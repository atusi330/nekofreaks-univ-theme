<?php
/**
 * テンプレートタグ
 * 
 * @package NekoFreaksUniv
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * 講座カードを表示
 */
function nfu_lecture_card( $post_id = null ) {
    if ( ! $post_id ) {
        $post_id = get_the_ID();
    }
    
    $status = nfu_get_field( 'lecture_status', $post_id );
    $professor = nfu_get_field( 'main_professor', $post_id );
    $progress = nfu_get_lecture_progress( $post_id );
    
    ?>
    <article class="lecture-card bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
        <?php if ( has_post_thumbnail( $post_id ) ) : ?>
            <div class="card-thumbnail">
                <?php echo get_the_post_thumbnail( $post_id, 'medium', array( 'class' => 'w-full h-48 object-cover' ) ); ?>
            </div>
        <?php else : ?>
            <div class="card-thumbnail bg-gradient-to-br from-blue-400 to-purple-500 h-48 flex items-center justify-center">
                <i class="fas fa-book text-6xl"></i>
            </div>
        <?php endif; ?>
        
        <div class="card-content p-4">
            <div class="flex justify-between items-start mb-2">
                <span class="status-badge inline-block px-2 py-1 text-xs rounded-full <?php echo $status === '開講中' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600'; ?>">
                    <?php echo esc_html( $status ); ?>
                </span>
                <span class="professor-badge <?php echo esc_attr( nfu_get_professor_class( $professor ) ); ?> text-xs px-2 py-1 rounded">
                    <?php echo esc_html( nfu_get_professor_name( $professor ) ); ?>
                </span>
            </div>
            
            <h3 class="card-title text-lg font-bold mb-2">
                <a href="<?php echo get_permalink( $post_id ); ?>" class="text-gray-800 hover:text-blue-600 transition-colors">
                    <?php echo get_the_title( $post_id ); ?>
                </a>
            </h3>
            
            <p class="card-excerpt text-sm text-gray-600 mb-3">
                <?php echo wp_trim_words( get_the_excerpt( $post_id ), 20 ); ?>
            </p>
            
            <div class="progress-bar bg-gray-200 rounded-full h-2 mb-2">
                <div class="progress-fill bg-gradient-to-r from-blue-400 to-purple-500 h-full rounded-full transition-all" style="width: <?php echo $progress['percentage']; ?>%"></div>
            </div>
            
            <div class="flex justify-between text-xs text-gray-500">
                <span>進捗: <?php echo $progress['published']; ?>/<?php echo $progress['total']; ?>回</span>
                <span><?php echo $progress['percentage']; ?>%完了</span>
            </div>
        </div>
    </article>
    <?php
}

/**
 * キャラクターの吹き出し表示
 */
