<?php

declare(strict_types = 1);

namespace Controller;

use Framework\Render;
use Service\Order\Basket;
use Service\Order\BasketFacade;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrderController
{
    use Render;

    /**
     * Корзина
     *
     * @param Request $request
     * @return Response
     */
    public function infoAction(Request $request): Response
    {
        if ($request->isMethod(Request::METHOD_POST)) {
            return $this->redirect('order_checkout');
        }
        $basket = new Basket($request->getSession());

        $productList = $basket->getProductsInfo();
        $discount = $basket->getBestDiscount();
        $isLogged = (new Security($request->getSession()))->isLogged();

        return $this->render(
            'order/info.html.php',
            [
                'productList' => $productList,
                'basket' => $basket,
                'isLogged' => $isLogged,
                'discount' => $discount,
            ]
        );
    }

    /**
     * Оформление заказа
     *
     * @param Request $request
     * @return Response
     */
    public function checkoutAction(Request $request): Response
    {
        $session = $request->getSession();
        $isLogged = (new Security($session))->isLogged();
        if (!$isLogged) {
            return $this->redirect('user_authentication');
        }

        $basket = new Basket($session);
        $basketFacade = new BasketFacade($basket, $session);

        $basketFacade->checkout();


        return $this->render('order/checkout.html.php');
    }
}
