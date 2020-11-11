<?php

declare(strict_types = 1);

namespace Service\Order;

use Model;
use Service\Billing\Card;
use Service\Billing\IBilling;
use Service\Communication\Email;
use Service\Communication\ICommunication;
use Service\Discount\BirthdayDiscount;
use Service\Discount\BigSumDiscount;
use Service\Discount\DelphiDiscount;
use Service\Discount\IDiscount;
use Service\Discount\NullObject;
use Service\User\ISecurity;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Basket
{
    /**
     * Сессионный ключ списка всех продуктов корзины
     */
    private const BASKET_DATA_KEY = 'basket';
    private const PREVIOUS_BASKET_SUM_KEY = 'previous_basket_sum';

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Добавляем товар в заказ
     *
     * @param int $product
     *
     * @return void
     */
    public function addProduct(int $product): void
    {
        $basket = $this->session->get(static::BASKET_DATA_KEY, []);
        if (!in_array($product, $basket, true)) {
            $basket[] = $product;
            $this->session->set(static::BASKET_DATA_KEY, $basket);
        }
    }

    /**
     * Проверяем, лежит ли продукт в корзине или нет
     *
     * @param int $productId
     *
     * @return bool
     */
    public function isProductInBasket(int $productId): bool
    {
        return in_array($productId, $this->getProductIds(), true);
    }

    /**
     * Получаем информацию по всем продуктам в корзине
     *
     * @return Model\Entity\Product[]
     */
    public function getProductsInfo(): array
    {
        $productIds = $this->getProductIds();
        return $this->getProductRepository()->search($productIds);
    }

    /**
     * Получаем информацию по текущей цене
     *
     * @return float
     */
    public function getTotalProductSum(): float
    {
        $products = $this->getProductsInfo();
        $totalSum = 0;
        foreach ($products as $product){
            $totalSum += $product->getPrice();
        }
        return $totalSum;
    }

    public function getTotalSumWithDiscount(): float
    {
        $totalSum = $this->getTotalProductSum();
        $discount = $this -> getBestDiscount();

        $totalSum = $totalSum - $totalSum / 100 * $discount->getDiscount();

        return $totalSum;
    }

    public function getPreviousTotalSum(): float
    {
        $previousSum = $this->session->get(static::PREVIOUS_BASKET_SUM_KEY, 0);
        return $previousSum;
    }

    public function getBestDiscount(): IDiscount
    {
        $security = new Security($this->session);
        $user = $security->getUser();

        $bestDiscount = new NullObject();
        $maxDiscountValue = 0;

        $discounts = [DelphiDiscount::class, BirthdayDiscount::class, BigSumDiscount::class];
        foreach ($discounts as $discount){
            $currentDiscount = new $discount($user, $this);
            $currentDiscountValue = $currentDiscount->getDiscount();

            if ($currentDiscountValue > $maxDiscountValue ){
                $bestDiscount = $currentDiscount;
            }
        }

        return $bestDiscount;
    }

    /**
     * Оформление заказа
     *
     * @return void
     */
    public function checkout(): void
    {
        // Здесь должна быть некоторая логика выбора способа платежа
        $billing = new Card();

        // Здесь должна быть некоторая логика получения информации о скидки пользователя
        $discount = $this -> getBestDiscount();

        // Здесь должна быть некоторая логика получения способа уведомления пользователя о покупке
        $communication = new Email();

        $security = new Security($this->session);

        $this->checkoutProcess($discount, $billing, $security, $communication);
    }

    /**
     * Проведение всех этапов заказа
     *
     * @param IDiscount $discount,
     * @param IBilling $billing,
     * @param ISecurity $security,
     * @param ICommunication $communication
     * @return void
     */
    public function checkoutProcess(
        IDiscount $discount,
        IBilling $billing,
        ISecurity $security,
        ICommunication $communication
    ): void {
        $totalPrice = 0;
        foreach ($this->getProductsInfo() as $product) {
            $totalPrice += $product->getPrice();
        }

        $discount = $discount->getDiscount();
        $totalPrice = $totalPrice - $totalPrice / 100 * $discount;

        $billing->pay($totalPrice);
        $this->session->set(static::PREVIOUS_BASKET_SUM_KEY, $totalPrice);


        $user = $security->getUser();
        $communication->process($user, 'checkout_template');
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

    /**
     * Получаем список id товаров корзины
     *
     * @return array
     */
    private function getProductIds(): array
    {
        return $this->session->get(static::BASKET_DATA_KEY, []);
    }
}
