<?php
/**
 * ネコフリークス大学テーマ functions.php
 * 
 * @package NekoFreaksUniv
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'NFU_THEME_VERSION', '1.0.0' );
define( 'NFU_THEME_DIR', get_template_directory() );
define( 'NFU_THEME_URI', get_template_directory_uri() );

/**
 * テーマのセットアップ
 */
function nfu_theme_setup() {
    load_theme_textdomain( 'nekofreaks-univ', NFU_THEME_DIR . '/languages' );
    
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );
    
    add_theme_support( 'customize-selective-refresh-widgets' );
    
    register_nav_menus( array(
        'primary' => __( 'プライマリーメニュー', 'nekofreaks-univ' ),
        'footer'  => __( 'フッターメニュー', 'nekofreaks-univ' ),
    ) );
}
add_action( 'after_setup_theme', 'nfu_theme_setup' );

/**
 * スクリプトとスタイルの読み込み
 */
function nfu_enqueue_scripts() {
    // Tailwind CSS (CDN版)
    wp_enqueue_style( 
        'tailwindcss', 
        'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css',
        array(),
        null
    );
    
    // テーマスタイル
    wp_enqueue_style( 
        'nfu-style', 
        get_stylesheet_uri(), 
        array('tailwindcss'),
        NFU_THEME_VERSION 
    );
    
    // jQuery (WordPress同梱版)
    wp_enqueue_script( 'jquery' );
    
    // メインJavaScript
    wp_enqueue_script(
        'nfu-main',
        NFU_THEME_URI . '/assets/js/main.js',
        array('jquery'),
        NFU_THEME_VERSION,
        true
    );
    
    // ブックマーク・シェア機能JavaScript
    wp_enqueue_script(
        'nfu-bookmark-share',
        NFU_THEME_URI . '/assets/js/bookmark-share.js',
        array('jquery'),
        NFU_THEME_VERSION,
        true
    );
    
    // エピソード完了機能JavaScript
    wp_enqueue_script(
        'nfu-episode-completion',
        NFU_THEME_URI . '/assets/js/episode-completion.js',
        array('jquery'),
        NFU_THEME_VERSION,
        true
    );
    
    // Ajax用のローカライズ
    wp_localize_script( 'nfu-main', 'nfu_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'nfu_ajax_nonce' ),
    ) );
}
add_action( 'wp_enqueue_scripts', 'nfu_enqueue_scripts' );

/**
 * サイドバーの登録
 */
function nfu_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'サイドバー', 'nekofreaks-univ' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'サイドバーウィジェットエリア', 'nekofreaks-univ' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s bg-white rounded-lg shadow-md p-6 mb-6">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title text-xl font-bold mb-4">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'nfu_widgets_init' );

/**
 * 抜粋の長さを変更
 */
function nfu_excerpt_length( $length ) {
    return 60;
}
add_filter( 'excerpt_length', 'nfu_excerpt_length' );

/**
 * 抜粋の末尾を変更
 */
function nfu_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'nfu_excerpt_more' );

/**
 * 必要なファイルをインクルード
 */
$inc_files = array(
    '/inc/post-types.php',
    '/inc/taxonomies.php',
    '/inc/ajax-handlers.php',
    '/inc/template-tags.php',
    '/inc/acf-fields.php',
);

foreach ( $inc_files as $file ) {
    $filepath = NFU_THEME_DIR . $file;
    if ( file_exists( $filepath ) ) {
        require_once $filepath;
    }
}

/**
 * ACFが有効かチェック
 */
function nfu_check_acf() {
    if ( ! function_exists( 'get_field' ) ) {
        add_action( 'admin_notices', function() {
            echo '<div class="notice notice-warning"><p>';
            echo 'ネコフリークス大学テーマはAdvanced Custom Fields (ACF)プラグインが必要です。';
            echo '</p></div>';
        });
    }
}
add_action( 'admin_init', 'nfu_check_acf' );

/**
 * ACFフィールドの初期化
 */
function nfu_init_acf_fields() {
    if ( function_exists( 'acf_add_local_field_group' ) ) {
        // ACFフィールドが利用可能な場合の処理
        do_action( 'nfu_acf_ready' );
    }
}
add_action( 'acf/init', 'nfu_init_acf_fields' );

