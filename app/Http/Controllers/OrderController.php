<?php
namespace App\Http\Controllers;

use App\Entities\Information;
use App\Entities\Order;
use App\Entities\Product;
use App\Entities\Cause;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public $arrayOrder = [];
    public function index()
    {
        $ordersSuccess = Order::whereIn('statusGHTK', [5, 6])->count();

        $ordersShipping = Order::whereIn('statusGHTK', [2, 3, 4])->count();

        $ordersReturning = Order::where('statusGHTK', 20)->count();

        $ordersReturned = Order::where('statusGHTK', 21)->count();

        $ordersCanXuLy = Order::whereIn('statusGHTK', [9, 10])->where('need_treatment', 0)->count();

        $ordersCanceled = Order::where('statusGHTK', -1)->count();

        $info          = Information::get();

        $data = [
            'ordersSuccess'   => $ordersSuccess,
            'ordersShipping'  => $ordersShipping,
            'ordersReturning' => $ordersReturning,
            'ordersReturned'  => $ordersReturned,
            'ordersCanXuLy'   => $ordersCanXuLy,
            'ordersCanceled'  => $ordersCanceled,
            'info'            => $info,
        ];

        return view('orders.index', $data);
    }

    public function singleOrder($id)
    {
        $order = Order::where('id', $id)->first();
        $products = Product::where('order_id', $id)->get();
        $causes = Cause::where('order_id', $id)->orderBy('created_at', 'desc')->get();

        $data = [
            'order'    => $order,
            'products' => $products,
            'causes' => $causes
        ];

        return view('orders.singleOrder', $data);
    }

    function list() {
        $numberPage = 20;
        if ($_GET) {
            if (isset($_GET['show_number'])) {
                $numberPage = $_GET['show_number'];
            }
        }

        $query = new Order;
        if ($_GET) {
            if (isset($_GET['type_not_ghtk'])) {
                $query = $query->where('label_GHTK', '=', null);
            }
        }

        if ($_GET) {
            if (isset($_GET['template-type'])) {
                if ($_GET['template-type'] == 'success') {
                    $query = $query->whereIn('statusGHTK', [5, 6]);
                }

                if ($_GET['template-type'] == 'shipping') {
                    $query = $query->whereIn('statusGHTK', [2, 3, 4]);
                }

                if ($_GET['template-type'] == 'transferring') {
                    $query = $query->where('statusGHTK', 20);
                }

                if ($_GET['template-type'] == 'completed') {
                    $query = $query->where('statusGHTK', 21);
                }

                if ($_GET['template-type'] == 'NeedTreatment') {
                    $query = $query->whereIn('statusGHTK', [9, 10]);
                }

                if ($_GET['template-type'] == 'Canceled') {
                    $query = $query->where('statusGHTK', -1);
                }
            }
        }
        $query = $query->where('need_treatment', 0);
        $query = $query->latest()->paginate($numberPage);

        $info = Information::get();

        $data = [
            'orders' => $query,
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
                                'code'     => $product->productCode,
                                'quantity' => $product->quantity,
                                'weight'   => $product->weight,
                            ];
                        }
                        $orderSaveDB->products       = json_encode($products_id);

                        $orderSaveDB->status         = Order::STATUS_NEW_CREATEED;
                        $orderSaveDB->need_treatment = Order::STATUS_NEED_TREATMENT_FALSE;
                        $orderSaveDB->save();

                        $this->arrayOrder[] = [
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
                        $this->arrayOrder[] = [
                            'order'  => $orderDB,
                            'status' => 'CONTAIN_DB',
                        ];
                    }
                }

                if ($response->data->totalPages > 1) {
                    $this->searchDeQuy($response->data->totalPages, $response->data->page, $_GET['type'], $_GET['value']);
                }

                return json_encode($this->arrayOrder);
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

        return md5(md5(env('TOKEN_NHANHVN') . $dataString) . $dataString);
    }

    public function searchDeQuy($totalPages, $currentPage, $type, $value)
    {
        if (($totalPages - $currentPage) <= 0) {
            return $this->arrayOrder;
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

                            $this->arrayOrder[] = [
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
                            $this->arrayOrder[] = [
                                'order'  => $orderDB,
                                'status' => 'CONTAIN_DB',
                            ];
                        }
                    }

                    if (($response->data->totalPages - $response->data->page) > 0) {
                        $this->searchDeQuy($response->data->totalPages, $response->data->page, $_GET['type'], $_GET['value']);
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

    public function resetStatusOrder()
    {
        $orders = Order::get();

        foreach ($orders as $key => $item) {
            $orderUpdate = Order::where('id', $item->id)->update([
                'reason' => null
            ]);
        }

        var_dump('oke');
        die();
    }

    public function createCause(Request $request)
    {
        $data = $request->all();
        $order_update = Order::where('id', $data['order_id'])->update(['need_treatment' => Order::STATUS_NEED_TREATMENT_TRUE]);
        $cause = new Cause;
        $cause->order_id = $data['order_id'];
        $cause->content  = $data['content'];
        $cause->save();

        

        return response()->json(['success' => true, 'messages' => 'Bạn đã xử lý thành công']);
    }
}