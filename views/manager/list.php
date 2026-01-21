<?php

/** @var yii\web\View $this */
/** @var app\models\Shop\Product\ProductItem[] $products */
/** @var app\models\Shop\Cart\Cart[] $carts */

use yii\helpers\Html;

$this->title = 'Admin - Armory';
?>

<div class="admin-list">
    <div class="text-center my-4">
        <h1 class="display-5 fw-bold">ADMIN PAGE</h1>
    </div>

    <div class="row g-4 justify-content-center">
        <?php foreach ($products as $item): ?>
            <div class="col-12 col-md-6 col-lg-4">
                <?= $this->render('_product_item_manager', ['item' => $item]) ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="mt-5">
        <h2 class="h4 fw-semibold mb-3">Paid carts</h2>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Paid at</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($carts as $cart): ?>
                        <tr>
                            <td><small><?= Html::encode($cart->client_uuid) ?></small></td>
                            <td><?= Html::encode(Yii::$app->formatter->asDatetime($cart->paid_at)) ?></td>
                            <td class="text-end">
                                <strong><?= Html::encode(number_format($cart->priceReserved, 2)) ?> $</strong>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
