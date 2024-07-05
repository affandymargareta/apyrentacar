

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
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span class="mr-2"><a href="blog.html">Blog <i class="ion-ios-arrow-forward"></i></a></span> <span>Blog Single <i class="ion-ios-arrow-forward"></i></span></p>
            <!-- <h1 class="mb-3 bread">Read our blog</h1> -->
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section ftco-degree-bg">
      <div class="container">
        <div class="row">
        <div class="col-md-4 sidebar ftco-animate">

            <div class="sidebar-box ftco-animate border border-light" style="background: rgb(242, 243, 243);">
              <div class="categories">
                <!-- <h3>Categories</h3> -->
                <div class="block-21 mb-4 d-flex">
                  <a class="blog-img mr-4 rounded-circle" style="background-image: url({{ asset('images/person_1.jpg') }});"></a>
                  <div class="text">
                    <h3 class="heading"><a href="#">Caren Gibran</a></h3>
                    <div class="meta">
                      <!-- <div><a href="#"><span class="icon-calendar"></span>Oct. 29, 2019</a></div> -->
                      <!-- <div><a href="#"><span class="icon-person"></span> Admin</a></div> -->
                      <!-- <div><a href="#"><span class="icon-chat"></span> 19</a></div> -->
                    </div>
                  </div>
                </div>
                <li><a href="{{ route('user.dashboard') }}">Pesanan Saya <span>(12)</span></a></li>
                <li><a href="{{ route('user.account', Auth::user()->id) }}">Akun Saya <span>(22)</span></a></li>
                <li><a href="#">Keluar Dari Akun <span>(37)</span></a></li>
                <!-- <li><a href="#">Subaru <span>(42)</span></a></li>
                <li><a href="#">Toyota <span>(14)</span></a></li>
                <li><a href="#">Mistsubishi <span>(140)</span></a></li> -->
              </div>
            </div>

          </div>
          <div class="col-md-8 ftco-animate">
          <!-- <h2 class="mb-3">It is a long established fact a reader be distracted</h2> -->
					<form method="post" action="{{ route('userupdate', $user->id) }}" enctype="multipart/form-data">               
            @method('PUT')
            @csrf            
            <div class="form-group">
              <label for="inputAddress">Nama Lengkap</label>
              <input type="text" name="name" class="form-control" id="inputAddress" placeholder="{{ $user->name }}">
              <small id="passwordHelpBlock" class="form-text text-muted">
                Nama lengkap Anda akan disingkat untuk nama profil.
              </small>
            </div>

            <div class="form-row">

              <div class="form-group col-md-3">
                <label for="inputState">Kelamin</label>
                <select name="gender" id="inputState" class="form-control">
                  <option selected>{{ $user->gender }}</option>
                  <option value="men">Laki Laki</option>
                  <option value="women">Perempuan</option>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label for="inputState">Tanggal Lahir</label>
                <select  name="tanggal" id="inputState" class="form-control">
                  <option selected>{{ $user->tanggal }}</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                  <option value="25">25</option>
                  <option value="26">26</option>
                  <option value="27">27</option>
                  <option value="28">28</option>
                  <option value="29">29</option>
                  <option value="30">30</option>
                  <option value="30">31</option>
                </select>
              </div>
              <div class="form-group col-md-3">
                <label for="inputState">Bulan Lahir</label>
                <select name="bulan" id="inputState" class="form-control">
                  <option selected>{{ $user->bulan }}</option>
                  <option value="Januari">Januari</option>
                  <option value="Februari">Februari</option>
                  <option value="Maret">Maret</option>
                  <option value="April">April</option>
                  <option value="Mei">Mei</option>
                  <option value="Juni">Juni</option>
                  <option value="Juli">Juli</option>
                  <option value="Agustus">Agustus</option>
                  <option value="September">September</option>
                  <option value="Oktober">Oktober</option>
                  <option value="November">November</option>
                  <option value="Desember">Desember</option>

                </select>
              </div>
              <div class="form-group col-md-3">
                <label for="inputState">Tahun Lahir</label>
                <select name="tahun" id="inputState" class="form-control">
                  <option selected>{{ $user->tahun }}</option>
                  <option value="2023">2023</option>
                  <option value="2022">2022</option>
                  <option value="2021">2021</option>
                  <option value="2020">2020</option>
                  <option value="2019">2019</option>
                  <option value="2018">2018</option>
                  <option value="2017">2017</option>
                  <option value="2016">2016</option>
                  <option value="2015">2015</option>
                  <option value="2014">2014</option>
                  <option value="2013">2013</option>
                  <option value="2012">2012</option>
                  <option value="2011">2011</option>
                  <option value="2010">2010</option>
                  <option value="2009">2009</option>
                  <option value="2008">2008</option>
                  <option value="2007">2007</option>
                  <option value="2006">2006</option>
                  <option value="2005">2005</option>
                  <option value="2004">2004</option>
                  <option value="2003">2003</option>
                  <option value="2002">2002</option>
                  <option value="2001">2001</option>
                  <option value="1999">1999</option>
                  <option value="1998">1998</option>
                  <option value="1997">1997</option>
                  <option value="1996">1996</option>
                  <option value="1995">1995</option>
                  <option value="1994">1994</option>
                  <option value="1993">1993</option>
                  <option value="1992">1992</option>
                  <option value="1991">1991</option>
                  <option value="1990">1990</option>
                  <option value="1899">1899</option>
                  <option value="1898">1898</option>
                  <option value="1897">1897</option>
                  <option value="1896">1896</option>
                  <option value="1895">1895</option>
                  <option value="1894">1894</option>
                  <option value="1893">1893</option>
                  <option value="1892">1892</option>
                  <option value="1891">1891</option>
                  <option value="1890">1890</option>
                  <option value="1889">1889</option>
                  <option value="1888">1888</option>
                  <option value="1887">1887</option>
                  <option value="1886">1886</option>
                  <option value="1885">1885</option>
                  <option value="1884">1884</option>
                  <option value="1883">1883</option>
                  <option value="1882">1882</option>
                  <option value="1881">1881</option>
                  <option value="1880">1880</option>
                  <option value="1879">1879</option>
                  <option value="1878">1878</option>
                  <option value="1877">1877</option>
                  <option value="1876">1876</option>
                  <option value="1875">1875</option>
                  <option value="1874">1874</option>
                  <option value="1873">1873</option>
                  <option value="1872">1872</option>
                  <option value="1871">1871</option>
                  <option value="1870">1870</option>
                </select>
              </div>

            </div>
            <div class="form-group">
                <label for="inputAddress">Kota Tempat Tinggal</label>
                <input type="text" name="city" class="form-control" id="inputAddress" placeholder="{{ $user->city }}">
                <small id="passwordHelpBlock" class="form-text text-muted">
                 Kota Tempat Tinggal.
                </small>
            </div>
            <div class="form-group">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="gridCheck">
                <label class="form-check-label" for="gridCheck">
                  Check me out
                </label>
              </div>
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
          </form>
          <!-- .col-md-8 -->


        </div>
      </div>
    </section> <!-- .section -->

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>



@endsection
<!-- @section('js')
<script>
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
</script>
@endsection -->
