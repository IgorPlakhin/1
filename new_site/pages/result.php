<?php
require_once __DIR__ . '/../boot.php';

if (!check_auth()) {
    header('Location: login.php');
    exit;
}

$user = null;
if (check_auth()) {
    $stmt = pdo()->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute(['id' => $_SESSION['user_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Правильный путь к файлу результатов (на уровень выше от pages/)
$file = dirname(__DIR__) . '/results.json';

$contents = @file_get_contents($file);
$results = [];

if ($contents !== false) {
    $decoded = json_decode($contents, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
        $results = $decoded;
    } else {
        // Если файл битый — не ломаем страницу, просто показываем пустой список
        $results = [];
    }
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <title>Результаты тестов</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="body">
    <div class="container py-4">
        <h2>Результаты тестов (все пользователи)</h2>

        <?php if ($user): ?>
            <p class="text-muted">Вы авторизованы как: <b><?= htmlspecialchars($user['username']) ?></b></p>
        <?php endif; ?>

        <?php if (empty($results)): ?>
            <div class="alert alert-info">Пока нет результатов тестов.</div>
        <?php else: ?>
            <table class="table table-striped table-hover table-sm">
                <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Пользователь</th>
                        <th class="text-end">Правильных</th>
                        <th class="text-end">Неправильных</th>
                        <th class="text-end">Процент</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $r): ?>
                        <tr>
                            <td><?= htmlspecialchars(date('d.m.Y H:i', strtotime($r['created_at']))) ?></td>
                            <td><?= htmlspecialchars($r['username']) ?></td>
                            <td class="text-end"><?= htmlspecialchars((string) $r['correct_answers']) ?></td>
                            <td class="text-end"><?= htmlspecialchars((string) $r['incorrect_answers']) ?></td>
                            <td class="text-end"><?= htmlspecialchars((string) $r['score_percent']) ?>%</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <a href="../index.php" class="btn btn-secondary">На главную</a>
    </div>
</body>

</html>