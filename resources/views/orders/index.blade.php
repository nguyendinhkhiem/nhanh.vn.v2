@extends('layouts.app')

@section('content')
	<div class="page_search_orders">
		<form id="search_order">
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
					<li class="item" data-type="id">
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

		<div class="categoris_order">
			<ul class="list">
				<li class="item Success">
					<a href="{{ route('list-nhanh') }}/?template-type=success">
						Thành công <span class="number">{{ $ordersSuccess }}</span>
					</a>
				</li>

				<li class="item Shipping">
					<a href="{{ route('list-nhanh') }}/?template-type=shipping">
						Đang chuyển <span class="number">{{ $ordersShipping }}</span>
					</a>
				</li>

				<li class="item Transferring">
					<a href="{{ route('list-nhanh') }}/?template-type=transferring">
						Đang chuyển hoàn <span class="number">{{ $ordersReturning }}</span>
					</a>
				</li>

				<li class="item Completed">
					<a href="{{ route('list-nhanh') }}/?template-type=completed">
						Đã hoàn <span class="number">{{ $ordersReturned }}</span>
					</a>
				</li>

				<li class="item NeedTreatment">
					<a href="{{ route('list-nhanh') }}/?template-type=NeedTreatment">
						Cần xử lý <span class="number">{{ $ordersCanXuLy }}</span>
					</a>
				</li>
			</ul>
		</div>

		<div class="response_search">
			<div class="header_order">
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
			</div>
			<table class="table">
			    <thead>
			        <tr>
			            <th scope="col"><input type="checkbox" name="choice_all" id="choice_all"></th>
			            <th scope="col">#</th>
			            <th scope="col">Mã ĐH</th>
			            <th scope="col">Ngày tạo</th>
			            <th scope="col">Khách Hàng</th>
			            <th scope="col">Số điện thoại</th>
			            <th scope="col">Trạng thái đơn hàng nhanh</th>
			            <th scope="col">Sản Phẩm</th>
			            <th scope="col">Tổng tiền</th>
			            <th scope="col">Trạng thái Search</th>
			        </tr>
			    </thead>
			    <tbody class="list_order_search" id="list_order_search">
			    </tbody>
			</table>
		</div>
	</div>
@endsection