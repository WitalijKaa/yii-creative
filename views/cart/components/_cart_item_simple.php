<?php

/** @var app\models\Shop\Cart\CartItem $item */

use yii\helpers\Html;

$productName = $item->productItem?->product?->name ?? ('Item #' . $item->product_item_id);
?>

<div class="card h-100 border-0 shadow-sm">
    <div class="card-body">
        <h6 class="card-title mb-2"><?= Html::encode($productName) ?></h6>
        <div class="small text-muted mb-2">Cart item #<?= Html::encode((string) $item->id) ?></div>
        <div class="mb-1">
            <span class="fw-semibold">Amount:</span>
            <?= Html::encode((string) $item->amount) ?>
        </div>
        <div class="mb-1">
            <span class="fw-semibold">Unit price:</span>
            <?= Html::encode(number_format((float) $item->price, 2)) ?> $
        </div>
        <div class="fw-semibold">
            Total: <?= Html::encode(number_format($item->amount * (float) $item->price, 2)) ?> $
        </div>
    </div>
</div>
