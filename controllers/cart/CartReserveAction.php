<?php

namespace app\controllers\cart;

use app\events\ProductItemAmountChangedEvent;
use app\interfaces\CartProviderInterface;
use Yii;
use yii\base\Action;

class CartReserveAction extends Action
{
    public function run(CartProviderInterface $cartProvider)
    {
        $cart = $cartProvider->cart();
        $cart->reserveCartItems();

        foreach ($cart->items as $cartItem) {
            $cart->trigger(ProductItemAmountChangedEvent::NAME, new ProductItemAmountChangedEvent([
                'productItemId' => $cartItem->product_item_id,
            ]));
        }

        return $this->controller->redirect(Yii::$app->request->referrer ?: ['cart/cart/view']);
    }
}
