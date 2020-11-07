<?php

/** @var \Model\Entity\User $user */

$body = function () use ($user, $path) {
    ?>

    <h1>Мой профиль</h1>

    <div>Имя: <?= $user->getId() ?> </div>
    <div>Логин: <?= $user->getLogin() ?></div>
    <div>Дата рождения: <?= $user->getBirthday() ?></div>
    <div>Роль: <?= $user->getRole()->getTitle() ?></div>

    <h4>последний заказ был совершен на сумму: скока ?</h4>



    <?php
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Мой профиль',
        'body' => $body,
    ]
);
