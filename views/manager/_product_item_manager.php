<?php

/** @var app\models\Shop\Product\ProductItem $item */

use yii\helpers\Html;

$productName = $item->product?->name ?? ('Product #' . $item->product_id);
$productPrice = $item->product?->price ?? 0;
?>

<div class="card h-100 border-0 shadow-sm">
    <div class="card-body">
        <h6 class="card-title mb-1"><?= Html::encode($productName) ?></h6>
        <div class="text-muted small mb-3">Item #<?= Html::encode((string) $item->id) ?></div>
        <div class="mb-2">
            <span class="fw-semibold">Price:</span>
            <?= Html::encode(number_format((float) $productPrice, 2)) ?> $
        </div>
        <div class="mb-1">
            <span class="fw-semibold">Available:</span>
            <?= Html::encode((string) $item->amount) ?>
        </div>
        <div>
            <span class="fw-semibold">Reserved:</span>
            <?= Html::encode((string) $item->amount_reserved) ?>
        </div>
    </div>
</div>
