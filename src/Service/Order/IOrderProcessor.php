<?php

declare(strict_types=1);

namespace Service\Order;

interface IOrderProcessor
{
    public function checkoutProcess(IBasketBuilder $basketBuilder): float;
}
