<?php
/**
 * カスタムタクソノミーの登録
 * 
 * @package NekoFreaksUniv
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * カスタムタクソノミーを登録
 */
function nfu_register_taxonomies() {
    
    // テーマカテゴリ（theme_category）
    register_taxonomy( 'theme_category', 
        array( 'lectures', 'lecture_episodes', 'papers', 'tips', 'goods' ),
        array(
            'labels' => array(
                'name'              => 'テーマカテゴリ',
                'singular_name'     => 'テーマカテゴリ',
                'search_items'      => 'テーマカテゴリを検索',
                'all_items'         => 'すべてのテーマカテゴリ',
                'parent_item'       => '親テーマカテゴリ',
                'parent_item_colon' => '親テーマカテゴリ:',
                'edit_item'         => 'テーマカテゴリを編集',
                'update_item'       => 'テーマカテゴリを更新',
                'add_new_item'      => '新規テーマカテゴリを追加',
                'new_item_name'     => '新規テーマカテゴリ名',
                'menu_name'         => 'テーマカテゴリ',
            ),
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'theme' ),
            'show_in_rest'      => true,
        )
    );
    
    // 担当講師（professor）
    register_taxonomy( 'professor',
        array( 'lectures', 'lecture_episodes', 'tips' ),
        array(
            'labels' => array(
                'name'              => '担当講師',
                'singular_name'     => '担当講師',
                'search_items'      => '講師を検索',
                'all_items'         => 'すべての講師',
                'edit_item'         => '講師を編集',
                'update_item'       => '講師を更新',
                'add_new_item'      => '新規講師を追加',
                'new_item_name'     => '新規講師名',
                'menu_name'         => '担当講師',
            ),
            'hierarchical'      => false,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'professor' ),
            'show_in_rest'      => true,
        )
    );
    
    // 難易度（difficulty）
    register_taxonomy( 'difficulty',
        array( 'lectures', 'papers' ),
        array(
            'labels' => array(
                'name'              => '難易度',
                'singular_name'     => '難易度',
                'search_items'      => '難易度を検索',
                'all_items'         => 'すべての難易度',
                'edit_item'         => '難易度を編集',
                'update_item'       => '難易度を更新',
                'add_new_item'      => '新規難易度を追加',
                'new_item_name'     => '新規難易度名',
                'menu_name'         => '難易度',
            ),
            'hierarchical'      => false,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'difficulty' ),
            'show_in_rest'      => true,
        )
    );
    
    // 汎用タグ（content_tags）
    register_taxonomy( 'content_tags',
        array( 'lectures', 'lecture_episodes', 'papers', 'tips', 'goods' ),
        array(
            'labels' => array(
                'name'              => 'タグ',
                'singular_name'     => 'タグ',
                'search_items'      => 'タグを検索',
                'popular_items'     => '人気のタグ',
                'all_items'         => 'すべてのタグ',
                'edit_item'         => 'タグを編集',
                'update_item'       => 'タグを更新',
                'add_new_item'      => '新規タグを追加',
                'new_item_name'     => '新規タグ名',
                'separate_items_with_commas' => 'タグをカンマで区切る',
                'add_or_remove_items'        => 'タグの追加または削除',
                'choose_from_most_used'      => 'よく使われているタグから選択',
                'menu_name'         => 'タグ',
            ),
            'hierarchical'      => false,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => 'tag' ),
            'show_in_rest'      => true,
        )
    );
}
add_action( 'init', 'nfu_register_taxonomies' );

/**
 * デフォルトのタクソノミーターム（カテゴリ）を作成
 */
