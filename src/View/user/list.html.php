<?php

/** @var \Model\Entity\User[] $userList */
$body = function () use ($userList, $path) {
    ?>
    <h1>Список пользователей</h1>


    <table border="5">
        <tr>
            <th>id</th>
            <th>Имя</th>
            <th>Логин</th>
            <th>Роль</th>
        </tr>
        <?php
        foreach ($userList as $key => $user) {
            ?>
            <tr>
                <th><?= $user->getId() ?></th>
                <th><?= $user->getName() ?></th>
                <th><?= $user->getLogin() ?></th>
                <th><?= $user->getRole()->getTitle() ?></th>
            </tr>
            <?php
        } ?>

    </table>
    <?php
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Курсы',
        'body' => $body,
    ]
);
