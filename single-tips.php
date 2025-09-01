<?php
/**
 * 豆知識詳細ページテンプレート
 * 
 * @package NekoFreaksUniv
 */

get_header(); ?>

<main class="tip-detail-page">
    <!-- パンくずリスト -->
    <div class="container mx-auto px-4 py-4">
        <?php nfu_breadcrumb(); ?>
    </div>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
        // 豆知識情報を取得
        $tip_category = nfu_get_field('tip_category');
        $related_lecture = nfu_get_field('related_lecture');
        $related_episode = nfu_get_field('related_episode');
        $tip_chat_data = nfu_get_field('tip_chat_data');
        $tip_source = nfu_get_field('tip_source');
        $tip_difficulty = nfu_get_field('tip_difficulty');
        
        // カテゴリ名を取得
        $category_names = array(
            'health' => '健康',
            'behavior' => '行動',
            'care' => 'ケア',
            'trivia' => 'トリビア',
        );
        
        // 難易度名を取得
        $difficulty_names = array(
            'beginner' => '初級',
            'intermediate' => '中級',
            'advanced' => '上級',
        );
        
        // チャットデータをパース
        $chat_messages = array();
        if ($tip_chat_data) {
            $parsed_data = json_decode($tip_chat_data, true);
            if ($parsed_data) {
                // messages配列がある場合と、直接配列の場合の両方に対応
                if (isset($parsed_data['messages'])) {
                    $chat_messages = $parsed_data['messages'];
                } elseif (is_array($parsed_data)) {
                    $chat_messages = $parsed_data;
                }
            }
        }
        
        // デバッグ情報（開発時のみ表示）
        if (WP_DEBUG) {
            echo '<!-- DEBUG: tip_chat_data = ' . esc_html($tip_chat_data) . ' -->';
            echo '<!-- DEBUG: chat_messages count = ' . count($chat_messages) . ' -->';
        }
    ?>
    
    <!-- ヘッダーセクション -->
    <section class="tip-header bg-gradient-to-br from-yellow-100 to-orange-100 py-12">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <div class="mb-4">
                    <?php if ($tip_category) : ?>
                        <span class="inline-block bg-yellow-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                            <?php echo esc_html($category_names[$tip_category]); ?>
                        </span>
                    <?php endif; ?>
                    <?php if ($tip_difficulty) : ?>
                        <span class="inline-block bg-blue-500 text-white px-4 py-2 rounded-full text-sm font-semibold ml-2">
                            <?php echo esc_html($difficulty_names[$tip_difficulty]); ?>
                        </span>
                    <?php endif; ?>
                </div>
                
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-800 mb-6">
                    <i class="fas fa-lightbulb text-yellow-500 mr-4"></i>
                    <?php the_title(); ?>
                </h1>
                
                <div class="max-w-3xl mx-auto">
                    <p class="text-lg text-gray-600 mb-6">
                        <?php echo get_the_excerpt(); ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- メインコンテンツ -->
    <section class="tip-content py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                <!-- 左カラム：チャット形式コンテンツ -->
                <div class="lg:col-span-2">
                    
                    <!-- チャット形式の豆知識 -->
                    <?php if (!empty($chat_messages)) : ?>
                        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <i class="fas fa-comments text-blue-500 mr-3"></i>
                                豆知識チャット
                            </h2>
                            
                            <div class="character-dialogues bg-gray-100 rounded-2xl p-6 space-y-4 min-h-96">
                                <?php foreach ($chat_messages as $index => $message) : 
                                    $speaker_id = $message['speaker'] ?? 'maron';
                                    $message_text = $message['message'] ?? '';
                                    $position = $message['position'] ?? 'left';
                                    $is_first = $index === 0;
                                    
                                    // 講師IDから表示名とアイコンを取得（講座回と同様）
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
                                                     class="w-full h-full object-cover">
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
                                                    <?php echo wpautop(esc_html($message_text)); ?>
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
                                <i class="fas fa-comments text-blue-500 mr-3"></i>
                                豆知識チャット
                            </h2>
                            
                            <div class="text-center py-8">
                                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-lightbulb text-2xl text-yellow-600"></i>
                                </div>
                                <p class="text-gray-600 mb-4">
                                    チャット形式の豆知識データが設定されていません。
                                </p>
                                <p class="text-sm text-gray-500">
                                    管理画面で「チャット形式データ」フィールドにJSONデータを入力してください。
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- 通常のコンテンツ -->
                    <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-info-circle text-green-500 mr-3"></i>
                            詳細情報
                        </h2>
                        
                        <div class="prose tip-content max-w-none">
                            <?php the_content(); ?>
                        </div>
                    </div>
                    
                    <!-- 情報源 -->
                    <?php if ($tip_source) : ?>
                        <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-6 border-l-4 border-blue-400">
                            <h3 class="text-lg font-bold text-gray-800 mb-3">
                                <i class="fas fa-book text-blue-600 mr-2"></i>
                                情報源・参考文献
                            </h3>
                            <p class="text-gray-700">
                                <?php echo esc_html($tip_source); ?>
                            </p>
                        </div>
                    <?php endif; ?>
                    
                </div>
                
                <!-- 右カラム：サイドバー -->
                <div class="lg:col-span-1">
                    <div class="space-y-6">
                        
                        <!-- 豆知識情報 -->
                        <div class="bg-white rounded-xl shadow-lg p-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                <i class="fas fa-lightbulb text-yellow-500 mr-3"></i>
                                豆知識情報
                            </h3>
                            
                            <div class="space-y-4">
                                <?php if ($tip_category) : ?>
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-yellow-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-tag text-yellow-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">カテゴリ</p>
                                            <p class="font-semibold text-gray-800"><?php echo esc_html($category_names[$tip_category]); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($tip_difficulty) : ?>
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                            <i class="fas fa-star text-blue-600"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-500">難易度</p>
                                            <p class="font-semibold text-gray-800"><?php echo esc_html($difficulty_names[$tip_difficulty]); ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                        <i class="fas fa-calendar text-green-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">公開日</p>
                                        <p class="font-semibold text-gray-800"><?php echo get_the_date('Y年n月j日'); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- 関連講座・講座回 -->
                        <?php if ($related_lecture || $related_episode) : ?>
                            <div class="bg-white rounded-xl shadow-lg p-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-link text-purple-500 mr-3"></i>
                                    関連コンテンツ
                                </h3>
                                
                                <div class="space-y-4">
                                    <?php if ($related_lecture) : ?>
                                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                            <h4 class="font-semibold text-gray-800 mb-2">
                                                <i class="fas fa-book text-purple-600 mr-2"></i>
                                                関連講座
                                            </h4>
                                            <p class="text-sm text-gray-600 mb-3">
                                                <?php echo esc_html($related_lecture->post_title); ?>
                                            </p>
                                            <a href="<?php echo get_permalink($related_lecture->ID); ?>" 
                                               class="inline-block bg-purple-600 text-white px-4 py-2 rounded text-sm hover:bg-purple-700 transition-colors">
                                                講座を見る
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($related_episode) : ?>
                                        <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                            <h4 class="font-semibold text-gray-800 mb-2">
                                                <i class="fas fa-play text-blue-600 mr-2"></i>
                                                関連講座回
                                            </h4>
                                            <p class="text-sm text-gray-600 mb-3">
                                                <?php echo esc_html($related_episode->post_title); ?>
                                            </p>
                                            <a href="<?php echo get_permalink($related_episode->ID); ?>" 
                                               class="inline-block bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700 transition-colors">
                                                講座回を見る
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <!-- 豆知識一覧へのリンク -->
                        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg p-6 border border-yellow-200">
                            <h3 class="font-bold text-gray-800 mb-3">
                                <i class="fas fa-lightbulb text-yellow-600 mr-2"></i>
                                他の豆知識も見る
                            </h3>
                            <p class="text-sm text-gray-700 mb-4">
                                猫に関する豆知識をたくさんご紹介しています。
                            </p>
                            <a href="<?php echo get_post_type_archive_link('tips'); ?>" 
                               class="block w-full text-center bg-yellow-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-yellow-700 transition-colors">
                                <i class="fas fa-arrow-right mr-2"></i>
                                豆知識バンクへ
                            </a>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <?php endwhile; endif; ?>
