<?php
/**
 * 講師カードテンプレート
 * 
 * @param array $professor 講師情報の配列
 */
?>

<article class="professor-card bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow transform hover:-translate-y-2 transition-transform">
    <!-- 上側：講師画像セクション -->
    <div class="professor-image-section h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
        <?php if ( isset($professor['image']) && $professor['image'] ) : ?>
            <img src="<?php echo esc_url($professor['image']); ?>" 
                 alt="<?php echo esc_attr($professor['name']); ?>" 
                 class="w-full h-full object-cover">
        <?php else : ?>
            <div class="w-full h-full flex items-center justify-center">
                <i class="fas fa-cat text-6xl text-gray-400"></i>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- 下側：講師情報セクション -->
    <div class="professor-info-section p-6">
        <!-- 講師名 -->
        <div class="text-center mb-4">
            <h3 class="text-xl font-bold text-gray-800">
                <?php echo esc_html(isset($professor['name']) ? $professor['name'] : ''); ?><?php echo esc_html(isset($professor['position']) ? $professor['position'] : ''); ?>
            </h3>
        </div>
        
        <!-- 担当 -->
        <?php if ( isset($professor['specialty']) && $professor['specialty'] ) : ?>
            <div class="mb-3">
                <p class="text-sm text-gray-600">
                    <span class="font-semibold">担当：</span>
                    <?php echo esc_html($professor['specialty']); ?>
                </p>
            </div>
        <?php endif; ?>
        
        <!-- 年齢/性別 -->
        <?php if ( (isset($professor['age']) && $professor['age']) || (isset($professor['gender']) && $professor['gender']) ) : ?>
            <div class="mb-3">
                <p class="text-sm text-gray-600">
                    <span class="font-semibold">年齢/性別：</span>
                    <?php 
                    $age_gender = array();
                    if (isset($professor['age']) && $professor['age']) {
                        $age_gender[] = $professor['age'] . '歳';
                    }
                    if (isset($professor['gender']) && $professor['gender']) {
                        $age_gender[] = $professor['gender'];
                    }
                    echo esc_html(implode(' / ', $age_gender));
                    ?>
                </p>
            </div>
        <?php endif; ?>
        
        <!-- 猫種 -->
        <?php if ( isset($professor['breed']) && $professor['breed'] ) : ?>
            <div class="mb-3">
                <p class="text-sm text-gray-600">
                    <span class="font-semibold">猫種：</span>
                    <?php echo esc_html($professor['breed']); ?>
                </p>
            </div>
        <?php endif; ?>
        
        <!-- 毛色 -->
        <?php if ( isset($professor['color']) && $professor['color'] ) : ?>
            <div class="mb-3">
                <p class="text-sm text-gray-600">
                    <span class="font-semibold">毛色：</span>
                    <?php echo esc_html($professor['color']); ?>
                </p>
            </div>
        <?php endif; ?>
        
        <!-- 性格 -->
        <?php if ( isset($professor['description']) && $professor['description'] ) : ?>
            <div class="mb-4">
                <p class="text-sm text-gray-600">
                    <span class="font-semibold">性格：</span>
                    <?php echo esc_html($professor['description']); ?>
                </p>
            </div>
        <?php endif; ?>
        
        <!-- 詳細ページへのリンク -->
        <div class="text-center">
            <a href="<?php echo esc_url(isset($professor['url']) ? $professor['url'] : '#'); ?>" 
               class="inline-flex items-center bg-gradient-to-r from-purple-600 to-pink-600 text-white py-2 px-4 rounded-lg font-semibold hover:from-purple-700 hover:to-pink-700 transition-all text-sm">
                <span>詳細を見る</span>
                <i class="fas fa-paw ml-2"></i>
            </a>
        </div>
    </div>
</article>
