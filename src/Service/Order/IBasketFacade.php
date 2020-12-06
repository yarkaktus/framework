<?php


namespace Service\Order;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

interface IBasketFacade
{
    /**
     * Оформление заказа
     *
     * @return void
     */

    public function checkout(): void;
}
