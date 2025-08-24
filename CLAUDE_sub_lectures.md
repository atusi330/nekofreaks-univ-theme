# CLAUDE_sub_lectures.md - 講座詳細仕様

## 講座システム概要

### 基本構造

- **1 講座 = 全 5 回の連続シリーズ**
- **配信**: 毎週金曜夜に 1 回ずつ公開
- **形式**: マロン学長 + ゲスト講師の会話形式
- **所要時間**: 各回 10-15 分で読める分量

### データ構造

```
lectures（講座親投稿）
    └── lecture_episodes（各回）
         ├── 第1回：基礎知識編
         ├── 第2回：メカニズム解説編
         ├── 第3回：実践編
         ├── 第4回：トラブル対策編
         └── 第5回：応用・まとめ編
```

## 講座一覧ページ（archive-lectures.php）

### ページ構成

```html
<!-- 講座一覧ページ -->
<div class="lectures-archive">
  <!-- ページヘッダー -->
  <section
    class="page-header bg-gradient-to-r from-primary to-primary-dark text-white py-16"
  >
    <div class="container mx-auto px-4">
      <h1 class="text-4xl font-bold text-center mb-4">📚 講座一覧</h1>
      <p class="text-xl text-center text-white/80">
        全5回の連続講座で、猫のことを楽しく学ぼう！
      </p>
    </div>
  </section>

  <!-- 講師フィルター（Ajax対応） -->
  <section
    class="professor-filter-section bg-white py-8 shadow-sm sticky top-0 z-10"
  >
    <div class="container mx-auto px-4">
      <h3 class="text-lg font-bold mb-4 text-center">🐱 講師で絞り込み</h3>
      <div
        class="filter-buttons flex flex-wrap justify-center gap-4"
        id="professor-filters"
      >
        <button
          class="filter-btn active flex items-center gap-2 px-6 py-3 rounded-full border-2 transition-all"
          data-professor="all"
        >
          <span class="icon text-2xl">🐾</span>
          <span>全て</span>
        </button>

        <button
          class="filter-btn flex items-center gap-2 px-6 py-3 rounded-full border-2 transition-all"
          data-professor="maron"
          style="--btn-color: #8B4513;"
        >
          <span class="icon text-2xl">🟫</span>
          <span>マロン学長</span>
        </button>

        <button
          class="filter-btn flex items-center gap-2 px-6 py-3 rounded-full border-2 transition-all"
          data-professor="ichi"
          style="--btn-color: #FF8C00;"
        >
          <span class="icon text-2xl">🟠</span>
          <span>いち教授</span>
        </button>

        <button
          class="filter-btn flex items-center gap-2 px-6 py-3 rounded-full border-2 transition-all"
          data-professor="hachi"
          style="--btn-color: #4682B4;"
        >
          <span class="icon text-2xl">🔵</span>
          <span>はち助教授</span>
        </button>

        <button
          class="filter-btn flex items-center gap-2 px-6 py-3 rounded-full border-2 transition-all"
          data-professor="jiji"
          style="--btn-color: #228B22;"
        >
          <span class="icon text-2xl">🟢</span>
          <span>ジジ助手</span>
        </button>

        <button
          class="filter-btn flex items-center gap-2 px-6 py-3 rounded-full border-2 transition-all"
          data-professor="daifuku"
          style="--btn-color: #9370DB;"
        >
          <span class="icon text-2xl">🟣</span>
          <span>大福先生</span>
        </button>
      </div>
    </div>
  </section>

  <!-- カテゴリフィルター -->
  <section class="category-filter-section bg-gray-50 py-6">
    <div class="container mx-auto px-4">
      <div class="flex flex-wrap justify-center gap-3">
        <span class="filter-tag active">すべて</span>
        <span class="filter-tag">行動学</span>
        <span class="filter-tag">健康・医学</span>
        <span class="filter-tag">飼育・ケア</span>
        <span class="filter-tag">猫の生態</span>
      </div>
    </div>
  </section>

  <!-- 講座カードグリッド -->
  <section class="lectures-grid-section py-12 bg-off-white">
    <div class="container mx-auto px-4">
      <!-- 結果カウント -->
      <p class="result-count text-gray-600 mb-6">
        🔄 <span id="count">12</span>件の講座を表示中
      </p>

      <!-- ローディング -->
      <div class="loading-spinner hidden">
        <div class="paw-loading text-4xl text-center">🐾</div>
      </div>

      <!-- グリッド -->
      <div
        class="lecture-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
        id="lecture-grid"
      >
        <!-- 開講中の講座カード -->
        <article
          class="lecture-card book-style bg-white rounded-lg shadow-lg hover:shadow-xl transition-all hover:-translate-y-1"
        >
          <!-- ステータスリボン -->
          <div
            class="status-ribbon absolute top-4 -right-2 bg-accent text-white px-4 py-1 rounded-l-lg shadow-md z-10"
          >
            開講中
          </div>

          <!-- 本の背表紙風デザイン -->
          <div
            class="book-spine h-2 bg-gradient-to-r from-hachi to-hachi-dark rounded-t-lg"
          ></div>

          <!-- カード本体 -->
          <div class="card-body p-6">
            <!-- 講師バッジ -->
            <div class="professor-info flex items-center gap-2 mb-3">
              <span class="professor-icon text-2xl">🔵</span>
              <span class="professor-name text-sm font-semibold text-hachi"
                >はち助教授</span
              >
            </div>

            <!-- タイトル -->
            <h3 class="lecture-title text-xl font-bold mb-3 line-clamp-2">
              猫のトイレ完全マスター講座
            </h3>

            <!-- 説明 -->
            <p
              class="lecture-description text-gray-600 text-sm mb-4 line-clamp-3"
            >
              トイレの選び方から設置場所、掃除の頻度まで。
              はち助教授が8年間のこだわりを全て伝授します。
            </p>

            <!-- 進捗表示（開講中の場合） -->
            <div class="progress-section mb-4">
              <div class="flex justify-between text-xs text-gray-500 mb-1">
                <span>進捗</span>
                <span>第3回/全5回</span>
              </div>
              <div class="progress-bar bg-gray-200 rounded-full h-2">
                <div
                  class="progress-fill bg-accent rounded-full h-2"
                  style="width: 60%"
                ></div>
              </div>
            </div>

            <!-- メタ情報 -->
            <div
              class="lecture-meta flex items-center justify-between text-sm text-gray-500"
            >
              <div class="flex items-center gap-3">
                <span>📚 全5回</span>
                <span>⭐ 4.8</span>
              </div>
              <span>👥 234名</span>
            </div>
          </div>

          <!-- アクション -->
          <div class="card-footer p-6 pt-0">
            <a
              href="/lectures/toilet-training/"
              class="btn-primary-block w-full text-center py-3 rounded-lg"
            >
              続きを受講する
            </a>
          </div>
        </article>

        <!-- 完結済み講座カード -->
        <article
          class="lecture-card book-style bg-white rounded-lg shadow-lg hover:shadow-xl transition-all hover:-translate-y-1"
        >
          <!-- 本の背表紙風デザイン -->
          <div
            class="book-spine h-2 bg-gradient-to-r from-ichi to-ichi-dark rounded-t-lg"
          ></div>

          <div class="card-body p-6">
            <!-- 講師バッジ -->
            <div class="professor-info flex items-center gap-2 mb-3">
              <span class="professor-icon text-2xl">🟠</span>
              <span class="professor-name text-sm font-semibold text-ichi"
                >いち教授</span
              >
            </div>

            <!-- タイトル -->
            <h3 class="lecture-title text-xl font-bold mb-3 line-clamp-2">
              高齢猫との暮らし方講座
            </h3>

            <!-- 説明 -->
            <p
              class="lecture-description text-gray-600 text-sm mb-4 line-clamp-3"
            >
              12歳のベテラン、いち教授が語る。
              シニア猫の健康管理から心のケアまで、経験に基づいた実践的アドバイス。
            </p>

            <!-- 完了バッジ -->
            <div
              class="completion-badge bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm inline-block mb-4"
            >
              ✅ 全5回完結
            </div>

            <!-- メタ情報 -->
            <div
              class="lecture-meta flex items-center justify-between text-sm text-gray-500"
            >
              <div class="flex items-center gap-3">
                <span>📚 全5回</span>
                <span>⭐ 4.9</span>
              </div>
              <span>👥 567名</span>
            </div>
          </div>

          <!-- アクション -->
          <div class="card-footer p-6 pt-0">
            <a
              href="/lectures/senior-cat-care/"
              class="btn-outline-primary-block w-full text-center py-3 rounded-lg"
            >
              講座を見る
            </a>
          </div>
        </article>
      </div>
    </div>
  </section>
</div>
```

