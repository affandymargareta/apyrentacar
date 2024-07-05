           
          
    @extends('layouts.seller')
    @section('content')
    <!-- END nav -->
    <section class="">

      <nav class="navbar navbar-dark sticky-top flex-md-nowrap" style="padding: 20px;">
      <a class="navbar-brand col-sm-3 col-md-2" href="{{ route('home') }}" style="background-color: #fff;"><img src="{{ asset('images/apyrentacars.png') }}" style="width: 150px;">
        </a>
        <!-- <a class="navbar-brand col-sm-3 col-md-2 mr-0 btn btn-outline-info" href="index.html" type="button">Company name</a> -->
        <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
        <ul class="navbar-nav px-3">
          <li class="nav-item text-nowrap">
            <!-- <a class="nav-link btn btn-outline-info" href="#">Sign out</a> -->
              <!-- Authentication -->
              <form method="POST" action="{{ route('mlogout.destroy') }}">
                @csrf

                <a class="nav-link btn btn-outline-info" type="button" :href="route('mlogout.destroy')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </a>
            </form>
            <!-- Authentication -->
          </li>
        </ul>
      </nav>
      <div class="container-fluid">
        <div class="row">
          <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="sidebar-sticky">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link active" href="{{ route('mdashboard') }}">
                        <i class="zmdi zmdi-widgets"></i>
                        {{ $seller->name }}
                      </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" href="{{ route('mdashboard') }}">
                        <i class="zmdi zmdi-widgets"></i>
                        Dashboard <span class="sr-only">(current)</span>
                      </a>
                </li>
                @if ($seller->suspend > 0)
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('morder.index') }}">
                    <i class="zmdi zmdi-file-text"></i>
                        Orders
                      </a>
                </li>
               
                <li class="nav-item">
                      <a class="nav-link" href="{{ route('productm.index') }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                        Product
                      </a>
                </li>
                @endif

              </ul>
      
            </div>
          </nav>
          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 my-3">
            <div class="card-list">
              <div class="row">
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
                  <div class="card blue">
                    <div class="title">all order</div>
                    <i class="zmdi zmdi-upload"></i>
                      <div class="value">{{ $seller->order->where('payment_status', 'paid')->count() }}</div>

                    <!-- <div class="stat"><b>13</b>% increase</div> -->
                  </div>
                </div>
                <!-- <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
                  <div class="card green">
                    <div class="title">team members</div>
                    <i class="zmdi zmdi-upload"></i>
                    <div class="value">5,990</div>
                    <div class="stat"><b>4</b>% increase</div>
                  </div>
                </div> -->
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
                  <div class="card orange">
                    <div class="title">total budget</div>
                    <i class="zmdi zmdi-download"></i>
                    <div class="value">{{ formatUang($seller->order()->where('payment_status', 'paid')->sum('price') - $subtotal) }}</div>
                    <!-- <div class="stat"><b>13</b>% decrease</div> -->
                  </div>
                </div>
                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-4">
                  <div class="card red">
                    <div class="title">all customers</div>
                    <i class="zmdi zmdi-download"></i>
                    <div class="value">{{ $seller->order->where('payment_status', 'paid')->count() }}</div>
                    <!-- <div class="stat"><b>13</b>% decrease</div> -->
                  </div>
                </div>
              </div>
            </div>
              <div class="container" style="color: #fff;">
                  <table id="example" class="table table-striped table-bordered" style="color: #fff;">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Member</th>
                          <th>Image</th>
                          <th>price</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($payment as $getData)
                        <tr>
                        <td>{{ $loop->iteration }}</td>

                          
                          <td>
                            {{ $getData ->name }}
                          </td>

                          <td>
                             {{ $getData->seller->name }}
                          </td>

                          <td>															
                              <a  href="">
                                  <img class="img-fluid" src="{{ asset($getData->image) }}" width="100px;" height ="100px;" alt="image" />
                              </a>
                          </td>

                          <td>
                            {{ formatUang($getData->price) }}
                          </td>
                          <td>
                            {{ $getData ->date }}
                          </td>
                          
                        </tr>
                        @endforeach
                      </tbody>
                      
                  </table>
              </div>
          
        </div>

          </main>

      </div>
           
    </section>	

    <footer class="">

    </footer>
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