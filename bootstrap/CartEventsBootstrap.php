<?php

namespace app\bootstrap;

use app\events\ProductItemAmountChangedEvent;
use app\listeners\ProductItemLowAmountDetectListener;
use app\models\Shop\Cart\Cart;
use yii\base\BootstrapInterface;
use yii\base\Event;

class CartEventsBootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        Event::on(
            Cart::class,
            ProductItemAmountChangedEvent::NAME,
            [ProductItemLowAmountDetectListener::class, 'handle']
        );
    }
}
