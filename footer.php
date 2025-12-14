    </div><!-- #content -->
    
    <footer id="colophon" class="site-footer bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4">
            
            <!-- 上部：重要リンク -->
            <div class="footer-top border-b border-gray-700 pb-8 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <!-- AI活用ポリシー -->
                    <div class="policy-section">
                        <h4 class="text-lg font-bold mb-4"><i class="fas fa-robot mr-2"></i>AI活用について</h4>
                        <p class="text-sm text-gray-400 mb-4">
                            本サイトはAI技術を活用して論文の要約・講座作成を行っています。
                            できる限り正確に理解できるよう、継続的に勉強しています。
                        </p>
                        <a href="<?php echo home_url('/about/'); ?>" class="text-pink-400 hover:text-pink-300 hover:underline transition-colors">
                            詳細を読む →
                        </a>
                    </div>
                    
                    <!-- 専門家レビュー募集 -->
                    <div class="review-section">
                        <h4 class="text-lg font-bold mb-4"><i class="fas fa-user-md mr-2"></i>専門家レビュー募集</h4>
                        <p class="text-sm text-gray-400 mb-4">
                            獣医師・動物行動学者・研究者の方々からのレビューを歓迎いたします。
                            より正確に理解できるよう、ご協力いただけると嬉しいです。
                        </p>
                        <a href="<?php echo home_url('/contact/expert-review/'); ?>" class="inline-block border-2 border-pink-400 text-pink-400 px-4 py-2 rounded-full text-sm font-semibold hover:bg-pink-400 hover:text-white transition-all">
                            レビューに協力する
                        </a>
                    </div>
                    
                    <!-- 創設者メッセージ -->
                    <div class="founder-section">
                        <h4 class="text-lg font-bold mb-4"><i class="fas fa-heart mr-2"></i>創設者の想い</h4>
                        <p class="text-sm text-gray-400 mb-4">
                            猫好きとして、信頼できる情報をみんなで作っていきたい。
                            すべては愛する猫たちの幸せのために...
                        </p>
                        <a href="<?php echo home_url('/about/'); ?>" class="text-pink-400 hover:text-pink-300 hover:underline transition-colors">
                            メッセージを読む →
                        </a>
                    </div>
                    
                </div>
            </div>
            
            <!-- 中部：統計情報 -->
            <div class="footer-middle py-6 bg-gray-800 -mx-4 px-4 mb-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                    <div class="stat-item">
                        <div class="text-2xl mb-1"><i class="fas fa-graduation-cap"></i></div>
                        <div class="text-2xl font-bold text-yellow-400">
                            <?php
                            $lecture_count = wp_count_posts('lectures');
                            echo $lecture_count->publish + $lecture_count->private;
                            ?>
                        </div>
                        <div class="text-xs text-gray-400">開講講座数</div>
                    </div>
                    <div class="stat-item">
                        <div class="text-2xl mb-1"><i class="fas fa-file-alt"></i></div>
                        <div class="text-2xl font-bold text-blue-400">
                            <?php
                            $paper_count = wp_count_posts('papers');
                            echo $paper_count->publish + $paper_count->private;
                            ?>
                        </div>
                        <div class="text-xs text-gray-400">論文数</div>
                    </div>
                    <div class="stat-item">
                        <div class="text-2xl mb-1"><i class="fas fa-lightbulb"></i></div>
                        <div class="text-2xl font-bold text-green-400">
                            <?php
                            $tips_count = wp_count_posts('tips');
                            echo $tips_count->publish + $tips_count->private;
                            ?>
                        </div>
                        <div class="text-xs text-gray-400">豆知識</div>
                    </div>
                    <div class="stat-item">
                        <div class="text-2xl mb-1"><i class="fas fa-paw"></i></div>
                        <div class="text-2xl font-bold text-pink-400">1,234</div>
                        <div class="text-xs text-gray-400">受講生数</div>
                    </div>
                </div>
            </div>
            
            <!-- 下部：基本情報とナビゲーション -->
            <div class="footer-bottom">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-6">
                    
                    <!-- サイト情報 -->
                    <div class="site-info">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-graduation-cap text-3xl mr-2"></i>
                            <h5 class="text-xl font-bold">ネコフリークス大学</h5>
                        </div>
                        <p class="text-sm text-gray-400 mb-4">
                            論文×AI×猫好きの想いで作った、論文を読んで勉強したことをシェアするサイトです。<br>
                            実在の猫たちをモデルに、親しみやすい形でシェアしています。<br>
                        </p>
                        <div class="social-links flex space-x-4">
                            <!-- ソーシャルリンクがあれば追加 -->
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <span class="sr-only">Twitter</span>
                                <i class="fab fa-twitter text-xl"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <span class="sr-only">YouTube</span>
                                <i class="fab fa-youtube text-xl"></i>
                            </a>
                        </div>
                    </div>
                    
                    <!-- クイックリンク -->
                    <div class="quick-links">
                        <h5 class="text-lg font-bold mb-4">クイックリンク</h5>
                        <div class="grid grid-cols-2 gap-2">
                            <ul class="space-y-2">
                                <li><a href="<?php echo home_url('/lectures/'); ?>" class="text-sm text-gray-400 hover:text-white transition-colors"><i class="fas fa-book mr-1"></i>講座一覧</a></li>
                                <li><a href="<?php echo home_url('/papers/'); ?>" class="text-sm text-gray-400 hover:text-white transition-colors"><i class="fas fa-file-alt mr-1"></i>論文アーカイブ</a></li>
                                <li><a href="<?php echo home_url('/tips/'); ?>" class="text-sm text-gray-400 hover:text-white transition-colors"><i class="fas fa-lightbulb mr-1"></i>豆知識バンク</a></li>
                                <li><a href="<?php echo home_url('/goods/'); ?>" class="text-sm text-gray-400 hover:text-white transition-colors"><i class="fas fa-shopping-bag mr-1"></i>おすすめの商品</a></li>
                            </ul>
                            <ul class="space-y-2">
                                <li><a href="<?php echo home_url('/about/'); ?>" class="text-sm text-gray-400 hover:text-white transition-colors"><i class="fas fa-users mr-1"></i>大学について</a></li>
                                <li><a href="<?php echo home_url('/about/professors/'); ?>" class="text-sm text-gray-400 hover:text-white transition-colors"><i class="fas fa-cat mr-1"></i>講師紹介</a></li>
                                <li><a href="<?php echo home_url('/contact/'); ?>" class="text-sm text-gray-400 hover:text-white transition-colors"><i class="fas fa-envelope mr-1"></i>お問い合わせ</a></li>
                                <li><a href="<?php echo home_url('/sitemap/'); ?>" class="text-sm text-gray-400 hover:text-white transition-colors"><i class="fas fa-sitemap mr-1"></i>サイトマップ</a></li>
                            </ul>
                        </div>
                    </div>
                    
                </div>
                
                <!-- コピーライトとリーガル情報 -->
                <div class="border-t border-gray-700 pt-6">
                    <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-400">
                        <div class="mb-2 md:mb-0">
                            &copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.
                        </div>
                        <div class="flex flex-wrap space-x-4">
                            <a href="<?php echo home_url('/privacy-policy/'); ?>" class="hover:text-white transition-colors">
                                プライバシーポリシー
                            </a>
                            <a href="<?php echo home_url('/terms/'); ?>" class="hover:text-white transition-colors">
                                利用規約
                            </a>
                            <a href="<?php echo home_url('/about/'); ?>" class="hover:text-white transition-colors">
                                AI活用ポリシー
                            </a>
                        </div>
                    </div>
                    
                    <!-- 免責事項 -->
                    <div class="mt-4 text-center text-xs text-gray-500">
                        <p class="mb-1">本サイトのコンテンツはAIによる論文翻訳・要約を含みます。できる限り正確に理解しようとしていますが、</p>
                        <p>重要な判断の際は必ず獣医師等の専門家にご相談ください。</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>