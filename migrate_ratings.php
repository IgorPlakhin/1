<?php
// migrate_ratings.php — запустить один раз
$dbPath = __DIR__ . '/comments.db';
$pdo = new PDO("sqlite:$dbPath");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Таблица оценок: один пользователь — одна оценка на комментарий
$pdo->exec("
    CREATE TABLE IF NOT EXISTS comment_ratings (
        comment_id INTEGER NOT NULL,
        user_id INTEGER NOT NULL,
        rating INTEGER NOT NULL CHECK (rating BETWEEN 1 AND 5),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (comment_id, user_id)
    )
");

echo "Готово: таблица оценок создана.";
?>