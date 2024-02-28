<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Item as ItemModel;
use App\Models\Cart as CartModel;

class DeleteCartCurUser
{
    public function __invoke(bool $restoreItemsTable = true)
    {
        return DeleteCartCurUser::handle($restoreItemsTable);
    }

    public static function handle(bool $restoreItemsTable = true)
    {
        DB::transaction(function() use ($restoreItemsTable)
        {
            if( $restoreItemsTable )
            {
                DeleteCartCurUser::restoreItemsModel();
            }
            DeleteCartCurUser::deleteItemsCart();
        });
    }

    public static function deleteItemsCart()
    {
        return CartModel::where('id_user',  Auth::id())->delete();
    }

    public static function restoreItemsModel()
    {
        $itemsCart = CartModel::where('id_user',  Auth::id())->get();
        if(!$itemsCart) return;
        foreach ( $itemsCart as $curItemCart)
        {
            $item = ItemModel::where('id', $curItemCart->id_item)->first();
            if( $item )
            {
                $item->count += $curItemCart->item_count;
                $item->save();
            }
        }
    }
}
