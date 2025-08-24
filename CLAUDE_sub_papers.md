# CLAUDE_sub_papers.md - 論文アーカイブ詳細仕様

## 論文アーカイブ（/papers/）概要

論文要約を一覧表示し、検索・フィルター機能を提供するアーカイブページと、各論文の詳細を表示する個別ページで構成。

## アーカイブページ（archive-papers.php）

### デザイン仕様

- 背景：オフホワイト（#FAFAF8）
- レイアウト：グリッド表示（カード形式）
- フィルター：年代別、カテゴリ別、検索機能

### ページ構成

```html
<!-- 論文アーカイブページ -->
<div class="papers-archive">
  <!-- ページヘッダー -->
  <section class="page-header bg-primary text-white py-16">
    <div class="container mx-auto px-4">
      <h1 class="text-4xl font-bold text-center mb-4">📚 論文要約アーカイブ</h1>
      <p class="text-xl text-center text-white/80">
        最新の猫研究論文を、わかりやすく要約してお届けします
      </p>
    </div>
  </section>

  <!-- フィルター・検索セクション -->
  <section class="filter-section bg-white py-8 shadow-sm sticky top-0 z-10">
    <div class="container mx-auto px-4">
      <div class="flex flex-wrap gap-4 items-center justify-between">
        <!-- 検索ボックス -->
        <div class="search-box flex-1 max-w-md">
          <input
            type="text"
            placeholder="論文タイトル、著者、キーワードで検索"
            class="w-full px-4 py-2 border rounded-lg"
          />
        </div>

        <!-- フィルター -->
        <div class="filters flex gap-4">
          <!-- 年代フィルター -->
          <select class="filter-select px-4 py-2 border rounded-lg">
            <option value="">発表年</option>
            <option value="2024">2024年</option>
            <option value="2023">2023年</option>
            <option value="2022">2022年</option>
            <option value="older">2021年以前</option>
          </select>

          <!-- カテゴリフィルター -->
          <select class="filter-select px-4 py-2 border rounded-lg">
            <option value="">カテゴリ</option>
            <option value="behavior">行動学</option>
            <option value="health">健康・医学</option>
            <option value="nutrition">栄養学</option>
            <option value="psychology">心理学</option>
          </select>

          <!-- ソート -->
          <select class="sort-select px-4 py-2 border rounded-lg">
            <option value="newest">新しい順</option>
            <option value="oldest">古い順</option>
            <option value="popular">人気順</option>
          </select>
        </div>
      </div>
    </div>
  </section>

  <!-- 論文カードグリッド -->
  <section class="papers-grid-section py-12">
    <div class="container mx-auto px-4">
      <!-- 結果表示 -->
      <p class="result-count text-gray-600 mb-6">24件の論文が見つかりました</p>

      <!-- グリッドレイアウト -->
      <div
        class="papers-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
      >
        <!-- 論文カード（アイキャッチあり） -->
        <article
          class="paper-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow"
        >
          <!-- アイキャッチ画像 -->
          <div
            class="paper-thumbnail h-48 bg-gray-200 relative overflow-hidden"
          >
            <img
              src="paper-thumbnail.jpg"
              alt="論文サムネイル"
              class="w-full h-full object-cover"
            />
            <span
              class="year-badge absolute top-4 right-4 bg-primary text-white px-3 py-1 rounded-full text-sm"
            >
              2024
            </span>
          </div>

          <!-- 論文情報 -->
          <div class="paper-content p-6">
            <!-- カテゴリ -->
            <span class="category-tag text-sm text-primary font-semibold">
              行動学
            </span>

            <!-- タイトル -->
            <h3 class="paper-title text-xl font-bold mt-2 mb-3 line-clamp-2">
              猫の爪とぎ行動における環境要因の影響に関する研究
            </h3>

            <!-- メタ情報 -->
            <div class="paper-meta text-sm text-gray-600 mb-4">
              <p class="authors line-clamp-1">Smith, J., Johnson, A., et al.</p>
              <p class="journal italic">Journal of Feline Behavior, 2024</p>
            </div>

            <!-- 要点プレビュー -->
            <div class="summary-preview">
              <p class="text-sm text-gray-700 line-clamp-3">
                爪とぎ行動は縄張り主張だけでなく、ストレス解消の役割も。
                垂直面を好む猫が68%、材質は麻縄が最も人気...
              </p>
            </div>

            <!-- アクション -->
            <div class="paper-actions mt-4 flex justify-between items-center">
              <a
                href="/papers/scratching-behavior-2024/"
                class="text-primary hover:underline font-semibold"
              >
                詳細を読む →
              </a>
              <span class="related-lecture text-sm text-gray-500">
                📚 関連講座あり
              </span>
            </div>
          </div>
        </article>

        <!-- 論文カード（アイキャッチなし） -->
        <article
          class="paper-card bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow"
        >
          <!-- アイキャッチなしの場合のヘッダー -->
          <div
            class="paper-header-no-image bg-gradient-to-r from-primary to-primary-dark p-6 text-white"
          >
            <span
              class="year-badge bg-white/20 text-white px-3 py-1 rounded-full text-sm"
            >
              2023
            </span>
            <div class="mt-4">
              <span class="category-tag text-sm text-white/80">
                健康・医学
              </span>
              <h3 class="paper-title text-xl font-bold mt-2 line-clamp-2">
                高齢猫における腎機能マーカーの新たな指標
              </h3>
            </div>
          </div>

          <!-- 論文情報（アイキャッチなし版） -->
          <div class="paper-content p-6">
            <!-- 同じ構成 -->
          </div>
        </article>
      </div>

      <!-- ページネーション -->
      <div class="pagination flex justify-center items-center gap-2 mt-12">
        <button class="px-4 py-2 border rounded hover:bg-gray-100">←</button>
        <button class="px-4 py-2 bg-primary text-white rounded">1</button>
        <button class="px-4 py-2 border rounded hover:bg-gray-100">2</button>
        <button class="px-4 py-2 border rounded hover:bg-gray-100">3</button>
        <span class="px-2">...</span>
        <button class="px-4 py-2 border rounded hover:bg-gray-100">8</button>
        <button class="px-4 py-2 border rounded hover:bg-gray-100">→</button>
      </div>
    </div>
  </section>
</div>
```

