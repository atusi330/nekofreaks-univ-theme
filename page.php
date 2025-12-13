<?php
/**
 * 固定ページテンプレート
 * 
 * @package NekoFreaksUniv
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="page-header bg-gradient-to-r from-blue-600 to-purple-600 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">
                    <?php the_title(); ?>
                </h1>
                <?php if ( has_excerpt() ): ?>
                    <p class="text-lg text-white/90"><?php the_excerpt(); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="container mx-auto px-4 py-8">
        <?php nfu_breadcrumb(); ?>
        
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- メインコンテンツ -->
            <div class="lg:col-span-3">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg shadow-md overflow-hidden'); ?>>
                        <div class="p-6">
                            <?php if ( has_post_thumbnail() ): ?>
                                <div class="mb-6">
                                    <?php the_post_thumbnail('large', array('class' => 'w-full h-64 object-cover rounded-lg')); ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="prose episode-content max-w-none">
                                <?php the_content(); ?>
                            </div>
                            
                            <?php
                            wp_link_pages( array(
                                'before' => '<div class="page-links mt-6 p-4 bg-gray-50 rounded-lg">',
                                'after'  => '</div>',
                                'link_before' => '<span class="inline-block px-3 py-1 bg-blue-600 text-white rounded mr-2 hover:bg-blue-700 transition-colors">',
                                'link_after' => '</span>',
                            ) );
                            ?>
                        </div>
                    </article>
                    
                    <?php
                    // コメントが有効な場合は表示
                    if ( comments_open() || get_comments_number() ) :
                        echo '<div class="mt-8 bg-white rounded-lg shadow-md p-6">';
                        comments_template();
                        echo '</div>';
                    endif;
                    ?>
                    
                <?php endwhile; ?>
            </div>
            
            <!-- サイドバー -->
            <div class="space-y-6">
                <!-- 関連リンク -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-gray-800 mb-4">
                        <i class="fas fa-graduation-cap text-blue-600 mr-2"></i>
                        大学について
                    </h3>
                    <div class="space-y-3 text-sm">
                        <a href="<?php echo home_url('/about/'); ?>" class="block text-blue-600 hover:text-blue-800 hover:underline">
                            ネコフリークス大学とは
                        </a>
                        <a href="<?php echo home_url('/about/professors/'); ?>" class="block text-blue-600 hover:text-blue-800 hover:underline">
                            講師紹介
                        </a>
                        <a href="<?php echo home_url('/about/policy/'); ?>" class="block text-blue-600 hover:text-blue-800 hover:underline">
                            AI活用ポリシー
                        </a>
                    </div>
                </div>
                
                <!-- 最新の講座 -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-gray-800 mb-4">
                        <i class="fas fa-book-open text-purple-600 mr-2"></i>
                        最新の講座
                    </h3>
                    <?php
                    $latest_lectures = get_posts(array(
                        'post_type' => 'lectures',
                        'posts_per_page' => 3,
                        'post_status' => 'publish'
                    ));
                    
                    if ($latest_lectures): ?>
                        <div class="space-y-3">
                            <?php foreach ($latest_lectures as $lecture): ?>
                                <div class="border-b border-gray-200 pb-2 last:border-0">
                                    <a href="<?php echo get_permalink($lecture->ID); ?>" class="text-blue-600 hover:text-blue-800 hover:underline block font-medium">
                                        <?php echo esc_html($lecture->post_title); ?>
                                    </a>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <?php echo get_the_date('Y年n月j日', $lecture->ID); ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="mt-4">
                            <a href="<?php echo home_url('/lectures/'); ?>" class="block text-center bg-purple-600 text-white py-2 px-4 rounded hover:bg-purple-700 transition-colors text-sm">
                                講座一覧を見る
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- 豆知識バンク -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-gray-800 mb-4">
                        <i class="fas fa-lightbulb text-yellow-600 mr-2"></i>
                        豆知識バンク
                    </h3>
                    <?php
                    $tips = get_posts(array(
                        'post_type' => 'tips',
                        'posts_per_page' => 3,
                        'post_status' => 'publish'
                    ));
                    
                    if ($tips): ?>
                        <div class="space-y-2">
                            <?php foreach ($tips as $tip): ?>
                                <a href="<?php echo get_permalink($tip->ID); ?>" class="block text-sm text-blue-600 hover:text-blue-800 hover:underline">
                                    <i class="fas fa-paw text-yellow-500 mr-1"></i>
                                    <?php echo esc_html($tip->post_title); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                        <div class="mt-4">
                            <a href="<?php echo home_url('/tips/'); ?>" class="block text-center bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600 transition-colors text-sm">
                                豆知識を見る
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- ナビゲーション -->
                <div class="bg-gradient-to-r from-yellow-50 to-pink-50 rounded-lg p-6 border border-yellow-200">
                    <h3 class="font-bold text-gray-800 mb-3">
                        <i class="fas fa-compass text-orange-600 mr-2"></i>
                        サイトナビ
                    </h3>
                    <div class="grid grid-cols-1 gap-2 text-sm">
                        <a href="<?php echo home_url('/lectures/'); ?>" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                            <i class="fas fa-book mr-2"></i>講座一覧
                        </a>
                        <a href="<?php echo home_url('/papers/'); ?>" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                            <i class="fas fa-file-alt mr-2"></i>論文アーカイブ
                        </a>
                        <a href="<?php echo home_url('/bookmarks/'); ?>" class="text-purple-600 hover:text-purple-800 hover:underline flex items-center">
                            <i class="fas fa-heart mr-2"></i>お気に入り
                        </a>
                        <a href="<?php echo home_url('/goods/'); ?>" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center">
                            <i class="fas fa-shopping-bag mr-2"></i>おすすめの商品
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>