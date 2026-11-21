<?php
require_once __DIR__ . '/../comments_db.php';

// Все комментарии, сгруппированные по слову, свежие сверху
$rows = commentsPdo()->query("
    SELECT word, date, author, text, created_at
    FROM comments
    ORDER BY date DESC, id DESC
")->fetchAll(PDO::FETCH_ASSOC);

$currentWord = null;
foreach ($rows as $c) {
    if ($c['word'] !== $currentWord) {
        $currentWord = $c['word'];
        echo '<h4 class="mt-4">«' . htmlspecialchars($currentWord) . '» (' . htmlspecialchars($c['date']) . ')</h4>';
    }
    echo '<div class="mb-1">'
        . '<strong>' . htmlspecialchars($c['author']) . '</strong> '
        . '<small class="text-muted">' . htmlspecialchars($c['created_at']) . '</small><br>'
        . nl2br(htmlspecialchars($c['text']))
        . '</div>';
}
