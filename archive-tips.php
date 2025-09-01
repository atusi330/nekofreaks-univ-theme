<?php
/**
 * 豆知識アーカイブページテンプレート
 * 
 * @package NekoFreaksUniv
 */

get_header(); ?>

<main class="tips-archive-page">
    <!-- ヘッダーセクション -->
    <div class="page-header bg-gradient-to-r from-yellow-500 to-orange-500 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-5xl font-bold mb-6">
                    <i class="fas fa-lightbulb mr-4"></i>
                    豆知識バンク
                </h1>
                <p class="text-xl text-white/90 max-w-3xl mx-auto">
                    猫に関する豆知識を、親しみやすいチャット形式でお届けします。
                    講座や講座回と連携して、より深い理解をサポートします。
                </p>
            </div>
        </div>
    </div>
    
    <div class="container mx-auto px-4 py-12">
        <?php nfu_breadcrumb(); ?>
        
        <!-- フィルター・検索 -->
        <div class="mb-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- カテゴリフィルター -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">カテゴリ</label>
                        <select id="category-filter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <option value="">すべてのカテゴリ</option>
                            <option value="health">健康</option>
                            <option value="behavior">行動</option>
                            <option value="care">ケア</option>
                            <option value="trivia">トリビア</option>
                        </select>
                    </div>
                    
                    <!-- 難易度フィルター -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">難易度</label>
                        <select id="difficulty-filter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                            <option value="">すべての難易度</option>
                            <option value="beginner">初級</option>
                            <option value="intermediate">中級</option>
                            <option value="advanced">上級</option>
                        </select>
                    </div>
                    
                    <!-- 検索 -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">検索</label>
                        <input type="text" id="search-input" placeholder="豆知識を検索..." 
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    </div>
                </div>
            </div>
        </div>
        
        <!-- 統計情報 -->
        <div class="mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-lg shadow-md p-4 text-center">
                    <div class="text-2xl font-bold text-yellow-600 mb-1">
                        <?php echo $wp_query->found_posts; ?>
                    </div>
                    <div class="text-sm text-gray-600">豆知識</div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-4 text-center">
                    <div class="text-2xl font-bold text-green-600 mb-1">
                        <?php 
                        $health_count = new WP_Query(array(
                            'post_type' => 'tips',
                            'meta_query' => array(
                                array('key' => 'tip_category', 'value' => 'health')
                            ),
                            'posts_per_page' => -1
                        ));
                        echo $health_count->found_posts;
                        ?>
                    </div>
                    <div class="text-sm text-gray-600">健康</div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-4 text-center">
                    <div class="text-2xl font-bold text-blue-600 mb-1">
                        <?php 
                        $behavior_count = new WP_Query(array(
                            'post_type' => 'tips',
                            'meta_query' => array(
                                array('key' => 'tip_category', 'value' => 'behavior')
                            ),
                            'posts_per_page' => -1
                        ));
                        echo $behavior_count->found_posts;
                        ?>
                    </div>
                    <div class="text-sm text-gray-600">行動</div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md p-4 text-center">
                    <div class="text-2xl font-bold text-purple-600 mb-1">
                        <?php 
                        $care_count = new WP_Query(array(
                            'post_type' => 'tips',
                            'meta_query' => array(
                                array('key' => 'tip_category', 'value' => 'care')
                            ),
                            'posts_per_page' => -1
                        ));
                        echo $care_count->found_posts;
                        ?>
                    </div>
                    <div class="text-sm text-gray-600">ケア</div>
                </div>
            </div>
        </div>
        
        <!-- 豆知識一覧 -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="tips-grid">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
                $tip_category = nfu_get_field('tip_category');
                $tip_difficulty = nfu_get_field('tip_difficulty');
                $related_lecture = nfu_get_field('related_lecture');
                $related_episode = nfu_get_field('related_episode');
                $tip_chat_data = nfu_get_field('tip_chat_data');
                
                // カテゴリ名を取得
                $category_names = array(
                    'health' => '健康',
                    'behavior' => '行動',
                    'care' => 'ケア',
                    'trivia' => 'トリビア',
                );
                
                // 難易度名を取得
                $difficulty_names = array(
                    'beginner' => '初級',
                    'intermediate' => '中級',
                    'advanced' => '上級',
                );
                
                // チャットデータから最初のメッセージを取得
                $first_message = '';
                if ($tip_chat_data) {
                    $parsed_data = json_decode($tip_chat_data, true);
                    if ($parsed_data && isset($parsed_data['messages'][0]['message'])) {
                        $first_message = $parsed_data['messages'][0]['message'];
                    }
                }
            ?>
                <article class="tip-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow transform hover:-translate-y-1">
                    <!-- カードヘッダー -->
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <?php if ($tip_category) : ?>
                                <span class="inline-block bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">
                                    <?php echo esc_html($category_names[$tip_category]); ?>
                                </span>
                            <?php endif; ?>
                            <?php if ($tip_difficulty) : ?>
                                <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold">
                                    <?php echo esc_html($difficulty_names[$tip_difficulty]); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <h3 class="text-lg font-bold text-gray-800 mb-3">
                            <a href="<?php the_permalink(); ?>" class="hover:text-yellow-600 transition-colors">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        
                        <?php if ($first_message) : ?>
                            <div class="mb-4">
                                <div class="flex items-start space-x-2">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center text-white text-sm font-bold flex-shrink-0">
                                        🐱
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3 flex-1">
                                        <p class="text-sm text-gray-600 line-clamp-3">
                                            <?php echo esc_html(wp_trim_words($first_message, 20, '...')); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php else : ?>
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                <?php echo get_the_excerpt(); ?>
                            </p>
                        <?php endif; ?>
                        
                        <!-- 関連リンク -->
                        <?php if ($related_lecture || $related_episode) : ?>
                            <div class="mb-4">
                                <div class="text-xs text-gray-500 mb-2">関連コンテンツ:</div>
                                <div class="flex flex-wrap gap-2">
                                    <?php if ($related_lecture) : ?>
                                        <a href="<?php echo get_permalink($related_lecture->ID); ?>" 
                                           class="inline-flex items-center bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs hover:bg-purple-200 transition-colors">
                                            <i class="fas fa-book mr-1"></i>
                                            <?php echo esc_html(wp_trim_words($related_lecture->post_title, 3, '...')); ?>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if ($related_episode) : ?>
                                        <a href="<?php echo get_permalink($related_episode->ID); ?>" 
                                           class="inline-flex items-center bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs hover:bg-blue-200 transition-colors">
                                            <i class="fas fa-play mr-1"></i>
                                            <?php echo esc_html(wp_trim_words($related_episode->post_title, 3, '...')); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- カードフッター -->
                        <div class="flex items-center justify-between">
                            <div class="text-xs text-gray-500">
                                <i class="fas fa-calendar mr-1"></i>
                                <?php echo get_the_date('Y年n月j日'); ?>
                            </div>
                            <a href="<?php the_permalink(); ?>" 
                               class="inline-flex items-center bg-yellow-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-yellow-700 transition-colors">
                                <i class="fas fa-lightbulb mr-2"></i>
                                詳細を見る
                            </a>
                        </div>
                    </div>
                </article>
            <?php endwhile; endif; ?>
        </div>
        
        <!-- ページネーション -->
        <?php if ( get_next_posts_link() || get_previous_posts_link() ) : ?>
            <div class="mt-12">
                <div class="flex justify-center space-x-4">
                    <?php if ( get_previous_posts_link() ) : ?>
                        <a href="<?php echo get_previous_posts_page_link(); ?>" 
                           class="inline-flex items-center bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors">
                            <i class="fas fa-chevron-left mr-2"></i>
                            前のページ
                        </a>
                    <?php endif; ?>
                    
                    <?php if ( get_next_posts_link() ) : ?>
                        <a href="<?php echo get_next_posts_page_link(); ?>" 
                           class="inline-flex items-center bg-yellow-600 text-white px-6 py-3 rounded-lg hover:bg-yellow-700 transition-colors">
                            次のページ
                            <i class="fas fa-chevron-right ml-2"></i>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- 豆知識が見つからない場合 -->
        <?php if ( !have_posts() ) : ?>
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-lightbulb text-4xl text-yellow-600"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">豆知識が見つかりません</h3>
                <p class="text-gray-600 mb-8">
                    検索条件を変更して、もう一度お試しください。
                </p>
                <a href="<?php echo get_post_type_archive_link('tips'); ?>" 
                   class="inline-flex items-center bg-yellow-600 text-white px-6 py-3 rounded-lg hover:bg-yellow-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    すべての豆知識を見る
                </a>
            </div>
        <?php endif; ?>
    </div>
