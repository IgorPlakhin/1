<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

function rlog(string $msg): void
{
    file_put_contents(__DIR__ . '/rate_log.txt', date('H:i:s ') . $msg . PHP_EOL, FILE_APPEND);
}

rlog('=== запрос получен ===');
require_once __DIR__ . '/../boot.php';
rlog('boot.php подключён');
require_once __DIR__ . '/../comments_db.php';
rlog('comments_db.php подключён');

header('Content-Type: application/json');

try {
    if (!check_auth()) {
        rlog('не авторизован');
        http_response_code(403);
        echo json_encode(['error' => 'Войдите, чтобы оценить комментарий']);
        exit;
    }
    rlog('авторизован, user_id=' . $_SESSION['user_id']);

    $stmt = pdo()->prepare("SELECT username FROM users WHERE id = :id");
    $stmt->execute([':id' => $_SESSION['user_id']]);
    $username = (string) $stmt->fetchColumn();
    rlog('username=' . $username);

    if (mb_strtolower(trim($username)) !== 'игорь') {
        rlog('не Игорь — запрет');
        http_response_code(403);
        echo json_encode(['error' => 'Оценки может ставить только Игорь']);
        exit;
    }

    $commentId = filter_input(INPUT_POST, 'comment_id', FILTER_VALIDATE_INT);
    $rating = filter_input(
        INPUT_POST,
        'rating',
        FILTER_VALIDATE_INT,
        ['options' => ['min_range' => 1, 'max_range' => 5]]
    );
    $userId = (int) $_SESSION['user_id'];
    rlog("comment_id=$commentId rating=$rating");

    if (!$commentId || !$rating) {
        rlog('неверные параметры: ' . print_r($_POST, true));
        http_response_code(400);
        echo json_encode(['error' => 'Неверные параметры']);
        exit;
    }

    $pdo = commentsPdo();

    $check = $pdo->prepare("SELECT 1 FROM comments WHERE id = :cid");
    $check->execute([':cid' => $commentId]);
    if (!$check->fetchColumn()) {
        rlog('комментарий не найден');
        http_response_code(404);
        echo json_encode(['error' => 'Комментарий не найден']);
        exit;
    }

    $has = $pdo->prepare("SELECT 1 FROM comment_ratings WHERE comment_id = :cid AND user_id = :uid");
    $has->execute([':cid' => $commentId, ':uid' => $userId]);

    if ($has->fetchColumn()) {
        $upd = $pdo->prepare("UPDATE comment_ratings SET rating = :rating
                              WHERE comment_id = :cid AND user_id = :uid");
        $upd->execute([':rating' => $rating, ':cid' => $commentId, ':uid' => $userId]);
        rlog('оценка обновлена');
    } else {
        $ins = $pdo->prepare("INSERT INTO comment_ratings (comment_id, user_id, rating)
                              VALUES (:cid, :uid, :rating)");
        $ins->execute([':cid' => $commentId, ':uid' => $userId, ':rating' => $rating]);
        rlog('оценка добавлена');
    }

    $avg = $pdo->prepare("SELECT ROUND(AVG(rating), 1) AS avg_r, COUNT(*) AS cnt
                          FROM comment_ratings WHERE comment_id = :cid");
    $avg->execute([':cid' => $commentId]);
    $row = $avg->fetch(PDO::FETCH_ASSOC);

    rlog('готовим ответ: ' . print_r($row, true));
    echo json_encode([
        'success' => true,
        'avg_rating' => (float) $row['avg_r'],
        'votes' => (int) $row['cnt'],
        'my_rating' => $rating,
    ]);
    rlog('ответ отправлен');

} catch (Throwable $e) {
    rlog('ИСКЛЮЧЕНИЕ: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['error' => 'Ошибка сервера: ' . $e->getMessage()]);
}
