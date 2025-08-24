<?php
/**
 * メインテンプレートファイル
 * 
 * @package NekoFreaksUniv
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="container mx-auto px-4 py-8">
        <?php if ( have_posts() ) : ?>
            
            <?php if ( is_home() && ! is_front_page() ) : ?>
                <header class="page-header mb-8">
                    <h1 class="page-title text-3xl font-bold text-gray-800">
                        <?php single_post_title(); ?>
                    </h1>
                </header>
            <?php endif; ?>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('bg-white rounded-lg shadow-md overflow-hidden'); ?>>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="post-thumbnail">
                                <?php the_post_thumbnail('medium', ['class' => 'w-full h-48 object-cover']); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="p-6">
                            <header class="entry-header">
                                <?php
                                if ( is_singular() ) :
                                    the_title( '<h1 class="entry-title text-2xl font-bold mb-2">', '</h1>' );
                                else :
                                    the_title( '<h2 class="entry-title text-xl font-semibold mb-2"><a href="' . esc_url( get_permalink() ) . '" class="text-gray-800 hover:text-blue-600 transition-colors">', '</a></h2>' );
                                endif;
                                ?>
                            </header>
                            
                            <div class="entry-content text-gray-600">
                                <?php 
                                if ( is_singular() ) :
                                    the_content();
                                else :
                                    the_excerpt();
                                endif;
                                ?>
                            </div>
                            
                            <?php if ( ! is_singular() ) : ?>
                                <footer class="entry-footer mt-4">
                                    <a href="<?php the_permalink(); ?>" class="text-blue-600 hover:underline">
                                        続きを読む →
                                    </a>
                                </footer>
                            <?php endif; ?>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>
            
            <div class="pagination mt-8">
                <?php the_posts_pagination(); ?>
            </div>
            
        <?php else : ?>
            
            <div class="no-results bg-white rounded-lg shadow-md p-8 text-center">
                <h2 class="text-2xl font-bold mb-4">コンテンツが見つかりません</h2>
                <p class="text-gray-600">申し訳ございません。お探しのコンテンツは見つかりませんでした。</p>
            </div>
            
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>