<?php


namespace Service\Order;

use Service\Billing\IBilling;
use Service\Communication\ICommunication;
use Service\Discount\IDiscount;
use Service\User\ISecurity;

class BasketBuilder implements IBasketBuilder
{
    /**
     * @var IBilling
     */
    private $billing;
    /**
     * @var IDiscount
     */
    private $discount;
    /**
     * @var ICommunication
     */
    private $communication;
    /**
     * @var ISecurity
     */
    private $security;
    /**
     * @var Basket
     */
    private $basket;

    public function setBilling(IBilling $billing)
    {
        $this->billing = $billing;
    }
    public function getBilling(): ?IBilling
    {
        return $this->billing;
    }

    public function setDiscount(IDiscount $discount)
    {
        $this->discount = $discount;
    }
    public function getDiscount(): ?IDiscount
    {
        return $this->discount;
    }

    public function setCommunication(ICommunication $communication)
    {
        $this->communication = $communication;
    }
    public function getCommunication(): ?ICommunication
    {
        return $this->communication;
    }

    public function setSecurity(ISecurity $security)
    {
        $this->security = $security;
    }

    public function getSecurity(): ?ISecurity
    {
        return $this->security;
    }

    public function setBasket(Basket $basket)
    {
        $this->basket = $basket;
    }

    public function getBasket(): ?Basket
    {
        return $this->basket;
    }
}
