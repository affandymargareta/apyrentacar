

@extends('layouts.landingpage')


@section('title')
    <title>Home, Situs Belanja Online dan Rental Car Mudah Terpercaya | Apy Rental A Car</title>
@endsection

@section('content')


    <!-- END nav -->
	<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('images/innova2019.png') }}');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Booking <i class="ion-ios-arrow-forward"></i></span></p>
            <!-- <h1 class="mb-3 bread">Booking</h1> -->
          </div>
        </div>
      </div>
    </section>
		

	<section class="ftco-section ftco-car-details">
		<div class="container">
	  
			<div class="row">
				<div class="col-lg-4 order-md-2 mb-4">
					<div class="card">
						<h6 class="card-header" style="color : #000;">Rental Mobil Dengan Sopir</h6>
						<div class="card-body">
							<ul class="list-group list-group-flush">
								<li class="list-group-item"><h6 class="card-title" style="color : #000;">{{ $cart->product->productName->name }}</h6></li>

								<li class="list-group-item" style="color : #000;">Disediakan oleh {{ $cart->seller->name }}.</li>
							</ul>
							<ul class="list-group list-group-flush">
								<li class="list-group-item" style="color : #000;">Kota/Wilayah Rental.</li>
								<li class="list-group-item" style="color : #000;">{{ $cart->wilayah }}</li>
								<li class="list-group-item" style="color : #000;">Tanggal Rental.</li>
								<li class="list-group-item" style="color : #000;">{{ date("D, d F Y", strtotime($cart->mulai)) }},  - {{$durasi}}</li>
								<li class="list-group-item" style="color : #000;">Lokasi Jemput.</li>
								<li class="list-group-item" style="color : #000;">{{ $jemputCity->city_name  ?? ''  }}.</li>
								<li class="list-group-item" style="color : #000;">Durasi Rental</li>
								<li class="list-group-item" style="color : #000;">{{ $cart->durasi }} Hari.</li>
								<li class="list-group-item" style="color : #000;">Waktu Jemput.</li>
								<li class="list-group-item" style="color : #000;">{{ $cart->jam_mulai }}.</li>
								@if ($cart->lokasi_kembali > 0)
									<li class="list-group-item" style="color : #000;">Lokasi Kembali.</li>
									<li class="list-group-item" style="color : #000;">{{ $kembaliCity->city_name  ?? ''  }}.</li>
								@endif
								

							</ul>
						</div>
					</div>
				</div>

				<div class="col-lg-8 order-md-1">
					<h4 class="mb-3" style="color : #000;">Booking</h4>
					@if ($cart->customer_name > 0)
					<ul class="list-group">
						<li class="list-group-item" style="background-color: rgba(0, 0, 0, 0.03); color : #000;">Data Pemesanan</li>
						<li class="list-group-item" style="color : #000;">Name : {{ $cart->customer_name }}</li>
						<li class="list-group-item" style="color : #000;">No Handphone : {{ $cart->customer_telpon }}</li>
						<li class="list-group-item" style="color : #000;">Email : {{ $cart->customer_email }}</li>
					</ul>
					@else
					<!-- <form class="needs-validation" novalidate> -->
					<form method="post" action="{{ route('cartupdate', $cart->id) }}" enctype="multipart/form-data">               
                      @method('PUT')
                      @csrf
						<div class="mb-3">
							<label for="address" style="color : #000;">Nama Lengkap</label>
							<input type="text" name="customer_name" class="form-control" id="address" placeholder="Nama Lengkap" required>
							<div class="invalid-feedback" style="color : #000;">
							Please enter your Nama Lengkap.
							</div>
						</div>

						<div class="mb-3">
							<label for="address" style="color : #000;">No Handpone</label>
							<input type="text" name="customer_telpon" class="form-control" id="number" placeholder="No Handpone" required>
							<div class="invalid-feedback" style="color : #000;">
							Please enter your No Handpone.
							</div>
						</div>
						
						<div class="mb-3"> 
							<label for="address" style="color : #000;">Email</label>
							<input type="email" name="customer_email"  class="form-control" id="email" placeholder="Email" required>
							<div class="invalid-feedback" style="color : #000;">
							Please enter your Email.
							</div>
						</div>
						
						<button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
					</form>
					@endif
					<ul class="list-group" style="margin-top: 15px;">
						@if ($cart->lokasi_jemput > 0)
							@if ($cart->jemput_id != $cart->product->wilayah)
								<li class="list-group-item" style="background-color: rgba(0, 0, 0, 0.03); color : #000;">Lokasi Jemput</li>
								<li class="list-group-item" style="color : #000;">{{ $jemputCity->city_name  ?? ''  }}</li>
								<li class="list-group-item" style="color : #000;">Zona {{ $jemputPrice->zona  ?? ''  }}</li>
							@else
								<li class="list-group-item" style="background-color: rgba(0, 0, 0, 0.03); color : #000;">Lokasi Jemput</li>
								<li class="list-group-item" style="color : #000;">{{ $jemputCity->city_name  ?? ''  }}</li>
								<li class="list-group-item" style="color : #000;">Free</li>
							@endif
						@endif
					</ul>
					<ul class="list-group" style="margin-top: 15px;">
						@if ($cart->lokasi_kembali > 0)
							@if ($cart->kembali_id != $cart->product->wilayah)
							<li class="list-group-item" style="background-color: rgba(0, 0, 0, 0.03); color : #000;">Lokasi Kembali</li>
								<li class="list-group-item" style="color : #000;">{{ $kembaliCity->city_name  ?? ''  }}</li>
								<li class="list-group-item" style="color : #000;">Zona {{ $kembaliPrice->zona  ?? ''  }}</li>
							@else
								<li class="list-group-item" style="background-color: rgba(0, 0, 0, 0.03); color : #000;">Lokasi Kembali</li>
								<li class="list-group-item" style="color : #000;">{{ $kembaliCity->city_name  ?? ''  }}</li>
								<li class="list-group-item" style="color : #000;">Free</li>
							@endif
						@endif
					</ul>

					<div class="card" style="margin-top: 15px;">
						<div class="panel-group" id="accordion">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title" style="border: 1px solid #ced4da; padding: 0.375rem 0.75rem; background: rgba(0, 0, 0, 0.03); color : #000;">
									<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
										Rincian Harga
									</a><span style="padding-left: 350px; " style="color : #000;">{{ formatUang($cart->price)}}</span>
									</h4>
								</div>
								<div class="card-body">
									<p class="card-text" style="color : #000;">Harga Total</p>
									<p class="card-text">
									<span id="total" style="color : #000;">{{ formatUang($cart->price)}}</span>
									</p>
									<form method="post" action="{{ route('orders.store') }}" enctype="multipart/form-data">
									@method('POST')
									@csrf
									<input type="hidden" name="cart_id" value="{{ $cart->id }}" class="form-control">

									<button type="submit" class="btn btn-primary btn-lg btn-block" id="submit-post" >Order</button>
									</form>
								</div>
								<div id="collapseOne" class="panel-collapse collapse in">
									<div class="panel-body">
										<ul class="list-group">
											<li class="list-group-item d-flex justify-content-between align-items-center" style="color : #000;">
												{{ $cart->product->productName->name }} x {{ $cart->durasi }}
												<span style="color : #000;">{{ formatUang($cart->product->price * $cart->durasi)}}</span>
											</li>
											@if ($cart->jemput_id > 0)
												@if ($cart->jemput_id != $cart->product->wilayah)
													<li class="list-group-item d-flex justify-content-between align-items-center" style="color : #000;">
														Penjemputan di Area {{ $jemputPrice->zona  ?? ''  }} x {{ $cart->durasi }}
														<span style="color : #000;">{{ formatUang($jemputPrice->price * $cart->durasi ?? '') }}</span>
													</li>
												@else

												@endif
											@endif

											@if ($cart->kembali_id > 0)
												@if ($cart->kembali_id != $cart->product->wilayah)
													<li class="list-group-item d-flex justify-content-between align-items-center" style="color : #000;">
														Pengantaran di Area {{ $kembaliPrice->zona  ?? ''  }} x {{ $cart->durasi }}
														<span style="color : #000;">{{ formatUang($kembaliPrice->price * $cart->durasi ?? '') }}</span>
													</li>
												@else

												@endif
											
											@endif
											@if ($cart->addon_price > 0)
												<li class="list-group-item d-flex justify-content-between align-items-center" style="color : #000;">
													Bensin 120 Km dan Makan Sopir x {{ $cart->addon_hari }} Hari / Days 
													<span style="color : #000;">{{ formatUang($cart->addon_price * $cart->addon_hari) }}</span>
												</li>
											@endif
											<li class="list-group-item d-flex justify-content-between align-items-center" style="color : #000;">
												Biaya Aplikasi
												<span style="color : #000;">{{ formatUang($cart->biaya_aplikasi) }}</span>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
			
				</div>
			</div>

		</div>
    </section>
	<!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>



@endsection