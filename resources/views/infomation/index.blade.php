@extends('layouts.app')

@section('content')
	<div class="setting_orders">
		<table class="table">
		    <thead>
		        <tr>
		            <th scope="col">Tên người liên hệ</th>
		            <th scope="col">Địa chỉ ngắn gọn</th>
		            <th scope="col">Tên tỉnh/thành phố</th>
		            <th scope="col">Tên quận/huyện</th>
		            <th scope="col">Tên phường/xã</th>
		            <th scope="col">Tên đường/phố nơi</th>
		            <th scope="col">Số điện thoại</th>
		            <th scope="col">Email</th>
		        </tr>
		    </thead>
		    <tbody class="list_order_search">
		    	@foreach ($list as $element)
			    	<tr>
				    	<td>{{ $element->pick_name }}</td>
				    	<td>{{ $element->pick_address }}</td>
				    	<td>{{ $element->pick_province }}</td>
				    	<td>{{ $element->pick_district }}</td>
				    	<td>{{ $element->pick_ward }}</td>
				    	<td>{{ $element->pick_street }}</td>
				    	<td>{{ $element->pick_tel }}</td>
				    	<td>{{ $element->pick_email }}</td>
			    	</tr>
		    	@endforeach
		    </tbody>
		</table>

		<form id="create-info">
		    <div class="form-group">
		        <label for="pick_name">Tên người liên hệ lấy hàng hóa</label>
		        <input type="text" class="form-control" id="pick_name" name="pick_name" placeholder="Tên người liên hệ lấy hàng hóa">
		    </div>
		    <div class="form-group">
		        <label for="pick_address">Địa chỉ ngắn gọn để lấy nhận hàng hóa</label>
		        <input type="text" class="form-control" id="pick_address" name="pick_address" placeholder="Địa chỉ ngắn gọn để lấy nhận hàng hóa">
		    </div>
		    <div class="form-group">
		        <label for="pick_province">Tên tỉnh/thành phố nơi lấy hàng hóa</label>
		        <input type="text" class="form-control" id="pick_province" name="pick_province" placeholder="Tên tỉnh/thành phố nơi lấy hàng hóa">
		    </div>
		    <div class="form-group">
		        <label for="pick_district">Tên quận/huyện nơi lấy hàng hóa</label>
		        <input type="text" class="form-control" id="pick_district" name="pick_district" placeholder="Tên quận/huyện nơi lấy hàng hóa">
		    </div>
		    <div class="form-group">
		        <label for="pick_ward">Tên phường/xã nơi lấy hàng hóa</label>
		        <input type="text" class="form-control" id="pick_ward" name="pick_ward" placeholder="Tên phường/xã nơi lấy hàng hóa">
		    </div>
		    <div class="form-group">
		        <label for="pick_street"> Tên đường/phố nơi lấy hàng hóa</label>
		        <input type="text" class="form-control" id="pick_street" name="pick_street" placeholder=" Tên đường/phố nơi lấy hàng hóa">
		    </div>
		    <div class="form-group">
		        <label for="pick_tel">Số điện thoại liên hệ nơi lấy hàng hóa</label>
		        <input type="text" class="form-control" id="pick_tel" name="pick_tel" placeholder="Số điện thoại liên hệ nơi lấy hàng hóa">
		    </div>
		    <div class="form-group">
		        <label for="pick_email">Email liên hệ nơi lấy hàng hóa</label>
		        <input type="text" class="form-control" id="pick_email" name="pick_email" placeholder="Email liên hệ nơi lấy hàng hóa">
		    </div>
		    <button type="submit" class="btn btn-primary">Submit</button>
		</form>
	</div>
@endsection