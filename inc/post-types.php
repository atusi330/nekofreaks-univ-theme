<?php
/**
 * カスタム投稿タイプの登録
 * 
 * @package NekoFreaksUniv
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * カスタム投稿タイプを登録
 */
function nfu_register_post_types() {
    
    // 講座（lectures）
    register_post_type( 'lectures', array(
        'labels' => array(
            'name'               => '講座',
            'singular_name'      => '講座',
            'add_new'            => '新規追加',
            'add_new_item'       => '新規講座を追加',
            'edit_item'          => '講座を編集',
            'new_item'           => '新規講座',
            'view_item'          => '講座を表示',
            'search_items'       => '講座を検索',
            'not_found'          => '講座が見つかりません',
            'not_found_in_trash' => 'ゴミ箱に講座はありません',
            'menu_name'          => '講座',
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array( 'slug' => 'lectures' ),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-welcome-learn-more',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'show_in_rest'        => true,
    ) );
    
    // 講座回（lecture_episodes）
    register_post_type( 'lecture_episodes', array(
        'labels' => array(
            'name'               => '講座回',
            'singular_name'      => '講座回',
            'add_new'            => '新規追加',
            'add_new_item'       => '新規講座回を追加',
            'edit_item'          => '講座回を編集',
            'new_item'           => '新規講座回',
            'view_item'          => '講座回を表示',
            'search_items'       => '講座回を検索',
            'not_found'          => '講座回が見つかりません',
            'not_found_in_trash' => 'ゴミ箱に講座回はありません',
            'menu_name'          => '講座回',
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array( 
            'slug' => 'lectures/%lecture_slug%/episode',
            'with_front' => false 
        ),
        'capability_type'     => 'post',
        'has_archive'         => false,
        'hierarchical'        => false,
        'menu_position'       => 6,
        'menu_icon'           => 'dashicons-video-alt3',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'show_in_rest'        => true,
    ) );
    
    // 論文要約（papers）
    register_post_type( 'papers', array(
        'labels' => array(
            'name'               => '論文',
            'singular_name'      => '論文',
            'add_new'            => '新規追加',
            'add_new_item'       => '新規論文を追加',
            'edit_item'          => '論文を編集',
            'new_item'           => '新規論文',
            'view_item'          => '論文を表示',
            'search_items'       => '論文を検索',
            'not_found'          => '論文が見つかりません',
            'not_found_in_trash' => 'ゴミ箱に論文はありません',
            'menu_name'          => '論文',
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array( 'slug' => 'papers' ),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 7,
        'menu_icon'           => 'dashicons-media-document',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'show_in_rest'        => true,
    ) );
    
    // 豆知識（tips）
    register_post_type( 'tips', array(
        'labels' => array(
            'name'               => '豆知識',
            'singular_name'      => '豆知識',
            'add_new'            => '新規追加',
            'add_new_item'       => '新規豆知識を追加',
            'edit_item'          => '豆知識を編集',
            'new_item'           => '新規豆知識',
            'view_item'          => '豆知識を表示',
            'search_items'       => '豆知識を検索',
            'not_found'          => '豆知識が見つかりません',
            'not_found_in_trash' => 'ゴミ箱に豆知識はありません',
            'menu_name'          => '豆知識',
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array( 'slug' => 'tips' ),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 8,
        'menu_icon'           => 'dashicons-lightbulb',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'comments' ),
        'show_in_rest'        => true,
    ) );
    
    // おすすめの商品（goods）
    register_post_type( 'goods', array(
        'labels' => array(
            'name'               => 'おすすめの商品',
            'singular_name'      => 'おすすめの商品',
            'add_new'            => '新規追加',
            'add_new_item'       => '新規おすすめの商品を追加',
            'edit_item'          => 'おすすめの商品を編集',
            'new_item'           => '新規おすすめの商品',
            'view_item'          => 'おすすめの商品を表示',
            'search_items'       => 'おすすめの商品を検索',
            'not_found'          => 'おすすめの商品が見つかりません',
            'not_found_in_trash' => 'ゴミ箱におすすめの商品はありません',
            'menu_name'          => 'おすすめの商品',
        ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array( 'slug' => 'goods' ),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 9,
        'menu_icon'           => 'dashicons-cart',
        'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'show_in_rest'        => true,
    ) );
}
add_action( 'init', 'nfu_register_post_types' );

/**
 * 講座回のパーマリンクを親講座のスラッグを含む形に変更
 */
function nfu_lecture_episode_permalink( $post_link, $post ) {
    if ( $post->post_type === 'lecture_episodes' ) {
        $parent_lecture = get_field( 'parent_lecture', $post->ID );
        $episode_number = get_field( 'episode_number', $post->ID );
        
        if ( $parent_lecture && $episode_number ) {
            $lecture_slug = get_post_field( 'post_name', $parent_lecture );
            $post_link = home_url( "lectures/{$lecture_slug}/episode/{$episode_number}/" );
        } else {
            // フォールバック: 通常のpost_type URLを使用
            $post_link = home_url( "lecture_episodes/" . $post->post_name . "/" );
        }
    }
    
    return $post_link;
}
add_filter( 'post_type_link', 'nfu_lecture_episode_permalink', 10, 2 );

/**
 * 講座回のURLリライトルールを追加
 */
function nfu_lecture_episode_rewrite_rules() {
    add_rewrite_rule(
        'lectures/([^/]+)/episode/([0-9]+)/?$',
        'index.php?post_type=lecture_episodes&lecture_slug=$matches[1]&episode_number=$matches[2]',
        'top'
    );
}
add_action( 'init', 'nfu_lecture_episode_rewrite_rules' );

/**
 * 講座回のクエリ変数を追加
 */
function nfu_add_query_vars( $vars ) {
    $vars[] = 'lecture_slug';
    $vars[] = 'episode_number';
    return $vars;
}
add_filter( 'query_vars', 'nfu_add_query_vars' );

/**
 * 講座回のクエリを処理
 */
function nfu_parse_lecture_episode_request( $wp ) {
    if ( isset( $wp->query_vars['lecture_slug'] ) && isset( $wp->query_vars['episode_number'] ) ) {
        $lecture_slug = $wp->query_vars['lecture_slug'];
        $episode_number = $wp->query_vars['episode_number'];
        
        // 親講座を検索
        $lectures = get_posts( array(
            'post_type' => 'lectures',
            'name' => $lecture_slug,
            'posts_per_page' => 1,
            'post_status' => 'publish'
        ) );
        
        if ( ! empty( $lectures ) ) {
            $lecture_id = $lectures[0]->ID;
            
            // 該当するエピソードを検索
            $episodes = get_posts( array(
                'post_type' => 'lecture_episodes',
                'meta_query' => array(
                    array(
                        'key' => 'parent_lecture',
                        'value' => $lecture_id,
                        'compare' => '='
                    ),
                    array(
                        'key' => 'episode_number',
                        'value' => $episode_number,
                        'compare' => '='
                    )
                ),
                'posts_per_page' => 1,
                'post_status' => 'publish'
            ) );
            
            if ( ! empty( $episodes ) ) {
                $wp->query_vars['post_type'] = 'lecture_episodes';
                $wp->query_vars['name'] = $episodes[0]->post_name;
                unset( $wp->query_vars['lecture_slug'] );
                unset( $wp->query_vars['episode_number'] );
            }
        }
    }
}
add_action( 'parse_request', 'nfu_parse_lecture_episode_request' );

/**
 * パーマリンクをフラッシュ（テーマ有効化時）
 */
function nfu_flush_rewrite_rules() {
    nfu_register_post_types();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'nfu_flush_rewrite_rules' );

/**
 * 管理画面でのカラムカスタマイズ
 */
function nfu_add_lecture_columns( $columns ) {
    $new_columns = array();
    foreach( $columns as $key => $value ) {
        $new_columns[$key] = $value;
        if ( $key === 'title' ) {
            $new_columns['professor'] = '担当講師';
            $new_columns['status'] = 'ステータス';
        }
    }
    return $new_columns;
}
add_filter( 'manage_lectures_posts_columns', 'nfu_add_lecture_columns' );

function nfu_lecture_column_content( $column, $post_id ) {
    switch ( $column ) {
        case 'professor':
            $professor = get_field( 'main_professor', $post_id );
            echo $professor ? nfu_get_professor_name( $professor ) : '−';
            break;
        case 'status':
            $status = get_field( 'lecture_status', $post_id );
            $class = $status === '開講中' ? 'text-green-600' : 'text-gray-500';
            echo '<span class="' . $class . '">' . ($status ?: '−') . '</span>';
            break;
    }
}
add_action( 'manage_lectures_posts_custom_column', 'nfu_lecture_column_content', 10, 2 );

/**
 * Register Professor Custom Post Type
 */
function nfu_register_professor_post_type() {
    $labels = array(
        'name'                  => '講師',
        'singular_name'         => '講師',
        'menu_name'             => '講師管理',
        'add_new'               => '新規追加',
        'add_new_item'          => '新しい講師を追加',
        'edit_item'             => '講師を編集',
        'new_item'              => '新しい講師',
        'view_item'             => '講師を表示',
        'search_items'          => '講師を検索',
        'not_found'             => '講師が見つかりませんでした',
        'not_found_in_trash'    => 'ゴミ箱に講師が見つかりませんでした',
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'professor'),
        'capability_type'     => 'post',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-admin-users',
        'supports'            => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'show_in_rest'        => true,
    );

    register_post_type('professor', $args);
}
add_action('init', 'nfu_register_professor_post_type');

/**
 * パーマリンク設定をリフレッシュ（開発用）
 */
function nfu_refresh_rewrite_rules() {
    if (isset($_GET['refresh_rewrite']) && current_user_can('manage_options')) {
        flush_rewrite_rules();
        echo '<div class="notice notice-success"><p>パーマリンク設定をリフレッシュしました。</p></div>';
    }
}
add_action('admin_notices', 'nfu_refresh_rewrite_rules');