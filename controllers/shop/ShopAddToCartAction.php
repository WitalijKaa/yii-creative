<?php

namespace app\controllers\shop;

use app\interfaces\CartProviderInterface;
use app\models\Shop\Product\ProductItem;
use Yii;
use yii\base\Action;

class ShopAddToCartAction extends Action
{
    public function run(CartProviderInterface $cartProvider)
    {
        $productId = (int)Yii::$app->request->post('product_id');
        $model = ProductItem::find()
            ->where(['product_id' => $productId])
            ->one();

        if (!$model) {
            return $this->controller->redirect(['shop/shop/list']);
        }

        $cartProvider->cart()->addToCartByProductID($productId);

        return $this->controller->redirect(Yii::$app->request->referrer ?: ['shop/shop/list']);
    }
}
