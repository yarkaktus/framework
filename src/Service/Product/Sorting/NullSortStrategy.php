<?php


namespace Service\Product\Sorting;

class NullSortStrategy implements ISortStrategy
{
    public function sort(array $data): array
    {
        return $data;
    }
}
