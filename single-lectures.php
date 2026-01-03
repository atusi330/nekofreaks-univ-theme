<?php
/**
 * 講座詳細ページテンプレート
 * 
 * @package NekoFreaksUniv
 */

get_header();

// 講座情報の取得
$lecture_status = nfu_get_field('lecture_status');
$main_professor = nfu_get_field('main_professor'); // 責任講師
$navigator = nfu_get_field('navigator') ?: 'maron'; // ナビゲーター（固定でマロン）
$lecture_overview = nfu_get_field('lecture_overview');
$total_episodes = nfu_get_field('total_episodes') ?: 5;
$related_paper = function_exists('get_field') ? get_field('related_paper') : nfu_get_field('related_paper');


// 進捗情報の取得
$progress = nfu_get_lecture_progress(get_the_ID());

// 講師情報の取得
$professor_data = array(
    'maron' => array('name' => 'マロン学長', 'color' => 'professor-maron'),
    'ichi' => array('name' => 'いち教授', 'color' => 'professor-ichi'), 
    'hachi' => array('name' => 'はち助教授', 'color' => 'professor-hachi'),
    'jiji' => array('name' => 'ジジ助手', 'color' => 'professor-jiji'),
    'daifuku' => array('name' => '大福先代学長', 'color' => 'professor-daifuku'),
);
$professor_info = $professor_data[$main_professor] ?? array('name' => '', 'color' => '');

// テーマカテゴリの取得
$themes = get_the_terms(get_the_ID(), 'theme_category');
$theme_name = ($themes && !is_wp_error($themes)) ? $themes[0]->name : '';

