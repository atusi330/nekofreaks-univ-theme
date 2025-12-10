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
    
    // メインJavaScript
    wp_enqueue_script(
        'nfu-main',
        NFU_THEME_URI . '/assets/js/main.js',
        array(),
        NFU_THEME_VERSION,
        true
    );
    
    // ブックマーク・シェア機能JavaScript
    wp_enqueue_script(
        'nfu-bookmark-share',
        NFU_THEME_URI . '/assets/js/bookmark-share.js',
        array(),
        NFU_THEME_VERSION,
        true
    );
    
    // エピソード完了機能JavaScript
    wp_enqueue_script(
        'nfu-episode-completion',
        NFU_THEME_URI . '/assets/js/episode-completion.js',
        array(),
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
    $professor_data = nfu_get_professor_by_id( $professor );
    
    if ( $professor_data && isset( $professor_data['name'] ) ) {
        return $professor_data['name'];
    }
    
    return '';
}

/**
 * 講師の画像を取得
 */
function nfu_get_professor_image( $professor ) {
    $professor_data = nfu_get_professor_by_id( $professor );
    
    if ( $professor_data && isset( $professor_data['image'] ) && ! empty( $professor_data['image'] ) ) {
        return $professor_data['image'];
    }
    
    // 画像が存在しない場合はnullを返す（アイコンが表示される）
    return null;
}

/**
 * JSON-LD構造化データを出力
 */
function nfu_output_json_ld() {
    if ( ! is_singular() ) {
        return;
    }
    
    global $post;
    
    // 論文ページの場合
    if ( is_singular( 'papers' ) ) {
        $original_title = nfu_get_field( 'original_title' );
        $authors = nfu_get_field( 'authors' );
        $published_year = nfu_get_field( 'published_year' );
        $journal = nfu_get_field( 'journal' );
        $doi_link = nfu_get_field( 'doi_link' );
        $summary_points = nfu_get_field( 'summary_points' );
        
        $json_ld = array(
            '@context' => 'https://schema.org',
            '@type' => 'ScholarlyArticle',
            'headline' => get_the_title(),
            'description' => wp_trim_words( get_the_excerpt() ?: get_the_content(), 30, '...' ),
            'datePublished' => get_the_date( 'c' ),
            'dateModified' => get_the_modified_date( 'c' ),
            'author' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo( 'name' )
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo( 'name' ),
                'logo' => array(
                    '@type' => 'ImageObject',
                    'url' => NFU_THEME_URI . '/assets/images/nfu_logo.svg'
                )
            ),
            'mainEntityOfPage' => array(
                '@type' => 'WebPage',
                '@id' => get_permalink()
            )
        );
        
        // 原題がある場合
        if ( $original_title ) {
            $json_ld['alternateName'] = $original_title;
        }
        
        // 著者情報
        if ( $authors ) {
            $author_list = array();
            $author_names = explode( "\n", $authors );
            foreach ( $author_names as $author_name ) {
                $author_name = trim( $author_name );
                if ( $author_name ) {
                    $author_list[] = array(
                        '@type' => 'Person',
                        'name' => $author_name
                    );
                }
            }
            if ( ! empty( $author_list ) ) {
                $json_ld['author'] = count( $author_list ) === 1 ? $author_list[0] : $author_list;
            }
        }
        
        // 発表年
        if ( $published_year ) {
            $json_ld['datePublished'] = $published_year . '-01-01';
        }
        
        // 掲載誌
        if ( $journal ) {
            $json_ld['isPartOf'] = array(
                '@type' => 'PublicationVolume',
                'isPartOf' => array(
                    '@type' => 'Periodical',
                    'name' => $journal
                )
            );
        }
        
        // DOIリンク
        if ( $doi_link ) {
            $json_ld['identifier'] = array(
                '@type' => 'PropertyValue',
                'propertyID' => 'DOI',
                'value' => $doi_link
            );
        }
        
        // 画像
        if ( has_post_thumbnail() ) {
            $thumbnail_id = get_post_thumbnail_id();
            $thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, 'full' );
            if ( $thumbnail_url ) {
                $json_ld['image'] = array(
                    '@type' => 'ImageObject',
                    'url' => $thumbnail_url[0],
                    'width' => $thumbnail_url[1],
                    'height' => $thumbnail_url[2]
                );
            }
        }
        
        echo '<script type="application/ld+json">' . "\n";
        echo wp_json_encode( $json_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
        echo "\n" . '</script>' . "\n";
    }
    
    // 講座ページの場合
    if ( is_singular( 'lectures' ) ) {
        $lecture_status = nfu_get_field( 'lecture_status' );
        $main_professor = nfu_get_field( 'main_professor' );
        $lecture_overview = nfu_get_field( 'lecture_overview' );
        $total_episodes = nfu_get_field( 'total_episodes' ) ?: 5;
        
        // 講師情報を取得
        $professor_data = nfu_get_professor_by_id( $main_professor );
        $professor_name = $professor_data ? $professor_data['name'] : '';
        
        $json_ld = array(
            '@context' => 'https://schema.org',
            '@type' => 'Course',
            'name' => get_the_title(),
            'description' => $lecture_overview ?: wp_trim_words( get_the_excerpt() ?: get_the_content(), 50, '...' ),
            'provider' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo( 'name' ),
                'url' => home_url( '/' ),
                'logo' => array(
                    '@type' => 'ImageObject',
                    'url' => NFU_THEME_URI . '/assets/images/nfu_logo.svg'
                )
            ),
            'url' => get_permalink(),
            'courseCode' => 'LECTURE-' . get_the_ID()
        );
        
        // 講師情報
        if ( $professor_name ) {
            $json_ld['instructor'] = array(
                '@type' => 'Person',
                'name' => $professor_name
            );
        }
        
        // エピソード数
        if ( $total_episodes ) {
            $json_ld['numberOfCredits'] = array(
                '@type' => 'Integer',
                'value' => $total_episodes
            );
        }
        
        // ステータス
        if ( $lecture_status ) {
            $json_ld['courseMode'] = $lecture_status === '開講中' ? 'https://schema.org/Online' : 'https://schema.org/Offline';
        }
        
        // 画像
        if ( has_post_thumbnail() ) {
            $thumbnail_id = get_post_thumbnail_id();
            $thumbnail_url = wp_get_attachment_image_src( $thumbnail_id, 'full' );
            if ( $thumbnail_url ) {
                $json_ld['image'] = array(
                    '@type' => 'ImageObject',
                    'url' => $thumbnail_url[0],
                    'width' => $thumbnail_url[1],
                    'height' => $thumbnail_url[2]
                );
            }
        }
        
        // カテゴリ
        $themes = get_the_terms( get_the_ID(), 'theme_category' );
        if ( $themes && ! is_wp_error( $themes ) ) {
            $keywords = array();
            foreach ( $themes as $theme ) {
                $keywords[] = $theme->name;
            }
            if ( ! empty( $keywords ) ) {
                $json_ld['keywords'] = implode( ', ', $keywords );
            }
        }
        
        echo '<script type="application/ld+json">' . "\n";
        echo wp_json_encode( $json_ld, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
        echo "\n" . '</script>' . "\n";
    }
}
add_action( 'wp_head', 'nfu_output_json_ld', 5 );

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