function nfu_character_dialogue( $character, $message, $position = 'left' ) {
    $character_data = array(
        'maron' => array(
            'name' => 'マロン学長',
            'icon' => '🐈',
            'color' => 'professor-maron',
        ),
        'ichi' => array(
            'name' => 'いち教授',
            'icon' => '🐈‍⬛',
            'color' => 'professor-ichi',
        ),
        'hachi' => array(
            'name' => 'はち助教授',
            'icon' => '🐾',
            'color' => 'professor-hachi',
        ),
        'jiji' => array(
            'name' => 'ジジ助手',
            'icon' => '🐈‍⬛',
            'color' => 'professor-jiji',
        ),
        'daifuku' => array(
            'name' => '大福先代学長',
            'icon' => '🐱',
            'color' => 'professor-daifuku',
        ),
    );
    
    if ( ! isset( $character_data[$character] ) ) {
        return;
    }
    
    $char = $character_data[$character];
    $alignment = $position === 'right' ? 'flex-row-reverse' : 'flex-row';
    
    ?>
    <div class="character-dialogue flex <?php echo $alignment; ?> items-start">
        <div class="character-icon flex-shrink-0 w-16 h-16 bg-white rounded-full shadow-md flex items-center justify-center <?php echo $position === 'right' ? 'ml-4' : 'mr-4'; ?> overflow-hidden">
            <?php 
            $professor_image = nfu_get_professor_image($character);
            if ($professor_image) : ?>
                <img src="<?php echo esc_url($professor_image); ?>" alt="<?php echo esc_attr($char['name']); ?>" class="w-full h-full object-cover">
            <?php else : ?>
                <span class="text-2xl"><?php echo $char['icon']; ?></span>
            <?php endif; ?>
        </div>
        <div class="dialogue-content <?php echo $position === 'right' ? 'max-w-2xl ml-auto' : 'max-w-2xl'; ?>">
            <div class="character-name <?php echo $char['color']; ?> font-bold text-sm mb-2 <?php echo $position === 'right' ? 'text-right' : 'text-left'; ?>">
                <?php echo $char['name']; ?>
            </div>
            <div class="dialogue-bubble <?php echo $position === 'right' ? 'bg-white' : 'custom-green'; ?> rounded-2xl shadow-sm p-4 relative border border-gray-200">
                <div class="bubble-tail absolute w-0 h-0 top-4 
                     <?php echo $position === 'right' ? 'right-0 translate-x-2' : 'left-0 -translate-x-2'; ?>"
                     style="border-style: solid; border-width: 8px; 
                     <?php echo $position === 'right' ? 
                         'border-color: transparent transparent transparent #ffffff;' : 
                         'border-color: transparent #06c755 transparent transparent;'; ?>">
                </div>
                
                <div class="dialogue-text <?php echo $position === 'right' ? 'text-gray-800' : 'text-black'; ?> leading-relaxed text-base">
                    <?php echo wpautop( $message ); ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/**
 * 講座回のナビゲーション
 */
function nfu_episode_navigation( $lecture_id, $current_episode ) {
    $total_episodes = nfu_get_field( 'total_episodes', $lecture_id ) ?: 5;
    
    ?>
    <nav class="episode-navigation bg-white rounded-lg shadow p-4 mb-6">
        <div class="flex justify-between items-center">
            <h3 class="font-bold text-gray-700">講座の進行</h3>
            <span class="text-sm text-gray-500">全<?php echo $total_episodes; ?>回</span>
        </div>
        <div class="flex space-x-2 mt-3">
            <?php for ( $i = 1; $i <= $total_episodes; $i++ ) : ?>
                <?php
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
                            'value' => $i,
                            'compare' => '='
                        )
                    ),
                    'posts_per_page' => 1,
                    'post_status' => 'publish'
                );
                
                $query = new WP_Query( $args );
                $is_published = $query->have_posts();
                $is_current = $i == $current_episode;
                
                if ( $is_published ) {
                    $query->the_post();
                    $episode_url = get_permalink();
                    wp_reset_postdata();
                } else {
                    $episode_url = '#';
                }
                ?>
                
                <a href="<?php echo $episode_url; ?>" 
                   class="episode-number flex-1 py-2 px-3 text-center rounded <?php 
                   echo $is_current ? 'bg-blue-600 text-white' : 
                        ($is_published ? 'bg-blue-100 text-blue-800 hover:bg-blue-200' : 'bg-gray-100 text-gray-400 cursor-not-allowed'); 
                   ?>"
                   <?php echo ! $is_published ? 'onclick="return false;"' : ''; ?>>
                    第<?php echo $i; ?>回
                </a>
            <?php endfor; ?>
        </div>
    </nav>
    <?php
}

/**
 * 肉球スタンプ評価
 */
function nfu_paw_rating( $rating = 0, $max = 5 ) {
    ?>
    <div class="paw-rating flex space-x-1">
        <?php for ( $i = 1; $i <= $max; $i++ ) : ?>
            <span class="paw-stamp text-2xl <?php echo $i <= $rating ? 'text-pink-500' : 'text-gray-300'; ?>">
                🐾
            </span>
        <?php endfor; ?>
    </div>
    <?php
}

/**
 * パンくずリスト
 */
function nfu_breadcrumb() {
    if ( is_front_page() ) {
        return;
    }
    
    echo '<nav class="breadcrumb text-sm text-gray-600 mb-4">';
    echo '<a href="' . home_url() . '" class="hover:text-blue-600">ホーム</a>';
    
    if ( is_post_type_archive() ) {
        echo ' <span class="mx-2">›</span> ';
        echo '<span>' . post_type_archive_title( '', false ) . '</span>';
    } elseif ( is_tax() ) {
        $term = get_queried_object();
        $post_type = get_post_type();
        $post_type_obj = get_post_type_object( $post_type );
        
        if ( $post_type_obj->has_archive ) {
            echo ' <span class="mx-2">›</span> ';
            echo '<a href="' . get_post_type_archive_link( $post_type ) . '" class="hover:text-blue-600">' . $post_type_obj->labels->name . '</a>';
        }
        
        echo ' <span class="mx-2">›</span> ';
        echo '<span>' . single_term_title( '', false ) . '</span>';
    } elseif ( is_singular() ) {
        $post_type = get_post_type();
        $post_type_obj = get_post_type_object( $post_type );
        
        if ( $post_type !== 'post' && $post_type_obj->has_archive ) {
            echo ' <span class="mx-2">›</span> ';
            echo '<a href="' . get_post_type_archive_link( $post_type ) . '" class="hover:text-blue-600">' . $post_type_obj->labels->name . '</a>';
        }
        
        if ( $post_type === 'lecture_episodes' ) {
            $parent_lecture = nfu_get_field( 'parent_lecture' );
            if ( $parent_lecture ) {
                echo ' <span class="mx-2">›</span> ';
                echo '<a href="' . get_permalink( $parent_lecture ) . '" class="hover:text-blue-600">' . get_the_title( $parent_lecture ) . '</a>';
            }
        }
        
        echo ' <span class="mx-2">›</span> ';
        echo '<span>' . get_the_title() . '</span>';
    }
    
    echo '</nav>';
}

