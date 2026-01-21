<?php

/** @var app\models\Shop\Product\ProductItem $item */
/** @var bool $allowRemove */

use yii\helpers\Html;

$productName = $item->product?->name ?? ('Product #' . $item->product_id);
$productPrice = $item->product?->price ?? 0;
$inCartItem = $item->inCartItem;
?>

<div class="card h-100 shadow-sm border-0">
    <div class="card-body d-flex flex-column">
        <div class="mb-3">
            <h5 class="card-title mb-1"><?= Html::encode($productName) ?></h5>
            <div class="text-muted small">Item #<?= Html::encode((string) $item->id) ?></div>
        </div>

        <div class="mb-2">
            <span class="fw-semibold">Price:</span>
            <?= Html::encode(number_format((float) $productPrice, 2)) ?> $
        </div>
        <div class="mb-3">
            <span class="fw-semibold">Available:</span>
            <?= Html::encode((string) $item->amount) ?>
        </div>

        <?php if ($inCartItem): ?>
            <div class="alert alert-secondary py-1 px-2 mb-3">
                In cart: <?= Html::encode((string) $inCartItem->amount) ?>
            </div>
        <?php endif; ?>

        <div class="mt-auto d-flex gap-2 flex-wrap">
            <?= Html::beginForm(['shop/shop/add-to-cart'], 'post', ['class' => 'd-inline']) ?>
            <?= Html::hiddenInput('product_id', $item->product_id) ?>
            <?= Html::submitButton('Add to cart', [
                'class' => 'btn btn-primary btn-sm',
                'disabled' => $item->amount < 1,
            ]) ?>
            <?= Html::endForm() ?>

            <?php if ($allowRemove && $inCartItem): ?>
                <?= Html::beginForm(['shop/shop/remove-from-cart'], 'post', ['class' => 'd-inline']) ?>
                <?= Html::hiddenInput('cart_item_id', $inCartItem->id) ?>
                <?= Html::submitButton('Remove', [
                    'class' => 'btn btn-outline-danger btn-sm',
                ]) ?>
                <?= Html::endForm() ?>
            <?php endif; ?>
        </div>
    </div>
</div>
