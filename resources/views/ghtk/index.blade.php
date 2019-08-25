@extends('layouts.app')

@section('content')
	<div class="list_order_nhanh">
		<div class="create-ghtk">
			<div class="button-cancle">
				Huỷ đơn hàng
			</div>
		</div>
		<div class="list_order_list">
			<table class="table">
			    <thead>
			        <tr>
			            <th scope="col"><input type="checkbox" name="choice_all_ghtk" id="choice_all_ghtk"></th>
			            <th scope="col">label</th>
			            <th scope="col">partner_id</th>
			            <th scope="col">estimated_pick_time</th>
			            <th scope="col">estimated_deliver_time</th>
			            <th scope="col">tracking_id</th>
			            <th scope="col">status_id</th>
			        </tr>
			    </thead>
			    <tbody class="list_order_search">
			    	@foreach ($list as $key => $item)
			    		<tr class="item-ghtk">
					    	<th scope="row">
								<input class="item-ghtk-nhanh" type="checkbox" name="order_id_ghtk" data-ghtk="{{ $item->label }}" data-status="{{ $item->status_id }}">
							</th>
							<td>{{ $item->label }}</td>
							<td>{{ $item->partner_id }}</td>
							<td>{{ $item->estimated_pick_time }}</td>
							<td>{{ $item->estimated_deliver_time }}</td>
							<td>{{ $item->tracking_id }}</td>
							<td>{{ $item->status_id }}</td>
			    		</tr>
				    @endforeach
			    </tbody>
			</table>
			<div class="pagination" id="">
				{!! $list->links() !!}
			</div>
		</div>
	</div>
@endsection