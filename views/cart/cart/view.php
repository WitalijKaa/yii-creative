<?php

/** @var yii\web\View $this */
/** @var app\models\Shop\Product\ProductItem[] $items */
/** @var app\models\Shop\Cart\Cart $cart */
/** @var app\models\Shop\Cart\Cart|null $cartReserved */

use yii\helpers\Html;

$this->title = 'Armory SHOP client cart';
?>

<div class="shop-cart">
    <div class="text-center my-4">
        <h1 class="display-4 fw-bold">Armory SHOP client cart</h1>
    </div>

    <?php if ($cart->price > 0): ?>
        <div class="text-center my-4">
            <h2 class="h3 fw-semibold">Total price <?= Html::encode(number_format($cart->price, 2)) ?> $</h2>
        </div>
    <?php endif; ?>

    <div class="row g-4 justify-content-center">
        <?php foreach ($items as $item): ?>
            <div class="col-12 col-md-6 col-lg-4">
                <?= $this->render('//shop/components/_product_item_basic', [
                    'item' => $item,
                    'allowRemove' => true,
                ]) ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="d-flex flex-column align-items-center">
        <?php if ($cart->mayReserve && $cartReserved === null): ?>
            <?= Html::a('Reserve items', ['cart/cart/reserve'], [
                'class' => 'btn btn-outline-dark btn-lg mt-5 px-4',
                'data' => ['method' => 'post'],
            ]) ?>
        <?php endif; ?>

        <?php if ($cartReserved): ?>
            <div class="text-center mt-5 w-100">
                <h2 class="h3 fw-semibold mb-3">Reserved cart</h2>
                <h2 class="h5 fw-semibold mb-4">
                    Total price <?= Html::encode(number_format($cartReserved->priceReserved, 2)) ?> $
                </h2>
                <?= Html::a('Buy items for ' . number_format($cartReserved->priceReserved, 2) . ' $', ['cart/cart/pay'], [
                        'class' => 'btn btn-success btn-lg mb-4',
                        'data' => ['method' => 'post'],
                ]) ?>

                <div class="row g-3 justify-content-center">
                    <?php foreach ($cartReserved->items as $item): ?>
                        <div class="col-12 col-md-6 col-lg-4">
                            <?= $this->render('//cart/components/_cart_item_simple', ['item' => $item]) ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?= Html::a('Back to SHOP Armory', ['shop/shop/list'], [
            'class' => 'btn btn-outline-secondary btn-lg mt-5 px-4',
        ]) ?>

        <div class="text-muted mt-4">User <?= Html::encode($cart->client_uuid) ?></div>
    </div>
</div>
