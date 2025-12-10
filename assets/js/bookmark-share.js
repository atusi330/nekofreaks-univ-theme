/**
 * ブックマークとシェア機能
 */
(function() {
    'use strict';
    
    // ローカルストレージキー
    var BOOKMARKS_KEY = 'nfu_bookmarks';
    var PROGRESS_KEY = 'nfu_progress';
    
    // DOMContentLoadedイベントで初期化
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
    function init() {
        // ブックマーク機能（.bookmark-button と .favorite-button の両方に対応）
        // イベント委譲を使用して動的に追加される要素にも対応
        document.addEventListener('click', function(e) {
            var button = e.target.closest('.bookmark-button, .favorite-button');
            if (!button) {
                // .favorite-icon がクリックされた場合も親のボタンを取得
                if (e.target.classList.contains('favorite-icon') || e.target.closest('.favorite-icon')) {
                    button = e.target.closest('.favorite-button');
                }
            }
            
            if (!button) {
                return;
            }
            
            e.preventDefault();
            e.stopPropagation();
            
            var lectureId = button.dataset.lectureId;
            var lectureTitle = button.dataset.lectureTitle;
            
            if (!lectureId) {
                console.error('Lecture ID not found on button:', button);
                return;
            }
            
            // lectureTitleが取得できない場合は、親要素から取得を試みる
            if (!lectureTitle) {
                var cardElement = button.closest('.lecture-card');
                if (cardElement) {
                    var titleElement = cardElement.querySelector('h3 a, h2 a, .lecture-title');
                    if (titleElement) {
                        lectureTitle = titleElement.textContent.trim();
                    } else {
                        // 最後の手段として、URLから取得
                        var urlElement = cardElement.querySelector('a[href*="/lectures/"]');
                        if (urlElement) {
                            lectureTitle = urlElement.textContent.trim() || '講座 #' + lectureId;
                        } else {
                            lectureTitle = '講座 #' + lectureId;
                        }
                    }
                } else {
                    lectureTitle = '講座 #' + lectureId;
                }
            }
            
            // URLを取得
            var lectureUrl = window.location.href;
            var cardElement = button.closest('.lecture-card');
            if (cardElement) {
                var urlElement = cardElement.querySelector('a[href*="/lectures/"]');
                if (urlElement && urlElement.href) {
                    lectureUrl = urlElement.href;
                }
            }
            if (!lectureUrl || lectureUrl === window.location.href) {
                lectureUrl = '/lectures/' + lectureId + '/';
            }
            
            var bookmarkText = button.querySelector('.bookmark-text');
            var icon = button.querySelector('i');
            var favoriteIcon = button.querySelector('.favorite-icon');
            
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
                if (icon) {
                    icon.classList.remove('fas');
                    icon.classList.add('far');
                }
                if (favoriteIcon) {
                    favoriteIcon.textContent = '🤍';
                }
                if (bookmarkText) {
                    bookmarkText.textContent = 'お気に入りに追加';
                }
                button.classList.remove('text-blue-600', 'text-red-500', 'is-favorite');
                button.classList.add('text-gray-400', 'text-gray-600');
                
                // アニメーション
                button.classList.add('animate-bounce');
                setTimeout(function() {
                    button.classList.remove('animate-bounce');
                }, 500);
                
                showNotification('お気に入りから削除しました', 'info');
            } else {
                // ブックマークを追加
                bookmarks.push({
                    id: lectureId,
                    title: lectureTitle,
                    url: lectureUrl,
                    timestamp: Date.now()
                });
                
                // UIを更新
                if (icon) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                }
                if (favoriteIcon) {
                    favoriteIcon.textContent = '❤️';
                }
                if (bookmarkText) {
                    bookmarkText.textContent = 'お気に入り済み';
                }
                button.classList.remove('text-gray-400', 'text-gray-600');
                button.classList.add('text-blue-600', 'text-red-500', 'is-favorite');
                
                // アニメーション
                button.classList.add('animate-pulse');
                setTimeout(function() {
                    button.classList.remove('animate-pulse');
                }, 1000);
                
                showNotification('お気に入りに追加しました', 'success');
            }
            
            // ブックマークを保存
            localStorage.setItem(BOOKMARKS_KEY, JSON.stringify(bookmarks));
            
            // デバッグ情報
            if (typeof console !== 'undefined' && console.log) {
                var logTitle = lectureTitle || 'Unknown';
                var logId = lectureId || 'Unknown';
                var logAction = isBookmarked ? 'Removed' : 'Added';
                console.log('NFU Bookmark: ' + logAction + ' ' + logTitle + ' ID: ' + logId);
            }
        });
    
        // エピソード進捗ブックマーク機能
        var episodeBookmarkButtons = document.querySelectorAll('.bookmark-episode-button');
        episodeBookmarkButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var episodeId = this.dataset.episodeId;
                var episodeNumber = this.dataset.episodeNumber;
                var lectureId = this.dataset.lectureId;
                
                // 進捗情報を保存
                var progress = getProgress();
                progress[lectureId] = {
                    currentEpisode: episodeNumber,
                    episodeId: episodeId,
                    timestamp: Date.now()
                };
                
                localStorage.setItem(PROGRESS_KEY, JSON.stringify(progress));
                
                // UIフィードバック
                var originalHTML = this.innerHTML;
                var icon = this.querySelector('i');
                
                this.textContent = '設定完了！';
                if (icon) {
                    icon.classList.remove('fa-bookmark');
                    icon.classList.add('fa-check');
                }
                this.classList.remove('text-gray-600');
                this.classList.add('text-green-600');
                
                setTimeout(function() {
                    button.innerHTML = '<i class="fas fa-bookmark mr-2"></i>続きから再生に設定';
                    button.classList.remove('text-green-600');
                    button.classList.add('text-gray-600');
                }, 2000);
                
                showNotification('続きから再生に設定しました', 'success');
                
                if (typeof console !== 'undefined' && console.log) {
                    console.log('NFU Progress Set:', lectureId, 'Episode:', episodeNumber);
                }
            });
        });
        
        // シェア機能
        var shareButtons = document.querySelectorAll('.share-button');
        shareButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var url = this.dataset.url;
                var title = this.dataset.title;
                
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
        });
        
        // ページロード時にブックマーク状態を設定
        initializeBookmarkStates();
    }
    
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
        var modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        modal.id = 'share-modal';
        modal.innerHTML = '<div class="bg-white rounded-lg p-6 max-w-md mx-4">' +
            '<h3 class="text-lg font-bold mb-4">講座をシェア</h3>' +
            '<p class="text-sm text-gray-600 mb-4">以下のURLをコピーしてシェアしてください：</p>' +
            '<input type="text" value="' + url + '" class="w-full p-2 border border-gray-300 rounded mb-4" readonly id="share-url">' +
            '<div class="flex space-x-2">' +
                '<button class="flex-1 bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700" id="copy-url">コピー</button>' +
                '<button class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded hover:bg-gray-400" id="close-modal">閉じる</button>' +
            '</div>' +
        '</div>';
        
        document.body.appendChild(modal);
        
        // URLをコピー
        var copyButton = modal.querySelector('#copy-url');
        if (copyButton) {
            copyButton.addEventListener('click', function() {
                var urlInput = document.getElementById('share-url');
                if (urlInput) {
                    urlInput.select();
                    urlInput.setSelectionRange(0, 99999);
                    if (document.execCommand) {
                        document.execCommand('copy');
                    } else if (navigator.clipboard) {
                        navigator.clipboard.writeText(urlInput.value);
                    }
                    showNotification('URLをコピーしました', 'success');
                }
                modal.remove();
            });
        }
        
        // モーダルを閉じる
        var closeButton = modal.querySelector('#close-modal');
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                modal.remove();
            });
        }
        
        // 背景クリックで閉じる
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.remove();
            }
        });
        
        // URLを選択状態にする
        var urlInput = modal.querySelector('#share-url');
        if (urlInput) {
            urlInput.select();
        }
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
        
        var notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 ' + bgColor + ' text-white px-4 py-2 rounded-lg shadow-lg z-50 notification';
        notification.innerHTML = '<div class="flex items-center">' +
            '<i class="fas fa-paw mr-2"></i>' +
            '<span>' + message + '</span>' +
        '</div>';
        
        document.body.appendChild(notification);
        
        // アニメーション
        notification.style.opacity = '0';
        notification.style.transition = 'opacity 0.3s';
        setTimeout(function() {
            notification.style.opacity = '1';
        }, 10);
        
        setTimeout(function() {
            notification.style.opacity = '0';
            setTimeout(function() {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    // ページロード時にブックマーク状態を設定
    function initializeBookmarkStates() {
        var bookmarks = getBookmarks();
        
        var bookmarkButtons = document.querySelectorAll('.bookmark-button, .favorite-button');
        bookmarkButtons.forEach(function(button) {
            var lectureId = button.dataset.lectureId;
            if (!lectureId) {
                return;
            }
            
            var isBookmarked = bookmarks.some(function(bookmark) {
                return bookmark.id == lectureId;
            });
            
            if (isBookmarked) {
                var icon = button.querySelector('i');
                var favoriteIcon = button.querySelector('.favorite-icon');
                var text = button.querySelector('.bookmark-text');
                
                if (icon) {
                    icon.classList.remove('far');
                    icon.classList.add('fas');
                }
                if (favoriteIcon) {
                    favoriteIcon.textContent = '❤️';
                }
                if (text) {
                    text.textContent = 'お気に入り済み';
                }
                button.classList.remove('text-gray-400', 'text-gray-600');
                button.classList.add('text-blue-600', 'text-red-500', 'is-favorite');
            } else {
                var favoriteIcon = button.querySelector('.favorite-icon');
                if (favoriteIcon) {
                    favoriteIcon.textContent = '🤍';
                }
            }
        });
    }
    
    // ブックマーク一覧を表示する関数（他のページで使用可能）
    window.nfuShowBookmarks = function() {
        var bookmarks = getBookmarks();
        
        if (bookmarks.length === 0) {
            showNotification('お気に入りの講座がありません', 'info');
            return;
        }
        
        var modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
        modal.id = 'bookmarks-modal';
        modal.innerHTML = '<div class="bg-white rounded-lg p-6 max-w-lg mx-4 max-h-96 overflow-y-auto">' +
            '<h3 class="text-lg font-bold mb-4">お気に入りの講座</h3>' +
            '<div id="bookmarks-list"></div>' +
            '<button class="w-full bg-gray-300 text-gray-700 py-2 px-4 rounded hover:bg-gray-400 mt-4" id="close-bookmarks">閉じる</button>' +
        '</div>';
        
        var bookmarksList = modal.querySelector('#bookmarks-list');
        
        bookmarks.forEach(function(bookmark) {
            var item = document.createElement('div');
            item.className = 'flex items-center justify-between p-2 border-b border-gray-200';
            item.innerHTML = '<div class="flex-1">' +
                '<a href="' + bookmark.url + '" class="text-blue-600 hover:underline">' + bookmark.title + '</a>' +
                '<div class="text-xs text-gray-500">追加日: ' + new Date(bookmark.timestamp).toLocaleDateString() + '</div>' +
            '</div>' +
            '<button class="text-red-500 hover:text-red-700 ml-2" data-bookmark-id="' + bookmark.id + '">' +
                '<i class="fas fa-trash text-sm"></i>' +
            '</button>';
            
            bookmarksList.appendChild(item);
        });
        
        document.body.appendChild(modal);
        
        // ブックマーク削除
        modal.addEventListener('click', function(e) {
            var deleteButton = e.target.closest('[data-bookmark-id]');
            if (deleteButton) {
                var bookmarkId = deleteButton.dataset.bookmarkId;
                var updatedBookmarks = bookmarks.filter(function(bookmark) {
                    return bookmark.id != bookmarkId;
                });
                
                localStorage.setItem(BOOKMARKS_KEY, JSON.stringify(updatedBookmarks));
                deleteButton.closest('.flex').remove();
                
                if (updatedBookmarks.length === 0) {
                    modal.remove();
                    showNotification('すべてのお気に入りを削除しました', 'info');
                } else {
                    showNotification('お気に入りから削除しました', 'info');
                }
            }
        });
        
        // モーダルを閉じる
        var closeButton = modal.querySelector('#close-bookmarks');
        if (closeButton) {
            closeButton.addEventListener('click', function() {
                modal.remove();
            });
        }
    };
})();
