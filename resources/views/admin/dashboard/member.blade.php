           
          
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
                  <a class="nav-link" href="{{ route('acustomer.index') }}">
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
                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Tambah Membership
                  </button>
                  <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-scrollable">
                        <form method="POST" action="{{ route('mregister.store') }}">
                        @csrf
                      
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                              <div class="form-group" style="color: #000;">
                                <label >Name</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                <small class="form-text text-muted">We'll never share your Name with anyone else.</small>
                              </div>
                                <input type="hidden" name="suspend" value="1" class="form-control">

                              <div class="form-group" style="color: #000;">
                                <label >Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                <small class="form-text text-muted">We'll never share your email with anyone else.</small>
                              </div>

                              <div class="form-group" style="color: #000;">
                                <label >Phone</label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
                                <small class="form-text text-muted">We'll never share your phone with anyone else.</small>
                              </div>

                              <div class="form-group" style="color: #fff;">
                                <label >City</label>
                                <select name="city" style="background: #f8f9fa !important; color: #0044cc !important;" class="rounded-pill form-control">
                                    <option value="">Pilih</option>
                                    @foreach ($province as $row)
                                    <option value="{{ $row->id }}" {{ old('city') == $row->id ? 'selected':'' }}>{{ $row->province }}</option>
                                    @endforeach
                                </select>  
                                <small class="form-text text-muted">We'll never share your Wilayah with anyone else.</small>
                              </div>
                              
                              <div class="form-group" style="color: #000;">
                                <label >Address</label>
                                <input type="text" class="form-control" name="address" value="{{ old('address') }}">
                                <small class="form-text text-muted">We'll never share your address with anyone else.</small>
                              </div>

                              <div class="form-group" style="color: #000;">
                                <label >Date</label>
                                <input type="date" class="form-control" name="tanggal" value="{{ old('tanggal') }}">
                                <small class="form-text text-muted">We'll never share your date with anyone else.</small>
                              </div>

                             
                              <div class="form-group" style="color: #000;">
                                <label >Password</label>
                                <input type="password" class="form-control" name="password" value="{{ old('password') }}">
                                <small class="form-text text-muted">We'll never share your password with anyone else.</small>
                              </div>

                              <div class="form-group" style="color: #000;">
                                <label >Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}">
                                <small class="form-text text-muted">We'll never share your password with anyone else.</small>
                              </div>
                                                       
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">{{ __('Register') }}</button>
                          </div>
                        </div>
                        </form>
                      </div>
                    </div>
                    <!-- Scrollable modal -->
                    <!-- <div class="count">| 32 Projects</div> -->
                    <i class="zmdi zmdi-download"></i>
                  </header>
                  <div class="container" style="color: #fff;">
                      <table id="example" class="table table-striped table-bordered" style="color: #fff;">
                          <thead>
                            <tr>
                              <th>ID</th>
                              <th>Nama</th>
                              <th>Suspend</th>
                              <th>Email</th>
                              <th>Phone</th>
                              <th>Date</th>
                              <th>City</th>
                              <th>Address</th>
                              <!-- <th>Description</th> -->
                              <th>Actions</th>
                            </tr>
                          </thead>
                          <tbody>
                          @foreach ($seller as $getData)
                            <tr>
                              <td>{{ $loop->iteration }}</td>

                              <td>
                                {{ $getData->name }}
                              </td>
                              <td>
                                  {{ $getData->suspend }}
                              </td>
                              <td>
                                  {{ $getData->email }}
                              </td>
                              <td>
                                {{ $getData->phone }}
                              </td>
                              <td>
                                {{ $getData->tanggal }}
                              </td>
                              <td>
                                  {{ $getData->province->province }}
                              </td>
                              <td>
                                  {{ $getData->address }}
                              </td>
                             
                             
                              <td>
                                <form action="" method="post">
                                  @csrf
                                  @method('DELETE')
                                  <a href="{{ route('suspend', $getData->id) }}" type="button" class="btn btn-info">Edit Product</a>
                                  <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
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
