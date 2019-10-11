<?php
namespace App\Http\Controllers;

use App\Entities\Information;
use App\Entities\Order;
use App\Entities\Product;
use App\Entities\Cause;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Cookie, X-API-KEY, Origin, X-CSRF-TOKEN, X-XSRF-TOKEN, X-Requested-With, Access-Control-Allow-Origin, Authorization, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE, PATCH");
header("Allow: GET, POST, OPTIONS, PUT, DELETE, PATCH");
header('Access-Control-Allow-Credentials: true');

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
}
