<?php

namespace App\Http\Controllers;

use App\Entities\Deliverys;
use App\Entities\Information;
use App\Entities\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderGiaoHangTietKiemControllers extends Controller
{
    public function index()
    {
        $list = Deliverys::latest()
            ->paginate(12);

        $data = [
            'list' => $list,
        ];

        return view('ghtk.index', $data);
    }

    public function createGhtk(Request $request)
    {
        $data = $request->all();

        $infomation    = Information::where('id', $data['params']['info_received'])->first();
        $orderDataGHTK = [];

        $newArray = [];
        foreach ($data['params']['data_id'] as $key => $item) {
            $order = Order::where('id_nhanhvn', $item)->first();

            $dataProducts = json_decode($order->products);

            foreach ($dataProducts as $product) {
                $orderDataGHTK[$key]['products'][] = [
                    "name"     => $product->name,
                    "weight"   => 0.1,
                    "quantity" => (int) $product->quantity,
                ];
            }

            $orderDataGHTK[$key]['order'] = [
                "id"            => $order->id_nhanhvn,
                "pick_name"     => $infomation->pick_name,
                "pick_address"  => $infomation->pick_address,
                "pick_province" => $infomation->pick_province,
                "pick_district" => $infomation->pick_district,
                "pick_tel"      => $infomation->pick_tel,
                "tel"           => $order->customerMobile,
                "name"          => $order->customerName,
                "address"       => $order->customerAddress,
                "province"      => $order->customerCity,
                "district"      => $order->customerDistrict,
                "is_freeship"   => $data['params']['calcShip'],
                "pick_date"     => $order->createdDateTime,
                "pick_money"    => (int) $order->calcTotalMoney,
                "note"          => $order->description . "<br> CHO XEM HÀNG nếu khách không nghe máy hoặc không nhận hàng thì gọi về báo shop không được tự ý hoàn đơn",
                "value"         => 3000000,
                "transport"     => "fly",
            ];
        }

        $responseData = [];
        foreach ($orderDataGHTK as $i => $orderGhtk) {
            $dataString = $orderGhtk;
            if (is_array($orderGhtk)) {
                $dataString = json_encode($orderGhtk);
            }

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL            => "https://services.giaohangtietkiem.vn/services/shipment/order",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST  => "POST",
                CURLOPT_POSTFIELDS     => $dataString,
                CURLOPT_HTTPHEADER     => array(
                    "Content-Type: application/json",
                    "Token: 463eE26342a6e99379779711218C0cb2783E7a5b",
                    "Content-Length: " . strlen($dataString),
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $ketqua         = json_decode($response);
            $responseData[] = $ketqua;

            if ($ketqua->success == true) {
                $deliverys                         = new Deliverys;
                $deliverys->label                  = (string) ($ketqua->order->label);
                $deliverys->partner_id             = (string) ($ketqua->order->partner_id);
                $deliverys->area                   = (string) ($ketqua->order->area);
                $deliverys->fee                    = (string) ($ketqua->order->fee);
                $deliverys->insurance_fee          = (string) ($ketqua->order->insurance_fee);
                $deliverys->estimated_pick_time    = (string) ($ketqua->order->estimated_pick_time);
                $deliverys->estimated_deliver_time = (string) ($ketqua->order->estimated_deliver_time);
                $deliverys->tracking_id            = (string) ($ketqua->order->tracking_id);
                $deliverys->save();

                $orderUpdate = Order::where('id_nhanhvn', $ketqua->order->partner_id)->update([
                    'label_GHTK' => $ketqua->order->label,
                ]);
            }

        }

        if ($responseData) {
            return json_encode($responseData);
        }
    }

    public function cancleGhtk(Request $request)
    {
        $data = $request->all();
        $converResponse = '';
        $response = '';
        foreach ($data['params']['data_label'] as $key => $item) {
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL            => "https://services.giaohangtietkiem.vn/services/shipment/cancel/" . $item,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CUSTOMREQUEST  => "POST",
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_HTTPHEADER     => array(
                    "Token: 463eE26342a6e99379779711218C0cb2783E7a5b",
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $converResponse = json_decode($response);

            $response = json_decode($response);
        }

        if ($converResponse->success == true) {
            foreach ($data['params']['data_label'] as $key => $item) {
                $ghtkUpdate = Deliverys::where('label', $item)->update([
                    'status_id' => "-1",
                ]);
            }

            return $response;
        }
    }

    public function test()
    {
        $order = [
            'products' => [
                [
                    "name"     => "bút",
                    "weight"   => 0.1,
                    "quantity" => 1,
                ],
                [
                    "name"     => "tẩy",
                    "weight"   => 0.2,
                    "quantity" => 1,
                ],
            ],
            'order'    => [
                "id"            => "1111223ewewewewe23wew",
                "pick_name"     => "HCM-nội thành",
                "pick_address"  => "590 CMT8 P.11",
                "pick_province" => "TP. Hồ Chí Minh",
                "pick_district" => "Quận 3",
                "pick_tel"      => "0911222333",
                "tel"           => "0911222333",
                "name"          => "GHTK - HCM - Noi Thanh",
                "address"       => "123 nguyễn chí thanh",
                "province"      => "TP. Hồ Chí Minh",
                "district"      => "Quận 1",
                "is_freeship"   => "1",
                "pick_date"     => "2016-09-30",
                "pick_money"    => 47000,
                "note"          => "Khối lượng tính cước tối đa: 1.00 kg",
                "value"         => 3000000,
                "transport"     => "fly",
            ],
        ];

        $dataString = $order;
        if (is_array($order)) {
            $dataString = json_encode($order);
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => "https://services.giaohangtietkiem.vn/services/shipment/order",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $dataString,
            CURLOPT_HTTPHEADER     => array(
                "Content-Type: application/json",
                "Token: 463eE26342a6e99379779711218C0cb2783E7a5b",
                "Content-Length: " . strlen($dataString),
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        $ketqua = json_decode($response);
        var_dump($ketqua->order);
        die();
    }

    public function huy()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => "https://services.giaohangtietkiem.vn/services/shipment/cancel/S6923320.SG11.32A.499062097",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER     => array(
                "Token: 463eE26342a6e99379779711218C0cb2783E7a5b",
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        var_dump(json_decode($response));
        die();
    }
}
