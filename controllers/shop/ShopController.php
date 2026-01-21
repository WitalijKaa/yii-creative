<?php

namespace app\controllers\shop;

use app\controllers\AbstractShopController;
use yii\filters\VerbFilter;

class ShopController extends AbstractShopController
{
    public function behaviors(): array
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'add-to-cart' => ['post'],
                    'remove-from-cart' => ['post'],
                ],
            ],
        ];
    }

    public function actions(): array
    {
        return [
            'list' => ShopListAction::class,
            'add-to-cart' => ShopAddToCartAction::class,
            'remove-from-cart' => ShopRemoveFromCartAction::class,
        ];
    }
}