## 講座詳細ページ（single-lectures.php）

### ページ構成

```html
<!-- 講座詳細ページ -->
<article class="lecture-single">
  <!-- ヘッダーセクション -->
  <section
    class="lecture-header bg-gradient-to-r from-primary to-primary-dark text-white py-16"
  >
    <div class="container mx-auto px-4 max-w-4xl">
      <!-- パンくずリスト -->
      <nav class="breadcrumb text-sm text-white/60 mb-6">
        <a href="/" class="hover:text-white">ホーム</a> &gt;
        <a href="/lectures/" class="hover:text-white">講座一覧</a> &gt;
        <span class="text-white">猫のトイレ完全マスター講座</span>
      </nav>

      <!-- 講座情報 -->
      <div class="lecture-info">
        <!-- ステータスバッジ -->
        <span
          class="status-badge bg-accent text-white px-4 py-2 rounded-full text-sm inline-block mb-4"
        >
          開講中
        </span>

        <h1 class="text-3xl md:text-4xl font-bold mb-6">
          猫のトイレ完全マスター講座
        </h1>

        <!-- 講師情報 -->
        <div class="professor-intro flex items-center gap-4 mb-6">
          <div
            class="professor-avatar w-16 h-16 bg-white/20 rounded-full flex items-center justify-center"
          >
            <span class="text-3xl">🔵</span>
          </div>
          <div>
            <p class="text-lg"><strong>メイン講師：</strong>はち助教授</p>
            <p class="text-white/80">× マロン学長</p>
          </div>
        </div>

        <!-- メタ情報 -->
        <div class="lecture-meta flex flex-wrap gap-6 text-white/90">
          <span>📚 全5回講座</span>
          <span>⏱️ 各回10-15分</span>
          <span>📊 初級〜中級</span>
          <span>👥 234名が受講中</span>
        </div>
      </div>
    </div>
  </section>

  <!-- 講座概要 -->
  <section class="lecture-overview py-12 bg-white">
    <div class="container mx-auto px-4 max-w-4xl">
      <h2 class="text-2xl font-bold mb-6">講座について</h2>

      <div class="overview-content prose prose-lg">
        <p>
          猫のトイレは、健康管理の基本であり、快適な共同生活の要です。
          この講座では、トイレのこだわりを持つはち助教授が、
          8年間の経験から得た知識とテクニックを余すことなくお伝えします。
        </p>

        <h3>この講座で学べること</h3>
        <ul>
          <li>最適なトイレの選び方と設置場所</li>
          <li>猫砂の種類と特徴、選び方のポイント</li>
          <li>掃除の頻度とタイミング</li>
          <li>トイレトラブルの原因と対処法</li>
          <li>多頭飼いでのトイレ管理</li>
        </ul>
      </div>

      <!-- 関連論文 -->
      <div class="related-paper mt-8 p-6 bg-blue-50 rounded-lg">
        <h3 class="text-lg font-bold mb-3">📄 ベースとなる論文</h3>
        <a
          href="/papers/cat-toilet-behavior-2024/"
          class="text-primary hover:underline"
        >
          「猫の排泄行動における環境要因の影響」（2024年）
        </a>
      </div>
    </div>
  </section>

  <!-- 各回の内容 -->
  <section class="lecture-episodes py-12 bg-gray-50">
    <div class="container mx-auto px-4 max-w-4xl">
      <h2 class="text-2xl font-bold mb-8 text-center">講座カリキュラム</h2>

      <!-- 進捗インジケーター -->
      <div
        class="progress-indicator flex justify-center items-center gap-2 mb-12"
      >
        <div class="episode-dot completed">
          <span>①</span>
        </div>
        <div class="progress-line completed"></div>
        <div class="episode-dot completed">
          <span>②</span>
        </div>
        <div class="progress-line completed"></div>
        <div class="episode-dot current">
          <span>③</span>
        </div>
        <div class="progress-line"></div>
        <div class="episode-dot">
          <span>④</span>
        </div>
        <div class="progress-line"></div>
        <div class="episode-dot">
          <span>⑤</span>
        </div>
      </div>

      <!-- 各回リスト -->
      <div class="episodes-list space-y-6">
        <!-- 第1回（完了） -->
        <div
          class="episode-card bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500"
        >
          <div class="flex items-start justify-between">
            <div class="flex-1">
              <div class="flex items-center gap-3 mb-2">
                <span class="episode-number text-sm font-bold text-gray-500"
                  >第1回</span
                >
                <span
                  class="completed-badge bg-green-100 text-green-700 px-2 py-1 rounded text-xs"
                >
                  ✅ 受講済み
                </span>
              </div>
              <h3 class="text-xl font-bold mb-2">
                基礎知識編：なぜトイレは大切なの？
              </h3>
              <p class="text-gray-600 mb-3">
                猫にとってトイレがどれほど重要か、健康チェックのポイントなど基本を学びます。
              </p>
              <div class="episode-meta text-sm text-gray-500">
                <span>🕐 12分</span>
                <span class="mx-2">•</span>
                <span>📅 2024.01.05 公開</span>
              </div>
            </div>
            <a
              href="/lectures/toilet-training/episode-1/"
              class="btn-outline-primary"
            >
              復習する
            </a>
          </div>
        </div>

        <!-- 第2回（完了） -->
        <div
          class="episode-card bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500"
        >
          <!-- 同様の構成 -->
        </div>

        <!-- 第3回（現在） -->
        <div
          class="episode-card bg-white rounded-lg shadow-md p-6 border-l-4 border-accent relative"
        >
          <div
            class="current-indicator absolute -left-8 top-1/2 transform -translate-y-1/2"
          >
            <span class="text-accent text-2xl">👉</span>
          </div>
          <div class="flex items-start justify-between">
            <div class="flex-1">
              <div class="flex items-center gap-3 mb-2">
                <span class="episode-number text-sm font-bold text-gray-500"
                  >第3回</span
                >
                <span
                  class="current-badge bg-accent text-white px-2 py-1 rounded text-xs"
                >
                  現在の回
                </span>
              </div>
              <h3 class="text-xl font-bold mb-2">
                実践編：理想的なトイレ環境の作り方
              </h3>
              <p class="text-gray-600 mb-3">
                トイレの設置場所、数、配置など、実際の環境づくりを詳しく解説します。
              </p>
              <div class="episode-meta text-sm text-gray-500">
                <span>🕐 15分</span>
                <span class="mx-2">•</span>
                <span>📅 2024.01.19 公開</span>
              </div>
            </div>
            <a href="/lectures/toilet-training/episode-3/" class="btn-primary">
              受講する
            </a>
          </div>
        </div>

        <!-- 第4回（未公開） -->
        <div
          class="episode-card bg-white rounded-lg shadow-md p-6 border-l-4 border-gray-300 opacity-75"
        >
          <div class="flex items-start justify-between">
            <div class="flex-1">
              <div class="flex items-center gap-3 mb-2">
                <span class="episode-number text-sm font-bold text-gray-500"
                  >第4回</span
                >
                <span
                  class="upcoming-badge bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs"
                >
                  🔒 未公開
                </span>
              </div>
              <h3 class="text-xl font-bold mb-2 text-gray-600">
                トラブル対策編：困った時の対処法
              </h3>
              <p class="text-gray-500 mb-3">
                粗相、トイレを使わない、においの問題など、よくあるトラブルの解決策。
              </p>
              <div class="episode-meta text-sm text-gray-400">
                <span>📅 2024.01.26 公開予定</span>
              </div>
            </div>
          </div>
        </div>

        <!-- 第5回（未公開） -->
        <div
          class="episode-card bg-white rounded-lg shadow-md p-6 border-l-4 border-gray-300 opacity-75"
        >
          <!-- 同様の構成 -->
        </div>
      </div>
    </div>
  </section>

  <!-- 受講者の声 -->
  <section class="testimonials py-12 bg-white">
    <div class="container mx-auto px-4 max-w-4xl">
      <h2 class="text-2xl font-bold mb-8 text-center">受講者の声</h2>

      <div class="testimonial-grid grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="testimonial-card bg-gray-50 p-6 rounded-lg">
          <div class="rating text-yellow-500 mb-2">⭐⭐⭐⭐⭐</div>
          <p class="text-gray-700 mb-3">
            「トイレの数は猫の数+1」という基本を知らなかった！
            2匹飼いなのにトイレ1つで、それが原因で...
          </p>
          <p class="text-sm text-gray-500">- 2匹の飼い主さん</p>
        </div>

        <div class="testimonial-card bg-gray-50 p-6 rounded-lg">
          <div class="rating text-yellow-500 mb-2">⭐⭐⭐⭐⭐</div>
          <p class="text-gray-700 mb-3">
            はち先生のこだわりがすごい！でも全部理にかなっていて、
            実践したら本当に改善しました。
          </p>
          <p class="text-sm text-gray-500">- 初心者飼い主さん</p>
        </div>
      </div>
    </div>
  </section>
</article>
```

