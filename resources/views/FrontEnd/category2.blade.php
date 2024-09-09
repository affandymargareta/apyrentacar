

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
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Category <i class="ion-ios-arrow-forward"></i></span></p>
            <!-- <h1 class="mb-3 bread">Category</h1> -->
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section2 ftco-cart">
			<div class="container">
				<div class="row">
    			<div class="col-md-12 ftco-animate">
    				<div class="car-list">
	    				<table class="table">
						    <thead class="thead-primary">
						      <tr class="text-center">
						        <th>&nbsp;</th>
						        <th>&nbsp;</th>
								<th>&nbsp;</th>
			
						      </tr>
						    </thead>
						    <tbody>
								<tr class="" style="  border: 2px solid #17a2b8">
									<td class="car-image">
										<!-- <div class="img" style="background-image:url({{ asset('images/bg_1.jpg') }});"></div> -->
									</td>
								  <td class="product-name3">
								
									  <div class="price-rate">
										<h3>
											<span class="subheading3">Rental Mobil</span>
											<span class="subheading2">: Dengan Sopir</span>
										</h3>
									</div>
									  <h3>Rental Mobil Dengan Supir / Rent A Car Without Driver
									  </h3>

									  <div class="price-rate">
										  <h3>
											
											  <span class="subheading1"><span class="subheading2"></span class=""> {{  $search['wilayah'] }} • {{ date("D, d F Y", strtotime($search['mulai'])) }}, {{ $search['jam_mulai'] }}</span>
											  <span class="subheading1"><span class="subheading2"></span class=""> - {{ date("D, d F Y", strtotime($search['akhir'])) }}, {{ $search['jam_akhir'] }}</span>
											</h3>
									  </div>
									  
								  </td>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								</tr>
								<tr>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								  <td>&nbsp;</td>
								</tr>
							@foreach($sellers as $seller)
							@foreach($seller->denganSopirs as $denganSopir)
						      <tr class="" style="  border: 2px solid #17a2b8">
								<!-- <td class="car-image"><div class="img" style="background-image:url({{ asset($denganSopir->productImages->image) }});"></div></td> -->
						        <td class="product-name">
									<h3 style="margin-left: 18px;">{{ $seller->name }}</h3>	
									<h3 style="margin-left: 18px;">{{ $denganSopir->productName->name }}</h3>																	
									<!-- <div class="price-rate">
							        	<h3>
							        		<span class="subheading1"><span class="flaticon-pistons subheading2"></span class=""></span>
							        	</h3>
							        </div>
									<div class="price-rate">
							        	<h3>
							        		<span class="subheading1"><span class="flaticon-car-seat subheading2"></span class=""> </span>
											<span class="subheading1"><span class="flaticon-backpack subheading2"></span class=""> </span>
							        	</h3>
									</div>
									<div class="price-rate">
							        	<h3>
							        		 <span class="subheading3">Tanpa Sopir</span>
							        		<span class="subheading2">With Driver /  Stock Providers Available</span>
							        	</h3>
						        	</div> -->
						        </td>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td class="prices">
									<form action="{{route('cardetail2',$denganSopir->id)}}" method="get" enctype="multipart/form-data">
										<input type="hidden" class="form-control" name="wilayah" value="{{  $search['wilayah'] }}">
										<input type="hidden" class="form-control" name="mulai" value="{{  $search['mulai'] }}">
										<input type="hidden" class="form-control" name="akhir" value="{{  $search['akhir'] }}">
										<input type="hidden" class="form-control" name="durasi" value="{{  $Hari }}">
										<input type="hidden" class="form-control" name="jam_mulai" value="{{  $search['jam_mulai'] }}">
										<input type="hidden" class="form-control" name="jam_akhir" value="{{  $search['jam_akhir'] }}">
									<!-- <p class="btn-custom"><a href="">Order</a></p> -->
									<div class="price-rate">
									<h6>
											<span class="num"> {{ formatUang($denganSopir->price * $Hari)}}</span>
											<span class="num">/ Total Days</span>
											
										</h6>
										<h6>
											
											<span class="num"> {{ formatUang($denganSopir->price)}}</span>
											<span class="num">/ Days</span>
										</h6>
										<button type="submit" class="form-control btn btn-primary">Order</button>
									</div>
									</form>
								</td>
						      </tr>
							  @endforeach
							@endforeach
							  <!-- END TR-->
						    </tbody>
						  </table>
					  </div>
    			</div>
    		</div>
			</div>
		</section>



  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>
@endsection

