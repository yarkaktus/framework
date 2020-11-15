<?php

declare(strict_types = 1);

namespace Service\Discount;

class NullObject implements IDiscount
{
    /**
     * @inheritdoc
     */
    public function getDiscountValue(): float
    {
        // Скидка отсутствует
        return 0;
    }
}
