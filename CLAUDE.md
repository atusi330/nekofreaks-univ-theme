# CLAUDE.md - ネコフリークス大学 WordPress 開発仕様

## プロジェクト概要

猫の論文要約と講座を提供する教育メディア「ネコフリークス大学」の WordPress オリジナルテーマを開発する。AI を活用した論文ベースの信頼性の高いコンテンツを、キャラクターによる親しみやすい形式で提供する。

## 技術スタック

- **CMS**: WordPress (最新版)
- **テーマ**: オリジナルテーマ
- **CSS**: Tailwind CSS
- **JavaScript**: jQuery (Ajax 用)
- **プラグイン**: ACF 無料版
- **開発環境**: Claude Code
- **バージョン管理**: Git

## ディレクトリ構造

```
neko-freaks-university/
├── style.css                      # テーマ情報
├── index.php                      # フォールバック
├── functions.php                  # 機能定義
├── front-page.php                # トップページ
├── header.php                    # ヘッダー
├── footer.php                    # フッター
├── page.php                      # 固定ページ
├── single.php                    # 投稿詳細
├── archive.php                   # アーカイブ
│
├── inc/                          # 機能別PHPファイル
│   ├── post-types.php           # カスタム投稿タイプ
│   ├── taxonomies.php           # カスタムタクソノミー
│   ├── ajax-handlers.php        # Ajax処理
│   └── template-tags.php        # テンプレートタグ
│
├── template-parts/               # 再利用可能パーツ
│   ├── content-lecture-card.php
│   ├── character-dialogue.php
│   └── navigation-episode.php
│
├── assets/                       # 静的ファイル
│   ├── css/
│   │   └── tailwind.css
│   ├── js/
│   │   ├── main.js
│   │   └── lecture-filter.js
│   └── images/
│       └── characters/
│
├── single-lectures.php           # 講座詳細
├── single-lecture_episodes.php   # 講座回詳細
├── archive-lectures.php          # 講座一覧
├── single-papers.php             # 論文詳細
├── single-tips.php               # 豆知識詳細
└── single-goods.php              # グッズ詳細
```

## サイト構成仕様

### サイト階層構造

ネコフリークス大学/
│
├── 🏠 トップページ
│ ├── ヒーローセクション（マロン学長のウェルカムメッセージ）
│ ├── 現在開講中の講座（進捗表示付き）
│ ├── 受講可能な講座一覧（3-6 件表示）
│ ├── 今週の更新情報（豆知識・グッズ）
│ ├── ネコフリークス大学について（簡易版）
│ └── フッター（AI 活用ポリシー・専門家レビュー募集）
│
├── 📚 講座一覧（/lectures/）
│ ├── 講師別フィルター（Ajax 実装）
│ ├── カテゴリ別フィルター
│ ├── 講座カード表示（グリッドレイアウト）
│ └── ローディングアニメーション（肉球）
│
├── 📖 テーマ別（/themes/）
│ └── 各テーマページ
│ ├── 論文要約
│ ├── 講座全 5 回へのリンク
│ ├── 関連豆知識リスト
│ └── 関連グッズリスト
│
├── 👥 大学について（/about/）
│ ├── ネコフリークス大学とは
│ ├── 講師紹介（簡易プロフィール）
│ │ └── 各講師詳細ページ（/about/professors/[name]/）
│ ├── 創設者メッセージ（/about/founder-message/）
│ ├── AI 活用ポリシー（/about/policy/）
│ └── 評価制度（肉球スタンプ）
│
├── 💡 豆知識バンク（/tips/）
├── 🛍️ グッズカタログ（/goods/）
├── 📄 論文アーカイブ（/papers/）
└── 📝 その他固定ページ

### パーマリンク構造

/lectures/[lecture-slug]/ # 講座トップ
/lectures/[lecture-slug]/episode-[number]/ # 各回
/papers/[paper-slug]/ # 論文要約
/tips/[tip-slug]/ # 豆知識
/goods/[goods-slug]/ # グッズ
/theme/[category-slug]/ # テーマ別
/professor/[professor-slug]/ # 講師別

## WordPress カスタム構成

### カスタム投稿タイプ

1. **lectures** - 講座（親投稿）
2. **lecture_episodes** - 講座回（各回）
3. **papers** - 論文要約
4. **tips** - 豆知識
5. **goods** - グッズ紹介

### カスタムタクソノミー

1. **theme_category** - テーマカテゴリ（行動学、健康・医学、飼育・ケア、猫の生態）
2. **professor** - 担当講師（maron, ichi, hachi, jiji, daifuku）
3. **difficulty** - 難易度（beginner, intermediate, advanced）
4. **content_tags** - 汎用タグ

