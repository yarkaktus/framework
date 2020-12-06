<?php


namespace Service\Product\Sorting;

interface ISortStrategy
{
    public static function sort(array $data): array;
}
