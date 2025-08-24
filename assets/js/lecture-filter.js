/**
 * 講座フィルター用JavaScript
 */
jQuery(document).ready(function($) {
    
    var filterForm = $('#lecture-filter-form');
    var lectureGrid = $('#lecture-grid');
    var loadingOverlay = $('#loading-overlay');
    var selectedProfessor = 'maron'; // 講師の状態を管理する変数
    
    // フィルター変更時の処理
    filterForm.on('change', 'select, input[type="checkbox"]', function() {
        filterLectures();
    });
    
    // フィルターリセット
    $('#reset-filters').on('click', function(e) {
        e.preventDefault();
        filterForm[0].reset();
        
        // 講師をマロン学長にリセット
        selectedProfessor = 'maron';
        
        // ボタンの状態をリセット
        $('.professor-filter-button').removeClass('active');
        $('.professor-filter-button[data-professor="maron"]').addClass('active');
        
        filterLectures();
    });
    
    // 講座をフィルタリング
    function filterLectures() {
        var formData = filterForm.serialize();
        
        // 講師パラメータを追加
        formData += '&professor=' + encodeURIComponent(selectedProfessor);
        
        // デバッグ情報
        if (typeof console !== 'undefined' && console.log) {
            console.log('NFU Filter Request:', formData);
        }
        
        // ローディング表示
        showLoading();
        
        $.ajax({
            url: nfu_ajax.ajax_url,
            type: 'POST',
            data: formData + '&action=filter_lectures&nonce=' + nfu_ajax.nonce,
            success: function(response) {
                if (typeof console !== 'undefined' && console.log) {
                    console.log('NFU Filter Response:', response);
                }
                
                if (response.success) {
                    // フェードアウト
                    lectureGrid.fadeOut(200, function() {
                        // コンテンツ更新
                        lectureGrid.html(response.data.html);
                        
                        // フェードイン
                        lectureGrid.fadeIn(400);
                        
                        // 結果数を更新
                        updateResultCount(response.data.found_posts);
                    });
                } else {
                    console.error('NFU Filter Error:', response);
                }
            },
            error: function(xhr, status, error) {
                console.error('NFU Filter AJAX Error:', error);
                console.error('Status:', status);
                console.error('Response:', xhr.responseText);
            },
            complete: function() {
                hideLoading();
            }
        });
    }
    
    // ローディング表示
    function showLoading() {
        if (!loadingOverlay.length) {
            loadingOverlay = $('<div/>', {
                'id': 'loading-overlay',
                'class': 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50',
                'html': '<div class="bg-white rounded-lg p-8 flex flex-col items-center">' +
                        '<div class="loading-paw text-6xl mb-4">🐾</div>' +
                        '<p class="text-gray-600">読み込み中...</p>' +
                        '</div>'
            }).appendTo('body');
        }
        loadingOverlay.fadeIn(200);
    }
    
    // ローディング非表示
    function hideLoading() {
        if (loadingOverlay.length) {
            loadingOverlay.fadeOut(200);
        }
    }
    
    // 結果数を更新
    function updateResultCount(count) {
        var resultText = count + '件の講座が見つかりました';
        if (count === 0) {
            resultText = '該当する講座が見つかりませんでした';
        }
        
        var resultCount = $('#result-count');
        if (!resultCount.length) {
            resultCount = $('<div/>', {
                'id': 'result-count',
                'class': 'text-gray-600 mb-4'
            }).insertBefore(lectureGrid);
        }
        
        resultCount.text(resultText);
    }
    
    // 講師フィルターのビジュアル切り替え
    $('.professor-filter-button').on('click', function() {
        var button = $(this);
        var professor = button.data('professor');
        
        // デバッグ情報
        if (typeof console !== 'undefined' && console.log) {
            console.log('NFU Professor Button Click:', professor);
        }
        
        // ボタンのビジュアル更新
        if (button.hasClass('active')) {
            // アクティブなボタンをクリックした場合
            if (professor === 'maron') {
                // マロン学長の場合は、そのままアクティブ状態を維持（全て表示）
                return;
            } else {
                // 他の講師の場合は、マロン学長に戻す
                $('.professor-filter-button').removeClass('active');
                $('.professor-filter-button[data-professor="maron"]').addClass('active');
                selectedProfessor = 'maron';
            }
        } else {
            // 非アクティブなボタンをクリックした場合
            $('.professor-filter-button').removeClass('active');
            button.addClass('active');
            selectedProfessor = professor;
        }
        
        // フィルター実行
        filterLectures();
    });
    
    // ソート機能
    $('#sort-lectures').on('change', function() {
        var sortBy = $(this).val();
        var cards = lectureGrid.find('.lecture-card').get();
        
        cards.sort(function(a, b) {
            var aValue, bValue;
            
            switch(sortBy) {
                case 'date':
                    aValue = $(a).data('date');
                    bValue = $(b).data('date');
                    return bValue - aValue;
                case 'title':
                    aValue = $(a).find('.card-title').text();
                    bValue = $(b).find('.card-title').text();
                    return aValue.localeCompare(bValue);
                case 'progress':
                    aValue = parseInt($(a).find('.progress-fill').css('width'));
                    bValue = parseInt($(b).find('.progress-fill').css('width'));
                    return bValue - aValue;
                default:
                    return 0;
            }
        });
        
        lectureGrid.fadeOut(200, function() {
            $.each(cards, function(idx, card) {
                lectureGrid.append(card);
            });
            lectureGrid.fadeIn(400);
        });
    });
    
    // カードホバーエフェクト
    lectureGrid.on('mouseenter', '.lecture-card', function() {
        $(this).find('.card-thumbnail img').css('transform', 'scale(1.05)');
    }).on('mouseleave', '.lecture-card', function() {
        $(this).find('.card-thumbnail img').css('transform', 'scale(1)');
    });
    
    // URLパラメータから初期フィルターを設定
    function setInitialFilters() {
        var urlParams = new URLSearchParams(window.location.search);
        
        if (urlParams.has('professor')) {
            selectedProfessor = urlParams.get('professor');
        }
        if (urlParams.has('theme')) {
            $('#filter-theme').val(urlParams.get('theme'));
        }
        if (urlParams.has('difficulty')) {
            $('#filter-difficulty').val(urlParams.get('difficulty'));
        }
        
        // 講師ボタンの初期状態を設定
        $('.professor-filter-button').removeClass('active');
        $('.professor-filter-button[data-professor="' + selectedProfessor + '"]').addClass('active');
        
        // フィルターを実行
        filterLectures();
    }
    
    setInitialFilters();
});