<?php

declare(strict_types = 1);

namespace Service\Discount;

use Model;
use Service;

class DelphiDiscount implements IDiscount
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
    public function getDiscount(): float
    {
        $discountValue = 8;
        $products = $this->basket->getProductsInfo();

        foreach ($products as $product){
            if ($product->getName() == 'Delphi'){
                return $discountValue;
            }
        }

        return 0;
    }
}
