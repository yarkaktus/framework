<?php

declare(strict_types=1);

namespace Service\Order;

interface IOrderFacade
{
    public function checkoutProcess(IBasketBuilder $basketBuilder): float;
}
