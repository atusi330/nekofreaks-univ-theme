<?php
/**
 * おすすめの商品アーカイブページテンプレート
 * 
 * @package NekoFreaksUniv
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="page-header bg-gradient-to-r from-purple-600 to-pink-600 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">
                    <i class="fas fa-shopping-bag mr-4"></i>
                    おすすめの商品
                </h1>
                <p class="text-xl text-white/90 max-w-3xl mx-auto">
                    猫好きのためのおすすめ商品をご紹介します
                </p>
            </div>
        </div>
    </div>
    
    <div class="container mx-auto px-4 py-16">
        <?php nfu_breadcrumb(); ?>
        
        <!-- 準備中メッセージ -->
        <div class="max-w-3xl mx-auto">
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl shadow-lg p-12 text-center border border-purple-200">
                <div class="mb-6">
                    <div class="text-6xl mb-4">🛍️</div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-4">現在準備中です</h2>
                    <div class="w-24 h-1 bg-purple-600 mx-auto mb-6"></div>
                </div>
                
                <div class="space-y-4 text-gray-700 mb-8">
                    <p class="text-lg">
                        おすすめの商品ページは現在準備中です。
                    </p>
                    <p class="text-base">
                        猫好きの皆様に役立つ商品を厳選して、近日中に公開予定です。
                    </p>
                    <p class="text-sm text-gray-600">
                        もうしばらくお待ちください。
                    </p>
                </div>
                
                <!-- 他のページへのリンク -->
                <div class="mt-8 pt-8 border-t border-purple-200">
                    <p class="text-sm text-gray-600 mb-4">他のコンテンツもご覧ください</p>
                    <div class="flex flex-wrap justify-center gap-4">
                        <a href="<?php echo home_url('/lectures/'); ?>" 
                           class="inline-flex items-center bg-blue-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-blue-700 transition-colors">
                            <i class="fas fa-graduation-cap mr-2"></i>
                            講座一覧
                        </a>
                        <a href="<?php echo home_url('/papers/'); ?>" 
                           class="inline-flex items-center bg-green-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-green-700 transition-colors">
                            <i class="fas fa-file-alt mr-2"></i>
                            論文アーカイブ
                        </a>
                        <a href="<?php echo home_url('/tips/'); ?>" 
                           class="inline-flex items-center bg-yellow-600 text-white px-6 py-3 rounded-full font-semibold hover:bg-yellow-700 transition-colors">
                            <i class="fas fa-lightbulb mr-2"></i>
                            豆知識バンク
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>