/**
 * JSONデータを安全にパースする
 */
function nfu_parse_dialogue_json($json_string) {
    if (empty($json_string)) {
        return array();
    }
    
    // 基本的なクリーンアップ
    $cleaned = trim($json_string);
    
    // 全角文字を半角に変換
    $cleaned = str_replace(
        array(
            '：', '，', '｛', '｝', '［', '］', '　', // 全角文字
            chr(0xE2).chr(0x80).chr(0x9C), // "
            chr(0xE2).chr(0x80).chr(0x9D), // "
            chr(0xE2).chr(0x80).chr(0x98), // '
            chr(0xE2).chr(0x80).chr(0x99), // '
            '…', '—', '–', // 特殊文字
            '『', '』', // 全角角括弧
        ),
        array(
            ':', ',', '{', '}', '[', ']', ' ', // 半角文字
            '"', '"', "'", "'", // 通常のクォート
            '...', '-', '-', // 通常の文字
            '"', '"', // 角括弧をクォートに変換
        ),
        $cleaned
    );
    
    // 改行文字を統一
    $cleaned = str_replace(array("\r\n", "\r"), "\n", $cleaned);
    
    // 制御文字を削除（改行とタブは保持）
    $cleaned = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $cleaned);
    
    // BOMを削除
    $cleaned = str_replace("\xEF\xBB\xBF", '', $cleaned);
    
    // JSONとしてパース
    $parsed = json_decode($cleaned, true);
    
    if (json_last_error() === JSON_ERROR_NONE && is_array($parsed)) {
        return $parsed;
    }
    
    // パースに失敗した場合のデバッグ情報
    if (defined('WP_DEBUG') && WP_DEBUG && current_user_can('administrator')) {
        error_log('NFU JSON Parse Error: ' . json_last_error_msg());
        error_log('NFU JSON Error Code: ' . json_last_error());
        error_log('NFU Original JSON (first 200 chars): ' . substr($json_string, 0, 200));
        error_log('NFU Cleaned JSON (first 200 chars): ' . substr($cleaned, 0, 200));
    }
    
    return array();
}

/**
 * JSONデータのバリデーション
 */
function nfu_validate_dialogue_json($json_string) {
    if (empty($json_string)) {
        return array('valid' => false, 'error' => 'JSONデータが空です');
    }
    
    $cleaned = trim($json_string);
    
    // 基本的なJSON構造チェック
    if (!preg_match('/^\[.*\]$/s', $cleaned) && !preg_match('/^\{.*\}$/s', $cleaned)) {
        return array('valid' => false, 'error' => 'JSONの構造が不正です（配列またはオブジェクトである必要があります）');
    }
    
    // 全角文字の検出
    $fullwidth_chars = array('：', '，', '｛', '｝', '［', '］', '　', 
        chr(0xE2).chr(0x80).chr(0x9C), // "
        chr(0xE2).chr(0x80).chr(0x9D), // "
        chr(0xE2).chr(0x80).chr(0x98), // '
        chr(0xE2).chr(0x80).chr(0x99), // '
        '『', '』'  // 全角角括弧
    );
    $found_fullwidth = array();
    foreach ($fullwidth_chars as $char) {
        if (strpos($cleaned, $char) !== false) {
            $found_fullwidth[] = $char;
        }
    }
    
    if (!empty($found_fullwidth)) {
        return array(
            'valid' => false, 
            'error' => '全角文字が検出されました: ' . implode(', ', $found_fullwidth),
            'suggestion' => '全角文字を半角文字に変換してください'
        );
    }
    
    // JSONとしてパーステスト
    $test_parse = json_decode($cleaned, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        return array(
            'valid' => false, 
            'error' => 'JSONパースエラー: ' . json_last_error_msg(),
            'error_code' => json_last_error()
        );
    }
    
    return array('valid' => true, 'data' => $test_parse);
}

/**
 * 会話データの構造を検証
 */
