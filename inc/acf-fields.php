<?php
/**
 * ACFフィールドグループの設定
 * 
 * @package NekoFreaksUniv
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * ACFフィールドグループを登録
 */
function nfu_register_acf_field_groups() {
    
    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }
    
    // 講座（lectures）用フィールド
    acf_add_local_field_group( array(
        'key' => 'group_lectures',
        'title' => '講座情報',
        'fields' => array(
            array(
                'key' => 'field_related_paper',
                'label' => '関連論文',
                'name' => 'related_paper',
                'type' => 'post_object',
                'post_type' => array( 'papers' ),
                'return_format' => 'object',
                'ui' => 1,
            ),
            array(
                'key' => 'field_lecture_status',
                'label' => '講座ステータス',
                'name' => 'lecture_status',
                'type' => 'select',
                'choices' => array(
                    '開講中' => '開講中',
                    '完結' => '完結',
                    '準備中' => '準備中',
                ),
                'default_value' => '準備中',
            ),
            array(
                'key' => 'field_main_professor',
                'label' => '講座責任講師',
                'name' => 'main_professor',
                'type' => 'select',
                'instructions' => 'この講座の専門分野を担当する講師（マロン学長は全講座で生徒役として固定）',
                'choices' => array(
                    'ichi' => 'いち教授（行動観察・高齢猫専門）',
                    'hachi' => 'はち助教授（環境・トイレ専門）',
                    'jiji' => 'ジジ助手（問題行動・若猫専門）',
                    'daifuku' => '大福先代学長（健康・ケア専門）',
                ),
                'default_value' => 'ichi',
            ),
            array(
                'key' => 'field_navigator',
                'label' => 'ナビゲーター',
                'name' => 'navigator',
                'type' => 'select',
                'instructions' => '生徒役として質問・進行する講師（通常はマロン学長で固定）',
                'choices' => array(
                    'maron' => 'マロン学長（生徒役・質問担当）',
                ),
                'default_value' => 'maron',
                'disabled' => 1,
            ),
            array(
                'key' => 'field_lecture_overview',
                'label' => '講座概要',
                'name' => 'lecture_overview',
                'type' => 'textarea',
                'rows' => 4,
            ),
            array(
                'key' => 'field_total_episodes',
                'label' => '全話数',
                'name' => 'total_episodes',
                'type' => 'number',
                'default_value' => 5,
                'min' => 1,
                'max' => 10,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'lectures',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ) );
    
    // 講座回（lecture_episodes）用フィールド
    acf_add_local_field_group( array(
        'key' => 'group_lecture_episodes',
        'title' => '講座回情報',
        'fields' => array(
            array(
                'key' => 'field_episode_number',
                'label' => '話数',
                'name' => 'episode_number',
                'type' => 'number',
                'instructions' => '第何回の講座か（1〜5）',
                'min' => 1,
                'max' => 10,
                'default_value' => 1,
            ),
            array(
                'key' => 'field_parent_lecture',
                'label' => '親講座',
                'name' => 'parent_lecture',
                'type' => 'post_object',
                'post_type' => array( 'lectures' ),
                'return_format' => 'id',
                'ui' => 1,
                'required' => 1,
            ),
            array(
                'key' => 'field_guest_professor',
                'label' => '特別ゲスト講師',
                'name' => 'guest_professor',
                'type' => 'select',
                'instructions' => 'この回に特別参加する講師（責任講師以外で、特別な視点を提供する場合のみ）',
                'choices' => array(
                    '' => 'なし（責任講師のみ）',
                    'ichi' => 'いち教授（行動観察・高齢猫専門）',
                    'hachi' => 'はち助教授（環境・トイレ専門）',
                    'jiji' => 'ジジ助手（問題行動・若猫専門）',
                    'daifuku' => '大福先代学長（健康・ケア専門）',
                ),
                'allow_null' => 1,
            ),
            array(
                'key' => 'field_key_points',
                'label' => 'ポイント',
                'name' => 'key_points',
                'type' => 'textarea',
                'instructions' => '重要なポイントを改行区切りで入力',
                'rows' => 5,
            ),
            array(
                'key' => 'field_dialogue_json',
                'label' => '冒頭会話データ',
                'name' => 'dialogue_json',
                'type' => 'textarea',
                'instructions' => 'JSON形式で冒頭会話データを入力',
                'rows' => 10,
            ),
            array(
                'key' => 'field_ending_dialogue_json',
                'label' => 'まとめ会話データ',
                'name' => 'ending_dialogue_json',
                'type' => 'textarea',
                'instructions' => 'JSON形式で今回のまとめ会話データを入力',
                'rows' => 10,
            ),
            array(
                'key' => 'field_next_episode_preview',
                'label' => '次回予告',
                'name' => 'next_episode_preview',
                'type' => 'textarea',
                'instructions' => '次回エピソードの予告文を入力してください。空の場合はデフォルトメッセージが表示されます。',
                'rows' => 3,
                'placeholder' => '例：第4回：トラブル対策編 - 粗相の原因と対処法を詳しく解説します',
            ),
            array(
                'key' => 'field_next_release_date',
                'label' => '次回公開予定日',
                'name' => 'next_release_date',
                'type' => 'date_picker',
                'instructions' => '次回エピソードの公開予定日（空の場合は「金曜20:00公開」と表示）',
                'display_format' => 'Y年m月d日',
                'return_format' => 'Y-m-d',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'lecture_episodes',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ) );
    
    // 論文要約（papers）用フィールド
    acf_add_local_field_group( array(
        'key' => 'group_papers',
        'title' => '論文情報',
        'fields' => array(
            array(
                'key' => 'field_original_title',
                'label' => '原題',
                'name' => 'original_title',
                'type' => 'text',
                'instructions' => '論文の原題（英語）',
            ),
            array(
                'key' => 'field_authors',
                'label' => '著者',
                'name' => 'authors',
                'type' => 'textarea',
                'instructions' => '著者名（複数の場合は改行区切り）',
                'rows' => 3,
            ),
            array(
                'key' => 'field_published_year',
                'label' => '発表年',
                'name' => 'published_year',
                'type' => 'number',
                'min' => 1900,
                'max' => 2050,
            ),
            array(
                'key' => 'field_journal',
                'label' => '掲載誌',
                'name' => 'journal',
                'type' => 'text',
            ),
            array(
                'key' => 'field_doi_link',
                'label' => '論文リンク',
                'name' => 'doi_link',
                'type' => 'url',
                'instructions' => 'DOIまたは論文へのリンク',
            ),
            array(
                'key' => 'field_summary_points',
                'label' => '要点',
                'name' => 'summary_points',
                'type' => 'textarea',
                'instructions' => '論文の要点を改行区切りで入力',
                'rows' => 8,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'papers',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ) );
    
    // 豆知識（tips）用フィールド
    acf_add_local_field_group( array(
        'key' => 'group_tips',
        'title' => '豆知識情報',
        'fields' => array(
            array(
                'key' => 'field_tip_category',
                'label' => '豆知識カテゴリ',
                'name' => 'tip_category',
                'type' => 'select',
                'choices' => array(
                    'health' => '健康',
                    'behavior' => '行動',
                    'care' => 'ケア',
                    'trivia' => 'トリビア',
                ),
            ),
            array(
                'key' => 'field_related_lecture',
                'label' => '関連講座',
                'name' => 'related_lecture',
                'type' => 'post_object',
                'post_type' => array( 'lectures' ),
                'return_format' => 'object',
                'ui' => 1,
                'allow_null' => 1,
            ),
            array(
                'key' => 'field_related_episode',
                'label' => '関連講座回',
                'name' => 'related_episode',
                'type' => 'post_object',
                'post_type' => array( 'lecture_episodes' ),
                'return_format' => 'object',
                'ui' => 1,
                'allow_null' => 1,
                'instructions' => '関連する講座回を選択してください',
            ),
            array(
                'key' => 'field_tip_chat_data',
                'label' => 'チャット形式データ',
                'name' => 'tip_chat_data',
                'type' => 'textarea',
                'instructions' => 'JSON形式でチャット形式のデータを入力してください。例：{"messages": [{"speaker": "マロン学長", "message": "こんにちは！"}, {"speaker": "いち教授", "message": "今日は豆知識をお話しします"}]}',
                'rows' => 10,
            ),
            array(
                'key' => 'field_tip_source',
                'label' => '情報源',
                'name' => 'tip_source',
                'type' => 'text',
                'instructions' => '参考文献や情報源',
            ),
            array(
                'key' => 'field_tip_difficulty',
                'label' => '難易度',
                'name' => 'tip_difficulty',
                'type' => 'select',
                'choices' => array(
                    'beginner' => '初級',
                    'intermediate' => '中級',
                    'advanced' => '上級',
                ),
                'default_value' => 'beginner',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'tips',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ) );
    
    // グッズ（goods）用フィールド
    acf_add_local_field_group( array(
        'key' => 'group_goods',
        'title' => 'グッズ情報',
        'fields' => array(
            array(
                'key' => 'field_price',
                'label' => '価格',
                'name' => 'price',
                'type' => 'number',
                'prepend' => '¥',
                'min' => 0,
            ),
            array(
                'key' => 'field_shop_url',
                'label' => '購入リンク',
                'name' => 'shop_url',
                'type' => 'url',
            ),
            array(
                'key' => 'field_is_recommended',
                'label' => 'おすすめ商品',
                'name' => 'is_recommended',
                'type' => 'true_false',
                'ui' => 1,
            ),
            array(
                'key' => 'field_goods_features',
                'label' => '特徴',
                'name' => 'goods_features',
                'type' => 'textarea',
                'instructions' => '商品の特徴を改行区切りで入力',
                'rows' => 4,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'goods',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
    ) );
    
    // 講師（professor）用フィールド
    acf_add_local_field_group( array(
        'key' => 'group_professors',
        'title' => '講師管理',
        'fields' => array(
            array(
                'key' => 'field_professor_name',
                'label' => '講師名',
                'name' => 'professor_name',
                'type' => 'text',
                'required' => 1,
            ),
            array(
                'key' => 'field_professor_id',
                'label' => '講師ID',
                'name' => 'professor_id',
                'type' => 'text',
                'required' => 1,
                'instructions' => '英数字のみ（例：maron, ichi, hachi）',
            ),
            array(
                'key' => 'field_professor_position',
                'label' => '役職',
                'name' => 'professor_position',
                'type' => 'text',
                'default_value' => '教授',
            ),
            array(
                'key' => 'field_professor_responsibility',
                'label' => '担当・責任',
                'name' => 'professor_responsibility',
                'type' => 'text',
                'instructions' => '例：プログラミング基礎、Webデザインなど',
            ),
            array(
                'key' => 'field_professor_breed',
                'label' => '猫種',
                'name' => 'professor_breed',
                'type' => 'text',
                'instructions' => '例：スコティッシュフォールド、アメリカンショートヘアなど',
            ),
            array(
                'key' => 'field_professor_color_type',
                'label' => '毛色タイプ',
                'name' => 'professor_color_type',
                'type' => 'text',
                'instructions' => '例：レッドタビー、黒、白黒ハチワレなど',
            ),
            array(
                'key' => 'field_professor_sex_age',
                'label' => '年齢/性別',
                'name' => 'professor_sex_age',
                'type' => 'text',
                'instructions' => '例：3歳♂、5歳♀など',
            ),
            array(
                'key' => 'field_professor_birthday',
                'label' => '誕生日',
                'name' => 'professor_birthday',
                'type' => 'date_picker',
                'display_format' => 'Y年n月j日',
                'return_format' => 'Y年n月j日',
            ),
            array(
                'key' => 'field_professor_arrival',
                'label' => 'お迎え日',
                'name' => 'professor_arrival',
                'type' => 'date_picker',
                'display_format' => 'Y年n月j日',
                'return_format' => 'Y年n月j日',
            ),
            array(
                'key' => 'field_professor_origin',
                'label' => '出身',
                'name' => 'professor_origin',
                'type' => 'text',
                'instructions' => '例：東京都、神奈川県など',
            ),
            array(
                'key' => 'field_professor_personality',
                'label' => '性格',
                'name' => 'professor_personality',
                'type' => 'textarea',
                'rows' => 4,
                'instructions' => '講師の性格や特徴を入力してください',
            ),
            array(
                'key' => 'field_professor_features',
                'label' => '特徴・エピソード',
                'name' => 'professor_features',
                'type' => 'textarea',
                'rows' => 6,
                'instructions' => '講師の特徴や面白いエピソードを入力してください',
            ),
            array(
                'key' => 'field_professor_lecture_role',
                'label' => '講義での役割',
                'name' => 'professor_lecture_role',
                'type' => 'textarea',
                'rows' => 3,
                'instructions' => '講義での役割や説明を入力してください',
            ),
            array(
                'key' => 'field_professor_sample_lines',
                'label' => 'セリフ例',
                'name' => 'professor_sample_lines',
                'type' => 'textarea',
                'rows' => 8,
                'instructions' => '講師の特徴的なセリフを改行区切りで入力してください',
            ),
            array(
                'key' => 'field_professor_playlist',
                'label' => 'YouTubeプレイリスト',
                'name' => 'professor_playlist',
                'type' => 'url',
                'instructions' => '講師関連のYouTubeプレイリストURLを入力してください',
            ),
            array(
                'key' => 'field_professor_image',
                'label' => '講師画像',
                'name' => 'professor_image',
                'type' => 'image',
                'return_format' => 'url',
            ),
            array(
                'key' => 'field_professor_lecture_count',
                'label' => '講座数',
                'name' => 'professor_lecture_count',
                'type' => 'number',
                'min' => 0,
                'default_value' => 0,
            ),
            array(
                'key' => 'field_professor_favorite_count',
                'label' => 'お気に入り数',
                'name' => 'professor_favorite_count',
                'type' => 'number',
                'min' => 0,
                'default_value' => 0,
                'readonly' => 1,
            ),
            array(
                'key' => 'field_professor_is_active',
                'label' => 'アクティブ',
                'name' => 'professor_is_active',
                'type' => 'true_false',
                'default_value' => 1,
                'ui' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'professor',
                ),
            ),
        ),
        'active' => true,
        'description' => '講師情報の管理',
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
    ) );
}

// ACFフィールドグループを登録
add_action( 'acf/init', 'nfu_register_acf_field_groups' );

/**
 * ACFの値を取得するヘルパー関数
 */
function nfu_get_field( $field_name, $post_id = null ) {
    if ( function_exists( 'get_field' ) ) {
        return get_field( $field_name, $post_id );
    }
    return get_post_meta( $post_id ?: get_the_ID(), $field_name, true );
}

/**
 * 講座の進捗を計算
 */
function nfu_get_lecture_progress( $lecture_id ) {
    $total_episodes = nfu_get_field( 'total_episodes', $lecture_id ) ?: 5;
    
    $args = array(
        'post_type' => 'lecture_episodes',
        'meta_query' => array(
            array(
                'key' => 'parent_lecture',
                'value' => $lecture_id,
                'compare' => '='
            )
        ),
        'post_status' => 'publish'
    );
    
    $query = new WP_Query( $args );
    $published_episodes = $query->found_posts;
    
    $progress = ( $published_episodes / $total_episodes ) * 100;
    
    return array(
        'published' => $published_episodes,
        'total' => $total_episodes,
        'percentage' => round( $progress )
    );
}