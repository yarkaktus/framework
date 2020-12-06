<?php


namespace Service\Product\Sorting;

class NullSortStrategy implements ISortStrategy
{
    public static function sort(array $data): array
    {
        return $data;
    }
}
