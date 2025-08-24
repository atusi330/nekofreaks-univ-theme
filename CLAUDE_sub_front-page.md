# CLAUDE_sub_front-page トップページ（front-page.php）詳細設計

## ページ構成とセクション詳細

### 1. ヒーローセクション

#### デザイン仕様
```
背景：黒板テクスチャー（#2D3E50）
高さ：100vh（ファーストビューフル表示）
```

#### コンテンツ構成
```html
<section class="hero-section bg-board-texture">
  <div class="container mx-auto px-4 py-16">
    <!-- ロゴ・タイトル -->
    <h1 class="text-6xl font-bold text-white text-center mb-8">
      ネコフリークス大学
    </h1>
    <p class="text-xl text-white/80 text-center mb-12">
      論文から学ぶ、本格的な猫の知識
    </p>
    
    <!-- マロン学長のウェルカムメッセージ -->
    <div class="welcome-message flex items-center justify-center">
      <div class="maron-character">
        <img src="maron-welcome.png" alt="マロン学長" class="w-48 h-48">
      </div>
      <div class="speech-bubble bg-white p-6 rounded-xl shadow-lg max-w-md">
        <p class="text-lg text-gray-800">
          「ようこそ！ネコフリークス大学へ！<br>
          ぼくと一緒に、猫のこと、たくさん学ぼうね！」
        </p>
        <p class="text-sm text-gray-600 mt-2">- マロン学長</p>
      </div>
    </div>
    
    <!-- CTA ボタン -->
    <div class="text-center mt-12">
      <a href="#current-lecture" class="btn-primary">
        今週の講座を見る
      </a>
    </div>
  </div>
</section>
```

### 2. 現在開講中の講座

#### デザイン仕様
```
背景：白（#FFFFFF）
パディング：80px 0
```

#### コンテンツ構成
```html
<section id="current-lecture" class="current-lecture-section py-20 bg-white">
  <div class="container mx-auto px-4">
    <h2 class="section-title text-4xl font-bold text-center mb-12">
      📚 現在開講中の講座
    </h2>
    
    <!-- 講座カード -->
    <div class="lecture-card bg-gradient-to-r from-primary to-primary-dark rounded-xl p-8 text-white">
      <div class="flex flex-col md:flex-row items-center gap-8">
        <!-- 講座情報 -->
        <div class="flex-1">
          <span class="badge bg-accent text-white px-3 py-1 rounded-full text-sm">
            開講中
          </span>
          <h3 class="text-3xl font-bold mt-4 mb-2">
            猫のトイレ完全マスター講座
          </h3>
          <p class="text-lg opacity-90 mb-4">
            担当：はち助教授 × マロン学長
          </p>
          
          <!-- 進捗表示 -->
          <div class="progress-indicator mb-6">
            <p class="text-sm mb-2">現在：第3回 / 全5回</p>
            <div class="progress-bar bg-white/20 rounded-full h-4">
              <div class="progress-fill bg-accent rounded-full h-4 w-3/5 flex items-center justify-end pr-2">
                <span class="text-xs">🐾</span>
              </div>
            </div>
          </div>
          
          <!-- 次回予告 -->
          <div class="next-episode bg-white/10 rounded-lg p-4">
            <p class="text-sm font-semibold">次回予告（金曜20:00公開）</p>
            <p class="text-sm mt-1">第4回：トラブル対策編 - 粗相の原因と対処法</p>
          </div>
        </div>
        
        <!-- 講座サムネイル -->
        <div class="lecture-thumbnail">
          <img src="lecture-toilet-thumb.jpg" alt="講座サムネイル" 
               class="w-64 h-64 object-cover rounded-lg shadow-xl">
        </div>
      </div>
      
      <!-- アクションボタン -->
      <div class="mt-6 flex gap-4">
        <a href="/lectures/toilet-training/episode-3/" class="btn-white">
          第3回を受講する
        </a>
        <a href="/lectures/toilet-training/" class="btn-outline-white">
          講座の詳細を見る
        </a>
      </div>
    </div>
  </div>
</section>
```

### 3. 受講可能な講座一覧

#### デザイン仕様
```
背景：オフホワイト（#FAFAF8）
カード：本の表紙風デザイン
```

