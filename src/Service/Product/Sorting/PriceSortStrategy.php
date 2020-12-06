<?php


namespace Service\Product\Sorting;

use Model\Entity\Product;

class PriceSortStrategy implements ISortStrategy
{
    public static function cmp(Product $a, Product $b)
    {
        return ($a->getPrice() > $b->getPrice()) ? +1 : -1;
    }

    public static function sort(array $data): array
    {
        usort($data, array(PriceSortStrategy::class, "cmp"));

        return $data;
    }
}
