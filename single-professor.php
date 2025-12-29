<?php get_header(); ?>

<main class="professor-detail-page">
    <!-- パンくずリスト -->
    <div class="container mx-auto px-4 py-4">
        <?php nfu_breadcrumb(); ?>
    </div>

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
        // 講師情報を取得
        $professor_name = nfu_get_field('professor_name') ?: get_the_title();
        $professor_position = nfu_get_field('professor_position');
        $professor_responsibility = nfu_get_field('professor_responsibility');
        $professor_breed = nfu_get_field('professor_breed');
        $professor_color_type = nfu_get_field('professor_color_type');
        $professor_sex_age = nfu_get_field('professor_sex_age');
        $professor_birthday = nfu_get_field('professor_birthday');
        $professor_arrival = nfu_get_field('professor_arrival');
        $professor_origin = nfu_get_field('professor_origin');
        $professor_personality = nfu_get_field('professor_personality');
        $professor_features = nfu_get_field('professor_features');
        $professor_lecture_role = nfu_get_field('professor_lecture_role');
        $professor_sample_lines = nfu_get_field('professor_sample_lines');
        $professor_playlist = nfu_get_field('professor_playlist');
        $professor_color = nfu_get_field('professor_color');
        $professor_image = nfu_get_field('professor_image');
    ?>
    
    <!-- ヘッダーセクション -->
    <section class="professor-header bg-gradient-to-br from-purple-100 to-pink-100 py-16">
        <div class="container mx-auto px-4">
            <div class="flex flex-col lg:flex-row items-center gap-8">
                <!-- 講師画像 -->
                <div class="professor-image-container flex-shrink-0">
                    <?php if ( $professor_image ) : ?>
                        <div class="w-64 h-64 rounded-full overflow-hidden shadow-2xl border-4 border-white">
                            <img src="<?php echo esc_url($professor_image); ?>" 
                                 alt="<?php echo esc_attr($professor_name); ?>" 
                                 class="w-full h-full object-cover"
                                 loading="lazy">
                        </div>
                    <?php else : ?>
                        <div class="w-64 h-64 rounded-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center shadow-2xl border-4 border-white">
                            <i class="fas fa-cat text-8xl text-gray-400"></i>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- 講師基本情報 -->
                <div class="professor-info flex-1 text-center lg:text-left">
                    <div class="mb-2">
                        <span class="inline-block bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-semibold">
                            <i class="fas fa-star mr-1"></i>キャラクター紹介
                        </span>
                    </div>
                    
                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-800 mb-4">
                        <?php echo esc_html($professor_name); ?>
                        <?php if ( $professor_sex_age ) : ?>
                            <span class="text-2xl lg:text-3xl text-gray-600">（<?php echo esc_html($professor_sex_age); ?>）</span>
                        <?php endif; ?>
                    </h1>
                    
                    <?php if ( $professor_position ) : ?>
                        <p class="text-lg text-gray-600 mb-4">
                            実在の猫をモデルにした「<?php echo esc_html($professor_position); ?>」キャラクターです
                        </p>
                        <div class="mb-6">
                            <span class="inline-block bg-gradient-to-r from-purple-600 to-pink-600 text-white px-6 py-3 rounded-full text-xl font-semibold shadow-lg">
                                <?php echo esc_html($professor_position); ?>
                            </span>
                            <?php if ( $professor_responsibility ) : ?>
                                <div class="mt-2 text-lg text-gray-600">
                                    <?php echo esc_html($professor_responsibility); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ( $professor_breed ) : ?>
                        <p class="text-xl text-gray-600 mb-2">
                            <i class="fas fa-paw mr-2"></i>
                            <?php echo esc_html($professor_breed); ?>
                        </p>
                    <?php endif; ?>
                    
                    <?php if ( $professor_color_type ) : ?>
                        <p class="text-lg text-gray-600 mb-4">
                            <i class="fas fa-palette mr-2"></i>
                            <?php echo esc_html($professor_color_type); ?>
                        </p>
                    <?php endif; ?>
                    
                    <?php if ( $professor_lecture_role ) : ?>
                        <p class="text-lg text-gray-700 max-w-2xl">
                            <?php echo esc_html($professor_lecture_role); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- メインコンテンツ -->
    <section class="professor-content py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                
                <!-- 左カラム：プロフィール -->
                <div class="lg:col-span-2">
                    
                    <!-- 性格・特徴 -->
                    <?php if ( $professor_personality || $professor_features ) : ?>
                        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <i class="fas fa-heart text-pink-500 mr-3"></i>
                                プロフィール
                            </h2>
                            
                            <?php if ( $professor_personality ) : ?>
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-700 mb-3">性格</h3>
                                    <p class="text-gray-600 leading-relaxed">
                                        <?php echo esc_html($professor_personality); ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $professor_features ) : ?>
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold text-gray-700 mb-3">特徴・エピソード</h3>
                                    <p class="text-gray-600 leading-relaxed">
                                        <?php echo esc_html($professor_features); ?>
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- セリフ例 -->
                    <?php if ( $professor_sample_lines ) : ?>
                        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <i class="fas fa-comments text-blue-500 mr-3"></i>
                                セリフ例
                            </h2>
                            <div class="space-y-4">
                                <?php 
                                $lines = explode("\n", $professor_sample_lines);
                                foreach ( $lines as $line ) : 
                                    $line = trim($line);
                                    if ( !empty($line) ) :
                                ?>
                                    <div class="bg-gradient-to-r from-blue-50 to-purple-50 p-4 rounded-lg border-l-4 border-blue-400">
                                        <p class="text-gray-700 italic">
                                            "<?php echo esc_html($line); ?>"
                                        </p>
                                    </div>
                                <?php 
                                    endif;
                                endforeach; 
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <!-- YouTubeプレイリスト -->
                    <?php if ( $professor_playlist ) : ?>
                        <div class="bg-white rounded-xl shadow-lg p-8 mb-8">
                            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                                <i class="fab fa-youtube text-red-500 mr-3"></i>
                                YouTubeプレイリスト
                            </h2>
                            <div class="text-center">
                                <a href="<?php echo esc_url($professor_playlist); ?>" 
                                   target="_blank" 
                                   class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-full text-lg font-semibold transition-all shadow-lg hover:shadow-xl">
                                    <i class="fab fa-youtube mr-3 text-xl"></i>
                                    <?php echo esc_html($professor_name); ?>の再生リストを見る
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                </div>
                
                <!-- 右カラム：詳細情報 -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg p-8 sticky top-8">
                        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-info-circle text-green-500 mr-3"></i>
                            詳細情報
                        </h2>
                        
                        <div class="space-y-6">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-gradient-to-br from-pink-400 to-pink-600 rounded-full flex items-center justify-center text-white mr-4">
                                    <i class="fas fa-birthday-cake"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">誕生日</p>
                                    <p class="font-semibold text-gray-800">
                                        <?php echo $professor_birthday ? esc_html($professor_birthday) : '不明'; ?>
                                    </p>
                                </div>
                            </div>
                            
                            <?php if ( $professor_arrival ) : ?>
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center text-white mr-4">
                                        <i class="fas fa-home"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">お迎え日</p>
                                        <p class="font-semibold text-gray-800"><?php echo esc_html($professor_arrival); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ( $professor_origin ) : ?>
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center text-white mr-4">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">出身</p>
                                        <p class="font-semibold text-gray-800"><?php echo esc_html($professor_origin); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- 講師一覧へのリンク -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <a href="<?php echo get_post_type_archive_link('professor'); ?>" 
                               class="block w-full text-center bg-gradient-to-r from-purple-600 to-pink-600 text-white py-3 px-6 rounded-lg font-semibold hover:from-purple-700 hover:to-pink-700 transition-all">
                                <i class="fas fa-users mr-2"></i>
                                他の講師を見る
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
.professor-detail-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.professor-image-container img {
    transition: transform 0.3s ease;
}

.professor-image-container:hover img {
    transform: scale(1.05);
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
