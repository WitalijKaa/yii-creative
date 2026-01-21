<?php

namespace app\services;

use app\models\Shop\Cart\CartItem;

interface ShoppingInterface
{
    // next logical step is to teleport this methods from the Cart model, to make it smaller and use MEDIATOR patters for this inter-model cooperations

    public function addToCartByProductID(int $productId, int $amount = 1): void;
    public function reserveToCartByProductItemID(CartItem $cartItems): void;
    public function reserveCartItems(): void;
    public function payCartItems(): void;
}
