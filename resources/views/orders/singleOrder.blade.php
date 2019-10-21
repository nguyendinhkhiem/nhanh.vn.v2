@extends('layouts.app')

@section('content')
	<div class="single_order">
			@if ($order->need_treatment == 0)
			<div class="need_treatment_order">
				@if ($order->statusGHTK == 9 || $order->statusGHTK == 10)
					<div class="update_status_order" data-id="{{ $order->id }}">
						Đã xử lý
					</div>
					<!-- Modal -->
					<div class="modal fade" id="exampleModalLyDo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					    <div class="modal-dialog" role="document">
					        <div class="modal-content">
					            <div class="modal-header">
					                <h5 class="modal-title" id="exampleModalLabel">Xử Lý Đơn Hàng</h5>
					                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					                    <span aria-hidden="true">&times;</span>
					                </button>
					            </div>
					            <div class="modal-body">
					            	<div class="form-group">
									    <label for="exampleFormControlLyDo">Nhập nội dung xử lý đơn hàng</label>
									    <textarea class="form-control" id="exampleFormControlLyDo" rows="3"></textarea>
									  </div>
					            </div>
					            <div class="modal-footer">
					                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
					                <button type="button" id="submit_update_order" class="btn btn-primary">Lưu lại</button>
					            </div>
					        </div>
					    </div>
					</div>
				@endif
				</div>
			@endif
		<div class="infomation">
			<div class="info-order">
				<ul>
					<li>
						<span class="label">Phí vận chuyển:</span>  {{ number_format($order->shipFee, 0, ',', '.') }}
					</li>
					<li>
						<span class="label">Phí thu của khách:</span>  {{ number_format($order->customerShipFeey, 0, ',', '.') }}
					</li>
					<li>
						<span class="label">Tổng tiền:</span> {{ number_format($order->calcTotalMoney, 0, ',', '.') }}
					</li>
				</ul>
			</div>
			<div class="info-khach">
				<ul>
					<li>
						<span class="label">Tên khách:</span> {{ $order->customerName }}
					</li>
					<li>
						<span class="label">Số Điện thoại:</span> {{ $order->customerMobile }}
					</li>
					<li>
						<span class="label">Địa chỉ:</span> {{ $order->customerAddress }}
					</li>
					<!-- <li>
						<span class="label">Email:</span> {{ $order->customerEmail }}
					</li> -->
				</ul>
			</div>

			<div class="info-giaohang">
				<ul>
					<li>
						<span class="label">Trạng thái đơn:</span> 
						@if ($order->statusGHTK == '-1')
							<span class="Dahuy">Đã huỷ</span>
						@elseif ($order->statusGHTK == '4' || $order->statusGHTK == '3'|| $order->statusGHTK == '2')
							<span class="Dangchuyen">Đang giao hàng</span>
						@elseif ($order->statusGHTK == '5' || $order->statusGHTK == '6')
							<span class="Thanhcong">Thành công</span>
						@elseif ($order->statusGHTK == '9' || $order->statusGHTK == '10')
							<span class="Canxuly">Cần xử lý</span>
						@elseif ($order->statusGHTK == '20')
							<span class="Dangchuyenhoan">Đang chuyển hoàn</span>
						@elseif ($order->statusGHTK == '21')
							<span class="Dahoan">Đã hoàn</span>
						@else
							{{ $order->statusGHTK }}
						@endif
					</li>
					<li>
						<span class="label">Lý do:</span> {{ $order->reason_code }}
					</li>
					<li>
						<span class="label">Ghi chú giao hàng:</span>
						@php
							$dataOrder = json_decode($order->reason);
							
						@endphp
						<ul>
						@foreach ($dataOrder as $data)
							<li>{{ $data }}</li>
						@endforeach
						</ul>
					</li>
				</ul>
			</div>

		</div>
		<div class="list_products">
			<table class="table table-bordered">
			    <thead>
			        <tr>
			            <th>Sản phẩm</th>
			            <th>ĐVT</th>
			            <th title="Khối lượng">KL</th>
			            <th title="Số lượng">SL</th>
			            <th>Giá</th>
			            <th title="Chiết khấu">C.Khấu</th>
			            <th>Thành tiền</th>
			            <th>Ghi chú</th>
			        </tr>
			    </thead>
			    <tbody>
			    	@foreach ($products as $product)
				        <tr>
				            <td style="max-width: 200px;">{{ $product->productName }}</td>
				            <td class="colUnit text-center"></td>
				            <td class="text-right">{{ $product->weight }}</td>
				            <td class="text-right">{{ $product->quantity }}</td>
				            <td class="text-right" data-vat="" data-vatmoney="0">{{ number_format($product->price, 0, ',', '.') }}</td>
				            <td class="text-right" data-discount="0"></td>
				            <td class="text-right">{{ number_format($product->price * $product->quantity, 0, ',', '.') }}</td>
				            <td style="max-width: 200px;overflow: auto;">{{ $product->description }}</td>
				        </tr>
			    	@endforeach
			    </tbody>
			    <tfoot></tfoot>
			</table>
		</div>


		@if ($causes->count() > 0)
			<div class="list_causes">
				<p class="title">
					Lịch sử xử lý
				</p>
				<table class="table table-dark">
				    <thead>
				        <tr>
				            <th scope="col">#</th>
				            <th scope="col">Content</th>
				            <th scope="col">Thời gian</th>
				        </tr>
				    </thead>
				    <tbody>
				    	@foreach ($causes as $key => $item)
							<tr>
					            <th scope="row">{{ $key + 1 }}</th>
					            <td>{{ $item->content }}</td>
					            <td>{{ $item->created_at }}</td>
					        </tr>
						@endforeach
				    </tbody>
				</table>
			</div>

		@else
			<div class="list_causes">
				<p class="title">
					Chưa có lịch sử xử lý
				</p>
			</div>
		@endif

	</div>
@endsection
