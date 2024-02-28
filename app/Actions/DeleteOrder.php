<?php

namespace App\Actions;

use Illuminate\Support\Facades\DB;
use App\Models\Item as ItemModel;
use App\Models\Order as OrderModel;
use App\Models\OrderItem as OrderItemModel;

class DeleteOrder
{
    public function __invoke($id)
    {
        return DeleteOrder::handle($id);
    }

    public static function handle($id)
    {
        $result = false;
        DB::transaction(function() use ($id, &$result)
        {
            $order = OrderModel::where('id',  $id )->get()->first();

            if($order)
            {
                $result = true;
                $orderItems = OrderItemModel::where('id_order',  $order->id )->get();
                foreach ( $orderItems as $curItem)
                {
                    $item = ItemModel::where('id', $curItem->id_item)->first();
                    if( $item )
                    {
                        $item->count += $curItem->item_count;
                        $item->save();
                    }
                    $curItem->delete();
                }
                $order->delete();
            }
        });
        return $result;
    }
}
