<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Apy Renta Car</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
    body{margin-top:20px;
      background:#eee;
      }

      /*Invoice*/
      .invoice .top-left {
          font-size:65px;
        color:#3ba0ff;
      }

      .invoice .top-right {
        text-align:right;
        padding-right:20px;
      }

      .invoice .table-row {
        margin-left:-15px;
        margin-right:-15px;
        margin-top:25px;
      }

      .invoice .payment-info {
        font-weight:500;
      }

      .invoice .table-row .table>thead {
        border-top:1px solid #ddd;
      }

      .invoice .table-row .table>thead>tr>th {
        border-bottom:none;
      }

      .invoice .table>tbody>tr>td {
        padding:8px 20px;
      }

      .invoice .invoice-total {
        margin-right:-10px;
        font-size:16px;
      }

      .invoice .last-row {
        border-bottom:1px solid #ddd;
      }

      .invoice-ribbon {
        width:85px;
        height:88px;
        overflow:hidden;
        position:absolute;
        top:-1px;
        right:14px;
      }

      .ribbon-inner {
        text-align:center;
        -webkit-transform:rotate(45deg);
        -moz-transform:rotate(45deg);
        -ms-transform:rotate(45deg);
        -o-transform:rotate(45deg);
        position:relative;
        padding:7px 0;
        left:-5px;
        top:11px;
        width:120px;
        background-color:#66c591;
        font-size:15px;
        color:#fff;
      }

      .ribbon-inner:before,.ribbon-inner:after {
        content:"";
        position:absolute;
      }

      .ribbon-inner:before {
        left:0;
      }

      .ribbon-inner:after {
        right:0;
      }

      @media(max-width:575px) {
        .invoice .top-left,.invoice .top-right,.invoice .payment-details {
          text-align:center;
        }

        .invoice .from,.invoice .to,.invoice .payment-details {
          float:none;
          width:100%;
          text-align:center;
          margin-bottom:25px;
        }

        .invoice p.lead,.invoice .from p.lead,.invoice .to p.lead,.invoice .payment-details p.lead {
          font-size:22px;
        }

        .invoice .btn {
          margin-top:10px;
        }
      }

      @media print {
        .invoice {
          width:900px;
          height:800px;
        }
      }
    </style>
  </head>
  <body>

  <nav class="navbar navbar-inverse" style="background-color: rgb(255, 255, 255);">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href=""><img src="{{ asset('images/apyrentacars.png') }}" style="width: 120px;">
      </a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="{{ route('mdashboard') }}" style="color: #1fb2ca;">Dashboard</a></li>
      <li><a href="{{ route('tanpasopirm.index') }}" style="color: #1fb2ca;">Product</a></li>
      <li><a href="{{ route('mtanpasopir') }}" style="color: #1fb2ca;">Order</a></li>
    </ul>
    <ul class="nav navbar-nav navbar-right">
      @if (Route::has('login'))
      @auth
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color: #1fb2ca;">{{ Auth::guard('seller')->user()->name }}<span class="caret"></span></a>
          
        <ul class="dropdown-menu">
              <!-- Authentication -->
            <form method="POST" action="{{ route('mlogout.destroy') }}">
                @csrf

                <a type="button" :href="route('mlogout.destroy')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                    {{ __('Log Out') }}
                </a>
            </form>
            <!-- Authentication -->
          </ul>
      </li>
      @else
      <li><a href="{{ route('login') }}" style="color: #1fb2ca;"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      @if (Route::has('register'))
      <li><a href="{{ route('register') }}" style="color: #1fb2ca;"><span class="glyphicon glyphicon-user"></span>Register</a></li>
      @endif
      @endauth     
      @endif



    </ul>
  </div>
</nav>



<div class="container bootstrap snippets bootdeys">
  <div class="row">
			<div class="col-xs-6 margintop text-right pull-right">
				<p class="lead marginbottom"></p>
        <form action="{{ route('userinvoice') }}" method="post">
          @csrf
          @method('POST')
          <input type="hidden" class="form-control" name="order_id" value="{{ $order->id }}">
          <button type="submit" class="btn btn-success" id="invoice-print"><i class="fa fa-print"></i>Unduh Detail Pesanan</button>
        </form>

        <a href="{{ route('morder.edit', $order->id) }}" class="btn btn-info"><i class="fa fa-envelope-o"></i> Isi Detail Sopir</a>
        <p class="lead marginbottom"></p>
			</div>
			<div class="col-xs-6 text-lft pull-left invoice-total">
            <p></p>
					  <p>Detail Pesanan</p>
            <p></p>
			      <p>Status: ISSUED</p>
			</div>
		</div>
