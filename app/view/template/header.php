<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $_POST['kitWords']['title']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="shortcut icon" href="app/public/images/site-images/start-foto.png" type="image/png">
    <link rel="stylesheet" href="app/public/css/style.css">
    <link rel="stylesheet" href="app/public/css/media.css">
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
    <script defer src="app/public/js/script.js"></script>
    <script defer src="app/public/js/language.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">

<div class="bg-dark">
    <h2 class="text-white text-center py-3" id="header"><?= $_POST['kitWords']['wrapper']['header']; ?></h2>
    <form action="/search" method="POST" id="language" class="container">
        <select onchange="setLanguage(this.value);">
            <option <?php if ($_COOKIE['language'] == 'en') { ?>selected<?php } ?> value="en">EN</option>
            <option <?php if ($_COOKIE['language'] == 'ru') { ?>selected<?php } ?> value="ru">RU</option>
        </select>
    </form>
</div>

<div class="container wrapper flex-grow-1">
