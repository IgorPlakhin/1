<?php
require_once __DIR__ . '/../boot.php'; // тут session_start() и check_auth()

// Проверка авторизации: тест только для залогиненных
if (!check_auth()) {
    header('Location: ../login.php');
    exit;
}

// Получаем данные пользователя (чтобы сохранить username)
$stmt = pdo()->prepare("SELECT * FROM users WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // Если пользователь вдруг не найден — выходим
    session_destroy();
    header('Location: ../login.php');
    exit;
}

// Массив вопросов для теста
$questions = [


    ['type' => 'radio', 'question' => 'How old are you?', 'options' => ['I have 16', 'I am 16', 'I have 16 years', 'I am 16 years'], 'correct_answer' => 'I am 16'],
    ['type' => 'radio', 'question' => 'Are you having a nice time?', 'options' => ['Yes, I’m nice', 'Yes, I’m having it', 'Yes, I am', 'Yes, it is'], 'correct_answer' => 'Yes, I am'],
    ['type' => 'radio', 'question' => 'Could you pass the salt please?', 'options' => ['a Over there', 'b I don’t know', 'c Help yourself', 'd Here you are'], 'correct_answer' => 'Here you are'],
    ['type' => 'radio', 'question' => 'Yesterday I went __________ bus to the National Museum', 'options' => ['on', 'in', 'c by', 'd with'], 'correct_answer' => 'c by'],
    ['type' => 'radio', 'question' => 'Sue and Mike __________ to go camping', 'options' => ['wanted', 'said', 'c made', 'd talked'], 'correct_answer' => 'wanted'],
    ['type' => 'radio', 'question' => 'Who’s calling, please', 'options' => ['Just a moment', 'It’s David Parker', 'I’ll call you back', 'Speaking'], 'correct_answer' => 'It’s David Parker'],
    ['type' => 'radio', 'question' => 'They were __________ after the long journey, so they went to bed', 'options' => ['hungry', 'hot ', 'lazy', 'tired'], 'correct_answer' => 'tired'],
    ['type' => 'radio', 'question' => 'Can you tell me the __________ to the bus station?', 'options' => ['road', 'way', 'direction', 'treet'], 'correct_answer' => 'way'],
    ['type' => 'radio', 'question' => '__________ you remember to buy some milk?', 'options' => ['Have', 'Do', 'Should', 'Did'], 'correct_answer' => 'Did'],
    ['type' => 'radio', 'question' => '- Don’t forget to put the rubbish out.- I’ve __________ done it', 'options' => ['yet', 'still', 'already', 'even'], 'correct_answer' => 'already'],
    ['type' => 'radio', 'question' => 'You don’t need to bring __________ to eat', 'options' => ['some', 'a food', 'c many', 'd anything'], 'correct_answer' => 'd anything'],
    ['type' => 'radio', 'question' => 'What about going to the cinema?', 'options' => ['Good idea!', 'Twice a month', 'It’s Star Wars', 'I think so'], 'correct_answer' => 'Good idea!'],
    ['type' => 'radio', 'question' => '- What would you like, Sue?- I’d like the same __________ Michael please.', 'options' => ['that', 'as', 'for', 'had'], 'correct_answer' => 'as'],
    ['type' => 'radio', 'question' => '__________ people know the answer to that question.', 'options' => ['Few', 'Little', 'Least', 'A little'], 'correct_answer' => 'Few'],
    ['type' => 'radio', 'question' => 'It’s not __________ to walk home by yourself in the dark', 'options' => ['sure', 'certain', 'safe', 'problem'], 'correct_answer' => 'safe'],
    ['type' => 'radio', 'question' => '__________ sure all the windows are locked', 'options' => ['Take', 'Have', 'Wait', 'Make'], 'correct_answer' => 'Make'],
    ['type' => 'radio', 'question' => 'I’ll go and __________ if I can find him', 'options' => ['see', 'look', 'try', 'tell'], 'correct_answer' => 'see'],
    ['type' => 'radio', 'question' => 'What’s the difference __________ football and rugby?', 'options' => ['from', 'with', 'for', 'between'], 'correct_answer' => 'between'],
    ['type' => 'radio', 'question' => 'My car needs __________', 'options' => ['repairing', 'to repair', 'to be repair', 'repair'], 'correct_answer' => 'repairing'],
    ['type' => 'radio', 'question' => 'Tim was too __________ to ask Monika for a dance.', 'options' => ['worried', 'shy', 'selfish', 'polite'], 'correct_answer' => 'shy'],
    ['type' => 'radio', 'question' => 'I haven’t had so much fun __________ I was a young boy!', 'options' => ['A when', 'B for', 'C during', 'D since'], 'correct_answer' => 'since'],
    ['type' => 'radio', 'question' => 'Sorry, I don’t know __________ you’re talking about.', 'options' => ['that', 'what', 'which', 'why'], 'correct_answer' => 'what'],
    ['type' => 'radio', 'question' => 'I’m afraid you __________ smoke in here.', 'options' => ['could not', 'don’t have to', ' are not allowed to', 'can’t be'], 'correct_answer' => 'are not allowed to'],
    ['type' => 'radio', 'question' => 'Everyone wanted to go out __________ John', 'options' => ['apart', 'unless', 'howeve', 'except'], 'correct_answer' => 'except'],
    ['type' => 'radio', 'question' => 'Honestly! I saw a ghost! I’m not __________ it up!', 'options' => ['having', 'laughing', 'making', 'joking'], 'correct_answer' => 'making'], //25
    ['type' => 'radio', 'question' => 'Eat everything up! I don’t want to see anything __________ on your plate!', 'options' => ['left', 'missing', 'put', 'staying'], 'correct_answer' => 'left'],
    ['type' => 'radio', 'question' => 'Take the A20 __________ the roundabout, then turn left.', 'options' => ['right', 'as far as', 'along', 'heading north'], 'correct_answer' => 'as far as'],
    ['type' => 'radio', 'question' => 'I really hope you can find a __________ to this problem', 'options' => ['result ', 'way', 'conclusion', 'solution'], 'correct_answer' => 'solution'],
    ['type' => 'radio', 'question' => 'Could you watch my bag while I go and get a cup of tea?', 'options' => ['Of course!', 'Never mind', 'If you don’t mind.', 'It doesn’t matter'], 'correct_answer' => 'Of course!'],
    ['type' => 'radio', 'question' => 'In my country, it is __________ the law to watch an X-rated film if you are under eighteen', 'options' => ['under', 'against', 'over', 'beyond'], 'correct_answer' => 'against'],
    ['type' => 'radio', 'question' => 'Rebecca had to __________ the invitation, as she was busy studying for her exams.', 'options' => ['A take off ', 'B put back', 'C turn down', 'D get away'], 'correct_answer' => 'turn down'],
    ['type' => 'radio', 'question' => 'Police __________ that a terrorist group might be behind the kidnapping', 'options' => ['A suppose', ' B fancy', 'C suspect', 'D accuse'], 'correct_answer' => 'suspect'],
    ['type' => 'radio', 'question' => 'When Christopher smiles, he __________ me of his grandfather.', 'options' => ['A remembers', 'B recalls', 'C rethinks', 'D reminds'], 'correct_answer' => 'reminds'],
    ['type' => 'radio', 'question' => 'The wonderful smell of freshly __________ coffee hit us as we entered the store.', 'options' => ['A crushed', 'B smashed', 'C ground', 'D pressed'], 'correct_answer' => 'ground'],
    ['type' => 'radio', 'question' => 'Mike’s dad wouldn’t __________ him go to school with a red streak in his hair.', 'options' => ['A allow', 'B permit', 'C accept', 'D let'], 'correct_answer' => 'let'],
    ['type' => 'radio', 'question' => 'If only I __________ made that phone call!', 'options' => ['A wasn’t', 'B didn’t', 'C hadn’t', 'D haven’t'], 'correct_answer' => 'hadn’t'],
    ['type' => 'radio', 'question' => 'I like Mary for her friendly smile and her __________ of humour', 'options' => ['A sense', 'b manner', 'C way', 'D impression'], 'correct_answer' => 'sense'],
    ['type' => 'radio', 'question' => 'These shoes are very __________ for walking in the mountains', 'options' => ['A practical', 'B functional', 'C realistic', 'D active'], 'correct_answer' => 'practical'],
    ['type' => 'radio', 'question' => '__________ of the credit for our success has to go to the Chairman, Peter Lewis', 'options' => ['A Several', 'B Much', 'C Enough', 'D Sufficient'], 'correct_answer' => 'Much'],
    ['type' => 'radio', 'question' => 'We were surprised that over 500 people __________ for the job.', 'options' => ['A wrote', 'B applied', 'C enquired', 'D requested'], 'correct_answer' => 'applied'], //40
    ['type' => 'radio', 'question' => 'The children watched in excitement as she __________ a match and lit the candles.', 'options' => ['A scratched', 'B struck', 'C rubbed', 'D scraped'], 'correct_answer' => 'struck'],
    ['type' => 'radio', 'question' => 'Sorry about Kate’s strange behaviour, but she’s just not used to __________ lots of people around her', 'options' => ['A had', 'B have', ' C having', 'D has'], 'correct_answer' => 'having'],
    ['type' => 'radio', 'question' => 'Ivan kept running very hard __________ none of the other runners could possibly catch him', 'options' => ['A even though', 'B however', 'C despite', 'D as'], 'correct_answer' => 'A even though'],
    ['type' => 'radio', 'question' => '‘I did this painting all __________ my own, Dad,’ said Milly.', 'options' => ['by', 'with', 'for', 'on'], 'correct_answer' => 'on'],
    ['type' => 'radio', 'question' => 'You __________ better check all the details are correct before we send it off.', 'options' => ['A would', 'B had', 'C should', 'D did'], 'correct_answer' => 'had'],
    ['type' => 'radio', 'question' => 'This game is __________ to be for five year-olds, but I think a two year-old could do it!', 'options' => ['A expected', 'B required', 'C obliged', 'D supposed'], 'correct_answer' => 'supposed'],
    ['type' => 'radio', 'question' => 'Just put this powder down, and it should __________ any more ants from getting in', 'options' => ['A prevent', 'B avoid', 'C refuse ', 'D forbid'], 'correct_answer' => 'prevent'],
    ['type' => 'radio', 'question' => 'When Jonie __________ to do something, you can be sure she’ll do it, and do it well.', 'options' => ['A gets on', 'B takes up', 'C sets out', 'D brings about'], 'correct_answer' => 'sets out'],
    ['type' => 'radio', 'question' => '__________ we get to the top of this hill, the path gets much easier.', 'options' => ['A At the time', 'B Eventually', 'C Once', 'D Finally'], 'correct_answer' => 'Once'],
    ['type' => 'radio', 'question' => 'Fifty-seven? No, that __________ be the right answer!', 'options' => ['A can’t', 'B mustn’t', 'C wouldn’t ', 'D needn’t'], 'correct_answer' => 'can’t'], //50
    ['type' => 'radio', 'question' => '__________ happens, I’ll always be there for you!', 'options' => ['A However', 'B What', 'C Whatever', 'D No matter'], 'correct_answer' => 'Whatever'],
    ['type' => 'radio', 'question' => 'Can you __________ to it that no one uses this entrance?', 'options' => ['A see', 'B deal', 'C ensure', 'get'], 'correct_answer' => 'see'],
    ['type' => 'radio', 'question' => 'A __________ debate ensued, with neither side prepared to give way to the other', 'options' => ['A warm', 'B heated ', 'C hot', 'D boiling'], 'correct_answer' => 'heated'],
    ['type' => 'radio', 'question' => 'I’ve drunk milk every __________ day of my life, and it’s never done me any harm!', 'options' => ['A particular', 'B individual', 'C single', 'D one'], 'correct_answer' => 'single'],
    ['type' => 'radio', 'question' => 'The version of the film I saw had been __________ censored', 'options' => ['A strongly', 'B deeply', 'C great', 'D heavily'], 'correct_answer' => 'heavily'],
    ['type' => 'radio', 'question' => 'He promised to phone me at nine o’clock exactly, and he was as __________ as his word', 'options' => ['A true', 'B good', ' C right', 'D honest'], 'correct_answer' => 'good'],
    ['type' => 'radio', 'question' => 'There has been so much media __________ of the wedding that I’m completely fed up with it', 'options' => ['A circulation', 'B attention', 'C broadcasting', 'D coverage'], 'correct_answer' => 'coverage'],
    ['type' => 'radio', 'question' => 'If I were you I would __________ clear of the area around the station late at night', 'options' => ['A stick', ' B steer', 'C stop', 'D stand'], 'correct_answer' => 'steer'],
    ['type' => 'radio', 'question' => 'Turning back now is out of the __________ .', 'options' => ['A agenda', 'B matter', 'C questions', 'D possibility'], 'correct_answer' => 'questions'],
    ['type' => 'radio', 'question' => 'Joe’s fear of enclosed spaces __________ from a bad experience he had when he was a child.', 'options' => ['A stems', 'B leads', 'C starts', 'D flows'], 'correct_answer' => 'stems']
];


