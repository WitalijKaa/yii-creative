<?php

namespace app\services;

use app\interfaces\CartProviderInterface;
use app\models\Shop\Cart\Cart;
use app\models\Shop\Cart\CartStatusEnum;
use Yii;
use yii\web\Cookie;
use yii\web\Request;

class CartUnregisteredService implements CartProviderInterface
{
    public const COOKIE_NAME = 'cart_unregistered';
    private const COOKIE_TTL_SECONDS = 60 * 60 * 24 * 180;

    private ?Cart $cart = null;
    private ?string $uuid = null;

    public function cart(): Cart
    {
        return $this->cart;
    }

    public function initCart(Request $request): void
    {
        $cookie = $request->cookies->get(self::COOKIE_NAME);
        $this->uuid = $cookie ? $cookie->value : bin2hex(random_bytes(16));

        $this->cart = Cart::find()
            ->where([
                'client_uuid' => $this->uuid,
                'status' => CartStatusEnum::potential->value,
            ])
            ->with(['items.productItem.product'])
            ->one();

        if ($this->cart === null) {
            $this->cart = new Cart();
        }

        $this->cart->client_uuid = $this->uuid;
        $this->cart->status = CartStatusEnum::potential->value;

        Yii::$app->response->cookies->add(new Cookie([
            'name' => self::COOKIE_NAME,
            'value' => $this->uuid,
            'expire' => time() + self::COOKIE_TTL_SECONDS,
            'httpOnly' => true,
        ]));
    }

    public function cartReserved(): ?Cart
    {
        if (empty($this->uuid)) {
            return null;
        }

        return Cart::find()
            ->where([
                'client_uuid' => $this->uuid,
                'status' => CartStatusEnum::reserved->value,
            ])
            ->with(['items.productItem.product'])
            ->one();
    }
}
