<nav class="navbar navbar-expand-lg navbar-dark ftco_navbar bg-dark ftco-navbar-light" id="ftco-navbar">
	    <div class="container">
	      <a class="navbar-brand" href="{{ route('home') }}"><img src="{{ asset('images/apyrentacars.png') }}">
        </a>
	      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ftco-nav" aria-controls="ftco-nav" aria-expanded="false" aria-label="Toggle navigation">
	        <span class="oi oi-menu"></span> Menu
	      </button>

	      <div class="collapse navbar-collapse" id="ftco-nav">
	        <ul class="navbar-nav ml-auto">
	          <li class="nav-item active"><a href="{{ route('home') }}" class="nav-link">Home</a></li>
	          <li class="nav-item"><a style="color:#000;" href="{{ route('companys.profile') }}" class="nav-link">Company</a></li>
            <li class="nav-item"><a style="color:#000;" href="{{ route('article') }}" class="nav-link">Article</a></li>
	          <!-- <li class="nav-item"><a style="color:#000;" href="" class="nav-link">Services</a></li> -->
	          <li class="nav-item"><a style="color:#000;" href="{{ route('contacts.company') }}" class="nav-link">Contact</a></li>
            <li class="nav-item"><a style="color:#000;" href="whatsapp://send?text=Hello&phone=+62 811-1047-992" class="nav-link"><span class="icon-whatsapp" style="color:green; font-size: 24px; padding-right: 5px;"></span>What's App</a></li>
            @if (Route::has('login'))
            @auth
            <li class="nav-item">
              <div class="dropdown" style="margin-top:12px;">
                <a style="color:#000;" class="nav-link" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="icon-person"></span> {{ Auth::user()->name }}
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                  <a href="{{ route('user.account', Auth::user()->id) }}" class="dropdown-item" type="button">Ubah Profil</a>
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
	        </ul>
	      </div>
	    </div>
	  </nav>
    <!-- END nav -->