## 論文詳細ページ（single-papers.php）

### ページ構成

```html
<!-- 論文詳細ページ -->
<article class="paper-single">
  <!-- ヘッダーセクション -->
  <section
    class="paper-header bg-gradient-to-b from-primary to-primary-dark text-white py-16"
  >
    <div class="container mx-auto px-4 max-w-4xl">
      <!-- パンくずリスト -->
      <nav class="breadcrumb text-sm text-white/60 mb-6">
        <a href="/" class="hover:text-white">ホーム</a> &gt;
        <a href="/papers/" class="hover:text-white">論文要約</a> &gt;
        <span class="text-white">現在の論文</span>
      </nav>

      <!-- 論文基本情報 -->
      <div class="paper-info">
        <span
          class="category-badge bg-white/20 text-white px-4 py-2 rounded-full text-sm inline-block mb-4"
        >
          行動学
        </span>

        <h1 class="text-3xl md:text-4xl font-bold mb-6">
          猫の爪とぎ行動における環境要因の影響に関する研究
        </h1>

        <!-- 原題 -->
        <p class="original-title text-lg text-white/80 italic mb-6">
          "Environmental Factors Influencing Scratching Behavior in Domestic
          Cats"
        </p>

        <!-- メタ情報 -->
        <div
          class="paper-meta grid grid-cols-1 md:grid-cols-2 gap-4 text-white/90"
        >
          <div><strong>著者:</strong> Smith, J., Johnson, A., Williams, K.</div>
          <div><strong>発表年:</strong> 2024年3月</div>
          <div><strong>掲載誌:</strong> Journal of Feline Behavior</div>
          <div>
            <strong>DOI:</strong>
            <a
              href="https://doi.org/10.1234/jfb.2024.001"
              class="underline hover:text-white"
              target="_blank"
              rel="noopener"
            >
              10.1234/jfb.2024.001 →
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- アイキャッチ画像（ある場合） -->
  <?php if (has_post_thumbnail()) : ?>
  <section class="paper-featured-image -mt-8 mb-12">
    <div class="container mx-auto px-4 max-w-4xl">
      <div class="rounded-lg overflow-hidden shadow-xl">
        <?php the_post_thumbnail('large', ['class' =>
        'w-full']); ?>
      </div>
    </div>
  </section>
  <?php endif; ?>

  <!-- 要点サマリー -->
  <section class="paper-summary bg-yellow-50 py-8 mb-12">
    <div class="container mx-auto px-4 max-w-4xl">
      <h2 class="text-2xl font-bold mb-6 flex items-center">📌 研究の要点</h2>

      <div class="summary-points grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="point-card bg-white p-6 rounded-lg shadow">
          <div class="point-number text-3xl font-bold text-primary mb-2">
            01
          </div>
          <p class="text-gray-700">
            爪とぎ行動は縄張り主張だけでなく、ストレス解消や爪の健康維持にも重要な役割を果たしている
          </p>
        </div>

        <div class="point-card bg-white p-6 rounded-lg shadow">
          <div class="point-number text-3xl font-bold text-primary mb-2">
            02
          </div>
          <p class="text-gray-700">
            68%の猫が垂直面での爪とぎを好み、材質は麻縄が最も人気（42%）
          </p>
        </div>

        <div class="point-card bg-white p-6 rounded-lg shadow">
          <div class="point-number text-3xl font-bold text-primary mb-2">
            03
          </div>
          <p class="text-gray-700">
            爪とぎ場所の設置位置は、猫の生活動線上が最も効果的
          </p>
        </div>

        <div class="point-card bg-white p-6 rounded-lg shadow">
          <div class="point-number text-3xl font-bold text-primary mb-2">
            04
          </div>
          <p class="text-gray-700">
            多頭飼いの場合、頭数+1個の爪とぎ設置が推奨される
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- 詳細解説 -->
  <section class="paper-detail mb-12">
    <div class="container mx-auto px-4 max-w-4xl">
      <div class="prose prose-lg max-w-none">
        <h2>研究の背景</h2>
        <p>
          猫の爪とぎ行動は、飼い主にとって悩みの種となることが多い一方で、
          猫にとっては本能的で必要不可欠な行動です。本研究では...
        </p>

        <h2>研究方法</h2>
        <p>
          234頭の室内飼い猫を対象に、12ヶ月間の観察調査を実施。
          爪とぎの頻度、場所、時間帯などを記録し...
        </p>

        <h3>調査項目</h3>
        <ul>
          <li>爪とぎの頻度と時間帯</li>
          <li>好まれる材質と設置角度</li>
          <li>環境要因（騒音、他の猫の存在など）</li>
          <li>年齢・性別による違い</li>
        </ul>

        <h2>主な発見</h2>
        <p>調査の結果、以下のような興味深い発見がありました：</p>

        <!-- 図表があれば挿入 -->
        <figure class="my-8">
          <img
            src="graph-scratching-preference.jpg"
            alt="爪とぎ材質の好み"
            class="rounded-lg shadow-lg"
          />
          <figcaption class="text-center text-sm text-gray-600 mt-2">
            図1: 爪とぎ材質の好み（n=234）
          </figcaption>
        </figure>

        <h2>実践への応用</h2>
        <p>この研究結果を日常生活に活かすには...</p>
      </div>
    </div>
  </section>

  <!-- 関連コンテンツ -->
  <section class="related-content bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-4xl">
      <!-- 関連講座 -->
      <div class="related-lecture mb-8">
        <h3 class="text-2xl font-bold mb-6">📚 この論文をベースにした講座</h3>

        <div
          class="lecture-link-card bg-white p-6 rounded-lg shadow-lg border-l-4 border-primary"
        >
          <div class="flex items-center justify-between">
            <div>
              <h4 class="text-xl font-bold mb-2">猫の爪とぎ完全マスター講座</h4>
              <p class="text-gray-600 mb-2">
                いち教授が、爪とぎの基礎から応用まで5回に分けて解説します
              </p>
              <div class="flex items-center gap-4 text-sm text-gray-500">
                <span>🎓 全5回</span>
                <span>👤 いち教授</span>
                <span>📊 初級〜中級</span>
              </div>
            </div>
            <a
              href="/lectures/scratching-master/"
              class="btn-primary whitespace-nowrap"
            >
              講座を見る
            </a>
          </div>
        </div>
      </div>

      <!-- 関連論文 -->
      <div class="related-papers">
        <h3 class="text-2xl font-bold mb-6">📄 関連する論文</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <a
            href="/papers/cat-stress-2023/"
            class="related-paper-card block bg-white p-4 rounded-lg shadow hover:shadow-lg transition-shadow"
          >
            <span class="text-sm text-gray-500">2023年</span>
            <h4 class="font-bold mt-1">
              猫のストレス行動と環境エンリッチメント
            </h4>
          </a>

          <a
            href="/papers/multi-cat-household-2024/"
            class="related-paper-card block bg-white p-4 rounded-lg shadow hover:shadow-lg transition-shadow"
          >
            <span class="text-sm text-gray-500">2024年</span>
            <h4 class="font-bold mt-1">多頭飼育環境における猫の行動変化</h4>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- 引用情報 -->
  <section class="citation-info py-8 border-t">
    <div class="container mx-auto px-4 max-w-4xl">
      <h3 class="text-lg font-bold mb-4">引用情報</h3>
      <div class="bg-gray-100 p-4 rounded-lg font-mono text-sm">
        <p>
          Smith, J., Johnson, A., Williams, K. (2024). Environmental Factors
          Influencing Scratching Behavior in Domestic Cats. Journal of Feline
          Behavior, 15(3), 234-248. https://doi.org/10.1234/jfb.2024.001
        </p>
      </div>
      <p class="text-sm text-gray-600 mt-2">
        ※ 本記事は上記論文の内容を要約・解説したものです。
        詳細は原論文をご参照ください。
      </p>
    </div>
  </section>
</article>
```

