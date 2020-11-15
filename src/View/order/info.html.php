<?php

/** @var \Model\Entity\Product[] $productList */
/** @var bool $isLogged */
/** @var \Service\Order\Basket $basket */
/** @var \Service\Discount\IDiscount $discount */
/** @var \Closure $path */


$body = function () use ($productList, $isLogged, $discount, $basket, $path) {
    ?>
    <form method="post">
        <table cellpadding="10">
            <tr>
                <td colspan="3" align="center">Корзина</td>
            </tr>
<?php
    $n = 1;
    foreach ($productList as $product) {
        ?>
            <tr>
                <td><?= $n++ ?>.</td>
                <td><?= $product->getName() ?></td>
                <td><?= $product->getPrice() ?> руб</td>
                <td><input type="button" value="Удалить" /></td>
            </tr>
<?php
    } ?>
            <tr>
                <td colspan="3" align="right">Итого: <?= $basket->getTotalSumWithDiscount() ?> рублей</td>
            </tr>
    <?php if ($discount->getDiscountValue()): ?>
        <tr>
            <td colspan="3" align="right">С учетом скидки в  <?= $discount->getDiscountValue() ?>% </td>
        </tr>
    <?php endif; ?>


            <?php if ($basket->getTotalSumWithDiscount() > 0) {
        if ($isLogged) {
            ?>
            <tr>
                <td colspan="3" align="center"><input type="submit" value="Оформить заказ" /></td>
            </tr>
<?php
        } else {
            ?>
            <tr>
                <td colspan="4" align="center">Для оформления заказа, <a href="<?= $path('user_authentication') ?>">авторизуйтесь</a></td>
            </tr>
<?php
        }
    } ?>
        </table>
    </form>
<?php
};

$renderLayout(
    'main_template.html.php',
    [
        'title' => 'Корзина',
        'body' => $body,
    ]
);
