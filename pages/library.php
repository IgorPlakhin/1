<?php
// library.php?cat=Grammar

$allowed = ['Teenagers', 'Adults', 'Grammar', 'Reading'];

$cat = $_GET['cat'] ?? 'Teenagers';
if (!in_array($cat, $allowed, true)) {
    http_response_code(404);
    exit('Категория не найдена');
}

// страница лежит в pages/ → папка pdf на уровень выше
$dir     = __DIR__ . '/../pdf/' . $cat . '/';
$webPath = '../pdf/' . $cat . '/';

$files = glob($dir . '*.pdf');
sort($files);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/library.css">
    <title><?= htmlspecialchars($cat) ?> — Библиотека</title>

    <style>
        @media (min-width: 992px) {
            .offcanvas-lg {
                position: sticky;
                top: 0;
                height: 100vh;
                width: 260px;
                border-right: 1px solid #dee2e6;
                background-color: #f8f9fa;
            }
        }
        .offcanvas-lg .nav-link {
            padding: 10px 16px;
            color: #495057;
            border-radius: 6px;
        }
        .offcanvas-lg .nav-link:hover {
            background-color: #e9ecef;
            color: #0d6efd;
        }
        .offcanvas-lg .nav-link.active {
            background-color: #0d6efd;
            color: #fff;
        }
        /* Карточки — без фикс. ширины, размер задают колонки Bootstrap */
        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            overflow: hidden;
            text-align: center;
            padding-bottom: 10px;
        }
        .card h3 {
            margin: 5px 0;
            font-size: 1.1rem;
        }
        .card a {
            display: inline-block;
            width: 80%;
            padding: 8px;
            background-color: #f0f0f0;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 5px;
        }
        .card a:hover { background-color: #e9ecee; }
        .pdf-preview {
            width: 100%;
            height: 200px;
            border: 0;
        }
    </style>
</head>
<body>

    <!-- Шапка с гамбургером — на мобильных -->
    <nav class="navbar bg-light border-bottom d-lg-none">
        <div class="container-fluid">
            <a class="navbar-brand" href="/index.php">
                <img src="../img/favicon-96x96.png" alt="logo" width="32" height="32">
            </a>
            <button class="navbar-toggler" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#sidebar"
                    aria-controls="sidebar" aria-label="Открыть меню">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <div class="container-fluid p-0">
        <div class="row m-0">

            <!-- Боковое меню -->
            <aside class="col-lg-auto p-0">
                <div class="offcanvas-lg offcanvas-start" tabindex="-1" id="sidebar"
                     aria-labelledby="sidebarLabel">

                    <div class="offcanvas-header d-lg-none">
                        <h5 class="offcanvas-title" id="sidebarLabel">Меню</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                data-bs-target="#sidebar" aria-label="Закрыть"></button>
                    </div>

                    <div class="offcanvas-body d-flex flex-column">
                        <a href="/index.php" class="d-none d-lg-flex align-items-center p-3 text-decoration-none">
                            <img src="../img/favicon-96x96.png" alt="logo" width="40" height="40">
                        </a>

                        <nav class="nav flex-column p-2">
                            <?php
                            $cats = [
                                'Teenagers' => 'library.php?cat=Teenagers',
                                'Adults'    => 'library.php?cat=Adults',
                                'Grammar'   => 'library.php?cat=Grammar',
                                'Reading'   => 'library.php?cat=Reading',
                            ];
                            foreach ($cats as $name => $link): ?>
                                <a href="<?= htmlspecialchars($link) ?>"
                                   class="nav-link <?= ($_GET['cat'] ?? 'Teenagers') === $name ? 'active' : '' ?>">
                                    <?= htmlspecialchars($name) ?>
                                </a>
                            <?php endforeach; ?>
                        </nav>
                    </div>
                </div>
            </aside>

            <!-- Контент -->
            <main class="col p-4">
                <header class="d-flex flex-wrap justify-content-between align-items-center py-3 mb-4 border-bottom">
                    <h2 class="mb-0"><?= htmlspecialchars($cat) ?></h2>
                    <nav class="nav nav-pills">
                        <?php
                        $siteMenu = [
                            'Home'     => '../index.php',
                            'Pricing'  => 'pricing.php',
                            'Contacts' => 'contacts.php',
                            'About'    => 'about.php',
                        ];
                        foreach ($siteMenu as $name => $link): ?>
                            <a href="<?= htmlspecialchars($link) ?>" class="nav-link"><?= htmlspecialchars($name) ?></a>
                        <?php endforeach; ?>
                    </nav>
                </header>

                <div class="row g-4">
                    <?php if (!$files): ?>
                        <div class="col-12">
                            <p class="text-muted">В этой категории пока нет файлов.</p>
                        </div>
                    <?php endif; ?>

                    <?php foreach ($files as $file):
                        $name  = basename($file);
                        $title = pathinfo($file, PATHINFO_FILENAME);
                        $url   = $webPath . rawurlencode($name);
                    ?>
                        <div class="col-xl-4 col-md-6 col-12">
                            <div class="card h-100">
                                <iframe src="<?= htmlspecialchars($url) ?>#page=1&toolbar=0"
                                        class="pdf-preview"></iframe>
                                <h3><?= htmlspecialchars($title) ?></h3>
                                <a href="<?= htmlspecialchars($url) ?>">open PDF</a>
                                <a href="<?= htmlspecialchars($url) ?>" download>download</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