## 講座回詳細ページ（single-lecture_episodes.php）

### ページ構成

```html
<!-- 講座回詳細ページ -->
<article class="lecture-episode-single">
  <!-- ヘッダー -->
  <section
    class="episode-header bg-gradient-to-r from-primary to-primary-dark text-white py-12"
  >
    <div class="container mx-auto px-4 max-w-4xl">
      <!-- パンくずリスト -->
      <nav class="breadcrumb text-sm text-white/60 mb-6">
        <a href="/" class="hover:text-white">ホーム</a> &gt;
        <a href="/lectures/" class="hover:text-white">講座一覧</a> &gt;
        <a href="/lectures/toilet-training/" class="hover:text-white"
          >猫のトイレ完全マスター講座</a
        >
        &gt;
        <span class="text-white">第3回</span>
      </nav>

      <!-- 講座タイトル -->
      <p class="lecture-name text-lg text-white/80 mb-2">
        猫のトイレ完全マスター講座
      </p>

      <h1 class="text-3xl md:text-4xl font-bold mb-4">
        第3回：実践編 - 理想的なトイレ環境の作り方
      </h1>

      <!-- 講師情報 -->
      <div class="episode-meta flex items-center gap-4">
        <span>👤 はち助教授 × マロン学長</span>
        <span>🕐 15分</span>
        <span>📅 2024.01.19</span>
      </div>
    </div>
  </section>

  <!-- 進捗インジケーター -->
  <section class="progress-section bg-white py-6 shadow-sm sticky top-0 z-10">
    <div class="container mx-auto px-4 max-w-4xl">
      <div class="progress-indicator flex justify-center items-center gap-2">
        <a
          href="/lectures/toilet-training/episode-1/"
          class="episode-dot completed clickable"
        >
          <span>①</span>
        </a>
        <div class="progress-line completed"></div>
        <a
          href="/lectures/toilet-training/episode-2/"
          class="episode-dot completed clickable"
        >
          <span>②</span>
        </a>
        <div class="progress-line completed"></div>
        <div class="episode-dot current">
          <span>③</span>
        </div>
        <div class="progress-line"></div>
        <div class="episode-dot disabled">
          <span>④</span>
        </div>
        <div class="progress-line"></div>
        <div class="episode-dot disabled">
          <span>⑤</span>
        </div>
      </div>
    </div>
  </section>

  <!-- メインコンテンツ -->
  <section class="episode-content py-12">
    <div class="container mx-auto px-4 max-w-4xl">
      <!-- オープニング会話 -->
      <div class="dialogue-section mb-12">
        <!-- マロンの発言 -->
        <div class="dialogue-box maron mb-6">
          <div class="flex items-start gap-4">
            <div class="character-icon">
              <img
                src="/assets/images/characters/maron-normal.png"
                alt="マロン学長"
                class="w-16 h-16 rounded-full"
              />
            </div>
            <div class="dialogue-content">
              <p class="speaker-name text-sm font-bold text-maron mb-1">
                マロン学長
              </p>
              <div
                class="speech-bubble bg-maron-light p-4 rounded-2xl rounded-tl-none"
              >
                <p>
                  前回はトイレの仕組みについて学んだけど、
                  今日はいよいよ実践編だね！
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- はちの発言 -->
        <div class="dialogue-box hachi mb-6">
          <div class="flex items-start gap-4 flex-row-reverse">
            <div class="character-icon">
              <img
                src="/assets/images/characters/hachi-confident.png"
                alt="はち助教授"
                class="w-16 h-16 rounded-full"
              />
            </div>
            <div class="dialogue-content">
              <p
                class="speaker-name text-sm font-bold text-hachi mb-1 text-right"
              >
                はち助教授
              </p>
              <div
                class="speech-bubble bg-hachi-light p-4 rounded-2xl rounded-tr-none"
              >
                <p>
                  そうよ。トイレ環境は猫の生活の質を大きく左右するの。
                  私の8年間のこだわりを全て教えるわ！
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 本文コンテンツ -->
      <div class="main-content prose prose-lg max-w-none">
        <h2>1. トイレの数と配置の基本原則</h2>

        <div class="content-section mb-8">
          <p>
            猫のトイレ環境を整える上で、最も重要なのが「数」と「配置」です。
            基本的な原則は以下の通りです：
          </p>

          <div class="key-point bg-yellow-50 p-6 rounded-lg my-6">
            <h3 class="text-xl font-bold mb-3">🔑 黄金の法則</h3>
            <p class="text-lg font-semibold text-center">
              トイレの数 = 猫の頭数 + 1
            </p>
          </div>

          <!-- 会話挿入 -->
          <div class="dialogue-insert my-8">
            <div class="dialogue-box maron">
              <div class="flex items-center gap-3">
                <img
                  src="/assets/images/characters/maron-surprised.png"
                  alt="マロン"
                  class="w-12 h-12 rounded-full"
                />
                <div
                  class="speech-bubble-inline bg-maron-light px-4 py-2 rounded-full"
                >
                  <p class="text-sm">えっ、1匹でも2個必要なの？</p>
                </div>
              </div>
            </div>

            <div class="dialogue-box hachi mt-3">
              <div class="flex items-center gap-3 flex-row-reverse">
                <img
                  src="/assets/images/characters/hachi-normal.png"
                  alt="はち"
                  class="w-12 h-12 rounded-full"
                />
                <div
                  class="speech-bubble-inline bg-hachi-light px-4 py-2 rounded-full"
                >
                  <p class="text-sm">そう！予備があると安心して使えるのよ</p>
                </div>
              </div>
            </div>
          </div>

          <h3>なぜ+1が必要？</h3>
          <ul>
            <li>メイントイレが汚れていても、予備がある安心感</li>
            <li>場所の好みに対応できる（1階用・2階用など）</li>
            <li>掃除中も別のトイレが使える</li>
          </ul>
        </div>

        <h2>2. 最適な設置場所の選び方</h2>

        <div class="content-section mb-8">
          <p>
            トイレの設置場所は、猫の行動パターンを考慮して決めることが大切です。
          </p>

          <!-- 図解 -->
          <figure class="my-8">
            <img
              src="/assets/images/lectures/toilet-placement-diagram.jpg"
              alt="トイレ配置の例"
              class="rounded-lg shadow-lg"
            />
            <figcaption class="text-center text-sm text-gray-600 mt-2">
              理想的なトイレ配置の例（2階建て住宅）
            </figcaption>
          </figure>

          <h3>良い設置場所の条件</h3>
          <div class="checklist bg-green-50 p-6 rounded-lg">
            <ul class="space-y-2">
              <li class="flex items-start gap-2">
                <span class="text-green-600">✓</span>
                <span>静かで落ち着ける場所</span>
              </li>
              <li class="flex items-start gap-2">
                <span class="text-green-600">✓</span>
                <span>食事場所から離れている</span>
              </li>
              <li class="flex items-start gap-2">
                <span class="text-green-600">✓</span>
                <span>換気が良い</span>
              </li>
              <li class="flex items-start gap-2">
                <span class="text-green-600">✓</span>
                <span>猫が24時間アクセスできる</span>
              </li>
            </ul>
          </div>

          <h3>避けるべき場所</h3>
          <div class="checklist bg-red-50 p-6 rounded-lg mt-4">
            <ul class="space-y-2">
              <li class="flex items-start gap-2">
                <span class="text-red-600">✗</span>
                <span>洗濯機の横（音がうるさい）</span>
              </li>
              <li class="flex items-start gap-2">
                <span class="text-red-600">✗</span>
                <span>玄関付近（人の出入りが多い）</span>
              </li>
              <li class="flex items-start gap-2">
                <span class="text-red-600">✗</span>
                <span>食事スペースの隣</span>
              </li>
            </ul>
          </div>
        </div>

        <h2>3. 実践！トイレ環境を整える手順</h2>

        <div class="step-by-step mb-8">
          <div
            class="step-card bg-white border-2 border-primary rounded-lg p-6 mb-4"
          >
            <div class="step-header flex items-center gap-4 mb-3">
              <span
                class="step-number bg-primary text-white w-10 h-10 rounded-full flex items-center justify-center font-bold"
              >
                1
              </span>
              <h4 class="text-lg font-bold">現在の環境を観察</h4>
            </div>
            <p>猫がよく過ごす場所、動線を1週間観察してメモする</p>
          </div>

          <div
            class="step-card bg-white border-2 border-primary rounded-lg p-6 mb-4"
          >
            <div class="step-header flex items-center gap-4 mb-3">
              <span
                class="step-number bg-primary text-white w-10 h-10 rounded-full flex items-center justify-center font-bold"
              >
                2
              </span>
              <h4 class="text-lg font-bold">候補地をピックアップ</h4>
            </div>
            <p>条件に合う場所を3〜4箇所選ぶ</p>
          </div>

          <!-- 以下ステップ続く -->
        </div>
      </div>

      <!-- 今回のまとめ -->
      <div class="episode-summary bg-blue-50 p-8 rounded-lg mt-12">
        <h2 class="text-2xl font-bold mb-6 text-center">
          🐾 今回のポイントまとめ
        </h2>

        <div class="summary-grid grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="summary-card bg-white p-6 rounded-lg shadow">
            <h3 class="font-bold mb-2">1. 数の法則</h3>
            <p>猫の頭数+1個のトイレを用意する</p>
          </div>

          <div class="summary-card bg-white p-6 rounded-lg shadow">
            <h3 class="font-bold mb-2">2. 場所選び</h3>
            <p>静かで、食事場所から離れた換気の良い場所</p>
          </div>

          <div class="summary-card bg-white p-6 rounded-lg shadow">
            <h3 class="font-bold mb-2">3. 猫の動線</h3>
            <p>猫の生活パターンに合わせて配置</p>
          </div>

          <div class="summary-card bg-white p-6 rounded-lg shadow">
            <h3 class="font-bold mb-2">4. 段階的導入</h3>
            <p>急な変更は避け、徐々に環境を整える</p>
          </div>
        </div>
      </div>

      <!-- クロージング会話 -->
      <div class="dialogue-section mt-12">
        <div class="dialogue-box maron mb-6">
          <div class="flex items-start gap-4">
            <div class="character-icon">
              <img
                src="/assets/images/characters/maron-happy.png"
                alt="マロン学長"
                class="w-16 h-16 rounded-full"
              />
            </div>
            <div class="dialogue-content">
              <p class="speaker-name text-sm font-bold text-maron mb-1">
                マロン学長
              </p>
              <div
                class="speech-bubble bg-maron-light p-4 rounded-2xl rounded-tl-none"
              >
                <p>
                  なるほど！トイレの場所ってそんなに大切だったんだ。
                  ぼくも実践してみよう！
                </p>
              </div>
            </div>
          </div>
        </div>

        <div class="dialogue-box hachi mb-6">
          <div class="flex items-start gap-4 flex-row-reverse">
            <div class="character-icon">
              <img
                src="/assets/images/characters/hachi-happy.png"
                alt="はち助教授"
                class="w-16 h-16 rounded-full"
              />
            </div>
            <div class="dialogue-content">
              <p
                class="speaker-name text-sm font-bold text-hachi mb-1 text-right"
              >
                はち助教授
              </p>
              <div
                class="speech-bubble bg-hachi-light p-4 rounded-2xl rounded-tr-none"
              >
                <p>
                  そうよ、環境が整えば猫も人も快適に過ごせるわ。
                  次回はトラブルが起きた時の対処法を教えるわね！
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- 次回予告 -->
      <div class="next-preview bg-gray-100 p-8 rounded-lg mt-12">
        <h3 class="text-xl font-bold mb-4">📺 次回予告</h3>
        <p class="text-lg font-semibold mb-2">
          第4回：トラブル対策編 - 困った時の対処法
        </p>
        <p class="text-gray-600 mb-4">
          粗相をしてしまう、トイレを使わない、においが気になる...
          そんなトラブルの原因と解決方法を、失敗例を交えながら解説します。
        </p>
        <p class="text-sm text-gray-500">
          📅 2024年1月26日（金）20:00 公開予定
        </p>
      </div>

      <!-- ナビゲーション -->
      <nav
        class="episode-navigation flex justify-between items-center mt-12 pt-8 border-t"
      >
        <a
          href="/lectures/toilet-training/episode-2/"
          class="flex items-center gap-2 text-primary hover:underline"
        >
          <span>←</span>
          <span>第2回：メカニズム解説編</span>
        </a>

        <a
          href="/lectures/toilet-training/"
          class="text-gray-600 hover:text-primary"
        >
          講座トップへ
        </a>

        <div class="text-gray-400">
          <span>第4回：トラブル対策編</span>
          <span>→</span>
        </div>
      </nav>
    </div>
  </section>

  <!-- 関連コンテンツ -->
  <section class="related-content bg-gray-50 py-12">
    <div class="container mx-auto px-4 max-w-4xl">
      <h3 class="text-2xl font-bold mb-6 text-center">関連コンテンツ</h3>

      <div class="related-grid grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- 関連豆知識 -->
        <div class="related-tips">
          <h4 class="text-lg font-bold mb-4">💡 関連する豆知識</h4>
          <div class="space-y-3">
            <a
              href="/tips/toilet-placement-tips/"
              class="block bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow"
            >
              <h5 class="font-bold">トイレ設置のNG例5選</h5>
              <p class="text-sm text-gray-600 mt-1">
                意外とやりがちな、猫が嫌がるトイレの置き方
              </p>
            </a>

            <a
              href="/tips/multi-cat-toilet/"
              class="block bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow"
            >
              <h5 class="font-bold">多頭飼いのトイレ管理術</h5>
              <p class="text-sm text-gray-600 mt-1">
                3匹以上の場合の効率的な配置方法
              </p>
            </a>
          </div>
        </div>

        <!-- 関連グッズ -->
        <div class="related-goods">
          <h4 class="text-lg font-bold mb-4">🛍️ おすすめグッズ</h4>
          <div class="space-y-3">
            <a
              href="/goods/system-toilet-review/"
              class="block bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow"
            >
              <h5 class="font-bold">システムトイレ徹底比較</h5>
              <p class="text-sm text-gray-600 mt-1">
                人気の3製品を実際に使って検証
              </p>
            </a>

            <a
              href="/goods/deodorizer-mat/"
              class="block bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow"
            >
              <h5 class="font-bold">トイレ下に敷く消臭マット</h5>
              <p class="text-sm text-gray-600 mt-1">
                砂の飛び散りも防げる優れもの
              </p>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
</article>
```

