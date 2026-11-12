
<!-- READ ME -->
<!-- --это тест сделан в формате 3-х уровней, если правильно отвечаешь, то переходишь на более высокий уровень и  наоборот. -->
<?php
session_start();

$questions_easy = [
    ['difficult' => 0, 'type' => 'radio', 'question' => 'Скажите, как его зовут?', 'options' => ['Буратино', 'Геннадий', 'Дуремар'], 'correct_answer' => 'Буратино'],
    ['difficult' => 0, 'type' => 'radio', 'question' => 'Назовите интеллектуальный статус сверчка.', 'options' => ['мудрый', 'хитроумный', 'дуремар'], 'correct_answer' => 'мудрый'],
    ['difficult' => 0, 'type' => 'radio', 'question' => 'Какой статус у Мальвины?', 'options' => ['невеста Пьеро', 'актриса театра', 'девочка с голубыми'], 'correct_answer' => 'невеста Пьеро'],
    ['difficult' => 0, 'type' => 'radio', 'question' => 'Где Буратино заказал три корочки хлеба?', 'options' => ['в доставке', 'в харчевне', 'на ужине у Мальвины'], 'correct_answer' => 'в харчевне'],
];
$questions_avg = [
    ['difficult' => 1, 'type' => 'radio', 'question' => 'У кого коробок-боробок?', 'options' => ['Дуремар', 'Буратино', 'Карабас-Барабас'], 'correct_answer' => 'Карабас-Барабас'],
    ['difficult' => 1, 'type' => 'radio', 'question' => 'Кто играл Дуремара?', 'options' => ['Басов', 'Этуш', 'Мальвина по понедельникам'], 'correct_answer' => 'Басов'],
];
$questions_hard = [
    ['difficult' => 2, 'type' => 'radio', 'question' => 'Кто играл Карабаса-Барабаса?', 'options' => ['Барабас', 'Артемон до стрижки', 'Этуш'], 'correct_answer' => 'Этуш'],
    ['difficult' => 2, 'type' => 'radio', 'question' => 'Кто играл Дуремара?', 'options' => ['Басов', 'ведущий Малахов', 'Этуш'], 'correct_answer' => 'Басов'],
    ['difficult' => 2, 'type' => 'radio', 'question' => 'Куда Буратино дел золотые монеты?', 'options' => ['зарыл', 'купил пиявок', 'потратил с Пьерро'], 'correct_answer' => 'зарыл'],
    ['difficult' => 2, 'type' => 'radio', 'question' => 'Что помешало Буратино утонуть в болоте?', 'options' => ['1-й разряд по плаванью', 'черпаха Тортила', 'свойства материала'], 'correct_answer' => 'свойства материала'],
];

$all_levels = [0 => $questions_easy, 1 => $questions_avg, 2 => $questions_hard];
$max_difficulty = 2;
$counter_names = ['n_easy', 'n_avg', 'n_hard'];

foreach (['difficulty', 'n_easy', 'n_avg', 'n_hard'] as $k) {
    if (!isset($_SESSION[$k]))
        $_SESSION[$k] = 0;
}

if (isset($_POST['reset'])) {
    unset($_SESSION['difficulty'], $_SESSION['n_easy'], $_SESSION['n_avg'], $_SESSION['n_hard']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['reset'])) {
    $ans = $_POST['user_answer'] ?? '';
    $qi = (int) ($_POST['current_question_index'] ?? 0);
    $dif = (int) ($_POST['current_difficulty'] ?? 0);
    $arr = $all_levels[$dif] ?? [];

    if (isset($arr[$qi])) {
        $correct = $arr[$qi]['correct_answer'];
        $cv = $counter_names[$dif];
        if ($ans === $correct) {
            $_SESSION[$cv] = $qi + 1; // фиксируем пройденный вопрос
            if ($_SESSION['difficulty'] < $max_difficulty) {
                $_SESSION['difficulty']++;
                $message = '<div class="alert alert-success">Правильно! Уровень повышен.</div>';
            } else {
                $message = '<div class="alert alert-success">Правильно!</div>';
            }
        } else {
            $message = '<div class="alert alert-danger">Неправильно. Правильный ответ: ' . htmlspecialchars($correct) . '</div>';
            if ($_SESSION['difficulty'] > 0) {
                $_SESSION['difficulty']--;
                $nv = $counter_names[$_SESSION['difficulty']];
                if ($_SESSION[$nv] >= count($all_levels[$_SESSION['difficulty']])) {
                    $_SESSION[$nv] = count($all_levels[$_SESSION['difficulty']]) - 1;
                }
            } else {
                $_SESSION[$cv] = $qi + 1;
            }
        }
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

$difficulty = $_SESSION['difficulty'];
$cv = $counter_names[$difficulty];
$current = $all_levels[$difficulty];
$index = $_SESSION[$cv];
if ($index >= count($current))
    $index = count($current) - 1;
$finished = ($difficulty >= $max_difficulty && $index >= count($current) - 1 && $_SESSION[$cv] >= count($current));
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Тест</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

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
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <?php echo $message; ?>
                        <?php if ($_SESSION[$cv] < count($current)) {
                            $q = $current[$_SESSION[$cv]]; ?>
                            <h3 class="h5 mb-3"><?php echo htmlspecialchars($q['question']); ?></h3>
                            <form method="post">
                                <?php foreach ($q['options'] as $opt): ?>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="user_answer"
                                            value="<?php echo htmlspecialchars($opt); ?>" id="<?php echo md5($opt); ?>"
                                            required>
                                        <label class="form-check-label"
                                            for="<?php echo md5($opt); ?>"><?php echo htmlspecialchars($opt); ?></label>
                                    </div>
                                <?php endforeach; ?>
                                <input type="hidden" name="current_question_index" value="<?php echo $index; ?>">
                                <input type="hidden" name="current_difficulty" value="<?php echo $difficulty; ?>">
                                <button type="submit" class="btn btn-primary w-100 mt-3">Ответить</button>
                            </form>
                        <?php } else { ?>
                            <h2 class="h4">Тест завершён</h2>
                            <ul class="list-group my-3">
                                <li class="list-group-item">Лёгких: <?php echo (int) $_SESSION['n_easy']; ?></li>
                                <li class="list-group-item">Средних: <?php echo (int) $_SESSION['n_avg']; ?></li>
                                <li class="list-group-item">Сложных: <?php echo (int) $_SESSION['n_hard']; ?></li>
                            </ul>
                            <form method="post"><button class="btn btn-outline-primary w-100" name="reset">Пройти
                                    заново</button></form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>