<?php
/**
 * 論文アーカイブページテンプレート
 * 
 * @package NekoFreaksUniv
 */

get_header(); ?>

<div class="papers-archive">
    <!-- ページヘッダー -->
    <section class="page-header bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold text-center mb-4"><i class="fas fa-file-alt mr-3"></i>論文要約アーカイブ</h1>
            <p class="text-xl text-center text-white/80">
                最新の猫研究論文を、AIで翻訳して読んで、勉強したことをシェアしています
            </p>
        </div>
    </section>

    <!-- フィルター・検索セクション -->
    <section class="filter-section bg-white py-8 shadow-sm sticky top-0 z-10">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap gap-4 items-center justify-between">
                <!-- 検索ボックス -->
                <div class="search-box flex-1 max-w-md">
                    <input
                        type="text"
                        id="paper-search"
                        placeholder="論文タイトル、著者、キーワードで検索"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        value="<?php echo isset($_GET['search']) ? esc_attr($_GET['search']) : ''; ?>"
                    />
                </div>

                <!-- フィルター -->
                <div class="filters flex flex-wrap gap-4">
                    <!-- 年代フィルター -->
                    <select id="year-filter" class="filter-select px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">発表年</option>
                        <?php
                        $current_year = date('Y');
                        for ($year = $current_year; $year >= $current_year - 10; $year--) {
                            $selected = (isset($_GET['year']) && $_GET['year'] == $year) ? 'selected' : '';
                            echo "<option value='{$year}' {$selected}>{$year}年</option>";
                        }
                        ?>
                        <option value="older" <?php echo (isset($_GET['year']) && $_GET['year'] == 'older') ? 'selected' : ''; ?>>
                            <?php echo $current_year - 10; ?>年以前
                        </option>
                    </select>

                    <!-- カテゴリフィルター -->
                    <select id="category-filter" class="filter-select px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">カテゴリ</option>
                        <?php
                        $categories = get_terms(array(
                            'taxonomy' => 'theme_category',
                            'hide_empty' => false,
                        ));
                        foreach ($categories as $category) {
                            $selected = (isset($_GET['category']) && $_GET['category'] == $category->slug) ? 'selected' : '';
                            echo "<option value='{$category->slug}' {$selected}>{$category->name}</option>";
                        }
                        ?>
                    </select>

                    <!-- ソート -->
                    <select id="sort-filter" class="sort-select px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="newest" <?php echo (!isset($_GET['sort']) || $_GET['sort'] == 'newest') ? 'selected' : ''; ?>>
                            新しい順
                        </option>
                        <option value="oldest" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'oldest') ? 'selected' : ''; ?>>
                            古い順
                        </option>
                        <option value="title" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'title') ? 'selected' : ''; ?>>
                            タイトル順
                        </option>
                    </select>
                </div>
            </div>
        </div>
    </section>

    <!-- 論文カードグリッド -->
    <section class="papers-grid-section py-12">
        <div class="container mx-auto px-4">
            <!-- ローディング表示 -->
            <div id="papers-loading" class="text-center py-8 hidden">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                <p class="mt-2 text-gray-600">検索中...</p>
            </div>

            <!-- 結果表示 -->
            <div id="papers-results">
                <?php
                // クエリパラメータを取得
                $search_query = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
                $year_filter = isset($_GET['year']) ? sanitize_text_field($_GET['year']) : '';
                $category_filter = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
                $sort_filter = isset($_GET['sort']) ? sanitize_text_field($_GET['sort']) : 'newest';

                // WP_Query引数を構築
                $args = array(
                    'post_type' => 'papers',
                    'posts_per_page' => 12,
                    'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
                    'post_status' => 'publish',
                );

                // 検索クエリ
                if (!empty($search_query)) {
                    $args['s'] = $search_query;
                }

                // 年度フィルター
                if (!empty($year_filter)) {
                    if ($year_filter === 'older') {
                        $args['meta_query'][] = array(
                            'key' => 'published_year',
                            'value' => date('Y') - 10,
                            'compare' => '<',
                            'type' => 'NUMERIC'
                        );
                    } else {
                        $args['meta_query'][] = array(
                            'key' => 'published_year',
                            'value' => $year_filter,
                            'compare' => '=',
                            'type' => 'NUMERIC'
                        );
                    }
                }

                // カテゴリフィルター
                if (!empty($category_filter)) {
                    $args['tax_query'] = array(
                        array(
                            'taxonomy' => 'theme_category',
                            'field' => 'slug',
                            'terms' => $category_filter,
                        ),
                    );
                }

                // ソート
                switch ($sort_filter) {
                    case 'oldest':
                        $args['orderby'] = 'date';
                        $args['order'] = 'ASC';
                        break;
                    case 'title':
                        $args['orderby'] = 'title';
                        $args['order'] = 'ASC';
                        break;
                    default: // newest
                        $args['orderby'] = 'date';
                        $args['order'] = 'DESC';
                        break;
                }

                $papers_query = new WP_Query($args);
                ?>

                <p class="result-count text-gray-600 mb-6">
                    <?php echo $papers_query->found_posts; ?>件の論文が見つかりました
                </p>

                <?php if ($papers_query->have_posts()) : ?>
                    <!-- グリッドレイアウト -->
                    <div class="papers-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="papers-container">
                        <?php while ($papers_query->have_posts()) : $papers_query->the_post();
                            // カスタムフィールド取得
                            $original_title = nfu_get_field('original_title');
                            $authors = nfu_get_field('authors');
                            $published_year = nfu_get_field('published_year');
                            $journal = nfu_get_field('journal');
                            $doi_link = nfu_get_field('doi_link');
                            $summary_points = nfu_get_field('summary_points');
                            
                            // カテゴリ取得
                            $categories = get_the_terms(get_the_ID(), 'theme_category');
                            $category_name = ($categories && !is_wp_error($categories)) ? $categories[0]->name : '';
                            
                            // 難易度取得
                            $difficulty = get_the_terms(get_the_ID(), 'difficulty');
                            $difficulty_name = ($difficulty && !is_wp_error($difficulty)) ? $difficulty[0]->name : '';
                            $difficulty_label = '';
                            switch($difficulty_name) {
                                case 'beginner': $difficulty_label = '初級'; break;
                                case 'intermediate': $difficulty_label = '中級'; break;
                                case 'advanced': $difficulty_label = '上級'; break;
                                default: $difficulty_label = $difficulty_name; break;
                            }
                            
                            // 要約プレビュー作成
                            $summary_preview = '';
                            if ($summary_points) {
                                $points = array_filter(array_map('trim', explode("\n", $summary_points)));
                                if (!empty($points)) {
                                    $summary_preview = wp_trim_words($points[0], 20);
                                }
                            }
                            
                            // 関連講座チェック
                            $related_lecture = new WP_Query(array(
                                'post_type' => 'lectures',
                                'meta_query' => array(
                                    array(
                                        'key' => 'related_paper',
                                        'value' => get_the_ID(),
                                        'compare' => '='
                                    )
                                ),
                                'posts_per_page' => 1
                            ));
                            $has_related_lecture = $related_lecture->have_posts();
                            wp_reset_postdata();
                        ?>
                            <article class="paper-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                                <?php if (has_post_thumbnail()) : ?>
                                    <!-- アイキャッチ画像 -->
                                    <div class="paper-thumbnail h-48 bg-gray-200 relative overflow-hidden">
                                        <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover')); ?>
                                        <?php if ($published_year) : ?>
                                            <span class="year-badge absolute top-4 right-4 bg-blue-600 text-white px-3 py-1 rounded-full text-sm">
                                                <?php echo esc_html($published_year); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php else : ?>
                                    <!-- アイキャッチなしの場合のヘッダー -->
                                    <div class="paper-header-no-image bg-gradient-to-r from-blue-600 to-blue-800 p-6 text-white">
                                        <?php if ($published_year) : ?>
                                            <span class="year-badge bg-white/20 text-white px-3 py-1 rounded-full text-sm">
                                                <?php echo esc_html($published_year); ?>
                                            </span>
                                        <?php endif; ?>
                                        <div class="mt-4">
                                            <?php if ($category_name) : ?>
                                                <span class="category-tag text-sm text-white/80">
                                                    <?php echo esc_html($category_name); ?>
                                                </span>
                                            <?php endif; ?>
                                            <h3 class="paper-title text-xl font-bold mt-2 line-clamp-2">
                                                <?php the_title(); ?>
                                            </h3>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- 論文情報 -->
                                <div class="paper-content p-6">
                                    <?php if (has_post_thumbnail() && $category_name) : ?>
                                        <!-- カテゴリ（アイキャッチありの場合） -->
                                        <span class="category-tag text-sm text-blue-600 font-semibold">
                                            <?php echo esc_html($category_name); ?>
                                        </span>
                                    <?php endif; ?>

                                    <?php if (has_post_thumbnail()) : ?>
                                        <!-- タイトル（アイキャッチありの場合） -->
                                        <h3 class="paper-title text-xl font-bold mt-2 mb-3 line-clamp-2">
                                            <?php the_title(); ?>
                                        </h3>
                                    <?php endif; ?>

                                    <!-- メタ情報 -->
                                    <div class="paper-meta text-sm text-gray-600 mb-4">
                                        <?php if ($authors) : ?>
                                            <p class="authors line-clamp-1"><?php echo esc_html($authors); ?></p>
                                        <?php endif; ?>
                                        <?php if ($journal && $published_year) : ?>
                                            <p class="journal italic"><?php echo esc_html($journal); ?>, <?php echo esc_html($published_year); ?></p>
                                        <?php elseif ($journal) : ?>
                                            <p class="journal italic"><?php echo esc_html($journal); ?></p>
                                        <?php elseif ($published_year) : ?>
                                            <p class="journal italic"><?php echo esc_html($published_year); ?></p>
                                        <?php endif; ?>
                                        <?php if ($difficulty_label) : ?>
                                            <div class="difficulty-badge inline-block bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-medium mt-1">
                                                <?php echo esc_html($difficulty_label); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- 要点プレビュー -->
                                    <?php if ($summary_preview) : ?>
                                        <div class="summary-preview">
                                            <p class="text-sm text-gray-700 line-clamp-3">
                                                <?php echo esc_html($summary_preview); ?>
                                            </p>
                                        </div>
                                    <?php endif; ?>

                                    <!-- アクション -->
                                    <div class="paper-actions mt-4 flex justify-between items-center">
                                        <a href="<?php the_permalink(); ?>" class="text-blue-600 hover:underline font-semibold">
                                            詳細を読む →
                                        </a>
                                        <?php if ($has_related_lecture) : ?>
                                            <span class="related-lecture text-sm text-gray-500">
                                                <i class="fas fa-book mr-1"></i>関連講座あり
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </div>

                    <!-- ページネーション -->
                    <?php if ($papers_query->max_num_pages > 1) : ?>
                        <div class="pagination flex justify-center items-center gap-2 mt-12">
                            <?php
                            echo paginate_links(array(
                                'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                                'format' => '?paged=%#%',
                                'current' => max(1, get_query_var('paged')),
                                'total' => $papers_query->max_num_pages,
                                'prev_text' => '←',
                                'next_text' => '→',
                                'type' => 'list',
                                'end_size' => 1,
                                'mid_size' => 2,
                            ));
                            ?>
                        </div>
                    <?php endif; ?>

                <?php else : ?>
                    <div class="no-results text-center py-12">
                        <div class="text-6xl mb-4"><i class="fas fa-file-alt"></i></div>
                        <h3 class="text-2xl font-bold text-gray-700 mb-2">検索結果がありません</h3>
                        <p class="text-gray-600 mb-6">条件を変更して再度検索してください</p>
                        <button onclick="clearFilters()" class="bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition-colors">
                            フィルターをクリア
                        </button>
                    </div>
                <?php endif; ?>

                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
