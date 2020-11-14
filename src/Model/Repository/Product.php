<?php

declare(strict_types = 1);

namespace Model\Repository;

use Model\Entity;

class Product
{
    /**
     * Поиск продуктов по массиву id
     *
     * @param int[] $ids
     * @return Entity\Product[]
     */
    public function search(array $ids = []): array
    {
        if (!count($ids)) {
            return [];
        }

        $productList = [];
        foreach ($this->getDataFromSource(['id' => $ids]) as $item) {
            $product = new Entity\Product($item['id'], $item['name'], $item['price'], $item['description']);
            $productList[] = clone $product;
        }

        return $productList;
    }

    /**
     * Получаем все продукты
     *
     * @return Entity\Product[]
     */
    public function fetchAll(): array
    {
        $productList = [];
        foreach ($this->getDataFromSource() as $item) {
            $product = new Entity\Product($item['id'], $item['name'], $item['price'], $item['description']);
            $productList[] = clone $product;
        }

        return $productList;
    }

    /**
     * Получаем продукты из источника данных
     *
     * @param array $search
     *
     * @return array
     */
    private function getDataFromSource(array $search = [])
    {
        $dataSource = [
            [
                'id' => 1,
                'name' => 'PHP',
                'price' => 15300,
                'description' => 'интересный курс',
            ],
            [
                'id' => 2,
                'name' => 'Python',
                'price' => 20400,
                'description' => 'классный курс',
            ],
            [
                'id' => 3,
                'name' => 'C#',
                'price' => 30100,
                'description' => 'сложный курс',
            ],
            [
                'id' => 4,
                'name' => 'Java',
                'price' => 30600,
                'description' => 'дорогущий курс',
            ],
            [
                'id' => 5,
                'name' => 'Ruby',
                'price' => 18600,
                'description' => 'устаревший курс',
            ],
            [
                'id' => 8,
                'name' => 'Delphi',
                'price' => 8400,
                'description' => 'давным давно устаревший курс',
            ],
            [
                'id' => 9,
                'name' => 'C++',
                'price' => 19300,
                'description' => 'курс от динозавров',
            ],
            [
                'id' => 10,
                'name' => 'C',
                'price' => 12800,
                'description' => 'курс от дедушек динозавров',
            ],
            [
                'id' => 11,
                'name' => 'Lua',
                'price' => 5000,
                'description' => 'интересный курс',
            ],
            [
                'id' => 12,
                'name' => 'Rust',
                'price' => 15000,
                'description' => 'ржавый курс',
            ],
        ];

        if (!count($search)) {
            return $dataSource;
        }

        $productFilter = function (array $dataSource) use ($search): bool {
            return in_array($dataSource[key($search)], current($search), true);
        };

        return array_filter($dataSource, $productFilter);
    }
}
