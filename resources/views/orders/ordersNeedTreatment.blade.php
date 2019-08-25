@extends('layouts.app')

@section('content')
	<div class="list_order_nhanh">
		<div class="create-ghtk">
			<div class="button-create">
				Tạo order GHTK
			</div>
			<div class="info-call-ghtk">
				<form id="info-call-ghtk">
				    <div class="form-group">
				        <label for="info-received">Chọn thông tin lấy hàng hóa</label>
				        <select class="form-control" id="info-received">
				            @foreach ($info as $item)
				                <option data-id="{{ $item->id }}">{{ $item->pick_name }}</option>
				            @endforeach
				        </select>
				    </div>
				    <div class="form-group">
				        <label for="money_ship">Example select</label>
				        <select class="form-control" id="money_ship">
				            <option data-ship="1">Freeship</option>
				            <option data-ship="0">Tính Phí</option>
				        </select>
				    </div>
				    <button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
		<div class="list_order_list">
			<table class="table">
			    <thead>
			        <tr>
			            <th scope="col"><input type="checkbox" name="choice_all" id="choice_all"></th>
			            <th scope="col">Mã ĐH</th>
			            <th scope="col">Ngày tạo</th>
			            <th scope="col">Khách Hàng</th>
			            <th scope="col">Số điện thoại</th>
			            <th scope="col">Trạng thái đơn hàng nhanh</th>
			            <th scope="col">Sản Phẩm</th>
			            <th scope="col">Tổng tiền</th>
			            <th scope="col">Trạng thái GHTK</th>
			        </tr>
			    </thead>
			    <tbody class="list_order_search">
			    	@foreach ($orders as $key => $item)
				    	<tr class="item" data-idNhanh="{{ $item->id_nhanhvn }}" data-status="{{ $item->statusCode }}">
							<th scope="row">
								<input class="item-order-nhanh" type="checkbox" name="order_id_nhanh" data-idNhanh="{{ $item->id_nhanhvn }}" data-status="{{ $item->statusCode }}">
							</th>
							<td>{{ $item->id_nhanhvn }}</td>
							<td>{{ $item->createdDateTime }}</td>
							<td>{{ $item->customerName }}</td>
							<td>{{ $item->customerId }}</td>
							<td>{{ $item->statusName }}</td>
							<td></td>
							<td>{{ $item->calcTotalMoney }}</td>
							@if($item->label_GHTK != null)
								<td>{{ $item->label_GHTK }}</td>
							@else
								<td>Chưa lên GHTK</td>
							@endif
					    </tr>
				    @endforeach
			    </tbody>
			</table>
			<div class="pagination" id="">
				{!! $orders->links() !!}
			</div>
		</div>
	</div>
@endsection