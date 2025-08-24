<?php
/**
 * 論文カードテンプレートパーツ
 * 
 * アーカイブページや関連論文表示で使用する再利用可能な論文カード
 * 
 * @package NekoFreaksUniv
 */

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

// 引数の検証とデフォルト値設定（最初に実行）
$defaults = array(
    'size' => 'default',
    'show_excerpt' => true,
    'show_meta' => true,
    'hover_effect' => false,
    'paper_id' => get_the_ID()
);
$args = wp_parse_args($args, $defaults);

$card_size = $args['size'];
$show_excerpt = $args['show_excerpt'];
$show_meta = $args['show_meta'];
$paper_id = $args['paper_id'];

// 要約プレビュー作成
$summary_preview = '';
if ($summary_points) {
    $points = array_filter(array_map('trim', explode("\n", $summary_points)));
    if (!empty($points)) {
        $summary_preview = wp_trim_words($points[0], 20);
    }
}

// 関連講座チェック（キャッシュ対応）
$cache_key = 'related_lecture_' . $paper_id;
$has_related_lecture = wp_cache_get($cache_key);

if ($has_related_lecture === false) {
    $related_lecture = new WP_Query(array(
        'post_type' => 'lectures',
        'meta_query' => array(
            'relation' => 'OR',
            array(
                'key' => 'related_paper',
                'value' => $paper_id,
                'compare' => '='
            ),
            array(
                'key' => 'related_paper', 
                'value' => '"' . $paper_id . '"',
                'compare' => 'LIKE'
            )
        ),
        'posts_per_page' => 1,
        'fields' => 'ids' // パフォーマンス向上のためIDのみ取得
    ));
    
    $has_related_lecture = $related_lecture->have_posts();
    wp_cache_set($cache_key, $has_related_lecture, '', 3600); // 1時間キャッシュ
    wp_reset_postdata();
}

// 論文データの取得とエラーハンドリング
$paper_post = get_post($paper_id);

if (!$paper_post) {
    // 投稿が見つからない場合
    if (WP_DEBUG) {
        error_log("NFU Error: Paper not found. ID: {$paper_id}");
    }
    return;
}

if ($paper_post->post_type === 'papers') {
    $paper_url = home_url('papers/' . $paper_post->post_name . '/');
    $paper_title = $paper_post->post_title;
} elseif ($paper_post->post_status === 'publish') {
    // 他の投稿タイプの場合
    $paper_url = get_permalink($paper_id);
    $paper_title = $paper_post->post_title;
} else {
    // 非公開投稿の場合
    if (WP_DEBUG) {
        error_log("NFU Error: Paper not published. ID: {$paper_id}, Status: {$paper_post->post_status}");
    }
    return;
}

// デバッグ情報（開発環境のみ）
if (defined('WP_DEBUG') && WP_DEBUG && current_user_can('administrator')) {
    echo '<!-- Paper Card Debug: paper_id=' . $paper_id . ', post_type=' . $paper_post->post_type . ', paper_url=' . $paper_url . ' -->';
}
?>

