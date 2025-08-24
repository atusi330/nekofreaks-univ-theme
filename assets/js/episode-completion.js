/**
 * エピソード完了機能
 */
jQuery(document).ready(function($) {
    
    // ローカルストレージキー
    var COMPLETION_KEY = 'nfu_episode_completion';
    var PROGRESS_KEY = 'nfu_lecture_progress';
    
    // エピソード完了ボタンのクリック処理
    $('.episode-complete-button').on('click', function() {
        var button = $(this);
        var episodeId = button.data('episode-id');
        var episodeNumber = button.data('episode-number');
        var lectureId = button.data('lecture-id');
        var totalEpisodes = button.data('total-episodes');
        
        // 既に完了済みかチェック
        var completions = getCompletedEpisodes();
        if (completions[episodeId]) {
            showNotification('このエピソードは既に完了済みです', 'info');
            return;
        }
        
        // エピソード完了を記録
        markEpisodeComplete(episodeId, episodeNumber, lectureId);
        
        // UIを更新
        updateCompletionUI(button, episodeId, true);
        
        // 講座全体の進捗を更新
        updateLectureProgress(lectureId, totalEpisodes);
        
        // 完了時のリワード表示
        showCompletionReward(episodeId);
        
        // 講座完了チェック
        checkLectureCompletion(lectureId, totalEpisodes);
        
        // 通知表示
        showNotification('エピソード完了！肉球スタンプを獲得しました 🐾', 'success');
        
        // デバッグ情報
        if (typeof console !== 'undefined' && console.log) {
            console.log('NFU Episode Completed:', {
                episodeId: episodeId,
                episodeNumber: episodeNumber,
                lectureId: lectureId,
                totalEpisodes: totalEpisodes
            });
        }
    });
    
    // エピソード完了を記録
    function markEpisodeComplete(episodeId, episodeNumber, lectureId) {
        var completions = getCompletedEpisodes();
        
        // エピソード完了を記録
        completions[episodeId] = {
            episodeNumber: episodeNumber,
            lectureId: lectureId,
            completedAt: Date.now(),
            timestamp: Date.now()
        };
        
        localStorage.setItem(COMPLETION_KEY, JSON.stringify(completions));
        
        // 講座進捗も更新（最新エピソードとして記録）
        var lectureProgress = getLectureProgress();
        if (!lectureProgress[lectureId] || lectureProgress[lectureId].currentEpisode < episodeNumber) {
            lectureProgress[lectureId] = {
                currentEpisode: episodeNumber,
                episodeId: episodeId,
                lastCompletedEpisode: episodeNumber,
                timestamp: Date.now()
            };
            localStorage.setItem(PROGRESS_KEY, JSON.stringify(lectureProgress));
        }
    }
    
    // 講座全体の進捗を更新
    function updateLectureProgress(lectureId, totalEpisodes) {
        var completions = getCompletedEpisodes();
        var completedCount = 0;
        
        // この講座で完了したエピソード数を計算
        Object.values(completions).forEach(function(completion) {
            if (completion.lectureId == lectureId) {
                completedCount++;
            }
        });
        
        var progressPercentage = Math.round((completedCount / totalEpisodes) * 100);
        
        // 進捗バーとテキストを更新
        $('#overall-progress-bar-' + lectureId).css('width', progressPercentage + '%');
        $('#overall-progress-text-' + lectureId).text(completedCount + '/' + totalEpisodes + ' (' + progressPercentage + '%)');
        
        return {
            completed: completedCount,
            total: totalEpisodes,
            percentage: progressPercentage
        };
    }
    
    // 完了UIの更新
    function updateCompletionUI(button, episodeId, isCompleted) {
        if (isCompleted) {
            button.removeClass('bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700')
                  .addClass('bg-gradient-to-r from-green-500 to-teal-500 cursor-not-allowed')
                  .prop('disabled', true)
                  .html('<i class="fas fa-check-double mr-2"></i>完了済み');
            
            // 完了ステータスを表示
            $('#completion-status-' + episodeId).html(
                '<div class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">' +
                '<i class="fas fa-check-circle mr-2"></i>' +
                '学習完了' +
                '</div>'
            );
        }
    }
    
    // 完了リワードの表示
    function showCompletionReward(episodeId) {
        var rewardElement = $('#rewards-' + episodeId);
        rewardElement.removeClass('hidden').addClass('animate-pulse');
        
        setTimeout(function() {
            rewardElement.removeClass('animate-pulse');
        }, 1500);
    }
    
    // 講座完了チェック
    function checkLectureCompletion(lectureId, totalEpisodes) {
        var completions = getCompletedEpisodes();
        var completedCount = 0;
        
        Object.values(completions).forEach(function(completion) {
            if (completion.lectureId == lectureId) {
                completedCount++;
            }
        });
        
        if (completedCount >= totalEpisodes) {
            // 講座完了！
            setTimeout(function() {
                showLectureCompletionModal(lectureId, totalEpisodes);
            }, 2000);
            
            // 講座完了を記録
            markLectureComplete(lectureId);
        }
    }
    
    // 講座完了モーダル表示
    function showLectureCompletionModal(lectureId, totalEpisodes) {
        var modal = $('<div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" id="lecture-completion-modal">' +
            '<div class="bg-white rounded-lg p-8 max-w-md mx-4 text-center animate-bounce">' +
                '<div class="text-6xl mb-4">🎉</div>' +
                '<h2 class="text-2xl font-bold text-purple-600 mb-4">講座完了おめでとうございます！</h2>' +
                '<p class="text-gray-600 mb-6">全' + totalEpisodes + '回のエピソードを完了しました。<br>素晴らしい学習成果です！</p>' +
                '<div class="flex items-center justify-center mb-6">' +
                    '<i class="fas fa-certificate text-4xl text-yellow-500 mr-2"></i>' +
                    '<span class="text-lg font-bold text-yellow-600">修了証を獲得！</span>' +
                '</div>' +
                '<div class="space-y-3">' +
                    '<button class="w-full bg-purple-600 text-white py-2 px-4 rounded hover:bg-purple-700 transition-colors" id="view-certificate">' +
                        '<i class="fas fa-certificate mr-2"></i>修了証を見る' +
                    '</button>' +
                    '<button class="w-full bg-gray-300 text-gray-700 py-2 px-4 rounded hover:bg-gray-400 transition-colors" id="close-completion-modal">' +
                        '閉じる' +
                    '</button>' +
                '</div>' +
            '</div>' +
        '</div>');
        
        $('body').append(modal);
        
        // イベントハンドラ
        modal.find('#view-certificate').on('click', function() {
            // 修了証ページへリダイレクト（実装予定）
            window.location.href = '/certificate/?lecture_id=' + lectureId;
        });
        
        modal.find('#close-completion-modal').on('click', function() {
            modal.remove();
        });
        
        // 背景クリックで閉じる
        modal.on('click', function(e) {
            if (e.target === this) {
                modal.remove();
            }
        });
    }
    
    // 講座完了を記録
    function markLectureComplete(lectureId) {
        var lectureCompletions = JSON.parse(localStorage.getItem('nfu_lecture_completions') || '{}');
        
        if (!lectureCompletions[lectureId]) {
            lectureCompletions[lectureId] = {
                completedAt: Date.now(),
                timestamp: Date.now()
            };
            
            localStorage.setItem('nfu_lecture_completions', JSON.stringify(lectureCompletions));
        }
    }
    
    // 完了済みエピソードを取得
    function getCompletedEpisodes() {
        var completions = localStorage.getItem(COMPLETION_KEY);
        return completions ? JSON.parse(completions) : {};
    }
    
    // 講座進捗を取得
    function getLectureProgress() {
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
        
        setTimeout(function() {
            notification.fadeOut(function() {
                notification.remove();
            });
        }, 3000);
    }
    
    // ページロード時の初期化
    function initializeCompletionStatus() {
        var completions = getCompletedEpisodes();
        
        $('.episode-complete-button').each(function() {
            var button = $(this);
            var episodeId = button.data('episode-id');
            var lectureId = button.data('lecture-id');
            var totalEpisodes = button.data('total-episodes');
            
            // 完了済みかチェック
            if (completions[episodeId]) {
                updateCompletionUI(button, episodeId, true);
            }
            
            // 講座進捗を更新
            updateLectureProgress(lectureId, totalEpisodes);
        });
    }
    
    // 初期化実行
    initializeCompletionStatus();
    
    // 講座カードの進捗も更新
    updateLectureCardsProgress();
    
    // 講座カードの進捗を更新する関数
    function updateLectureCardsProgress() {
        var completions = getCompletedEpisodes();
        
        $('.progress-section').each(function() {
            var section = $(this);
            var lectureId = section.data('lecture-id');
            
            if (lectureId) {
                var completedCount = 0;
                var totalEpisodes = 5; // デフォルト値
                
                // この講座で完了したエピソード数を計算
                Object.values(completions).forEach(function(completion) {
                    if (completion.lectureId == lectureId) {
                        completedCount++;
                    }
                });
                
                var progressPercentage = Math.round((completedCount / totalEpisodes) * 100);
                
                // 進捗バーとテキストを更新
                section.find('[data-progress-bar="' + lectureId + '"]').css('width', progressPercentage + '%');
                section.find('[data-progress-text="' + lectureId + '"]').text('進捗: ' + completedCount + '/' + totalEpisodes + '回');
                section.find('[data-completion-text="' + lectureId + '"]').text(progressPercentage + '%完了');
                
                // 100%完了の場合は完了バッジを表示
                if (progressPercentage >= 100) {
                    section.find('[data-completion-badge="' + lectureId + '"]').removeClass('hidden');
                }
            }
        });
    }
    
    // 他のページで使用可能なグローバル関数
    window.nfuGetCompletionStats = function(lectureId) {
        var completions = getCompletedEpisodes();
        var completedCount = 0;
        
        Object.values(completions).forEach(function(completion) {
            if (completion.lectureId == lectureId) {
                completedCount++;
            }
        });
        
        return {
            completed: completedCount,
            total: $('.episode-complete-button[data-lecture-id="' + lectureId + '"]').length || 5,
            percentage: Math.round((completedCount / 5) * 100)
        };
    };
});