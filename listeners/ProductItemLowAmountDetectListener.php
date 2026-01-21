<?php

namespace app\listeners;

use app\events\ProductItemAmountChangedEvent;
use app\models\Shop\Product\ProductItem;
use Yii;

class ProductItemLowAmountDetectListener
{
    public const int LOW_AMOUNT_THRESHOLD = 3;

    public static function handle(ProductItemAmountChangedEvent $event): void
    {
        if (!($productItem = ProductItem::find()->with(['product'])->where(['id' => $event->productItemId])->one()) ||
            $productItem->amount > Yii::$app->params['shop.min_amount']) {
            return;
        }

        self::sendWarningEmail($productItem, $productItem->amount, 'low', Yii::$app->params['adminEmail']);
    }

    private static function sendWarningEmail(ProductItem $productItem, int $amount, string $level, string $email): void
    {
        $productName = $productItem->product?->name;
        $lines = [
            'Hello!',
            sprintf('Stock for "%s" dropped to the %s level.', $productName, $level),
            sprintf('Available quantity: %d.', $amount),
            'Please restock as soon as possible.',
        ];

        Yii::$app->mailer->compose()
            ->setTo($email)
            ->setSubject(sprintf('%s: %s level', $productName, $level))
            ->setTextBody(implode(PHP_EOL, $lines))
            ->setFrom('todo@email.ru')
            ->send();
    }
}
