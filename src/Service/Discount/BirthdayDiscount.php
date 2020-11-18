<?php

declare(strict_types = 1);

namespace Service\Discount;

use Model;
use Service;

class BirthdayDiscount implements IDiscount
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
        if (is_null($this->user)) {
            return 0;
        }

        $discountValue = 5;

        $daysBefore = 5;
        $daysAfter = 5;

        $birthday = Date('m.d', strtotime($this->user->getBirthday()));
        $dateLeftRange = Date('m.d', strtotime("-".$daysBefore." days"));
        $dateRightRange = Date('m.d', strtotime("+".$daysAfter." days"));

        if (($dateLeftRange <= $birthday) && ($birthday <= $dateRightRange)) {
            return $discountValue;
        }

        return 0;
    }
}
