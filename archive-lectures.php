<?php
/**
 * 講座一覧ページテンプレート
 * 
 * @package NekoFreaksUniv
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="page-header bg-gradient-to-r from-blue-600 to-purple-600 text-white py-12">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold text-center">講座一覧</h1>
            <p class="text-center mt-4 text-lg">猫の論文をベースにした、楽しく学べる講座をご用意しています</p>
        </div>
    </div>
    
    <div class="container mx-auto px-4 py-8">
        <?php nfu_breadcrumb(); ?>
        
        <!-- フィルターセクション -->
        <div class="filter-section bg-white rounded-lg shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold mb-4">講座を絞り込む</h2>
            
            <form id="lecture-filter-form" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- テーマフィルター -->
                <div class="filter-group">
                    <label for="filter-theme" class="block text-sm font-medium text-gray-700 mb-2">
                        テーマで絞り込む
                    </label>
                    <select id="filter-theme" name="theme" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="">すべてのテーマ</option>
                        <?php
                        $themes = get_terms( array(
                            'taxonomy' => 'theme_category',
                            'hide_empty' => true,
                        ) );
                        foreach ( $themes as $theme ) : ?>
                            <option value="<?php echo esc_attr( $theme->slug ); ?>">
                                <?php echo esc_html( $theme->name ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- 難易度フィルター -->
                <div class="filter-group">
                    <label for="filter-difficulty" class="block text-sm font-medium text-gray-700 mb-2">
                        難易度で絞り込む
                    </label>
                    <select id="filter-difficulty" name="difficulty" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="">すべての難易度</option>
                        <option value="beginner">初級</option>
                        <option value="intermediate">中級</option>
                        <option value="advanced">上級</option>
                    </select>
                </div>
                
                <!-- ソート -->
                <div class="filter-group">
                    <label for="sort-lectures" class="block text-sm font-medium text-gray-700 mb-2">
                        並び替え
                    </label>
                    <select id="sort-lectures" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="date">新着順</option>
                        <option value="title">タイトル順</option>
                        <option value="progress">進捗順</option>
                    </select>
                </div>
            </form>
            
            <!-- 講師ボタン（ビジュアル選択） -->
            <div class="professor-buttons mt-6">
                <p class="text-sm font-medium text-gray-700 mb-3">講師をクリックして選択：</p>
                <div class="flex flex-wrap gap-2">
                    <button class="professor-filter-button professor-maron active px-4 py-2 rounded-lg transition-all shadow-sm hover:shadow-md" data-professor="maron">
                        <span class="mr-1"><i class="fas fa-paw"></i></span> マロン学長（全て表示）
                    </button>
                    <button class="professor-filter-button professor-ichi px-4 py-2 rounded-lg transition-all shadow-sm hover:shadow-md" data-professor="ichi">
                        <span class="mr-1"><i class="fas fa-paw"></i></span> いち教授
                    </button>
                    <button class="professor-filter-button professor-hachi px-4 py-2 rounded-lg transition-all shadow-sm hover:shadow-md" data-professor="hachi">
                        <span class="mr-1"><i class="fas fa-paw"></i></span> はち助教授
                    </button>
                    <button class="professor-filter-button professor-jiji px-4 py-2 rounded-lg transition-all shadow-sm hover:shadow-md" data-professor="jiji">
                        <span class="mr-1"><i class="fas fa-paw"></i></span> ジジ助手
                    </button>
                    <button class="professor-filter-button professor-daifuku px-4 py-2 rounded-lg transition-all shadow-sm hover:shadow-md" data-professor="daifuku">
                        <span class="mr-1"><i class="fas fa-paw"></i></span> 大福先代学長
                    </button>
                </div>
            </div>
            
            <div class="flex justify-end mt-4">
                <button id="reset-filters" class="text-sm text-blue-600 hover:underline">
                    フィルターをリセット
                </button>
            </div>
        </div>
        
        <!-- 結果数表示 -->
        <div id="result-count" class="text-gray-600 mb-4">
            <?php echo $wp_query->found_posts; ?>件の講座が見つかりました
        </div>
        
        <!-- 講座グリッド -->
        <div id="lecture-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if ( have_posts() ) : ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/content', 'lecture-card' ); ?>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-600">講座が見つかりませんでした。</p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- ページネーション -->
        <?php if ( $wp_query->max_num_pages > 1 ) : ?>
            <div class="pagination mt-8">
                <?php
                the_posts_pagination( array(
                    'mid_size' => 2,
                    'prev_text' => '← 前へ',
                    'next_text' => '次へ →',
                    'class' => 'flex justify-center space-x-2',
                ) );
                ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<script>
jQuery(document).ready(function($) {
    // 講座フィルター用のスクリプトを読み込み
    if (typeof nfu_ajax !== 'undefined') {
        // lecture-filter.jsの機能がここで動作
    }
});
</script>

<?php
wp_enqueue_script( 'nfu-lecture-filter', NFU_THEME_URI . '/assets/js/lecture-filter.js', array('jquery'), NFU_THEME_VERSION, true );
get_footer(); ?>