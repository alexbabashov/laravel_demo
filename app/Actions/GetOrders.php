<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;

use App\Models\Order as OrderModel;
use App\Models\OrderItem as OrderItemModel;

class GetOrders
{
    public function __invoke()
    {
        return GetOrders::handle();
    }

    public static function handle()
    {
        $itemsList = [];
        $price_all = 0;
        $id_user = Auth::id();
        $orders = OrderModel::where('id_user',  $id_user )->get();
        foreach ( $orders as $curItemOrder)
        {
            $addItemsList = [
                'id' => $curItemOrder->id,
                'date' => date('d-m-Y H:i:s', strtotime($curItemOrder->created_at)),
                'price_all' => 0,
                'items' => [],
            ];

            $cur_order_price_all = 0;
            $orderItems = OrderItemModel::where('id_order',  $curItemOrder->id )->get();
            foreach ( $orderItems as $curItem)
            {
                $addItem = [
                    'id_item' => $curItem->id_item,
                    'item_title' => $curItem->item_title,
                    'item_count' => $curItem->item_count,
                    'item_price' => $curItem->item_price,
                    'price_all' => $curItem->item_price * $curItem->item_count,
                ];
                $cur_order_price_all += $addItem['price_all'];
                $addItemsList['items'][] = $addItem;
            }

            $price_all += $cur_order_price_all;
            $addItemsList['price_all'] = $cur_order_price_all;
            $itemsList[] = $addItemsList;;
        }

        return ['orders' => $itemsList,
                            'id_user' => $id_user,
                            'price_all' => $price_all
                        ];
    }
}
