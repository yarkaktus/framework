<?php


namespace Service\Order;

use Service\Billing\Card;
use Service\Communication\Email;
use Service\User\Security;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BasketFacade implements IBasketFacade
{
    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var Basket
     */
    private $basket;

    public function __construct(Basket $basket, SessionInterface $session)
    {
        $this->session = $session;
        $this->basket = $basket;
    }

    public function checkout(): void
    {
        $session = $this->session;
        $basket = $this->basket;

        // Здесь должна быть некоторая логика выбора способа платежа
        $billing = new Card();

        // Здесь должна быть некоторая логика получения информации о скидки пользователя
        $discount = $basket->getBestDiscount();

        // Здесь должна быть некоторая логика получения способа уведомления пользователя о покупке
        $communication = new Email();

        $security = new Security($session);

        $basketBuilder = new BasketBuilder();
        $basketBuilder->setBilling($billing);
        $basketBuilder->setCommunication($communication);
        $basketBuilder->setDiscount($discount);
        $basketBuilder->setSecurity($security);
        $basketBuilder->setBasket($basket);

        $orderFacade = new OrderFacade();
        $totalPrice = $orderFacade->checkoutProcess($basketBuilder);
        $basket->setPreviousTotalSum($totalPrice);
    }
}
