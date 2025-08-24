/**
 * メインJavaScriptファイル
 */
jQuery(document).ready(function($) {
    
    // モバイルメニュートグル
    $('.menu-toggle').on('click', function(e) {
        e.preventDefault();
        var menuContainer = $('.mobile-menu');
        var isExpanded = $(this).attr('aria-expanded') === 'true';
        
        console.log('Menu toggle clicked, isExpanded:', isExpanded);
        
        if (isExpanded) {
            menuContainer.addClass('hidden');
            $(this).attr('aria-expanded', 'false');
            console.log('Menu hidden');
        } else {
            menuContainer.removeClass('hidden');
            $(this).attr('aria-expanded', 'true');
            console.log('Menu shown');
        }
    });
    
    // モバイルメニューの外側をクリックした時に閉じる
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#site-navigation').length) {
            $('.mobile-menu').addClass('hidden');
            $('.menu-toggle').attr('aria-expanded', 'false');
        }
    });
    
    // スムーススクロール
    $('a[href^="#"]').on('click', function(e) {
        var target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 800);
        }
    });
    
    // 講座のお気に入り機能
    $('.favorite-button').on('click', function(e) {
        e.preventDefault();
        var button = $(this);
        var lectureId = button.data('lecture-id');
        
        $.ajax({
            url: nfu_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'toggle_favorite_lecture',
                lecture_id: lectureId,
                nonce: nfu_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    if (response.data.action === 'added') {
                        button.addClass('is-favorite');
                        button.find('.favorite-icon').text('❤️');
                    } else {
                        button.removeClass('is-favorite');
                        button.find('.favorite-icon').text('🤍');
                    }
                }
            }
        });
    });
    
    // 講座進捗の更新
    $('.mark-as-complete').on('click', function() {
        var button = $(this);
        var lectureId = button.data('lecture-id');
        var episodeNumber = button.data('episode-number');
        
        $.ajax({
            url: nfu_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'update_lecture_progress',
                lecture_id: lectureId,
                episode_number: episodeNumber,
                nonce: nfu_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    button.text('✅ 受講完了');
                    button.prop('disabled', true);
                    
                    // 次回予告を表示
                    loadNextEpisode(lectureId, episodeNumber);
                }
            }
        });
    });
    
    // 次回予告の読み込み
    function loadNextEpisode(lectureId, currentEpisode) {
        $.ajax({
            url: nfu_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'get_next_episode',
                lecture_id: lectureId,
                current_episode: currentEpisode,
                nonce: nfu_ajax.nonce
            },
            success: function(response) {
                if (response.success && response.data.found) {
                    var nextEpisode = response.data;
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
                    
                    $('.episode-content').append(html);
                }
            }
        });
    }
    
    // タブ切り替え
    $('.tab-button').on('click', function() {
        var tabId = $(this).data('tab');
        
        $('.tab-button').removeClass('active bg-blue-600 text-white').addClass('bg-gray-200 text-gray-700');
        $(this).removeClass('bg-gray-200 text-gray-700').addClass('active bg-blue-600 text-white');
        
        $('.tab-content').addClass('hidden');
        $('#' + tabId).removeClass('hidden');
    });
    
    // 肉球アニメーション
    function animatePaw() {
        $('.loading-paw').each(function() {
            var paw = $(this);
            setInterval(function() {
                paw.toggleClass('bounce');
            }, 600);
        });
    }
    
    animatePaw();
    
    // スクロールトップボタン
    var scrollTopButton = $('<button/>', {
        'class': 'scroll-top-button fixed bottom-8 right-8 bg-blue-600 text-white p-3 rounded-full shadow-lg hidden hover:bg-blue-700 transition-colors',
        'html': '↑',
        'click': function() {
            $('html, body').animate({ scrollTop: 0 }, 600);
        }
    }).appendTo('body');
    
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 300) {
            scrollTopButton.fadeIn();
        } else {
            scrollTopButton.fadeOut();
        }
    });
    
    // 画像の遅延読み込み
    if ('IntersectionObserver' in window) {
        var lazyImages = document.querySelectorAll('img[data-lazy-src]');
        var imageObserver = new IntersectionObserver(function(entries, observer) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var img = entry.target;
                    img.src = img.dataset.lazySrc;
                    img.removeAttribute('data-lazy-src');
                    imageObserver.unobserve(img);
                }
            });
        });
        
        lazyImages.forEach(function(img) {
            imageObserver.observe(img);
        });
    }
});