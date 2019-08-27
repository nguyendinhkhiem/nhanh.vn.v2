@extends('layouts.app')

@section('content')
	<div class="single_order">
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
					<li>
						<span class="label">Email:</span> {{ $order->customerEmail }}
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
	</div>
@endsection