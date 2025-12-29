<?php
/**
 * 講座回詳細ページテンプレート
 * 
 * @package NekoFreaksUniv
 */

get_header();

// エピソード情報の取得
$episode_number = nfu_get_field('episode_number');
$parent_lecture = nfu_get_field('parent_lecture');
$guest_professor = nfu_get_field('guest_professor');
$key_points = nfu_get_field('key_points');
$dialogue_json = nfu_get_field('dialogue_json');
$ending_dialogue_json = nfu_get_field('ending_dialogue_json');
$next_episode_preview = nfu_get_field('next_episode_preview');

// 親講座の情報を取得
if ($parent_lecture) {
    $lecture_title = get_the_title($parent_lecture);
    $lecture_url = get_permalink($parent_lecture);
    $main_professor = nfu_get_field('main_professor', $parent_lecture);
    $total_episodes = nfu_get_field('total_episodes', $parent_lecture) ?: 5;
    $related_paper = nfu_get_field('related_paper', $parent_lecture);
} else {
    $lecture_title = '';
    $lecture_url = '#';
    $main_professor = 'maron';
    $total_episodes = 5;
    $related_paper = null;
}

// 講師情報の取得
$professor_data = array(
    'maron' => array('name' => 'マロン学長', 'color' => 'professor-maron', 'icon' => 'fas fa-cat'),
    'ichi' => array('name' => 'いち教授', 'color' => 'professor-ichi', 'icon' => 'fas fa-cat'), 
    'hachi' => array('name' => 'はち助教授', 'color' => 'professor-hachi', 'icon' => 'fas fa-paw'),
    'jiji' => array('name' => 'ジジ助手', 'color' => 'professor-jiji', 'icon' => 'fas fa-cat'),
    'daifuku' => array('name' => '大福先代学長', 'color' => 'professor-daifuku', 'icon' => 'fas fa-cat'),
);

$main_prof_info = $professor_data[$main_professor] ?? $professor_data['maron'];
$guest_prof_info = $guest_professor ? ($professor_data[$guest_professor] ?? null) : null;

// 冒頭会話データをパース（改善版）
$dialogues = array();
$json_validation = array();

if ($dialogue_json) {
    // 新しいJSON処理関数を使用
    $dialogues = nfu_parse_dialogue_json($dialogue_json);
    
    // バリデーション実行
    $json_validation = nfu_validate_dialogue_json($dialogue_json);
    
    if ($json_validation['valid']) {
        $structure_validation = nfu_validate_dialogue_structure($dialogues);
        if (!$structure_validation['valid']) {
            // 構造エラーの場合
            if (defined('WP_DEBUG') && WP_DEBUG && current_user_can('administrator')) {
                error_log('NFU Dialogue Structure Error: ' . json_encode($structure_validation));
            }
        }
    } else {
        // JSONエラーの場合
        if (defined('WP_DEBUG') && WP_DEBUG && current_user_can('administrator')) {
            error_log('NFU JSON Validation Error: ' . json_encode($json_validation));
        }
    }
} else {
    // デバッグ情報
    if (defined('WP_DEBUG') && WP_DEBUG && current_user_can('administrator')) {
        echo '<!-- dialogue_jsonフィールドが空です -->';
    }
}

// ラスト会話データをパース
$ending_dialogues = array();
$ending_json_validation = array();

if ($ending_dialogue_json) {
    // 新しいJSON処理関数を使用
    $ending_dialogues = nfu_parse_dialogue_json($ending_dialogue_json);
    
    // バリデーション実行
    $ending_json_validation = nfu_validate_dialogue_json($ending_dialogue_json);
    
    if ($ending_json_validation['valid']) {
        $ending_structure_validation = nfu_validate_dialogue_structure($ending_dialogues);
        if (!$ending_structure_validation['valid']) {
            // 構造エラーの場合
            if (defined('WP_DEBUG') && WP_DEBUG && current_user_can('administrator')) {
                error_log('NFU Ending Dialogue Structure Error: ' . json_encode($ending_structure_validation));
            }
        }
    } else {
        // JSONエラーの場合
        if (defined('WP_DEBUG') && WP_DEBUG && current_user_can('administrator')) {
            error_log('NFU Ending JSON Validation Error: ' . json_encode($ending_json_validation));
        }
    }
} else {
    // デバッグ情報
    if (defined('WP_DEBUG') && WP_DEBUG && current_user_can('administrator')) {
        echo '<!-- ending_dialogue_jsonフィールドが空です -->';
    }
}

