<?php
/**
 * Ajax処理ハンドラー
 * 
 * @package NekoFreaksUniv
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 講座一覧のフィルター処理
 */
function nfu_filter_lectures() {
    // Nonceチェック
    if ( ! wp_verify_nonce( $_POST['nonce'], 'nfu_ajax_nonce' ) ) {
        wp_die( 'セキュリティエラー' );
    }
    
    $professor = isset( $_POST['professor'] ) ? sanitize_text_field( $_POST['professor'] ) : '';
    $theme = isset( $_POST['theme'] ) ? sanitize_text_field( $_POST['theme'] ) : '';
    $difficulty = isset( $_POST['difficulty'] ) ? sanitize_text_field( $_POST['difficulty'] ) : '';
    
    $args = array(
        'post_type' => 'lectures',
        'posts_per_page' => 12,
        'post_status' => 'publish',
    );
    
    $meta_query = array();
    $tax_query = array();
    
    // 講師フィルター（カスタムフィールド）
    if ( $professor && $professor !== 'maron' ) {
        // マロン学長以外の場合は、その講師の講座のみを表示
        $meta_query[] = array(
            'key' => 'main_professor',
            'value' => $professor,
            'compare' => '='
        );
    }
    // マロン学長（全て表示）の場合は、フィルターを適用しない（全講座表示）
    
    // テーマフィルター（タクソノミー）
    if ( $theme ) {
        $tax_query[] = array(
            'taxonomy' => 'theme_category',
            'field' => 'slug',
            'terms' => $theme,
        );
    }
    
    // 難易度フィルター（タクソノミー）
    if ( $difficulty ) {
        $tax_query[] = array(
            'taxonomy' => 'difficulty',
            'field' => 'slug',
            'terms' => $difficulty,
        );
    }
    
    // メタクエリの設定
    if ( ! empty( $meta_query ) ) {
        if ( count( $meta_query ) > 1 ) {
            $meta_query['relation'] = 'AND';
        }
        $args['meta_query'] = $meta_query;
    }
    
    // タクソノミークエリの設定
    if ( ! empty( $tax_query ) ) {
        if ( count( $tax_query ) > 1 ) {
            $tax_query['relation'] = 'AND';
        }
        $args['tax_query'] = $tax_query;
    }
    
    $query = new WP_Query( $args );
    
    // デバッグ情報（開発環境のみ）
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG && current_user_can( 'administrator' ) ) {
        $filter_type = ($professor === 'maron') ? '全て表示' : '講師絞り込み';
        error_log( 'NFU Filter Debug: ' . json_encode( array(
            'professor' => $professor,
            'filter_type' => $filter_type,
            'theme' => $theme,
            'difficulty' => $difficulty,
            'meta_query' => $meta_query,
            'tax_query' => $tax_query,
            'found_posts' => $query->found_posts,
            'request' => $query->request
        ) ) );
    }
    
    ob_start();
    
    if ( $query->have_posts() ) :
        while ( $query->have_posts() ) : $query->the_post();
            get_template_part( 'template-parts/content', 'lecture-card' );
        endwhile;
    else :
        echo '<div class="col-span-full text-center py-8">';
        echo '<p class="text-gray-600">該当する講座が見つかりませんでした。</p>';
        echo '</div>';
    endif;
    
    wp_reset_postdata();
    
    $output = ob_get_clean();
    
    wp_send_json_success( array(
        'html' => $output,
        'found_posts' => $query->found_posts,
    ) );
}
add_action( 'wp_ajax_filter_lectures', 'nfu_filter_lectures' );
add_action( 'wp_ajax_nopriv_filter_lectures', 'nfu_filter_lectures' );

/**
 * 講座の進捗を更新
 */
