<?php


namespace Service\Order;

class OrderFacade implements IOrderFacade
{
    /**
    * //     * Проведение всех этапов заказа
    * //     *
    * //     * @param IBasketBuilder $basketBuilder
    * //     * @return void
    * //
    */
    public function checkoutProcess(
        IBasketBuilder $basketBuilder
    ): float {
        $billing = $basketBuilder->getBilling();
        $basket = $basketBuilder->getBasket();
        $security = $basketBuilder->getSecurity();
        $communication = $basketBuilder->getCommunication();
        $discount = $basketBuilder->getDiscount();

        $totalPrice = $basket->getTotalProductSum();
        $discountValue = $discount->getDiscountValue();
        $totalPrice = $totalPrice - $totalPrice / 100 * $discountValue;

        $billing->pay($totalPrice);


        $user = $security->getUser();
        $communication->process($user, 'checkout_template');

        return $totalPrice;
    }
}
