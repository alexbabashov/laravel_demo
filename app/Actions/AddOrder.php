<?php

namespace App\Actions;

use Illuminate\Support\Facades\DB;
use App\Models\Order as OrderModel;
use App\Models\OrderItem as OrderItemModel;

use App\Actions\GetCartCurUser;

class AddOrder
{
    public function __invoke()
    {
        return AddOrder::handle();
    }

    public static function handle()
    {
        $i = 0;
        $s = 1;
        $cart = GetCartCurUser::handle();
        $s = 1;
        $s = 1;

        DB::transaction(function()
        {
            $cart = GetCartCurUser::handle();
            if($cart && count($cart['items']))
            {
                $order = OrderModel::create([ 'id_user' => $cart['id_user'] ]);

                foreach ( $cart['items'] as $curCartItem)
                {
                    $newItem = [
                        'id_order' => $order->id,
                        'id_item' => $curCartItem['id_item'],
                        'item_title' => $curCartItem['item_title'],
                        'item_count' => $curCartItem['item_count'],
                        'item_price' => $curCartItem['item_price']
                    ];
                    OrderItemModel::create($newItem);
                }

                DeleteCartCurUser::deleteItemsCart();
            }
        });
    }
}
