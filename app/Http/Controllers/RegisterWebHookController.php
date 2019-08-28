<?php
namespace App\Http\Controllers;

use App\Entities\Deliverys;
use App\Entities\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 *
 */
class RegisterWebHookController extends Controller
{
    public function register()
    {
        $result = $this->webhook_url();
        var_dump($result);
        die();

        $url = route('listen-webhook');
        if ($url !== $result->data) {
            $delete = $this->curl("https://services.giaohangtietkiem.vn/services/webhook/del", ['url' => $result->data]);
        }

        $data = ['url' => route('listen-webhook')];
        $add  = $this->curl("https://services.giaohangtietkiem.vn/services/webhook/add", $data);

        if ($add->success) {
            $resultAddWebHook = $this->webhook_url();
        }

    }

    public function webhook_url()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => "https://services.giaohangtietkiem.vn/services/webhook",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER     => array(
                "Token: " . env('TOKEN_GHTK'),
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

    public function curl($url, $data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "POST",
            CURLOPT_POSTFIELDS     => $data,
            CURLOPT_HTTPHEADER     => array(
                "Token: " . env('TOKEN_GHTK'),
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }

    public function listenOrderGhtk(Request $request)
    {
        $data = $request->all();
        Log::info($data);
        $orderGhtk  = Deliverys::where('label', $data['label_id'])->update(['status_id' => $data['status_id']]);
        $orderNhanh = Order::where('label_GHTK', $data['label_id'])->update(['statusGHTK' => $data['status_id']]);
        Log::info($orderGhtk);
        Log::info($orderNhanh);
        return response()->json(['success' => true]);
    }

    public function test()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL            => "https://services.giaohangtietkiem.vn/services/shipment/v2/S6923320.BO.MT4.D1.416911708",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER     => array(
                "Token: " . env('TOKEN_GHTK'),
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        var_dump(json_decode($response));
        die();

        echo 'Response: ' . $response;
    }
}
