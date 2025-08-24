<?php
/**
 * 講師投稿デバッグページ
 * このファイルは一時的なデバッグ用です
 */

// WordPressの読み込み
require_once('../../../wp-load.php');

// 管理者のみアクセス可能
if (!current_user_can('administrator')) {
    wp_die('アクセス権限がありません');
}

echo '<h1>講師投稿デバッグ情報</h1>';

// 1. 講師投稿タイプの確認
echo '<h2>1. 講師投稿タイプの確認</h2>';
$professor_post_type = get_post_type_object('professor');
if ($professor_post_type) {
    echo '<p>✅ 講師投稿タイプが登録されています</p>';
    echo '<p>スラッグ: ' . $professor_post_type->rewrite['slug'] . '</p>';
} else {
    echo '<p>❌ 講師投稿タイプが登録されていません</p>';
}

// 2. 講師投稿の一覧
echo '<h2>2. 講師投稿の一覧</h2>';
$professors = get_posts(array(
    'post_type' => 'professor',
    'post_status' => 'publish',
    'numberposts' => -1,
));

if (empty($professors)) {
    echo '<p>❌ 講師投稿が見つかりません</p>';
} else {
    echo '<p>✅ ' . count($professors) . '件の講師投稿が見つかりました</p>';
    echo '<ul>';
    foreach ($professors as $professor) {
        echo '<li>';
        echo 'ID: ' . $professor->ID . ', ';
        echo 'タイトル: ' . $professor->post_title . ', ';
        echo 'スラッグ: ' . $professor->post_name . ', ';
        echo 'ステータス: ' . $professor->post_status;
        echo '</li>';
    }
    echo '</ul>';
}

// 3. 各講師の画像フィールド確認
echo '<h2>3. 講師画像フィールドの確認</h2>';
$professor_keys = array('maron', 'ichi', 'hachi', 'jiji', 'daifuku');

foreach ($professor_keys as $key) {
    echo '<h3>講師: ' . $key . '</h3>';
    
    // 投稿を検索
    $professor_query = new WP_Query(array(
        'post_type' => 'professor',
        'name' => $key,
        'post_status' => 'publish',
        'posts_per_page' => 1,
    ));
    
    if ($professor_query->have_posts()) {
        $professor_query->the_post();
        $post_id = get_the_ID();
        $professor_image = nfu_get_field('professor_image', $post_id);
        
        echo '<p>✅ 投稿が見つかりました (ID: ' . $post_id . ')</p>';
        echo '<p>画像フィールド値: ' . var_export($professor_image, true) . '</p>';
        
        if ($professor_image) {
            echo '<p>✅ 画像が設定されています</p>';
            echo '<img src="' . esc_url($professor_image) . '" style="max-width: 200px; height: auto;" alt="' . $key . '">';
        } else {
            echo '<p>❌ 画像が設定されていません</p>';
        }
        
        wp_reset_postdata();
    } else {
        echo '<p>❌ 投稿が見つかりません (スラッグ: ' . $key . ')</p>';
    }
}

// 4. ACFフィールドの確認
echo '<h2>4. ACFフィールドの確認</h2>';
if (function_exists('get_field_objects')) {
    $field_objects = get_field_objects();
    if ($field_objects) {
        echo '<p>✅ ACFフィールドが設定されています</p>';
        foreach ($field_objects as $field) {
            if ($field['name'] === 'professor_image') {
                echo '<p>講師画像フィールド: ' . $field['label'] . '</p>';
                echo '<p>return_format: ' . $field['return_format'] . '</p>';
            }
        }
    } else {
        echo '<p>❌ ACFフィールドが見つかりません</p>';
    }
} else {
    echo '<p>❌ ACFプラグインが有効化されていません</p>';
}

echo '<hr>';
echo '<p><a href="' . admin_url() . '">管理画面に戻る</a></p>';
?>

