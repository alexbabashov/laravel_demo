<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;
use App\Models\Cart as CartModel;

class GetCartCurUser
{
    public function __invoke()
    {
        return GetCartCurUser::handle();
    }

    public static function handle()
    {
        if(!Auth::check()) return null;

        $id_user = Auth::id();
        $items = [];

        $price_all = 0;
        $cartItems = CartModel::where('id_user',  $id_user )->get();
        foreach ( $cartItems as $item)
        {
            $addItem = [
                'id_item' => $item->id_item,
                'item_title' => $item->item_title,
                'item_count' => $item->item_count,
                'item_price' => $item->item_price,
                'price_all' => $item->item_price * $item->item_count,
            ];
            $price_all += $addItem['price_all'];
            $items[] = $addItem;
        }

        return ['items' => $items,
                'id_user' => $id_user,
                'price_all' => $price_all
                ];
    }
}
