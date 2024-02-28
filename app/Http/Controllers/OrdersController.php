<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Actions\AddOrder;
use App\Actions\GetOrders;
use App\Actions\DeleteOrder;

class OrdersController extends Controller
{

    public function index()
    {
        return view('orders', GetOrders::handle());
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try
        {
            AddOrder::handle();
        }
        catch (QueryException $exception)
        {
            return response()->json(['error' => 'Database error'], 500);
        }
        return response()->json(['error' => null]);
    }


    public function show($id)
    {
        //
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
        $result = false;
        try
        {
            $result = DeleteOrder::handle($id);
        }
        catch (QueryException $exception)
        {
            return response()->json(['error' => 'Database error'], 500);
        }
        return response()->json(['error' => $result ? null : 'Ошибка удаления']);
    }
}
