<?php

/** @var \Model\Entity\Product[] $productList */
$body = function () use ($productList, $path) {
    ?>
    <h1>Наши курсы</h1>


    <table border="5">
        <tr>
            <th>Название курса</th>
            <th>Стоимость</th>
            <th>Описание</th>
        </tr>
        <?php
        foreach ($productList as $key => $product) {
            ?>
            <tr>
                <th>
                    <a href="<?= $path('product_info', ['id' => $product->getId()]) ?>"><?= $product->getName() ?>
                </th>
                <th><?= $product->getPrice() ?> рублей</th>
                <th><?= $product->getDescription() ?></th>
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
