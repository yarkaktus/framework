<?php

/** @var \Model\Entity\User $user */
/** @var \Service\Order\Basket $basket */

$body = function () use ($user, $basket, $path) {
    ?>

    <h1>Мой профиль</h1>
    <div style="text-align: left; padding-left: 50px">
        <div>ID: <?= $user->getId() ?> </div>
        <div>Имя: <?= $user->getName() ?> </div>
        <div>Логин: <?= $user->getLogin() ?></div>
        <div>Дата рождения: <?= $user->getBirthday() ?></div>
        <div>Роль: <?= $user->getRole()->getTitle() ?></div>
    </div>

    <h4>последний заказ был совершен на сумму: <?= $basket->getPreviousTotalSum() ?>  </h4>


    <?php
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Мой профиль',
        'body' => $body,
    ]
);
