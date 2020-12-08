<?php

declare(strict_types=1);

namespace Service\Product;

use Model;
use Service\Product\Sorting\NameSortStrategy;
use Service\Product\Sorting\NullSortStrategy;
use Service\Product\Sorting\PriceSortStrategy;

class Product
{
    /**
     * Получаем информацию по конкретному продукту
     *
     * @param int $id
     * @return Model\Entity\Product|null
     */
    public function getInfo(int $id): ?Model\Entity\Product
    {
        $product = $this->getProductRepository()->search([$id]);
        return count($product) ? $product[0] : null;
    }

    /**
     * Получаем все продукты
     *
     * @param string $sortType
     *
     * @return Model\Entity\Product[]
     */
    public function getAll(string $sortType): array
    {
        $productList = $this->getProductRepository()->fetchAll();
        $sortContext = new SortContext();
        $sortContext->setStrategy(new NullSortStrategy());

        if ($sortType === 'price') {
            $sortContext->setStrategy(new PriceSortStrategy());
        } elseif ($sortType === 'name') {
            $sortContext->setStrategy(new NameSortStrategy());
        }

        $productList = $sortContext->doSorting($productList);

        return $productList;
    }

    /**
     * Фабричный метод для репозитория Product
     *
     * @return Model\Repository\Product
     */
    protected function getProductRepository(): Model\Repository\Product
    {
        return new Model\Repository\Product();
    }
}
