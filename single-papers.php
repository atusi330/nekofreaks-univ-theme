<?php
/**
 * 論文詳細ページテンプレート
 * 
 * @package NekoFreaksUniv
 */

get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post();
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
    $category_slug = ($categories && !is_wp_error($categories)) ? $categories[0]->slug : '';
    
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
?>

<article class="paper-single">
    <!-- ヘッダーセクション -->
    <section class="paper-header bg-gradient-to-b from-blue-600 to-blue-800 text-white py-16">
        <div class="container mx-auto px-4 max-w-4xl">
            <!-- パンくずリスト -->
            <nav class="breadcrumb text-sm text-white/60 mb-6">
                <a href="<?php echo home_url('/'); ?>" class="hover:text-white transition-colors">ホーム</a> &gt;
                <a href="<?php echo home_url('/papers/'); ?>" class="hover:text-white transition-colors">論文要約</a> &gt;
                <span class="text-white"><?php the_title(); ?></span>
            </nav>

            <!-- 論文基本情報 -->
            <div class="paper-info">
                <div class="paper-badges mb-4 flex flex-wrap gap-2">
                    <?php if ($category_name) : ?>
                        <span class="category-badge bg-white/20 text-white px-4 py-2 rounded-full text-sm">
                            <?php echo esc_html($category_name); ?>
                        </span>
                    <?php endif; ?>
                    <?php if ($difficulty_label) : ?>
                        <span class="difficulty-badge bg-yellow-500/20 text-yellow-100 px-4 py-2 rounded-full text-sm">
                            <?php echo esc_html($difficulty_label); ?>
                        </span>
                    <?php endif; ?>
                </div>

                <h1 class="text-3xl md:text-4xl font-bold mb-6">
                    <?php the_title(); ?>
                </h1>

                <?php if ($original_title) : ?>
                    <!-- 原題 -->
                    <p class="original-title text-lg text-white/80 italic mb-6">
                        "<?php echo esc_html($original_title); ?>"
                    </p>
                <?php endif; ?>

                <!-- メタ情報 -->
                <div class="paper-meta grid grid-cols-1 md:grid-cols-2 gap-4 text-white/90">
                    <?php if ($authors) : ?>
                        <div><strong>著者:</strong> <?php echo esc_html($authors); ?></div>
                    <?php endif; ?>
                    <?php if ($published_year) : ?>
                        <div><strong>発表年:</strong> <?php echo esc_html($published_year); ?>年</div>
                    <?php endif; ?>
                    <?php if ($journal) : ?>
                        <div><strong>掲載誌:</strong> <?php echo esc_html($journal); ?></div>
                    <?php endif; ?>
                    <?php if ($doi_link) : ?>
                        <div>
                            <strong>DOI:</strong>
                            <a href="<?php echo esc_url($doi_link); ?>" 
                               class="underline hover:text-white transition-colors"
                               target="_blank" rel="noopener">
                                <?php echo esc_html(parse_url($doi_link, PHP_URL_PATH)); ?> →
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- アイキャッチ画像（ある場合） -->
    <?php if (has_post_thumbnail()) : ?>
        <section class="paper-featured-image -mt-8 mb-12">
            <div class="container mx-auto px-4 max-w-4xl">
                <div class="rounded-lg overflow-hidden shadow-xl">
                    <?php the_post_thumbnail('large', ['class' => 'w-full h-auto']); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- 要点サマリー -->
    <?php if ($summary_points) : ?>
        <section class="paper-summary bg-yellow-50 py-8 mb-12">
            <div class="container mx-auto px-4 max-w-4xl">
                <h2 class="text-2xl font-bold mb-6 flex items-center">📌 研究の要点</h2>

                <div class="summary-points grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php
                    $points = array_filter(array_map('trim', explode("\n", $summary_points)));
                    foreach ($points as $index => $point) {
                        if ($point) :
                    ?>
                        <div class="point-card bg-white p-6 rounded-lg shadow">
                            <div class="point-number text-3xl font-bold text-blue-600 mb-2">
                                <?php echo str_pad($index + 1, 2, '0', STR_PAD_LEFT); ?>
                            </div>
                            <p class="text-gray-700">
                                <?php echo nl2br(esc_html($point)); ?>
                            </p>
                        </div>
                    <?php
                        endif;
                    }
                    ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- 詳細解説 -->
    <section class="paper-detail mb-12">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="prose prose-lg max-w-none">
                <?php the_content(); ?>
            </div>
        </div>
    </section>

    <!-- 関連コンテンツ -->
    <section class="related-content bg-gray-50 py-12">
        <div class="container mx-auto px-4 max-w-4xl">
            <?php
            // 関連講座を検索
            $related_lecture_query = new WP_Query(array(
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

            if ($related_lecture_query->have_posts()) :
                while ($related_lecture_query->have_posts()) : $related_lecture_query->the_post();
                    $professor = nfu_get_field('main_professor');
                    $total_episodes = nfu_get_field('total_episodes') ?: 5;
                    $difficulty = get_the_terms(get_the_ID(), 'difficulty');
                    $difficulty_label = $difficulty && !is_wp_error($difficulty) ? $difficulty[0]->name : '初級';
            ?>
                <!-- 関連講座 -->
                <div class="related-lecture mb-8">
                    <h3 class="text-2xl font-bold mb-6"><i class="fas fa-book mr-2"></i>この論文をベースにした講座</h3>

                    <div class="lecture-link-card bg-white p-6 rounded-lg shadow-lg border-l-4 border-blue-600">
                        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                            <div class="flex-1">
                                <h4 class="text-xl font-bold mb-2"><?php the_title(); ?></h4>
                                <p class="text-gray-600 mb-2">
                                    <?php echo nfu_get_professor_name($professor); ?>が、<?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                                </p>
                                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                    <span><i class="fas fa-graduation-cap mr-1"></i>全<?php echo $total_episodes; ?>回</span>
                                    <span><i class="fas fa-user mr-1"></i><?php echo nfu_get_professor_name($professor); ?></span>
                                    <span><i class="fas fa-chart-bar mr-1"></i><?php echo $difficulty_label; ?></span>
                                </div>
                            </div>
                            <a href="<?php the_permalink(); ?>" 
                               class="bg-blue-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-blue-700 transition-colors whitespace-nowrap">
                                講座を見る
                            </a>
                        </div>
                    </div>
                </div>
            <?php
                endwhile;
                wp_reset_postdata();
            endif;
            ?>

            <!-- 関連論文 -->
            <?php
            $related_papers_args = array(
                'post_type' => 'papers',
                'posts_per_page' => 4,
                'post__not_in' => array(get_the_ID()),
                'orderby' => 'rand'
            );

            // 同じカテゴリの論文を優先
            if ($category_slug) {
                $related_papers_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'theme_category',
                        'field' => 'slug',
                        'terms' => $category_slug,
                    ),
                );
            }

            $related_papers_query = new WP_Query($related_papers_args);

            if ($related_papers_query->have_posts()) :
            ?>
                <div class="related-papers">
                    <h3 class="text-2xl font-bold mb-6"><i class="fas fa-file-alt mr-2"></i>関連する論文</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php while ($related_papers_query->have_posts()) : $related_papers_query->the_post();
                            $rel_year = nfu_get_field('published_year');
                        ?>
                            <a href="<?php the_permalink(); ?>" 
                               class="related-paper-card block bg-white p-4 rounded-lg shadow hover:shadow-lg transition-shadow">
                                <?php if ($rel_year) : ?>
                                    <span class="text-sm text-gray-500"><?php echo esc_html($rel_year); ?>年</span>
                                <?php endif; ?>
                                <h4 class="font-bold mt-1 line-clamp-2">
                                    <?php the_title(); ?>
                                </h4>
                                <p class="text-sm text-gray-600 mt-2 line-clamp-2">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                </p>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php wp_reset_postdata(); ?>
            <?php endif; ?>
        </div>
    </section>

    <!-- 引用情報 -->
    <section class="citation-info py-8 border-t border-gray-200">
        <div class="container mx-auto px-4 max-w-4xl">
            <h3 class="text-lg font-bold mb-4">引用情報</h3>
            <div class="bg-gray-100 p-4 rounded-lg font-mono text-sm overflow-x-auto">
                <p>
                    <?php
                    if ($authors && $published_year && $original_title && $journal) {
                        echo esc_html($authors) . ' (' . esc_html($published_year) . '). ' . esc_html($original_title) . '. ' . esc_html($journal) . '.';
                        if ($doi_link) {
                            echo ' ' . esc_html($doi_link);
                        }
                    } else {
                        echo '引用情報が不完全です。詳細は原論文をご確認ください。';
                    }
                    ?>
                </p>
            </div>
            <p class="text-sm text-gray-600 mt-2">
                ※ 本記事は上記論文の内容を要約・解説したものです。詳細は原論文をご参照ください。
            </p>
        </div>
    </section>

    <!-- 前後の論文ナビゲーション -->
    <section class="paper-navigation bg-white py-8 border-t border-gray-200">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="flex justify-between items-center">
                <div class="prev-post">
                    <?php
                    $prev_post = get_previous_post();
                    if ($prev_post) :
                    ?>
                        <a href="<?php echo get_permalink($prev_post->ID); ?>" class="flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                            <span class="mr-2">←</span>
                            <div>
                                <div class="text-sm text-gray-500">前の論文</div>
                                <div class="font-semibold"><?php echo wp_trim_words($prev_post->post_title, 8); ?></div>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="back-to-archive">
                    <a href="<?php echo home_url('/papers/'); ?>" 
                       class="bg-gray-600 text-white px-4 py-2 rounded-full hover:bg-gray-700 transition-colors">
                        論文一覧に戻る
                    </a>
                </div>

                <div class="next-post">
                    <?php
                    $next_post = get_next_post();
                    if ($next_post) :
                    ?>
                        <a href="<?php echo get_permalink($next_post->ID); ?>" class="flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                            <div class="text-right">
                                <div class="text-sm text-gray-500">次の論文</div>
                                <div class="font-semibold"><?php echo wp_trim_words($next_post->post_title, 8); ?></div>
                            </div>
                            <span class="ml-2">→</span>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</article>

<style>
/* 論文詳細ページ用カスタムスタイル */
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.prose {
    color: #374151;
    line-height: 1.75;
}

.prose h2 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #1f2937;
}

.prose h3 {
    font-size: 1.25rem;
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    color: #1f2937;
}

.prose p {
    margin-bottom: 1.25rem;
}

.prose ul, .prose ol {
    margin: 1.25rem 0;
    padding-left: 1.5rem;
}

.prose li {
    margin-bottom: 0.5rem;
}

.prose blockquote {
    border-left: 4px solid #e5e7eb;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #6b7280;
}

.prose figure {
    margin: 2rem 0;
}

.prose figcaption {
    text-align: center;
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 0.5rem;
}

.point-card {
    transition: transform 0.2s ease;
}

.point-card:hover {
    transform: translateY(-2px);
}

.related-paper-card:hover {
    transform: translateY(-2px);
}

.paper-navigation a {
    transition: all 0.3s ease;
}

.paper-navigation a:hover {
    transform: translateX(-2px);
}

.paper-navigation .next-post a:hover {
    transform: translateX(2px);
}
</style>

<?php endwhile; endif; ?>

<?php get_footer(); ?>