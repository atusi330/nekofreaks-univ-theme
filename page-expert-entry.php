<?php
/**
 * Template Name: 専門家募集エントリー
 */
$is_submitted = isset($_GET['entry_sent']) && $_GET['entry_sent'] === '1';
get_header(); ?>

<div class="bg-gray-50 min-h-screen">
    <div class="bg-gradient-to-r from-gray-800 to-gray-900 text-white py-12 md:py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-3xl md:text-4xl font-bold mb-4"><i class="fas fa-user-md mr-3"></i>専門家監修エントリー</h1>
            <p class="text-gray-300">ネコフリークス大学の記事監修にご協力いただける専門家の方を募集しています。</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12 max-w-4xl">
        <?php if ($is_submitted) : ?>
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-paper-plane text-3xl text-green-600"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">送信いたしました</h2>
                <p class="text-gray-600 mb-8">内容を確認の上、運営事務局よりご連絡させていただきます。</p>
                <a href="<?php echo home_url(); ?>" class="inline-block bg-gray-800 text-white px-8 py-3 rounded-full hover:bg-gray-700 transition-colors">トップへ戻る</a>
            </div>
        <?php else : ?>
            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="bg-white p-6 md:p-8 rounded-xl shadow-lg">
                <input type="hidden" name="action" value="nfu_expert_entry">
                <?php wp_nonce_field('nfu_expert_entry_action', 'nfu_entry_nonce'); ?>
                <div class="hidden"><input type="text" name="nfu_honeypot" value=""></div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">お名前 <span class="text-red-500">*</span></label>
                        <input type="text" name="expert_name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">保有資格 <span class="text-red-500">*</span></label>
                        <select name="expert_qualification" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 bg-white">
                            <option value="" disabled selected>選択してください</option>
                            <option value="獣医師">獣医師</option>
                            <option value="愛玩動物看護師">愛玩動物看護師</option>
                            <option value="研究者">研究者</option>
                            <option value="その他">その他</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">所属・確認用URL <span class="text-red-500">*</span></label>
                        <input type="text" name="expert_affiliation" required placeholder="病院や活動内容が分かるURL" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">メールアドレス <span class="text-red-500">*</span></label>
                        <input type="email" name="expert_email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">メッセージ (任意)</label>
                        <textarea name="expert_message" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-lg hover:bg-blue-700 transition-colors">送信する</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>
<?php get_footer(); ?>


