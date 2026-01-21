<?php

namespace app\controllers;

use app\interfaces\CartProviderInterface;
use Yii;
use yii\web\Controller;

abstract class AbstractShopController extends Controller
{
    protected CartProviderInterface $cartProvider;

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        Yii::$app->get('cartProvider')->initCart(Yii::$app->request);
        return true;
    }
}
