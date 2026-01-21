<?php

namespace app\events;

use yii\base\Event;

class ProductItemAmountChangedEvent extends Event
{
    public const string NAME = 'productItemAmountChanged';

    public int $productItemId = 0;
}