// ポイントを配列に変換
$points = array();
if ($key_points) {
    $points = array_filter(array_map('trim', explode("\n", $key_points)));
}
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<main id="main" class="site-main">
    <div class="container mx-auto px-4 py-8">
        <?php nfu_breadcrumb(); ?>
        
        <!-- エピソードヘッダー -->
        <div class="episode-header bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-lg overflow-hidden shadow-xl mb-8">
            <div class="p-8">
                <!-- 講座・エピソード情報 -->
                <div class="mb-4">
                    <div class="flex items-center text-sm text-white/80 mb-2">
                        <a href="<?php echo $lecture_url; ?>" class="hover:text-white transition-colors">
                            <?php echo esc_html($lecture_title); ?>
                        </a>
                        <span class="mx-2">›</span>
                        <span>第<?php echo $episode_number; ?>回</span>
                    </div>
                    <h1 class="text-3xl lg:text-4xl font-bold mb-4 leading-tight">
                        第<?php echo $episode_number; ?>回: <?php the_title(); ?>
                    </h1>
                </div>
                
                <!-- 講師情報 -->
                <div class="flex flex-wrap gap-4 mb-4">
                    <div class="professor-info flex items-center">
                        <div class="professor-icon w-10 h-10 bg-white/20 rounded-full flex items-center justify-center mr-3">
                            <i class="<?php echo $main_prof_info['icon']; ?> text-lg"></i>
                        </div>
                        <div>
                            <p class="font-semibold"><?php echo esc_html($main_prof_info['name']); ?></p>
                            <p class="text-white/80 text-sm">メイン講師</p>
                        </div>
                    </div>
                    
                    <?php if ($guest_prof_info) : ?>
                        <div class="professor-info flex items-center">
                            <div class="professor-icon w-10 h-10 bg-white/20 rounded-full flex items-center justify-center mr-3">
                                <i class="<?php echo $guest_prof_info['icon']; ?> text-lg"></i>
                            </div>
                            <div>
                                <p class="font-semibold"><?php echo esc_html($guest_prof_info['name']); ?></p>
                                <p class="text-white/80 text-sm">ゲスト講師</p>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- エピソードナビゲーション -->
                <div class="episode-nav bg-white/10 rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium">講座の進行</span>
                        <span class="text-sm">第<?php echo $episode_number; ?>回 / 全<?php echo $total_episodes; ?>回</span>
                    </div>
                    <div class="flex space-x-1">
                        <?php for ($i = 1; $i <= $total_episodes; $i++) : ?>
                            <div class="flex-1 h-2 rounded-full <?php echo $i <= $episode_number ? 'bg-white' : 'bg-white/30'; ?>"></div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- メインコンテンツ -->
            <div class="lg:col-span-3 space-y-8">
                <!-- 冒頭会話 -->
                <?php
                $chat_messages = array();
                if (!empty($dialogues)) {
                    foreach ($dialogues as $dialogue) {
                        $chat_messages[] = array(
                            'speaker' => $dialogue['speaker'] ?? 'maron',
                            'message' => $dialogue['message'] ?? '',
                            'position' => $dialogue['position'] ?? 'left'
                        );
                    }
                }
                
                $title = '冒頭会話';
                $icon_class = 'fas fa-comments text-blue-600';
                $empty_message = '冒頭会話データが設定されていません';
                $empty_description = '管理画面でJSON形式の会話データを追加してください';
                
                include get_template_directory() . '/template-parts/template_chat.php';
                ?>
                
                <!-- 今回のポイント -->
                <?php if (!empty($points)) : ?>
                    <section class="key-points bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-key text-yellow-600 mr-2"></i>
                            今回のポイント
                        </h2>
                        <div class="points-grid grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php foreach ($points as $index => $point) : ?>
                                <div class="point-card bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg p-4 border-l-4 border-yellow-400">
                                    <div class="flex items-start">
                                        <span class="point-number flex-shrink-0 w-6 h-6 bg-yellow-400 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">
                                            <?php echo $index + 1; ?>
                                        </span>
                                        <p class="text-gray-700 text-sm leading-relaxed">
                                            <?php echo esc_html($point); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>
                
                <!-- マロン学長からのお願い -->
                <section class="maron-request bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-heart text-pink-600 mr-2"></i>
                        マロン学長からのお願い
                    </h2>
                    <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                        <!-- 左側：画像 -->
                        <div class="flex-shrink-0 rounded-full overflow-hidden" style="width: 5rem; height: 5rem;">
                            <img src="<?php echo NFU_THEME_URI . '/assets/images/maron_please.png'; ?>" 
                                 alt="マロン学長からのお願い" 
                                 class="object-cover rounded-full" style="width: 5rem; height: 5rem;">
                        </div>
                        <!-- 右側：文章 -->
                        <div class="flex-1">
                            <p class="text-gray-700 leading-relaxed text-base md:text-lg">
                                僕たち「ネコフリークス大学」は<strong>架空の大学</strong>で、
                                僕や教授たちは実在の猫をモデルにした<strong>キャラクター</strong>なんだ！<br>
                                実際には、猫好きの飼い主さんがAIを使って英語の論文を読んで勉強して、
                                僕たちが案内する形でみんなにシェアしているんだよ。<br><br>
                                <span class="inline-block bg-yellow-100 border-l-4 border-yellow-500 px-4 py-2 rounded">
                                    <strong>だから、獣医さんや専門家じゃないから、
                                    猫ちゃんの健康で心配なことがあったら、必ず動物病院で診てもらってね！</strong>
                                </span>
                            </p>
                        </div>
                    </div>
                </section>
                
                <!-- 本文コンテンツ -->
                <section class="episode-content bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-file-text text-green-600 mr-2"></i>
                        勉強したことのまとめ
                    </h2>
                    <div class="prose prose-lg max-w-none episode-content">
                        <?php the_content(); ?>
                    </div>
                </section>
                
                <!-- 今回のまとめ -->
                <?php
                $chat_messages = array();
                if (!empty($ending_dialogues)) {
                    foreach ($ending_dialogues as $dialogue) {
                        $chat_messages[] = array(
                            'speaker' => $dialogue['speaker'] ?? 'maron',
                            'message' => $dialogue['message'] ?? '',
                            'position' => $dialogue['position'] ?? 'left'
                        );
                    }
                }
                
                $title = '今回のまとめ';
                $icon_class = 'fas fa-comments text-purple-600';
                $empty_message = 'まとめ会話データが設定されていません';
                $empty_description = '管理画面でJSON形式のまとめ会話データを追加してください';
                
                include get_template_directory() . '/template-parts/template_chat.php';
                ?>
                
                <!-- 次回予告 -->
                <?php if ($next_episode_preview && $episode_number < $total_episodes) : ?>
                    <section class="next-episode-preview bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg p-6 border border-indigo-200">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-forward text-indigo-600 mr-2"></i>
                            次回予告
                        </h2>
                        <div class="preview-content">
                            <div class="flex items-center mb-3">
                                <span class="episode-badge bg-indigo-600 text-white px-3 py-1 rounded-full text-sm font-semibold mr-3">
                                    第<?php echo $episode_number + 1; ?>回
                                </span>
                                <span class="text-gray-600 text-sm">近日配信予定</span>
                            </div>
                            <div class="preview-text bg-white rounded-lg p-4 border border-indigo-200">
                                <?php echo wpautop(esc_html($next_episode_preview)); ?>
                            </div>
                        </div>
                    </section>
                <?php endif; ?>
                
                <!-- エピソード完了セクション -->
                <section class="episode-completion bg-white rounded-lg shadow-md p-6 mt-8">
                    <div class="completion-content text-center">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">
                            <i class="fas fa-graduation-cap text-purple-600 mr-2"></i>
                            第<?php echo $episode_number; ?>回の学習完了
                        </h3>
                        
                        <p class="text-gray-600 mb-6">
                            このエピソードの内容は理解できましたか？<br>
                            完了ボタンを押すと学習進捗が記録されます。
                        </p>
                        
                        <div class="completion-status mb-6" id="completion-status-<?php echo get_the_ID(); ?>">
                            <!-- JavaScriptで動的に更新 -->
                        </div>
                        
                        <button 
                            class="episode-complete-button bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white font-bold py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 shadow-lg"
                            data-episode-id="<?php echo esc_attr(get_the_ID()); ?>"
                            data-episode-number="<?php echo esc_attr($episode_number); ?>"
                            data-lecture-id="<?php echo esc_attr($parent_lecture ? $parent_lecture : ''); ?>"
                            data-total-episodes="<?php echo esc_attr($total_episodes); ?>"
                            id="complete-btn-<?php echo get_the_ID(); ?>"
                        >
                            <i class="fas fa-check-circle mr-2"></i>
                            このエピソードを完了する
                        </button>
                        
                        <div class="completion-rewards hidden mt-6" id="rewards-<?php echo get_the_ID(); ?>">
                            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg p-4 border border-yellow-200">
                                <div class="flex items-center justify-center mb-2">
                                    <i class="fas fa-paw text-2xl text-orange-500 mr-2"></i>
                                    <span class="font-bold text-orange-700">学習完了！</span>
                                </div>
                                <p class="text-sm text-gray-600">
                                    肉球スタンプを獲得しました 🐾
                                </p>
                            </div>
                        </div>
                        
                        <!-- 講座全体の進捗表示 -->
                        <div class="lecture-progress-summary mt-6 p-4 bg-gray-50 rounded-lg">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700">講座全体の進捗</span>
                                <span class="text-sm font-bold text-purple-600" id="overall-progress-text-<?php echo $parent_lecture; ?>">
                                    <!-- JavaScriptで更新 -->
                                </span>
                            </div>
                            <div class="progress-bar bg-gray-200 rounded-full h-3">
                                <div 
                                    class="progress-fill bg-gradient-to-r from-purple-500 to-blue-500 h-full rounded-full transition-all duration-500"
                                    id="overall-progress-bar-<?php echo $parent_lecture; ?>"
                                    style="width: 0%"
                                ></div>
                            </div>
                        </div>
                    </div>
                </section>
                
                <!-- エピソードナビゲーション -->
                <section class="episode-navigation bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between">
                        <!-- 前のエピソード -->
                        <?php if ($episode_number > 1) : 
                            $prev_episode_args = array(
                                'post_type' => 'lecture_episodes',
                                'meta_query' => array(
                                    array('key' => 'parent_lecture', 'value' => $parent_lecture, 'compare' => '='),
                                    array('key' => 'episode_number', 'value' => $episode_number - 1, 'compare' => '=')
                                ),
                                'posts_per_page' => 1,
                                'post_status' => 'publish'
                            );
                            $prev_query = new WP_Query($prev_episode_args);
                            if ($prev_query->have_posts()) : $prev_query->the_post();
                        ?>
                            <a href="<?php the_permalink(); ?>" class="flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                                <i class="fas fa-chevron-left mr-2"></i>
                                <div>
                                    <div class="text-xs text-gray-500">前回</div>
                                    <div class="font-medium">第<?php echo $episode_number - 1; ?>回: <?php the_title(); ?></div>
                                </div>
                            </a>
                        <?php wp_reset_postdata(); endif; else : ?>
                            <div></div>
                        <?php endif; ?>
                        
                        <!-- 講座トップに戻る -->
                        <a href="<?php echo $lecture_url; ?>" class="text-center">
                            <div class="bg-gray-100 hover:bg-gray-200 rounded-lg px-4 py-2 transition-colors">
                                <div class="text-xs text-gray-500 mb-1">講座トップ</div>
                                <div class="text-sm font-medium text-gray-800">全エピソード一覧</div>
                            </div>
                        </a>
                        
                        <!-- 次のエピソード -->
                        <?php if ($episode_number < $total_episodes) :
                            $next_episode_args = array(
                                'post_type' => 'lecture_episodes',
                                'meta_query' => array(
                                    array('key' => 'parent_lecture', 'value' => $parent_lecture, 'compare' => '='),
                                    array('key' => 'episode_number', 'value' => $episode_number + 1, 'compare' => '=')
                                ),
                                'posts_per_page' => 1,
                                'post_status' => 'publish'
                            );
                            $next_query = new WP_Query($next_episode_args);
                            if ($next_query->have_posts()) : $next_query->the_post();
                        ?>
                            <a href="<?php the_permalink(); ?>" class="flex items-center text-blue-600 hover:text-blue-800 transition-colors text-right">
                                <div>
                                    <div class="text-xs text-gray-500">次回</div>
                                    <div class="font-medium">第<?php echo $episode_number + 1; ?>回: <?php the_title(); ?></div>
                                </div>
                                <i class="fas fa-chevron-right ml-2"></i>
                            </a>
                        <?php wp_reset_postdata(); endif; else : ?>
                            <div class="text-right">
                                <div class="bg-green-100 text-green-800 rounded-lg px-4 py-2">
                                    <div class="text-xs mb-1">完結</div>
                                    <div class="text-sm font-medium">お疲れさまでした！</div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
            
            <!-- サイドバー -->
            <div class="lg:col-span-1 space-y-6">
                <!-- このエピソードの情報 -->
                <div class="episode-info bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-gray-800 mb-4">エピソード情報</h3>
                    <div class="info-grid space-y-3">
                        <div class="info-item">
                            <dt class="text-sm text-gray-500 mb-1">エピソード番号</dt>
                            <dd class="font-semibold">第<?php echo $episode_number; ?>回 / 全<?php echo $total_episodes; ?>回</dd>
                        </div>
                        
                        <div class="info-item">
                            <dt class="text-sm text-gray-500 mb-1">メイン講師</dt>
                            <dd class="font-semibold"><?php echo esc_html($main_prof_info['name']); ?></dd>
                        </div>
                        
                        <?php if ($guest_prof_info) : ?>
                            <div class="info-item">
                                <dt class="text-sm text-gray-500 mb-1">ゲスト講師</dt>
                                <dd class="font-semibold"><?php echo esc_html($guest_prof_info['name']); ?></dd>
                            </div>
                        <?php endif; ?>
                        
                        <div class="info-item">
                            <dt class="text-sm text-gray-500 mb-1">投稿日</dt>
                            <dd class="font-semibold"><?php echo get_the_date('Y年m月d日'); ?></dd>
                        </div>
                    </div>
                </div>
                
                <!-- 講座全体への移動 -->
                <div class="lecture-navigation bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-gray-800 mb-4">この講座について</h3>
                    
                    <div class="lecture-card border border-gray-200 rounded-lg p-4">
                        <h4 class="font-semibold text-sm mb-2">
                            <a href="<?php echo $lecture_url; ?>" class="text-blue-600 hover:text-blue-800 transition-colors">
                                <?php echo esc_html($lecture_title); ?>
                            </a>
                        </h4>
                        <p class="text-xs text-gray-500 mb-3">全<?php echo $total_episodes; ?>回シリーズ</p>
                        
                        <div class="progress-bar bg-gray-200 rounded-full h-2 mb-2">
                            <div class="progress-fill bg-gradient-to-r from-blue-400 to-purple-500 h-full rounded-full" 
                                 style="width: <?php echo ($episode_number / $total_episodes) * 100; ?>%"></div>
                        </div>
                        <div class="text-xs text-gray-500 text-center">
                            進捗: <?php echo round(($episode_number / $total_episodes) * 100); ?>%
                        </div>
                    </div>
                    
                    <div class="action-buttons mt-4 space-y-2">
                        <a href="<?php echo $lecture_url; ?>" class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg font-medium transition-colors">
                            講座トップに戻る
                        </a>
                        
                        <?php if ($episode_number < $total_episodes) : ?>
                            <button class="bookmark-episode-button w-full text-gray-600 hover:text-blue-600 py-2 transition-colors flex items-center justify-center" data-episode-id="<?php echo esc_attr(get_the_ID()); ?>" data-episode-number="<?php echo esc_attr($episode_number); ?>" data-lecture-id="<?php echo esc_attr($parent_lecture ? $parent_lecture : ''); ?>">
                                <i class="fas fa-bookmark mr-2"></i>続きから再生に設定
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- 参考論文 -->
                <?php if ($related_paper) : ?>
                    <div class="related-paper bg-white rounded-lg shadow-md p-6">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-file-alt text-green-600 mr-2"></i>
                            参考論文
                        </h3>
                        
                        <div class="paper-card border border-gray-200 rounded-lg p-4">
                            <h4 class="font-semibold text-sm mb-2">
                                <a href="<?php echo get_permalink($related_paper->ID); ?>" class="text-green-600 hover:text-green-800 transition-colors">
                                    <?php echo esc_html($related_paper->post_title); ?>
                                </a>
                            </h4>
                            
                            <?php 
                            $authors = nfu_get_field('authors', $related_paper->ID);
                            $published_year = nfu_get_field('published_year', $related_paper->ID);
                            $journal = nfu_get_field('journal', $related_paper->ID);
                            ?>
                            
                            <?php if ($authors || $published_year || $journal) : ?>
                                <div class="paper-meta text-xs text-gray-500 space-y-1 mb-3">
                                    <?php if ($authors) : ?>
                                        <div class="authors">
                                            <i class="fas fa-user-edit mr-1"></i>
                                            <?php echo esc_html($authors); ?>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($published_year) : ?>
                                        <div class="year">
                                            <i class="fas fa-calendar mr-1"></i>
                                            <?php echo esc_html($published_year); ?>年
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($journal) : ?>
                                        <div class="journal">
                                            <i class="fas fa-book mr-1"></i>
                                            <?php echo esc_html($journal); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            
                            <div class="paper-excerpt text-xs text-gray-600 mb-3">
                                <?php echo wp_trim_words($related_paper->post_excerpt ?: $related_paper->post_content, 20, '...'); ?>
                            </div>
                            
                            <a href="<?php echo get_permalink($related_paper->ID); ?>" class="block w-full text-center bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-medium transition-colors text-sm">
                                <i class="fas fa-external-link-alt mr-1"></i>
                                論文要約を読む
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- エピソード一覧 -->
                <div class="episodes-list bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-gray-800 mb-4">エピソード一覧</h3>
                    
                    <div class="episodes-grid space-y-2">
                        <?php
                        for ($i = 1; $i <= $total_episodes; $i++) :
                            $ep_args = array(
                                'post_type' => 'lecture_episodes',
                                'meta_query' => array(
                                    array('key' => 'parent_lecture', 'value' => $parent_lecture, 'compare' => '='),
                                    array('key' => 'episode_number', 'value' => $i, 'compare' => '=')
                                ),
                                'posts_per_page' => 1,
                                'post_status' => 'publish'
                            );
                            
                            $ep_query = new WP_Query($ep_args);
                            $is_available = $ep_query->have_posts();
                            $is_current = ($i == $episode_number);
                            
                            if ($is_available) {
                                $ep_query->the_post();
                                $ep_title = get_the_title();
                                $ep_url = get_permalink();
                                wp_reset_postdata();
                            } else {
                                $ep_title = "第{$i}回（準備中）";
                                $ep_url = '#';
                            }
                        ?>
                            <div class="episode-item flex items-center p-2 rounded <?php echo $is_current ? 'bg-blue-100 border border-blue-300' : ($is_available ? 'hover:bg-gray-50' : 'bg-gray-50'); ?>">
                                <div class="episode-number w-6 h-6 rounded-full flex items-center justify-center mr-3 text-xs font-bold
                                     <?php echo $is_current ? 'bg-blue-600 text-white' : ($is_available ? 'bg-gray-300 text-gray-700' : 'bg-gray-200 text-gray-400'); ?>">
                                    <?php echo $i; ?>
                                </div>
                                
                                <?php if ($is_available && !$is_current) : ?>
                                    <a href="<?php echo $ep_url; ?>" class="flex-1 text-sm text-gray-700 hover:text-blue-600 transition-colors">
                                        <?php echo esc_html($ep_title); ?>
                                    </a>
                                <?php else : ?>
                                    <span class="flex-1 text-sm <?php echo $is_current ? 'font-semibold text-blue-800' : 'text-gray-500'; ?>">
                                        <?php echo esc_html($ep_title); ?>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if ($is_current) : ?>
                                    <span class="text-xs text-blue-600 font-medium">現在</span>
                                <?php elseif ($is_available) : ?>
                                    <i class="fas fa-play-circle text-green-500 text-sm"></i>
                                <?php endif; ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php endwhile; endif; ?>

<style>
/* チャットテンプレート用の基本スタイル */
.custom-green {
    background-color: #06c755 !important;
    box-shadow: 0 2px 8px rgba(6, 199, 85, 0.3) !important;
}

.bg-white {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08) !important;
}

/* チャット背景のLINE風スタイル */
.character-dialogues {
    background: linear-gradient(135deg, #f0f2f5 0%, #e4e6ea 100%) !important;
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
</style>

<?php get_footer(); ?>