<article class="paper-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 <?php echo $card_size === 'compact' ? 'h-auto' : ''; ?>">
    <?php if (has_post_thumbnail()) : ?>
        <!-- アイキャッチ画像 -->
        <div class="paper-thumbnail <?php echo $card_size === 'compact' ? 'h-32' : 'h-48'; ?> bg-gray-200 relative overflow-hidden">
            <?php 
            $thumbnail_size = $card_size === 'compact' ? 'thumbnail' : 'medium';
            the_post_thumbnail($thumbnail_size, array('class' => 'w-full h-full object-cover transition-transform duration-300 hover:scale-105')); 
            ?>
            <?php if ($published_year) : ?>
                <span class="year-badge absolute top-3 right-3 bg-blue-600 text-white px-2 py-1 rounded-full text-xs font-semibold">
                    <?php echo esc_html($published_year); ?>
                </span>
            <?php endif; ?>
        </div>
    <?php else : ?>
        <!-- アイキャッチなしの場合のヘッダー -->
        <div class="paper-header-no-image bg-gradient-to-r from-blue-600 to-blue-800 <?php echo $card_size === 'compact' ? 'p-4' : 'p-6'; ?> text-white">
            <?php if ($published_year) : ?>
                <span class="year-badge bg-white/20 text-white px-2 py-1 rounded-full text-xs">
                    <?php echo esc_html($published_year); ?>
                </span>
            <?php endif; ?>
            <div class="<?php echo $published_year ? 'mt-3' : ''; ?>">
                <?php if ($category_name) : ?>
                    <span class="category-tag text-xs text-white/80 font-medium">
                        <?php echo esc_html($category_name); ?>
                    </span>
                <?php endif; ?>
                <h3 class="paper-title <?php echo $card_size === 'compact' ? 'text-lg' : 'text-xl'; ?> font-bold mt-2 line-clamp-2">
                    <a href="<?php echo esc_url($paper_url); ?>" class="text-white hover:text-white/90 transition-colors">
                        <?php echo esc_html($paper_title); ?>
                    </a>
                </h3>
            </div>
        </div>
    <?php endif; ?>

    <!-- 論文情報 -->
    <div class="paper-content <?php echo $card_size === 'compact' ? 'p-4' : 'p-6'; ?>">
        <?php if (has_post_thumbnail()) : ?>
            <!-- アイキャッチありの場合のタイトル・カテゴリ -->
            <?php if ($category_name) : ?>
                <span class="category-tag text-sm text-blue-600 font-semibold">
                    <?php echo esc_html($category_name); ?>
                </span>
            <?php endif; ?>

            <h3 class="paper-title <?php echo $card_size === 'compact' ? 'text-lg' : 'text-xl'; ?> font-bold mt-2 mb-3 line-clamp-2">
                <a href="<?php echo esc_url($paper_url); ?>" class="text-gray-800 hover:text-blue-600 transition-colors">
                    <?php echo esc_html($paper_title); ?>
                </a>
            </h3>
        <?php endif; ?>

        <!-- メタ情報 -->
        <?php if ($show_meta && ($authors || $journal || $difficulty_label)) : ?>
            <div class="paper-meta text-sm text-gray-600 mb-3">
                <?php if ($authors) : ?>
                    <p class="authors line-clamp-1"><?php echo esc_html($authors); ?></p>
                <?php endif; ?>
                <?php if ($journal) : ?>
                    <p class="journal italic">
                        <?php echo esc_html($journal); ?><?php echo $published_year ? ', ' . esc_html($published_year) : ''; ?>
                    </p>
                <?php endif; ?>
                <?php if ($difficulty_label) : ?>
                    <div class="difficulty-badge inline-block bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-medium mt-1">
                        <?php echo esc_html($difficulty_label); ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- 要点プレビュー -->
        <?php if ($show_excerpt && $summary_preview) : ?>
            <div class="summary-preview mb-4">
                <p class="text-sm text-gray-700 <?php echo $card_size === 'compact' ? 'line-clamp-2' : 'line-clamp-3'; ?>">
                    <?php echo esc_html($summary_preview); ?>
                </p>
            </div>
        <?php elseif ($show_excerpt && !$summary_preview) : ?>
            <!-- 要約がない場合は本文の抜粋を表示 -->
            <div class="summary-preview mb-4">
                <p class="text-sm text-gray-700 <?php echo $card_size === 'compact' ? 'line-clamp-2' : 'line-clamp-3'; ?>">
                    <?php echo wp_trim_words(get_the_excerpt(), $card_size === 'compact' ? 15 : 25); ?>
                </p>
            </div>
        <?php endif; ?>

        <!-- アクション -->
        <div class="paper-actions flex justify-between items-center">
            <a href="<?php echo esc_url($paper_url); ?>" class="text-blue-600 hover:underline font-semibold <?php echo $card_size === 'compact' ? 'text-sm' : ''; ?> transition-colors">
                詳細を読む →
            </a>
            <?php if ($has_related_lecture) : ?>
                <span class="related-lecture text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                    <i class="fas fa-book mr-1"></i>関連講座
                </span>
            <?php endif; ?>
        </div>

        <!-- DOIリンク（compact版では非表示） -->
        <?php if ($card_size !== 'compact' && $doi_link) : ?>
            <div class="doi-link mt-3 pt-3 border-t border-gray-200">
                <a href="<?php echo esc_url($doi_link); ?>" 
                   target="_blank" rel="noopener"
                   class="text-xs text-gray-500 hover:text-blue-600 transition-colors">
                    <i class="fas fa-external-link-alt mr-1"></i>原論文を見る
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- ホバーエフェクト用オーバーレイ（オプション） -->
    <?php if ($args['hover_effect']) : ?>
        <div class="paper-overlay absolute inset-0 bg-blue-600/90 opacity-0 hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
            <div class="text-center text-white p-4">
                <h4 class="font-bold mb-2"><?php echo esc_html($paper_title); ?></h4>
                <a href="<?php echo esc_url($paper_url); ?>" class="bg-white text-blue-600 px-4 py-2 rounded-full font-semibold hover:bg-gray-100 transition-colors">
                    詳細を見る
                </a>
            </div>
        </div>
    <?php endif; ?>
</article>