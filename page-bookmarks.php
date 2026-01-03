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
                        <div class="flex items-center gap-4">
                            <div class="text-sm text-gray-500" id="completed-lectures-info">
                                読み込み中...
                            </div>
                            <a href="<?php echo home_url('/certificate/'); ?>" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition-colors inline-flex items-center text-sm font-medium shadow-md">
                                <i class="fas fa-certificate mr-2"></i>修了証を見る
                            </a>
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
(function() {
    'use strict';
    
    // 完了講座管理
    var completedLecturesData = {
        lectures: [],
        currentOffset: 0,
        perPage: 5,
        hasMore: false
    };
    
    // DOMContentLoadedイベントで初期化
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initBookmarksPage);
    } else {
        initBookmarksPage();
    }
    
    function initBookmarksPage() {
        console.log('Initializing bookmarks page...');
        
        // 読み込み中表示を初期化
        var bookmarksInfo = document.getElementById('bookmarks-info');
        var completedInfo = document.getElementById('completed-lectures-info');
        if (bookmarksInfo) bookmarksInfo.textContent = '読み込み中...';
        if (completedInfo) completedInfo.textContent = '読み込み中...';
        
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
    
    function clearLoadingStates() {
        var bookmarks = getBookmarks();
        var completedCount = 0;
        
        // completedLecturesDataが存在することを確認
        if (typeof completedLecturesData !== 'undefined' && completedLecturesData.lectures) {
            completedCount = completedLecturesData.lectures.length;
        }
        
        var bookmarksInfo = document.getElementById('bookmarks-info');
        var completedInfo = document.getElementById('completed-lectures-info');
        if (bookmarksInfo) bookmarksInfo.textContent = bookmarks.length + '件のお気に入り';
        if (completedInfo) completedInfo.textContent = completedCount + '件';
        
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
        
        var emptyBookmarks = document.getElementById('empty-bookmarks');
        var bookmarksGrid = document.getElementById('bookmarks-grid');
        
        if (bookmarks.length === 0) {
            if (emptyBookmarks) emptyBookmarks.classList.remove('hidden');
            if (bookmarksGrid) bookmarksGrid.classList.add('hidden');
        } else {
            if (emptyBookmarks) emptyBookmarks.classList.add('hidden');
            if (bookmarksGrid) bookmarksGrid.classList.remove('hidden');
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
        var emptyProgress = document.getElementById('empty-progress');
        var progressGrid = document.getElementById('progress-grid');
        if (emptyProgress) emptyProgress.classList.add('hidden');
        if (progressGrid) progressGrid.classList.remove('hidden');
        
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
            if (progressGrid) {
                progressGrid.innerHTML = '<div class="text-center py-8 text-gray-500">まだ学習を開始した講座がありません</div>';
            }
        }
        
        // 統計情報を更新
        updateStats();
        
        // 読み込み完了の明示的な処理
        setTimeout(function() {
            // 統計情報を即座に更新
            var bookmarksCount = document.getElementById('bookmarks-count');
            if (bookmarksCount) bookmarksCount.textContent = bookmarks.length;
            
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
            var progressCount = document.getElementById('progress-count');
            if (progressCount) progressCount.textContent = studyingLectures.size;
            
            // 読み込み中テキストを削除
            var bookmarksInfo = document.getElementById('bookmarks-info');
            if (bookmarksInfo) bookmarksInfo.textContent = bookmarks.length + '件のお気に入り';
            
            // ローディング状態のクラスを削除
            var loadingStates = document.querySelectorAll('.loading-state');
            loadingStates.forEach(function(el) {
                el.classList.remove('loading-state');
            });
            
            // デバッグ用ログ
            console.log('Loading completed, bookmarks:', bookmarks.length, 'studying:', studyingLectures.size);
        }, 100);
        
        // 完了講座の読み込み中表示を強制的に更新
        setTimeout(function() {
            var completedCount = completedLecturesData.lectures ? completedLecturesData.lectures.length : 0;
            var completedInfo = document.getElementById('completed-lectures-info');
            if (completedInfo) completedInfo.textContent = completedCount + '件';
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
            
            var bookmarksInfo = document.getElementById('bookmarks-info');
            var completedInfo = document.getElementById('completed-lectures-info');
            if (bookmarksInfo) bookmarksInfo.textContent = bookmarks.length + '件のお気に入り';
            if (completedInfo) completedInfo.textContent = completedCount + '件';
            
            console.log('Final update - Bookmarks:', bookmarks.length, 'Completed:', completedCount);
        }, 300);
    }
    
    function renderBookmarks(bookmarks) {
        var grid = document.getElementById('bookmarks-grid');
        if (!grid) return;
        
        grid.innerHTML = '';
        
        bookmarks.forEach(function(bookmark) {
            var card = document.createElement('div');
            card.className = 'bookmark-card bg-gray-50 rounded-lg p-4 hover:shadow-md transition-shadow';
            card.innerHTML = '<div class="flex items-start justify-between mb-3">' +
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
            '</div>';
            
            grid.appendChild(card);
        });
    }
    
    // 講座データを取得する関数
    function getLectureData(lectureIds) {
        if (!window.nfu_ajax) {
            return Promise.reject('nfu_ajax is not defined');
        }
        
        var formData = new FormData();
        formData.append('action', 'get_lecture_data');
        formData.append('lecture_ids', JSON.stringify(lectureIds));
        formData.append('nonce', window.nfu_ajax.nonce);
        
        return fetch(window.nfu_ajax.ajax_url, {
            method: 'POST',
            body: formData
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (typeof console !== 'undefined' && console.log) {
                console.log('getLectureData response:', data);
                if (data.success && data.data) {
                    console.log('getLectureData data keys:', Object.keys(data.data));
                }
            }
            if (data.success && data.data) {
                // データのキーを正規化（数値キーと文字列キーの両方をチェック）
                var normalizedData = {};
                Object.keys(data.data).forEach(function(key) {
                    var value = data.data[key];
                    var normalizedKey = key;
                    
                    // 文字列がJSON配列の場合の処理（例: '["8"]'）
                    if (typeof key === 'string' && key.match(/^\[.*\]$/)) {
                        try {
                            var decoded = JSON.parse(key);
                            if (Array.isArray(decoded) && decoded.length > 0) {
                                normalizedKey = decoded[0];
                            }
                        } catch (e) {
                            // JSONパースに失敗した場合は元のキーを使用
                        }
                    }
                    
                    var numKey = parseInt(normalizedKey);
                    var strKey = String(normalizedKey);
                    
                    // 数値キーと文字列キーの両方で保存
                    if (!isNaN(numKey) && isFinite(numKey)) {
                        normalizedData[numKey] = value;
                        normalizedData[strKey] = value;
                    } else {
                        normalizedData[normalizedKey] = value;
                    }
                    
                    // 元のキーも保存（フォールバック用）
                    if (key !== normalizedKey && key !== String(numKey) && key !== numKey) {
                        normalizedData[key] = value;
                    }
                });
                
                if (typeof console !== 'undefined' && console.log) {
                    console.log('getLectureData normalized keys:', Object.keys(normalizedData));
                    console.log('getLectureData sample data:', normalizedData[Object.keys(normalizedData)[0]]);
                }
                
                return normalizedData;
            } else {
                console.error('getLectureData failed:', data);
                throw new Error(data.data || 'Failed to load lecture data');
            }
        });
    }

    function renderProgress(progress, episodeCompletions) {
        console.log('=== RENDER PROGRESS START ===');
        var container = document.getElementById('progress-grid');
        if (!container) {
            console.error('progress-grid container not found');
            return;
        }
        console.log('Container found:', container !== null);
        container.innerHTML = '';
        
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
            container.innerHTML = '<div class="text-center py-8 text-gray-500">まだ学習を開始した講座がありません</div>';
            return;
        }
        
        // 講座データを取得してからレンダリング
        var lectureIds = Object.keys(lectureProgress);
        if (typeof console !== 'undefined' && console.log) {
            console.log('Requesting lecture data for IDs:', lectureIds);
        }
        
        getLectureData(lectureIds).then(function(lectureData) {
            if (typeof console !== 'undefined' && console.log) {
                console.log('Received lecture data:', lectureData);
            }
            
            // 各講座の進捗アイテムをレンダリング
            Object.keys(lectureProgress).forEach(function(lectureId) {
                var progData = lectureProgress[lectureId];
                var completedCount = progData.completedEpisodes.length;
                var totalEpisodes = 5; // デフォルト値
                var completionPercentage = Math.round((completedCount / totalEpisodes) * 100);
                
                // 講座タイトルを取得
                var lectureTitle = '講座 #' + lectureId; // デフォルト
                var lectureUrl = '/lectures/' + lectureId + '/';
                
                // 講座IDを数値に変換して試す（文字列の場合と数値の場合の両方に対応）
                var lectureIdNum = parseInt(lectureId);
                var lectureIdStr = String(lectureId);
                
                if (lectureData) {
                    // まず利用可能なキーを確認
                    var availableKeys = Object.keys(lectureData);
                    
                    // 数値キーと文字列キーの両方をチェック
                    var lectureInfo = lectureData[lectureId] || 
                                      lectureData[lectureIdNum] || 
                                      lectureData[lectureIdStr];
                    
                    // 見つからない場合、JSON文字列化されたキーをチェック（PHP側のバグ対応）
                    if (!lectureInfo) {
                        var jsonKey1 = JSON.stringify([lectureId]);
                        var jsonKey2 = JSON.stringify(lectureId);
                        lectureInfo = lectureData[jsonKey1] || lectureData[jsonKey2];
                    }
                    
                    // まだ見つからない場合、利用可能なキーから最初のデータを使用
                    if (!lectureInfo && availableKeys.length > 0) {
                        console.warn('Lecture data not found for ID:', lectureId, 'Available keys:', availableKeys);
                        console.warn('Using first available key:', availableKeys[0]);
                        lectureInfo = lectureData[availableKeys[0]];
                    }
                    
                    if (lectureInfo) {
                        lectureTitle = lectureInfo.title || lectureTitle;
                        lectureUrl = lectureInfo.url || lectureUrl;
                        totalEpisodes = lectureInfo.total_episodes || totalEpisodes;
                        completionPercentage = Math.round((completedCount / totalEpisodes) * 100);
                        
                        if (typeof console !== 'undefined' && console.log) {
                            console.log('Lecture info found:', {
                                id: lectureId,
                                title: lectureTitle,
                                totalEpisodes: totalEpisodes,
                                url: lectureUrl
                            });
                        }
                    } else {
                        console.error('Lecture data not found for ID:', lectureId, 'Available keys:', availableKeys);
                    }
                }
                
                var progressItem = document.createElement('div');
                progressItem.className = 'progress-item bg-gray-50 rounded-lg p-4 border border-gray-200';
                progressItem.innerHTML = '<div class="flex items-center justify-between mb-3">' +
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
                    '<a href="' + lectureUrl + '" class="flex-1 bg-blue-600 text-white py-2 px-3 rounded text-sm hover:bg-blue-700 transition-colors text-center inline-flex items-center justify-center">' +
                        '<i class="fas fa-book-open mr-1"></i>講座を見る' +
                    '</a>' +
                    (completionPercentage < 100 ?
                        '<button class="continue-from-here bg-purple-600 text-white py-2 px-3 rounded text-sm hover:bg-purple-700 transition-colors" data-lecture-id="' + lectureId + '" data-episode="' + progData.currentEpisode + '">' +
                            '<i class="fas fa-play mr-1"></i>続きから' +
                        '</button>' :
                        '<button class="bg-green-600 text-white py-2 px-3 rounded text-sm cursor-default" disabled>' +
                            '<i class="fas fa-check mr-1"></i>完了' +
                        '</button>'
                    ) +
                '</div>';
            
            container.appendChild(progressItem);
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
                
                // エラー時もlectureUrlを設定
                var lectureUrl = '/lectures/' + lectureId + '/';
                
                var progressItem = document.createElement('div');
                progressItem.className = 'progress-item bg-gray-50 rounded-lg p-4 border border-gray-200';
                progressItem.innerHTML = '<div class="flex items-center justify-between mb-3">' +
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
                    '<a href="' + lectureUrl + '" class="flex-1 bg-blue-600 text-white py-2 px-3 rounded text-sm hover:bg-blue-700 transition-colors text-center inline-flex items-center justify-center">' +
                        '<i class="fas fa-book-open mr-1"></i>講座を見る' +
                    '</a>' +
                    (completionPercentage < 100 ?
                        '<button class="continue-from-here bg-purple-600 text-white py-2 px-3 rounded text-sm hover:bg-purple-700 transition-colors" data-lecture-id="' + lectureId + '" data-episode="' + progData.currentEpisode + '">' +
                            '<i class="fas fa-play mr-1"></i>続きから' +
                        '</button>' :
                        '<button class="bg-green-600 text-white py-2 px-3 rounded text-sm cursor-default" disabled>' +
                            '<i class="fas fa-check mr-1"></i>完了' +
                        '</button>'
                    ) +
                '</div>';
                
                container.appendChild(progressItem);
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
        if (typeof console !== 'undefined' && console.log) {
            console.log('Requesting lecture data for completed lectures, IDs:', lectureIds);
        }
        
        getLectureData(lectureIds).then(function(lectureData) {
            if (typeof console !== 'undefined' && console.log) {
                console.log('Received lecture data for completed lectures:', lectureData);
            }
            
            // 100%完了した講座のみを抽出
            var completedLectures = [];
            Object.keys(lectureCompletions).forEach(function(lectureId) {
                var lectureDataItem = lectureCompletions[lectureId];
                var totalEpisodes = 5; // デフォルト値
                var lectureTitle = lectureDataItem.title; // デフォルト
                var lectureUrl = '/lectures/' + lectureId + '/';
                
                // 講座IDを数値に変換して試す（文字列の場合と数値の場合の両方に対応）
                var lectureIdNum = parseInt(lectureId);
                var lectureIdStr = String(lectureId);
                
                // 講座データから実際のタイトルとエピソード数を取得
                if (lectureData) {
                    // まず利用可能なキーを確認
                    var availableKeys = Object.keys(lectureData);
                    
                    // 数値キーと文字列キーの両方をチェック
                    var lectureInfo = lectureData[lectureId] || 
                                      lectureData[lectureIdNum] || 
                                      lectureData[lectureIdStr];
                    
                    // 見つからない場合、JSON文字列化されたキーをチェック（PHP側のバグ対応）
                    if (!lectureInfo) {
                        var jsonKey1 = JSON.stringify([lectureId]);
                        var jsonKey2 = JSON.stringify(lectureId);
                        lectureInfo = lectureData[jsonKey1] || lectureData[jsonKey2];
                    }
                    
                    // まだ見つからない場合、利用可能なキーから最初のデータを使用
                    if (!lectureInfo && availableKeys.length > 0) {
                        console.warn('Completed lecture data not found for ID:', lectureId, 'Available keys:', availableKeys);
                        console.warn('Using first available key:', availableKeys[0]);
                        lectureInfo = lectureData[availableKeys[0]];
                    }
                    
                    if (lectureInfo) {
                        lectureTitle = lectureInfo.title || lectureTitle;
                        lectureUrl = lectureInfo.url || lectureUrl;
                        totalEpisodes = lectureInfo.total_episodes || totalEpisodes;
                        
                        if (typeof console !== 'undefined' && console.log) {
                            console.log('Completed lecture info found:', {
                                id: lectureId,
                                title: lectureTitle,
                                totalEpisodes: totalEpisodes,
                                url: lectureUrl
                            });
                        }
                    } else {
                        console.error('Completed lecture data not found for ID:', lectureId, 'Available keys:', availableKeys);
                        // フォールバック: 利用可能なキーから最初のデータを使用
                        if (availableKeys.length > 0) {
                            console.warn('Using first available key:', availableKeys[0]);
                            lectureInfo = lectureData[availableKeys[0]];
                            if (lectureInfo) {
                                lectureTitle = lectureInfo.title || lectureTitle;
                                lectureUrl = lectureInfo.url || lectureUrl;
                                totalEpisodes = lectureInfo.total_episodes || totalEpisodes;
                            }
                        }
                    }
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
                    
                    if (typeof console !== 'undefined' && console.log) {
                        console.log('Added completed lecture:', {
                            id: lectureId,
                            title: lectureTitle,
                            url: lectureUrl
                        });
                    }
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
                var completedInfo = document.getElementById('completed-lectures-info');
                if (completedInfo) completedInfo.textContent = completedCount + '件';
                console.log('Completed lectures loaded:', completedCount);
            }, 50);
            
            // 念のため、もう一度更新
            setTimeout(function() {
                var completedCount = completedLecturesData.lectures ? completedLecturesData.lectures.length : 0;
                var completedInfo = document.getElementById('completed-lectures-info');
                if (completedInfo) completedInfo.textContent = completedCount + '件';
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
                var completedInfo = document.getElementById('completed-lectures-info');
                if (completedInfo) completedInfo.textContent = completedCount + '件';
            }, 50);
        });
    }
    
    function renderCompletedLectures(isInitial) {
        var container = document.getElementById('completed-lectures-list');
        if (!container) return;
        
        // completedLecturesDataが存在することを確認
        if (typeof completedLecturesData === 'undefined') {
            console.error('completedLecturesData is undefined in renderCompletedLectures');
            var completedInfo = document.getElementById('completed-lectures-info');
            if (completedInfo) completedInfo.textContent = '0件';
            return;
        }
        
        var lectures = completedLecturesData.lectures;
        var offset = completedLecturesData.currentOffset;
        var perPage = completedLecturesData.perPage;
        
        if (isInitial) {
            container.innerHTML = '';
            completedLecturesData.currentOffset = 0;
            offset = 0;
        }
        
        // 表示する講座を取得
        var lecturesSlice = lectures.slice(offset, offset + perPage);
        var remainingCount = lectures.length - (offset + perPage);
        
        var emptyCompleted = document.getElementById('empty-completed');
        var loadMoreCompleted = document.getElementById('load-more-completed');
        var completedInfo = document.getElementById('completed-lectures-info');
        var paginationInfo = document.getElementById('completed-pagination-info');
        
        if (lectures.length === 0) {
            if (emptyCompleted) emptyCompleted.classList.remove('hidden');
            if (container) container.classList.add('hidden');
            if (loadMoreCompleted) loadMoreCompleted.classList.add('hidden');
            if (completedInfo) completedInfo.textContent = '0件';
            return;
        }
        
        if (emptyCompleted) emptyCompleted.classList.add('hidden');
        if (container) container.classList.remove('hidden');
        
        // 講座アイテムを生成
        lecturesSlice.forEach(function(lecture) {
            var completedDate = new Date(lecture.completedAt).toLocaleDateString('ja-JP');
            
            var lectureItem = document.createElement('div');
            lectureItem.className = 'completed-lecture-item flex items-center justify-between py-3 px-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors';
            lectureItem.innerHTML = '<div class="flex-1">' +
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
            '</div>';
            
            container.appendChild(lectureItem);
        });
        
        // 情報テキストを更新
        if (completedInfo) completedInfo.textContent = lectures.length + '件';
        console.log('renderCompletedLectures: Updated info text to', lectures.length + '件');
        
        // もっと見るボタンの表示制御
        if (remainingCount > 0) {
            if (loadMoreCompleted) loadMoreCompleted.classList.remove('hidden');
            if (paginationInfo) paginationInfo.textContent = '残り ' + remainingCount + '件';
            completedLecturesData.hasMore = true;
        } else {
            if (loadMoreCompleted) loadMoreCompleted.classList.add('hidden');
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
        var bookmarksCount = document.getElementById('bookmarks-count');
        if (bookmarksCount) bookmarksCount.textContent = bookmarks.length;
        
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
        
        var progressCount = document.getElementById('progress-count');
        if (progressCount) progressCount.textContent = studyingLectures.size;
        
        // 完了率の計算を改善
        var lectureCompletions = {};
        
        // 各講座の完了エピソード数を計算
        Object.values(completions).forEach(function(completion) {
            var lectureId = completion.lectureId;
            if (!lectureCompletions[lectureId]) {
                lectureCompletions[lectureId] = {
                    completedEpisodes: new Set(),
                    totalEpisodes: 5 // デフォルト値（後で更新される）
                };
            }
            lectureCompletions[lectureId].completedEpisodes.add(completion.episodeNumber);
        });
        
        // 講座データを取得して完了率を正確に計算
        var lectureIds = Object.keys(lectureCompletions);
        if (lectureIds.length > 0 && window.nfu_ajax) {
            var formData = new FormData();
            formData.append('action', 'get_lecture_data');
            formData.append('lecture_ids', JSON.stringify(lectureIds));
            formData.append('nonce', window.nfu_ajax.nonce);
            
            fetch(window.nfu_ajax.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.success && data.data) {
                    var lectureData = data.data;
                    
                    // 各講座の実際のエピソード数を更新
                    Object.keys(lectureCompletions).forEach(function(lectureId) {
                        if (lectureData[lectureId] && lectureData[lectureId].total_episodes) {
                            lectureCompletions[lectureId].totalEpisodes = lectureData[lectureId].total_episodes;
                        }
                    });
                    
                    // 完了率を計算
                    var completionRates = [];
                    Object.keys(lectureCompletions).forEach(function(lectureId) {
                        var completedEpisodes = lectureCompletions[lectureId].completedEpisodes.size;
                        var totalEpisodes = lectureCompletions[lectureId].totalEpisodes;
                        if (totalEpisodes > 0) {
                            var rate = (completedEpisodes / totalEpisodes) * 100;
                            // 100%を超えないように制限
                            completionRates.push(Math.min(100, Math.round(rate)));
                        }
                    });
                    
                    var avgCompletion = completionRates.length > 0 ? 
                        Math.round(completionRates.reduce(function(a, b) { return a + b; }, 0) / completionRates.length) : 0;
                    var completionRate = document.getElementById('completion-rate');
                    if (completionRate) completionRate.textContent = avgCompletion + '%';
                    
                    console.log('Completion rate calculated:', {
                        rates: completionRates,
                        average: avgCompletion,
                        lectureCount: completionRates.length
                    });
                    
                    // 完了した講座数を計算
                    var fullyCompletedLectures = 0;
                    Object.keys(lectureCompletions).forEach(function(lectureId) {
                        var completedEpisodes = lectureCompletions[lectureId].completedEpisodes.size;
                        var totalEpisodes = lectureCompletions[lectureId].totalEpisodes;
                        if (completedEpisodes >= totalEpisodes) {
                            fullyCompletedLectures++;
                        }
                    });
                    
                    var completedLecturesEl = document.getElementById('completed-lectures');
                    if (completedLecturesEl) completedLecturesEl.textContent = fullyCompletedLectures;
                    
                    // 完了講座の情報表示はloadCompletedLectures()で更新されるので、ここでは更新しない
                } else {
                    // データ取得に失敗した場合はデフォルト値で計算
                    calculateCompletionRateWithDefault(lectureCompletions);
                }
            })
            .catch(function(error) {
                console.error('Failed to load lecture data for stats:', error);
                // エラー時はデフォルト値で計算
                calculateCompletionRateWithDefault(lectureCompletions);
            });
        } else {
            // 講座データがない場合はデフォルト値で計算
            calculateCompletionRateWithDefault(lectureCompletions);
        }
        
        // デフォルト値で完了率を計算する関数
        function calculateCompletionRateWithDefault(lectureCompletions) {
            var totalEpisodes = 5; // デフォルト値
            var completionRates = [];
            Object.keys(lectureCompletions).forEach(function(lectureId) {
                var completedEpisodes = lectureCompletions[lectureId].completedEpisodes.size;
                completionRates.push((completedEpisodes / totalEpisodes) * 100);
            });
            
            var avgCompletion = completionRates.length > 0 ? 
                Math.round(completionRates.reduce(function(a, b) { return a + b; }, 0) / completionRates.length) : 0;
            var completionRate = document.getElementById('completion-rate');
            if (completionRate) completionRate.textContent = avgCompletion + '%';
            
            // 完了した講座数を計算
            var fullyCompletedLectures = 0;
            Object.keys(lectureCompletions).forEach(function(lectureId) {
                var completedEpisodes = lectureCompletions[lectureId].completedEpisodes.size;
                if (completedEpisodes >= totalEpisodes) {
                    fullyCompletedLectures++;
                }
            });
            
            var completedLecturesEl = document.getElementById('completed-lectures');
            if (completedLecturesEl) completedLecturesEl.textContent = fullyCompletedLectures;
            
            // 完了講座の情報表示はloadCompletedLectures()で更新されるので、ここでは更新しない
        }
        
        // 完了した講座数はcompletedLecturesDataから取得（loadCompletedLectures()で設定される）
        if (typeof completedLecturesData !== 'undefined' && completedLecturesData.lectures) {
            var completedLectures = document.getElementById('completed-lectures');
            if (completedLectures) completedLectures.textContent = completedLecturesData.lectures.length;
        }
        
        // 今週の学習エピソード数を計算（概算）
        var weeklyEpisodes = 0;
        var oneWeekAgo = Date.now() - (7 * 24 * 60 * 60 * 1000);
        
        Object.values(completions).forEach(function(completion) {
            if (completion.timestamp > oneWeekAgo) {
                weeklyEpisodes++;
            }
        });
        
        var estimatedMinutes = weeklyEpisodes * 15; // 1エピソード15分と仮定
        var weeklyTime = document.getElementById('weekly-time');
        if (weeklyTime) weeklyTime.textContent = estimatedMinutes + '分';
        var weeklyProgress = document.getElementById('weekly-progress');
        if (weeklyProgress) weeklyProgress.style.width = Math.min(100, (weeklyEpisodes / 5) * 100) + '%';
        
        // お気に入り講師の統計
        var favoriteProfessor = getFavoriteProfessor();
        var favoriteProf = document.getElementById('favorite-professor');
        if (favoriteProf) favoriteProf.textContent = favoriteProfessor;
    }
    
    function setupEventHandlers() {
        // お気に入り削除（イベント委譲を改善）
        document.addEventListener('click', function(e) {
            // e.targetが要素でない場合（テキストノードなど）は親要素を取得
            var target = e.target.nodeType === 3 ? e.target.parentElement : e.target;
            var removeBtn = target.closest ? target.closest('.remove-bookmark') : null;
            if (removeBtn) {
                e.preventDefault();
                e.stopPropagation();
                
                var bookmarkId = removeBtn.dataset.bookmarkId;
                console.log('Remove bookmark clicked:', bookmarkId);
                
                if (bookmarkId) {
                    removeBookmark(bookmarkId);
                } else {
                    console.error('Bookmark ID not found');
                }
            }
        });
        
        // 削除ボタンのホバー効果を追加
        document.addEventListener('mouseenter', function(e) {
            var target = e.target.nodeType === 3 ? e.target.parentElement : e.target;
            var removeBtn = target.closest ? target.closest('.remove-bookmark') : null;
            if (removeBtn) {
                removeBtn.classList.add('text-red-700');
            }
        }, true);
        
        document.addEventListener('mouseleave', function(e) {
            var target = e.target.nodeType === 3 ? e.target.parentElement : e.target;
            var removeBtn = target.closest ? target.closest('.remove-bookmark') : null;
            if (removeBtn) {
                removeBtn.classList.remove('text-red-700');
            }
        }, true);
        
        // すべて削除
        var clearAllBtn = document.getElementById('clear-all-bookmarks');
        if (clearAllBtn) {
            clearAllBtn.addEventListener('click', function() {
                if (confirm('すべてのお気に入りを削除しますか？')) {
                    localStorage.removeItem('nfu_bookmarks');
                    loadBookmarksData();
                    updateStats();
                    showNotification('すべてのお気に入りを削除しました', 'info');
                }
            });
        }
        
        // データリセット
        var resetAllBtn = document.getElementById('reset-all-data');
        if (resetAllBtn) {
            resetAllBtn.addEventListener('click', function() {
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
        }
        
        // ソート
        var bookmarkSort = document.getElementById('bookmark-sort');
        if (bookmarkSort) {
            bookmarkSort.addEventListener('change', function() {
                var sortType = this.value;
                sortBookmarks(sortType);
            });
        }
        
        // 続きから学習（ヘッダーボタン）
        var continueLearning = document.getElementById('continue-learning');
        if (continueLearning) {
            continueLearning.addEventListener('click', function() {
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
        }
        
        // 続きから学習（個別ボタン）
        document.addEventListener('click', function(e) {
            var target = e.target.nodeType === 3 ? e.target.parentElement : e.target;
            var continueBtn = target.closest ? target.closest('.continue-from-here') : null;
            if (continueBtn) {
                var lectureId = continueBtn.dataset.lectureId;
                var episodeNumber = continueBtn.dataset.episode;
                
                if (lectureId && episodeNumber) {
                    window.location.href = '/lectures/' + lectureId + '/episode-' + episodeNumber + '/';
                } else if (lectureId) {
                    window.location.href = '/lectures/' + lectureId + '/';
                }
            }
        });
        
        // シェア
        document.addEventListener('click', function(e) {
            var target = e.target.nodeType === 3 ? e.target.parentElement : e.target;
            var shareBtn = target.closest ? target.closest('.share-bookmark') : null;
            if (shareBtn) {
                var url = shareBtn.dataset.url;
                var title = shareBtn.dataset.title;
                shareContent(url, title);
            }
        });
        
        // 完了講座の「さらに読み込む」ボタン
        var loadMoreBtn = document.querySelector('#load-more-completed .load-more-btn');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                var originalHTML = this.innerHTML;
                
                // ローディング状態
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>読み込み中...';
                this.disabled = true;
                
                // 少し遅延を入れてUXを向上
                setTimeout(function() {
                    renderCompletedLectures(false); // 追加読み込み
                    
                    // ボタンの状態をリセット
                    loadMoreBtn.innerHTML = originalHTML;
                    loadMoreBtn.disabled = false;
                }, 300);
            });
        }
        
        // お気に入り講師変更ボタン
        var changeFavoriteProf = document.getElementById('change-favorite-professor');
        if (changeFavoriteProf) {
            changeFavoriteProf.addEventListener('click', function() {
                window.location.href = '<?php echo home_url('/professor/'); ?>';
            });
        }
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
        var removeBtn = document.querySelector('.remove-bookmark[data-bookmark-id="' + bookmarkId + '"]');
        var bookmarkCard = removeBtn && removeBtn.closest ? removeBtn.closest('.bookmark-card') : null;
        
        console.log('Found bookmark card:', bookmarkCard !== null);
        
        if (bookmarkCard) {
            bookmarkCard.style.opacity = '0';
            bookmarkCard.style.transition = 'opacity 0.3s';
            setTimeout(function() {
                bookmarkCard.remove();
                
                // 削除後にお気に入りが空になった場合の処理
                if (updatedBookmarks.length === 0) {
                    var emptyBookmarks = document.getElementById('empty-bookmarks');
                    var bookmarksGrid = document.getElementById('bookmarks-grid');
                    if (emptyBookmarks) emptyBookmarks.classList.remove('hidden');
                    if (bookmarksGrid) bookmarksGrid.classList.add('hidden');
                }
                
                // 統計を更新
                var bookmarksCount = document.getElementById('bookmarks-count');
                var bookmarksInfo = document.getElementById('bookmarks-info');
                if (bookmarksCount) bookmarksCount.textContent = updatedBookmarks.length;
                if (bookmarksInfo) bookmarksInfo.textContent = updatedBookmarks.length + '件のお気に入り';
                
                console.log('Bookmark removed successfully');
            }, 300);
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
        
        var notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 ' + bgColor + ' text-white px-4 py-2 rounded-lg shadow-lg z-50';
        notification.innerHTML = '<div class="flex items-center">' +
            '<i class="fas fa-paw mr-2"></i>' +
            '<span>' + message + '</span>' +
        '</div>';
        
        document.body.appendChild(notification);
        
        setTimeout(function() {
            notification.style.opacity = '0';
            notification.style.transition = 'opacity 0.3s';
            setTimeout(function() {
                notification.remove();
            }, 300);
        }, 3000);
    }
})();
</script>

<?php get_footer(); ?>