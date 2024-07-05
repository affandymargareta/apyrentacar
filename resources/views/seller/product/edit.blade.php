           
          
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
                  <form method="post" action="{{ route('productm.update', $product->id) }}" enctype="multipart/form-data">               
                    @method('PUT')
                    @csrf
                    <div class="form-group" style="color: #000;">
                      <label >Name</label>
                      <select name="name" style="background: #f8f9fa !important; color: #0044cc !important;" class="rounded-pill form-control">
                          <option value="">Pilih</option>
                          @foreach ($seller as $row)
                          <option value="{{ $row->id }}" {{ old('name') == $row->id ? 'selected':'' }}>{{ $row->name }}</option>
                          @endforeach
                      </select>  
                      <small class="form-text text-muted">We'll never share your Wilayah with anyone else.</small>
                    </div>
                  <div class="form-group" style="color: #fff;">
                    <label >Jenis</label>
                    <input type="text" class="form-control" name="jenis" value="{{ $product->jenis }}">
                    <small class="form-text text-muted">We'll never share your Jenis with anyone else.</small>
                  </div> 
                  <div class="form-group" style="color: #fff;">
                    <label >Wilayah</label>
                    <select name="wilayah" style="background: #f8f9fa !important; color: #0044cc !important;" class="rounded-pill form-control">
                        <option value="">Pilih</option>
                        @foreach ($province as $row)
                        <option value="{{ $row->id }}" {{ old('wilayah') == $row->id ? 'selected':'' }}>{{ $row->province }}</option>
                        @endforeach
                    </select>  
                    <small class="form-text text-muted">We'll never share your Wilayah with anyone else.</small>
                  </div>
                  <div class="form-group" style="color: #fff;">
                    <label >Bagasi</label>
                    <input type="text" class="form-control" name="bagasi" value="{{ $product->bagasi }}">
                    <small class="form-text text-muted">We'll never share your Bagasi with anyone else.</small>
                  </div>
                  <div class="form-group" style="color: #fff;">
                    <label >Kursi</label>
                    <input type="text" class="form-control" name="kursi" value="{{ $product->kursi }}">
                    <small class="form-text text-muted">We'll never share your Kursi with anyone else.</small>
                  </div>
                  <div class="form-group" style="color: #fff;">
                    <label >Price</label>
                    <input type="text" class="form-control" name="price" value="{{ $product->price }}">
                    <small class="form-text text-muted">We'll never share your Price with anyone else.</small>
                  </div>

                  <div class="form-group" style="color: #fff;">
                    <label >Stock</label>
                    <input type="text" class="form-control" name="stock" value="{{ $product->stock }}">
                    <small class="form-text text-muted">We'll never share your Price with anyone else.</small>
                  </div>

                  <div class="form-group" style="color: #000;">
                    <label>Status</label>
                      <select  name="status" style="background: #f8f9fa !important; color: #0044cc !important;" class="rounded-pill form-control">
                        <option value="0">Tidak Aktif</option>
                        <option value="1">Aktif</option>
                      </select>
                      <small class="form-text text-muted">We'll never share your Status with anyone else.</small>
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