function nfu_create_default_terms() {
    
    // テーマカテゴリのデフォルトターム
    $theme_categories = array(
        '行動学' => array(
            'slug' => 'behavior',
            'description' => '猫の行動や心理に関する研究'
        ),
        '健康・医学' => array(
            'slug' => 'health',
            'description' => '猫の健康管理や病気に関する情報'
        ),
        '飼育・ケア' => array(
            'slug' => 'care',
            'description' => '猫の飼育方法やケアに関する知識'
        ),
        '猫の生態' => array(
            'slug' => 'ecology',
            'description' => '猫の生態や進化に関する研究'
        ),
    );
    
    foreach ( $theme_categories as $name => $data ) {
        if ( ! term_exists( $name, 'theme_category' ) ) {
            wp_insert_term( $name, 'theme_category', array(
                'slug' => $data['slug'],
                'description' => $data['description']
            ) );
        }
    }
    
    // 担当講師のデフォルトターム
    $professors = array(
        'マロン学長' => array(
            'slug' => 'maron',
            'description' => 'スコティッシュストレート、レッドタビー、0歳、わんぱくで甘えん坊'
        ),
        'いち教授' => array(
            'slug' => 'ichi',
            'description' => '黒猫、12歳、高齢猫の行動・観察担当'
        ),
        'はち助教授' => array(
            'slug' => 'hachi',
            'description' => '黒白ハチワレ、8歳、トイレ・環境・美意識担当'
        ),
        'ジジ助手' => array(
            'slug' => 'jiji',
            'description' => '黒猫、4歳、問題行動・若猫行動学担当'
        ),
        '大福先代学長' => array(
            'slug' => 'daifuku',
            'description' => 'スコティッシュフォールド、1歳、命・絆・繊細なケア担当'
        ),
    );
    
    foreach ( $professors as $name => $data ) {
        if ( ! term_exists( $name, 'professor' ) ) {
            wp_insert_term( $name, 'professor', array(
                'slug' => $data['slug'],
                'description' => $data['description']
            ) );
        }
    }
    
    // 難易度のデフォルトターム
    $difficulties = array(
        '初級' => array(
            'slug' => 'beginner',
            'description' => '猫を飼い始めた方向け'
        ),
        '中級' => array(
            'slug' => 'intermediate',
            'description' => '猫と暮らして1年以上の方向け'
        ),
        '上級' => array(
            'slug' => 'advanced',
            'description' => 'より専門的な知識を求める方向け'
        ),
    );
    
    foreach ( $difficulties as $name => $data ) {
        if ( ! term_exists( $name, 'difficulty' ) ) {
            wp_insert_term( $name, 'difficulty', array(
                'slug' => $data['slug'],
                'description' => $data['description']
            ) );
        }
    }
}
add_action( 'init', 'nfu_create_default_terms', 20 );

/**
 * タクソノミーアーカイブページのタイトルをカスタマイズ
 */
function nfu_custom_archive_title( $title ) {
    if ( is_tax( 'theme_category' ) ) {
        $title = single_term_title( 'テーマ: ', false );
    } elseif ( is_tax( 'professor' ) ) {
        $title = single_term_title( '講師: ', false );
    } elseif ( is_tax( 'difficulty' ) ) {
        $title = single_term_title( '難易度: ', false );
    } elseif ( is_tax( 'content_tags' ) ) {
        $title = single_term_title( 'タグ: ', false );
    }
    
    return $title;
}
add_filter( 'get_the_archive_title', 'nfu_custom_archive_title' );

/**
 * タクソノミーごとのクラスを取得
 */
function nfu_get_term_class( $term ) {
    $classes = array();
    
    if ( $term->taxonomy === 'professor' ) {
        $professor_classes = array(
            'maron'   => 'bg-yellow-100 text-yellow-800',
            'ichi'    => 'bg-orange-100 text-orange-800',
            'hachi'   => 'bg-blue-100 text-blue-800',
            'jiji'    => 'bg-green-100 text-green-800',
            'daifuku' => 'bg-purple-100 text-purple-800',
        );
        
        if ( isset( $professor_classes[$term->slug] ) ) {
            $classes[] = $professor_classes[$term->slug];
        }
    } elseif ( $term->taxonomy === 'difficulty' ) {
        $difficulty_classes = array(
            'beginner'     => 'bg-green-100 text-green-800',
            'intermediate' => 'bg-yellow-100 text-yellow-800',
            'advanced'     => 'bg-red-100 text-red-800',
        );
        
        if ( isset( $difficulty_classes[$term->slug] ) ) {
            $classes[] = $difficulty_classes[$term->slug];
        }
    } elseif ( $term->taxonomy === 'theme_category' ) {
        $classes[] = 'bg-indigo-100 text-indigo-800';
    } else {
        $classes[] = 'bg-gray-100 text-gray-800';
    }
    
    return implode( ' ', $classes );
}