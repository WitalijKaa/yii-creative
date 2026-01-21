<?php

/** @var yii\web\View $this */
/** @var app\models\Shop\Product\ProductItem[] $items */
/** @var string|null $cartUuid */

use yii\helpers\Html;

$this->title = 'Armory SHOP';

?><div class="shop-list">
    <div class="text-center my-4">
        <h1 class="display-4 fw-bold">Armory SHOP</h1>
        <p class="text-muted">Select gear and build your cart.</p>
    </div>

    <div class="row g-4 justify-content-center">
        <?php foreach ($items as $item): ?>
            <div class="col-12 col-md-6 col-lg-4">
                <?= $this->render('//shop/components/_product_item_basic', [
                    'item' => $item,
                    'allowRemove' => false,
                ]) ?>
            </div>
        <?php endforeach; ?>
    </div>

    <?php if ($cartUuid): ?>
        <div class="text-center my-5">
            <?= Html::a('View Cart', ['cart/cart/view'], [
                'class' => 'btn btn-outline-dark btn-lg px-4',
            ]) ?>
            <div class="text-muted mt-3">User <?= Html::encode($cartUuid) ?></div>
        </div>
    <?php endif; ?>
</div>
