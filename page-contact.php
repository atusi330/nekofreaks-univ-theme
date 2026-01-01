<?php
/**
 * Template Name: 一般お問い合わせ
 */
$is_submitted = isset($_GET['contact_sent']) && $_GET['contact_sent'] === '1';
get_header(); ?>

<div class="bg-blue-50 min-h-screen">
    <div class="bg-white border-b">
        <div class="container mx-auto px-4 py-12 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-4"><i class="fas fa-envelope mr-3 text-blue-500"></i>お問い合わせ</h1>
            <p class="text-gray-600">ご意見・ご質問はこちらからお送りください。</p>
        </div>
    </div>

    <div class="container mx-auto px-4 py-12 max-w-3xl">
        <?php if ($is_submitted) : ?>
            <div class="bg-white rounded-xl shadow p-12 text-center">
                <div class="text-green-500 text-5xl mb-4"><i class="fas fa-check-circle"></i></div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">お問い合わせを受け付けました</h2>
                <p class="text-gray-600 mb-8">確認のため自動返信メールをお送りしています。<br>お問い合わせ内容は順次確認させていただきます。</p>
                <a href="<?php echo home_url(); ?>" class="text-blue-600 hover:underline">トップページへ戻る</a>
            </div>
        <?php else : ?>
            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="bg-white p-6 md:p-10 rounded-xl shadow-lg">
                <input type="hidden" name="action" value="nfu_general_contact">
                <?php wp_nonce_field('nfu_contact_action', 'nfu_contact_nonce'); ?>
                <div class="hidden"><input type="text" name="nfu_honeypot" value=""></div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">お名前 <span class="text-red-500">*</span></label>
                        <input type="text" name="contact_name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">メールアドレス <span class="text-red-500">*</span></label>
                        <input type="email" name="contact_email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">お問い合わせ種別 <span class="text-red-500">*</span></label>
                        <select name="contact_type" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white">
                            <option value="" disabled selected>選択してください</option>
                            <option value="記事の内容について">記事の内容について</option>
                            <option value="不具合報告">サイトの不具合報告</option>
                            <option value="その他">その他</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">お問い合わせ内容 <span class="text-red-500">*</span></label>
                        <textarea name="contact_message" rows="6" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold py-4 rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all shadow-md">送信する</button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>
<?php get_footer(); ?>


