<?php

namespace app\interfaces;

use app\models\Shop\Cart\Cart;
use yii\web\Request;

interface CartProviderInterface
{
    public function initCart(Request $request): void;
    public function cart(): Cart;
    public function cartReserved(): ?Cart;
}