</main>

<style>
.tips-archive-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.tip-card {
    transition: all 0.3s ease;
}

.tip-card:hover {
    transform: translateY(-4px);
}
</style>

<script>
jQuery(document).ready(function($) {
    // フィルター機能
    function filterTips() {
        var category = $('#category-filter').val();
        var difficulty = $('#difficulty-filter').val();
        var search = $('#search-input').val().toLowerCase();
        
        $('.tip-card').each(function() {
            var card = $(this);
            var cardCategory = card.find('.bg-yellow-100').text().trim();
            var cardDifficulty = card.find('.bg-blue-100').text().trim();
            var cardTitle = card.find('h3 a').text().toLowerCase();
            var cardContent = card.find('p').text().toLowerCase();
            
            var showCard = true;
            
            // カテゴリフィルター
            if (category && cardCategory !== category) {
                showCard = false;
            }
            
            // 難易度フィルター
            if (difficulty && cardDifficulty !== difficulty) {
                showCard = false;
            }
            
            // 検索フィルター
            if (search && !cardTitle.includes(search) && !cardContent.includes(search)) {
                showCard = false;
            }
            
            if (showCard) {
                card.show();
            } else {
                card.hide();
            }
        });
        
        // 結果が0件の場合のメッセージ表示
        var visibleCards = $('.tip-card:visible').length;
        if (visibleCards === 0) {
            if ($('#no-results').length === 0) {
                $('#tips-grid').after('<div id="no-results" class="text-center py-16"><p class="text-gray-600">条件に一致する豆知識が見つかりませんでした。</p></div>');
            }
        } else {
            $('#no-results').remove();
        }
    }
    
    // イベントリスナー
    $('#category-filter, #difficulty-filter').on('change', filterTips);
    $('#search-input').on('input', filterTips);
});
</script>

<?php get_footer(); ?>
