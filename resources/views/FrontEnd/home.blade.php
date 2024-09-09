

@extends('layouts.landingpage')


@section('title')
    <title>Home, Situs Belanja Online dan Rental Car Mudah Terpercaya | Apy Rental A Car</title>
@endsection

@section('content')

    
    <div id="demo" class="carousel slide" data-ride="carousel">

      <!-- Indicators -->
      <ul class="carousel-indicators">
        <li data-target="#demo" data-slide-to="0" class="active"></li>
        <li data-target="#demo" data-slide-to="1"></li>
        <li data-target="#demo" data-slide-to="2"></li>
      </ul>
      
      <!-- The slideshow -->
      <div class="carousel-inner">
      <div class="carousel-item  active">
          <img src="{{ asset('images/innova2019.png') }}" alt="Chicago" width="1100" height="500">
          <div class="heroContent">
            <p>Welcome Apy Rent A Car</p>
            <p>Fast &amp; Easy Way To Rent A Car!</p>
          </div>
        </div>
      @foreach ($Banner as $getData)
        <div class="carousel-item">
          <img src="{{ asset($getData->image) }}" alt="Los Angeles" width="1100" height="500">
          <div class="heroContent">
            <p>{{ $getData ->name }}</p>
            <p>Fast &amp;  {{ $getData ->description }}!</p>
          </div>
        </div>
        @endforeach

      </div>
      
      <!-- Left and right controls -->
      <a class="carousel-control-prev" href="#demo" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </a>
      <a class="carousel-control-next" href="#demo" data-slide="next">
        <span class="carousel-control-next-icon"></span>
      </a>
    </div>

        <section class="ftco-section ftco-no-pt bg-light  mb-10">
          <div class="container">
            <div class="row no-gutters">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-lg-12 request-form ftco-animate bg-primary">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link rounded-pill" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Tanpa Sopir</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active rounded-pill" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Dengan Sopir</button>
                      </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                      <div class="tab-pane fade " id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                      <form method="get" action="{{ route('provided1') }}" enctype="multipart/form-data">
                          <!-- @method('GET') -->

                            <h2>Make your trip Tanpa Supir</h2>
                            <div class="form-row">
                              <div class="form-group col-md-2">
                                <label class="form-control">Lokasi Anda / Your location</label>
                                <select name="wilayah" style="background: #f8f9fa !important; color: #0044cc !important;" class="rounded-pill form-control">
                                    <option value="">Pilih</option>
                                    @foreach ($province as $row)
                                      <option value="{{ $row->province }}" {{ old('wilayah') == $row->id ? 'selected':'' }}>{{ $row->province }}</option>
                                    @endforeach
                                </select>                                
                              </div>
                              <div class="form-group col-md-2">
                                <label class="form-control">Tanggal Mulai / Start Date</label>
                                <input type="date" name="mulai" value="{{ old('mulai') }}" style="background: #f8f9fa !important; color: #0044cc !important;" class="rounded-pill form-control">
                              </div>
                              
                              <div class="form-group col-md-2">
                                <label class="form-control">Waktu Jemput & Ambil / Pick Up Times</label>
                                <input type="time" name="jam_mulai" value="09:00" style="background: #f8f9fa !important; color: #0044cc !important;" class="rounded-pill form-control">
                              </div>

                              <div class="form-group col-md-2">
                                <label  class="form-control">Durasi / Duration</label>
                                <select  name="durasi" style="background: #f8f9fa !important; color: #0044cc !important;" class="rounded-pill form-control">
                                  <option value="7">7 Hari</option>
                                </select>
                              </div>
                              
                              <div class="form-group col-md-2">
                                <label class="form-control">Waktu Selesai / Pick Up Times</label>
                                <input type="time" name="jam_akhir" value="09:00" style="background: #f8f9fa !important; color: #0044cc !important;" class="rounded-pill form-control">
                              </div>
                              <div class="form-group col-md-2">
                                <label class="form-control"></label>
                                <!-- <a href="" class="btn btn-warning"><i class="fa fa-search"></i></a> -->
                                <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>

                      </div>
                      <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                      <form method="get" action="{{ route('provided2') }}" enctype="multipart/form-data">
                          <!-- @method('GET') -->

                            <h2>Make your trip Dengan Supir</h2>
                            <div class="form-row">
                              <div class="form-group col-md-2">
                                <label class="form-control">Lokasi Anda / Your location</label>
                                <select name="wilayah" style="background: #f8f9fa !important; color: #0044cc !important;" class="rounded-pill form-control">
                                    <option value="">Pilih</option>
                                    @foreach ($province as $row)
                                      <option value="{{ $row->province }}" {{ old('wilayah') == $row->id ? 'selected':'' }}>{{ $row->province }}</option>
                                    @endforeach
                                </select>                                
                              </div>
                              <div class="form-group col-md-2">
                                <label class="form-control">Tanggal Mulai / Start Date</label>
                                <input type="date" name="mulai" value="{{ old('mulai') }}" style="background: #f8f9fa !important; color: #0044cc !important;" class="rounded-pill form-control">
                              </div>
                              <div class="form-group col-md-2">
                                <label  class="form-control">Durasi / Duration</label>
                                <select  name="durasi" style="background: #f8f9fa !important; color: #0044cc !important;" class="rounded-pill form-control">
                                  <option value="1">1 Hari</option>
                                  <option value="2">2 Hari</option>
                                  <option value="3">3 Hari</option>
                                  <option value="4">4 Hari</option>
                                  <option value="5">5 Hari</option>
                                  <option value="6">6 Hari</option>
                                  <option value="7">7 Hari</option>
                                  <option value="8">8 Hari</option>
                                  <option value="9">9 Hari</option>
                                  <option value="10">10 Hari</option>
                                  <option value="11">11 Hari</option>
                                  <option value="12">12 Hari</option>
                                  <option value="13">13 Hari</option>
                                  <option value="14">14 Hari</option>
                                  <option value="15">15 Hari</option>
                                  <option value="16">16 Hari</option>
                                  <option value="17">17 Hari</option>
                                  <option value="18">18 Hari</option>
                                  <option value="19">19 Hari</option>
                                  <option value="20">20 Hari</option>
                                  <option value="21">21 Hari</option>
                                  <option value="22">22 Hari</option>
                                  <option value="23">23 Hari</option>
                                  <option value="24">24 Hari</option>
                                  <option value="25">25 Hari</option>
                                  <option value="26">26 Hari</option>
                                  <option value="27">27 Hari</option>
                                  <option value="28">28 Hari</option>
                                  <option value="29">29 Hari</option>
                                  <option value="30">30 Hari</option>
                                </select>
                                
                              </div>
                              <div class="form-group col-md-2">
                                <label class="form-control">Waktu Jemput & Ambil / Pick Up Times</label>
                                <input type="time" name="jam_mulai" value="17:15" style="background: #f8f9fa !important; color: #0044cc !important;" class="rounded-pill form-control">
                              </div>
                              <input type="hidden" name="jam_akhir" value="23:59" style="background: #f8f9fa !important; color: #0044cc !important;" class="rounded-pill form-control">
                              <div class="form-group col-md-2">
                                <label class="form-control"></label>
                                <!-- <a href="" class="btn btn-warning"><i class="fa fa-search"></i></a> -->
                                <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
                              </div>
                            </div>
                        </form>

                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>


    <section class="ftco-section ftco-about">
			<div class="container">
      @foreach ($company as $getData)

				<div class="row no-gutters">
					<div class="col-md-6 p-md-5 img img-2 d-flex justify-content-center align-items-center" style="background-image: url({{ asset($getData->image) }});">
					</div>
					<div class="col-md-6 wrap-about ftco-animate">
	          <div class="heading-section heading-section-white pl-md-5">
	          	<span class="subheading">About us</span>
	            <h2 class="mb-4">{{ $getData ->name }}</h2>

	            <p>{{ $getData ->title }}.</p>
	            <p>{{ $getData ->description }}.</p>
	            <p><a href="#" class="btn btn-primary py-3 px-4">Search Vehicle</a></p>
	          </div>
					</div>
				</div>
        @endforeach

			</div>
		</section>

  <form action="{{ route('userinvoice1') }}" method="post">
    @csrf
    @method('POST')
    <input type="hidden" class="form-control" name="order_id" value="1">
    <button type="submit" class="btn btn-success" style="font-size: 10px;">Download Voucher 2</button>
	</form>
  <form action="{{ route('userinvoice2') }}" method="post">
    @csrf
    @method('POST')
    <input type="hidden" class="form-control" name="order_id" value="2">
    <button type="submit" class="btn btn-success" style="font-size: 10px;">Download Voucher 2</button>
	</form>
  <form action="{{ route('userinvoice3') }}" method="post">
    @csrf
    @method('POST')
    <input type="hidden" class="form-control" name="order_id" value="1">
    <button type="submit" class="btn btn-success" style="font-size: 10px;">Download Voucher 2</button>
	</form>
  <form action="{{ route('userinvoice4') }}" method="post">
    @csrf
    @method('POST')
    <input type="hidden" class="form-control" name="order_id" value="2">
    <button type="submit" class="btn btn-success" style="font-size: 10px;">Download Voucher 2</button>
	</form>

  <form action="{{ route('userinvoice4') }}" method="post">
    @csrf
    @method('POST')
    <input type="hidden" class="form-control" name="order_id" value="1">
    <button type="submit" class="btn btn-success" style="font-size: 10px;">Download Voucher v1</button>
	</form>
  <form action="{{ route('userinvoice4') }}" method="post">
    @csrf
    @method('POST')
    <input type="hidden" class="form-control" name="order_id" value="2">
    <button type="submit" class="btn btn-success" style="font-size: 10px;">Download Voucher v2</button>
	</form>

		<section class="ftco-section">
			<div class="container">
				<div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
          	<span class="subheading">Services</span>
            <h2 class="mb-3" style="color : #000;">Our Latest Services</h2>
          </div>
        </div>
				<div class="row">
					<div class="col-md-3">
						<div class="services services-2 w-100 text-center">
            	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-wedding-car"></span></div>
            	<div class="text w-100">
                <h3 class="heading mb-2" style="color : #000;">Wedding Ceremony</h3>
                <p style="color : #000;">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
              </div>
            </div>
					</div>
					<div class="col-md-3">
						<div class="services services-2 w-100 text-center">
            	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-transportation"></span></div>
            	<div class="text w-100">
                <h3 class="heading mb-2" style="color : #000;">City Transfer</h3>
                <p style="color : #000;">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
              </div>
            </div>
					</div>
					<div class="col-md-3">
						<div class="services services-2 w-100 text-center">
            	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-car"></span></div>
            	<div class="text w-100">
                <h3 class="heading mb-2" style="color : #000;">Airport Transfer</h3>
                <p style="color : #000;">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
              </div>
            </div>
					</div>
					<div class="col-md-3">
						<div class="services services-2 w-100 text-center">
            	<div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-transportation"></span></div>
            	<div class="text w-100">
                <h3 class="heading mb-2" style="color : #000;">Whole City Tour</h3>
                <p style="color : #000;">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
              </div>
            </div>
					</div>
				</div>
			</div>
		</section>

		<section class="ftco-section ftco-intro" style="background-image: url({{ asset('images/bg_3.jpg') }});">
			<div class="overlay"></div>
			<div class="container">
				<div class="row justify-content-end">
					<div class="col-md-6 heading-section heading-section-white ftco-animate">
            <h2 class="mb-3" style="color : #000;">Do You Want To Earn With Us? So Don't Be Late.</h2>
            <a href="#" class="btn btn-primary btn-lg" >Become A Driver</a>
          </div>
				</div>
			</div>
		</section>


    <!-- <section class="ftco-section testimony-section bg-light">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 text-center heading-section ftco-animate">
          	<span class="subheading">Testimonial</span>
            <h2 class="mb-3">Happy Clients</h2>
          </div>
        </div>
        <div class="row ftco-animate">
          <div class="col-md-12">
            <div class="carousel-testimony owl-carousel ftco-owl">
              <div class="item">
                <div class="testimony-wrap rounded text-center py-4 pb-5">
                  <div class="user-img mb-2" style="background-image: url({{ asset('images/person_1.jpg') }})">
                  </div>
                  <div class="text pt-4">
                    <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <p class="name">Roger Scott</p>
                    <span class="position">Marketing Manager</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap rounded text-center py-4 pb-5">
                  <div class="user-img mb-2" style="background-image: url({{ asset('images/person_2.jpg') }})">
                  </div>
                  <div class="text pt-4">
                    <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <p class="name">Roger Scott</p>
                    <span class="position">Interface Designer</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap rounded text-center py-4 pb-5">
                  <div class="user-img mb-2" style="background-image: url({{ asset('images/person_3.jpg') }})">
                  </div>
                  <div class="text pt-4">
                    <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <p class="name">Roger Scott</p>
                    <span class="position">UI Designer</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap rounded text-center py-4 pb-5">
                  <div class="user-img mb-2" style="background-image: url({{ asset('images/person_1.jpg') }})">
                  </div>
                  <div class="text pt-4">
                    <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <p class="name">Roger Scott</p>
                    <span class="position">Web Developer</span>
                  </div>
                </div>
              </div>
              <div class="item">
                <div class="testimony-wrap rounded text-center py-4 pb-5">
                  <div class="user-img mb-2" style="background-image: url({{ asset('images/person_1.jpg') }})">
                  </div>
                  <div class="text pt-4">
                    <p class="mb-4">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    <p class="name">Roger Scott</p>
                    <span class="position">System Analyst</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section> -->

    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center mb-5">
          <div class="col-md-7 heading-section text-center ftco-animate">
          	<span class="subheading">Blog</span>
            <h2 style="color : #000;">Recent Blog</h2>
          </div>
        </div>
        <div class="row d-flex">
        @foreach ($blog as $getData)

          <div class="col-md-4 d-flex ftco-animate">
          	<div class="blog-entry justify-content-end">
              <a href="{{ route('blog.show', $getData->id) }}" class="block-20" style="background-image: url('{{ asset($getData->image) }}');">
              </a>
              <div class="text pt-4">
              	<div class="meta mb-3">
                  <div><a href="#">{{ $getData->created_at }}</a></div>
                  <!-- <div><a href="#">Admin</a></div>
                  <div><a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a></div> -->
                </div>
                <h5 class="heading mt-2"><a href="{{ route('blog.show', $getData->id) }}">{{ $getData->name }}</a></h5>
                <h5 class="heading mt-2"><a href="{{ route('blog.show', $getData->id) }}">{{ $getData->description }}</a></h5>
                <p><a href="{{ route('blog.show', $getData->id) }}" class="btn btn-primary">Read more</a></p>
              </div>
            </div>
          </div>
          @endforeach

        </div>
      </div>
    </section>	

    <section class="ftco-counter ftco-section img bg-light" id="section-counter">
			<div class="overlay"></div>
    	<div class="container">
    		<div class="row">
          <div class="col-md-6 col-lg-3 justify-content-center counter-wrap ftco-animate">
            <div class="block-18">
              <div class="text text-border d-flex align-items-center">
                <strong class="number" data-number="20">0</strong>
                <span>Year <br>Experienced</span>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 justify-content-center counter-wrap ftco-animate">
            <div class="block-18">
              <div class="text text-border d-flex align-items-center">
                <strong class="number" data-number="1000">0</strong>
                <span>Total <br>Cars</span>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 justify-content-center counter-wrap ftco-animate">
            <div class="block-18">
              <div class="text text-border d-flex align-items-center">
                <strong class="number" data-number="5000">0</strong>
                <span>Happy <br>Customers</span>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 justify-content-center counter-wrap ftco-animate">
            <div class="block-18">
              <div class="text d-flex align-items-center">
                <strong class="number" data-number="100">0</strong>
                <span>Total <br>Branches</span>
              </div>
            </div>
          </div>
        </div>
    	</div>
    </section>	

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>



@endsection
@section('js')
<!-- <script>
$(document).ready(function() {
        // direct buy
    $('.direct-buy').on('click', function(){
        let wilayah = this.dataset.wilayah
        let wilayah = $('[name=wilayah]').val()
        let mulai = $('[name=mulai]').val()
        let durasi = $('[name=durasi]').val()
        let jam = $('[name=jam]').val()
        window.open(`{{ url('searching') }}?wilayah%5B%5D=${wilayah}&mulai=${mulai}&durasi=${durasi}&jam=${jam}`)

    })

  });
</script> -->
@endsection