function nfu_validate_dialogue_structure($dialogues) {
    if (!is_array($dialogues)) {
        return array('valid' => false, 'error' => '会話データが配列ではありません');
    }
    
    $valid_speakers = array('maron', 'ichi', 'hachi', 'jiji', 'daifuku');
    $errors = array();
    
    foreach ($dialogues as $index => $dialogue) {
        if (!is_array($dialogue)) {
            $errors[] = "会話{$index}: 配列ではありません";
            continue;
        }
        
        // speakerフィールドのチェック
        if (!isset($dialogue['speaker']) || empty($dialogue['speaker'])) {
            $errors[] = "会話{$index}: speakerフィールドがありません";
        } elseif (!in_array($dialogue['speaker'], $valid_speakers)) {
            $errors[] = "会話{$index}: 無効なspeaker '{$dialogue['speaker']}'";
        }
        
        // messageフィールドのチェック
        if (!isset($dialogue['message']) || empty($dialogue['message'])) {
            $errors[] = "会話{$index}: messageフィールドがありません";
        }
        
        // positionフィールドのチェック（オプション）
        if (isset($dialogue['position']) && !in_array($dialogue['position'], array('left', 'right'))) {
            $errors[] = "会話{$index}: 無効なposition '{$dialogue['position']}' (leftまたはrightである必要があります)";
        }
    }
    
    if (!empty($errors)) {
        return array('valid' => false, 'errors' => $errors);
    }
    
    return array('valid' => true, 'count' => count($dialogues));
}

/**
 * Get all active professors
 */
function nfu_get_professors() {
    $args = array(
        'post_type' => 'professor',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'professor_is_active',
                'value' => '1',
                'compare' => '='
            )
        ),
        'orderby' => 'menu_order',
        'order' => 'ASC'
    );

    $professors = get_posts($args);
    $professor_data = array();

    foreach ($professors as $professor) {
        $professor_data[] = array(
            'id' => $professor->ID,
            'name' => get_field('professor_name', $professor->ID) ?: $professor->post_title,
            'professor_id' => get_field('professor_id', $professor->ID),
            'position' => get_field('professor_position', $professor->ID),
            'responsibility' => get_field('professor_responsibility', $professor->ID),
            'breed' => get_field('professor_breed', $professor->ID),
            'color_type' => get_field('professor_color_type', $professor->ID),
            'sex_age' => get_field('professor_sex_age', $professor->ID),
            'personality' => get_field('professor_personality', $professor->ID),
            'image' => get_field('professor_image', $professor->ID),
            'lecture_count' => get_field('professor_lecture_count', $professor->ID) ?: 0,
            'favorite_count' => get_field('professor_favorite_count', $professor->ID) ?: 0,
            'url' => get_permalink($professor->ID)
        );
    }

    return $professor_data;
}

/**
 * Get professor by ID
 */
function nfu_get_professor_by_id($professor_id) {
    $args = array(
        'post_type' => 'professor',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'professor_id',
                'value' => $professor_id,
                'compare' => '='
            )
        ),
        'posts_per_page' => 1
    );

    $professors = get_posts($args);
    
    if (!empty($professors)) {
        $professor = $professors[0];
        return array(
            'id' => $professor->ID,
            'name' => get_field('professor_name', $professor->ID) ?: $professor->post_title,
            'professor_id' => get_field('professor_id', $professor->ID),
            'position' => get_field('professor_position', $professor->ID),
            'responsibility' => get_field('professor_responsibility', $professor->ID),
            'breed' => get_field('professor_breed', $professor->ID),
            'color_type' => get_field('professor_color_type', $professor->ID),
            'sex_age' => get_field('professor_sex_age', $professor->ID),
            'personality' => get_field('professor_personality', $professor->ID),
            'image' => get_field('professor_image', $professor->ID),
            'lecture_count' => get_field('professor_lecture_count', $professor->ID) ?: 0,
            'favorite_count' => get_field('professor_favorite_count', $professor->ID) ?: 0,
            'url' => get_permalink($professor->ID)
        );
    }

    return null;
}

/**
 * Update professor favorite count
 */
function nfu_update_professor_favorite_count($professor_id, $increment = true) {
    $args = array(
        'post_type' => 'professor',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'professor_id',
                'value' => $professor_id,
                'compare' => '='
            )
        ),
        'posts_per_page' => 1
    );

    $professors = get_posts($args);
    
    if (!empty($professors)) {
        $professor = $professors[0];
        $current_count = get_field('professor_favorite_count', $professor->ID) ?: 0;
        $new_count = $increment ? $current_count + 1 : max(0, $current_count - 1);
        
        update_field('professor_favorite_count', $new_count, $professor->ID);
        return $new_count;
    }

    return 0;
}