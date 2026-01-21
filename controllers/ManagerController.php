<?php

namespace app\controllers;

use app\models\Shop\Cart\Cart;
use app\models\Shop\Cart\CartStatusEnum;
use app\models\Shop\Product\ProductItem;
use yii\web\Controller;

class ManagerController extends Controller
{
    public function actionPanel(): string
    {
        $products = ProductItem::find()
            ->with(['product'])
            ->all();

        $carts = Cart::find()
            ->where(['status' => CartStatusEnum::paid->value])
            ->with(['items'])
            ->orderBy(['id' => SORT_DESC])
            ->limit(100)
            ->all();

        return $this->render('list', [
            'products' => $products,
            'carts' => $carts,
        ]);
    }
}
