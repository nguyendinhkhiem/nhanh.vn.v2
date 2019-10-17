<?php
namespace App\Http\Controllers;

use App\Entities\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 *
 */
class SortOrderController extends Controller
{
    public function sortByKeyList(Request $request)
    {
        $data = $request->all();
        $id = $data['params']['value'];
        // $querry = Order::where($data['params']['type'], 'like', "%{$data['params']['value']}%");

        $querry = Order::where(function ($query) use ($id) {     
            $query->orWhere('label_GHTK', 'like', "%$id%");
            $query->orWhere('customerName', 'like', "%$id%");
            $query->orWhere('customerMobile', 'like', "%$id%");
            $query->orWhere('id_nhanhvn', 'like', "%$id%");
        });

        $listOrders = $querry->get();
        $count = $querry->get()->count();

        return response()->json(['success' => true, 'listOrders' => $listOrders, 'count' => $count]);
    }

    public function sortListOrder(Request $request)
    {
        $data = $request->all();

        $listOrders = Order::where($data['params']['type'], $data['params']['value'])
            ->where('label_GHTK', '=', null)
            ->get();

        return response()->json(['success' => true, 'listOrders' => $listOrders]);
    }

    public function sortListOrderSuccess(Request $request)
    {
    	$data = $request->all();

        $listOrders = Order::where($data['params']['type'], $data['params']['value'])
        	->where('statusGHTK', 5)
            ->get();

        return response()->json(['success' => true, 'listOrders' => $listOrders]);
    }

    public function sortListOrderShipping(Request $request)
    {
    	$data = $request->all();

        $listOrders = Order::where($data['params']['type'], $data['params']['value'])
        	->where('statusGHTK', 4)
            ->get();

        return response()->json(['success' => true, 'listOrders' => $listOrders]);
    }

    public function sortListOrderTransferring(Request $request)
    {
        $data = $request->all();

        $listOrders = Order::where($data['params']['type'], $data['params']['value'])
            ->where('statusGHTK', 20)
            ->get();

        return response()->json(['success' => true, 'listOrders' => $listOrders]);
    }

    public function sortListOrderCompleted(Request $request)
    {
        $data = $request->all();

        $listOrders = Order::where($data['params']['type'], $data['params']['value'])
            ->where('statusGHTK', 21)
            ->get();

        return response()->json(['success' => true, 'listOrders' => $listOrders]);
    }

    public function sortListOrderNeedTreatment(Request $request)
    {
        $data = $request->all();

        $listOrders = Order::where($data['params']['type'], $data['params']['value'])
            ->where('statusGHTK', 10)
            ->get();

        return response()->json(['success' => true, 'listOrders' => $listOrders]);
    }
}
