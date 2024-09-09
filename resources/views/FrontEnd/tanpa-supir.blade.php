@extends('layouts.landingpage')


@section('title')
<title>Home, Situs Belanja Online dan Rental Car Mudah Terpercaya | Apy Rental A Car</title>
@endsection

@section('content')


<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('images/innova2019.png') }}');" data-stellar-background-ratio="0.5">
	<div class="overlay"></div>
	<div class="container">
		<div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
			<div class="col-md-9 ftco-animate pb-5">
				<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span class="mr-2"><a href="blog.html">Blog <i class="ion-ios-arrow-forward"></i></a></span> <span>Blog Single <i class="ion-ios-arrow-forward"></i></span></p>
				<!-- <h1 class="mb-3 bread">Read our blog</h1> -->
			</div>
		</div>
	</div>
</section>

<section class="ftco-section ftco-degree-bg">
	<div class="container">

		<form method="post" action="{{ route('cartstore1') }}" enctype="multipart/form-data">
			@method('POST')
			@csrf
			<input type="hidden" name="biaya_aplikasi" value="3000" class="form-control">
			<input type="hidden" name="product_id" value="{{ $product->id }}" class="form-control">
			<input type="hidden" class="form-control" name="wilayah" value="{{  $search['wilayah'] }}">
			<input type="hidden" class="form-control" name="mulai" value="{{  $search['mulai'] }}">
			<input type="hidden" class="form-control" name="akhir" value="{{  $search['akhir'] }}">
			<input type="hidden" class="form-control" name="durasi" value="{{  $durasi }}">
			<input type="hidden" class="form-control" name="jam_mulai" value="{{  $search['jam_mulai'] }}">
			<input type="hidden" class="form-control" name="jam_akhir" value="{{  $search['jam_akhir'] }}">
			<!-- <form action="javascript:void(0)" id="frm-create-post" method="post"> -->
			<div class="row">
				<div class="col-lg-12"> 
					<div class="card" style="background : rgb(158 158 158 / 40%);">
						<div class="card-body">
							<p class="card-text" style="margin-bottom: 5px; color : #000;">Rental Mobil : Tanpa Sopir / </p>
							<h5 class="card-title" style="margin-bottom: 5px; color : #000;">Rental Mobil Tanpa Supir / Rent A Car Car Rental Without Driver
							</h5>
							<p class="card-text" style="margin-bottom: 5px; color : #000;">{{ $search['wilayah'] }} • {{ date("D, d F Y", strtotime($search['mulai'])) }}, {{ $search['jam_mulai'] }} - {{ date("D, d F Y", strtotime($search['akhir'])) }}, {{ $search['jam_akhir'] }}.</p>
						</div>
					</div>
				</div>
				<div class="col-lg-8 ftco-animate">

					<div class="card mb-3" style="background : rgb(158 158 158 / 40%);">
						<div class="row no-gutters">

							<div class="col-md-6">
								<img src="{{ asset($product->productImages->image) }}" class="card-img" alt="...">
							</div>
							<div class="col-md-6">
								<div class="card-body" style="background : rgb(158 158 158 / 40%)">
									<h5 class="card-title" style="color : #000;">{{ $product->productName->name }}</h5>
									<p class="card-text" style="color : #000;">Disediakan / Provided By {{ $product ->seller->name }}</p>
									<div class="d-flex" style="margin-bottom: -15px;">
										<!-- <span class="cat">Price</span> -->
										<p class="price1 ml-2" style="color : #000;"><span class="flaticon-pistons mr-2"></span>{{ $product ->jenis }}</p>
									</div>
									<div class="d-flex mb-2">
										<!-- <span class="cat">Price</span> -->
										<p class="price1 ml-2" style="color : #000;"><span class="flaticon-car-seat mr-2"></span>{{ $product ->bagasi }} Bag</p>
										<p class="price1 ml-2" style="color : #000;"><span class="flaticon-backpack mr-2"></span> {{ $product ->kursi }} Seat</p>
									</div>
								</div>
							</div>

						</div>
					</div>
					<div class="card" style="background : rgb(158 158 158 / 40%) ">
						<div class="card-body">
							<h5 class="card-title" style="color : #000; color : #000;">Kebijakan Rental</h5>
							<ul class="list-group list-group-flush">
								<li class="list-group-item" style="color : #000;">Return the fuel as received.</li>
								<li class="list-group-item" style="color : #000;">Penggunaan hingga 24 jam setiap hari rental.</li>
								<!--<li class="list-group-item" style="color : #000;">Bisa Refund.</li>-->
								<li class="list-group-item" style="color : #000;">Verifikasi Mudah.</li>
								<li class="list-group-item" style="color : #000;">Pengemudi hanya perlu membagikan ke penyedia berupa foto KTP, foto SIM A, dan swafoto dengan KTP.</li>

							</ul>
							<h5 class="card-title" style="margin-top: 20px; color : #000;">Informasi Penting</h5>
							<ul class="list-group list-group-flush">
								<li class="list-group-item" style="color : #000;">Sebelum Anda pesan</li>
								<li class="list-group-item" style="color : #000;">Pastikan untuk membaca syarat rental</li>
								<li class="list-group-item" style="color : #000;">Setelah Anda pesan.</li>
								<li class="list-group-item" style="color : #000;">Penyedia akan menghubungi pengemudi melalui WhatsApp untuk meminta foto beberapa dokumen wajib.</li>
								<li class="list-group-item" style="color : #000;">Saat pengambilan.</li>
								<li class="list-group-item" style="color : #000;">Bawa KTP, SIM A, dan dokumen-dokumen lain yang dibutuhkan oleh penyedia rental..</li>
								<li class="list-group-item" style="color : #000;">Saat Anda bertemu dengan staf rental, cek kondisi mobil dengan staf.</li>

								<li class="list-group-item" style="color : #000;">Biaya parkir & tol.</li>

							</ul>
							<h5 class="card-title" style="margin-top: 20px; color : #000;">Syarat Rental Tanpa Supir</h5>
							<ul class="list-group list-group-flush">
        						<li class="list-group-item" style="color : #000;">SIM A/SIM Internasional</li>
        						<li class="list-group-item" style="color : #000;">Pengemudi harus membagikan kepada penyedia foto SIM A atau SIM Internasional mereka.</li>
        						<li class="list-group-item" style="color : #000;">Foto Diri dengan KTP/Paspor</li>
        						<li class="list-group-item" style="color : #000;">Pengemudi harus membagikan kepada penyedia foto diri dengan KTP/paspor mereka.</li>
        						<li class="list-group-item" style="color : #000;">e-KTP/paspor</li>
        						<li class="list-group-item" style="color : #000;">Pengemudi harus membagikan kepada penyedia foto e-KTP/paspor mereka.</li>
        						<li class="list-group-item" style="color : #000;">Others (if provider requires additional verification)
        						Syarat tambahan seperti NPWP, kartu keluarga, dan/atau nama akun media sosial dapat diminta kepada pengemudi setelah pemesanan jika penyedia membutuhkan verifikasi tambahan.</li>
        						<li class="list-group-item" style="color : #000;">Bersedia Di Survey</li>
        					</ul>
						</div>
					</div>
					<!-- <div class="card" style="margin-top: 15px; background : rgb(158 158 158 / 40%);">
						<div class="card-body">
							<h6 class="card-title" style="color : #000;">Lokasi Penjemputan <br> Pickup Location*</h6>
							<h6 class="card-subtitle mb-2 text-muted" style="color : #000;">Pilih lokasi penjemputan <br> Select a pick-up location </h6>
							<select class="form-control" name="jemput_id" id="jemput_id" >
								<option value="">Pilih Propinsi</option>
								
								<option value=""></option>
							</select>

							<div class="form-group mt-2">
								<h6 class="card-subtitle mb-2 text-muted" style="color : #000;">Pilih lokasi penjemputan <br> Select a pick-up location</h6>
								<select class="form-control" name="lokasi_jemput" id="lokasi_jemput" >
									<option value="">Pilih Kabupaten/Kota</option>
								</select>
							</div>
							<div class="form-group mt-2">
								<label for="formGroupExampleInput" style="color : #000;">Note*</label>
								<input type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input">
							</div>
						</div>

					</div> -->

					
				</div>
				<!-- .col-md-8 -->
				<div class="col-lg-4 sidebar ftco-animate">


					<div class="card" style="background : rgb(158 158 158 / 40%);">
						<div class="panel-group" id="accordion">
							<div class="panel panel-default">
								<div class="panel-heading">
									<h6 class="panel-title" style="border: 1px solid #ced4da; padding: 0.375rem 0.75rem; background: rgba(0, 0, 0, 0.03);">
										<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" style="color : #000;">
											Rincian Harga <br> Pricing Details
										</a>
									</h6>
								</div>
								<div class="card-body">
									<p class="card-text" style="color : #000;">Harga Total <br> Total price</p>
									<p class="card-text">
										<span id="total" style="color : #000;">{{ formatUang($product->price * $durasi) }}</span>
									</p>
									<button type="submit" class="btn btn-primary btn-lg btn-block" id="submit-post">Submit</button>
								</div>
								<div id="collapseOne" class="panel-collapse collapse in">
									<div class="panel-body">
										<input type="hidden" id="rentalDasarPlusHari" value="">

										<ul class="list-group" id="listItemOrder"  style="color : #000;">
											<li class="list-group-item d-flex justify-content-between align-items-center" style="color : #000;">
												Termasuk semua biaya & pajak <br> Includes all fees & taxes
												<!-- <span class="badge badge-primary badge-pill">14</span> -->
											</li>
											<li class="list-group-item d-flex justify-content-between align-items-center" style="color : #000;">
												Rental dasar <br> Basic rental
												<span id="rentalDasar" style="color : #000;">{{ formatUang($product->price * $durasi) }}</span>
											</li>
											<!-- <li class="list-group-item d-flex justify-content-between align-items-center" id="zona1">

											</li>
											<li class="list-group-item d-flex justify-content-between align-items-center" id="zona2">


											</li> -->
											<!-- <li class="list-group-item d-flex justify-content-between align-items-center">
                            Penjemputan di Area 1 x 1
                          <span >Rp 200.000</span>
                        </li> -->
											<div id="durasiContent" style="display:none"></div>
											<li class="list-group-item d-flex justify-content-between align-items-center" style="color : #000;">
												Durasi <br> Duration
												<span class="total" style="color : #000;">{{ $durasi }} Hari / Days</span>
											</li>
										</ul>

									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</form>
	</div>
</section> <!-- .section -->


<!-- loader -->
<div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
		<circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
		<circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00" />
	</svg></div>

@endsection
@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

@endsection
@section('css')

@endsection