// 難易度の取得  
$difficulty = get_the_terms(get_the_ID(), 'difficulty');
$difficulty_name = ($difficulty && !is_wp_error($difficulty)) ? $difficulty[0]->name : '';
$difficulty_label = '';
switch($difficulty_name) {
    case 'beginner': $difficulty_label = '初級'; break;
    case 'intermediate': $difficulty_label = '中級'; break;
    case 'advanced': $difficulty_label = '上級'; break;
    default: $difficulty_label = $difficulty_name; break;
}
?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<main id="main" class="site-main">
    <div class="container mx-auto px-4 py-8">
        <?php nfu_breadcrumb(); ?>
        
        <!-- 講座ヘッダー -->
        <div class="lecture-header bg-gradient-to-r from-blue-600 to-purple-600 text-white rounded-lg overflow-hidden shadow-xl mb-8">
            <div class="flex flex-col lg:flex-row">
                <!-- 左側: 基本情報 -->
                <div class="flex-1 p-8">
                    <!-- ステータス・バッジ -->
                    <div class="flex flex-wrap gap-3 mb-4">
                        <span class="status-badge px-3 py-1 rounded-full text-sm font-semibold <?php echo $lecture_status === '開講中' ? 'bg-green-500 text-white' : ($lecture_status === '完結' ? 'bg-gray-500 text-white' : 'bg-yellow-500 text-white'); ?>">
                            <?php echo esc_html($lecture_status ?: '準備中'); ?>
                        </span>
                        
                        <?php if ($theme_name) : ?>
                            <span class="theme-badge bg-white/20 text-white px-3 py-1 rounded-full text-sm">
                                <?php echo esc_html($theme_name); ?>
                            </span>
                        <?php endif; ?>
                        
                        <?php if ($difficulty_label) : ?>
                            <span class="difficulty-badge bg-white/20 text-white px-3 py-1 rounded-full text-sm">
                                <?php echo esc_html($difficulty_label); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- タイトル -->
                    <h1 class="lecture-title text-3xl lg:text-4xl font-bold mb-4 leading-tight">
                        <?php the_title(); ?>
                    </h1>
                    
                    <!-- 講師情報 -->
                    <div class="professors-info mb-4">
                        <!-- 責任講師 -->
                        <div class="main-professor flex items-center mb-3">
                            <div class="professor-icon w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user-tie text-xl"></i>
                            </div>
                            <div>
                                <p class="professor-name font-semibold text-lg"><?php echo esc_html($professor_info['name']); ?></p>
                                <p class="professor-role text-white/80 text-sm">講座責任講師</p>
                            </div>
                        </div>
                        
                        <!-- ナビゲーター -->
                        <div class="navigator flex items-center">
                            <div class="professor-icon w-10 h-10 bg-white/10 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-cat text-lg"></i>
                            </div>
                            <div>
                                <p class="professor-name font-medium">マロン学長</p>
                                <p class="professor-role text-white/70 text-xs">ナビゲーター（生徒役）</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 進捗情報 -->
                    <div class="progress-section bg-white/10 rounded-lg p-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium">講座の進捗</span>
                            <span class="text-sm"><?php echo $progress['published']; ?>/<?php echo $progress['total']; ?>回配信済み</span>
                        </div>
                        <div class="progress-bar bg-white/20 rounded-full h-3">
                            <div class="progress-fill bg-gradient-to-r from-yellow-400 to-orange-500 h-full rounded-full transition-all" 
                                 style="width: <?php echo $progress['percentage']; ?>%"></div>
                        </div>
                        <div class="text-right mt-1">
                            <span class="text-xs text-white/80"><?php echo $progress['percentage']; ?>%完了</span>
                        </div>
                    </div>
                </div>
                
                <!-- 右側: サムネイル -->
                <div class="lg:w-80 flex-shrink-0">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="h-64 lg:h-full">
                            <?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover')); ?>
                        </div>
                    <?php else : ?>
                        <div class="h-64 lg:h-full bg-white/10 flex items-center justify-center">
                            <i class="fas fa-book text-6xl text-white/50"></i>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- メインコンテンツ -->
            <div class="lg:col-span-2 space-y-6">
                <!-- 講座概要 -->
                <?php if ($lecture_overview) : ?>
                    <section class="lecture-overview bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                            講座について
                        </h2>
                        <div class="overview-content text-gray-700 leading-relaxed">
                            <?php echo wpautop(esc_html($lecture_overview)); ?>
                        </div>
                    </section>
                <?php endif; ?>
                
                <!-- 関連論文 -->
                <?php if ($related_paper) : ?>
                    <section class="related-paper bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                            <i class="fas fa-file-alt text-green-600 mr-2"></i>
                            この講座のベースとなる論文
                        </h2>
                        <div class="paper-card-container">
                            <?php
                            // 関連論文のIDを取得（ACFフィールドから）
                            $paper_id = is_object($related_paper) ? $related_paper->ID : $related_paper;
                            
                            if ($paper_id) {
                                // 論文投稿を取得
                                $paper_post = get_post($paper_id);
                                
                                if ($paper_post && $paper_post->post_type === 'papers') {
                                    // 直接論文IDを渡してカードを表示
                                    echo '<div class="paper-card-wrapper">';
                                    
                                    // グローバル$postを一時的に変更
                                    global $post;
                                    $original_post = $post;
                                    
                                    $post = $paper_post;
                                    setup_postdata($post);
                                    
                                    // 論文カードテンプレートを呼び出し
                                    get_template_part('template-parts/content-paper-card', null, array(
                                        'size' => 'compact',
                                        'show_meta' => true,
                                        'show_excerpt' => true,
                                        'paper_id' => $paper_id
                                    ));
                                    
                                    // 元の投稿に戻す
                                    wp_reset_postdata();
                                    $post = $original_post;
                                    setup_postdata($post);
                                    
                                    echo '</div>';
                                } else {
                                    echo '<p class="text-gray-500">関連論文が見つかりません。（ID: ' . $paper_id . '、投稿タイプ: ' . ($paper_post ? $paper_post->post_type : '見つからない') . '）</p>';
                                }
                            } else {
                                echo '<p class="text-gray-500">関連論文のIDが取得できませんでした。</p>';
                            }
                            ?>
                        </div>
                    </section>
                <?php endif; ?>
                
                <!-- 講座エピソード一覧 -->
                <section class="episode-list bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-list text-purple-600 mr-2"></i>
                        講座一覧（全<?php echo $total_episodes; ?>回）
                    </h2>
                    
                    <div class="episodes-grid space-y-4">
                        <?php
                        for ($i = 1; $i <= $total_episodes; $i++) :
                            // 各エピソードの情報を取得
                            $episode_args = array(
                                'post_type' => 'lecture_episodes',
                                'meta_query' => array(
                                    array(
                                        'key' => 'parent_lecture',
                                        'value' => get_the_ID(),
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
                            
                            $episode_query = new WP_Query($episode_args);
                            $is_published = $episode_query->have_posts();
                            
                            if ($is_published) {
                                $episode_query->the_post();
                                $episode_id = get_the_ID();
                                $episode_title = get_the_title();
                                $episode_url = get_permalink();
                                $guest_professor = nfu_get_field('guest_professor', $episode_id);
                                $key_points = nfu_get_field('key_points', $episode_id);
                                $episode_excerpt = $key_points ? wp_trim_words(str_replace("\n", ' ', $key_points), 25) : get_the_excerpt();
                                wp_reset_postdata();
                            } else {
                                $episode_title = "第{$i}回（配信予定）";
                                $episode_url = '#';
                                $guest_professor = '';
                                $episode_excerpt = '近日配信予定です。お楽しみに！';
                            }
                        ?>
                        
                        <div class="episode-item flex items-start p-4 rounded-lg border <?php echo $is_published ? 'bg-white hover:bg-blue-50 border-gray-200' : 'bg-gray-50 border-gray-100'; ?> transition-colors">
                            <!-- エピソード番号 -->
                            <div class="episode-number flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center mr-4 <?php echo $is_published ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600'; ?>">
                                <span class="font-bold"><?php echo $i; ?></span>
                            </div>
                            
                            <!-- エピソード情報 -->
                            <div class="episode-info flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="episode-title font-semibold text-gray-800 <?php echo $is_published ? '' : 'text-gray-500'; ?>">
                                        <?php if ($is_published) : ?>
                                            <a href="<?php echo $episode_url; ?>" class="hover:text-blue-600 transition-colors">
                                                <?php echo esc_html($episode_title); ?>
                                            </a>
                                        <?php else : ?>
                                            <?php echo esc_html($episode_title); ?>
                                        <?php endif; ?>
                                    </h3>
                                    
                                    <?php if ($is_published) : ?>
                                        <span class="status-published bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">
                                            配信中
                                        </span>
                                    <?php else : ?>
                                        <span class="status-upcoming bg-gray-100 text-gray-600 px-2 py-1 rounded-full text-xs">
                                            配信予定
                                        </span>
                                    <?php endif; ?>
                                </div>
                                
                                <!-- 講師情報表示 -->
                                <?php if ($is_published) : ?>
                                    <div class="episode-professors text-xs text-gray-500 mb-1">
                                        <span class="main-prof">
                                            <i class="fas fa-user-tie mr-1"></i>
                                            <?php echo esc_html($professor_data[$main_professor]['name'] ?? '責任講師'); ?>
                                        </span>
                                        <span class="mx-1">+</span>
                                        <span class="navigator">
                                            <i class="fas fa-cat mr-1"></i>マロン学長
                                        </span>
                                        <?php if ($guest_professor) : ?>
                                            <span class="mx-1">+</span>
                                            <span class="guest text-blue-600">
                                                <i class="fas fa-star mr-1"></i>
                                                ゲスト: <?php echo esc_html($professor_data[$guest_professor]['name'] ?? $guest_professor); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                
                                <p class="episode-excerpt text-sm text-gray-600 line-clamp-2">
                                    <?php echo esc_html($episode_excerpt); ?>
                                </p>
                                
                                <?php if ($is_published) : ?>
                                    <div class="episode-actions mt-3">
                                        <a href="<?php echo $episode_url; ?>" class="inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors">
                                            受講する <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <?php endfor; ?>
                    </div>
                </section>
                
                <!-- 学習のコツ -->
                <section class="learning-tips bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg p-6 border border-yellow-200">
                    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-lightbulb text-yellow-500 mr-2"></i>
                        この講座を効果的に学ぶためのコツ
                    </h2>
                    <div class="tips-content space-y-3">
                        <div class="tip-item flex items-start">
                            <i class="fas fa-paw text-yellow-600 mr-3 mt-1"></i>
                            <p class="text-gray-700">各回のポイントをメモしながら受講しましょう</p>
                        </div>
                        <div class="tip-item flex items-start">
                            <i class="fas fa-paw text-yellow-600 mr-3 mt-1"></i>
                            <p class="text-gray-700">関連する論文も併せて読むとより理解が深まります</p>
                        </div>
                        <div class="tip-item flex items-start">
                            <i class="fas fa-paw text-yellow-600 mr-3 mt-1"></i>
                            <p class="text-gray-700">実際の猫との生活で実践してみてください</p>
                        </div>
                    </div>
                </section>
            </div>
            
            <!-- サイドバー -->
            <div class="space-y-6">
                <!-- 世界観説明 -->
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl shadow-lg p-6 mb-6 border border-purple-200">
                    <h3 class="font-bold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-info-circle text-purple-600 mr-2"></i>
                        この講座について
                    </h3>
                    <p class="text-sm text-gray-700 leading-relaxed mb-3">
                        この講座は、猫好きの運営者がAIを活用して英語論文を読み、
                        勉強した内容を「<?php echo esc_html($professor_info['name']); ?>」などの
                        <strong>猫のキャラクター</strong>が案内する形でお届けしています。
                    </p>
                    <p class="text-xs text-gray-600 bg-white rounded px-3 py-2 border border-purple-100">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        運営者は獣医師・研究者ではありません
                    </p>
                    <p class="text-xs text-gray-600 bg-white rounded px-3 py-2 border border-purple-100 mt-2">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        猫の健康に関する判断は、必ず獣医師にご相談ください。
                    </p>
                </div>
                
                <!-- 講座アクション -->
                <div class="lecture-actions bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-gray-800 mb-4">講座を始める</h3>
                    
                    <?php
                    // 最初のエピソードを取得
                    $first_episode_args = array(
                        'post_type' => 'lecture_episodes',
                        'meta_query' => array(
                            array(
                                'key' => 'parent_lecture',
                                'value' => get_the_ID(),
                                'compare' => '='
                            ),
                            array(
                                'key' => 'episode_number',
                                'value' => 1,
                                'compare' => '='
                            )
                        ),
                        'posts_per_page' => 1,
                        'post_status' => 'publish'
                    );
                    
                    $first_episode_query = new WP_Query($first_episode_args);
                    $first_episode_available = $first_episode_query->have_posts();
                    
                    if ($first_episode_available) {
                        $first_episode_query->the_post();
                        $first_episode_url = get_permalink();
                        wp_reset_postdata();
                    ?>
                        <a href="<?php echo $first_episode_url; ?>" class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-lg font-semibold transition-colors">
                            第1回から受講する
                        </a>
                    <?php 
                    } else {
                    ?>
                        <button class="block w-full bg-gray-400 text-white text-center py-3 rounded-lg font-semibold cursor-not-allowed" disabled>
                            配信開始をお待ちください
                        </button>
                    <?php 
                    }
                    ?>
                    
                    <div class="action-links mt-4 space-y-2">
                        <button class="bookmark-button w-full text-gray-600 hover:text-blue-600 py-2 transition-colors flex items-center justify-center" data-lecture-id="<?php echo get_the_ID(); ?>" data-lecture-title="<?php echo esc_attr(get_the_title()); ?>">
                            <i class="fas fa-bookmark mr-2"></i>
                            <span class="bookmark-text">お気に入りに追加</span>
                        </button>
                        <button class="share-button w-full text-gray-600 hover:text-green-600 py-2 transition-colors flex items-center justify-center" data-url="<?php echo esc_url(get_permalink()); ?>" data-title="<?php echo esc_attr(get_the_title()); ?>">
                            <i class="fas fa-share mr-2"></i>この講座をシェア
                        </button>
                    </div>
                </div>
                
                <!-- 講座統計 -->
                <div class="lecture-stats bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-gray-800 mb-4">講座情報</h3>
                    <div class="stats-grid space-y-3">
                        <div class="stat-item flex justify-between">
                            <span class="text-gray-600">総回数</span>
                            <span class="font-semibold"><?php echo $total_episodes; ?>回</span>
                        </div>
                        <div class="stat-item flex justify-between">
                            <span class="text-gray-600">配信済み</span>
                            <span class="font-semibold"><?php echo $progress['published']; ?>回</span>
                        </div>
                        <div class="stat-item flex justify-between">
                            <span class="text-gray-600">進捗率</span>
                            <span class="font-semibold"><?php echo $progress['percentage']; ?>%</span>
                        </div>
                        <div class="stat-item flex justify-between">
                            <span class="text-gray-600">難易度</span>
                            <span class="font-semibold"><?php echo esc_html($difficulty_label); ?></span>
                        </div>
                    </div>
                </div>
                
                <!-- 関連講座 -->
                <div class="related-lectures bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-gray-800 mb-4">関連する講座</h3>
                    
                    <?php
                    // 同じテーマカテゴリの他の講座を取得
                    if ($themes && !is_wp_error($themes)) {
                        $related_args = array(
                            'post_type' => 'lectures',
                            'posts_per_page' => 3,
                            'post__not_in' => array(get_the_ID()),
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'theme_category',
                                    'field' => 'term_id',
                                    'terms' => $themes[0]->term_id,
                                ),
                            ),
                        );
                        
                        $related_query = new WP_Query($related_args);
                        
                        if ($related_query->have_posts()) :
                            while ($related_query->have_posts()) : $related_query->the_post();
                                $related_professor = nfu_get_field('main_professor');
                                $related_status = nfu_get_field('lecture_status');
                    ?>
                        <div class="related-lecture-item mb-4 last:mb-0">
                            <h4 class="font-semibold text-sm mb-1">
                                <a href="<?php the_permalink(); ?>" class="text-gray-800 hover:text-blue-600 transition-colors line-clamp-2">
                                    <?php the_title(); ?>
                                </a>
                            </h4>
                            <div class="flex items-center justify-between text-xs text-gray-500">
                                <span><?php echo esc_html($professor_data[$related_professor]['name'] ?? ''); ?></span>
                                <span class="<?php echo $related_status === '開講中' ? 'text-green-600' : 'text-gray-500'; ?>">
                                    <?php echo esc_html($related_status); ?>
                                </span>
                            </div>
                        </div>
                    <?php
                            endwhile;
                        else :
                    ?>
                        <p class="text-gray-500 text-sm">現在、関連する講座はありません。</p>
                    <?php
                        endif;
                        wp_reset_postdata();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>
    
<?php endwhile; endif; ?>

<?php get_footer(); ?>