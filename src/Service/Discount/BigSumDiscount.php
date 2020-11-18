<?php

declare(strict_types = 1);

namespace Service\Discount;

use Model;
use Service;

class BigSumDiscount implements IDiscount
{
    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $basket;

    /**
     * @param Model\Entity\User $user
     * @param Service\Order\Basket $basket
     */
    public function __construct(?Model\Entity\User $user, Service\Order\Basket $basket)
    {
        $this->user = $user;
        $this->basket = $basket;
    }

    /**
     * @inheritdoc
     */
    public function getDiscountValue(): float
    {
        $orderSum = 40000;
        $discountValue = 10;

        if ($this->basket->getTotalProductSum() > $orderSum) {
            return $discountValue;
        }
        return 0;
    }
}
