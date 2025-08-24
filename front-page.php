<?php
/**
 * トップページテンプレート
 * 
 * @package NekoFreaksUniv
 */

get_header(); ?>

<main id="main" class="site-main">
    
    <!-- 1. ヒーローセクション -->
    <section class="hero-section min-h-screen flex items-center justify-center relative" style="background-color: #2D3E50;">
        <!-- 背景画像 -->
        <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('<?php echo NFU_THEME_URI . '/assets/images/hero_back.webp'; ?>');"></div>
        
        <div class="container mx-auto px-4 py-16 relative z-10">
            <!-- ロゴ・タイトル -->
            <h1 class="text-5xl md:text-6xl font-bold text-white text-center mb-8">
                ネコフリークス大学
            </h1>
            <p class="text-xl text-white text-opacity-80 text-center mb-12">
                論文から学ぶ、本格的な猫の知識
            </p>
            
            <!-- マロン学長のウェルカムメッセージ -->
            <div class="welcome-message flex flex-col md:flex-row items-center justify-center gap-6 md:gap-6">
                <div class="maron-character">
                    <img src="<?php echo NFU_THEME_URI . '/assets/images/maron_image.webp'; ?>" alt="マロン学長" class="w-48 h-48 rounded-full object-cover shadow-xl">
                </div>
                <div class="speech-bubble bg-white p-6 rounded-xl shadow-lg max-w-md relative mt-4 md:mt-0">
                    <!-- デスクトップ版：左向きの三角 -->
                    <div class="hidden md:block absolute -left-3 top-8 w-0 h-0" style="border-style: solid; border-width: 10px 12px 10px 0; border-color: transparent white transparent transparent;"></div>
                    <!-- スマホ版：上向きの三角 -->
                    <div class="md:hidden absolute -top-3 left-1/2 transform -translate-x-1/2 w-0 h-0" style="border-style: solid; border-width: 0 12px 12px 12px; border-color: transparent transparent white transparent;"></div>
                    <p class="text-lg text-gray-800">
                        「ようこそ！ネコフリークス大学へ！<br>
                        ぼくと一緒に、猫のこと、たくさん学ぼうね！」
                    </p>
                    <p class="text-sm text-gray-600 mt-2">- マロン学長</p>
                </div>
            </div>
            
            <!-- CTA ボタン -->
            <div class="text-center mt-12">
                <a href="#current-lecture" class="inline-block bg-pink-500 text-white px-8 py-4 rounded-full font-bold hover:bg-pink-600 transition-colors">
                    今週の講座を見る
                </a>
            </div>
        </div>
    </section>
    
    <!-- 2. 現在開講中の講座 -->
    <section id="current-lecture" class="current-lecture-section py-20 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12">
                現在開講中の講座
            </h2>
            
            <?php
            // デバッグ用: 全ての講座とそのstatusを確認
            $debug_lectures = new WP_Query( array(
                'post_type' => 'lectures',
                'posts_per_page' => -1,
                'post_status' => 'publish'
            ) );
            
            // 開講中の講座を検索（厳密なクエリ）
            $current_lectures = new WP_Query( array(
                'post_type' => array('lectures'), // 配列形式で明示的に指定
                'posts_per_page' => 1,
                'post_status' => 'publish',
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key' => 'lecture_status',
                        'value' => '開講中',
                        'compare' => '=',
                        'type' => 'CHAR'
                    )
                ),
                'orderby' => array(
                    'menu_order' => 'ASC',
                    'date' => 'DESC'
                ),
                'suppress_filters' => false,
            ) );
            
            // 開講中の講座が見つからない場合、すべての講座から最新を表示
            if ( !$current_lectures->have_posts() ) {
                wp_reset_postdata();
                $current_lectures = new WP_Query( array(
                    'post_type' => array('lectures'), // 配列形式で明示的に指定
                    'posts_per_page' => 1,
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'order' => 'DESC',
                    'suppress_filters' => false,
                ) );
            }
            
            if ( $current_lectures->have_posts() ) : 
                while ( $current_lectures->have_posts() ) : $current_lectures->the_post();
                    $professor = nfu_get_field( 'main_professor' );
                    $progress = nfu_get_lecture_progress( get_the_ID() );
                    $overview = nfu_get_field( 'lecture_overview' );
                    $lecture_status = nfu_get_field( 'lecture_status' );
                    
                    // 詳細デバッグ情報
                    $post_type = get_post_type();
                    $post_id = get_the_ID();
                    
                    // 常にデバッグ情報を表示（一時的）
                    echo '<!-- デバッグ詳細: 投稿ID=' . $post_id . ', 投稿タイプ=' . $post_type . ', タイトル=' . get_the_title() . ', lecture_status=' . $lecture_status . ' -->';
                    
                    // 投稿タイプが lectures でない場合はスキップ
                    if ( $post_type !== 'lectures' ) {
                        echo '<!-- エラー: 投稿タイプが lectures ではありません -->';
                        continue;
                    }
                    
                    // 講座のIDを保存（the_post()で上書きされる前に）
                    $lecture_id = get_the_ID();
                    $lecture_post = $post; // 現在の講座投稿を保存
                    
                    // 最新のエピソードを取得
                    $latest_episode = new WP_Query( array(
                        'post_type' => 'lecture_episodes',
                        'posts_per_page' => 1,
                        'meta_query' => array(
                            array(
                                'key' => 'parent_lecture',
                                'value' => $lecture_id,
                                'compare' => '='
                            )
                        ),
                        'orderby' => 'meta_value_num',
                        'meta_key' => 'episode_number',
                        'order' => 'DESC',
                        'post_status' => 'publish'
                    ) );
                    
                    $current_episode_number = 1;
                    $current_episode_id = null;
                    if ( $latest_episode->have_posts() ) {
                        $latest_episode->the_post();
                        $current_episode_number = nfu_get_field( 'episode_number' );
                        $current_episode_id = get_the_ID();
                        wp_reset_postdata();
                    }
                    
                    // 講座投稿の状態を復元
                    $post = $lecture_post;
                    setup_postdata( $post );
            ?>
                <!-- 講座カード -->
                <div class="lecture-card bg-gradient-to-r from-blue-600 to-blue-800 rounded-xl p-8 text-white max-w-none lg:max-w-5xl lg:mx-auto">
                    <div class="flex flex-col md:flex-row items-center gap-8">
                        <!-- 講座情報 -->
                        <div class="flex-1">
                            <span class="inline-block bg-pink-500 text-white px-3 py-1 rounded-full text-sm">
                                開講中
                            </span>
                            <h3 class="text-3xl font-bold mt-4 mb-2">
                                <?php 
                                // 講座投稿の状態を再確認
                                if (get_the_ID() !== $lecture_id) {
                                    $post = $lecture_post;
                                    setup_postdata($post);
                                }
                                the_title(); 
                                ?>
                            </h3>
                            <p class="text-lg opacity-90 mb-4">
                                担当：<?php echo nfu_get_professor_name( $professor ); ?> × マロン学長
                            </p>
                            
                            <!-- 進捗表示 -->
                            <div class="progress-indicator mb-6">
                                <p class="text-sm mb-2">現在：第<?php echo $current_episode_number; ?>回 / 全<?php echo $progress['total']; ?>回</p>
                                <div class="progress-bar bg-white bg-opacity-20 rounded-full h-4">
                                    <div class="progress-fill bg-pink-500 rounded-full h-4 flex items-center justify-end pr-2" 
                                         style="width: <?php echo $progress['percentage']; ?>%">
                                        <i class="fas fa-paw text-xs"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- 次回予告 -->
                            <?php if ( $current_episode_number < $progress['total'] ) : 
                                // 現在のエピソードから次回予告を取得
                                $next_episode_preview = '';
                                $next_release_date = '';
                                
                                if ($current_episode_id) {
                                    // 現在のエピソードのIDを一時保存
                                    $temp_post = $post;
                                    $episode_post = get_post($current_episode_id);
                                    if ($episode_post) {
                                        $post = $episode_post;
                                        setup_postdata($post);
                                        $next_episode_preview = nfu_get_field('next_episode_preview');
                                        $next_release_date = nfu_get_field('next_release_date');
                                        wp_reset_postdata();
                                        $post = $temp_post;
                                        setup_postdata($post); // 講座投稿の状態を再設定
                                    }
                                }
                                
                                // 公開日の表示形式を決定
                                $release_text = '金曜20:00公開';
                                if ($next_release_date) {
                                    $date_obj = DateTime::createFromFormat('Y-m-d', $next_release_date);
                                    if ($date_obj) {
                                        $weekdays = ['日', '月', '火', '水', '木', '金', '土'];
                                        $weekday = $weekdays[$date_obj->format('w')];
                                        $release_text = $date_obj->format('n月j日') . '（' . $weekday . '）20:00公開';
                                    }
                                }
                                
                                // 予告文の決定
                                $preview_text = $next_episode_preview ? 
                                    $next_episode_preview : 
                                    '第' . ($current_episode_number + 1) . '回：続きをお楽しみに！';
                            ?>
                            <div class="next-episode bg-white bg-opacity-10 rounded-lg p-4">
                                <p class="text-sm font-semibold">次回予告（<?php echo esc_html($release_text); ?>）</p>
                                <p class="text-sm mt-1"><?php echo esc_html($preview_text); ?></p>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- 講座サムネイル -->
                        <div class="lecture-thumbnail">
                            <?php if ( has_post_thumbnail() ) : ?>
                                <?php the_post_thumbnail('medium', array('class' => 'w-48 h-48 lg:w-52 lg:h-52 object-cover rounded-lg shadow-xl')); ?>
                            <?php else : ?>
                                <div class="w-48 h-48 lg:w-52 lg:h-52 bg-white bg-opacity-20 rounded-lg shadow-xl flex items-center justify-center">
                                    <i class="fas fa-book text-6xl lg:text-7xl"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- アクションボタン -->
                    <div class="mt-6 flex flex-wrap gap-4">
                        <?php if ( $current_episode_id ) : ?>
                        <a href="<?php echo get_permalink( $current_episode_id ); ?>" class="bg-white text-blue-600 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition-colors">
                            第<?php echo $current_episode_number; ?>回を受講する
                        </a>
                        <?php endif; ?>
                        <a href="<?php the_permalink(); ?>" class="border-2 border-white text-white px-6 py-3 rounded-full font-semibold hover:bg-white hover:text-blue-600 transition-all">
                            講座の詳細を見る
                        </a>
                    </div>
                </div>
            <?php 
                endwhile;
            else : ?>
                <p class="text-center text-gray-600">現在開講中の講座はありません。</p>
            <?php endif;
            wp_reset_postdata();
            ?>
        </div>
    </section>
    
    <!-- 3. 受講可能な講座一覧 -->
    <section class="available-lectures-section py-20" style="background-color: #FAFAF8;">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12">
                受講可能な講座
            </h2>
            
            <?php
            $available_lectures = new WP_Query( array(
                'post_type' => 'lectures',
                'posts_per_page' => 6,
                'meta_query' => array(
                    array(
                        'key' => 'lecture_status',
                        'value' => array('開講中', '完結'),
                        'compare' => 'IN'
                    )
                )
            ) );
            
            if ( $available_lectures->have_posts() ) : ?>
                <!-- 講座グリッド -->
                <div class="lecture-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-none lg:max-w-5xl lg:mx-auto">
                    <?php while ( $available_lectures->have_posts() ) : $available_lectures->the_post(); 
                        $professor = nfu_get_field( 'main_professor' );
                        $total_episodes = nfu_get_field( 'total_episodes' ) ?: 5;
                        $difficulty = get_the_terms( get_the_ID(), 'difficulty' );
                        $difficulty_label = $difficulty && !is_wp_error($difficulty) ? $difficulty[0]->name : '初級';
                        
                        // 講師別カラー
                        $professor_colors = array(
                            'maron' => 'from-yellow-500 to-yellow-600',
                            'ichi' => 'from-orange-500 to-orange-600',
                            'hachi' => 'from-blue-500 to-blue-600',
                            'jiji' => 'from-green-500 to-green-600',
                            'daifuku' => 'from-purple-500 to-purple-600'
                        );
                        $spine_color = isset($professor_colors[$professor]) ? $professor_colors[$professor] : 'from-gray-500 to-gray-600';
                    ?>
                        <!-- 講座カード（本の表紙風） -->
                        <article class="lecture-book-card transform hover:-translate-y-2 transition-transform">
                            <div class="book-cover bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow overflow-hidden">
                                <!-- 表紙デザイン（背表紙） -->
                                <div class="book-spine bg-gradient-to-r <?php echo $spine_color; ?> h-2"></div>
                                
                                <div class="p-6">
                                    <!-- 講座情報 -->
                                    <span class="<?php echo nfu_get_professor_class( $professor ); ?> text-sm font-semibold">
                                        <?php echo nfu_get_professor_name( $professor ); ?>
                                    </span>
                                    <h3 class="text-xl font-bold mt-2 mb-2">
                                        <a href="<?php the_permalink(); ?>" class="text-gray-800 hover:text-blue-600 transition-colors">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 text-sm mb-4">
                                        <?php echo wp_trim_words( get_the_excerpt(), 20 ); ?>
                                    </p>
                                    
                                    <!-- メタ情報 -->
                                    <div class="flex items-center gap-4 text-sm text-gray-500">
                                        <span><i class="fas fa-graduation-cap mr-1"></i>全<?php echo $total_episodes; ?>回</span>
                                        <span><i class="fas fa-chart-bar mr-1"></i><?php echo $difficulty_label; ?></span>
                                        <span><i class="fas fa-users mr-1"></i><?php echo rand(100, 999); ?>名</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>
                
                <!-- もっと見るリンク -->
                <div class="text-center mt-12">
                    <a href="<?php echo home_url('/lectures/'); ?>" class="inline-block border-2 border-blue-600 text-blue-600 px-6 py-3 rounded-full font-semibold hover:bg-blue-600 hover:text-white transition-all">
                        すべての講座を見る →
                    </a>
                </div>
            <?php endif;
            wp_reset_postdata();
            ?>
        </div>
    </section>
    
    <!-- 4. 今週の更新情報 -->
    <section class="weekly-updates-section py-20 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12">
                今週の更新情報
            </h2>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-none lg:max-w-5xl lg:mx-auto">
                
                <!-- 豆知識 -->
                <div class="tips-column">
                    <h3 class="text-2xl font-bold mb-6">
                        最新の豆知識
                    </h3>
                    
                    <div class="tips-list space-y-4">
                        <?php
                        $recent_tips = new WP_Query( array(
                            'post_type' => 'tips',
                            'posts_per_page' => 3
                        ) );
                        
                        if ( $recent_tips->have_posts() ) :
                            while ( $recent_tips->have_posts() ) : $recent_tips->the_post();
                        ?>
                            <!-- 豆知識カード -->
                            <article class="tip-card bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                                <span class="date text-sm text-gray-600"><?php echo get_the_date('Y.m.d'); ?>（<?php echo get_the_date('D'); ?>）</span>
                                <h4 class="font-bold mt-1">
                                    <?php the_title(); ?>
                                </h4>
                                <p class="text-sm text-gray-700 mt-2">
                                    <?php echo wp_trim_words( get_the_excerpt(), 30 ); ?>
                                </p>
                                <a href="<?php the_permalink(); ?>" class="text-blue-600 text-sm hover:underline">
                                    続きを読む →
                                </a>
                            </article>
                        <?php 
                            endwhile;
                        else : ?>
                            <p class="text-gray-600">豆知識はまだありません。</p>
                        <?php endif;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
                
                <!-- グッズ紹介 -->
                <div class="goods-column">
                    <h3 class="text-2xl font-bold mb-6">
                        今週のおすすめグッズ
                    </h3>
                    
                    <div class="goods-list space-y-4">
                        <?php
                        $recent_goods = new WP_Query( array(
                            'post_type' => 'goods',
                            'posts_per_page' => 3
                        ) );
                        
                        if ( $recent_goods->have_posts() ) :
                            while ( $recent_goods->have_posts() ) : $recent_goods->the_post();
                                $price = nfu_get_field('price');
                                $is_recommended = nfu_get_field('is_recommended');
                        ?>
                            <!-- グッズカード -->
                            <article class="goods-card bg-purple-50 rounded-lg p-4 flex gap-4">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail('thumbnail', array('class' => 'w-24 h-24 object-cover rounded')); ?>
                                <?php else : ?>
                                    <div class="w-24 h-24 bg-purple-200 rounded flex items-center justify-center">
                                        <i class="fas fa-shopping-bag text-3xl"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="flex-1">
                                    <span class="date text-sm text-gray-600"><?php echo get_the_date('Y.m.d'); ?>（<?php echo get_the_date('D'); ?>）</span>
                                    <h4 class="font-bold mt-1">
                                        <?php the_title(); ?>
                                    </h4>
                                    <?php if ( $is_recommended ) : ?>
                                    <div class="rating text-yellow-500 text-sm mt-1">
                                        <i class="fas fa-star text-yellow-500"></i><i class="fas fa-star text-yellow-500"></i><i class="fas fa-star text-yellow-500"></i><i class="fas fa-star text-yellow-500"></i><i class="fas fa-star text-yellow-500"></i> (4.8)
                                    </div>
                                    <?php endif; ?>
                                    <?php if ( $price ) : ?>
                                    <p class="text-green-600 font-bold text-sm mt-1">¥<?php echo number_format($price); ?></p>
                                    <?php endif; ?>
                                    <a href="<?php the_permalink(); ?>" class="text-blue-600 text-sm hover:underline">
                                        詳細を見る →
                                    </a>
                                </div>
                            </article>
                        <?php 
                            endwhile;
                        else : ?>
                            <p class="text-gray-600">グッズはまだありません。</p>
                        <?php endif;
                        wp_reset_postdata();
                        ?>
                    </div>
                </div>
                
            </div>
        </div>
    </section>
    
    <!-- 5. 講師紹介 -->
    <section class="professors-section py-20 bg-gradient-to-r from-purple-50 to-pink-50">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12">
                講師紹介
            </h2>
            
            <p class="text-xl text-center mb-12 max-w-3xl mx-auto text-gray-700">
                ネコフリークス大学の優秀な講師陣をご紹介します
            </p>
            
            <?php
            // 講師情報を取得
            $professors = nfu_get_professors();
            
            if ( !empty($professors) ) : ?>
                <!-- 講師グリッド -->
                <div class="professors-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
                    <?php foreach ( $professors as $professor ) : ?>
                        <?php include get_template_directory() . '/template-parts/content-professor-card.php'; ?>
                    <?php endforeach; ?>
                </div>
                
                <!-- 公式SNSリンク -->
                <div class="text-center mt-16 mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-8">
                        普段の猫たちの様子はこちらのSNSからご覧いただけます
                    </h3>
                    
                    <div class="flex flex-col md:flex-row justify-center items-center gap-4 max-w-4xl mx-auto">
                        <!-- X（Twitter） -->
                        <a href="https://x.com/REPLACE_WITH_OFFICIAL" 
                           target="_blank" 
                           class="flex items-center bg-black text-white px-6 py-3 rounded-full font-semibold hover:bg-gray-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class="fab fa-x-twitter text-lg mr-2"></i>
                            <span>Xを見に行く</span>
                        </a>
                        
                        <!-- Instagram -->
                        <a href="https://instagram.com/REPLACE_WITH_OFFICIAL" 
                           target="_blank" 
                           class="flex items-center bg-gradient-to-r from-purple-500 to-pink-500 text-white px-6 py-3 rounded-full font-semibold hover:from-purple-600 hover:to-pink-600 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class="fab fa-instagram text-lg mr-2"></i>
                            <span>Instagramを見に行く</span>
                        </a>
                        
                        <!-- YouTube -->
                        <a href="https://youtube.com/@REPLACE_WITH_OFFICIAL" 
                           target="_blank" 
                           class="flex items-center bg-red-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-red-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class="fab fa-youtube text-lg mr-2"></i>
                            <span>YouTubeを見に行く</span>
                        </a>
                    </div>
                </div>
            <?php else : ?>
                <div class="text-center text-gray-600">
                    <p>講師情報がまだ登録されていません。</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
    
    <!-- 6. ネコフリークス大学について（簡易版） -->
    <section class="about-section py-20 bg-gradient-to-b from-blue-700 to-blue-900 text-white">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-12">
                ネコフリークス大学とは
            </h2>
            
            <p class="text-xl text-center mb-12 max-w-3xl mx-auto">
                論文×AI×猫好きの想いで作った、信頼できる猫情報メディアです
            </p>
            
            <!-- 3つの特徴 -->
            <div class="features grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
                
                <div class="feature text-center">
                    <div class="icon bg-white bg-opacity-20 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4 text-4xl">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">論文ベースの確かな情報</h3>
                    <p class="text-white text-opacity-80">
                        最新の研究論文をAIで分析し、科学的根拠に基づいた情報を提供
                    </p>
                </div>
                
                <div class="feature text-center">
                    <div class="icon bg-white bg-opacity-20 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4 text-4xl">
                        <i class="fas fa-cat"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">楽しく学べるキャラクター講義</h3>
                    <p class="text-white text-opacity-80">
                        5匹の個性豊かな猫講師たちが、会話形式で分かりやすく解説
                    </p>
                </div>
                
                <div class="feature text-center">
                    <div class="icon bg-white bg-opacity-20 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4 text-4xl">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-2">AI活用による最新情報</h3>
                    <p class="text-white text-opacity-80">
                        常に最新の研究成果を反映し、専門家レビューで品質を保証
                    </p>
                </div>
                
            </div>
            
            <!-- 詳細リンク -->
            <div class="text-center">
                <a href="<?php echo home_url('/about/'); ?>" class="inline-block bg-white text-blue-700 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition-colors">
                    詳しく見る
                </a>
            </div>
        </div>
    </section>
    
</main>

<style>
/* カスタムスタイル */
.hero-section {
    position: relative;
}

.speech-bubble {
    position: relative;
}

.lecture-book-card .book-spine {
    transition: all 0.3s ease;
}

.lecture-book-card:hover .book-spine {
    height: 3px;
}

/* 肉球アニメーション */
@keyframes paw-stamp {
    0% { transform: scale(0) rotate(-10deg); }
    50% { transform: scale(1.2) rotate(5deg); }
    100% { transform: scale(1) rotate(0deg); }
}

.paw-animation {
    animation: paw-stamp 0.3s ease-out;
}

/* セクションタイトルの下線 */
h2.text-4xl::after {
    content: '';
    display: block;
    width: 80px;
    height: 4px;
    background: #ff6b6b;
    margin: 1rem auto 0;
    border-radius: 2px;
}
</style>

<?php get_footer(); ?>