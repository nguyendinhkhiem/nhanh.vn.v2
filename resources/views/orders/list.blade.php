@extends('layouts.app')

@section('content')
	<div class="list_order_nhanh">
		{{-- <div class="header_order">
			<form id="search_order_list">
				@csrf
				<div class="choice_type_search">
					<input type="hidden" id="type_serch_input" name="type_serch_input" value="handoverId">
					<p class="type_current_order">
						<span class="name">ID Biên bản bàn giao</span>
						<span class="icon">
							<svg class="icon-down" width="8" height="4" viewBox="0 0 8 4" fill="none" xmlns="http://www.w3.org/2000/svg">
	                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.86983 0.117157C8.04339 0.273367 8.04339 0.526633 7.86983 0.682843L4.31427 3.88284C4.1407 4.03905 3.8593 4.03905 3.68573 3.88284L0.130175 0.682843C-0.0433913 0.526633 -0.0433912 0.273367 0.130175 0.117157C0.303741 -0.0390527 0.585148 -0.0390528 0.758714 0.117157L4 3.03431L7.24129 0.117157C7.41485 -0.0390525 7.69626 -0.0390524 7.86983 0.117157Z" fill="#4F4F4F"/>
	                        </svg>

	                        <svg class="icon-up" width="8" height="4" viewBox="0 0 8 4" fill="none" xmlns="http://www.w3.org/2000/svg">
	                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.130175 3.88284C-0.0433916 3.72663 -0.0433916 3.47337 0.130175 3.31716L3.68573 0.117157C3.8593 -0.0390531 4.1407 -0.0390532 4.31427 0.117157L7.86982 3.31716C8.04339 3.47337 8.04339 3.72663 7.86982 3.88284C7.69626 4.03905 7.41485 4.03905 7.24129 3.88284L4 0.965685L0.758714 3.88284C0.585148 4.03905 0.303741 4.03905 0.130175 3.88284Z" fill="#4F4F4F"/>
	                        </svg>
						</span>
					</p>
					<ul class="list">
						<li class="item" data-type="handoverId">
							ID Biên bản bàn giao
						</li>
						<li class="item" data-type="id_nhanhvn">
							ID đơn hàng của Nhanh
						</li>
						<li class="item" data-type="customerMobile">
							SĐT khách hàng
						</li>
					</ul>
				</div>
				<div class="input_search">
					<input type="number" value="" name="search_order_input" id="search_order_input" placeholder="Nhập thông tin">
				</div>
				<div class="button_submit">
					<input type="submit" name="submit_search_orders">
				</div>
			</form>
			<div class="create-ghtk">
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
					    <button type="submit" class="btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
		</div> --}}

		<div class="header_order">
			<div class="search_order">
				<form id="search_order_list_info">
					@csrf
					<div class="choice_type_search">
						<input type="hidden" id="type_serch_input" name="type_serch_input" value="label_GHTK">
						<p class="type_current_order">
							<span class="name">ID Giao Hàng Tiết Kiệm</span>
							<span class="icon">
								<svg class="icon-down" width="8" height="4" viewBox="0 0 8 4" fill="none" xmlns="http://www.w3.org/2000/svg">
		                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.86983 0.117157C8.04339 0.273367 8.04339 0.526633 7.86983 0.682843L4.31427 3.88284C4.1407 4.03905 3.8593 4.03905 3.68573 3.88284L0.130175 0.682843C-0.0433913 0.526633 -0.0433912 0.273367 0.130175 0.117157C0.303741 -0.0390527 0.585148 -0.0390528 0.758714 0.117157L4 3.03431L7.24129 0.117157C7.41485 -0.0390525 7.69626 -0.0390524 7.86983 0.117157Z" fill="#4F4F4F"/>
		                        </svg>

		                        <svg class="icon-up" width="8" height="4" viewBox="0 0 8 4" fill="none" xmlns="http://www.w3.org/2000/svg">
		                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.130175 3.88284C-0.0433916 3.72663 -0.0433916 3.47337 0.130175 3.31716L3.68573 0.117157C3.8593 -0.0390531 4.1407 -0.0390532 4.31427 0.117157L7.86982 3.31716C8.04339 3.47337 8.04339 3.72663 7.86982 3.88284C7.69626 4.03905 7.41485 4.03905 7.24129 3.88284L4 0.965685L0.758714 3.88284C0.585148 4.03905 0.303741 4.03905 0.130175 3.88284Z" fill="#4F4F4F"/>
		                        </svg>
							</span>
						</p>
						<ul class="list">
							<li class="item" data-type="id_nhanhvn">
								ID Order Nhanh.vn
							</li>
							<li class="item" data-type="label_GHTK">
								ID Giao Hàng Tiết Kiệm
							</li>
							<li class="item" data-type="customerName">
								Tên Khách Hàng
							</li>
							<li class="item" data-type="customerMobile">
								Số Điện Thoại Khách Hàng
							</li>
							<li class="item" data-type="customerAddress">
								Địa Chỉ Khách Hàng
							</li>
						</ul>
					</div>
					<div class="input_search">
						<input type="text" value="" name="search_order_input" required="true" id="search_order_input" placeholder="Nhập thông tin">
					</div>
					<div class="button_submit">
						<input type="submit" name="submit_search_orders">
					</div>
				</form>
			</div>
			<div class="create_order_on_ghtk">
				<form id="info-call-ghtk-new">
				    <div class="form-group">
				        <select class="form-control" id="info-received">
				            @foreach ($info as $item)
				                <option data-id="{{ $item->id }}">{{ $item->pick_name }}</option>
				            @endforeach
				        </select>
				    </div>
				    <button type="submit" class="btn btn-primary">Đăng Ký Đơn lên GHTK</button>
				</form>
			</div>
			<div style="width: 20%;position: relative;">
				<div class="action_list">
					<div class="contain">
						<svg aria-hidden="true" focusable="false" data-prefix="fal" data-icon="ellipsis-h" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-ellipsis-h fa-w-10"><path fill="currentColor" d="M192 256c0 17.7-14.3 32-32 32s-32-14.3-32-32 14.3-32 32-32 32 14.3 32 32zm88-32c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32zm-240 0c-17.7 0-32 14.3-32 32s14.3 32 32 32 32-14.3 32-32-14.3-32-32-32z" class=""></path></svg>
					</div>
				</div>
				<ul class="list_action">
					<li class="">
						Đơn hàng chưa lên GHTK
					</li>
				</ul>
			</div>
		</div>
		<div class="list_order_list">
			<table class="table">
			    <thead>
			        <tr>
			            <th scope="col"><input type="checkbox" name="choice_all" id="choice_all"></th>
			            <th scope="col">Mã ĐH</th>
			            <th scope="col">Mã Đơn GHTK</th>
			            <th scope="col">Khách Hàng</th>
			            <th scope="col">Số điện thoại</th>
			            <th scope="col">Sản Phẩm</th>
			            <th scope="col">Tổng tiền</th>
			            <th scope="col">Trạng thái đơn hàng nhanh</th>
			            <th scope="col">Trạng thái GHTK</th>
			        </tr>
			    </thead>

			    <tbody class="list_order_search" id="search_list_order_clone">
			    	@foreach ($orders as $key => $item)
			    		@php
			    			$nameProducts = '';
			    			$products = json_decode($item->products);

			    			foreach ($products as $i => $product) {
			    				if ($i > 0) {
			    					$nameProducts .= '<br> ' . $product->name;
			    				}else{
			    					$nameProducts .= $product->name;
			    				}
			    			}
			    		@endphp
				    	<tr class="item" data-idNhanh="{{ $item->id_nhanhvn }}" data-status="{{ $item->statusCode }}">
							<th scope="row">
								<input class="item-order-nhanh" type="checkbox" name="order_id_nhanh" data-idNhanh="{{ $item->id_nhanhvn }}" data-status="{{ $item->statusCode }}">
							</th>
							<td><a href="{!! route('single-order', $item->id) !!}">{{ $item->id_nhanhvn }}</a></td>
							<td>{{ $item->label_GHTK }}</td>
							<td>{{ $item->customerName }}</td>
							<td>{{ $item->customerMobile }}</td>
							<td>{!! $nameProducts !!}</td>
							<td>{{ $item->calcTotalMoney }}</td>
							<td>{{ $item->statusName }}</td>
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
	<!-- Modal -->
	<div class="modal fade" id="exampleModalCenterListOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	    <div class="modal-dialog modal-dialog-centered" role="document">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	            </div>
	            <div class="modal-body" id="ketqua_create_ghtk">
	            </div>
	        </div>
	    </div>
	</div>
@endsection