function nfu_update_lecture_progress() {
    // Nonceチェック
    if ( ! wp_verify_nonce( $_POST['nonce'], 'nfu_ajax_nonce' ) ) {
        wp_die( 'セキュリティエラー' );
    }
    
    $lecture_id = isset( $_POST['lecture_id'] ) ? intval( $_POST['lecture_id'] ) : 0;
    $episode_number = isset( $_POST['episode_number'] ) ? intval( $_POST['episode_number'] ) : 0;
    
    if ( ! $lecture_id || ! $episode_number ) {
        wp_send_json_error( 'パラメータが不正です' );
    }
    
    // セッションまたはCookieに進捗を保存
    $progress_key = 'nfu_lecture_progress_' . $lecture_id;
    $current_progress = isset( $_COOKIE[$progress_key] ) ? intval( $_COOKIE[$progress_key] ) : 0;
    
    if ( $episode_number > $current_progress ) {
        setcookie( $progress_key, $episode_number, time() + ( 30 * DAY_IN_SECONDS ), '/' );
        
        wp_send_json_success( array(
            'message' => '進捗を更新しました',
            'progress' => $episode_number,
        ) );
    } else {
        wp_send_json_success( array(
            'message' => 'すでに受講済みです',
            'progress' => $current_progress,
        ) );
    }
}
add_action( 'wp_ajax_update_lecture_progress', 'nfu_update_lecture_progress' );
add_action( 'wp_ajax_nopriv_update_lecture_progress', 'nfu_update_lecture_progress' );

/**
 * お気に入り講座の追加/削除
 */
function nfu_toggle_favorite_lecture() {
    // Nonceチェック
    if ( ! wp_verify_nonce( $_POST['nonce'], 'nfu_ajax_nonce' ) ) {
        wp_die( 'セキュリティエラー' );
    }
    
    $lecture_id = isset( $_POST['lecture_id'] ) ? intval( $_POST['lecture_id'] ) : 0;
    
    if ( ! $lecture_id ) {
        wp_send_json_error( '講座IDが不正です' );
    }
    
    $favorites_key = 'nfu_favorite_lectures';
    $favorites = isset( $_COOKIE[$favorites_key] ) ? explode( ',', $_COOKIE[$favorites_key] ) : array();
    
    if ( in_array( $lecture_id, $favorites ) ) {
        // 削除
        $favorites = array_diff( $favorites, array( $lecture_id ) );
        $action = 'removed';
    } else {
        // 追加
        $favorites[] = $lecture_id;
        $action = 'added';
    }
    
    $favorites_string = implode( ',', array_filter( $favorites ) );
    setcookie( $favorites_key, $favorites_string, time() + ( 365 * DAY_IN_SECONDS ), '/' );
    
    wp_send_json_success( array(
        'action' => $action,
        'favorites' => $favorites,
    ) );
}
add_action( 'wp_ajax_toggle_favorite_lecture', 'nfu_toggle_favorite_lecture' );
add_action( 'wp_ajax_nopriv_toggle_favorite_lecture', 'nfu_toggle_favorite_lecture' );

/**
 * 講座回の次回予告を取得
 */
function nfu_get_next_episode() {
    // Nonceチェック
    if ( ! wp_verify_nonce( $_POST['nonce'], 'nfu_ajax_nonce' ) ) {
        wp_die( 'セキュリティエラー' );
    }
    
    $lecture_id = isset( $_POST['lecture_id'] ) ? intval( $_POST['lecture_id'] ) : 0;
    $current_episode = isset( $_POST['current_episode'] ) ? intval( $_POST['current_episode'] ) : 0;
    
    if ( ! $lecture_id || ! $current_episode ) {
        wp_send_json_error( 'パラメータが不正です' );
    }
    
    $next_episode = $current_episode + 1;
    
    $args = array(
        'post_type' => 'lecture_episodes',
        'meta_query' => array(
            array(
                'key' => 'parent_lecture',
                'value' => $lecture_id,
                'compare' => '='
            ),
            array(
                'key' => 'episode_number',
                'value' => $next_episode,
                'compare' => '='
            )
        ),
        'posts_per_page' => 1,
        'post_status' => array( 'publish', 'future' )
    );
    
    $query = new WP_Query( $args );
    
    if ( $query->have_posts() ) {
        $query->the_post();
        
        $response = array(
            'found' => true,
            'title' => get_the_title(),
            'excerpt' => get_the_excerpt(),
            'url' => get_permalink(),
            'status' => get_post_status(),
            'date' => get_the_date( 'Y年n月j日' ),
        );
        
        wp_reset_postdata();
        wp_send_json_success( $response );
    } else {
        wp_send_json_success( array( 'found' => false ) );
    }
}
add_action( 'wp_ajax_get_next_episode', 'nfu_get_next_episode' );
add_action( 'wp_ajax_nopriv_get_next_episode', 'nfu_get_next_episode' );

