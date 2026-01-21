<?php

namespace app\controllers\shop;

use app\interfaces\CartProviderInterface;
use app\models\Shop\Product\ProductItem;
use yii\base\Action;

class ShopListAction extends Action
{
    public function run(CartProviderInterface $cartProvider)
    {
        $cart = $cartProvider->cart();
        $items = ProductItem::findAvailableAll($cart->productsItemsIDs());
        $cart->setInCartAmount($items);

        $cartUuid = (count($cart->items) > 0 || $cartProvider->cartReserved() !== null)
            ? $cart->client_uuid
            : null;

        return $this->controller->render('list', [
            'items' => $items,
            'cartUuid' => $cartUuid,
        ]);
    }
}
