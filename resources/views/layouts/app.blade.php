<!DOCTYPE html>
<html>
	@include('partials.head')
<body>
	<main>
		<div class="menu">
			<ul class="list">
				<li class="item">
					<a href="{!! route('page-search') !!}">Trang chủ</a>
				</li>

				<!-- <li class="item">
					<a href="{!! route('list-ghtk') !!}">Danh sách đơn hàng tiết kiệm</a>
				</li> -->

				<li class="item">
					<a href="{!! route('list-nhanh') !!}">Danh sách Đơn hàng</a>
				</li>
			</ul>
		</div>

		<!-- Loading -->
		<div class="loading"> <svg class="lds-spinner" width="58px" height="58px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" style="background: none;"> <g transform="rotate(0 50 50)"> <rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#ffffff"> <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="0.9s" begin="-0.8250000000000001s" repeatCount="indefinite"></animate> </rect> </g> <g transform="rotate(30 50 50)"> <rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#ffffff"> <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="0.9s" begin="-0.75s" repeatCount="indefinite"></animate> </rect> </g> <g transform="rotate(60 50 50)"> <rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#ffffff"> <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="0.9s" begin="-0.6749999999999999s" repeatCount="indefinite"></animate> </rect> </g> <g transform="rotate(90 50 50)"> <rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#ffffff"> <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="0.9s" begin="-0.6s" repeatCount="indefinite"></animate> </rect> </g> <g transform="rotate(120 50 50)"> <rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#ffffff"> <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="0.9s" begin="-0.525s" repeatCount="indefinite"></animate> </rect> </g> <g transform="rotate(150 50 50)"> <rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#ffffff"> <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="0.9s" begin="-0.45s" repeatCount="indefinite"></animate> </rect> </g> <g transform="rotate(180 50 50)"> <rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#ffffff"> <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="0.9s" begin="-0.375s" repeatCount="indefinite"></animate> </rect> </g> <g transform="rotate(210 50 50)"> <rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#ffffff"> <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="0.9s" begin="-0.3s" repeatCount="indefinite"></animate> </rect> </g> <g transform="rotate(240 50 50)"> <rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#ffffff"> <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="0.9s" begin="-0.225s" repeatCount="indefinite"></animate> </rect> </g> <g transform="rotate(270 50 50)"> <rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#ffffff"> <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="0.9s" begin="-0.15s" repeatCount="indefinite"></animate> </rect> </g> <g transform="rotate(300 50 50)"> <rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#ffffff"> <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="0.9s" begin="-0.075s" repeatCount="indefinite"></animate> </rect> </g> <g transform="rotate(330 50 50)"> <rect x="47" y="24" rx="9.4" ry="4.8" width="6" height="12" fill="#ffffff"> <animate attributeName="opacity" values="1;0" keyTimes="0;1" dur="0.9s" begin="0s" repeatCount="indefinite"></animate> </rect> </g> </svg></div>

		@yield('content')

	</main>

	<!-- Modal -->
	<div class="modal fade" id="exampleModalCenterListOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	    <div class="modal-dialog modal-dialog-centered" role="document">
	        <div class="modal-content">
	            <div class="modal-header">
	                <h5 class="modal-title" id="exampleModalLongTitle">Đăng đơn sang GHTK</h5>
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                    <span aria-hidden="true">&times;</span>
	                </button>
	            </div>
	            <div class="modal-body" id="ketqua_create_ghtk">
	            </div>
	        </div>
	    </div>
	</div>
	
    @include('partials.footer')
        
    @show
</body>
</html>