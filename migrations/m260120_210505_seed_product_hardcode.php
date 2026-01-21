<?php

use app\models\Shop\Product\Product;
use app\models\Shop\Product\ProductItem;
use yii\db\Migration;

class m260120_210505_seed_product_hardcode extends Migration
{
    public function safeUp()
    {
        $products = [
            ['Sword', 200.20],
            ['Shield', 150.10],
            ['Hammer', 404.00],
            ['Spear', 50.95],
        ];

        foreach ($products as [$name, $price]) {
            $model = new Product();
            $model->name = $name;
            $model->price = $price;
            $model->save(false);

            $items = new ProductItem();
            $items->amount = ($name == 'Spear' ? 5 : 100);
            $items->product_id = $model->id;
            $items->save(false);
        }
    }

    public function safeDown()
    {
        ProductItem::deleteAll();
        Product::deleteAll();
    }
}
