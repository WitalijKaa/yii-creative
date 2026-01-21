<?php

namespace app\controllers\shop;

use app\models\Shop\Cart\CartItem;
use Yii;
use yii\base\Action;

class ShopRemoveFromCartAction extends Action
{
    public function run()
    {
        $cartItem = CartItem::find()
            ->where(['id' => (int)Yii::$app->request->post('cart_item_id')])
            ->one();

        if (!$cartItem) {
            return $this->controller->redirect(['shop/product-item/list']);
        }

        $cartItem->removeFromCart();

        return $this->controller->redirect(Yii::$app->request->referrer ?: ['shop/shop/list']);
    }
}
