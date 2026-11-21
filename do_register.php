<?php

require_once __DIR__ . '/boot.php';

// Проверяем метод запроса

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header('Location: index.php');

    exit;

}

// Получаем данные

$username = trim($_POST['username'] ?? '');

$password = $_POST['password'] ?? '';

// Валидация

if ($username === '' || $password === '') {

    flash('Заполните все поля');

    header('Location: login.php');

    exit;

}

// Проверяем, не занято ли имя пользователя

$stmt = pdo()->prepare("SELECT id FROM `users` WHERE `username` = :username");

$stmt->execute(['username' => $username]);

if ($stmt->fetch()) {

    flash('Это имя пользователя уже занято.');

    header('Location: login.php');

    exit;

}

// Добавляем пользователя

$stmt = pdo()->prepare("INSERT INTO `users` (`username`, `password`) VALUES (:username, :password)");

$stmt->execute([

    'username' => $username,

    'password' => password_hash($password, PASSWORD_DEFAULT),

]);

// Авторизуем сразу

session_start();

$_SESSION['user_id'] = pdo()->lastInsertId();

$_SESSION['username'] = $username;

header('Location: login.php');

exit;

