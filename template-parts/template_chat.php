<?php
/**
 * チャット表示テンプレート
 * 
 * @package NekoFreaksUniv
 * 
 * @param array $chat_messages チャットメッセージの配列
 * @param string $title チャットのタイトル
 * @param string $icon_class タイトルのアイコンクラス
 * @param string $empty_message データがない場合のメッセージ
 * @param string $empty_description データがない場合の説明
 */

// パラメータのデフォルト値を設定
$title = $title ?? 'チャット';
$icon_class = $icon_class ?? 'fas fa-comments text-blue-500';
$empty_message = $empty_message ?? 'チャットデータが設定されていません';
$empty_description = $empty_description ?? '管理画面でチャットデータを追加してください';
?>

<?php if (!empty($chat_messages)) : ?>
    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="<?php echo esc_attr($icon_class); ?> mr-3"></i>
            <?php echo esc_html($title); ?>
        </h2>
        
        <div class="character-dialogues bg-gray-100 rounded-2xl p-6 space-y-4 min-h-96">
            <?php foreach ($chat_messages as $index => $message) : 
                $speaker_id = $message['speaker'] ?? 'maron';
                $message_text = $message['message'] ?? '';
                $position = $message['position'] ?? 'left';
                $is_first = $index === 0;
                
                // 講師IDから表示名とアイコンを取得
                $speaker_names = array(
                    'maron' => 'マロン学長',
                    'ichi' => 'いち教授',
                    'hachi' => 'はち助教授',
                    'jiji' => 'ジジ助手',
                    'daifuku' => '大福先代学長',
                );
                
                $speaker_icons = array(
                    'maron' => '🐱',
                    'ichi' => '🐈‍⬛',
                    'hachi' => '🐾',
                    'jiji' => '🐈‍⬛',
                    'daifuku' => '🐱',
                );
                
                $speaker_name = $speaker_names[$speaker_id] ?? $speaker_id;
                $speaker_icon = $speaker_icons[$speaker_id] ?? '🐱';
                $is_left = $position === 'left';
            ?>
                <div class="character-dialogue flex <?php echo $is_left ? 'flex-row' : 'flex-row-reverse'; ?> items-start">
                    <!-- キャラクターアイコン -->
                    <div class="character-icon flex-shrink-0 w-16 h-16 bg-white rounded-full shadow-md flex items-center justify-center <?php echo $is_left ? 'mr-4' : 'ml-4'; ?> overflow-hidden">
                        <?php 
                        $professor_image = nfu_get_professor_image($speaker_id);
                        if ($professor_image) : ?>
                            <img src="<?php echo esc_url($professor_image); ?>" 
                                 alt="<?php echo esc_attr($speaker_name); ?>" 
                                 class="w-full h-full object-cover"
                                 loading="lazy">
                        <?php else : ?>
                            <i class="<?php echo esc_attr($speaker_icon); ?> text-2xl text-gray-600"></i>
                        <?php endif; ?>
                    </div>
                    
                    <!-- 吹き出し -->
                    <div class="dialogue-content <?php echo $is_left ? 'max-w-2xl' : 'max-w-2xl ml-auto'; ?>">
                        <div class="character-name font-bold text-sm mb-2 <?php echo $is_left ? 'text-left' : 'text-right'; ?>">
                            <?php echo esc_html($speaker_name); ?>
                        </div>
                        <div class="dialogue-bubble <?php echo $is_left ? 'custom-green' : 'bg-white'; ?> rounded-2xl shadow-sm p-4 relative border border-gray-200">
                            <!-- 三角形の矢印 -->
                            <div class="bubble-tail absolute w-0 h-0 top-4 
                                 <?php echo $is_left ? 'left-0 -translate-x-2' : 'right-0 translate-x-2'; ?>"
                                 style="border-style: solid; border-width: 8px; 
                                 <?php echo $is_left ? 
                                     'border-color: transparent #06c755 transparent transparent;' : 
                                     'border-color: transparent transparent transparent #ffffff;'; ?>">
                            </div>
                            
                            <div class="dialogue-text <?php echo $is_left ? 'text-black' : 'text-gray-800'; ?> leading-relaxed text-base <?php echo $is_left ? '' : 'text-justify'; ?>">
                                <?php echo wpautop(wp_kses_post($message_text)); ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php else : ?>
    <!-- チャットデータがない場合の表示 -->
    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
            <i class="<?php echo esc_attr($icon_class); ?> mr-3"></i>
            <?php echo esc_html($title); ?>
        </h2>
        
        <div class="text-center py-8">
            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-lightbulb text-2xl text-yellow-600"></i>
            </div>
            <p class="text-gray-600 mb-4">
                <?php echo esc_html($empty_message); ?>
            </p>
            <p class="text-sm text-gray-500">
                <?php echo esc_html($empty_description); ?>
            </p>
        </div>
    </div>
<?php endif; ?>
