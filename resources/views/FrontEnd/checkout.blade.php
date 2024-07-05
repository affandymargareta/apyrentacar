

@extends('layouts.landingpage')


@section('title')
    <title>Home, Situs Belanja Online dan Rental Car Mudah Terpercaya | Apy Rental A Car</title>
@endsection

@section('content')


    <!-- END nav -->
	<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_3.jpg');" data-stellar-background-ratio="0.5">
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
				<div class="col-md-4 order-md-2 mb-4">
					<div class="card">
						<h5 class="card-header">Rental Mobil Tanpa Sopir</h5>
						<div class="card-body">
							<h5 class="card-title">Daihatsu Ayla</h5>
							<!-- <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
							<a href="#" class="btn btn-primary">Go somewhere</a> -->
							<ul class="list-group list-group-flush">
								<li class="list-group-item">Otomatis.</li>
								<li class="list-group-item">Disediakan oleh CSS Rent Jakarta.</li>
							</ul>
						</div>
						<div class="card-body">
							<ul class="list-group list-group-flush">
								<li class="list-group-item">Kota/Wilayah Rental.</li>
								<li class="list-group-item">Jakarta.</li>
								<li class="list-group-item">Tanggal & Waktu Mulai.</li>
								<li class="list-group-item">Sel, 21 Mei 2024 • 09:00.</li>
								<li class="list-group-item">Lokasi Jemput.</li>
								<li class="list-group-item">Soekarno Hatta International Airport (CGK).</li>
								<li class="list-group-item">Tanggal & Waktu Selesai.</li>
								<li class="list-group-item">Kam, 23 Mei 2024 • 09:00.</li>
								<li class="list-group-item">Lokasi Kembali.</li>
								<li class="list-group-item">Soekarno Hatta International Airport (CGK).</li>

							</ul>
						</div>
					</div>
				</div>

				<div class="col-md-8 order-md-1">
					<h4 class="mb-3">Booking</h4>
					<form class="needs-validation" novalidate>

						<div class="mb-3">
							<ul class="list-group">
								<li class="list-group-item">Nama Lengkap</li>
								<li class="list-group-item">No Handpone</li>
								<li class="list-group-item">Email</li>
							</ul>
						</div>
						
					<button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
					</form>
				</div>
			</div>

		</div>
    </section>
	<!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>



@endsection