## PHP コード実装

### ACF フィールド設定

```php
// アイキャッチ画像は WordPress標準機能を使用
add_theme_support('post-thumbnails');

// papers投稿タイプでアイキャッチを有効化
function enable_paper_thumbnails() {
    add_post_type_support('papers', 'thumbnail');
}
add_action('init', 'enable_paper_thumbnails');
```

### 表示制御

```php
// アイキャッチの有無で表示を切り替え
<?php if (has_post_thumbnail()) : ?>
    <!-- アイキャッチありのレイアウト -->
    <div class="paper-thumbnail">
        <?php the_post_thumbnail('medium', ['class' => 'w-full h-full object-cover']); ?>
    </div>
<?php else : ?>
    <!-- アイキャッチなしのレイアウト -->
    <div class="paper-header-no-image bg-gradient-to-r from-primary to-primary-dark p-6">
        <!-- 代替デザイン -->
    </div>
<?php endif; ?>

// 要点の表示（改行区切り）
<?php
$summary_points = get_field('summary_points');
if ($summary_points) {
    $points = explode("\n", $summary_points);
    foreach ($points as $index => $point) {
        $point = trim($point);
        if ($point) {
            echo '<div class="point-card">';
            echo '<div class="point-number">' . str_pad($index + 1, 2, '0', STR_PAD_LEFT) . '</div>';
            echo '<p>' . esc_html($point) . '</p>';
            echo '</div>';
        }
    }
}
?>
```

## レスポンシブ対応

### モバイル（〜768px）

- カード 1 列表示
- 要点は縦並び
- フィルターは縦積み

### タブレット（768px〜1024px）

- カード 2 列表示
- 要点は 2 列維持

### デスクトップ（1024px〜）

- カード 3 列表示
- 要点は 2 列
- フィルター横並び

## 必要な ACF フィールド

### papers 投稿タイプ用

- original_title (Text) - 原題
- authors (Textarea) - 著者
- published_year (Number) - 発表年
- journal (Text) - 掲載誌
- doi_link (URL) - 論文リンク
- summary_points (Textarea) - 要点（改行区切り）
