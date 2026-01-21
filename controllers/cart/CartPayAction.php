<?php

namespace app\controllers\cart;

use app\interfaces\CartProviderInterface;
use Yii;
use yii\base\Action;

class CartPayAction extends Action
{
    public function run(CartProviderInterface $cartProvider)
    {
        if ($cartReserved = $cartProvider->cartReserved()) {
            $cartReserved->payCartItems();
        }
        return $this->controller->redirect(Yii::$app->request->referrer ?: ['cart/cart/view']);
    }
}
