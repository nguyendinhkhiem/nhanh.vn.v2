<?php
namespace App\Http\Controllers;

use App\Entities\Information;
use App\Entities\Order;
use App\Entities\Product;
use App\Entities\Cause;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function index(){}

    public function CountOrder()
    {
        $ordersSuccess = Order::whereIn('statusGHTK', [5, 6])->count();
        $ordersShipping = Order::whereIn('statusGHTK', [2, 3, 4])->count();
        $ordersReturning = Order::where('statusGHTK', 20)->count();
        $ordersReturned = Order::where('statusGHTK', 21)->count();
        $ordersCanXuLy = Order::whereIn('statusGHTK', [9, 10])->where('need_treatment', 0)->count();
        $ordersCanceled = Order::where('statusGHTK', -1)->count();
        $data = [
            'ordersSuccess'   => $ordersSuccess,
            'ordersShipping'  => $ordersShipping,
            'ordersReturning' => $ordersReturning,
            'ordersReturned'  => $ordersReturned,
            'ordersCanXuLy'   => $ordersCanXuLy,
            'ordersCanceled'  => $ordersCanceled
        ];
        return $data;
    }

    public function detailOrderByNhanhId($id)
    {
        $order = Order::where('id_nhanhvn', $id)->first();
        if(!empty($order)){
            $order_id = $order->id;
            $products = Product::where('order_id', $order_id)->get();
            $causes = Cause::where('order_id', $order_id)->orderBy('created_at', 'desc')->get();
            $data = [
                'order'    => $order,
                'products' => $products,
                'causes' => $causes
            ];
            return $data;
        }else{
            return 'Đơn hàng chưa đăng lên GHTK!';
        }
    }

    public function detailOrderBySearch($id)
    {
        $order = Order::where(function ($query) use ($id) {     
            $query->orWhere('label_GHTK', 'like', "%$id%");
            // $query->orWhere('customerName', 'like', "%$id%");
            $query->orWhere('customerMobile', 'like', "%$id%");
            $query->orWhere('id_nhanhvn', 'like', "%$id%");
        })
        ->skip(0)
        ->take(5)
        ->get();
        // dd($order);exit();

        if(!empty($order)){
            return $order;
        }else{
            return 'Đơn hàng chưa đăng lên GHTK!';
        }
    }


    public function getListOrderNeedTreetment()
    {
        $order = Order::whereIn('statusGHTK', [9, 10])
        ->where('need_treatment', 0)
        ->get();

        if(!empty($order)){
            return $order;
        }else{
            return 'Đơn hàng chưa đăng lên GHTK!';
        }
    }

    
}