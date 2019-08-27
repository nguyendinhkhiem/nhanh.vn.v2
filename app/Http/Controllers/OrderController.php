<?php
namespace App\Http\Controllers;

use App\Entities\Information;
use App\Entities\Order;
use App\Entities\Product;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        $ordersSuccess = Order::where('statusGHTK', 5)->count();

        $ordersShipping = Order::where('statusGHTK', 4)->count();

        $ordersReturning = Order::where('statusGHTK', 20)->count();

        $ordersReturned = Order::where('statusGHTK', 21)->count();

        $ordersCanXuLy = Order::where('statusGHTK', 10)->count();

        $data = [
            'ordersSuccess'   => $ordersSuccess,
            'ordersShipping'  => $ordersShipping,
            'ordersReturning' => $ordersReturning,
            'ordersReturned'  => $ordersReturned,
            'ordersCanXuLy'   => $ordersCanXuLy,
        ];

        return view('orders.index', $data);
    }

    public function singleOrder($id)
    {
        $order = Order::where('id', $id)->first();

        $products = Product::where('order_id', $id)->get();

        $data = [
            'order' => $order,
            'products' => $products
        ];

        return view('orders.singleOrder', $data); 
    }

    function list() {
        $orders = Order::orderByRaw('FIELD(statusCode, "Canceled","SoldOut","CustomerConfirming","Confirmed", "Returned","Returning", "Shipping", "Success")')
            ->where('label_GHTK', '=', null)
            ->latest()
            ->paginate(12);

        $info = Information::get();

        $data = [
            'orders' => $orders,
            'info'   => $info,
        ];

        return view('orders.list', $data);
    }

    public function searchOrder()
    {
        // the storeId on e-commerce platforms, individual websites set $storeId = null;
        $storeId = null;

        $data = array(
            $_GET['type'] => $_GET['value'],
        );

        $dataString = $data;
        if (is_array($data)) {
            $dataString = json_encode($data);
        }

        $postFields = array(
            "version"     => '1.0',
            "apiUsername" => 'phuongdungapi',
            "storeId"     => $storeId,
            "data"        => $dataString,
            "checksum"    => $this->createChecksum($dataString),
        );

        $curl = curl_init('https://graph.nhanh.vn/api/order/index');
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $curlResult = curl_exec($curl);

        if (curl_error($curl) == "") {
            $response = json_decode($curlResult);
            if ($response->code == 1) {

                $responseFrontEnd = [];

                foreach ($response->data->orders as $key => $order) {
                    $orderDB = Order::where('id_nhanhvn', $order->id)->get();
                    if ($orderDB->isEmpty()) {
                        $orderSaveDB             = new Order;
                        $orderSaveDB->id_nhanhvn = $order->id;
                        if ($_GET['type'] == 'handoverId') {
                            $orderSaveDB->handoverId = $_GET['value'];
                        }
                        $orderSaveDB->privateId                = $order->privateId;
                        $orderSaveDB->depotId                  = $order->depotId;
                        $orderSaveDB->channel                  = $order->channel;
                        $orderSaveDB->depotName                = $order->depotName;
                        $orderSaveDB->type                     = $order->type;
                        $orderSaveDB->typeId                   = $order->typeId;
                        $orderSaveDB->shippingType             = $order->shippingType;
                        $orderSaveDB->shippingTypeId           = $order->shippingTypeId;
                        $orderSaveDB->moneyDiscount            = $order->moneyDiscount;
                        $orderSaveDB->moneyDeposit             = $order->moneyDeposit;
                        $orderSaveDB->moneyTransfer            = $order->moneyTransfer;
                        $orderSaveDB->carrierId                = $order->carrierId;
                        $orderSaveDB->carrierName              = $order->carrierName;
                        $orderSaveDB->serviceId                = $order->serviceId;
                        $orderSaveDB->serviceName              = $order->serviceName;
                        $orderSaveDB->carrierCode              = $order->carrierCode;
                        $orderSaveDB->shipFee                  = $order->shipFee;
                        $orderSaveDB->codFee                   = $order->codFee;
                        $orderSaveDB->customerShipFee          = $order->customerShipFee;
                        $orderSaveDB->returnFee                = $order->returnFee;
                        $orderSaveDB->overWeightShipFee        = $order->overWeightShipFee;
                        $orderSaveDB->description              = $order->description;
                        $orderSaveDB->privateDescription       = $order->privateDescription;
                        $orderSaveDB->customerId               = $order->customerId;
                        $orderSaveDB->customerName             = $order->customerName;
                        $orderSaveDB->customerEmail            = $order->customerEmail;
                        $orderSaveDB->customerMobile           = $order->customerMobile;
                        $orderSaveDB->customerAddress          = $order->customerAddress;
                        $orderSaveDB->shipToCityLocationId     = $order->shipToCityLocationId;
                        $orderSaveDB->customerCity             = $order->customerCity;
                        $orderSaveDB->shipToDistrictLocationId = $order->shipToDistrictLocationId;
                        $orderSaveDB->customerDistrict         = $order->customerDistrict;
                        $orderSaveDB->createdById              = $order->createdById;
                        $orderSaveDB->createdByUserName        = $order->createdByUserName;
                        $orderSaveDB->createdByName            = $order->createdByName;
                        $orderSaveDB->saleId                   = $order->saleId;
                        $orderSaveDB->saleName                 = $order->saleName;
                        $orderSaveDB->createdDateTime          = $order->createdDateTime;
                        $orderSaveDB->deliveryDate             = $order->deliveryDate;
                        $orderSaveDB->statusName               = $order->statusName;
                        $orderSaveDB->statusCode               = $order->statusCode;
                        $orderSaveDB->calcTotalMoney           = $order->calcTotalMoney;
                        $orderSaveDB->trafficSourceId          = $order->trafficSourceId;
                        $orderSaveDB->trafficSourceName        = $order->trafficSourceName;
                        $products_id                           = [];

                        foreach ($order->products as $key => $product) {
                            $products_id[] = [
                                'id'       => $product->productId,
                                'name'     => $product->productName,
                                'quantity' => $product->quantity,
                                'weight'   => $product->weight,
                            ];
                        }
                        $orderSaveDB->products = json_encode($products_id);
                        $orderSaveDB->status   = Order::STATUS_NEW_CREATEED;
                        $orderSaveDB->save();

                        $responseFrontEnd[] = [
                            'order'  => [$orderSaveDB],
                            'status' => 'GET_NHANH.VN',
                        ];

                        foreach ($order->products as $key => $product) {
                            $crateProduct                 = new Product;
                            $crateProduct->order_id       = $orderSaveDB->id;
                            $crateProduct->productId      = $product->productId;
                            $crateProduct->productName    = $product->productName;
                            $crateProduct->productCode    = $product->productCode;
                            $crateProduct->productBarCode = $product->productBarCode;
                            $crateProduct->price          = $product->price;
                            $crateProduct->quantity       = $product->quantity;
                            $crateProduct->weight         = $product->weight;
                            $crateProduct->discount       = $product->discount;
                            $crateProduct->description    = $product->description;
                            $crateProduct->imei           = $product->imei;
                            $crateProduct->save();
                        }

                    } else {
                        if ($_GET['type'] == 'handoverId') {
                            $orderUpdate = Order::where('id_nhanhvn', $order->id)->update([
                                'status'     => 1,
                                'handoverId' => $_GET['value'],
                            ]);
                        } else {
                            $orderUpdate = Order::where('id_nhanhvn', $order->id)->update(['status' => 1]);
                        }

                        $orderDB            = Order::where('id_nhanhvn', $order->id)->get();
                        $responseFrontEnd[] = [
                            'order'  => $orderDB,
                            'status' => 'CONTAIN_DB',
                        ];
                    }
                }

                $dequyKetQua = [];
                if ($response->data->totalPages > 1) {
                    $dequyKetQua = $this->searchDeQuy($response->data->totalPages, $response->data->page, $_GET['type'], $_GET['value']);
                }

                if ($dequyKetQua) {
                    $sumResponse = array_merge($responseFrontEnd, json_decode($dequyKetQua));
                    return json_encode($sumResponse);
                } else {
                    return json_encode($responseFrontEnd);
                }

            }
        } else {
            $response           = new stdClass();
            $response->code     = 0;
            $response->messages = array(
                curl_error($curl),
            );
        }
        curl_close($curl);
    }

    public function createChecksum($data)
    {
        if (is_array($data)) {
            $dataString = json_encode($data);
        } else {
            $dataString = $data;
        }

        return md5(md5('VYx44TFEAtyJffKkAFkR33aj' . $dataString) . $dataString);
    }

    public function searchDeQuy($totalPages, $currentPage, $type, $value)
    {
        if (($totalPages - $currentPage) <= 0) {
            return false;
        } else {
            $storeId = null;

            $data = array(
                $type  => $value,
                'page' => $currentPage + 1,
            );

            $dataString = $data;
            if (is_array($data)) {
                $dataString = json_encode($data);
            }

            $postFields = array(
                "version"     => '1.0',
                "apiUsername" => 'phuongdungapi',
                "storeId"     => $storeId,
                "data"        => $dataString,
                "checksum"    => $this->createChecksum($dataString),
            );

            $curl = curl_init('https://graph.nhanh.vn/api/order/index');
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            $curlResult = curl_exec($curl);

            if (curl_error($curl) == "") {
                $response = json_decode($curlResult);
                if ($response->code == 1) {

                    $responseFrontEnd = [];

                    foreach ($response->data->orders as $key => $order) {
                        $orderDB = Order::where('id_nhanhvn', $order->id)->get();
                        if ($orderDB->isEmpty()) {
                            $orderSaveDB             = new Order;
                            $orderSaveDB->id_nhanhvn = $order->id;
                            if ($_GET['type'] == 'handoverId') {
                                $orderSaveDB->handoverId = $_GET['value'];
                            }
                            $orderSaveDB->privateId                = $order->privateId;
                            $orderSaveDB->depotId                  = $order->depotId;
                            $orderSaveDB->channel                  = $order->channel;
                            $orderSaveDB->depotName                = $order->depotName;
                            $orderSaveDB->type                     = $order->type;
                            $orderSaveDB->typeId                   = $order->typeId;
                            $orderSaveDB->shippingType             = $order->shippingType;
                            $orderSaveDB->shippingTypeId           = $order->shippingTypeId;
                            $orderSaveDB->moneyDiscount            = $order->moneyDiscount;
                            $orderSaveDB->moneyDeposit             = $order->moneyDeposit;
                            $orderSaveDB->moneyTransfer            = $order->moneyTransfer;
                            $orderSaveDB->carrierId                = $order->carrierId;
                            $orderSaveDB->carrierName              = $order->carrierName;
                            $orderSaveDB->serviceId                = $order->serviceId;
                            $orderSaveDB->serviceName              = $order->serviceName;
                            $orderSaveDB->carrierCode              = $order->carrierCode;
                            $orderSaveDB->shipFee                  = $order->shipFee;
                            $orderSaveDB->codFee                   = $order->codFee;
                            $orderSaveDB->customerShipFee          = $order->customerShipFee;
                            $orderSaveDB->returnFee                = $order->returnFee;
                            $orderSaveDB->overWeightShipFee        = $order->overWeightShipFee;
                            $orderSaveDB->description              = $order->description;
                            $orderSaveDB->privateDescription       = $order->privateDescription;
                            $orderSaveDB->customerId               = $order->customerId;
                            $orderSaveDB->customerName             = $order->customerName;
                            $orderSaveDB->customerEmail            = $order->customerEmail;
                            $orderSaveDB->customerMobile           = $order->customerMobile;
                            $orderSaveDB->customerAddress          = $order->customerAddress;
                            $orderSaveDB->shipToCityLocationId     = $order->shipToCityLocationId;
                            $orderSaveDB->customerCity             = $order->customerCity;
                            $orderSaveDB->shipToDistrictLocationId = $order->shipToDistrictLocationId;
                            $orderSaveDB->customerDistrict         = $order->customerDistrict;
                            $orderSaveDB->createdById              = $order->createdById;
                            $orderSaveDB->createdByUserName        = $order->createdByUserName;
                            $orderSaveDB->createdByName            = $order->createdByName;
                            $orderSaveDB->saleId                   = $order->saleId;
                            $orderSaveDB->saleName                 = $order->saleName;
                            $orderSaveDB->createdDateTime          = $order->createdDateTime;
                            $orderSaveDB->deliveryDate             = $order->deliveryDate;
                            $orderSaveDB->statusName               = $order->statusName;
                            $orderSaveDB->statusCode               = $order->statusCode;
                            $orderSaveDB->calcTotalMoney           = $order->calcTotalMoney;
                            $orderSaveDB->trafficSourceId          = $order->trafficSourceId;
                            $orderSaveDB->trafficSourceName        = $order->trafficSourceName;
                            $products_id                           = [];

                            foreach ($order->products as $key => $product) {
                                $products_id[] = [
                                    'id'       => $product->productId,
                                    'name'     => $product->productName,
                                    'quantity' => $product->quantity,
                                    'weight'   => $product->weight,
                                ];
                            }
                            $orderSaveDB->products = json_encode($products_id);
                            $orderSaveDB->status   = Order::STATUS_NEW_CREATEED;
                            $orderSaveDB->save();

                            $responseFrontEnd[] = [
                                'order'  => [$orderSaveDB],
                                'status' => 'GET_NHANH.VN',
                            ];

                            foreach ($order->products as $key => $product) {
                                $crateProduct                 = new Product;
                                $crateProduct->order_id       = $orderSaveDB->id;
                                $crateProduct->productId      = $product->productId;
                                $crateProduct->productName    = $product->productName;
                                $crateProduct->productCode    = $product->productCode;
                                $crateProduct->productBarCode = $product->productBarCode;
                                $crateProduct->price          = $product->price;
                                $crateProduct->quantity       = $product->quantity;
                                $crateProduct->weight         = $product->weight;
                                $crateProduct->discount       = $product->discount;
                                $crateProduct->description    = $product->description;
                                $crateProduct->imei           = $product->imei;
                                $crateProduct->save();
                            }

                        } else {
                            if ($_GET['type'] == 'handoverId') {
                                $orderUpdate = Order::where('id_nhanhvn', $order->id)->update([
                                    'status'     => 1,
                                    'handoverId' => $_GET['value'],
                                ]);
                            } else {
                                $orderUpdate = Order::where('id_nhanhvn', $order->id)->update(['status' => 1]);
                            }

                            $orderDB            = Order::where('id_nhanhvn', $order->id)->get();
                            $responseFrontEnd[] = [
                                'order'  => $orderDB,
                                'status' => 'CONTAIN_DB',
                            ];
                        }
                    }

                    $dequyKetQua = [];
                    if (($response->data->totalPages - $response->data->page) > 0) {
                        $dequyKetQua = $this->searchDeQuy($response->data->totalPages, $response->data->page, $_GET['type'], $_GET['value']);
                    } else {
                        return json_encode($responseFrontEnd);
                    }
                }
            } else {
                $response           = new stdClass();
                $response->code     = 0;
                $response->messages = array(
                    curl_error($curl),
                );
            }
            curl_close($curl);
        }
    }

    public function listOrdersSuccess()
    {
        $orders = Order::where('statusGHTK', 5)
            ->orderBy('createdDateTime', 'desc')
            ->latest()
            ->paginate(12);

        $info = Information::get();

        $data = [
            'orders' => $orders,
            'info'   => $info,
        ];

        return view('orders.ordersSuccess', $data);
    }

    public function listOrdersShipping()
    {
        $orders = Order::where('statusGHTK', 4)
            ->orderBy('createdDateTime', 'desc')
            ->latest()
            ->paginate(12);

        $info = Information::get();

        $data = [
            'orders' => $orders,
            'info'   => $info,
        ];

        return view('orders.ordersShipping', $data);
    }

    public function listOrdersTransferring()
    {
        $orders = Order::where('statusGHTK', 20)
            ->orderBy('createdDateTime', 'desc')
            ->latest()
            ->paginate(12);

        $info = Information::get();

        $data = [
            'orders' => $orders,
            'info'   => $info,
        ];

        return view('orders.ordersTransferring', $data);
    }

    public function listOrdersCompleted()
    {
        $orders = Order::where('statusGHTK', 21)
            ->orderBy('createdDateTime', 'desc')
            ->latest()
            ->paginate(12);

        $info = Information::get();

        $data = [
            'orders' => $orders,
            'info'   => $info,
        ];

        return view('orders.ordersCompleted', $data);
    }

    public function listOrdersNeedTreatment()
    {
        $orders = Order::where('statusGHTK', 10)
            ->orderBy('createdDateTime', 'desc')
            ->latest()
            ->paginate(12);

        $info = Information::get();

        $data = [
            'orders' => $orders,
            'info'   => $info,
        ];

        return view('orders.ordersNeedTreatment', $data);
    }
}