#### コンテンツ構成
```html
<section class="available-lectures-section py-20 bg-off-white">
  <div class="container mx-auto px-4">
    <h2 class="section-title text-4xl font-bold text-center mb-12">
      📖 受講可能な講座
    </h2>
    
    <!-- 講座グリッド -->
    <div class="lecture-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      
      <!-- 講座カード（繰り返し） -->
      <article class="lecture-book-card">
        <div class="book-cover bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-shadow">
          <!-- 表紙デザイン -->
          <div class="book-spine bg-gradient-to-r from-ichi to-ichi-dark h-2 rounded-t-lg"></div>
          
          <!-- 講座情報 -->
          <div class="mt-4">
            <span class="professor-badge text-ichi text-sm font-semibold">
              いち教授
            </span>
            <h3 class="text-xl font-bold mt-2 mb-2">
              高齢猫との暮らし方講座
            </h3>
            <p class="text-gray-600 text-sm mb-4">
              シニア猫の健康管理から心のケアまで、12歳のいち教授が経験を語ります
            </p>
            
            <!-- メタ情報 -->
            <div class="flex items-center gap-4 text-sm text-gray-500">
              <span>🎓 全5回</span>
              <span>📚 中級</span>
              <span>👥 523名受講</span>
            </div>
          </div>
          
          <!-- ホバー時のオーバーレイ -->
          <div class="book-overlay">
            <a href="/lectures/senior-cat-care/" class="btn-primary-sm">
              講座を見る
            </a>
          </div>
        </div>
      </article>
      
      <!-- 他の講座カード... -->
      
    </div>
    
    <!-- もっと見るリンク -->
    <div class="text-center mt-12">
      <a href="/lectures/" class="btn-outline-primary">
        すべての講座を見る →
      </a>
    </div>
  </div>
</section>
```

### 4. 今週の更新情報

#### デザイン仕様
```
背景：白（#FFFFFF）
2カラムレイアウト（豆知識・グッズ）
```

#### コンテンツ構成
```html
<section class="weekly-updates-section py-20 bg-white">
  <div class="container mx-auto px-4">
    <h2 class="section-title text-4xl font-bold text-center mb-12">
      ✨ 今週の更新情報
    </h2>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
      
      <!-- 豆知識 -->
      <div class="tips-column">
        <h3 class="text-2xl font-bold mb-6 flex items-center">
          💡 最新の豆知識
        </h3>
        
        <div class="tips-list space-y-4">
          <!-- 豆知識カード -->
          <article class="tip-card bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
            <span class="date text-sm text-gray-600">2024.01.15（月）</span>
            <h4 class="font-bold mt-1">
              猫がトイレの後に猛ダッシュする理由
            </h4>
            <p class="text-sm text-gray-700 mt-2">
              実は野生の本能が関係していた！トイレ後の行動から見る猫の心理とは...
            </p>
            <a href="/tips/toilet-dash/" class="text-primary text-sm hover:underline">
              続きを読む →
            </a>
          </article>
          
          <!-- 他の豆知識... -->
        </div>
      </div>
      
      <!-- グッズ紹介 -->
      <div class="goods-column">
        <h3 class="text-2xl font-bold mb-6 flex items-center">
          🛍️ 今週のおすすめグッズ
        </h3>
        
        <div class="goods-list space-y-4">
          <!-- グッズカード -->
          <article class="goods-card bg-purple-50 rounded-lg p-4 flex gap-4">
            <img src="goods-thumb.jpg" alt="商品画像" 
                 class="w-24 h-24 object-cover rounded">
            <div class="flex-1">
              <span class="date text-sm text-gray-600">2024.01.16（火）</span>
              <h4 class="font-bold mt-1">
                においを99%カット！最新猫砂レビュー
              </h4>
              <div class="rating text-yellow-500 text-sm mt-1">
                ⭐⭐⭐⭐⭐ (4.8)
              </div>
              <a href="/goods/deodorant-cat-litter/" class="text-primary text-sm hover:underline">
                詳細を見る →
              </a>
            </div>
          </article>
          
          <!-- 他のグッズ... -->
        </div>
      </div>
      
    </div>
  </div>
</section>
```

### 5. ネコフリークス大学について（簡易版）

#### デザイン仕様
```
背景：紺色グラデーション
アイコン付き3カラム
```

