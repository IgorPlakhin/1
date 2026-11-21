<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$API_KEY = 'rrtr4867m789376necj9seqs0qn51rdk7u79e4vlavqkok0ny';

function tryRequest(string $label, array $params, string $apiKey): void
{
    $params['api_key'] = $apiKey;
    $url = 'https://api.wordnik.com/v4/words.json/wordOfTheDay?' . http_build_query($params);
    echo "<h3>$label</h3>";
    echo '<p>URL: ' . htmlspecialchars($url) . '</p>';

    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 10,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_CAINFO => 'C:/MAMP/htdocs/new_site/pages/cert/cacert.pem', // <-- добавь
    ]);

    $response = curl_exec($ch);
    $err = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    echo '<p>HTTP-код: ' . (int) $httpCode . '</p>';
    if ($response === false || $err) {
        echo '<p style="color:red">CURL ОШИБКА: ' . htmlspecialchars($err) . '</p>';
    } else {
        $data = json_decode((string) $response, true);
        echo '<p style="color:green">Ответ API: ' . htmlspecialchars(mb_substr($response, 0, 300)) . '</p>';
    }
    echo '<hr>';
}

echo '<h2>Диагностика Wordnik</h2>';
// Тест 1: без даты — как Wordnik отдаёт «свежее» слово
tryRequest('Тест 1: без параметра date', [], $API_KEY);
// Тест 2: с сегодняшней датой — как в index.php
tryRequest('Тест 2: с текущей датой', ['date' => date('Y-m-d')], $API_KEY);
