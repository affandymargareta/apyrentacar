           
          
    @extends('layouts.admin')
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
                        {{ Auth::guard('seller')->user()->name }}
                      </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" href="{{ route('mdashboard') }}">
                        <i class="zmdi zmdi-widgets"></i>
                        Dashboard <span class="sr-only">(current)</span>
                      </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('mdengansopir.index') }}">
                    <i class="zmdi zmdi-file-text"></i>
                        Orders Dengan Supir
                      </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="{{ route('mtanpasopir.index') }}">
                    <i class="zmdi zmdi-file-text"></i>
                        Orders Tanpa Supir
                      </a>
                </li>
               
                <li class="nav-item">
                      <a class="nav-link" href="{{ route('dengansopirm.index') }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                        Dengan Sopir
                      </a>
                </li>
                <li class="nav-item">
                      <a class="nav-link" href="{{ route('tanpasopirm.index') }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                        Tanpa Sopir
                      </a>
                </li>
                
              </ul>
      
      
              <!-- <h6 class="sidebar-heading d-flex justify-content-between align-items-center pl-3 mt-4 mb-1 text-muted">
                <span>Saved reports</span>
                <a class="d-flex align-items-center text-muted" href="#">
                  <i class="zmdi zmdi-plus-circle-o"></i>
                </a>
              </h6>
              <ul class="nav flex-column mb-2">
                <li class="nav-item">
                  <a class="nav-link" href="#">
                        <i class="zmdi zmdi-file-text"></i>
                        Current month
                      </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">
                        <i class="zmdi zmdi-file-text"></i>
                        Last quarter
                      </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">
                        <i class="zmdi zmdi-file-text"></i>
                        Social engagement
                      </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">
                        <i class="zmdi zmdi-file-text"></i>
                        Year-end sale
                      </a>
                </li>
              </ul> -->
            </div>
          </nav>
          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 my-3">
            <div class="projects mb-4">
              <div class="projects-inner">
                  <header class="projects-header">
                    <!-- <div class="title">Product <a href="product-create.html" type="button" class="btn btn-info">Tambah Product</a>
                    </div> -->
                    <!-- Button trigger modal -->
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Order
                  </button>
                  <!-- Modal -->

                    <!-- <div class="count">| 32 Projects</div> -->
                    <i class="zmdi zmdi-download"></i>
                  </header>
                  <div class="container" style="color: #fff;">
                      <table id="example" class="table table-striped table-bordered" style="color: #fff;">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Invoice</th>
                              <th>Wilayah</th>
                              <th>Mulai</th>
                              <th>Durasi</th>
                              <th>Product</th>
                              <th>Customer</th>
                              <th>Supir</th>
                              <th>Payment</th>
                              <th>Price</th>
                              <!-- <th>Description</th> -->
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach ($order as $getData)
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>
                                {{ $getData ->invoice }}
                              </td>
                              <td>
                                  {{ $getData ->wilayah }}
                              </td>
                              <td>
                                  {{ date("D, d F Y", strtotime($getData ->mulai)) }}
                              </td>

                              <td>
                                  {{ $getData ->durasi }} Hari/Days
                              </td>
                              <td>
                              {{ $getData ->product_id }}
                              </td>

                              <td>
                                  {{ $getData ->customer_name }} <br> {{ $getData->customer_telpon }} <br> {{ $getData ->customer_email }}

                              </td>
                              
                              <td>
                              {{ $getData ->supir_name }} <br> {{ $getData ->supir_telpon }} <br> {{ $getData ->plat_nomer }}
                              </td>

                              <td>
                              {{ $getData ->payment_status }}
                              </td>
                              
                              <td>
                              {{ $getData ->price }}
                              </td>
                            
                              <td>
                           
                                <a href="{{ route('morder.edit', $getData->id) }}" type="button" class="btn btn-info"  style="font-size: 10px;">Isi Data Sopir</a>
                                <a href="{{ route('morder.show', $getData->id) }}" type="button" class="btn btn-info"  style="font-size: 10px;">Invoice</a>
                                <form action="{{ route('userinvoice') }}" method="post">
                                @csrf
                                @method('POST')
                                <input type="hidden" class="form-control" name="order_id" value="{{ $getData->id }}">
                                <button type="submit" class="btn btn-success" style="font-size: 10px;">Download Voucher</button>
                              </form>
                                <!-- <button type="submit" class="btn btn-danger">Delete</button> -->
                              </td>
                            </tr>
                            @endforeach
                          </tbody>
                          <!-- <tfoot>
                              <tr>
                                  <th>Name</th>
                                  <th>Position</th>
                                  <th>Office</th>
                                  <th>Age</th>
                                  <th>Start date</th>
                                  <th>Salary</th>
                              </tr>
                          </tfoot> -->
                      </table>
                  </div>
              </div>
            </div>

            <div class="chart-data">
              <div class="row">
                <div class="col-12 col-md-4">
                  <div class="chart radar-chart dark">
                    <div class="actions">
                      <button type="button" class="btn btn-link" 
                            data-toggle="dropdown" 
                            aria-haspopup="true" aria-expanded="false">
                         <i class="zmdi zmdi-more-vert"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" type="button">Action</button>
                        <button class="dropdown-item" type="button">Another action</button>
                        <button class="dropdown-item" type="button">Something else here</button>
                      </div>
                    </div>
                    <h3 class="title">Household Expenditure</h3>
                    <p class="tagline">Yearly</p>
                    <canvas height="400" id="radarChartDark"></canvas>
                  </div>
                </div>
                <div class="col-12 col-md-4">
                  <div class="chart bar-chart light">
                    <div class="actions">
                      <button type="button" class="btn btn-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <i class="zmdi zmdi-more-vert"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" type="button">Action</button>
                        <button class="dropdown-item" type="button">Another action</button>
                        <button class="dropdown-item" type="button">Something else here</button>
                      </div>
                    </div>
                    <h3 class="title">Monthly revenue</h3>
                    <p class="tagline">2015 (in thousands US$)</p>
                    <canvas height="400" id="barChartHDark"></canvas>
                  </div>
                </div>
                <div class="col-12 col-md-4">
                  <div class="chart doughnut-chart dark">
                    <div class="actions">
                      <button type="button" class="btn btn-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                         <i class="zmdi zmdi-more-vert"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-right">
                        <button class="dropdown-item" type="button">Action</button>
                        <button class="dropdown-item" type="button">Another action</button>
                        <button class="dropdown-item" type="button">Something else here</button>
                      </div>
                    </div>
                    <h3 class="title">Exports of Goods</h3>
                    <p class="tagline">2015 (in billion US$)</p>
                    <canvas height="400" id="doughnutChartDark"></canvas>
                  </div>
                </div>
              </div>
            </div>
          </main>
        </div>
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
