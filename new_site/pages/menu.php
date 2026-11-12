



<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.1">
  <link rel="stylesheet" href="../css/library.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <title>Сайт</title>

  <meta charset="UTF-8">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Карточки с PDF</title>



</head>

<body>
  <!-- NAV #1 и HEADER -->
  <div class="top">
    <div class="container">
      <div class="row">
        <!-- NAV #1 -->

        <nav class="navbar navbar-expand-md   mb-4">
          <div class="container-fluid">

            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
              <div class="navbar-brand sec-">
                <img src="../img/favicon-96x96.png" alt="logo">
              </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
              aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
              <ul class="navbar-nav me-auto mb-2 mb-md-0">

                <?php

                // Единый массив навигации
                
                $menu = [
                  'Home' => '../index.php',

                  'Pricing' => '../pages/pricing.php',
                  'Contacts' => '../pages/contacts.php',
                  'About' => '../pages/about.php'


                ];

                ?>

                <nav class="nav nav-pills">
                  <?php foreach ($menu as $name => $link): ?>
                    <li class="nav-item">
                      <a href="<?= $link ?>" class="nav-link"><?= $name ?></a>
                    </li>
                  <?php endforeach; ?>
                </nav>

              </ul>

            </div>
          </div>
        </nav>
        <!-- HEADER -->

        <!-- NAV #2 -->
        <!-- <nav class="col-xl-2">
                    <h4>Our goal is to make online education work for everyone</h4>
                </nav> -->
        <!-- ARTICLE -->
        <article class="col-md-8 col-xl-6">
          <h4> ARTICLEOur goal is to make online education work for everyone</h4>
        </article>
        <!-- ASIDE -->
        <aside class="col-md-4 col-xl-6">

          <img src="../img/image.png" class="img-responsive" alt="image" width="100%">

        </aside>
      </div>
    </div>
    </main>
    <!-- FOOTER -->
    <footer>
      <div class="container">
        <h4>Our goal is to make online education work for everyone</h4>
      </div>
    </footer>
</body>

</html>