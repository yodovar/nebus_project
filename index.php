<?php

define("ROOT", dirname(__FILE__));
include_once ROOT."/router/router.php";
// include_once ROOT."/functions.php";

$router = new Router();
$router->run();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Страница для вывода информации</title>
    <link rel="stylesheet" href="/nebus_project/views/css/index.css">
</head>
<body>

<header>
    <h1>Инструкция</h1>
</header>

<main>
    <section class="info-section">
        <h2>База Данных</h2>
        <p>Создайте БД Nebus</p>
        <p>Импортируйте страницу "init.sql"</p>
    </section>

    <section class="info-section">
        <h2>В URL Дополните  /poduct </h2>
        <p>Это работа роутера</p>
    </section>

    <section class="info-section">
        <h2>Выберите Раздел в product</h2>
        <p> после того как вы выбрали раздел вы можете его поисковом input - е Поискать то что хотите найти в этом разделе</p>
        <ul>
            <li>Начил проект в 14 : 00</li>
            <li>Закончил в 22 : 30 2</li>
            <li>Использовал GPT как инструмента </li>
        </ul>
    </section>

    <section class="info-section">
        <h2>информация</h2>
        <p>Я знаю что мой уровень Junior но я могу дать быстрых результатов</p>
        <p>Я готов решать любые задачи </p>
        <p>Я хочу работать и одно времена развиваться и хочу работать в этом компании много лет!</p>
    </section>
</main>

<footer>
    <p>Все права защищены &copy; 2025</p>
</footer>

</body>
</html>