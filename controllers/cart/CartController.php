<?php

namespace app\controllers\cart;

use app\controllers\AbstractShopController;
use Yii;
 use yii\filters\VerbFilter;

class CartController extends AbstractShopController
{
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'reserve' => ['post'],
                    'pay' => ['post'],
                ],
            ],
        ];
    }

    public function actions(): array
    {
        return [
            'view' => CartViewAction::class,
            'reserve' => CartReserveAction::class,
            'pay' => CartPayAction::class,
        ];
    }
}