#### コンテンツ構成
```html
<section class="about-section py-20 bg-gradient-to-b from-primary to-primary-dark text-white">
  <div class="container mx-auto px-4">
    <h2 class="section-title text-4xl font-bold text-center mb-12">
      🎓 ネコフリークス大学とは
    </h2>
    
    <p class="text-xl text-center mb-12 max-w-3xl mx-auto">
      論文×AI×猫好きの想いで作った、信頼できる猫情報メディアです
    </p>
    
    <!-- 3つの特徴 -->
    <div class="features grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
      
      <div class="feature text-center">
        <div class="icon bg-white/20 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4">
          📄
        </div>
        <h3 class="text-xl font-bold mb-2">論文ベースの確かな情報</h3>
        <p class="text-white/80">
          最新の研究論文をAIで分析し、科学的根拠に基づいた情報を提供
        </p>
      </div>
      
      <div class="feature text-center">
        <div class="icon bg-white/20 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4">
          🐱
        </div>
        <h3 class="text-xl font-bold mb-2">楽しく学べるキャラクター講義</h3>
        <p class="text-white/80">
          5匹の個性豊かな猫講師たちが、会話形式で分かりやすく解説
        </p>
      </div>
      
      <div class="feature text-center">
        <div class="icon bg-white/20 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4">
          🤖
        </div>
        <h3 class="text-xl font-bold mb-2">AI活用による最新情報</h3>
        <p class="text-white/80">
          常に最新の研究成果を反映し、専門家レビューで品質を保証
        </p>
      </div>
      
    </div>
    
    <!-- 詳細リンク -->
    <div class="text-center">
      <a href="/about/" class="btn-white">
        詳しく見る
      </a>
    </div>
  </div>
</section>
```

### 6. フッター

#### コンテンツ構成
```html
<footer class="site-footer bg-gray-900 text-white py-12">
  <div class="container mx-auto px-4">
    
    <!-- 上部：重要リンク -->
    <div class="footer-top border-b border-gray-700 pb-8 mb-8">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- AI活用ポリシー -->
        <div class="policy-section">
          <h4 class="text-lg font-bold mb-4">🤖 AI活用について</h4>
          <p class="text-sm text-gray-400 mb-4">
            本サイトはAI技術を活用して論文の要約・講座作成を行っています。
            正確性向上のため、継続的な改善を行っています。
          </p>
          <a href="/about/policy/" class="text-accent hover:underline">
            詳細を読む →
          </a>
        </div>
        
        <!-- 専門家レビュー募集 -->
        <div class="review-section">
          <h4 class="text-lg font-bold mb-4">👨‍⚕️ 専門家レビュー募集</h4>
          <p class="text-sm text-gray-400 mb-4">
            獣医師・動物行動学者・研究者の方々からの
            レビューを歓迎いたします。
          </p>
          <a href="/contact/expert-review/" class="btn-outline-accent">
            レビューに協力する
          </a>
        </div>
        
        <!-- 創設者メッセージ -->
        <div class="founder-section">
          <h4 class="text-lg font-bold mb-4">💭 創設者の想い</h4>
          <p class="text-sm text-gray-400 mb-4">
            猫好きとして、信頼できる情報を
            みんなで作っていきたい...
          </p>
          <a href="/about/founder-message/" class="text-accent hover:underline">
            メッセージを読む →
          </a>
        </div>
        
      </div>
    </div>
    
    <!-- 下部：基本情報 -->
    <div class="footer-bottom text-center text-sm text-gray-400">
      <p>&copy; 2024 ネコフリークス大学. All rights reserved.</p>
    </div>
    
  </div>
</footer>
```

## Tailwind CSSクラス定義

```css
/* ボタンスタイル */
.btn-primary {
  @apply bg-accent text-white px-8 py-4 rounded-full font-bold hover:bg-accent-dark transition-colors;
}

.btn-white {
  @apply bg-white text-primary px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition-colors;
}

.btn-outline-primary {
  @apply border-2 border-primary text-primary px-6 py-3 rounded-full font-semibold hover:bg-primary hover:text-white transition-all;
}

/* セクションタイトル */
.section-title {
  @apply relative inline-block;
}

.section-title::after {
  content: '';
  @apply absolute bottom-0 left-1/2 transform -translate-x-1/2 w-20 h-1 bg-accent mt-2;
}

/* 講座カードホバー */
.lecture-book-card:hover {
  @apply transform -translate-y-2 transition-transform;
}

/* 肉球アニメーション */
@keyframes paw-stamp {
  0% { transform: scale(0) rotate(-10deg); }
  50% { transform: scale(1.2) rotate(5deg); }
  100% { transform: scale(1) rotate(0deg); }
}

.paw-animation {
  animation: paw-stamp 0.3s ease-out;
}
```

## レスポンシブ対応注意点

- モバイル: シングルカラム、タップしやすいボタンサイズ
- タブレット: 2カラムグリッド
- デスクトップ: 3カラムグリッド、ホバーエフェクト有効