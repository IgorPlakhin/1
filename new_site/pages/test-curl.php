<?php
$url = 'https://favqs.com/api/qotd?date=2026-11-01';
$caFile = __DIR__ . '\certs\cacert.pem';

if (!file_exists($caFile)) {
    die('Файл cacert.pem не найден по пути: ' . $caFile);
}

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
curl_setopt($ch, CURLOPT_CAINFO, $caFile);

$result = curl_exec($ch);

if ($result === false) {
    echo 'cURL error: ' . curl_error($ch);
} else {
    echo $result;
}
curl_close($ch);
?>