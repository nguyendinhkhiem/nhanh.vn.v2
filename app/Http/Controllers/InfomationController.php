<?php

namespace App\Http\Controllers;

use App\Entities\Information;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InfomationController extends Controller
{
    public function index()
    {
    	$list = Information::get();

    	$data = [
    		'list' => $list
    	];

        return view('infomation.index', $data);
    }

    public function create(Request $request)
    {
        $data = $request->all();

        $information                = new Information;
        $information->pick_name     = $data['params']['pick_name'];
        $information->pick_address  = $data['params']['pick_address'];
        $information->pick_province = $data['params']['pick_province'];
        $information->pick_district = $data['params']['pick_district'];
        $information->pick_ward     = $data['params']['pick_ward'];
        $information->pick_street   = $data['params']['pick_street'];
        $information->pick_email    = $data['params']['pick_email'];
        $information->pick_tel      = $data['params']['pick_tel'];
        $information->save();
        
        if ($information) {
        	return json_encode($information);
        }
    }
}
