<?php
/**
 * Template Name: お気に入り管理
 * 
 * お気に入り管理ページテンプレート
 * 
 * @package NekoFreaksUniv
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="page-header bg-gradient-to-r from-purple-600 to-pink-600 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">
                    <i class="fas fa-heart text-pink-300 mr-3"></i>
                    お気に入り管理
                </h1>
                <p class="text-lg text-white/90">あなたがお気に入りに追加した講座を管理できます</p>
            </div>
        </div>
    </div>
    
    <div class="container mx-auto px-4 py-8">
        <?php nfu_breadcrumb(); ?>
        
        <!-- お気に入り講座セクション -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- メインコンテンツ -->
            <div class="lg:col-span-3">
                <!-- 統計情報 -->
                <div class="stats-cards grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="stat-card bg-white rounded-lg shadow-md p-6 text-center">
                        <div class="text-3xl font-bold text-purple-600 mb-2" id="bookmarks-count">0</div>
                        <div class="text-gray-600">お気に入り講座</div>
                    </div>
                    <div class="stat-card bg-white rounded-lg shadow-md p-6 text-center">
                        <div class="text-3xl font-bold text-blue-600 mb-2" id="progress-count">0</div>
                        <div class="text-gray-600">学習中の講座</div>
                    </div>
                    <div class="stat-card bg-white rounded-lg shadow-md p-6 text-center">
                        <div class="text-3xl font-bold text-green-600 mb-2" id="completion-rate">0%</div>
                        <div class="text-gray-600">平均進捗率</div>
                    </div>
                </div>
                
                <!-- フィルター・ソートバー -->
                <div class="filter-bar bg-white rounded-lg shadow-md p-4 mb-6 flex flex-wrap items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <label class="text-sm font-medium text-gray-700">表示順:</label>
                        <select id="bookmark-sort" class="border border-gray-300 rounded-lg px-3 py-1 text-sm">
                            <option value="recent">追加日（新しい順）</option>
                            <option value="oldest">追加日（古い順）</option>
                            <option value="title">タイトル順</option>
                        </select>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <button id="clear-all-bookmarks" class="text-sm text-red-600 hover:text-red-800 px-3 py-1 border border-red-300 rounded-lg hover:bg-red-50 transition-colors">
                            <i class="fas fa-trash mr-1"></i>すべて削除
                        </button>
                        <button id="reset-all-data" class="text-sm text-orange-600 hover:text-orange-800 px-3 py-1 border border-orange-300 rounded-lg hover:bg-orange-50 transition-colors">
                            <i class="fas fa-undo mr-1"></i>データリセット
                        </button>
                    </div>
                </div>
                
                <!-- お気に入り一覧 -->
                <div class="bookmarks-section bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-bookmark text-purple-600 mr-2"></i>
                            お気に入りの講座
                        </h2>
                        <div class="text-sm text-gray-500" id="bookmarks-info">
                            読み込み中...
                        </div>
                    </div>
                    
                    <!-- 空の状態 -->
                    <div id="empty-bookmarks" class="empty-state text-center py-12 hidden">
                        <div class="text-6xl text-gray-300 mb-4">🐾</div>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">まだお気に入りがありません</h3>
                        <p class="text-gray-500 mb-6">気になる講座を見つけて、お気に入りに追加してみましょう！</p>
                        <a href="<?php echo home_url('/lectures/'); ?>" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-colors inline-flex items-center">
                            <i class="fas fa-search mr-2"></i>講座を探す
                        </a>
                    </div>
                    
                    <!-- ブックマーク一覧 -->
                    <div id="bookmarks-grid" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- JavaScriptで動的に生成 -->
                    </div>
                </div>
                
                <!-- 完了講座セクション -->
                <div class="completed-lectures-section bg-white rounded-lg shadow-md p-6 mt-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-800">
                            <i class="fas fa-trophy text-yellow-600 mr-2"></i>
                            完了した講座
                        </h2>
                        <div class="text-sm text-gray-500" id="completed-lectures-info">
                            読み込み中...
                        </div>
                    </div>
                    
                    <!-- 完了講座一覧 -->
                    <div id="completed-lectures-list" class="space-y-3">
                        <!-- JavaScriptで動的に生成 -->
                    </div>
                    
                    <!-- 空の状態 -->
                    <div id="empty-completed" class="text-center py-8 text-gray-500 hidden">
                        <div class="text-4xl text-gray-300 mb-3">🎓</div>
                        <p>まだ完了した講座がありません</p>
                        <p class="text-sm mt-2">講座の全エピソードを完了すると、ここに表示されます</p>
                    </div>
                    
                    <!-- もっと見るボタン -->
                    <div id="load-more-completed" class="text-center mt-6 hidden">
                        <button class="load-more-btn bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg transition-colors">
                            <i class="fas fa-chevron-down mr-2"></i>
                            さらに読み込む
                        </button>
                        <div class="text-xs text-gray-500 mt-2" id="completed-pagination-info">
                            <!-- 読み込み状況 -->
                        </div>
                    </div>
                </div>
                
                <!-- 学習進捗セクション -->
                <div class="progress-section bg-white rounded-lg shadow-md p-6 mt-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">
                        <i class="fas fa-chart-line text-blue-600 mr-2"></i>
                        学習進捗
                    </h2>
                    
                    <div id="progress-grid" class="space-y-4">
                        <!-- JavaScriptで動的に生成 -->
                    </div>
                    
                    <div id="empty-progress" class="text-center py-8 text-gray-500 hidden">
                        まだ学習を開始した講座がありません
                    </div>
                </div>
            </div>
            
            <!-- サイドバー -->
            <div class="space-y-6">
                <!-- アクションカード -->
                <div class="action-card bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-gray-800 mb-4">クイックアクション</h3>
                    
                    <div class="space-y-3">
                        <a href="<?php echo home_url('/lectures/'); ?>" class="flex items-center p-3 rounded-lg bg-purple-50 text-purple-700 hover:bg-purple-100 transition-colors">
                            <i class="fas fa-plus-circle mr-3"></i>
                            <span>新しい講座を探す</span>
                        </a>
                        
                        <button id="continue-learning" class="flex items-center p-3 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 transition-colors w-full text-left">
                            <i class="fas fa-play-circle mr-3"></i>
                            <span>続きから学習</span>
                        </button>
                        
                        <a href="<?php echo home_url('/papers/'); ?>" class="flex items-center p-3 rounded-lg bg-green-50 text-green-700 hover:bg-green-100 transition-colors">
                            <i class="fas fa-file-alt mr-3"></i>
                            <span>論文を読む</span>
                        </a>
                    </div>
                </div>
                
                <!-- 学習統計 -->
                <div class="stats-card bg-white rounded-lg shadow-md p-6">
                    <h3 class="font-bold text-gray-800 mb-4">学習レポート</h3>
                    
                    <div class="space-y-4">
                        <div class="stat-item">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-sm text-gray-600">今週の学習時間</span>
                                <span class="font-semibold" id="weekly-time">0分</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-purple-600 h-2 rounded-full" id="weekly-progress" style="width: 0%"></div>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm text-gray-600">完了した講座</span>
                                <span class="font-semibold" id="completed-lectures">0</span>
                            </div>
                        </div>
                        
                        <div class="stat-item">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-sm text-gray-600">お気に入り講師</span>
                                <span class="font-semibold" id="favorite-professor">-</span>
                            </div>
                            <button id="change-favorite-professor" class="text-xs text-blue-600 hover:text-blue-800 mt-1">
                                <i class="fas fa-edit mr-1"></i>変更
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- ヘルプ -->
                <div class="help-card bg-gradient-to-r from-yellow-50 to-orange-50 rounded-lg p-6 border border-yellow-200">
                    <h3 class="font-bold text-gray-800 mb-3">
                        <i class="fas fa-question-circle text-yellow-600 mr-2"></i>
                        ヘルプ
                    </h3>
                    <div class="text-sm text-gray-700 space-y-2">
                        <p>• お気に入りはブラウザに保存されます</p>
                        <p>• 学習進捗も自動で記録されます</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- お気に入り管理用のJavaScript -->
<script>
jQuery(document).ready(function($) {
    // お気に入り管理ページの初期化
    initBookmarksPage();
    
    function initBookmarksPage() {
        console.log('Initializing bookmarks page...');
        
        // 読み込み中表示を初期化
        $('#bookmarks-info').text('読み込み中...');
        $('#completed-lectures-info').text('読み込み中...');
        
        // イベントハンドラーを先に設定
        setupEventHandlers();
        
        // データを読み込み
        loadBookmarksData();
        
        // エピソード完了システムとの連携チェック
        if (typeof window.nfuGetCompletionStats === 'function') {
            console.log('Episode completion system detected - syncing data');
        }
        
        // 最終的な読み込み中表示のクリア
        setTimeout(function() {
            clearLoadingStates();
        }, 500);
        
        console.log('Bookmarks page initialized');
    }
    
    // 完了講座管理
    var completedLecturesData = {
        lectures: [],
        currentOffset: 0,
        perPage: 5,
        hasMore: false
    };
    
    function clearLoadingStates() {
        var bookmarks = getBookmarks();
        var completedCount = 0;
        
        // completedLecturesDataが存在することを確認
        if (typeof completedLecturesData !== 'undefined' && completedLecturesData.lectures) {
            completedCount = completedLecturesData.lectures.length;
        }
        
        $('#bookmarks-info').text(bookmarks.length + '件のお気に入り');
        $('#completed-lectures-info').text(completedCount + '件');
        
        console.log('Loading states cleared - Bookmarks:', bookmarks.length, 'Completed:', completedCount);
    }
    
    function loadBookmarksData() {
        var bookmarks = getBookmarks();
        var progress = getProgress();
        var episodeCompletions = getEpisodeCompletions();
        
        // デバッグ用ログ - より詳細に
        if (typeof console !== 'undefined' && console.log) {
            console.log('=== BOOKMARKS PAGE DATA DEBUG ===');
            console.log('Bookmarks:', bookmarks);
            console.log('Progress:', progress);
            console.log('Episode Completions:', episodeCompletions);
            console.log('Bookmarks count:', bookmarks.length);
            console.log('Progress keys:', Object.keys(progress));
            console.log('Episode completion keys:', Object.keys(episodeCompletions));
            console.log('================================');
        }
        
        if (bookmarks.length === 0) {
            $('#empty-bookmarks').removeClass('hidden');
            $('#bookmarks-grid').addClass('hidden');
        } else {
            $('#empty-bookmarks').addClass('hidden');
            $('#bookmarks-grid').removeClass('hidden');
            renderBookmarks(bookmarks);
        }
        
        // 完了講座を読み込み
        loadCompletedLectures(episodeCompletions);
        
        // 学習進捗の表示処理を改善
        var hasTraditionalProgress = progress && Object.keys(progress).length > 0;
        var hasEpisodeCompletions = episodeCompletions && Object.keys(episodeCompletions).length > 0;
        var hasAnyProgressData = hasTraditionalProgress || hasEpisodeCompletions;
        
        // デバッグ用ログを追加
        if (typeof console !== 'undefined' && console.log) {
            console.log('=== PROGRESS DISPLAY CHECK ===');
            console.log('Traditional Progress:', hasTraditionalProgress);
            console.log('Episode Completions:', hasEpisodeCompletions);
            console.log('Has Any Data:', hasAnyProgressData);
            console.log('Progress Keys:', progress ? Object.keys(progress) : []);
            console.log('Completion Keys:', episodeCompletions ? Object.keys(episodeCompletions) : []);
            console.log('Episode Completions Data:', episodeCompletions);
            console.log('=============================');
        }
        
        // 進捗セクションを必ず表示
        $('#empty-progress').addClass('hidden');
        $('#progress-grid').removeClass('hidden');
        
        // エピソード完了データがある場合は必ず表示
        if (hasAnyProgressData) {
            console.log('=== CALLING RENDER PROGRESS ===');
            console.log('Progress data:', progress);
            console.log('Episode completions:', episodeCompletions);
            console.log('Has traditional progress:', hasTraditionalProgress);
            console.log('Has episode completions:', hasEpisodeCompletions);
            renderProgress(progress, episodeCompletions);
        } else {
            console.log('No progress data found, showing empty state');
            // データがない場合でも空の状態として表示
            $('#progress-grid').html('<div class="text-center py-8 text-gray-500">まだ学習を開始した講座がありません</div>');
        }
        
        // 統計情報を更新
        updateStats();
        
        // 読み込み完了の明示的な処理
        setTimeout(function() {
            // 統計情報を即座に更新
            $('#bookmarks-count').text(bookmarks.length);
            
            // 学習中の講座数を計算
            var studyingLectures = new Set();
            Object.keys(progress).forEach(function(lectureId) {
                studyingLectures.add(lectureId);
            });
            Object.keys(episodeCompletions).forEach(function(episodeId) {
                var completion = episodeCompletions[episodeId];
                if (completion.lectureId) {
                    studyingLectures.add(completion.lectureId);
                }
            });
            $('#progress-count').text(studyingLectures.size);
            
            // 読み込み中テキストを削除
            $('#bookmarks-info').text(bookmarks.length + '件のお気に入り');
            
            // ローディング状態のクラスを削除
            $('.loading-state').removeClass('loading-state');
            
            // デバッグ用ログ
            console.log('Loading completed, bookmarks:', bookmarks.length, 'studying:', studyingLectures.size);
        }, 100); // タイミングを短縮
        
        // 完了講座の読み込み中表示を強制的に更新
        setTimeout(function() {
            var completedCount = completedLecturesData.lectures ? completedLecturesData.lectures.length : 0;
            $('#completed-lectures-info').text(completedCount + '件');
            console.log('Completed lectures info updated:', completedCount);
        }, 200);
        
        // 最終的な強制更新
        setTimeout(function() {
            var bookmarks = getBookmarks();
            var completedCount = 0;
            
            // completedLecturesDataが存在することを確認
            if (typeof completedLecturesData !== 'undefined' && completedLecturesData.lectures) {
                completedCount = completedLecturesData.lectures.length;
            }
            
            $('#bookmarks-info').text(bookmarks.length + '件のお気に入り');
            $('#completed-lectures-info').text(completedCount + '件');
            
            console.log('Final update - Bookmarks:', bookmarks.length, 'Completed:', completedCount);
        }, 300);
    }
    
    function renderBookmarks(bookmarks) {
        var grid = $('#bookmarks-grid');
        grid.empty();
        
        bookmarks.forEach(function(bookmark) {
            var card = $('<div class="bookmark-card bg-gray-50 rounded-lg p-4 hover:shadow-md transition-shadow">' +
                '<div class="flex items-start justify-between mb-3">' +
                    '<div class="flex-1">' +
                        '<h3 class="font-semibold text-gray-800 mb-2">' +
                            '<a href="' + bookmark.url + '" class="text-purple-600 hover:underline">' + bookmark.title + '</a>' +
                        '</h3>' +
                        '<div class="text-xs text-gray-500">' +
                            '追加日: ' + new Date(bookmark.timestamp).toLocaleDateString('ja-JP') +
                        '</div>' +
                    '</div>' +
                    '<button class="remove-bookmark text-red-500 hover:text-red-700 ml-2" data-bookmark-id="' + bookmark.id + '">' +
                        '<i class="fas fa-times"></i>' +
                    '</button>' +
                '</div>' +
                '<div class="flex items-center gap-2">' +
                    '<a href="' + bookmark.url + '" class="flex-1 text-center bg-purple-600 text-white py-2 px-3 rounded text-sm hover:bg-purple-700 transition-colors">' +
                        '講座を見る' +
                    '</a>' +
                    '<button class="share-bookmark bg-gray-200 text-gray-600 py-2 px-3 rounded text-sm hover:bg-gray-300 transition-colors" data-url="' + bookmark.url + '" data-title="' + bookmark.title + '">' +
                        '<i class="fas fa-share"></i>' +
                    '</button>' +
                '</div>' +
            '</div>');
            
            grid.append(card);
        });
    }
    
    // 講座データを取得する関数
    function getLectureData(lectureIds) {
        return new Promise(function(resolve, reject) {
            $.ajax({
                url: '/wp-admin/admin-ajax.php',
                type: 'POST',
                data: {
                    action: 'get_lecture_data',
                    lecture_ids: lectureIds,
                    nonce: nfu_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        resolve(response.data);
                    } else {
                        reject(response.data);
                    }
                },
                error: function(xhr, status, error) {
                    reject(error);
                }
            });
        });
    }

    function renderProgress(progress, episodeCompletions) {
        console.log('=== RENDER PROGRESS START ===');
        var container = $('#progress-grid');
        console.log('Container found:', container.length > 0);
        container.empty();
        
        // データが存在することを確認
        progress = progress || {};
        episodeCompletions = episodeCompletions || {};
        
        // デバッグ用ログを追加
        if (typeof console !== 'undefined' && console.log) {
            console.log('renderProgress called with:', {
                progressData: progress,
                episodeCompletionsData: episodeCompletions,
                progressCount: Object.keys(progress).length,
                episodeCount: Object.keys(episodeCompletions).length
            });
        }
        
        // 講座ごとの完了状況をまとめる
        var lectureProgress = {};
        
        // 従来の進捗データを処理
        Object.keys(progress).forEach(function(lectureId) {
            if (!lectureProgress[lectureId]) {
                lectureProgress[lectureId] = {
                    lectureId: lectureId,
                    currentEpisode: progress[lectureId].currentEpisode || 1,
                    completedEpisodes: [],
                    lastActivity: progress[lectureId].timestamp || Date.now(),
                    episodeId: progress[lectureId].episodeId || null
                };
            }
        });
        
        // エピソード完了データを処理
        console.log('Processing episode completions:', Object.keys(episodeCompletions).length, 'items');
        Object.keys(episodeCompletions).forEach(function(episodeId) {
            var completion = episodeCompletions[episodeId];
            var lectureId = completion.lectureId;
            
            console.log('Processing completion:', episodeId, 'for lecture:', lectureId, 'episode:', completion.episodeNumber);
            
            if (!lectureProgress[lectureId]) {
                lectureProgress[lectureId] = {
                    lectureId: lectureId,
                    currentEpisode: completion.episodeNumber,
                    completedEpisodes: [],
                    lastActivity: completion.timestamp,
                    episodeId: episodeId
                };
                console.log('Created new lecture progress for:', lectureId);
            }
            
            // 重複を避けて追加
            if (lectureProgress[lectureId].completedEpisodes.indexOf(completion.episodeNumber) === -1) {
                lectureProgress[lectureId].completedEpisodes.push(completion.episodeNumber);
                console.log('Added episode', completion.episodeNumber, 'to lecture', lectureId);
            }
            
            // 最新のアクティビティを更新
            if (completion.timestamp > lectureProgress[lectureId].lastActivity) {
                lectureProgress[lectureId].lastActivity = completion.timestamp;
                lectureProgress[lectureId].currentEpisode = Math.max(
                    lectureProgress[lectureId].currentEpisode,
                    completion.episodeNumber
                );
            }
        });
        
        // デバッグ用ログ - データが正しく処理されているか確認
        if (typeof console !== 'undefined' && console.log) {
            console.log('Lecture Progress Data:', {
                lectureProgress: lectureProgress,
                totalLectures: Object.keys(lectureProgress).length,
                hasData: Object.keys(lectureProgress).length > 0
            });
        }
        
        // データが空の場合の処理
        if (Object.keys(lectureProgress).length === 0) {
            container.html('<div class="text-center py-8 text-gray-500">まだ学習を開始した講座がありません</div>');
            return;
        }
        
        // 講座データを取得してからレンダリング
        var lectureIds = Object.keys(lectureProgress);
        getLectureData(lectureIds).then(function(lectureData) {
            // 各講座の進捗アイテムをレンダリング
            Object.keys(lectureProgress).forEach(function(lectureId) {
                var progData = lectureProgress[lectureId];
                var completedCount = progData.completedEpisodes.length;
                var totalEpisodes = 5; // デフォルト値
                var completionPercentage = Math.round((completedCount / totalEpisodes) * 100);
                
                // 講座タイトルを取得
                var lectureTitle = '講座 #' + lectureId; // デフォルト
                var lectureUrl = '/lectures/' + lectureId + '/';
                
                if (lectureData && lectureData[lectureId]) {
                    lectureTitle = lectureData[lectureId].title || lectureTitle;
                    lectureUrl = lectureData[lectureId].url || lectureUrl;
                    totalEpisodes = lectureData[lectureId].total_episodes || totalEpisodes;
                }
                
                var progressItem = $('<div class="progress-item bg-gray-50 rounded-lg p-4 border border-gray-200">' +
                    '<div class="flex items-center justify-between mb-3">' +
                        '<div>' +
                            '<a href="' + lectureUrl + '" class="font-medium text-gray-800 hover:text-blue-600 transition-colors">' + lectureTitle + '</a>' +
                            '<div class="text-xs text-gray-500 mt-1">現在のエピソード: ' + progData.currentEpisode + '</div>' +
                        '</div>' +
                        '<div class="text-right">' +
                            '<span class="text-sm font-bold text-purple-600">' + completionPercentage + '%</span>' +
                            '<div class="text-xs text-gray-500">' + completedCount + '/' + totalEpisodes + ' 完了</div>' +
                        '</div>' +
                    '</div>' +
                
                '<div class="mb-3">' +
                    '<div class="flex items-center justify-between mb-1">' +
                        '<span class="text-xs text-gray-500">学習進捗</span>' +
                        '<span class="text-xs text-gray-500">' + completedCount + ' エピソード完了</span>' +
                    '</div>' +
                    '<div class="progress-bar bg-gray-200 rounded-full h-2">' +
                        '<div class="progress-fill bg-gradient-to-r from-purple-500 to-blue-500 h-2 rounded-full transition-all" style="width: ' + completionPercentage + '%"></div>' +
                    '</div>' +
                '</div>' +
                
                '<div class="flex items-center justify-between mb-3">' +
                    '<div class="text-xs text-gray-500">' +
                        '最終学習: ' + new Date(progData.lastActivity).toLocaleDateString('ja-JP') +
                    '</div>' +
                    '<div class="completion-status">' +
                        (completionPercentage >= 100 ? 
                            '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-green-100 text-green-800">' +
                                '<i class="fas fa-certificate mr-1"></i>完了' +
                            '</span>' :
                            '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800">' +
                                '<i class="fas fa-play mr-1"></i>学習中' +
                            '</span>'
                        ) +
                    '</div>' +
                '</div>' +
                
                '<div class="flex space-x-2">' +
                    '<button class="flex-1 bg-blue-600 text-white py-2 px-3 rounded text-sm hover:bg-blue-700 transition-colors" onclick="window.location.href=\'/lectures/' + lectureId + '/\'">' +
                        '<i class="fas fa-book-open mr-1"></i>講座を見る' +
                    '</button>' +
                    (completionPercentage < 100 ?
                        '<button class="continue-from-here bg-purple-600 text-white py-2 px-3 rounded text-sm hover:bg-purple-700 transition-colors" data-lecture-id="' + lectureId + '" data-episode="' + progData.currentEpisode + '">' +
                            '<i class="fas fa-play mr-1"></i>続きから' +
                        '</button>' :
                        '<button class="bg-green-600 text-white py-2 px-3 rounded text-sm cursor-default" disabled>' +
                            '<i class="fas fa-check mr-1"></i>完了' +
                        '</button>'
                    ) +
                '</div>' +
            '</div>');
            
            container.append(progressItem);
        });
        console.log('=== RENDER PROGRESS COMPLETED ===');
        }).catch(function(error) {
            console.error('Failed to load lecture data for progress:', error);
            // エラー時はデフォルトデータで処理
            Object.keys(lectureProgress).forEach(function(lectureId) {
                var progData = lectureProgress[lectureId];
                var completedCount = progData.completedEpisodes.length;
                var totalEpisodes = 5;
                var completionPercentage = Math.round((completedCount / totalEpisodes) * 100);
                
                var progressItem = $('<div class="progress-item bg-gray-50 rounded-lg p-4 border border-gray-200">' +
                    '<div class="flex items-center justify-between mb-3">' +
                        '<div>' +
                            '<span class="font-medium text-gray-800">講座 #' + lectureId + '</span>' +
                            '<div class="text-xs text-gray-500 mt-1">現在のエピソード: ' + progData.currentEpisode + '</div>' +
                        '</div>' +
                        '<div class="text-right">' +
                            '<span class="text-sm font-bold text-purple-600">' + completionPercentage + '%</span>' +
                            '<div class="text-xs text-gray-500">' + completedCount + '/' + totalEpisodes + ' 完了</div>' +
                        '</div>' +
                    '</div>' +
                    
                    '<div class="mb-3">' +
                        '<div class="w-full bg-gray-200 rounded-full h-2">' +
                            '<div class="bg-purple-600 h-2 rounded-full transition-all duration-300" style="width: ' + completionPercentage + '%"></div>' +
                        '</div>' +
                    '</div>' +
                    
                    '<div class="flex space-x-2">' +
                        '<button class="flex-1 bg-blue-600 text-white py-2 px-3 rounded text-sm hover:bg-blue-700 transition-colors" onclick="window.location.href=\'/lectures/' + lectureId + '/\'">' +
                            '<i class="fas fa-book-open mr-1"></i>講座を見る' +
                        '</button>' +
                        (completionPercentage < 100 ?
                            '<button class="continue-from-here bg-purple-600 text-white py-2 px-3 rounded text-sm hover:bg-purple-700 transition-colors" data-lecture-id="' + lectureId + '" data-episode="' + progData.currentEpisode + '">' +
                                '<i class="fas fa-play mr-1"></i>続きから' +
                            '</button>' :
                            '<button class="bg-green-600 text-white py-2 px-3 rounded text-sm cursor-default" disabled>' +
                                '<i class="fas fa-check mr-1"></i>完了' +
                            '</button>'
                        ) +
                    '</div>' +
                '</div>');
                
                container.append(progressItem);
            });
        });
    }
    
    function loadCompletedLectures(episodeCompletions) {
        episodeCompletions = episodeCompletions || {};
        
        console.log('Loading completed lectures, episode completions:', Object.keys(episodeCompletions).length);
        
        // completedLecturesDataが存在することを確認
        if (typeof completedLecturesData === 'undefined') {
            console.error('completedLecturesData is undefined, creating it...');
            window.completedLecturesData = {
                lectures: [],
                currentOffset: 0,
                perPage: 5,
                hasMore: false
            };
        }
        
        // 講座ごとの完了状況を集計
        var lectureCompletions = {};
        
        Object.keys(episodeCompletions).forEach(function(episodeId) {
            var completion = episodeCompletions[episodeId];
            var lectureId = completion.lectureId;
            
            if (!lectureCompletions[lectureId]) {
                lectureCompletions[lectureId] = {
                    lectureId: lectureId,
                    completedEpisodes: [],
                    latestCompletion: completion.timestamp,
                    title: '講座 #' + lectureId // デフォルトタイトル
                };
            }
            
            // 重複を避けて追加
            if (lectureCompletions[lectureId].completedEpisodes.indexOf(completion.episodeNumber) === -1) {
                lectureCompletions[lectureId].completedEpisodes.push(completion.episodeNumber);
            }
            
            // 最新の完了日時を更新
            if (completion.timestamp > lectureCompletions[lectureId].latestCompletion) {
                lectureCompletions[lectureId].latestCompletion = completion.timestamp;
            }
        });
        
        console.log('Lecture completions:', Object.keys(lectureCompletions).length);
        
        // 講座データを取得してから完了講座を処理
        var lectureIds = Object.keys(lectureCompletions);
        getLectureData(lectureIds).then(function(lectureData) {
            // 100%完了した講座のみを抽出
            var completedLectures = [];
            Object.keys(lectureCompletions).forEach(function(lectureId) {
                var lectureDataItem = lectureCompletions[lectureId];
                var totalEpisodes = 5; // デフォルト値
                var lectureTitle = lectureDataItem.title; // デフォルト
                var lectureUrl = '/lectures/' + lectureId + '/';
                
                // 講座データから実際のタイトルとエピソード数を取得
                if (lectureData && lectureData[lectureId]) {
                    lectureTitle = lectureData[lectureId].title || lectureTitle;
                    lectureUrl = lectureData[lectureId].url || lectureUrl;
                    totalEpisodes = lectureData[lectureId].total_episodes || totalEpisodes;
                }
                
                // 完了エピソード数を正確に計算
                var uniqueCompletedEpisodes = [...new Set(lectureDataItem.completedEpisodes)];
                
                if (uniqueCompletedEpisodes.length >= totalEpisodes) {
                    completedLectures.push({
                        id: lectureId,
                        title: lectureTitle,
                        completedAt: lectureDataItem.latestCompletion,
                        totalEpisodes: totalEpisodes,
                        completedEpisodes: uniqueCompletedEpisodes.length,
                        url: lectureUrl
                    });
                }
            });
            
            // 完了日時の降順でソート
            completedLectures.sort(function(a, b) {
                return b.completedAt - a.completedAt;
            });
            
            // 安全にデータを設定
            if (typeof completedLecturesData !== 'undefined') {
                completedLecturesData.lectures = completedLectures;
                completedLecturesData.currentOffset = 0;
            } else {
                console.error('completedLecturesData is still undefined after creation');
                return;
            }
            
            renderCompletedLectures(true); // 初期表示
            
            // 完了講座の読み込み中表示を更新
            setTimeout(function() {
                var completedCount = completedLecturesData.lectures ? completedLecturesData.lectures.length : 0;
                $('#completed-lectures-info').text(completedCount + '件');
                console.log('Completed lectures loaded:', completedCount);
            }, 50);
            
            // 念のため、もう一度更新
            setTimeout(function() {
                var completedCount = completedLecturesData.lectures ? completedLecturesData.lectures.length : 0;
                $('#completed-lectures-info').text(completedCount + '件');
            }, 150);
        }).catch(function(error) {
            console.error('Failed to load lecture data:', error);
            // エラー時はデフォルトデータで処理
            var completedLectures = [];
            Object.keys(lectureCompletions).forEach(function(lectureId) {
                var lectureDataItem = lectureCompletions[lectureId];
                var totalEpisodes = 5;
                var uniqueCompletedEpisodes = [...new Set(lectureDataItem.completedEpisodes)];
                
                if (uniqueCompletedEpisodes.length >= totalEpisodes) {
                    completedLectures.push({
                        id: lectureId,
                        title: lectureDataItem.title,
                        completedAt: lectureDataItem.latestCompletion,
                        totalEpisodes: totalEpisodes,
                        completedEpisodes: uniqueCompletedEpisodes.length,
                        url: '/lectures/' + lectureId + '/'
                    });
                }
            });
            
            completedLectures.sort(function(a, b) {
                return b.completedAt - a.completedAt;
            });
            
            if (typeof completedLecturesData !== 'undefined') {
                completedLecturesData.lectures = completedLectures;
                completedLecturesData.currentOffset = 0;
            }
            
            renderCompletedLectures(true);
            
            setTimeout(function() {
                var completedCount = completedLecturesData.lectures ? completedLecturesData.lectures.length : 0;
                $('#completed-lectures-info').text(completedCount + '件');
            }, 50);
        });
    }
    
    function renderCompletedLectures(isInitial) {
        var container = $('#completed-lectures-list');
        
        // completedLecturesDataが存在することを確認
        if (typeof completedLecturesData === 'undefined') {
            console.error('completedLecturesData is undefined in renderCompletedLectures');
            $('#completed-lectures-info').text('0件');
            return;
        }
        
        var lectures = completedLecturesData.lectures;
        var offset = completedLecturesData.currentOffset;
        var perPage = completedLecturesData.perPage;
        
        if (isInitial) {
            container.empty();
            completedLecturesData.currentOffset = 0;
            offset = 0;
        }
        
        // 表示する講座を取得
        var lecturesSlice = lectures.slice(offset, offset + perPage);
        var remainingCount = lectures.length - (offset + perPage);
        
        if (lectures.length === 0) {
            $('#empty-completed').removeClass('hidden');
            $('#completed-lectures-list').addClass('hidden');
            $('#load-more-completed').addClass('hidden');
            $('#completed-lectures-info').text('0件');
            return;
        }
        
        $('#empty-completed').addClass('hidden');
        $('#completed-lectures-list').removeClass('hidden');
        
        // 講座アイテムを生成
        lecturesSlice.forEach(function(lecture) {
            var completedDate = new Date(lecture.completedAt).toLocaleDateString('ja-JP');
            
            var lectureItem = $('<div class="completed-lecture-item flex items-center justify-between py-3 px-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">' +
                '<div class="flex-1">' +
                    '<div class="flex items-center mb-1">' +
                        '<i class="fas fa-trophy text-yellow-500 mr-2"></i>' +
                        '<h3 class="font-medium text-gray-800">' + lecture.title + '</h3>' +
                    '</div>' +
                    '<div class="text-sm text-gray-500">' +
                        '<i class="fas fa-calendar mr-1"></i>' +
                        '完了日: ' + completedDate +
                    '</div>' +
                '</div>' +
                '<div class="ml-4">' +
                    '<a href="' + lecture.url + '" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">' +
                        '<i class="fas fa-external-link-alt mr-2"></i>' +
                        '講座を見る' +
                    '</a>' +
                '</div>' +
            '</div>');
            
            container.append(lectureItem);
        });
        
        // 情報テキストを更新
        $('#completed-lectures-info').text(lectures.length + '件');
        console.log('renderCompletedLectures: Updated info text to', lectures.length + '件');
        
        // もっと見るボタンの表示制御
        if (remainingCount > 0) {
            $('#load-more-completed').removeClass('hidden');
            $('#completed-pagination-info').text('残り ' + remainingCount + '件');
            completedLecturesData.hasMore = true;
        } else {
            $('#load-more-completed').addClass('hidden');
            completedLecturesData.hasMore = false;
        }
        
        // オフセットを更新
        completedLecturesData.currentOffset += perPage;
    }
    
    function updateStats() {
        var bookmarks = getBookmarks();
        var progress = getProgress();
        var completions = getEpisodeCompletions();
        
        // 統計情報の更新
        $('#bookmarks-count').text(bookmarks.length);
        
        // 学習中の講座数を正確に計算（従来の進捗 + エピソード完了データ）
        var studyingLectures = new Set();
        
        // 従来の進捗データから学習中講座を取得
        Object.keys(progress).forEach(function(lectureId) {
            studyingLectures.add(lectureId);
        });
        
        // エピソード完了データからも学習中講座を取得
        Object.keys(completions).forEach(function(episodeId) {
            var completion = completions[episodeId];
            if (completion.lectureId) {
                studyingLectures.add(completion.lectureId);
            }
        });
        
        $('#progress-count').text(studyingLectures.size);
        
        // 完了率の計算を改善
        var lectureCompletions = {};
        var totalEpisodes = 5; // デフォルト値
        
        // 各講座の完了エピソード数を計算
        Object.values(completions).forEach(function(completion) {
            var lectureId = completion.lectureId;
            if (!lectureCompletions[lectureId]) {
                lectureCompletions[lectureId] = new Set();
            }
            lectureCompletions[lectureId].add(completion.episodeNumber);
        });
        
        // 完了率を計算
        var completionRates = [];
        Object.keys(lectureCompletions).forEach(function(lectureId) {
            var completedEpisodes = lectureCompletions[lectureId].size;
            completionRates.push((completedEpisodes / totalEpisodes) * 100);
        });
        
        var avgCompletion = completionRates.length > 0 ? 
            Math.round(completionRates.reduce((a, b) => a + b) / completionRates.length) : 0;
        $('#completion-rate').text(avgCompletion + '%');
        

        
        // 完了した講座数を計算
        var fullyCompletedLectures = 0;
        Object.keys(lectureCompletions).forEach(function(lectureId) {
            if (lectureCompletions[lectureId].size >= 5) {
                fullyCompletedLectures++;
            }
        });
        
        $('#completed-lectures').text(fullyCompletedLectures);
        
        // 完了講座の情報表示も更新
        $('#completed-lectures-info').text(fullyCompletedLectures + '件');
        console.log('updateStats: Updated completed lectures info to', fullyCompletedLectures + '件');
        
        // 今週の学習エピソード数を計算（概算）
        var weeklyEpisodes = 0;
        var oneWeekAgo = Date.now() - (7 * 24 * 60 * 60 * 1000);
        
        Object.values(completions).forEach(function(completion) {
            if (completion.timestamp > oneWeekAgo) {
                weeklyEpisodes++;
            }
        });
        
        var estimatedMinutes = weeklyEpisodes * 15; // 1エピソード15分と仮定
        $('#weekly-time').text(estimatedMinutes + '分');
        $('#weekly-progress').css('width', Math.min(100, (weeklyEpisodes / 5) * 100) + '%');
        
        // お気に入り講師の統計
        var favoriteProfessor = getFavoriteProfessor();
        $('#favorite-professor').text(favoriteProfessor);
    }
    
    function setupEventHandlers() {
        // お気に入り削除（イベント委譲を改善）
        $(document).on('click', '.remove-bookmark', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            var bookmarkId = $(this).data('bookmark-id');
            console.log('Remove bookmark clicked:', bookmarkId);
            
            if (bookmarkId) {
                removeBookmark(bookmarkId);
            } else {
                console.error('Bookmark ID not found');
            }
        });
        
        // 削除ボタンのホバー効果を追加
        $(document).on('mouseenter', '.remove-bookmark', function() {
            $(this).addClass('text-red-700');
        }).on('mouseleave', '.remove-bookmark', function() {
            $(this).removeClass('text-red-700');
        });
        
        // すべて削除
        $('#clear-all-bookmarks').on('click', function() {
            if (confirm('すべてのお気に入りを削除しますか？')) {
                localStorage.removeItem('nfu_bookmarks');
                loadBookmarksData();
                updateStats();
                showNotification('すべてのお気に入りを削除しました', 'info');
            }
        });
        
        // データリセット
        $('#reset-all-data').on('click', function() {
            if (confirm('すべてのデータをリセットしますか？これにより、お気に入り、学習進捗、完了講座の履歴が削除されます。')) {
                localStorage.removeItem('nfu_bookmarks');
                localStorage.removeItem('nfu_progress');
                localStorage.removeItem('nfu_episode_completion');
                localStorage.removeItem('nfu_favorite_professor');
                loadBookmarksData();
                updateStats();
                showNotification('すべてのデータをリセットしました', 'info');
            }
        });
        

        
        // ソート
        $('#bookmark-sort').on('change', function() {
            var sortType = $(this).val();
            sortBookmarks(sortType);
        });
        
        // 続きから学習（ヘッダーボタン）
        $('#continue-learning').on('click', function() {
            var progress = getProgress();
            var episodeCompletions = getEpisodeCompletions();
            var lectureIds = Object.keys(progress);
            
            if (lectureIds.length === 0 && Object.keys(episodeCompletions).length === 0) {
                showNotification('学習中の講座がありません', 'info');
                return;
            }
            
            // 最後に更新された講座を取得
            var latestLecture = null;
            var latestTimestamp = 0;
            
            // 従来の進捗データをチェック
            lectureIds.forEach(function(lectureId) {
                if (progress[lectureId].timestamp > latestTimestamp) {
                    latestTimestamp = progress[lectureId].timestamp;
                    latestLecture = lectureId;
                }
            });
            
            // エピソード完了データもチェック
            Object.keys(episodeCompletions).forEach(function(episodeId) {
                var completion = episodeCompletions[episodeId];
                if (completion.timestamp > latestTimestamp) {
                    latestTimestamp = completion.timestamp;
                    latestLecture = completion.lectureId;
                }
            });
            
            if (latestLecture) {
                window.location.href = '/lectures/' + latestLecture + '/';
            }
        });
        
        // 続きから学習（個別ボタン）
        $(document).on('click', '.continue-from-here', function() {
            var button = $(this);
            var lectureId = button.data('lecture-id');
            var episodeNumber = button.data('episode');
            
            if (lectureId && episodeNumber) {
                window.location.href = '/lectures/' + lectureId + '/episode-' + episodeNumber + '/';
            } else if (lectureId) {
                window.location.href = '/lectures/' + lectureId + '/';
            }
        });
        
        // シェア
        $(document).on('click', '.share-bookmark', function() {
            var url = $(this).data('url');
            var title = $(this).data('title');
            shareContent(url, title);
        });
        
        // 完了講座の「さらに読み込む」ボタン
        $('#load-more-completed .load-more-btn').on('click', function() {
            var button = $(this);
            var originalText = button.html();
            
            // ローディング状態
            button.html('<i class="fas fa-spinner fa-spin mr-2"></i>読み込み中...')
                  .prop('disabled', true);
            
            // 少し遅延を入れてUXを向上
            setTimeout(function() {
                renderCompletedLectures(false); // 追加読み込み
                
                // ボタンの状態をリセット
                button.html(originalText).prop('disabled', false);
            }, 300);
        });
        
        // お気に入り講師変更ボタン
        $('#change-favorite-professor').on('click', function() {
            window.location.href = '<?php echo home_url('/professor/'); ?>';
        });


    }
    
    function removeBookmark(bookmarkId) {
        console.log('Removing bookmark:', bookmarkId);
        
        var bookmarks = getBookmarks();
        var updatedBookmarks = bookmarks.filter(function(bookmark) {
            return bookmark.id !== bookmarkId;
        });
        
        console.log('Bookmarks before:', bookmarks.length, 'after:', updatedBookmarks.length);
        
        localStorage.setItem('nfu_bookmarks', JSON.stringify(updatedBookmarks));
        
        // 削除したブックマークの要素を即座に削除
        var bookmarkCard = $('.remove-bookmark[data-bookmark-id="' + bookmarkId + '"]').closest('.bookmark-card');
        
        console.log('Found bookmark card:', bookmarkCard.length);
        
        if (bookmarkCard.length > 0) {
            bookmarkCard.fadeOut(300, function() {
                $(this).remove();
                
                // 削除後にお気に入りが空になった場合の処理
                if (updatedBookmarks.length === 0) {
                    $('#empty-bookmarks').removeClass('hidden');
                    $('#bookmarks-grid').addClass('hidden');
                }
                
                // 統計を更新
                $('#bookmarks-count').text(updatedBookmarks.length);
                $('#bookmarks-info').text(updatedBookmarks.length + '件のお気に入り');
                
                console.log('Bookmark removed successfully');
            });
        } else {
            console.error('Bookmark card not found for ID:', bookmarkId);
            // 要素が見つからない場合は、ページを再読み込み
            loadBookmarksData();
        }
        
        showNotification('お気に入りから削除しました', 'info');
    }
    

    
    function sortBookmarks(sortType) {
        var bookmarks = getBookmarks();
        
        switch(sortType) {
            case 'recent':
                bookmarks.sort((a, b) => b.timestamp - a.timestamp);
                break;
            case 'oldest':
                bookmarks.sort((a, b) => a.timestamp - b.timestamp);
                break;
            case 'title':
                bookmarks.sort((a, b) => a.title.localeCompare(b.title));
                break;
        }
        
        renderBookmarks(bookmarks);
    }
    
    function getBookmarks() {
        var bookmarks = localStorage.getItem('nfu_bookmarks');
        return bookmarks ? JSON.parse(bookmarks) : [];
    }
    
    function getProgress() {
        var progress = localStorage.getItem('nfu_progress');
        return progress ? JSON.parse(progress) : {};
    }
    
    function getEpisodeCompletions() {
        var completions = localStorage.getItem('nfu_episode_completion');
        return completions ? JSON.parse(completions) : {};
    }
    
    // お気に入り講師管理
    function getFavoriteProfessor() {
        var favoriteProfessor = localStorage.getItem('nfu_favorite_professor');
        return favoriteProfessor || '-';
    }
    
    function setFavoriteProfessor(professorName) {
        localStorage.setItem('nfu_favorite_professor', professorName);
        console.log('Favorite professor set to:', professorName);
    }
    
    function removeFavoriteProfessor() {
        localStorage.removeItem('nfu_favorite_professor');
        console.log('Favorite professor removed');
    }
    
    function shareContent(url, title) {
        if (navigator.share) {
            navigator.share({
                title: title + ' - ネコフリークス大学',
                url: url
            });
        } else if (navigator.clipboard) {
            navigator.clipboard.writeText(url).then(function() {
                showNotification('URLをクリップボードにコピーしました', 'success');
            });
        }
    }
    
    function showNotification(message, type) {
        var bgColor = type === 'success' ? 'bg-green-500' : 
                      type === 'error' ? 'bg-red-500' : 'bg-blue-500';
        
        var notification = $('<div class="fixed top-4 right-4 ' + bgColor + ' text-white px-4 py-2 rounded-lg shadow-lg z-50">' +
            '<div class="flex items-center">' +
                '<i class="fas fa-paw mr-2"></i>' +
                '<span>' + message + '</span>' +
            '</div>' +
        '</div>');
        
        $('body').append(notification);
        
        setTimeout(function() {
            notification.fadeOut(function() {
                notification.remove();
            });
        }, 3000);
    }
});
</script>

<?php get_footer(); ?>