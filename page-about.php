<?php
/**
 * Template Name: 大学について
 * 
 * 大学について（About）ページテンプレート
 * 
 * @package NekoFreaksUniv
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="page-header bg-gradient-to-r from-blue-600 to-purple-600 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-5xl font-bold mb-6">
                    <i class="fas fa-graduation-cap mr-4"></i>
                    ネコフリークス大学について
                </h1>
                <p class="text-xl text-white/90 max-w-3xl mx-auto">
                    猫の論文を読んで勉強したことを、親しみやすいキャラクターと共にシェアするサイトです
                </p>
            </div>
        </div>
    </div>
    
    <div class="container mx-auto px-4 py-12">
        <?php nfu_breadcrumb(); ?>
        
        <!-- 世界観説明セクション -->
        <section class="mb-16">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">ネコフリークス大学とは？</h2>
                <div class="w-24 h-1 bg-purple-600 mx-auto"></div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- メインコンテンツ -->
                <div class="lg:col-span-2">
                <!-- メインカード -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
                    <!-- ヘッダー部分 -->
                    <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white p-8 text-center">
                        <div class="text-6xl mb-4">🎓✨</div>
                        <h3 class="text-3xl font-bold mb-2">架空の猫の大学です</h3>
                        <p class="text-lg text-white/90">実在の猫をモデルにしたキャラクターが案内します</p>
                    </div>
                    
                    <!-- コンテンツ部分 -->
                    <div class="p-8">
                        <div class="space-y-6 text-gray-700">
                            <!-- 説明文1 -->
                            <div class="bg-blue-50 rounded-lg p-6 border-l-4 border-blue-500">
                                <p class="text-lg leading-relaxed">
                                    「ネコフリークス大学」は、実在の<strong class="text-blue-700">5匹の猫たち</strong>をモデルにした
                                    <strong class="text-blue-700">架空の大学</strong>です。
                                </p>
                            </div>
                            
                            <!-- 説明文2 -->
                            <div class="bg-purple-50 rounded-lg p-6 border-l-4 border-purple-500">
                                <p class="text-lg leading-relaxed">
                                    猫たちが「マロン学長」「いち教授」などの<strong class="text-purple-700">キャラクター</strong>として登場し、
                                    獣医学・動物行動学の論文を一緒に学んでいくという設定で運営しています。
                                </p>
                            </div>
                            
                            <!-- 制作体制カード -->
                            <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border-2 border-gray-200 shadow-sm">
                                <h4 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                                    <i class="fas fa-info-circle text-purple-600 mr-3 text-2xl"></i>
                                    実際の制作体制
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-user text-purple-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800 mb-1">運営者</p>
                                                <p class="text-sm text-gray-600">猫好きの一般人<br>（獣医師・研究者ではありません）</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-robot text-blue-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800 mb-1">AI活用</p>
                                                <p class="text-sm text-gray-600">英語論文の翻訳・理解をサポート</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-book text-green-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800 mb-1">情報源</p>
                                                <p class="text-sm text-gray-600">査読済み学術論文・獣医学ガイドライン</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="bg-white rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 w-10 h-10 bg-pink-100 rounded-full flex items-center justify-center mr-3">
                                                <i class="fas fa-cat text-pink-600"></i>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-800 mb-1">キャラクター</p>
                                                <p class="text-sm text-gray-600">実在の猫5匹をモデルに作成</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- まとめメッセージ -->
                            <div class="bg-yellow-50 rounded-lg p-6 border-l-4 border-yellow-400">
                                <p class="text-base leading-relaxed text-gray-700">
                                    <i class="fas fa-lightbulb text-yellow-600 mr-2"></i>
                                    専門家ではない私たちが、論文を読んで勉強したことを
                                    <strong class="text-yellow-700">「猫の教授たち」というキャラクター</strong>を通じて、
                                    親しみやすくお届けしています。
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                
                <!-- サイドバー -->
                <div class="space-y-6">
                    <!-- 講師紹介 -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="font-bold text-gray-800 mb-4">
                            <i class="fas fa-users text-blue-600 mr-2"></i>
                            講師陣
                        </h3>
                        
                        <div class="space-y-4">
                            <?php
                            // 講師データを取得
                            $professors = nfu_get_professors();
                            
                            if ($professors) :
                                foreach ($professors as $professor) :
                                    // 講師IDに基づいて背景色を設定
                                    $bg_color_class = 'bg-gray-50';
                                    $text_color_class = 'text-gray-700';
                                    
                                    switch ($professor['professor_id']) {
                                        case 'maron':
                                            $bg_color_class = 'bg-orange-50';
                                            $text_color_class = 'text-orange-700';
                                            break;
                                        case 'ichi':
                                            $bg_color_class = 'bg-orange-50';
                                            $text_color_class = 'text-orange-700';
                                            break;
                                        case 'hachi':
                                            $bg_color_class = 'bg-blue-50';
                                            $text_color_class = 'text-blue-700';
                                            break;
                                        case 'jiji':
                                            $bg_color_class = 'bg-green-50';
                                            $text_color_class = 'text-green-700';
                                            break;
                                        case 'daifuku':
                                            $bg_color_class = 'bg-purple-50';
                                            $text_color_class = 'text-purple-700';
                                            break;
                                    }
                            ?>
                                <a href="<?php echo esc_url($professor['url']); ?>" 
                                   class="block hover:shadow-md transition-shadow">
                                    <div class="flex items-center p-3 rounded-lg <?php echo $bg_color_class; ?> hover:bg-opacity-80 transition-colors">
                                        <div class="w-12 h-12 rounded-full overflow-hidden flex-shrink-0 mr-3 border-2 border-white shadow-sm">
                                            <?php if (isset($professor['image']) && $professor['image']) : ?>
                                                <img src="<?php echo esc_url($professor['image']); ?>" 
                                                     alt="<?php echo esc_attr($professor['name']); ?>" 
                                                     class="w-full h-full object-cover">
                                            <?php else : ?>
                                                <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                                    <i class="fas fa-cat text-gray-400"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-semibold <?php echo $text_color_class; ?> truncate">
                                                <?php echo esc_html($professor['name']); ?>
                                            </h4>
                                            <p class="text-xs text-gray-600 truncate">
                                                <?php echo esc_html(isset($professor['responsibility']) ? $professor['responsibility'] : ''); ?>
                                            </p>
                                        </div>
                                        <div class="ml-2">
                                            <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                                        </div>
                                    </div>
                                </a>
                            <?php 
                                endforeach;
                            else :
                            ?>
                                <div class="text-center text-gray-500 py-4">
                                    <i class="fas fa-cat text-2xl mb-2"></i>
                                    <p class="text-sm">講師情報を読み込み中...</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- 統計情報 -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="font-bold text-gray-800 mb-4">
                            <i class="fas fa-chart-bar text-green-600 mr-2"></i>
                            サイト統計
                        </h3>
                        
                        <div class="space-y-3">
                            <?php
                            $lectures_count = wp_count_posts('lectures')->publish;
                            $papers_count = wp_count_posts('papers')->publish;
                            $tips_count = wp_count_posts('tips')->publish;
                            ?>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">開講中の講座</span>
                                <span class="font-bold text-purple-600"><?php echo $lectures_count; ?>講座</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">論文要約</span>
                                <span class="font-bold text-blue-600"><?php echo $papers_count; ?>本</span>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">豆知識記事</span>
                                <span class="font-bold text-yellow-600"><?php echo $tips_count; ?>記事</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- お問い合わせ -->
                    <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg p-6 border border-yellow-200">
                        <h3 class="font-bold text-gray-800 mb-3">
                            <i class="fas fa-envelope text-orange-600 mr-2"></i>
                            専門家レビュー募集
                        </h3>
                        <p class="text-sm text-gray-700 mb-4">
                            獣医師・動物行動学者の方で、コンテンツレビューにご協力いただける方を募集しています。
                        </p>
                        <a href="<?php echo home_url('/expert-entry/'); ?>" class="inline-flex items-center text-sm text-white px-4 py-2 rounded transition-colors shadow-md hover:shadow-lg bg-yellow-500 hover:bg-yellow-600">
                            <i class="fas fa-paper-plane mr-2"></i>
                            お問い合わせ
                        </a>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- コンテンツ -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- メインコンテンツ -->
            <div class="lg:col-span-2">
                <!-- ミッション -->
                <section class="mb-16">
                    <div class="text-center mb-12">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">私たちのミッション</h2>
                        <div class="w-24 h-1 bg-purple-600 mx-auto"></div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-search text-2xl text-blue-600"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-3">論文を読んで学ぶ</h3>
                            <p class="text-gray-600">
                                査読済み論文を読んで、勉強したことをシェアしています。
                            </p>
                        </div>
                        
                        <div class="text-center">
                            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-heart text-2xl text-purple-600"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-3">親しみやすさ</h3>
                            <p class="text-gray-600">
                                個性豊かな猫のキャラクターが、難しい内容も一緒に学んでいきます。
                            </p>
                        </div>
                        
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-lightbulb text-2xl text-green-600"></i>
                            </div>
                            <h3 class="text-xl font-bold mb-3">実用性</h3>
                            <p class="text-gray-600">
                                日常の猫との暮らしに直接役立つ知識を、勉強したことをまとめてシェアします。
                            </p>
                        </div>
                    </div>
                </section>
                <?php while ( have_posts() ) : the_post(); ?>
                    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                        <div class="prose episode-content max-w-none">
                            <?php the_content(); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
                
                <!-- AI活用ポリシー -->
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-8 border-l-4 border-purple-600 mb-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">
                        <i class="fas fa-robot text-purple-600 mr-2"></i>
                        AI活用ポリシー
                    </h3>
                    <p class="text-gray-700 mb-4">
                        当サイトでは、コンテンツ制作にAI技術を活用しています。ただし、以下の原則に従って運用しています：
                    </p>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                            すべての情報は査読済み学術論文を出典とします
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                            専門家によるレビュー体制の構築と、正確性の向上に努めています
                            <span class="text-xs text-gray-500 ml-1">（※全記事の監修を保証するものではありません）</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                            出典・参考文献は必ず明示します
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check text-green-500 mr-2 mt-1"></i>
                            AIは情報整理・表現の補助として活用します
                        </li>
                    </ul>
                </div>
                
                <!-- 運営者紹介 -->
                <?php
                $operator_image = nfu_get_field('operator_image');
                $operator_profile = nfu_get_field('operator_profile');
                $operator_sns = nfu_get_field('operator_sns');
                
                if ($operator_image || $operator_profile || $operator_sns) :
                ?>
                    <section class="operator-intro bg-white rounded-xl shadow-lg p-8 mb-8">
                        <div class="text-center mb-8">
                            <h2 class="text-3xl font-bold text-gray-800 mb-4">運営者紹介</h2>
                            <div class="w-24 h-1 bg-purple-600 mx-auto"></div>
                        </div>
                        
                        <div class="flex flex-col md:flex-row items-center md:items-start gap-8">
                            <!-- 運営者画像 -->
                            <?php if ($operator_image) : ?>
                                <div class="flex-shrink-0">
                                    <?php 
                                    $image_url = is_array($operator_image) ? $operator_image['url'] : $operator_image;
                                    $image_alt = is_array($operator_image) ? $operator_image['alt'] : '運営者';
                                    ?>
                                    <div class="w-48 h-48 rounded-full overflow-hidden shadow-xl border-4 border-purple-200">
                                        <img src="<?php echo esc_url($image_url); ?>" 
                                             alt="<?php echo esc_attr($image_alt); ?>" 
                                             class="w-full h-full object-cover">
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- プロフィール -->
                            <div class="flex-1">
                                <?php if ($operator_profile) : ?>
                                    <div class="prose max-w-none text-gray-700 leading-relaxed mb-6">
                                        <?php echo wpautop(esc_html($operator_profile)); ?>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- SNSリンク -->
                                <?php if ($operator_sns) : 
                                    $sns_links = array();
                                    if (!empty($operator_sns['twitter'])) {
                                        $sns_links[] = array('url' => $operator_sns['twitter'], 'icon' => 'fab fa-x-twitter', 'label' => 'Twitter / X', 'color' => 'bg-black hover:bg-gray-800');
                                    }
                                    if (!empty($operator_sns['instagram'])) {
                                        $sns_links[] = array('url' => $operator_sns['instagram'], 'icon' => 'fab fa-instagram', 'label' => 'Instagram', 'color' => 'bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600');
                                    }
                                    if (!empty($operator_sns['youtube'])) {
                                        $sns_links[] = array('url' => $operator_sns['youtube'], 'icon' => 'fab fa-youtube', 'label' => 'YouTube', 'color' => 'bg-red-600 hover:bg-red-700');
                                    }
                                    if (!empty($operator_sns['facebook'])) {
                                        $sns_links[] = array('url' => $operator_sns['facebook'], 'icon' => 'fab fa-facebook', 'label' => 'Facebook', 'color' => 'bg-blue-600 hover:bg-blue-700');
                                    }
                                    if (!empty($operator_sns['blog'])) {
                                        $sns_links[] = array('url' => $operator_sns['blog'], 'icon' => 'fas fa-blog', 'label' => 'ブログ', 'color' => 'bg-green-600 hover:bg-green-700');
                                    }
                                    
                                    if (!empty($sns_links)) :
                                ?>
                                    <div class="sns-links">
                                        <h3 class="text-lg font-semibold text-gray-800 mb-4">SNS・リンク</h3>
                                        <div class="flex flex-wrap gap-3">
                                            <?php foreach ($sns_links as $sns) : ?>
                                                <a href="<?php echo esc_url($sns['url']); ?>" 
                                                   target="_blank" 
                                                   rel="noopener noreferrer"
                                                   class="inline-flex items-center <?php echo esc_attr($sns['color']); ?> text-white px-4 py-2 rounded-full font-semibold transition-all shadow-md hover:shadow-lg transform hover:-translate-y-1">
                                                    <i class="<?php echo esc_attr($sns['icon']); ?> mr-2"></i>
                                                    <?php echo esc_html($sns['label']); ?>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php 
                                    endif;
                                endif; ?>
                            </div>
                        </div>
                    </section>
                <?php endif; ?>
            </div>
            
            <!-- サイドバー（空 - 既に上に表示済み） -->
            <div class="lg:col-span-1">
                <!-- サイドバーは「ネコフリークス大学とは」セクションに移動済み -->
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>