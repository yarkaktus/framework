<?php


namespace Service\Product;

use Service\Product\Sorting\ISortStrategy;

class SortContext
{

    /**
     * @var ISortStrategy
     */
    private $strategy;

    public function setStrategy(ISortStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function doSorting(array $data): array
    {
        $strategy = $this->strategy;
        return $strategy->sort($data);
    }
}
