

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
          	<p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span class="mr-2"><a href="blog.html">User <i class="ion-ios-arrow-forward"></i></a></span> <span>Dashboard <i class="ion-ios-arrow-forward"></i></span></p>
            <!-- <h1 class="mb-3 bread">Read our blog</h1> -->
          </div>
        </div>
      </div>
    </section>

    <section class="ftco-section ftco-degree-bg">
      <div class="container">
        <div class="row">
        <div class="col-lg-3 sidebar">

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
                <li><a href="{{ route('user.dashboard') }}">Pesanan Saya <span></span></a></li>
                <li><a href="{{ route('user.account', Auth::user()->id) }}">Akun Saya <span></span></a></li>
                <li><a href="#">Keluar Dari Akun <span></span></a></li>
                <!-- <li><a href="#">Subaru <span>(42)</span></a></li>
                <li><a href="#">Toyota <span>(14)</span></a></li>
                <li><a href="#">Mistsubishi <span>(140)</span></a></li> -->
              </div>
            </div>

          </div>
          <div class="col-lg-9">
          <!-- <h2 class="mb-3">It is a long established fact a reader be distracted</h2> -->
          <div class="table-responsive">
          <table id="example" class="table table-striped table-bordered">
              <thead>
                <tr>
                <th style="font-size: 12px; padding: 10px;">Invoice</th>
                <th style="font-size: 12px; padding: 10px;">Product</th>
                <th style="font-size: 12px; padding: 10px;">Wilayah</th>
                <th style="font-size: 12px; padding: 10px;">Mulai</th>
                <th style="font-size: 12px; padding: 10px;">Durasi</th>
                <th style="font-size: 12px; padding: 10px;">Costumer</th>
                <th style="font-size: 12px; padding: 10px;">Price</th>
                <th style="font-size: 12px; padding: 10px;">Action</th>
                </tr>
              </thead>
              <tbody>
              @foreach ($order as $getData)

                <tr>
                  <td style="font-size: 12px; padding: 10px;">{{ $getData ->invoice }}</td>
                  <td style="font-size: 12px; padding: 10px;">
                  {{ $getData->product->productName->name }}
                  </td>
                  <td style="font-size: 12px; padding: 10px;">{{ $getData ->wilayah }}</td>
                  <td style="font-size: 12px; padding: 10px;">
                      {{ date("D, d F Y", strtotime($getData ->mulai)) }}
                  </td>
                  <td style="font-size: 12px; padding: 10px;">
                      {{ $getData ->durasi }} Hari/Days
                  </td>
                  
                  <td style="font-size: 12px; padding: 10px;">
                    {{ $getData ->customer_name }} <br> {{ $getData->customer_telpon }} <br> {{ $getData ->customer_email }}
                </td>
                <td style="font-size: 12px; padding: 10px;">
                  {{ $getData ->price }}
                  </td>

                  <td style="font-size: 12px; padding: 10px;">
                  @if ($getData->payment_status === 'unpaid')
                      <a href="{{ $getData->payment_url }}" type="button" class="btn btn-info"  style="font-size: 10px; padding: 10px; margin: 10px;">Bayar Order</a>
                  @else
                    @if ($getData->supir_name > 0)
                    <form action="{{ route('userinvoice') }}" method="post">
                      @csrf
                      @method('POST')
                      <input type="hidden" class="form-control" name="order_id" value="{{ $getData->id }}">
                      <button type="submit" class="btn btn-info"  style="font-size: 10px; padding: 10px; margin: 10px;">Download Voucher</button>
                    </form>
                    
                    @endif
                  
                  @endif
                  </td>
                </tr>
                @endforeach

              </tbody>
            </table>
            </div>
          </div> 
          <!-- .col-md-8 -->


        </div>
      </div>
    </section> <!-- .section -->

  <!-- loader -->
  <div id="ftco-loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/></svg></div>



@endsection
@section('css')
    <link href="https://cdn.datatables.net/2.0.7/css/dataTables.bootstrap4.css" rel="stylesheet">
    @endsection
    @section('js')
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.7/js/dataTables.bootstrap4.js"></script>
    <script>
      $(document).ready(function() {
          $('#example').DataTable();
      } );
    </script>
    @endsection
