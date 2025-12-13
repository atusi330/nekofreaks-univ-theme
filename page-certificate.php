<?php
/**
 * Template Name: 修了証
 * 
 * 修了証ページテンプレート
 * 
 * @package NekoFreaksUniv
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="page-header bg-gradient-to-r from-yellow-400 via-orange-500 to-pink-500 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">
                    <i class="fas fa-certificate text-yellow-200 mr-3"></i>
                    修了証
                </h1>
                <p class="text-lg text-white/90">あなたの学習成果を証明します</p>
            </div>
        </div>
    </div>
    
    <div class="container mx-auto px-4 py-8">
        <?php nfu_breadcrumb(); ?>
        
        <!-- 修了証コンテンツ -->
        <div id="certificate-container" class="max-w-4xl mx-auto">
            <!-- 読み込み中 -->
            <div id="certificate-loading" class="text-center py-12">
                <div class="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-purple-600 mb-4"></div>
                <p class="text-gray-600">修了証を読み込んでいます...</p>
            </div>
            
            <!-- 修了証 -->
            <div id="certificate-content" class="hidden">
                <div class="certificate bg-white rounded-lg shadow-2xl p-8 md:p-12 border-4 border-yellow-400">
                    <!-- ヘッダー -->
                    <div class="text-center mb-8">
                        <div class="text-6xl mb-4">🎓</div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">ネコフリークス大学</h2>
                        <p class="text-xl text-gray-600">NekoFreaks University</p>
                    </div>
                    
                    <!-- 称号 -->
                    <div class="text-center mb-8 pb-6 border-b-2 border-gray-300">
                        <div id="certificate-title" class="text-2xl md:text-3xl font-bold text-purple-600 mb-2">
                            <!-- JavaScriptで動的に設定 -->
                        </div>
                        <div id="certificate-subtitle" class="text-lg text-gray-600">
                            <!-- JavaScriptで動的に設定 -->
                        </div>
                    </div>
                    
                    <!-- 本文 -->
                    <div class="text-center mb-8">
                        <p class="text-lg text-gray-700 mb-4">
                            この修了証は、以下の講座を完了したことを証明します。
                        </p>
                        <div id="certificate-stats" class="flex justify-center gap-8 mb-6">
                            <div class="text-center">
                                <div id="completed-count" class="text-3xl font-bold text-blue-600">0</div>
                                <div class="text-sm text-gray-600">完了講座数</div>
                            </div>
                            <div class="text-center">
                                <div id="certificate-date" class="text-lg font-semibold text-gray-700">
                                    <!-- JavaScriptで動的に設定 -->
                                </div>
                                <div class="text-sm text-gray-600">発行日</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- 完了講座一覧 -->
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 text-center">
                            <i class="fas fa-list-check mr-2 text-purple-600"></i>
                            完了した講座
                        </h3>
                        <div id="completed-lectures-list" class="space-y-2 max-h-96 overflow-y-auto">
                            <!-- JavaScriptで動的に生成 -->
                        </div>
                    </div>
                    
                    <!-- フッター -->
                    <div class="text-center pt-6 border-t-2 border-gray-300">
                        <div class="flex justify-center items-center gap-4 mb-4">
                            <div class="text-4xl">🐾</div>
                            <div class="text-sm text-gray-600">
                                <p>ネコフリークス大学</p>
                                <p>NekoFreaks University</p>
                            </div>
                            <div class="text-4xl">🐾</div>
                        </div>
                        <p class="text-xs text-gray-500">
                            この修了証は、ブラウザのローカルストレージに保存された学習データに基づいて発行されています。
                        </p>
                    </div>
                </div>
                
                <!-- アクションボタン -->
                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <button id="print-certificate" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors inline-flex items-center">
                        <i class="fas fa-print mr-2"></i>印刷する
                    </button>
                    <button id="download-certificate" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-colors inline-flex items-center">
                        <i class="fas fa-download mr-2"></i>PDFとして保存
                    </button>
                    <a href="<?php echo home_url('/bookmarks/'); ?>" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors inline-flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>お気に入りページに戻る
                    </a>
                </div>
            </div>
            
            <!-- エラー状態 -->
            <div id="certificate-error" class="hidden text-center py-12">
                <div class="text-6xl text-gray-300 mb-4">😿</div>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">修了証を表示できません</h3>
                <p class="text-gray-500 mb-6">完了した講座が見つかりませんでした。</p>
                <a href="<?php echo home_url('/lectures/'); ?>" class="bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-colors inline-flex items-center">
                    <i class="fas fa-graduation-cap mr-2"></i>講座を探す
                </a>
            </div>
        </div>
    </div>
</main>

<!-- 修了証用のJavaScript -->
<script>
(function() {
    'use strict';
    
    // 称号マッピング
    var titleMap = {
        1: { title: '駆け出しの猫好き', subtitle: '🐱 最初の一歩を踏み出しました', color: 'text-gray-600' },
        2: { title: '駆け出しの猫好き', subtitle: '🐱 最初の一歩を踏み出しました', color: 'text-gray-600' },
        3: { title: '駆け出しの猫好き', subtitle: '🐱 最初の一歩を踏み出しました', color: 'text-gray-600' },
        4: { title: 'ネコフリークス大学受験者', subtitle: '📚 大学への道を歩んでいます', color: 'text-blue-600' },
        5: { title: 'ネコフリークス大学受験者', subtitle: '📚 大学への道を歩んでいます', color: 'text-blue-600' },
        6: { title: 'ネコフリークス大学受験者', subtitle: '📚 大学への道を歩んでいます', color: 'text-blue-600' },
        7: { title: 'ネコフリークス大学生', subtitle: '🎓 大学生として学びを深めています', color: 'text-purple-600' },
        8: { title: 'ネコフリークス大学生', subtitle: '🎓 大学生として学びを深めています', color: 'text-purple-600' },
        9: { title: 'ネコフリークス大学生', subtitle: '🎓 大学生として学びを深めています', color: 'text-purple-600' },
        10: { title: 'ネコフリークス大学生', subtitle: '🎓 大学生として学びを深めています', color: 'text-purple-600' },
        11: { title: 'ネコフリークス院生', subtitle: '🔬 より深い研究に取り組んでいます', color: 'text-indigo-600' },
        12: { title: 'ネコフリークス院生', subtitle: '🔬 より深い研究に取り組んでいます', color: 'text-indigo-600' },
        13: { title: 'ネコフリークス院生', subtitle: '🔬 より深い研究に取り組んでいます', color: 'text-indigo-600' },
        14: { title: 'ネコフリークス院生', subtitle: '🔬 より深い研究に取り組んでいます', color: 'text-indigo-600' },
        15: { title: 'ネコフリークス院生', subtitle: '🔬 より深い研究に取り組んでいます', color: 'text-indigo-600' },
        16: { title: 'ネコフリークス助教授', subtitle: '👔 教育者としての道を歩んでいます', color: 'text-yellow-600' },
        26: { title: 'ネコフリークス教授', subtitle: '👑 教授としての地位を確立しました', color: 'text-orange-600' },
        41: { title: 'ネコフリークス特別顧問', subtitle: '⭐ 特別な地位を獲得しました', color: 'text-pink-600' },
        101: { title: 'ネコフリークス次期学長', subtitle: '🌟 学長候補として認められました', color: 'text-red-600' }
    };
    
    // 称号を取得
    function getTitle(count) {
        if (count >= 101) {
            return titleMap[101];
        } else if (count >= 41) {
            return titleMap[41];
        } else if (count >= 26) {
            return titleMap[26];
        } else if (count >= 16) {
            return titleMap[16];
        } else if (count >= 11) {
            return titleMap[11];
        } else if (count >= 7) {
            return titleMap[7];
        } else if (count >= 4) {
            return titleMap[4];
        } else {
            return titleMap[1];
        }
    }
    
    // 完了したエピソードを取得
    function getEpisodeCompletions() {
        var completions = localStorage.getItem('nfu_episode_completion');
        return completions ? JSON.parse(completions) : {};
    }
    
    // 講座データを取得（AJAX）
    function getLectureData(lectureIds) {
        if (!lectureIds || lectureIds.length === 0) {
            return Promise.resolve({});
        }
        
        var formData = new FormData();
        formData.append('action', 'get_lecture_data');
        formData.append('lecture_ids', JSON.stringify(lectureIds));
        formData.append('nonce', '<?php echo wp_create_nonce('nfu_ajax_nonce'); ?>');
        
        return fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            body: formData
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (typeof console !== 'undefined' && console.log) {
                console.log('Certificate: getLectureData response:', data);
                if (data.success && data.data) {
                    console.log('Certificate: getLectureData data keys:', Object.keys(data.data));
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
                    
                    // 元のキーも保持（念のため）
                    if (key !== normalizedKey && key !== numKey && key !== strKey) {
                        normalizedData[key] = value;
                    }
                });
                
                if (typeof console !== 'undefined' && console.log) {
                    console.log('Certificate: getLectureData normalized keys:', Object.keys(normalizedData));
                    if (Object.keys(normalizedData).length > 0) {
                        var sampleKey = Object.keys(normalizedData)[0];
                        console.log('Certificate: getLectureData sample data:', normalizedData[sampleKey]);
                    }
                }
                
                return normalizedData;
            }
            return {};
        })
        .catch(function(error) {
            console.error('Certificate: Error fetching lecture data:', error);
            return {};
        });
    }
    
    // 完了した講座を取得
    function getCompletedLectures() {
        var episodeCompletions = getEpisodeCompletions();
        var lectureCompletions = {};
        
        // 講座ごとの完了状況を集計
        Object.keys(episodeCompletions).forEach(function(episodeId) {
            var completion = episodeCompletions[episodeId];
            var lectureId = completion.lectureId;
            
            if (!lectureCompletions[lectureId]) {
                lectureCompletions[lectureId] = {
                    lectureId: lectureId,
                    completedEpisodes: [],
                    latestCompletion: completion.timestamp
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
        
        return lectureCompletions;
    }
    
    // 修了証を表示
    function displayCertificate() {
        var loading = document.getElementById('certificate-loading');
        var content = document.getElementById('certificate-content');
        var error = document.getElementById('certificate-error');
        
        var lectureCompletions = getCompletedLectures();
        var lectureIds = Object.keys(lectureCompletions);
        
        if (lectureIds.length === 0) {
            loading.classList.add('hidden');
            error.classList.remove('hidden');
            return;
        }
        
        // 講座データを取得
        getLectureData(lectureIds).then(function(lectureData) {
            // 100%完了した講座のみを抽出
            var completedLectures = [];
            
            Object.keys(lectureCompletions).forEach(function(lectureId) {
                var lectureCompletion = lectureCompletions[lectureId];
                var totalEpisodes = 5; // デフォルト値
                var lectureTitle = '講座 #' + lectureId;
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
                        console.warn('Certificate: Lecture data not found for ID:', lectureId, 'Available keys:', availableKeys);
                        // 利用可能なキーから最初のデータを使用（フォールバック）
                        var firstKey = availableKeys[0];
                        lectureInfo = lectureData[firstKey];
                        if (lectureInfo) {
                            console.warn('Certificate: Using first available key:', firstKey);
                        }
                    }
                    
                    if (lectureInfo) {
                        lectureTitle = lectureInfo.title || lectureTitle;
                        lectureUrl = lectureInfo.url || lectureUrl;
                        totalEpisodes = lectureInfo.total_episodes || totalEpisodes;
                        
                        if (typeof console !== 'undefined' && console.log) {
                            console.log('Certificate: Lecture info found:', {
                                id: lectureId,
                                title: lectureTitle,
                                totalEpisodes: totalEpisodes,
                                url: lectureUrl
                            });
                        }
                    } else {
                        console.error('Certificate: Lecture data not found for ID:', lectureId, 'Available keys:', availableKeys);
                        // フォールバック: 利用可能なキーから最初のデータを使用
                        if (availableKeys.length > 0) {
                            console.warn('Certificate: Using first available key:', availableKeys[0]);
                            lectureInfo = lectureData[availableKeys[0]];
                            if (lectureInfo) {
                                lectureTitle = lectureInfo.title || lectureTitle;
                                lectureUrl = lectureInfo.url || lectureUrl;
                                totalEpisodes = lectureInfo.total_episodes || totalEpisodes;
                            }
                        }
                    }
                }
                
                // 完了エピソード数を確認
                var uniqueCompletedEpisodes = Array.from(new Set(lectureCompletion.completedEpisodes));
                
                if (uniqueCompletedEpisodes.length >= totalEpisodes) {
                    completedLectures.push({
                        id: lectureId,
                        title: lectureTitle,
                        completedAt: lectureCompletion.latestCompletion,
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
            
            if (completedLectures.length === 0) {
                loading.classList.add('hidden');
                error.classList.remove('hidden');
                return;
            }
            
            // 修了証を表示
            var completedCount = completedLectures.length;
            var titleInfo = getTitle(completedCount);
            
            // 称号を設定
            var certificateTitle = document.getElementById('certificate-title');
            var certificateSubtitle = document.getElementById('certificate-subtitle');
            if (certificateTitle) {
                certificateTitle.textContent = titleInfo.title;
                certificateTitle.className = 'text-2xl md:text-3xl font-bold mb-2 ' + titleInfo.color;
            }
            if (certificateSubtitle) {
                certificateSubtitle.textContent = titleInfo.subtitle;
            }
            
            // 完了講座数を設定
            var completedCountEl = document.getElementById('completed-count');
            if (completedCountEl) {
                completedCountEl.textContent = completedCount;
            }
            
            // 発行日を設定
            var certificateDate = document.getElementById('certificate-date');
            if (certificateDate) {
                var today = new Date();
                var dateStr = today.getFullYear() + '年' + 
                             (today.getMonth() + 1) + '月' + 
                             today.getDate() + '日';
                certificateDate.textContent = dateStr;
            }
            
            // 完了講座一覧を表示
            var lecturesList = document.getElementById('completed-lectures-list');
            if (lecturesList) {
                lecturesList.innerHTML = '';
                
                completedLectures.forEach(function(lecture) {
                    var completedDate = new Date(lecture.completedAt);
                    var dateStr = completedDate.getFullYear() + '年' + 
                                 (completedDate.getMonth() + 1) + '月' + 
                                 completedDate.getDate() + '日';
                    
                    var item = document.createElement('div');
                    item.className = 'flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors';
                    item.innerHTML = '<div class="flex-1">' +
                        '<div class="font-medium text-gray-800">' + lecture.title + '</div>' +
                        '<div class="text-sm text-gray-500">完了日: ' + dateStr + '</div>' +
                    '</div>' +
                    '<div class="ml-4">' +
                        '<a href="' + lecture.url + '" class="text-blue-600 hover:text-blue-800 text-sm" target="_blank">' +
                            '<i class="fas fa-external-link-alt"></i>' +
                        '</a>' +
                    '</div>';
                    
                    lecturesList.appendChild(item);
                });
            }
            
            // 表示
            loading.classList.add('hidden');
            content.classList.remove('hidden');
        });
    }
    
    // 印刷機能
    function setupPrintButton() {
        var printBtn = document.getElementById('print-certificate');
        if (printBtn) {
            printBtn.addEventListener('click', function() {
                window.print();
            });
        }
    }
    
    // PDFダウンロード機能（印刷ダイアログを開く）
    function setupDownloadButton() {
        var downloadBtn = document.getElementById('download-certificate');
        if (downloadBtn) {
            downloadBtn.addEventListener('click', function() {
                window.print();
            });
        }
    }
    
    // 初期化
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            displayCertificate();
            setupPrintButton();
            setupDownloadButton();
        });
    } else {
        displayCertificate();
        setupPrintButton();
        setupDownloadButton();
    }
})();
</script>

<!-- 印刷用スタイル -->
<style>
@media print {
    body {
        background: white;
    }
    
    .page-header,
    .container > nav,
    #certificate-container > div:not(#certificate-content),
    #certificate-content > div:last-child {
        display: none !important;
    }
    
    .certificate {
        border: 4px solid #000 !important;
        box-shadow: none !important;
        page-break-inside: avoid;
    }
    
    #completed-lectures-list {
        max-height: none !important;
        overflow: visible !important;
    }
    
    @page {
        margin: 2cm;
        size: A4;
    }
}
</style>

<?php get_footer(); ?>