### ACF 無料版フィールド構成

#### lectures（講座）

- related_paper (Post Object) - 関連論文
- lecture_status (Select) - 開講中/完結
- main_professor (Select) - メイン講師
- lecture_overview (Textarea) - 講座概要
- total_episodes (Number) - 全話数

#### lecture_episodes（講座回）

- episode_number (Number) - 話数（1-5）
- parent_lecture (Post Object) - 親講座
- guest_professor (Select) - ゲスト講師
- key_points (Textarea) - ポイント（改行区切り）
- dialogue_json (Textarea) - 会話データ（JSON 形式）

#### papers（論文要約）

- original_title (Text) - 原題
- authors (Textarea) - 著者
- published_year (Number) - 発表年
- journal (Text) - 掲載誌
- doi_link (URL) - 論文リンク
- summary_points (Textarea) - 要点（改行区切り）

## キャラクター設定

### マロン学長（全講座ナビゲーター）

- スコティッシュストレート（レッドタビー）
- ♂/0 歳、わんぱくで甘えん坊
- カラー: #8B4513

### いち教授（長老ポジション）

- 黒猫、♂/12 歳
- 高齢猫の行動、観察担当
- カラー: #FF8C00

### はち助教授（こだわり女子）

- 黒白ハチワレ、♀/8 歳
- トイレ、環境、美意識担当
- カラー:rgb(233, 152, 217)

### ジジ助手（やらかし担当）

- 黒猫、♂/4 歳
- 問題行動、若猫行動学担当
- カラー: #228B22

### 大福先代学長（特別講師）

- スコティッシュフォールド、♀/1 歳
- 命、絆、繊細なケア担当
- カラー: #9370DB

## デザイン仕様

### カラーパレット

```css
:root {
  --primary: #4a5d7a; /* 紺色 */
  --secondary: #f4a460; /* サンディブラウン */
  --accent: #ff6b6b; /* 肉球ピンク */
  --bg-main: #fafaf8; /* オフホワイト */
  --bg-paper: #ffffff; /* 純白 */
  --bg-board: #2d3e50; /* 黒板色 */

  /* 講師別カラー */
  --maron: #8b4513;
  --ichi: #ff8c00;
  --hachi: #4682b4;
  --jiji: #228b22;
  --daifuku: #9370db;
}
```

### デザインコンセプト

- アカデミック × 親しみやすさ
- 黒板風背景、吹き出し会話
- ノート風本文、肉球スタンプ進捗
- 講座カードは本の表紙風

## 主要機能実装

### 講座一覧ページ - Ajax 絞り込み

```javascript
// 講師別フィルター実装
// Ajax通信でカード表示を動的更新
// フェードイン/アウトアニメーション
// 肉球ローディングアニメーション
```

### 講座システム

- 全 5 回連続講座（金曜夜配信）
- マロン＋講師の会話形式
- 進捗管理（Cookie/Session）
- 次回予告機能

### コンテンツ配信スケジュール

- 金曜夜: 講座（週 1 回）
- 月・水: 豆知識
- 火・木: グッズ紹介

## URL 構造

```
/lectures/[slug]/                    # 講座トップ
/lectures/[slug]/episode-[number]/   # 各回
/papers/[slug]/                      # 論文要約
/tips/[slug]/                        # 豆知識
/goods/[slug]/                       # グッズ
/theme/[category]/                   # テーマ別
/professor/[name]/                   # 講師別
```

## 開発優先順位

### Phase 1（基本機能）

1. テーマ基本構造作成
2. カスタム投稿タイプ/タクソノミー実装
3. トップページデザイン
4. 講座一覧（Ajax 絞り込み）
5. 講座詳細ページ
6. キャラクター会話システム

### Phase 2（拡張機能）

- 会員機能
- 理解度テスト
- 修了証発行
- API 実装（アプリ化準備）

## SEO・パフォーマンス

- 構造化データ実装
- WebP 画像形式
- キャッシュプラグイン
- Google Analytics

## 注意事項

- 論文の要約は出典明記
- AI 活用の透明性を明記
- 専門家レビュー募集を設置
- レスポンシブ対応必須

## 開発コマンド例

```bash
# ローカル環境起動（Local by Flywheel使用想定）
# テーマディレクトリで作業

# Tailwind CSS（CDN版使用のため不要）
# jQuery（WordPress同梱版使用）

# Git操作
git add .
git commit -m "機能: 講座一覧のAjax絞り込み実装"
git push origin main
```

## 未確定事項

- ドメイン名
- キャラクターイラスト
- 初回講座テーマ
- ロゴデザイン
- サーバー環境
