<?php
// index.php
require_once __DIR__ . '/boot.php';



// Обработка выхода через GET
if (isset($_GET['logout'])) {
  session_unset();
  session_destroy();
  header('Location: index.php');
  exit;
}

// Проверка авторизации
$user = null;
if (check_auth()) {
  $stmt = pdo()->prepare("SELECT * FROM users WHERE id = :id");
  $stmt->execute(['id' => $_SESSION['user_id']]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

$menu = [
  'Home' => 'index.php',
  'Library' => 'pages/library.php',
  'Pricing' => 'pages/pricing.php',
  'Contacts' => 'pages/contacts.php',
  'About' => 'pages/about.php',
  'menu' => 'pages/test.php'
];
?>
<?php
// URL API для получения цитаты дня
$api_url = 'https://favqs.com/api/qotd';

// Инициализация cURL сессии
$ch = curl_init();


// Установка параметров cURL
curl_setopt($ch, CURLOPT_URL, $api_url); // URL для запроса
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Возвращать результат в виде строки
curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Таймаут запроса в секундах
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  'Accept: application/json' // Указываем, что ожидаем JSON ответ
));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
// Выполнение cURL запроса
$response = curl_exec($ch);

// Проверка на ошибки cURL
if (curl_errno($ch)) {

  $error_message = 'cURL error: ' . curl_error($ch);

  echo "<p style='color: red;'>Не удалось получить цитату: " . htmlspecialchars($error_message) . "</p>";
  $quote_body = "Не удалось загрузить цитату.";
  $quote_author = "Система";
} else {
  // Закрытие cURL сессии
  curl_close($ch);

  // Декодирование JSON ответа
  $data = json_decode($response, true);

  // Проверка, успешно ли декодирован JSON и есть ли нужные ключи
  if (json_last_error() === JSON_ERROR_NONE && isset($data['quote']['body']) && isset($data['quote']['author'])) {
    $quote_body = $data['quote']['body'];
    $quote_author = $data['quote']['author'];
  } else {
    // Обработка случая, если ответ не в ожидаемом формате
    echo "<p style='color: orange;'>Получен некорректный ответ от API.</p>";
    $quote_body = "Ошибка в формате данных.";
    $quote_author = "Система";
  }
}


$test_result_block = '';

if ($user && !empty($_SESSION['test_finished'])) {
  $correct = $_SESSION['correct_answers'] ?? 0;
  $incorrect = $_SESSION['incorrect_answers'] ?? 0;
  $total = $correct + $incorrect;


  $test_result_block = "
        <div class='alert alert-info mt-3'>
            <strong>Результат последнего теста:</strong> $correct из $total правильных ответов.
            <a href='test2.php?reset=1' class='fw-bold'>Пройти заново</a>
        </div>
    ";
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Убедитесь, что стили Bootstrap подключены. Можете использовать один из них, например, последний -->
  <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/utilities/font-size/font-size.css">
  <link rel="stylesheet" href="css/responsive.css">

  <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
  <link rel="shortcut icon" href="/favicon.ico" />
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
  <meta name="apple-mobile-web-app-title" content="MyWebSite" />
  <link rel="manifest" href="/site.webmanifest" />
  <link rel="stylesheet" href="css/style.css">
  <title>Сайт</title>

</head>

<body class="body" style="background: linear-gradient(to right, #FFE53B, #00FFFF)">
  <header class="d-flex flex-wrap justify-content-center py-3 mb-0 border-bottom" ;>
    <!-- NAV #1 и HEADER -->
    <div class=" top">
      <div class="container">
        <div class="row">
          <!-- NAV #1 -->
          <nav class="navbar navbar-expand-md mb-4" class="bizes-nav">
            <div class="container-fluid">
              <div class="me-3"> <!-- Добавляем отступ слева -->
                <?php if ($user): ?>

                  <a href="index.php?logout=1" class="btn btn-primary btn-sm">Logout</a>
                <?php else: ?>
                  <a href="login.php" class="btn btn-outline-primary btn-sm me-2">Login</a> <!-- Кнопка Login -->
                <?php endif; ?>
              </div>
              <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
                <div class="navbar-brand sec-">
                  <img src="img/favicon-96x96.png" alt="logo">
                </div>
              </a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ms-auto mb-2 mb-md-0 main-menu-wrap">
                  <?php



                  $menu = [
                    'Home' => 'index.php',
                    'Pricing' => 'pages/pricing.php',
                    'Contacts' => 'pages/contacts.php',
                    'About' => 'pages/about.php',
                  ];

                  // Тест показываем только авторизованным
                  if ($user) {
                    $menu['Library'] = 'pages/library.php';
                    $menu['Test'] = 'pages/test2.php';
                    $menu['Result'] = 'pages/result.php';
                  }
                  ?>
                  <nav class="nav nav-pills">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0 bizes-nav">
                      <?php foreach ($menu as $name => $link): ?>
                        <li class="menu-list">
                          <a href="<?= $link ?>" class="nav-link">
                            <?= $name ?>
                          </a>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  </nav>
                </ul>
              </div>
            </div>
          </nav>
          <!-- HEADER -->



          <!-- ARTICLE -->
          <article class="col-md-8 col-xl-6 py-4">
            <div class="me-3 "> <!-- Добавляем отступ слева -->
              <?php if ($user): ?>
                <span class="me-3">
                  <h2> Welcome back,
                    <?= htmlspecialchars($user['username']) ?>!
                  </h2>
                </span>


              <?php endif; ?>
            </div>

            <div class="header_title ">
              <h5>рубрика: </h5>

              <h1>Цитата дня</h1>


            </div>
            <blockquote class="blockquote mt-3">
              <p class="mb-0"><?= htmlspecialchars($quote_body, ENT_QUOTES, 'UTF-8') ?></p>
              <br>
              <footer class="blockquote-footer">— <?= htmlspecialchars($quote_author, ENT_QUOTES, 'UTF-8') ?></footer>
            </blockquote>

            <!-- Результат теста выводим ОТДЕЛЬНО, не внутри цитаты -->
            <!-- <?php if ($test_result_block): ?>
                <?= $test_result_block ?>
              <?php endif; ?> -->


          </article>
          <!-- ASIDE -->
          <aside class="col-md-4 col-xl-5">
            <img src="img/image.png" class="img-responsive" alt="image" width="100%">
          </aside>
        </div>
      </div>
    </div>
  </header> <!-- Закрытие header, которое было открыто вверху -->
  <div class="container">



    <!-- FOOTER -->
    <div class="container d-flex flex-wrap justify-content-between align-items-center py-4 my-4 border-top">
      <div class="col-md-2 mb-0 text-body-secondary">
        <img src="img2/favicon-96x96.png" alt="logo">
      </div>

      <div class="col-md-6 d-flex align-items-center">

        <p class="text-muted"> создавать пространство, где ученик не просто учит язык, а развивает
          коммуникативные навыки, уверенность в себе и готовность к жизни в глобальном мире</p>
      </div>
      <h3 class="fw-bold mb-3">Миссия</h5>


    </div>
    <div class="d-flex gap-3 mt-4">
      <span class="text-muted">© To be or not to be</span>
    </div>
  </div> <!-- Закрытие основного .container -->

  <!-- Подключение JavaScript Bootstrap -->
  <!-- ВАЖНО: Подключите эти скрипты перед закрывающим тегом </body> -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Или если вы используете другой CDN -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> -->

  <!-- Ваш собственный JavaScript, если есть -->
  <!-- <script src="js/script.js"></script> -->
</body>

</html>