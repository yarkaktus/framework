<?php


namespace Service\Product\Sorting;

use Model\Entity\Product;

class NameSortStrategy implements ISortStrategy
{
    public static function cmp(Product $a, Product $b)
    {
        return strcmp($a->getName(), $b->getName());
    }

    public static function sort(array $data): array
    {
        usort($data, array(NameSortStrategy::class, "cmp"));

        return $data;
    }
}
