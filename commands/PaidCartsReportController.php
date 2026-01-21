<?php

namespace app\commands;

use app\models\Shop\Cart\Cart;
use app\models\Shop\Cart\CartStatusEnum;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class PaidCartsReportController extends Controller
{
    public int $subDays = 0;
    public ?string $sendEmail = null;

    private const int CHUNK = 50;

    public function options($actionID): array
    {
        return ['subDays', 'sendEmail'];
    }

    public function optionAliases(): array
    {
        return [
            'sub_days' => 'subDays',
            'send_email' => 'sendEmail',
        ];
    }

    public function actionIndex()
    {
        if ($report = $this->createReportForDay($this->subDays)) {
            $filePath = $this->saveReportToFile($report);

            if ($this->sendEmail) {
                $this->sendEmailWithReport($filePath, $this->sendEmail);
                dd(file($filePath));
            }
        }
    }

    private function createReportForDay(int $subDays): array
    {
        $from = (new DateTimeImmutable('now'))->modify("-{$subDays} days")->setTime(0, 0, 0);
        $to = (new DateTimeImmutable('now'))->setTime(23, 59, 59);

        $query = Cart::find()
            ->where(['between', 'paid_at', $from->format('Y-m-d H:i:s'), $to->format('Y-m-d H:i:s')])
            ->andWhere(['status' => CartStatusEnum::paid->value])
            ->with(['items.productItem.product'])
            ->orderBy(['paid_at' => SORT_ASC, 'id' => SORT_ASC]);

        $report = [];
        foreach ($query->batch(self::CHUNK) as $carts) {
            foreach ($carts as $cart) {
                $report[] = [
                    $cart->id,
                    $cart->paid_at,
                    $cart->client_uuid,
                    $cart->priceReserved,
                ];

                foreach ($cart->items as $cartItem) {
                    $product = $cartItem->productItem?->product;
                    $report[] = [
                        $cart->id,
                        $cart->paid_at,
                        $cart->client_uuid,
                        $cart->priceReserved,
                        $product?->name ?? '',
                        $cartItem->amount,
                        (float) $cartItem->amount * (float) $cartItem->price,
                        $cartItem->price,
                        $product?->price ?? '',
                    ];
                }
            }
        }
        return $report;
    }

    private function saveReportToFile(array $report): string
    {
        $dir = Yii::getAlias('@runtime/logs');

        $filePath = $dir . DIRECTORY_SEPARATOR . 'day_report_' . date('Y-m-d_H-i-s') . '.csv';
        $stream = fopen($filePath, 'w');

        foreach ($report as $line) {
            fputcsv($stream, $line, ';', '"', "\\");
        }

        fclose($stream);
        return $filePath;
    }

    private function sendEmailWithReport(string $reportFilePath, string $email): void
    {
        Yii::$app->mailer->compose()
            ->setTo($email)
            ->setSubject('Daily report on sold products')
            ->setTextBody('The daily report on sold products is attached.')
            ->attach($reportFilePath, [
                'fileName' => basename($reportFilePath),
                'contentType' => 'text/csv',
            ])
            ->setFrom('todo@email.ru')
            ->send();
    }
}
