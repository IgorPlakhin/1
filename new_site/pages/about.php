<?php
// Проверка авторизации с использованием функции из boot.php
// require_once __DIR__ . '../boot.php';

// if (!check_auth()) {
//     header('Location: ../login.php');
//     exit;
// }

// Получаем имя пользователя из сессии
$username = $_SESSION['username'] ?? '';
$menu = [
    'Home' => '../index.php',
    'library' => '../pages/library.php',
    'Contacts' => '../pages/contacts.php',
    'About' => '../pages/about.php'
];
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/about.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>О нас</title>
</head>

<body>
    <div class="container">
        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
                <img src="../img/favicon-96x96.png" alt="logo" class="navbar-brand">
            </a>
            <nav class="nav nav-pills">
                <?php foreach ($menu as $name => $link): ?>
                    <li class="nav-item">
                        <a href="<?= $link ?>" class="nav-link"><?= $name ?></a>
                    </li>
                <?php endforeach; ?>
            </nav>
            <div class="ms-3">
                <?php if ($username): ?>
                    <span class="text-muted">Добро пожаловать, <?= htmlspecialchars($username) ?>!</span>
                <?php endif; ?>
            </div>
        </header>

        <main>
            <section class="py-1 py-md-1">
                <div class="row justify-content-md-center">
                    <div class="col-12 col-md-10 col-lg-8">
                        <h2 class=" display-4 text-center">About Us</h2>
                        <p class="text-secondary text-center lead fs-5">
                            Привет!<br>
                            Наша миссия — Ваши отличные знания.<br>
                            Мы работаем в сфере образования (английский язык).
                        </p>
                    </div>
                </div>
            </section>

            <div class="container">
                <div class="row gy-4 gy-lg-0 align-items-lg-center">
                    <div class="col-12 col-lg-4">
                        <img class="img-fluid rounded border border-dark" loading="lazy" src="../img/image.png"
                            alt="About Us">
                    </div>
                    <div class="col-12 col-lg-6 col-xxl-6">
                        <div class="row justify-content-lg-end">
                            <div class="col-12 col-lg-11">
                                <div class="about-wrapper">
                                    <p class="lead mb-4 mb-md-5">Учу английскийскому языку взрослых и детей в
                                        индивидуальном и
                                        групповом форомате с 2004 года. Есть опыт работы в
                                        различных языковых школах школах "Я" и "English First". За плечами успешная
                                        погодовка к ОГЭ и УГЭ, IELST.
                                        В 2006 году получила образование в Новосибирском Педагогическом Университете по
                                        специальности "Английский язык и новышие технологии преподавания", после
                                        окончания ВУЗа жила и работала в Соединенных Штатах, училась в колледже в
                                        Великобритании.

                                    </p>
                                    <div class="row gy-4 mb-4 mb-md-5">
                                        <div class="col-12 col-md-6">
                                            <div class="card border border-dark">
                                                <div class="card-body p-4">
                                                    <h3 class="display-5 fw-bold text-primary text-center mb-2">370+
                                                    </h3>
                                                    <p class="fw-bold text-center m-0">Qualified Experts</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="card border border-dark">
                                                <div class="card-body p-4">
                                                    <h3 class="display-5 fw-bold text-primary text-center mb-2">18k+
                                                    </h3>
                                                    <p class="fw-bold text-center m-0">Satisfied Clients</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="#!" class="btn btn-primary bsb-btn-2xl">
                                        Certificate
                                        <img src="../img/image.png" alt="Arrow" width="20" height="20"
                                            style="margin-left: 5px;">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>