</div>

<style>
/* 論文アーカイブ用カスタムスタイル */
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.filter-section {
    backdrop-filter: blur(10px);
}

.paper-card:hover {
    transform: translateY(-4px);
}

.paper-thumbnail img {
    transition: transform 0.3s ease;
}

.paper-card:hover .paper-thumbnail img {
    transform: scale(1.05);
}

/* ページネーション */
.pagination ul {
    @apply flex justify-center items-center gap-2;
}

.pagination a,
.pagination span {
    @apply px-4 py-2 border border-gray-300 rounded hover:bg-gray-100 transition-colors;
}

.pagination .current {
    @apply bg-blue-600 text-white border-blue-600;
}
</style>

<script>
// 論文アーカイブフィルター機能
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('paper-search');
    const yearFilter = document.getElementById('year-filter');
    const categoryFilter = document.getElementById('category-filter');
    const sortFilter = document.getElementById('sort-filter');
    let searchTimeout;

    // 検索・フィルター変更時の処理
    function handleFilterChange() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            updateURL();
            // ページをリロード（実際のプロジェクトではAjaxで動的更新）
            window.location.reload();
        }, 500);
    }

    // URLパラメータ更新
    function updateURL() {
        const params = new URLSearchParams();
        
        if (searchInput.value) params.set('search', searchInput.value);
        if (yearFilter.value) params.set('year', yearFilter.value);
        if (categoryFilter.value) params.set('category', categoryFilter.value);
        if (sortFilter.value && sortFilter.value !== 'newest') params.set('sort', sortFilter.value);
        
        const newURL = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
        window.history.replaceState({}, '', newURL);
    }

    // イベントリスナー
    searchInput.addEventListener('input', handleFilterChange);
    yearFilter.addEventListener('change', handleFilterChange);
    categoryFilter.addEventListener('change', handleFilterChange);
    sortFilter.addEventListener('change', handleFilterChange);
});

// フィルタークリア機能
function clearFilters() {
    document.getElementById('paper-search').value = '';
    document.getElementById('year-filter').value = '';
    document.getElementById('category-filter').value = '';
    document.getElementById('sort-filter').value = 'newest';
    
    // URLからパラメータを削除してリロード
    window.location.href = window.location.pathname;
}
</script>

<?php get_footer(); ?>