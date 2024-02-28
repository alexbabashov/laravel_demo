<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

use App\Actions\AddToCartCurUser;
use App\Actions\GetCartCurUser;
use App\Actions\DeleteCartCurUser;

class CartsController extends Controller
{
    public function index()
    {
        return view('cart', GetCartCurUser::handle());
    }

    public function store(Request $request)
    {
        return AddToCartCurUser::handle($request);
    }

    public function show($id)
    {
        //::findOrFail($id);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {

    }

    public function destroy_by_current_user()
    {
        try
        {
            DeleteCartCurUser::handle();
        }
        catch (QueryException $exception)
        {
            return response()->json(['error' => 'Database error'], 500);
        }
        return response()->json(['error' => null]);
    }
}
