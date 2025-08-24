<?php
/**
 * JSONテスト用ファイル
 * 
 * 提供されたJSONの解析をテストするための一時的なファイル
 */

// テスト用JSON
$test_json = '[
  {
    "speaker": "maron",
    "message": "みんな〜こんにちは！ネコフリークス大学の時間だよ！今日から新しい講座が始まるんだって！今回はどんなテーマなのかな？",
    "position": "left"
  },
  {
    "speaker": "ichi",
    "message": "こんにちは、マロン学長。今回は『猫の行動問題』について一緒に学んでいこう。これは多くの飼い主にとって、とても大切なテーマだ。",
    "position": "right"
  },
  {
    "speaker": "maron",
    "message": "えええ！？猫の"行動問題"？そんなに大事なことだったの！？…びっくりしたにゃ〜！",
    "position": "left"
  },
  {
    "speaker": "ichi",
    "message": "ふふ、驚くのも無理はない。だが、行動の問題は猫の命にも関わることがあるのだよ。",
    "position": "right"
  },
  {
    "speaker": "maron",
    "message": "そ、それは困るにゃ…！よーし、今日からみんなで一緒にがんばろう！",
    "position": "left"
  }
]';

echo "<h1>JSONテスト結果</h1>";

// 1. 基本的なJSON解析テスト
echo "<h2>1. 基本的なJSON解析</h2>";
$parsed = json_decode($test_json, true);
if (json_last_error() === JSON_ERROR_NONE) {
    echo "✅ JSON解析成功<br>";
    echo "会話数: " . count($parsed) . "<br>";
} else {
    echo "❌ JSON解析エラー: " . json_last_error_msg() . "<br>";
    echo "エラーコード: " . json_last_error() . "<br>";
}

// 2. 文字エンコーディングチェック
echo "<h2>2. 文字エンコーディングチェック</h2>";
$fullwidth_chars = array('：', '，', '｛', '｝', '［', '］', '　', 
    chr(0xE2).chr(0x80).chr(0x9C), // "
    chr(0xE2).chr(0x80).chr(0x9D), // "
    chr(0xE2).chr(0x80).chr(0x98), // '
    chr(0xE2).chr(0x80).chr(0x99)  // '
);
$found_chars = array();
foreach ($fullwidth_chars as $char) {
    if (strpos($test_json, $char) !== false) {
        $found_chars[] = $char;
    }
}

if (empty($found_chars)) {
    echo "✅ 全角文字は検出されませんでした<br>";
} else {
    echo "❌ 全角文字が検出されました: " . implode(', ', $found_chars) . "<br>";
}

// 3. 特殊文字チェック
echo "<h2>3. 特殊文字チェック</h2>";
$special_chars = array('…', '—', '–', '『', '』');
$found_special = array();
foreach ($special_chars as $char) {
    if (strpos($test_json, $char) !== false) {
        $found_special[] = $char;
    }
}

if (empty($found_special)) {
    echo "✅ 特殊文字は検出されませんでした<br>";
} else {
    echo "⚠️ 特殊文字が検出されました: " . implode(', ', $found_special) . "<br>";
}

// 4. 構造チェック
echo "<h2>4. 構造チェック</h2>";
if (is_array($parsed)) {
    $valid_speakers = array('maron', 'ichi', 'hachi', 'jiji', 'daifuku');
    $errors = array();
    
    foreach ($parsed as $index => $dialogue) {
        if (!isset($dialogue['speaker'])) {
            $errors[] = "会話{$index}: speakerフィールドがありません";
        } elseif (!in_array($dialogue['speaker'], $valid_speakers)) {
            $errors[] = "会話{$index}: 無効なspeaker '{$dialogue['speaker']}'";
        }
        
        if (!isset($dialogue['message'])) {
            $errors[] = "会話{$index}: messageフィールドがありません";
        }
        
        if (isset($dialogue['position']) && !in_array($dialogue['position'], array('left', 'right'))) {
            $errors[] = "会話{$index}: 無効なposition '{$dialogue['position']}'";
        }
    }
    
    if (empty($errors)) {
        echo "✅ 構造は正常です<br>";
    } else {
        echo "❌ 構造エラー:<br>";
        foreach ($errors as $error) {
            echo "&nbsp;&nbsp;• {$error}<br>";
        }
    }
}

// 5. 実際のデータ表示
echo "<h2>5. 解析されたデータ</h2>";
if (is_array($parsed)) {
    foreach ($parsed as $index => $dialogue) {
        echo "<div style='border: 1px solid #ccc; margin: 10px 0; padding: 10px;'>";
        echo "<strong>会話{$index}:</strong><br>";
        echo "Speaker: " . htmlspecialchars($dialogue['speaker']) . "<br>";
        echo "Message: " . htmlspecialchars($dialogue['message']) . "<br>";
        echo "Position: " . htmlspecialchars($dialogue['position'] ?? 'left') . "<br>";
        echo "</div>";
    }
}

// 6. 改善された関数でのテスト
echo "<h2>6. 改善された関数でのテスト</h2>";

// 関数が存在するかチェック
if (function_exists('nfu_parse_dialogue_json')) {
    $improved_result = nfu_parse_dialogue_json($test_json);
    echo "改善された関数での解析結果: " . count($improved_result) . "件の会話<br>";
} else {
    echo "❌ nfu_parse_dialogue_json関数が見つかりません<br>";
}

if (function_exists('nfu_validate_dialogue_json')) {
    $validation = nfu_validate_dialogue_json($test_json);
    if ($validation['valid']) {
        echo "✅ JSONバリデーション成功<br>";
    } else {
        echo "❌ JSONバリデーションエラー: " . $validation['error'] . "<br>";
    }
} else {
    echo "❌ nfu_validate_dialogue_json関数が見つかりません<br>";
}

echo "<h2>7. 推奨される修正版JSON</h2>";
echo "<pre>";
echo htmlspecialchars('[
  {
    "speaker": "maron",
    "message": "みんな〜こんにちは！ネコフリークス大学の時間だよ！今日から新しい講座が始まるんだって！今回はどんなテーマなのかな？",
    "position": "left"
  },
  {
    "speaker": "ichi",
    "message": "こんにちは、マロン学長。今回は「猫の行動問題」について一緒に学んでいこう。これは多くの飼い主にとって、とても大切なテーマだ。",
    "position": "right"
  },
  {
    "speaker": "maron",
    "message": "えええ！？猫の「行動問題」？そんなに大事なことだったの！？…びっくりしたにゃ〜！",
    "position": "left"
  },
  {
    "speaker": "ichi",
    "message": "ふふ、驚くのも無理はない。だが、行動の問題は猫の命にも関わることがあるのだよ。",
    "position": "right"
  },
  {
    "speaker": "maron",
    "message": "そ、それは困るにゃ…！よーし、今日からみんなで一緒にがんばろう！",
    "position": "left"
  }
]');
echo "</pre>";
?>