/**
 * 講師別のクラスを取得
 */
function nfu_get_professor_class( $professor ) {
    $classes = array(
        'maron'   => 'professor-maron',
        'ichi'    => 'professor-ichi',
        'hachi'   => 'professor-hachi',
        'jiji'    => 'professor-jiji',
        'daifuku' => 'professor-daifuku',
    );
    
    return isset( $classes[$professor] ) ? $classes[$professor] : '';
}

/**
 * 講師の表示名を取得
 */
function nfu_get_professor_name( $professor ) {
    $names = array(
        'maron'   => 'マロン学長',
        'ichi'    => 'いち教授',
        'hachi'   => 'はち助教授',
        'jiji'    => 'ジジ助手',
        'daifuku' => '大福先代学長',
    );
    
    return isset( $names[$professor] ) ? $names[$professor] : '';
}

/**
 * 講師の画像を取得
 */
function nfu_get_professor_image( $professor ) {
    // 講師のスラッグから投稿を検索
    $professor_post = get_page_by_path( $professor, OBJECT, 'professor' );
    
    if ( $professor_post ) {
        // ACFフィールドから画像を取得
        $professor_image = nfu_get_field( 'professor_image', $professor_post->ID );
        
        if ( $professor_image ) {
            return $professor_image;
        }
    }
    
    // フォールバック: 講師別の画像パスを定義（実際のファイル構造に合わせて修正）
    $images = array(
        'maron'   => NFU_THEME_URI . '/assets/images/maron_image.webp',
        'ichi'    => NFU_THEME_URI . '/assets/images/characters/ichi.webp',
        'hachi'   => NFU_THEME_URI . '/assets/images/characters/hachi.webp',
        'jiji'    => NFU_THEME_URI . '/assets/images/characters/jiji.webp',
        'daifuku' => NFU_THEME_URI . '/assets/images/characters/daifuku.webp',
    );
    
    // 画像が存在するかチェック
    if ( isset( $images[$professor] ) ) {
        $image_path = str_replace( NFU_THEME_URI, NFU_THEME_DIR, $images[$professor] );
        if ( file_exists( $image_path ) ) {
            return $images[$professor];
        }
    }
    
    // デバッグ情報（管理者のみ）
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG && current_user_can( 'administrator' ) ) {
        error_log( 'NFU Professor Image Debug: Professor=' . $professor . ', Post Found=' . ( $professor_post ? 'yes' : 'no' ) . ', ACF Image=' . ( $professor_image ? 'yes' : 'no' ) );
    }
    
    // 画像が存在しない場合はnullを返す（アイコンが表示される）
    return null;
}

/**
 * カスタムナビゲーションウォーカー
 */
if ( ! class_exists( 'NFU_Nav_Walker' ) ) {
    class NFU_Nav_Walker extends Walker_Nav_Menu {
        function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
            $classes = empty( $item->classes ) ? array() : (array) $item->classes;
            $classes[] = 'menu-item-' . $item->ID;
            
            $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
            $class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';
            
            $output .= '<li' . $class_names .'>';
            
            $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
            $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
            $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
            $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';
            $attributes .= ' class="text-gray-700 hover:text-blue-600 transition-colors"';
            
            $item_output = $args->before ?? '';
            $item_output .= '<a' . $attributes . '>';
            $item_output .= ($args->link_before ?? '') . apply_filters( 'the_title', $item->title, $item->ID ) . ($args->link_after ?? '');
            $item_output .= '</a>';
            $item_output .= $args->after ?? '';
            
            $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
        }
    }
}

/**
 * フッター用カスタムナビゲーションウォーカー
 */
if ( ! class_exists( 'NFU_Footer_Walker' ) ) {
    class NFU_Footer_Walker extends Walker_Nav_Menu {
        function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
            $output .= '<li>';
            
            $attributes = ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';
            $attributes .= ' class="text-sm hover:text-yellow-300 transition-colors"';
            
            $item_output = '<a' . $attributes . '>';
            $item_output .= apply_filters( 'the_title', $item->title, $item->ID );
            $item_output .= '</a>';
            
            $output .= $item_output;
        }
    }
}