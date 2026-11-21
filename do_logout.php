<?php
// do_logout.php - обработчик выхода из системы
require_once __DIR__ . '/boot.php';

// Проверяем, что пользователь авторизован
if (check_auth()) {
    // Уничтожаем сессию полностью
    session_unset();
    session_destroy();

    // Перенаправляем на главную страницу
    header('Location: index.php');
    exit;
}

// Если не авторизован - также на главную
header('Location: index.php');
exit;
?>