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

		<form method="post" action="{{ route('cartstore2') }}" enctype="multipart/form-data">
			@method('POST')
			@csrf
			<input type="hidden" name="biaya_aplikasi" value="3000" class="form-control">
			<input type="hidden" name="product_id" value="{{ $product->id }}" class="form-control">
			<input type="hidden" name="wilayah" value="{{  $search['wilayah'] }}" class="form-control">
			<input type="hidden" name="mulai" value="{{  $search['mulai'] }}" class="form-control">
			<input type="hidden" name="durasi" value="{{  $search['durasi'] }}" class="form-control">
			<input type="hidden" name="jam" value="{{  $search['jam'] }}" class="form-control">

			<!-- <form action="javascript:void(0)" id="frm-create-post" method="post"> -->
			<div class="row">
				<div class="col-lg-12">
					<div class="card" style="background : rgb(158 158 158 / 40%);">
						<div class="card-body">
							<p class="card-text" style="margin-bottom: 5px; color : #000;">Rental Mobil : Dengan Sopir / With Driver</p>
							<h5 class="card-title" style="margin-bottom: 5px; color : #000;">Rental Mobil Dengan Supir / Rent A Car With Driver</h5>
							<p class="card-text" style="margin-bottom: 5px; color : #000;">{{ $search['wilayah'] }} • {{ date("D, d F Y", strtotime($search['mulai'])) }}, {{ $search['jam'] }} - {{$durasi}}, 23:59.</p>
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

							<div class="col-md-5 mt-5">
								<img src="{{ asset('images/zona.webp') }}" class="card-img" alt="...">
							</div>
							<div class="col-md-7 mt-5">
								<div class="card-body">
									<div class="d-flex">
										<!-- <span class="cat">Price</span> -->
										<p class="price1 ml-2" style="font-size: 12px; color : #000;"> Dalam Kota</p>
										<p class="price1 ml-2" style="font-size: 12px; color : #000;">Cikarang Barat, Marunda – Cilincing, Cibubur, Cinere, Depok, Sentul, Ah Poong Sentul, Cilebut (Stasiun Cilebut), Angke, IKEA
										</p>
									</div>
									<h5 class="card-title" style="font-size: 12px; color : #000;">Luar Kota</h5>
									<p class="card-text" style="font-size: 12px; color : #000;">PENTING: Biaya tambahan berlaku untuk perjalanan di luar area biru.</p>
									<div class="d-flex">
										<!-- <span class="cat">Price</span> -->
										<p class="price1 ml-2" style="font-size: 12px; color : #000;">Zona 1</p>
										<p class="price1 ml-2" style="font-size: 12px; color : #000;">Area 0 + Purwakarta, Kota Bogor, Kebun Raya Bogor, Ciawi, Cisarua (Masjid At-tawun/Taman Safari), Caringin Bogor (Bestcamp Arung Jeram/Paint Ball), Banten, Serang City, Rangkas Blitung, Leuwiliang, Tangerang.
										</p>
									</div>
									<div class="d-flex">
										<!-- <span class="cat">Price</span> -->
										<p class="price1 ml-2" style="font-size: 12px; color : #000;">Zone 2</p>
										<p class="price1 ml-2" style="font-size: 12px; color : #000;">Area 0 + Area 1 + Subang, Bandung (Kawah Putih Pulomerak (Bakauheni – Merak), Anyer, Labuhan Pandeglang, Sukabumi, Cimangu, Cilegon, Kota/Kec. Cianjur.
											.</p>
									</div>
								</div>
							</div>

						</div>
					</div>
					<div class="card" style="background : rgb(158 158 158 / 40%) ">
						<div class="card-body">
							<h5 class="card-title" style="color : #000; color : #000;">Basic Service Includes</h5>
							<ul class="list-group list-group-flush">
								<li class="list-group-item" style="color : #000;">Penggunaan di Area 0.</li>
								<li class="list-group-item" style="color : #000;">Penggunaan selama 12 jam (maks. 23:59 jika rental dimulai setelah jam 12:00).</li>
								<li class="list-group-item" style="color : #000;">Gratis antar dan jemput di Area 0.</li>

							</ul>
							<h5 class="card-title" style="margin-top: 80px; color : #000;">Basic Service Excludes</h5>
							<ul class="list-group list-group-flush">
								<li class="list-group-item" style="color : #000;">Bensin</li>
								<li class="list-group-item" style="color : #000;">Bisa ditambah di halaman berikutnya</li>
								<li class="list-group-item" style="color : #000;">Makan sopir Rp60.000/hari atau Rp70.000/hari saat high season.</li>
								<li class="list-group-item" style="color : #000;">Bisa ditambah di halaman berikutnya.</li>
								<li class="list-group-item" style="color : #000;">Biaya parkir & tol.</li>
							</ul>
						</div>
					</div>

					<div class="card" style="margin-top: 15px; background : rgb(158 158 158 / 40%);">
						<div class="card-body">
							<h6 class="card-title" style="color : #000;">Lokasi Penjemputan <br> Pickup Location*</h6>
							<h6 class="card-subtitle mb-2 text-muted" style="color : #000;">Pilih lokasi penjemputan <br> Select a pick-up location </h6>
							<select class="form-control" name="jemput_id" id="jemput_id" required>
								<option value="">Pilih Propinsi</option>
								@foreach ($provinces as $row)
								<option value="{{ $row->id }}">{{ $row->province }}</option>
								@endforeach
							</select>

							<div class="form-group mt-2">
								<h6 class="card-subtitle mb-2 text-muted" style="color : #000;">Pilih lokasi penjemputan <br> Select a pick-up location</h6>
								<select class="form-control" name="lokasi_jemput" id="lokasi_jemput" required>
									<option value="">Pilih Kabupaten/Kota</option>
								</select>
							</div>
							<div class="form-group mt-2">
								<label for="formGroupExampleInput" style="color : #000;">Alamat Lengkap*</label>
								<input type="text" name="lokasi_jemput_lengkap" class="form-control" id="formGroupExampleInput" placeholder="Example input" required>
							</div>
						</div>

					</div>

					<div class="card" style="margin-top: 15px; background : rgb(158 158 158 / 40%);">
						<div class="card-body">
							<h6 class="card-title" style="color : #000;">Lokasi Pengantaran <br> Return Location*</h6>
							<h6 class="card-subtitle mb-2 text-muted" style="color : #000;">Pilih lokasi Pengantaran <br> Select a delivery location </h6>
							<select class="form-control" name="kembali_id" id="kembali_id">
								<option value="" style="color : #000;">Pilih Propinsi</option>
								@foreach ($provinces as $row)
								<option value="{{ $row->id }}">{{ $row->province }}</option>
								@endforeach
							</select>

							<div class="form-group mt-2">
								<h6 class="card-subtitle mb-2 text-muted" style="color : #000;">Pilih lokasi Pengantaran <br> Select a delivery location </h6>
								<select class="form-control" name="lokasi_kembali" id="lokasi_kembali">
									<option value="">Pilih Kabupaten/Kota</option>
								</select>
							</div>
							<div class="form-group mt-2">
								<label for="formGroupExampleInput" style="color : #000;">Alamat Lengkap*</label>
								<input type="text"  name="lokasi_kembali_lengkap" class="form-control" id="formGroupExampleInput" placeholder="Example input" required>
							</div>
						</div>

					</div>


					<div class="card" style="margin-top: 15px; background : rgb(158 158 158 / 40%);">
						<div class="card-body">
							<h5 class="card-title" style="color : #000;">Pilih Add On *</h5>
							<h6 class="card-subtitle mb-2 text-muted" style="color : #000;">Pilih Pilih Add On</h6>
							<select class="form-control" name="addon_hari" id="addon_hari">
								<option value="0" style="color : #000;">Pilih Add On</option>
									@for ($i = 1; $i <= $search['durasi']; $i++) 
									<option value="{{ $i }}">
										Bensin 120 Km dan Makan Sopir x {{$i}} Hari : {{ formatUang($addon->addon_price * $i) }}
									</option>
									@endfor
							</select>
						</div>

					</div>

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
										<span id="total" style="color : #000;">{{ formatUang($product->price * $search['durasi']) }}</span>
									</p>
									<button type="submit" class="btn btn-primary btn-lg btn-block" id="submit-post">Submit</button>
								</div>
								<div id="collapseOne" class="panel-collapse collapse in">
									<div class="panel-body">
										<input type="hidden" id="rentalDasarPlusHari" value="{{ $product->price * $search['durasi'] }}">
										<input type="hidden" id="duration" value="{{ $search['durasi'] }}">

										<ul class="list-group" id="listItemOrder"  style="color : #000;">
											<li class="list-group-item d-flex justify-content-between align-items-center" style="color : #000;">
												Termasuk semua biaya & pajak <br> Includes all fees & taxes
												<!-- <span class="badge badge-primary badge-pill">14</span> -->
											</li>
											<li class="list-group-item d-flex justify-content-between align-items-center" style="color : #000;">
												Rental dasar <br> Basic rental
												<span id="rentalDasar" style="color : #000;">{{ formatUang($product->price * $search['durasi']) }}</span>
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
												<span class="total" style="color : #000;">{{ $search['durasi'] }} Hari / Days</span>
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
<script>
	function numberWithDot(x) {
		return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ".");
	}

	const addonPriceValue = "{{ $addon->addon_price }}";

	const product_id = "{{ $product->name }}";


	$('#addon_hari').on('change', function() {
		let content = $(this).find('option:selected').text();
		$('#listItemOrder').find('#addon_hari_content').remove();
		$('#durasiContent')
			.after(`<li class="list-group-item d-flex justify-content-between align-items-center" id="addon_hari_content">${content}</li>`);


		hitungTotal();
	});

	$('#jemput_id').on('change', function() {

		
		$.ajax({
			url: "{{ url('/api/city1') }}",
			type: "GET",
			data: {
				jemput_id: $(this).val()
			},
			success: function(html) {

				$('#lokasi_jemput').empty()
				$('#lokasi_jemput').append('<option value="">Pilih Kabupaten/Kota</option>')
				$.each(html.data, function(key, item) {
					$('#lokasi_jemput').append('<option value="' + item.id + '">' + item.city_name + '</option>')
				})
			}
		});
	});

	$('#jemput_id').on('change', function() {
		$.ajax({
			url: "{{ url('/api/cityprice1') }}",
			type: "GET",
			data: {
				jemput_id: $(this).val(),
				product_id: product_id,
			},
			success: function(html) {
				$('#listItemOrder').find('#zona1').remove();
				$.each(html.data, function(key, item) {
					let content = `<span id="priceZona1" style="display:none">0</span>`;
					if (item.province_id != "{{  $product->wilayah }}") {
						content = `Penjemputan Di Area  ${item.zona} x 1 <span id="priceZona1" style="display:none">${item.price}</span><span>Rp. ${numberWithDot(item.price)}</span>`
					}

					$('#durasiContent')
						.before(`<li class="list-group-item d-flex justify-content-between align-items-center" id="zona1">${content}</li>`)
				})

				hitungTotal();
			}
		});
	});

	$('#kembali_id').on('change', function() {
		$.ajax({
			url: "{{ url('/api/city2') }}",
			type: "GET",
			data: {
				kembali_id: $(this).val()
			},
			success: function(html) {

				$('#lokasi_kembali').empty()
				$('#lokasi_kembali').append('<option value="">Pilih Kabupaten/Kota</option>')
				$.each(html.data, function(key, item) {
					$('#lokasi_kembali').append('<option value="' + item.id + '">' + item.city_name + '</option>')
				})
			}
		});
	});

	$('#kembali_id').on('change', function() {
		$.ajax({
			url: "{{ url('/api/cityprice2') }}",
			type: "GET",
			data: {
				kembali_id: $(this).val(),
				product_id: product_id,

			},
			success: function(html) {
				$('#listItemOrder').find('#zona2').remove();
				$.each(html.data, function(key, item) {
					let content = `<span id="priceZona2" style="display:none">0</span>`;
					if (item.province_id != "{{  $product->wilayah }}") {
						content = `Pengantaran Di Area  ${item.zona} x 1 <span id="priceZona2" style="display:none;">${item.price}</span><span>Rp. ${numberWithDot(item.price)}</span>`
					}

					$('#durasiContent')
						.before(`<li class="list-group-item d-flex justify-content-between align-items-center" id="zona2">${content}</li>`)
				})

				hitungTotal();
			}
		});
	});

	function hitungTotal() {
		let rentalDasarPlusHari = parseInt($('#rentalDasarPlusHari').val());
		let duration = parseInt($('#duration').val());
		let zona1 = $('#priceZona1').html() || 0;
		let zona2 = $('#priceZona2').html() || 0;
		let addonHari = $('#addon_hari').find('option:selected').val() || 0;
		let total = parseInt(rentalDasarPlusHari) + (parseInt(duration) * parseInt(zona1)) + (parseInt(duration) * parseInt(zona2)) + (parseInt(addonHari) * parseInt(addonPriceValue));

		$('#total').html(`Rp. ${numberWithDot(total)}`);
	}
</script>
@endsection
@section('css')

@endsection