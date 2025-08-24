/**
 * ブックマークとシェア機能
 */
jQuery(document).ready(function($) {
    
    // ローカルストレージキー
    var BOOKMARKS_KEY = 'nfu_bookmarks';
    var PROGRESS_KEY = 'nfu_progress';
    
    // ブックマーク機能
    $('.bookmark-button').on('click', function() {
        var button = $(this);
        var lectureId = button.data('lecture-id');
        var lectureTitle = button.data('lecture-title');
        var bookmarkText = button.find('.bookmark-text');
        var icon = button.find('i');
        
        var bookmarks = getBookmarks();
        var isBookmarked = bookmarks.some(function(bookmark) {
            return bookmark.id == lectureId;
        });
        
        if (isBookmarked) {
            // ブックマークを削除
            bookmarks = bookmarks.filter(function(bookmark) {
                return bookmark.id != lectureId;
            });
            
            // UIを更新
            icon.removeClass('fas').addClass('far');
            bookmarkText.text('お気に入りに追加');
            button.removeClass('text-blue-600').addClass('text-gray-600');
            
            // アニメーション
            button.addClass('animate-bounce');
            setTimeout(function() {
                button.removeClass('animate-bounce');
            }, 500);
            
            showNotification('お気に入りから削除しました', 'info');
        } else {
            // ブックマークを追加
            bookmarks.push({
                id: lectureId,
                title: lectureTitle,
                url: window.location.href,
                timestamp: Date.now()
            });
            
            // UIを更新
            icon.removeClass('far').addClass('fas');
            bookmarkText.text('お気に入り済み');
            button.removeClass('text-gray-600').addClass('text-blue-600');
            
            // アニメーション
            button.addClass('animate-pulse');
            setTimeout(function() {
                button.removeClass('animate-pulse');
            }, 1000);
            
            showNotification('お気に入りに追加しました', 'success');
        }
        
        // ブックマークを保存
        localStorage.setItem(BOOKMARKS_KEY, JSON.stringify(bookmarks));
        
        // デバッグ情報
        if (typeof console !== 'undefined' && console.log) {
            console.log('NFU Bookmark:', isBookmarked ? 'Removed' : 'Added', lectureTitle);
        }
    });
    
    // エピソード進捗ブックマーク機能
    $('.bookmark-episode-button').on('click', function() {
        var button = $(this);
        var episodeId = button.data('episode-id');
        var episodeNumber = button.data('episode-number');
        var lectureId = button.data('lecture-id');
        
        // 進捗情報を保存
        var progress = getProgress();
        progress[lectureId] = {
            currentEpisode: episodeNumber,
            episodeId: episodeId,
            timestamp: Date.now()
        };
        
        localStorage.setItem(PROGRESS_KEY, JSON.stringify(progress));
        
        // UIフィードバック
        var originalText = button.text();
        var icon = button.find('i');
        
        button.text('設定完了！');
        icon.removeClass('fa-bookmark').addClass('fa-check');
        button.removeClass('text-gray-600').addClass('text-green-600');
        
        setTimeout(function() {
            button.html('<i class="fas fa-bookmark mr-2"></i>続きから再生に設定');
            button.removeClass('text-green-600').addClass('text-gray-600');
        }, 2000);
        
        showNotification('続きから再生に設定しました', 'success');
        
        if (typeof console !== 'undefined' && console.log) {
            console.log('NFU Progress Set:', lectureId, 'Episode:', episodeNumber);
        }
    });
    
    // シェア機能
    $('.share-button').on('click', function() {
        var button = $(this);
        var url = button.data('url');
        var title = button.data('title');
        
        // Web Share APIが利用可能な場合
        if (navigator.share) {
            navigator.share({
                title: title + ' - ネコフリークス大学',
                text: '猫について学べる講座をチェック！',
                url: url
            }).then(function() {
                showNotification('シェアありがとうございます！', 'success');
            }).catch(function(error) {
                // ユーザーがキャンセルした場合は何もしない
                if (error.name !== 'AbortError') {
                    console.log('Share error:', error);
                    fallbackShare(url, title);
                }
            });
        } else {
            // フォールバック：クリップボードにコピー
            fallbackShare(url, title);
        }
    });
    
    // フォールバックシェア機能
    function fallbackShare(url, title) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(url).then(function() {
                showNotification('URLをクリップボードにコピーしました', 'success');
            }).catch(function() {
                showShareModal(url, title);
            });
        } else {
            showShareModal(url, title);
        }
    }
    
    // シェアモーダル表示
    function showShareModal(url, title) {
        var modal = $('<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" id="share-modal">' +
            '<div class="bg-white rounded-lg p-6 max-w-md mx-4">' +
                '<h3 class="text-lg font-bold mb-4">講座をシェア</h3>' +
                '<p class="text-sm text-gray-600 mb-4">以下のURLをコピーしてシェアしてください：</p>' +
                '<input type="text" value="' + url + '" class="w-full p-2 border border-gray-300 rounded mb-4" readonly id="share-url">' +
                '<div class="flex space-x-2">' +
                    '<button class="flex-1 bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700" id="copy-url">コピー</button>' +
                    '<button class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded hover:bg-gray-400" id="close-modal">閉じる</button>' +
                '</div>' +
            '</div>' +
        '</div>');
        
        $('body').append(modal);
        
        // URLをコピー
        modal.find('#copy-url').on('click', function() {
            var urlInput = document.getElementById('share-url');
            urlInput.select();
            urlInput.setSelectionRange(0, 99999);
            document.execCommand('copy');
            showNotification('URLをコピーしました', 'success');
            modal.remove();
        });
        
        // モーダルを閉じる
        modal.find('#close-modal, #share-modal').on('click', function(e) {
            if (e.target === this) {
                modal.remove();
            }
        });
        
        // URLを選択状態にする
        modal.find('#share-url').select();
    }
    
    // ブックマーク取得
    function getBookmarks() {
        var bookmarks = localStorage.getItem(BOOKMARKS_KEY);
        return bookmarks ? JSON.parse(bookmarks) : [];
    }
    
    // 進捗取得
    function getProgress() {
        var progress = localStorage.getItem(PROGRESS_KEY);
        return progress ? JSON.parse(progress) : {};
    }
    
    // 通知表示
    function showNotification(message, type) {
        var bgColor = type === 'success' ? 'bg-green-500' : 
                      type === 'error' ? 'bg-red-500' : 'bg-blue-500';
        
        var notification = $('<div class="fixed top-4 right-4 ' + bgColor + ' text-white px-4 py-2 rounded-lg shadow-lg z-50 notification">' +
            '<div class="flex items-center">' +
                '<i class="fas fa-paw mr-2"></i>' +
                '<span>' + message + '</span>' +
            '</div>' +
        '</div>');
        
        $('body').append(notification);
        
        // アニメーション
        notification.addClass('animate-slide-in-right');
        
        setTimeout(function() {
            notification.addClass('animate-fade-out');
            setTimeout(function() {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    // ページロード時にブックマーク状態を設定
    function initializeBookmarkStates() {
        var bookmarks = getBookmarks();
        
        $('.bookmark-button').each(function() {
            var button = $(this);
            var lectureId = button.data('lecture-id');
            var isBookmarked = bookmarks.some(function(bookmark) {
                return bookmark.id == lectureId;
            });
            
            if (isBookmarked) {
                var icon = button.find('i');
                var text = button.find('.bookmark-text');
                
                icon.removeClass('far').addClass('fas');
                text.text('お気に入り済み');
                button.removeClass('text-gray-600').addClass('text-blue-600');
            }
        });
    }
    
    // 初期化
    initializeBookmarkStates();
    
    // ブックマーク一覧を表示する関数（他のページで使用可能）
    window.nfuShowBookmarks = function() {
        var bookmarks = getBookmarks();
        
        if (bookmarks.length === 0) {
            showNotification('お気に入りの講座がありません', 'info');
            return;
        }
        
        var modal = $('<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" id="bookmarks-modal">' +
            '<div class="bg-white rounded-lg p-6 max-w-lg mx-4 max-h-96 overflow-y-auto">' +
                '<h3 class="text-lg font-bold mb-4">お気に入りの講座</h3>' +
                '<div id="bookmarks-list"></div>' +
                '<button class="w-full bg-gray-300 text-gray-700 py-2 px-4 rounded hover:bg-gray-400 mt-4" id="close-bookmarks">閉じる</button>' +
            '</div>' +
        '</div>');
        
        var bookmarksList = modal.find('#bookmarks-list');
        
        bookmarks.forEach(function(bookmark) {
            var item = $('<div class="flex items-center justify-between p-2 border-b border-gray-200">' +
                '<div class="flex-1">' +
                    '<a href="' + bookmark.url + '" class="text-blue-600 hover:underline">' + bookmark.title + '</a>' +
                    '<div class="text-xs text-gray-500">追加日: ' + new Date(bookmark.timestamp).toLocaleDateString() + '</div>' +
                '</div>' +
                '<button class="text-red-500 hover:text-red-700 ml-2" data-bookmark-id="' + bookmark.id + '">' +
                    '<i class="fas fa-trash text-sm"></i>' +
                '</button>' +
            '</div>');
            
            bookmarksList.append(item);
        });
        
        $('body').append(modal);
        
        // ブックマーク削除
        modal.on('click', '[data-bookmark-id]', function() {
            var bookmarkId = $(this).data('bookmark-id');
            var updatedBookmarks = bookmarks.filter(function(bookmark) {
                return bookmark.id != bookmarkId;
            });
            
            localStorage.setItem(BOOKMARKS_KEY, JSON.stringify(updatedBookmarks));
            $(this).closest('.flex').remove();
            
            if (updatedBookmarks.length === 0) {
                modal.remove();
                showNotification('すべてのお気に入りを削除しました', 'info');
            } else {
                showNotification('お気に入りから削除しました', 'info');
            }
        });
        
        // モーダルを閉じる
        modal.find('#close-bookmarks').on('click', function() {
            modal.remove();
        });
    };
});