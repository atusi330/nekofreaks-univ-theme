/**
 * 講座フィルター用JavaScript
 */
(function() {
    'use strict';
    
    var filterForm = null;
    var lectureGrid = null;
    var loadingOverlay = null;
    var selectedProfessor = 'maron'; // 講師の状態を管理する変数
    
    // DOMContentLoadedイベントで初期化
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
    function init() {
        filterForm = document.getElementById('lecture-filter-form');
        lectureGrid = document.getElementById('lecture-grid');
        loadingOverlay = document.getElementById('loading-overlay');
        
        if (!filterForm || !lectureGrid) {
            return;
        }
        
        // フィルター変更時の処理
        filterForm.addEventListener('change', function(e) {
            if (e.target.matches('select, input[type="checkbox"]')) {
                filterLectures();
            }
        });
        
        // フィルターリセット
        var resetButton = document.getElementById('reset-filters');
        if (resetButton) {
            resetButton.addEventListener('click', function(e) {
                e.preventDefault();
                filterForm.reset();
                
                // 講師をマロン学長にリセット
                selectedProfessor = 'maron';
                
                // ボタンの状態をリセット
                var professorButtons = document.querySelectorAll('.professor-filter-button');
                professorButtons.forEach(function(btn) {
                    btn.classList.remove('active');
                });
                var maronButton = document.querySelector('.professor-filter-button[data-professor="maron"]');
                if (maronButton) {
                    maronButton.classList.add('active');
                }
                
                filterLectures();
            });
        }
        
        // 講師フィルターのビジュアル切り替え
        var professorButtons = document.querySelectorAll('.professor-filter-button');
        professorButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var professor = this.dataset.professor;
                
                // デバッグ情報
                if (typeof console !== 'undefined' && console.log) {
                    console.log('NFU Professor Button Click:', professor);
                }
                
                // ボタンのビジュアル更新
                if (this.classList.contains('active')) {
                    // アクティブなボタンをクリックした場合
                    if (professor === 'maron') {
                        // マロン学長の場合は、そのままアクティブ状態を維持（全て表示）
                        return;
                    } else {
                        // 他の講師の場合は、マロン学長に戻す
                        professorButtons.forEach(function(btn) {
                            btn.classList.remove('active');
                        });
                        var maronButton = document.querySelector('.professor-filter-button[data-professor="maron"]');
                        if (maronButton) {
                            maronButton.classList.add('active');
                        }
                        selectedProfessor = 'maron';
                    }
                } else {
                    // 非アクティブなボタンをクリックした場合
                    professorButtons.forEach(function(btn) {
                        btn.classList.remove('active');
                    });
                    this.classList.add('active');
                    selectedProfessor = professor;
                }
                
                // フィルター実行
                filterLectures();
            });
        });
        
        // ソート機能
        var sortSelect = document.getElementById('sort-lectures');
        if (sortSelect) {
            sortSelect.addEventListener('change', function() {
                var sortBy = this.value;
                var cards = Array.from(lectureGrid.querySelectorAll('.lecture-card'));
                
                cards.sort(function(a, b) {
                    var aValue, bValue;
                    
                    switch(sortBy) {
                        case 'date':
                            aValue = parseInt(a.dataset.date) || 0;
                            bValue = parseInt(b.dataset.date) || 0;
                            return bValue - aValue;
                        case 'title':
                            var aTitle = a.querySelector('.card-title');
                            var bTitle = b.querySelector('.card-title');
                            aValue = aTitle ? aTitle.textContent.trim() : '';
                            bValue = bTitle ? bTitle.textContent.trim() : '';
                            return aValue.localeCompare(bValue);
                        case 'progress':
                            var aProgress = a.querySelector('.progress-fill');
                            var bProgress = b.querySelector('.progress-fill');
                            if (aProgress && bProgress) {
                                var aWidth = window.getComputedStyle(aProgress).width;
                                var bWidth = window.getComputedStyle(bProgress).width;
                                aValue = parseInt(aWidth) || 0;
                                bValue = parseInt(bWidth) || 0;
                            } else {
                                aValue = 0;
                                bValue = 0;
                            }
                            return bValue - aValue;
                        default:
                            return 0;
                    }
                });
                
                // フェードアウト
                lectureGrid.style.opacity = '0';
                setTimeout(function() {
                    // カードを再配置
                    cards.forEach(function(card) {
                        lectureGrid.appendChild(card);
                    });
                    // フェードイン
                    lectureGrid.style.opacity = '1';
                }, 200);
            });
        }
        
        // カードホバーエフェクト
        lectureGrid.addEventListener('mouseenter', function(e) {
            var card = e.target.closest('.lecture-card');
            if (card) {
                var img = card.querySelector('.card-thumbnail img');
                if (img) {
                    img.style.transform = 'scale(1.05)';
                }
            }
        }, true);
        
        lectureGrid.addEventListener('mouseleave', function(e) {
            var card = e.target.closest('.lecture-card');
            if (card) {
                var img = card.querySelector('.card-thumbnail img');
                if (img) {
                    img.style.transform = 'scale(1)';
                }
            }
        }, true);
        
        // URLパラメータから初期フィルターを設定
        setInitialFilters();
    }
    
    // 講座をフィルタリング
    function filterLectures() {
        if (!filterForm || !window.nfu_ajax) {
            return;
        }
        
        var formData = new FormData(filterForm);
        
        // 講師パラメータを追加
        formData.append('professor', selectedProfessor);
        formData.append('action', 'filter_lectures');
        formData.append('nonce', window.nfu_ajax.nonce);
        
        // デバッグ情報
        if (typeof console !== 'undefined' && console.log) {
            console.log('NFU Filter Request: professor=' + selectedProfessor);
        }
        
        // ローディング表示
        showLoading();
        
        fetch(window.nfu_ajax.ajax_url, {
            method: 'POST',
            body: formData
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (typeof console !== 'undefined' && console.log) {
                console.log('NFU Filter Response:', data);
            }
            
            if (data.success) {
                // フェードアウト
                lectureGrid.style.opacity = '0';
                setTimeout(function() {
                    // コンテンツ更新
                    lectureGrid.innerHTML = data.data.html;
                    
                    // フェードイン
                    lectureGrid.style.opacity = '1';
                    
                    // 結果数を更新
                    updateResultCount(data.data.found_posts);
                }, 200);
            } else {
                console.error('NFU Filter Error:', data);
            }
        })
        .catch(function(error) {
            console.error('NFU Filter AJAX Error:', error);
        })
        .finally(function() {
            hideLoading();
        });
    }
    
    // ローディング表示
    function showLoading() {
        if (!loadingOverlay) {
            loadingOverlay = document.createElement('div');
            loadingOverlay.id = 'loading-overlay';
            loadingOverlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
            loadingOverlay.innerHTML = '<div class="bg-white rounded-lg p-8 flex flex-col items-center">' +
                '<div class="loading-paw text-6xl mb-4">🐾</div>' +
                '<p class="text-gray-600">読み込み中...</p>' +
                '</div>';
            document.body.appendChild(loadingOverlay);
        }
        loadingOverlay.style.display = 'flex';
        loadingOverlay.style.opacity = '0';
        setTimeout(function() {
            loadingOverlay.style.opacity = '1';
        }, 10);
    }
    
    // ローディング非表示
    function hideLoading() {
        if (loadingOverlay) {
            loadingOverlay.style.opacity = '0';
            setTimeout(function() {
                loadingOverlay.style.display = 'none';
            }, 200);
        }
    }
    
    // 結果数を更新
    function updateResultCount(count) {
        var resultText = count + '件の講座が見つかりました';
        if (count === 0) {
            resultText = '該当する講座が見つかりませんでした';
        }
        
        var resultCount = document.getElementById('result-count');
        if (!resultCount) {
            resultCount = document.createElement('div');
            resultCount.id = 'result-count';
            resultCount.className = 'text-gray-600 mb-4';
            if (lectureGrid && lectureGrid.parentNode) {
                lectureGrid.parentNode.insertBefore(resultCount, lectureGrid);
            }
        }
        
        resultCount.textContent = resultText;
    }
    
    // URLパラメータから初期フィルターを設定
    function setInitialFilters() {
        var urlParams = new URLSearchParams(window.location.search);
        
        if (urlParams.has('professor')) {
            selectedProfessor = urlParams.get('professor');
        }
        if (urlParams.has('theme') && filterForm) {
            var themeSelect = filterForm.querySelector('#filter-theme');
            if (themeSelect) {
                themeSelect.value = urlParams.get('theme');
            }
        }
        if (urlParams.has('difficulty') && filterForm) {
            var difficultySelect = filterForm.querySelector('#filter-difficulty');
            if (difficultySelect) {
                difficultySelect.value = urlParams.get('difficulty');
            }
        }
        
        // 講師ボタンの初期状態を設定
        var professorButtons = document.querySelectorAll('.professor-filter-button');
        professorButtons.forEach(function(btn) {
            btn.classList.remove('active');
        });
        var selectedButton = document.querySelector('.professor-filter-button[data-professor="' + selectedProfessor + '"]');
        if (selectedButton) {
            selectedButton.classList.add('active');
        }
        
        // フィルターを実行
        filterLectures();
    }
})();