### 補足：アイコンは全て Font Awesome にて対応

## CSS 定義

```css
/* 講座カードのホバー効果 */
.lecture-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

/* 講師別のアクセントカラー */
.text-maron {
  color: #8b4513;
}
.text-ichi {
  color: #ff8c00;
}
.text-hachi {
  color: #4682b4;
}
.text-jiji {
  color: #228b22;
}
.text-daifuku {
  color: #9370db;
}

.bg-maron-light {
  background-color: #8b451320;
}
.bg-ichi-light {
  background-color: #ff8c0020;
}
.bg-hachi-light {
  background-color: #4682b420;
}
.bg-jiji-light {
  background-color: #228b2220;
}
.bg-daifuku-light {
  background-color: #9370db20;
}

/* フィルターボタンのアクティブ状態 */
.filter-btn.active {
  background-color: var(--btn-color);
  color: white;
  border-color: var(--btn-color);
}

/* 進捗インジケーター */
.episode-dot {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: #e5e7eb;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  color: #6b7280;
  transition: all 0.3s;
}

.episode-dot.completed {
  background: #10b981;
  color: white;
}

.episode-dot.current {
  background: #ff6b6b;
  color: white;
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.1);
  }
  100% {
    transform: scale(1);
  }
}

.progress-line {
  width: 60px;
  height: 2px;
  background: #e5e7eb;
}

.progress-line.completed {
  background: #10b981;
}

/* 吹き出しスタイル */
.speech-bubble {
  position: relative;
  max-width: 400px;
}

.speech-bubble-inline {
  display: inline-block;
}

/* 肉球ローディング */
@keyframes pawWalk {
  0% {
    content: "🐾";
    transform: translateX(0);
  }
  25% {
    content: "🐾";
    transform: translateX(10px) rotate(45deg);
  }
  50% {
    content: "🐾";
    transform: translateX(20px) rotate(0deg);
  }
  75% {
    content: "🐾";
    transform: translateX(30px) rotate(-45deg);
  }
  100% {
    content: "🐾";
    transform: translateX(40px) rotate(0deg);
  }
}

.paw-loading {
  animation: pawWalk 1s infinite;
}
```

