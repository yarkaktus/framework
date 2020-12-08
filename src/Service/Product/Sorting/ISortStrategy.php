<?php


namespace Service\Product\Sorting;

interface ISortStrategy
{
    public function sort(array $data): array;
}
