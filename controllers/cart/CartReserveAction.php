<?php

namespace app\controllers\cart;

use app\interfaces\CartProviderInterface;
use Yii;
use yii\base\Action;

class CartReserveAction extends Action
{
    public function run(CartProviderInterface $cartProvider)
    {
        $cartProvider->cart()->reserveCartItems();
        return $this->controller->redirect(Yii::$app->request->referrer ?: ['cart/cart/view']);
    }
}