## JavaScript 実装

```javascript
// lectures-filter.js
jQuery(document).ready(function ($) {
  let currentFilters = {
    professor: "all",
    category: "all",
  };

  // 講師フィルター
  $(".filter-btn").on("click", function () {
    const $btn = $(this);
    const professor = $btn.data("professor");

    // アクティブ状態切り替え
    $(".filter-btn").removeClass("active");
    $btn.addClass("active");

    currentFilters.professor = professor;
    loadLectures();
  });

  // 講座読み込み
  function loadLectures() {
    const $grid = $("#lecture-grid");
    const $spinner = $(".loading-spinner");

    $grid.addClass("opacity-50");
    $spinner.removeClass("hidden");

    $.ajax({
      url: neko_ajax.ajax_url,
      type: "POST",
      data: {
        action: "filter_lectures",
        nonce: neko_ajax.nonce,
        filters: currentFilters,
      },
      success: function (response) {
        if (response.success) {
          $grid.fadeOut(200, function () {
            $grid.html(response.data.html);
            $("#count").text(response.data.count);
            $grid.fadeIn(300);
            animateCards();
          });
        }
      },
      complete: function () {
        $grid.removeClass("opacity-50");
        $spinner.addClass("hidden");
      },
    });
  }

  // カードアニメーション
  function animateCards() {
    $(".lecture-card").each(function (index) {
      $(this)
        .css({
          opacity: 0,
          transform: "translateY(20px)",
        })
        .delay(index * 100)
        .animate(
          {
            opacity: 1,
          },
          300,
          function () {
            $(this).css("transform", "translateY(0)");
          }
        );
    });
  }
});
```

## ACF フィールド構成

### lectures（講座）

- related_paper (Post Object) - 関連論文
- lecture_status (Select) - 開講中/完結
- main_professor (Select) - メイン講師
- lecture_overview (Textarea) - 講座概要
- total_episodes (Number) - 全話数

### lecture_episodes（講座回）

- episode_number (Number) - 話数
- parent_lecture (Post Object) - 親講座
- guest_professor (Select) - ゲスト講師
- key_points (Textarea) - ポイント
- dialogue_json (Textarea) - 会話データ（JSON）

### 会話データ JSON 形式

```json
[
  {
    "speaker": "maron",
    "text": "今日のテーマは何かな？",
    "emotion": "curious"
  },
  {
    "speaker": "hachi",
    "text": "トイレ環境について詳しく説明するわ",
    "emotion": "confident"
  }
]
```

## レスポンシブ対応

### モバイル（〜768px）

- フィルターボタン：2 列表示
- 講座カード：1 列
- 会話：縦積み
- 進捗インジケーター：横スクロール

### タブレット（768px〜）

- フィルターボタン：3 列
- 講座カード：2 列
- 会話：そのまま

### デスクトップ（1024px〜）

- フィルターボタン：横一列
- 講座カード：3 列
- サイドバー表示可能
