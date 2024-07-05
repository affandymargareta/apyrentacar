

@extends('layouts.landingpage')


@section('title')
    <title>Home, Situs Belanja Online dan Rental Car Mudah Terpercaya | Apy Rental A Car</title>
@endsection

@section('content')

    <nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('images/apyrentacar.png') }}">
        </a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item active"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
	          <li class="nav-item"><a style="color:#000;" href="{{ route('companys.profile') }}" class="nav-link">Company</a></li>
            <li class="nav-item"><a style="color:#000;" href="{{ route('article') }}" class="nav-link">Article</a></li>
	          <li class="nav-item"><a style="color:#000;" href="{{ route('services') }}" class="nav-link">Services</a></li>
	          <li class="nav-item"><a style="color:#000;" href="{{ route('contacts.company') }}" class="nav-link">Contact</a></li>
            <!-- <li class="nav-item"><a style="color:#000;" href="" class="nav-link">Testimonial</a></li> -->
            <!-- <li class="nav-item"><a style="color:#000;" href="contact.html" class="nav-link">Login</a></li> -->
            <li class="nav-item"><a style="color:#000;" href="whatsapp://send?text=Hello&phone=+62 811-1047-992" class="nav-link"><span class="icon-whatsapp" style="color:green; font-size: 24px;"></span> Hubungi Kami</a></li>
            @if (Route::has('login'))
            @auth
            <li class="nav-item">
              <div class="dropdown" style="margin-top:12px;">
                <a style="color:#000;" class="nav-link" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="icon-person"></span> {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                  <a href="{{ route('user.dashboard') }}" class="dropdown-item" type="button">Ubah Profil</a>
                  <a href="{{ route('user.dashboard') }}" class="dropdown-item" type="button">Pesanan Saya</a>
                    <!-- Authentication -->
                  <form method="POST" action="{{ route('logout') }}">
                      @csrf

                      <a class="dropdown-item" type="button" :href="route('logout')"
                              onclick="event.preventDefault();
                                          this.closest('form').submit();">
                          {{ __('Log Out') }}
                      </a>
                  </form>
                  <!-- Authentication -->
                  <!-- <a href="{{ route('user.dashboard') }}" class="dropdown-item" type="button">Log Out</a> -->
                </div>
              </div>
            </li>
            @else
            <li class="nav-item"><a style="color:#000;" href="{{ route('login') }}" class="nav-link">Log in</a></li>
            @if (Route::has('register'))
            <li class="nav-item"><a style="color:#000;" href="{{ route('register') }}" class="nav-link">Register</a></li>
            @endif
            @endauth
                  
            @endif
            <!-- <li class="nav-item"><a style="color:#000;" href="#" class="nav-link"><span class="icon-whatsapp" style="color:green; font-size: 24px;"></span> Renatha</a></li> -->
	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->
    <!-- END nav -->
    
    <section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('images/bg_3.jpg') }}');" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
          <div class="col-md-9 ftco-animate pb-5">
          	<p class="breadcrumbs"><span class="mr-2"><a href="{{ route('home') }}">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>Contact <i class="ion-ios-arrow-forward"></i></span></p>
            <h1 class="mb-3 bread">Contact Us</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section contact-section">
      <div class="container">
        <div class="row d-flex mb-5 contact-info">
        	<div class="col-md-4">
        		<div class="row mb-5">
		          <div class="col-md-12">
		          	<div class="border w-100 p-4 rounded mb-2 d-flex">
			          	<div class="icon mr-3">
			          		<span class="icon-map-o"></span>
			          	</div>
			            <p><span>Address:</span>Alamat: SH, Komp. Transkop Jl. Prof. DR. Soepomo No.16, RT.2/RW.1, 
                    Menteng Dalam, Kec. Tebet, Kota Jakarta Selatan,
                    Daerah Khusus Ibukota Jakarta 12870</p>
			          </div>
		          </div>
		          <div class="col-md-12">
		          	<div class="border w-100 p-4 rounded mb-2 d-flex">
			          	<div class="icon mr-3">
			          		<span class="icon-mobile-phone"></span>
			          	</div>
			            <p><span>Phone:</span> <a href="tel://1234567920">(021) 83792927</a></p>
			          </div>
		          </div>
		          <div class="col-md-12">
		          	<div class="border w-100 p-4 rounded mb-2 d-flex">
			          	<div class="icon mr-3">
			          		<span class="icon-envelope-o"></span>
			          	</div>
			            <p><span>Email:</span> <a href="mailto:info@yoursite.com">apyrentacar@gmail.com</a></p>
			          </div>
		          </div>
		        </div>
          </div>
          <div class="col-md-8 block-9 mb-md-5">
            <form method="post" action="{{ route('contact.store') }}" enctype="multipart/form-data" class="bg-light p-5 contact-form">
              @method('POST')
              @csrf
              <div class="form-group">
                <label >Name</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                <small class="form-text text-muted">We'll never share your Name with anyone else.</small>
              </div>

              <div class="form-group">
                <label >Email</label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                <small class="form-text text-muted">We'll never share your Name with anyone else.</small>
              </div>

              <div class="form-group">
                <label >Subject</label>
                <input type="text" class="form-control" name="subject" value="{{ old('subject') }}">
                <small class="form-text text-muted">We'll never share your Name with anyone else.</small>
              </div>
              
              <div class="form-group">
                <label >Description</label>
                <textarea name="description" value="{{ old('description') }} id="" cols="30" rows="7" class="form-control" placeholder="Message"></textarea>
                <small class="form-text text-muted">We'll never share your Description with anyone else.</small>
              </div>

              <div class="form-group">
                <input type="submit" value="Send Message" class="btn btn-primary py-3 px-5">
              </div>
            </form>
          
          </div>
        </div>
        <div class="row justify-content-center">
        	<div class="col-md-12">
            <div class="ratio ratio-16x9">
              <iframe style="width: 100%;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.171591045231!2d106.84113637409652!3d-6.241102861111936!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f393dad605a9%3A0xd6f10bde98ced370!2sAPY%20Rent%20A%20Car!5e0!3m2!1sid!2sid!4v1716187724086!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        		<!-- <div id="map" class="bg-white"></div> -->
        	</div>
        </div>
      </div>
    </section>
	

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>



@endsection