/**
 * Update professor favorite count via AJAX
 */
function nfu_update_professor_favorite_count_ajax() {
    // セキュリティチェック
    if (!wp_verify_nonce($_POST['nonce'], 'update_professor_favorite')) {
        wp_die('Security check failed');
    }
    
    $professor_id = sanitize_text_field($_POST['professor_id']);
    $increment = intval($_POST['increment']);
    
    if ($increment) {
        $new_count = nfu_update_professor_favorite_count($professor_id, true);
    } else {
        $new_count = nfu_update_professor_favorite_count($professor_id, false);
    }
    
    wp_send_json_success(array('count' => $new_count));
}
add_action('wp_ajax_update_professor_favorite_count', 'nfu_update_professor_favorite_count_ajax');
add_action('wp_ajax_nopriv_update_professor_favorite_count', 'nfu_update_professor_favorite_count_ajax');

/**
 * 講座データを取得するAJAXハンドラー
 */
function nfu_get_lecture_data_ajax() {
    // セキュリティチェック
    if (!wp_verify_nonce($_POST['nonce'], 'nfu_ajax_nonce')) {
        wp_die('Security check failed');
    }
    
    $lecture_ids = isset($_POST['lecture_ids']) ? $_POST['lecture_ids'] : array();
    
    if (empty($lecture_ids)) {
        wp_send_json_error('No lecture IDs provided');
    }
    
    $lecture_data = array();
    
    foreach ($lecture_ids as $lecture_id) {
        // 講座IDから投稿を検索（複数の方法を試す）
        $lecture = null;
        
        // 方法1: 投稿IDとして直接検索
        if (is_numeric($lecture_id)) {
            $lecture = get_post($lecture_id);
            if ($lecture && $lecture->post_type === 'lectures') {
                // 投稿が見つかった
            } else {
                $lecture = null;
            }
        }
        
        // 方法2: スラッグとして検索
        if (!$lecture) {
            $args = array(
                'post_type' => 'lectures',
                'post_status' => 'publish',
                'name' => $lecture_id,
                'posts_per_page' => 1
            );
            $lectures = get_posts($args);
            if (!empty($lectures)) {
                $lecture = $lectures[0];
            }
        }
        
        // 方法3: ACFフィールドで検索（lecture_idフィールドがある場合）
        if (!$lecture) {
            $args = array(
                'post_type' => 'lectures',
                'post_status' => 'publish',
                'meta_query' => array(
                    array(
                        'key' => 'lecture_id',
                        'value' => $lecture_id,
                        'compare' => '='
                    )
                ),
                'posts_per_page' => 1
            );
            $lectures = get_posts($args);
            if (!empty($lectures)) {
                $lecture = $lectures[0];
            }
        }
        
        if ($lecture) {
            $lecture_data[$lecture_id] = array(
                'title' => get_the_title($lecture->ID),
                'url' => get_permalink($lecture->ID),
                'total_episodes' => get_field('total_episodes', $lecture->ID) ?: 5,
                'main_professor' => get_field('main_professor', $lecture->ID),
                'lecture_status' => get_field('lecture_status', $lecture->ID)
            );
        } else {
            // 見つからない場合はデフォルトデータ
            $lecture_data[$lecture_id] = array(
                'title' => '講座 #' . $lecture_id,
                'url' => '/lectures/' . $lecture_id . '/',
                'total_episodes' => 5,
                'main_professor' => 'maron',
                'lecture_status' => '開講中'
            );
        }
    }
    
    wp_send_json_success($lecture_data);
}
add_action('wp_ajax_get_lecture_data', 'nfu_get_lecture_data_ajax');
add_action('wp_ajax_nopriv_get_lecture_data', 'nfu_get_lecture_data_ajax');