<div class="row">
  <div class="col-sm-12">
	  	<div class="panel panel-default invoice" id="invoice">
		  <div class="panel-body">
			<div class="invoice-ribbon"><div class="ribbon-inner">{{ $order->payment_status }}</div></div>
			<hr>
			<div class="row">

				<div class="col-xs-6 from">
					<p>Booking ID</p>
					<p class="lead">{{ $order->invoice }}</p>
				</div>

			</div>

      <div class="row">
				<table class="table table-striped">
			      <tbody>
            <tr> 
              </tr>
              <tr>
                <td colspan="2">
                  <div style="font-size: 20px; font-weight: bold; padding: 10px">Detail Pesanan</div>
                </td>
              </tr>
			        <tr>
			          <td style="width:50%" style="font-size: 20px; padding: 25px">Detail Mobil</td>
			          <td style="width:50%" style="font-size: 20px; padding: 25px">{{ $order->product->productName->name }}</td>
			        </tr>
              <tr>
			          <td style="width:50%" style="font-size: 20px; padding: 25px">Spesifikasi Mobil</td>
			          <td style="width:50%" style="font-size: 20px; padding: 25px">With Driver</td>
			        </tr>
              <tr>
			          <td style="width:50%" style="font-size: 20px; padding: 25px">-</td>
			          <td style="width:50%" style="font-size: 20px; padding: 25px">-</td>
			        </tr>
              <tr>
			          <td style="width:50%" style="font-size: 20px; padding: 25px">Pembelian Tambahan</td>
			          <td style="width:50%" style="font-size: 20px; padding: 25px">{{ date("D, d F Y", strtotime($order->mulai)) }} <br>
                Area 0 80KM and Drivers Meals</td>
			        </tr>
              <!-- <tr>
			          <td style="width:50%" style="font-size: 20px; padding: 25px">Kebutuhan Khusus</td>
			          <td style="width:50%" style="font-size: 20px; padding: 25px">-</td>
			        </tr> -->
			       </tbody>
			    </table>

			</div>
      <div class="row">
				<table class="table table-striped">
			      <tbody>
            <tr> 
              </tr>
              <tr>
                <td colspan="2">
                  <div style="font-size: 20px; font-weight: bold; padding: 10px">Detail Rental</div>
                </td>
              </tr>
			        <tr>
			          <td style="width:50%">Kota Rental</td>
			          <td style="width:50%">{{ $order->wilayah }}</td>
			        </tr>
              <tr>
			          <td style="width:50%">Durasi Rental</td>
			          <td style="width:50%">{{ $order->durasi }}  Hari / Days</td>
			        </tr>
              <tr>
			          <td style="width:50%">Waktu Jemput</td>
			          <td style="width:50%"> {{ date("D, d F Y", strtotime($order->mulai)) }}<br> {{$order->jam_mulai}}</td>
			        </tr>
              <!-- <tr>
			          <td style="width:50%">Jam Tambahan</td>
			          <td style="width:50%">-</td>
			        </tr>
              <tr>
			          <td style="width:50%">Cutoff Type</td>
			          <td style="width:50%">-</td>
			        </tr> -->
              <tr> 
              @if ($order->jemput_id > 0)
                @if ($order->jemput_id != $order->product->wilayah)
                  <td style="width:50%">Lokasi Penjemputan</td>
                  <td style="width:50%">{{ $jemputCity->city_name }}</td>
                @else
                <td style="width:50%">Lokasi Penjemputan</td>
			          <td style="width:50%">{{ $jemputCity->city_name }}, Free</td>
                @endif
              @endif
			        </tr>
              <tr>
			          <td style="width:50%">Catatan Lokasi Penjemputan</td>
			          <td style="width:50%">-</td>
			        </tr>

              <tr>
              @if ($order->kembali_id > 0)
                @if ($order->kembali_id != $order->product->wilayah)
                <td style="width:50%">Lokasi Pengantaran</td>
                  <td style="width:50%">{{ $kembaliCity->city_name }}</td>
                @else
                <td style="width:50%">Lokasi Pengantaran</td>
			          <td style="width:50%">{{ $kembaliCity->city_name }}, Free</td>
                @endif
              @endif
			        </tr>
              <tr>
			          <td style="width:50%">Catatan Lokasi Pengantaran</td>
			          <td style="width:50%">-</td>
			        </tr>
              <tr>
			          <td style="width:50%">Waktu Menurunkan</td>
			          <td style="width:50%">{{$durasi}} <br> {{$order->jam_akhir}}</td>
			        </tr>
			       </tbody>
			    </table>

			</div>

      <div class="row table-row">
				<table class="table table-striped">
        <tbody>
            <tr> 
              </tr>
              <tr>
                <td colspan="2">
                  <div style="font-size: 20px; font-weight: bold; padding: 10px">Detail Peminjam</div>
                </td>
              </tr>
			        <tr>
			          <td style="width:50%">Nama</td>
			          <td style="width:50%">{{ $order->customer_name }}</td>
			        </tr>
              <tr>
			          <td style="width:50%">Nomor Telepon Peminjam</td>
			          <td style="width:50%">{{ $order->customer_telpon }}</td>
			        </tr>
              
			       </tbody>
             <tbody>
            <tr> 
              </tr>
              <tr>
                <td colspan="2">
                  <div style="font-size: 20px; font-weight: bold; padding: 10px">Info Penyedia</div>
                </td>
              </tr>
			        <tr>
			          <td style="width:50%">Nama Perusahaan</td>
			          <td style="width:50%">{{ $order->seller->name }}</td>
			        </tr>
              <tr>
			          <td style="width:50%">Nomor Telepon</td>
			          <td style="width:50%">{{ $order->seller->phone }}</td>
			        </tr>
              
			       </tbody>
             <tbody>
            <tr> 
              </tr>
              <tr>
                <td colspan="2">
                  <div style="font-size: 20px; font-weight: bold; padding: 10px">Detail Pemesan</div>
                </td>
              </tr>
			        <tr>
			          <td style="width:50%">Email</td>
			          <td style="width:50%">{{ $order->customer_email }}</td>
			        </tr>
              <tr>
			          <td style="width:50%">Nomor Telepon</td>
			          <td style="width:50%">{{ $order->customer_telpon }}</td>
			        </tr>
              
			       </tbody>
			    </table>

			</div>

      <div class="row table-row">
				<table class="table table-striped">
        <tr>
            <td width="10%" style="">No</td>
            <td width="50%" style="">Tipe Tambahan</td>
            <td width="35%" style="">Harga/Durasi</td>
          </tr>
          <tr>
            <td style="">1</td>
            <td style="">Akomodasi Sopir <br>
            Biaya tambahan ini akan dibebankan untuk membiyai penginapan pengemudi selama perjalanan luar kota.</td>
            <td style="">IDR 150.000 / Malam</td>
          </tr>
          <tr>
            <td style="">2</td>
            <td style="">All Inclusive <br>
            Paket tambahan ini melingkupi biaya-biaya seperti biaya bensin hingga 120km/hari, 
            tol, parkir, dan makanan pengemudi. Paket tambahan ini tidak termasuk tiket masuk ke tempat wisata.</td>
            <td style="">IDR 300.000 / Hari</td>
          </tr>
          <tr>
            <td style="">3</td>
            <td style="">Antar Luar Kota Zona 1 <br>
            Biaya ini akan dikenakan ketika lokasi antar Anda di Zona 1 atau Zona 2. Biaya ini sudah termasuk Anda penggunaan ke luar kota. 
            Hanya untuk Golden Bird, juga termasuk bahan bakar. Tol dan parkir tidak termasuk dalam add-on.</td>
            <td style="">IDR 250.000 / Pemakaian</td>
          </tr>
          <tr>
            <td style="">4</td>
            <td style="">Antar Luar Kota Zona 2 <br>
            Biaya ini akan dikenakan ketika lokasi antar Anda di Zona 1 atau Zona 2. Biaya ini sudah termasuk Anda penggunaan ke luar kota. 
            Hanya untuk Golden Bird, juga termasuk bahan bakar. Tol dan parkir tidak termasuk dalam add-on.</td>
            <td style="">IDR 395.000 / Pemakaian</td>
          </tr>
          <tr>
            <td style="">5</td>
            <td style="">Area 0 165KM and Drivers Meals</td>
            <td style="">IDR 390.000 / Hari</td>
          </tr>
          <tr>
            <td style="">6</td>
            <td style="">Area 0 80KM and Drivers Meals</td>
            <td style="">IDR 225.000 / Hari</td>
          </tr>
          <tr>
            <td style="">7</td>
            <td style="">Area 1 140KM and Driver's Meals</td>
            <td style="">IDR 330.000 / Hari</td>
          </tr>
          <tr>
            <td style="">8</td>
            <td style="">Area 1 160KM and Drivers Meals</td>
            <td style="">IDR 370.000 / Hari</td>
          </tr>
          <tr>
            <td style="">9</td>
            <td style="">Area 1 180KM and Driver's Meals</td>
            <td style="">IDR 405.000 / Hari</td>
          </tr>
          <tr>
            <td style="">10</td>
            <td style="">Area 1 200KM and Drivers Meals</td>
            <td style="">IDR 440.000 / Hari</td>
          </tr>
          <tr>
            <td style="">11</td>
            <td style="">Area 1 245KM and Drivers Meals</td>
            <td style="">IDR 530.000 / Hari</td>
          </tr>
          <tr>
            <td style="">12</td>
            <td style="">Area 2 195KM and Driver's Meals</td>
            <td style="">IDR 435.000 / Hari</td>
          </tr>
          <tr>
            <td style="">13</td>
            <td style="">Area 2 220KM and Driver's Meals</td>
            <td style="">IDR 485.000 / Hari</td>
          </tr>
          <tr>
            <td style="">14</td>
            <td style="">IDR 485.000 / Hari</td>
            <td style="">IDR 520.000 / Hari</td>
          </tr>
          <tr>
            <td style="">15</td>
            <td style="">Area 2 280KM and Drivers Meals</td>
            <td style="">IDR 595.000 / Hari</td>
          </tr>
          <tr>
            <td style="">16</td>
            <td style="">Area 2 325KM and Drivers Meals</td>
            <td style="">IDR 675.000 / Hari</td>
          </tr>
          <tr>
            <td style="">17</td>
            <td style="">Jemput Luar Kota Zona 1 <br>
            Biaya ini akan dikenakan ketika lokasi penjemputan Anda di Zona 1. 
            Biaya ini sudah termasuk penggunaan luar kota. Khusus untuk Golden Bird, biaya juga termasuk bahan bakar dan makanan pengemudi. Tol, 
            parkir, dan akomodasi penginapan pengemudi tidak termasuk dalam add-on ini.</td>
            <td style="">IDR 250.000 / Pemakaian</td>
          </tr>
          <tr>
            <td style="">18</td>
            <td style="">Jemput Luar Kota Zona 2 <br>
            Biaya ini akan dikenakan ketika lokasi penjemputan Anda di Zona 2. 
            Biaya ini sudah termasuk penggunaan luar kota. Khusus untuk Golden Bird, biaya juga termasuk bahan bakar dan makanan pengemudi. Tol, 
            parkir, dan akomodasi penginapan pengemudi tidak termasuk dalam add-on ini.</td>
            <td style="">IDR 395.000 / Pemakaian</td>
          </tr>
          <tr>
            <td style="">19</td>
            <td style="">Luar Kota Zona 1 <br>
            Biaya ini akan dikenakan untuk penggunaan dalam Zona 1. 
            Khusus untuk Golden Bird, biaya sudah termasuk bahan bakar dan makanan pengemudi. 
            Biaya Tol, parkir, dan akomodasi pengemudi tidak termasuk dalam add-on ini.</td>
            <td style="">IDR 165.000 / Hari</td>
          </tr>
          <tr>
            <td style="">20</td>
            <td style="">Luar Kota Zona 2 <br>
            Biaya ini akan dikenakan untuk penggunaan dalam Zona 2. 
            Hanya untuk Golden Bird, biaya juga termasuk bahan bakar dan pengemudi makanan. 
            Tol, parkir, dan akomodasi penginapan pengemudi tidak termasuk dalam add-on ini.</td>
            <td style="">IDR 220.000 / Hari</td>
          </tr>
          <tr>
            <td style="">21</td>
            <td style="">Overtime <br>
            Biaya ini akan dikenakan ketika durasi sewa melebihi batas waktu. 
            Khusus untuk Golden Bird, biaya ini termasuk bahan bakar dan makanan pengemudi. 
            Tol dan parkir tidak termasuk. Tambahan biaya harus dibayar langsung ke sopir atau penyedia rental.</td>
            <td style="">IDR 85.000 / Jam</td>
          </tr>
			       </tbody>
			    </table>

			</div>

      <div class="row">
				<div class="col-xs-12">
          <h4>Peta Zona Luar Kota</h4>
					<p>Biaya ini akan dikenakan untuk penggunaan di Zona 1 dan Zona 2. 
            Khusus Golden Bird, biaya ini sudah termasuk bensin dan makan sopir. 
            Tol, parkir, dan akomodasi sopir tidak termasuk dalam tambahan ini.</p>
            <h4>Zone 1:</h4>
            <h4>Zone 2:</h4>
					<p>Untuk rental dengan sopir, biaya tambahan berlaku untuk perjalanan di luar area biru.</p>
				</div>
			</div>

			<div class="row table-row">
      <h4 style="margin-left: 20px">Tarif</h4>
      <h4 style="margin-left: 20px">Pembelian Online</h4>
				<table class="table table-striped">
			      <thead>
			        <tr>
			          <!-- <th class="text-center" style="width:5%">#</th> -->
			          <th>Barang</th>
			          <th>Harga</th>
			          <th>Kuantitas</th>
			          <th>Total</th>
			        </tr>
			      </thead>
			      <tbody>

            <tr>
			          <!-- <td class="text-center">1</td> -->
			          <td style=" border-color: #FFC107;">{{ $order->product->productName->name }}</td>
			          <td style=" border-color: #FFC107;">IDR {{ $order->product->price }}</td>
			          <td style=" border-color: #FFC107;">{{ $order->durasi }}</td>
			          <td style=" border-color: #FFC107;">IDR {{ $order->product->price * $order->durasi }}</td>
			        </tr>

            @if ($jemputPrice > 0)
              @if ($order->jemput_id != $order->product->wilayah)
              <tr>
                <td style=" border-color: #FFC107;">Antar Luar Kota Zona {{ $jemputzona }}</td>
                <td style=" border-color: #FFC107;">IDR {{ $jemputPrice }}</td>
                <td style=" border-color: #FFC107;">{{ $order->durasi }}</td>
                <td style=" border-color: #FFC107;">IDR {{ $jemputPrice * $order->durasi }}</td>
              </tr>	
              @else

              @endif
            @endif
            
            @if ($kembaliPrice > 0)
              @if ($order->kembali_id != $order->product->wilayah)
              <tr>
                <td style=" border-color: #FFC107;">Antar Luar Kota Zona {{ $Kembalizona}}</td>
                <td style=" border-color: #FFC107;">IDR {{ $kembaliPrice }}</td>
                <td style=" border-color: #FFC107;">{{ $order->durasi }}</td>
                <td style=" border-color: #FFC107;">IDR {{ $kembaliPrice  * $order->durasi}}</td>
              </tr>
              @else

              @endif
            @endif
			        <tr>
			          <!-- <td class="text-center">3</td> -->
			          <td style=" border-color: #FFC107;"></td>
			          <td style=" border-color: #FFC107;"></td>
			          <td style=" border-color: #FFC107;">Total Harga</td>
			          <td style=" border-color: #FFC107;">IDR {{ $order->price }}</td>
			        </tr>
			         
			       </tbody>
			    </table>

			</div>

			<!-- <div class="row">
			<div class="col-xs-6 margintop">
				<p class="lead marginbottom">THANK YOU!</p>

				<button class="btn btn-success" id="invoice-print"><i class="fa fa-print"></i> Print Invoice</button>
				<button class="btn btn-danger"><i class="fa fa-envelope-o"></i> Mail Invoice</button>
			</div>
			<div class="col-xs-6 text-right pull-right invoice-total">
					  <p>Subtotal : $1019</p>
			          <p>Discount (10%) : $101 </p>
			          <p>VAT (8%) : $73 </p>
			          <p>Total : $991 </p>
			</div>
			</div> -->

		  </div>
		</div>
	</div>
</div>
</div>

</body>
</html>