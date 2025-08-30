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
                    猫の論文ベースの教育メディアとして、信頼性の高い学術情報を
                    親しみやすいキャラクターと共にお届けします
                </p>
            </div>
        </div>
    </div>
    
    <div class="container mx-auto px-4 py-12">
        <?php nfu_breadcrumb(); ?>
        
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
                    <h3 class="text-xl font-bold mb-3">学術的信頼性</h3>
                    <p class="text-gray-600">
                        査読済み論文を基にした、科学的根拠のある情報のみを提供します。
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">親しみやすさ</h3>
                    <p class="text-gray-600">
                        個性豊かな猫のキャラクターが、難しい内容も分かりやすく解説します。
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-lightbulb text-2xl text-green-600"></i>
                    </div>
                    <h3 class="text-xl font-bold mb-3">実用性</h3>
                    <p class="text-gray-600">
                        日常の猫との暮らしに直接役立つ知識を、実践的な形でお届けします。
                    </p>
                </div>
            </div>
        </section>
        
        <!-- コンテンツ -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- メインコンテンツ -->
            <div class="lg:col-span-2">
                <?php while ( have_posts() ) : the_post(); ?>
                    <div class="bg-white rounded-lg shadow-md p-8 mb-8">
                        <div class="prose episode-content max-w-none">
                            <?php the_content(); ?>
                        </div>
                    </div>
                <?php endwhile; ?>
                
                <!-- AI活用ポリシー -->
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg p-8 border-l-4 border-purple-600">
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
                            専門家による内容の監修・確認を実施します
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
                    <a href="mailto:review@nekofreaks-university.com" class="inline-flex items-center text-sm bg-orange-600 text-white px-4 py-2 rounded hover:bg-orange-700 transition-colors">
                        <i class="fas fa-paper-plane mr-2"></i>
                        お問い合わせ
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>