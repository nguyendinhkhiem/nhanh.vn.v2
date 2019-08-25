<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function index()
    {
        // the storeId on e-commerce platforms, individual websites set $storeId = null;
        $storeId = null;

        $data = array(
            'customerMobile' => '0985830008',
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
//         curl_setopt($curl, CURLOPT_CAINFO, './cacert.pem');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $curlResult = curl_exec($curl);

        if (curl_error($curl) == "") {
            $response = json_decode($curlResult);
        } else {
            $response           = new stdClass();
            $response->code     = 0;
            $response->messages = array(
                curl_error($curl),
            );
        }
        curl_close($curl);

        var_dump($response);
        die();
    }

    function createChecksum($data){
    	if (is_array($data)) {
            $dataString = json_encode($data);
        } else {
            $dataString = $data;
        }

        var_dump(md5(md5('VYx44TFEAtyJffKkAFkR33aj' . $dataString) . $dataString));
        die();

        return md5(md5('VYx44TFEAtyJffKkAFkR33aj' . $dataString) . $dataString);
    }
}
