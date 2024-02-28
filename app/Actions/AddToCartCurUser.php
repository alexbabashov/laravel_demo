<?php

namespace App\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

use App\Models\Item as ItemModel;
use App\Models\Cart as CartModel;

class AddToCartCurUser
{
    public function __invoke(Request $request)
    {
        return AddToCartCurUser::handle($request);
    }

    public static function handle(Request $request)
    {
        $result = [
            'error' => null,
        ];

        $idItem = $request->input('id');
        $requestCountItem = $request->input('count');

        $item = ItemModel::where('id', $idItem)->first();
        if(!$item)
        {
            $result = [
                'error' => 'Товар не найден',
            ];
            return response()->json($result);
        }
        if( $item->count < $requestCountItem )
        {
            $result = [
                'error' => 'Нет такого количества товаров',
            ];
            return response()->json($result);
        }

        $newItem = [
            'id_user' => Auth::id(),
            'id_item' => $idItem,
            'item_title' => $item->title,
            'item_count' => $requestCountItem,
            'item_price' => $item->price,
        ];

        $cartItem = null;

        try
        {
            DB::transaction(function() use (&$newItem, &$item, $requestCountItem,  &$cartItem)
            {
                $cartItem = CartModel::where('id_user', $newItem['id_user'])
                                    ->where('id_item',  $newItem['id_item'])->first();
                if($cartItem )
                {
                    $cartItem->item_count += $requestCountItem;
                    $cartItem->save();
                }
                else
                {
                    $cartItem = CartModel::create($newItem);
                }
                $item->count = $item->count - $requestCountItem;
                $item->save();
            });
        }
        catch (QueryException $exception)
        {
            return response()->json(['error' => 'Database error'], 500);
        }

        if(!$cartItem)
        {
            $result = [
                'error' => 'Ошибка добавления',
                'newItem' => $newItem,
            ];
            return response()->json($result);
        }

        $result = [
            'error' => null,
            'newItem' => $newItem,
        ];
        return response()->json($result);
    }

}
