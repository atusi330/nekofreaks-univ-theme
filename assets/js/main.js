/**
 * メインJavaScriptファイル
 */
(function() {
    'use strict';
    
    // DOMContentLoadedイベントで初期化
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
    function init() {
        // モバイルメニュートグル
        var menuToggle = document.querySelector('.menu-toggle');
        if (menuToggle) {
            menuToggle.addEventListener('click', function(e) {
                e.preventDefault();
                var menuContainer = document.querySelector('.mobile-menu');
                var isExpanded = this.getAttribute('aria-expanded') === 'true';
                
                console.log('Menu toggle clicked, isExpanded:', isExpanded);
                
                if (isExpanded) {
                    menuContainer.classList.add('hidden');
                    this.setAttribute('aria-expanded', 'false');
                    console.log('Menu hidden');
                } else {
                    menuContainer.classList.remove('hidden');
                    this.setAttribute('aria-expanded', 'true');
                    console.log('Menu shown');
                }
            });
        }
        
        // モバイルメニューの外側をクリックした時に閉じる
        document.addEventListener('click', function(e) {
            var siteNavigation = document.querySelector('#site-navigation');
            if (siteNavigation && !siteNavigation.contains(e.target)) {
                var mobileMenu = document.querySelector('.mobile-menu');
                var menuToggle = document.querySelector('.menu-toggle');
                if (mobileMenu) {
                    mobileMenu.classList.add('hidden');
                }
                if (menuToggle) {
                    menuToggle.setAttribute('aria-expanded', 'false');
                }
            }
        });
        
        // スムーススクロール
        var anchorLinks = document.querySelectorAll('a[href^="#"]');
        anchorLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                var href = this.getAttribute('href');
                if (href === '#') return;
                
                var target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    var targetPosition = target.getBoundingClientRect().top + window.pageYOffset - 100;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // 講座のお気に入り機能（bookmark-share.jsで処理されるため、ここでは無効化）
        // 注意: .favorite-button の処理は bookmark-share.js で行われる
        
        // 講座進捗の更新
        var markCompleteButtons = document.querySelectorAll('.mark-as-complete');
        markCompleteButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var lectureId = this.dataset.lectureId;
                var episodeNumber = this.dataset.episodeNumber;
                
                if (!window.nfu_ajax) {
                    console.error('nfu_ajax is not defined');
                    return;
                }
                
                var formData = new FormData();
                formData.append('action', 'update_lecture_progress');
                formData.append('lecture_id', lectureId);
                formData.append('episode_number', episodeNumber);
                formData.append('nonce', window.nfu_ajax.nonce);
                
                fetch(window.nfu_ajax.ajax_url, {
                    method: 'POST',
                    body: formData
                })
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    if (data.success) {
                        button.textContent = '✅ 受講完了';
                        button.disabled = true;
                        
                        // 次回予告を表示
                        loadNextEpisode(lectureId, episodeNumber);
                    }
                })
                .catch(function(error) {
                    console.error('Error:', error);
                });
            });
        });
        
        // 次回予告の読み込み
        function loadNextEpisode(lectureId, currentEpisode) {
            if (!window.nfu_ajax) {
                console.error('nfu_ajax is not defined');
                return;
            }
            
            var formData = new FormData();
            formData.append('action', 'get_next_episode');
            formData.append('lecture_id', lectureId);
            formData.append('current_episode', currentEpisode);
            formData.append('nonce', window.nfu_ajax.nonce);
            
            fetch(window.nfu_ajax.ajax_url, {
                method: 'POST',
                body: formData
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if (data.success && data.data.found) {
                    var nextEpisode = data.data;
                    var html = '<div class="next-episode-preview bg-yellow-50 border-l-4 border-yellow-400 p-4 mt-6">';
                    html += '<h4 class="font-bold text-lg mb-2">🎯 次回予告</h4>';
                    html += '<p class="font-semibold">' + nextEpisode.title + '</p>';
                    html += '<p class="text-sm text-gray-600 mt-2">' + nextEpisode.excerpt + '</p>';
                    if (nextEpisode.status === 'publish') {
                        html += '<a href="' + nextEpisode.url + '" class="inline-block mt-3 text-blue-600 hover:underline">次の講座へ進む →</a>';
                    } else {
                        html += '<p class="text-sm text-gray-500 mt-3">配信予定日: ' + nextEpisode.date + '</p>';
                    }
                    html += '</div>';
                    
                    var episodeContent = document.querySelector('.episode-content');
                    if (episodeContent) {
                        episodeContent.insertAdjacentHTML('beforeend', html);
                    }
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
            });
        }
        
        // タブ切り替え
        var tabButtons = document.querySelectorAll('.tab-button');
        tabButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var tabId = this.dataset.tab;
                
                // すべてのタブボタンのクラスをリセット
                tabButtons.forEach(function(btn) {
                    btn.classList.remove('active', 'bg-blue-600', 'text-white');
                    btn.classList.add('bg-gray-200', 'text-gray-700');
                });
                
                // クリックされたボタンをアクティブに
                this.classList.remove('bg-gray-200', 'text-gray-700');
                this.classList.add('active', 'bg-blue-600', 'text-white');
                
                // すべてのタブコンテンツを非表示
                var tabContents = document.querySelectorAll('.tab-content');
                tabContents.forEach(function(content) {
                    content.classList.add('hidden');
                });
                
                // 選択されたタブコンテンツを表示
                var selectedTab = document.getElementById(tabId);
                if (selectedTab) {
                    selectedTab.classList.remove('hidden');
                }
            });
        });
        
        // 肉球アニメーション
        function animatePaw() {
            var paws = document.querySelectorAll('.loading-paw');
            paws.forEach(function(paw) {
                setInterval(function() {
                    paw.classList.toggle('bounce');
                }, 600);
            });
        }
        
        animatePaw();
        
        // スクロールトップボタン
        var scrollTopButton = document.createElement('button');
        scrollTopButton.className = 'scroll-top-button fixed bottom-8 right-8 bg-blue-600 text-white p-3 rounded-full shadow-lg hidden hover:bg-blue-700 transition-colors';
        scrollTopButton.innerHTML = '↑';
        scrollTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        document.body.appendChild(scrollTopButton);
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollTopButton.classList.remove('hidden');
            } else {
                scrollTopButton.classList.add('hidden');
            }
        });
    }
})();
