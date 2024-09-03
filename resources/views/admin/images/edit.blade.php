           
          
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
            <!-- Authentication -->
            <form method="POST" action="{{ route('alogout.destroy') }}">
                @csrf

                <a class="nav-link btn btn-outline-info" type="button" :href="route('alogout.destroy')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </a>
            </form>
            <!-- Authentication -->
            <!-- <a class="nav-link btn btn-outline-info" href="#">Sign out</a> -->
          </li>
        </ul>
      </nav>
      <div class="container-fluid">
        <div class="row">
          <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="sidebar-sticky">
            <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link active" href="index.html">
                        <i class="zmdi zmdi-widgets"></i>
                        {{ Auth::guard('admin')->user()->name }}
                      </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link active" href="index.html">
                        <i class="zmdi zmdi-widgets"></i>
                        Dashboard <span class="sr-only">(current)</span>
                      </a>
                </li>
                <li class="nav-item">
                      <a class="nav-link" href="{{ route('sellerpayment.index') }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                        Payment Seller
                      </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="">
                    <i class="zmdi zmdi-file-text"></i>
                        Orders
                      </a>
                </li>

                <li class="nav-item">
                  <a class="nav-link" href="">
                    <i class="zmdi zmdi-file-text"></i>
                        Orders
                      </a>
                </li>

                <li class="nav-item">
                      <a class="nav-link" href="{{ route('member') }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                        Membership
                      </a>
                </li>
                <li class="nav-item">
                      <a class="nav-link" href="{{ route('addon.index') }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                        Add On
                      </a>
                </li>
                <li class="nav-item">
                      <a class="nav-link" href="{{ route('banner.index') }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                        Banner
                      </a>
                </li>
                <li class="nav-item">
                      <a class="nav-link" href="{{ route('contact.index') }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                        Contact
                      </a>
                </li>
                <li class="nav-item">
                      <a class="nav-link" href="{{ route('company.index') }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                        Company
                      </a>
                </li>
                <li class="nav-item">
                      <a class="nav-link" href="{{ route('blog.index') }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                        Blog
                      </a>
                </li>
                <li class="nav-item">
                      <a class="nav-link" href="">
                        <i class="zmdi zmdi-shopping-cart"></i>
                        Product
                      </a>
                </li>

                <li class="nav-item">
                      <a class="nav-link" href="">
                        <i class="zmdi zmdi-shopping-cart"></i>
                        Product
                      </a>
                </li>

                <li class="nav-item">
                      <a class="nav-link" href="{{ route('productname.index') }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                        Product Name
                      </a>
                </li>

                <li class="nav-item">
                      <a class="nav-link" href="{{ route('productcar.index') }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                        Product seller Name
                      </a>
                </li>

                <li class="nav-item">
                      <a class="nav-link" href="{{ route('productimage.index') }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                        Product Image
                      </a>
                </li>

                <li class="nav-item">
                      <a class="nav-link" href="{{ route('province.index') }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                        Province
                      </a>
                </li>
                <li class="nav-item">
                      <a class="nav-link" href="{{ route('city.index') }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                        City
                      </a>
                </li>
                <li class="nav-item">
                      <a class="nav-link" href="{{ route('cityprice.index') }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                        City Price
                      </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('acustomer') }}">
                        <i class="zmdi zmdi-accounts"></i>
                        Customers
                      </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">
                        <i class="zmdi zmdi-chart"></i>
                        Reports
                      </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">
                        <i class="zmdi zmdi-layers"></i>
                        Integrations
                      </a>
                </li>
              </ul>
      
              <h6 class="sidebar-heading d-flex justify-content-between align-items-center pl-3 mt-4 mb-1 text-muted">
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
              </ul>
            </div>
          </nav>
          <main role="main" class="col-md-9 ml-sm-auto col-lg-10 my-3">
            <div class="projects mb-4">
              <div class="projects-inner">
                  <header class="projects-header">
                    <!-- <div class="title">Product <a href="product-create.html" type="button" class="btn btn-info">Tambah Product</a>
                    </div> -->
                    <!-- Button trigger modal -->
                  <button type="button" class="btn btn-primary">
                    Tambah Product
                  </button>
                  <!-- Modal -->
                    <!-- Scrollable modal -->
                    <!-- <div class="count">| 32 Projects</div> -->
                    <i class="zmdi zmdi-download"></i>
                  </header>
                  <form method="post" action="{{ route('productimage.update', $images->id) }}" enctype="multipart/form-data">               
                    @method('PUT')
                    @csrf
                    <div class="form-group" style="color: #fff;">
                      <label >Product</label>
                      <select name="product_id" style="background: #f8f9fa !important; color: #0044cc !important;" class="rounded-pill form-control">
                          <option value="">Pilih</option>
                          @foreach ($product as $row)
                          <option value="{{ $row->id }}" {{ old('product_id') == $row->id ? 'selected':'' }}>{{ $row->name }}</option>
                          @endforeach
                      </select>  
                      <small class="form-text text-muted">We'll never share your Wilayah with anyone else.</small>
                    </div>

                  <div class="form-group" style="color: #fff;">
                    <label >Gambar</label>
                    <input type="file" class="form-control" name="image">
                    <small class="form-text text-muted">We'll never share your Gambar with anyone else.</small>
                  </div>
                 
                 
                      <button type="submit" class="btn btn-primary">Submit</button>
                  </form>
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
