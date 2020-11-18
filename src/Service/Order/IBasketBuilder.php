<?php


namespace Service\Order;

use Service\Billing\IBilling;
use Service\Communication\ICommunication;
use Service\Discount\IDiscount;
use Service\User\ISecurity;

interface IBasketBuilder
{
    public function setBilling(IBilling $billing);

    public function getBilling(): ?IBilling;

    public function setDiscount(IDiscount $discount);

    public function getDiscount(): ?IDiscount;

    public function setCommunication(ICommunication $communication);

    public function getCommunication(): ?ICommunication;

    public function setSecurity(ISecurity $security);

    public function getSecurity(): ?ISecurity;

    public function setBasket(Basket $basket);

    public function getBasket(): ?Basket;
}
