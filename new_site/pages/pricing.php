<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" />

<style>
    .pricing-list {
        margin-bottom: 1px;
    }

    .pricing-table {
        max-width: 350px;
        margin: auto;
    }

    .pricing-table,
    .pricing-horizontal {
        border-radius: 15px !important;
    }
</style>

<body>

    <div class="container">

        <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-decoration-none">
                <div class="navbar-brand sec-">
                    <img src="../img/favicon-96x96.png" alt="logo">
                </div>
            </a>
            <?php

            // Единый массив навигации
            
            $menu = [
                'Home' => '../index.php',

                'library' => '../pages/library.php',
                'Contacts' => '../pages/contacts.php',
                'About' => '../pages/about.php'


            ];

            ?>

            <nav class="nav nav-pills">
                <?php foreach ($menu as $name => $link): ?>
                    <li class="nav-item">
                        <a href="<?= $link ?>" class="nav-link">
                            <?= $name ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </nav>

</body>
<section class="container py-5">

    <h1 class="h2 semi-bold-600 text-center pt-3">Pricing for lesson</h1>
    <p class="text-center pb-3 light-300">
        You can join to us
        <!-- <a rel="nofollow"
            href="https://bootstraptema.ru/index/kupit_shablony_bootstrap/0-6" target="_blank">buy templates</a>              in one
        file in large quantities. -->
    </p>

    <div class="row d-flex align-items-center pb-3">

        <div class="col-lg-6 offset-lg-0 col-md-8 offset-md-2">
            <img class="rounded float-right"
                src="https://bootstraptema.ru/snippets/price/2021/horizontal-section-pricing.svg">
        </div>

        <div class="col-lg-6">

            <!-- Start Pricing List -->
            <div class="pricing-list shadow-sm rounded-top rounded-3 py-sm-0 py-2">
                <div class="row p-2">
                    <div class="pricing-list-icon col-3 text-center m-auto text-secondary ml-5 py-2">
                        <i class="display-3 bx bx-package"></i>
                    </div>
                    <div class="pricing-list-body col-md-5 align-items-center pl-3 pt-2">
                        <ul class="list-unstyled text-center light-300">
                            <li class="h5 semi-bold-600 mb-0 mt-3">Free</li>
                            <li>To test our offer</li>
                        </ul>
                    </div>
                    <div class="pricing-list-footer col-4 text-center m-auto align-items-center">
                        <p class="btn rounded-pill px-4 btn-primary light-300">0 рублей </p>
                        <!-- <a href="#" class="btn rounded-pill px-4 btn-primary light-300">0₽</a> -->
                    </div>
                </div>
            </div>
            <!-- End Pricing List -->

            <!-- Start Pricing List -->
            <div class="pricing-list shadow-sm py-sm-0 py-5">
                <div class="row p-2">
                    <div class="pricing-list-icon col-3 text-center m-auto text-secondary ml-5 py-5">
                        <i class="display-3 bx bx-package"></i>
                    </div>
                    <div class="pricing-list-body col-md-5 align-items-center pl-3 pt-2">
                        <ul class="list-unstyled text-center light-300">
                            <li class="h5 semi-bold-600 mb-0 mt-3">Group lesson</li>
                            <li>do you want teach with friend</li>
                        </ul>
                    </div>
                    <div class="pricing-list-footer col-sm-4 col-5 text-center m-auto align-items-center">
                        <p class="btn rounded-pill px-4 btn-primary light-300">500 рублей </p>
                    </div>
                </div>
            </div>
            <!-- End Pricing List -->

            <!-- Start Pricing List -->
            <div class="pricing-list shadow-sm rounded-botton rounded-3 py-sm-0 py-5">
                <div class="row p-2">
                    <div class="pricing-list-icon col-sm-3 text-center m-auto text-secondary ml-5 py-2">
                        <i class="display-3 bx bx-package"></i>
                    </div>
                    <div class="pricing-list-body col-md-5 align-items-center pl-3 pt-2">
                        <ul class="list-unstyled text-center light-300">
                            <li class="h5 semi-bold-600 mb-0 mt-3">Personal</li>
                            <li>if you like personal couch</li>
                        </ul>
                    </div>
                    <div class="pricing-list-footer col-sm-4 col-5 text-center m-auto align-items-center">
                        <p class="btn rounded-pill px-4 btn-primary light-300">600 рублей </p>
                    </div>
                </div>
            </div>
            <!-- End Pricing List -->

        </div>
    </div>
</section>