</main>

<style>
.tip-detail-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

/* LINE風チャットスタイル */
.character-dialogue {
    opacity: 0;
    animation: fadeInUp 0.6s ease forwards;
}

.character-dialogue:nth-child(1) { animation-delay: 0.1s; }
.character-dialogue:nth-child(2) { animation-delay: 0.2s; }
.character-dialogue:nth-child(3) { animation-delay: 0.3s; }
.character-dialogue:nth-child(4) { animation-delay: 0.4s; }
.character-dialogue:nth-child(5) { animation-delay: 0.5s; }
.character-dialogue:nth-child(6) { animation-delay: 0.6s; }
.character-dialogue:nth-child(7) { animation-delay: 0.7s; }
.character-dialogue:nth-child(8) { animation-delay: 0.8s; }
.character-dialogue:nth-child(9) { animation-delay: 0.9s; }
.character-dialogue:nth-child(10) { animation-delay: 1.0s; }

/* LINE風の吹き出しスタイル */
.dialogue-bubble {
    max-width: 80%;
    word-wrap: break-word;
}

.dialogue-bubble.custom-green {
    background-color: #06c755;
    box-shadow: 0 2px 8px rgba(6, 199, 85, 0.3);
}

.dialogue-bubble.bg-white {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

/* 右側の吹き出しを右寄せにする */
.dialogue-content.ml-auto {
    margin-left: auto;
    text-align: right;
}

.dialogue-content.ml-auto .dialogue-bubble {
    margin-left: auto;
}

/* チャット背景のLINE風スタイル */
.character-dialogues {
    background: linear-gradient(135deg, #f0f2f5 0%, #e4e6ea 100%);
    position: relative;
}

.character-dialogues::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 80%, rgba(74, 222, 128, 0.05) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(59, 130, 246, 0.05) 0%, transparent 50%);
    pointer-events: none;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.sticky {
    position: sticky;
    top: 2rem;
}

@media (max-width: 1024px) {
    .sticky {
        position: static;
    }
}
</style>

<?php get_footer(); ?>
