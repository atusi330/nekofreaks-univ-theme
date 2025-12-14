<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <?php wp_head(); ?>
</head>

<body <?php body_class('bg-gray-50'); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'コンテンツへスキップ', 'nekofreaks-univ' ); ?></a>
    
    <header id="masthead" class="site-header bg-white shadow-md">
        <div class="header-top bg-gradient-to-r from-blue-600 to-purple-600 text-white py-2">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-center text-sm">
                    <span><i class="fas fa-paw mr-1"></i>猫の論文を読んで学ぶサイト</span>
                    <span>AIと猫好きが作る猫好きのためのコンテンツ</span>
                </div>
            </div>
        </div>
        
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-1 relative">
                <div class="site-branding">
                    <?php if ( is_front_page() && is_home() ) : ?>
                        <h1 class="site-title">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="flex items-center">
                                <img src="<?php echo NFU_THEME_URI . '/assets/images/nfu_logo.svg'; ?>" alt="<?php bloginfo( 'name' ); ?>" class="h-10 md:h-12">
                            </a>
                        </h1>
                    <?php else : ?>
                        <p class="site-title">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="flex items-center">
                                <img src="<?php echo NFU_THEME_URI . '/assets/images/nfu_logo.svg'; ?>" alt="<?php bloginfo( 'name' ); ?>" class="h-10 md:h-12">
                            </a>
                        </p>
                    <?php endif; ?>
                    
                    <?php
                    $description = get_bloginfo( 'description', 'display' );
                    if ( $description || is_customize_preview() ) :
                    ?>
                        <p class="site-description text-gray-600 mt-2 text-sm">
                            <?php echo $description; ?>
                        </p>
                    <?php endif; ?>
                </div>
                
                <nav id="site-navigation" class="main-navigation relative">
                    <button class="menu-toggle md:hidden" aria-controls="primary-menu" aria-expanded="false">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    
                    <?php
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => 'div',
                        'container_class' => 'mobile-menu hidden',
                        'menu_class'     => 'flex flex-col md:flex-row space-y-2 md:space-y-0 md:space-x-6',
                        'fallback_cb'    => function() {
                            echo '<div class="mobile-menu hidden">';
                            echo '<ul class="flex flex-col md:flex-row md:flex-wrap space-y-2 md:space-y-0 md:space-x-6">';
                            echo '<li><a href="' . home_url('/') . '" class="block text-gray-700 hover:text-blue-600 transition-colors py-2 md:py-0"><i class="fas fa-home"></i>ホーム</a></li>';
                            echo '<li><a href="' . home_url('/lectures/') . '" class="block text-gray-700 hover:text-blue-600 transition-colors py-2 md:py-0"><i class="fas fa-graduation-cap"></i>講座一覧</a></li>';
                            echo '<li><a href="' . home_url('/papers/') . '" class="block text-gray-700 hover:text-blue-600 transition-colors py-2 md:py-0"><i class="fas fa-file-alt"></i>論文アーカイブ</a></li>';
                            echo '<li><a href="' . home_url('/tips/') . '" class="block text-gray-700 hover:text-blue-600 transition-colors py-2 md:py-0"><i class="fas fa-lightbulb"></i>豆知識バンク</a></li>';
                            echo '<li><a href="' . home_url('/goods/') . '" class="block text-gray-700 hover:text-blue-600 transition-colors py-2 md:py-0"><i class="fas fa-shopping-bag"></i>おすすめの商品</a></li>';
                            echo '<li><a href="' . home_url('/bookmarks/') . '" class="block text-gray-700 hover:text-purple-600 transition-colors py-2 md:py-0 flex items-center"><i class="fas fa-heart text-purple-500 mr-1"></i>お気に入り</a></li>';
                            echo '<li><a href="' . home_url('/about/') . '" class="block text-gray-700 hover:text-blue-600 transition-colors py-2 md:py-0"><i class="fas fa-info-circle"></i>大学について</a></li>';
                            echo '</ul>';
                            echo '</div>';
                        },
                    ) );
                    ?>
                </nav>
            </div>
        </div>
    </header>
    
    <div id="content" class="site-content">