// Инициализация переменных сессии при первом запуске
if (!isset($_SESSION['question_index'])) {
    $_SESSION['question_index'] = 0;
}
if (!isset($_SESSION['correct_answers'])) {
    $_SESSION['correct_answers'] = 0;
}
if (!isset($_SESSION['incorrect_answers'])) {
    $_SESSION['incorrect_answers'] = 0;
}
// unset($_SESSION['question_index'], $_SESSION['correct_answers'], $_SESSION['incorrect_answers']);
$current_question_index = $_SESSION['question_index'];

// Обработка отправки ответа
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_answer'])) {
    $user_answer = $_POST['user_answer'];
    $correct_answer = $questions[$current_question_index]['correct_answer'];

    if ($user_answer === $correct_answer) {
        $_SESSION['correct_answers']++;
    } else {
        $_SESSION['incorrect_answers']++;
    }

    $_SESSION['question_index']++;

    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Обработка сброса теста
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset'])) {
    unset($_SESSION['question_index'], $_SESSION['correct_answers'], $_SESSION['incorrect_answers']);
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}


// Если тест завершён — сохраняем результат в JSON
if ($current_question_index >= count($questions)) {
    // Сначала сохраняем значения в локальные переменные
    $correct = (int) $_SESSION['correct_answers'];
    $incorrect = (int) $_SESSION['incorrect_answers'];
    $total = $correct + $incorrect;
    $percent = $total > 0 ? round(($correct / $total) * 100, 2) : 0;
    $level = ['elementary language Practice', 'Intermediate language Practice', 'First Certificate', 'Advanced language Practice'];
    $current_level = '';

    switch (true) {
        case $correct <= 15:
            $current_level = $level[0];
            break;
        case $correct > 15 && $correct <= 30:
            $current_level = $level[1];
            break;
        case $correct > 30 && $correct <= 45:
            $current_level = $level[2];
            break;
        case $correct > 45 && $correct <= 60:
            $current_level = $level[3];
            break;
        default:
            $current_level = 'Неизвестный уровень'; // лучше не echo, а присвоить
            break;

    }


    //1-15 elementary language Practice
// 16-30 Intermediate 
// 31-45 First Certificate
//46-60 Advanced

    // Путь к файлу результатов (на уровень выше от test2.php)
    $file = dirname(__DIR__) . '/results.json';

    $contents = @file_get_contents($file);
    $data = ($contents !== false) ? json_decode($contents, true) : [];

    if (json_last_error() !== JSON_ERROR_NONE || !is_array($data)) {
        $data = [];
    }

    // Добавляем результат
    $result = [
        'user_id' => (int) $_SESSION['user_id'],
        'username' => $user['username'] ?? 'Unknown',
        'correct_answers' => $correct,
        'incorrect_answers' => $incorrect,
        'total_questions' => $total,
        'score_percent' => (float) $percent,
        'level' => $current_level,
        'created_at' => date('Y-m-d H:i:s'),
    ];
    $data[] = $result;

    // Атомарная запись: пишем во временный файл, потом переименовываем
    $tmpFile = $file . '.tmp';
    file_put_contents($tmpFile, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    rename($tmpFile, $file);

    // Сбрасываем сессию ТОЛЬКО ПОСЛЕ того, как взяли нужные значения
    unset($_SESSION['question_index'], $_SESSION['correct_answers'], $_SESSION['incorrect_answers']);

    $_SESSION['test_finished'] = true;
} else {
    // Если тест ещё не завершён, инициализируем переменные, чтобы в HTML они точно были
    $correct = (int) ($_SESSION['correct_answers'] ?? 0);
    $incorrect = (int) ($_SESSION['incorrect_answers'] ?? 0);
    $percent = 0;
    $current_level = '';
}

$current_question = $questions[$current_question_index] ?? null;
$total_questions = count($questions);
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
    $menu = [
        'Home' => '../index.php',
        'Results' => '../pages/result.php', // ссылка на общий рейтинг
        'About' => '../pages/about.php',
    ];
    ?>
    <nav class="nav nav-pills mb-4">
        <?php foreach ($menu as $name => $link): ?>
            <li class="nav-item">
                <a href="<?= htmlspecialchars($link) ?>" class="nav-link"><?= htmlspecialchars($name) ?></a>
            </li>
        <?php endforeach; ?>
    </nav>

    <div class="container">
        <h1 class="mb-4 text-center">Тест</h1>

        <?php if ($current_question): ?>
            <form method="post">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4><?= ($current_question_index + 1) . '. ' . htmlspecialchars($current_question['question']) ?>
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php if ($current_question['type'] === 'radio'): ?>
                            <?php foreach ($current_question['options'] as $option): ?>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="user_answer" id="opt_<?= md5($option) ?>"
                                        value="<?= htmlspecialchars($option) ?>" required>
                                    <label class="form-check-label" for="opt_<?= md5($option) ?>">
                                        <?= htmlspecialchars($option) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Ответить</button>
                    <button type="submit" name="reset" class="btn btn-secondary">Сбросить тест</button>
                </div>
            </form>
        <?php else: ?>
            <!-- Тест завершён -->
            <div class="alert alert-success text-center" role="alert">
                Тест завершён!
                <br>
                Правильных: <?= htmlspecialchars((string) $correct) ?>
                <br>
                Неправильных: <?= htmlspecialchars((string) $incorrect) ?>
                <br>
                Процент: <?= htmlspecialchars((string) $percent) ?>%
                <?php if ($current_level): ?>
                    <br>
                    Уровень: <?= htmlspecialchars($current_level) ?>
                <?php endif; ?>
            </div>
            <div class="text-center mt-3">
                <a href='../pages/result.php' class="btn btn-primary">Посмотреть общий рейтинг</a>
                <form method="post" style="display:inline;">
                    <button type="submit" name="reset" class="btn btn-secondary">Начать заново</button>
                </form>
            </div>
        <?php endif; ?>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>