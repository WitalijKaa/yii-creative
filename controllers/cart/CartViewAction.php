<?php

namespace app\controllers\cart;

use app\interfaces\CartProviderInterface;
use app\models\Shop\Product\ProductItem;
use yii\base\Action;

class CartViewAction extends Action
{
    public function run(CartProviderInterface $cartProvider)
    {
        $cartReserved = $cartProvider->cartReserved();
        $cart = $cartProvider->cart();

        if (count($cart->items) === 0 && $cartReserved === null) {
            return $this->controller->redirect(['shop/shop/list']);
        }

        $items = ProductItem::find()
            ->where(['id' => $cart->productsItemsIDs()])
            ->with(['product'])
            ->all();

        $cart->setInCartAmount($items);

        return $this->controller->render('view', [
            'items' => $items,
            'cart' => $cart,
            'cartReserved' => $cartReserved,
        ]);
    }
}
