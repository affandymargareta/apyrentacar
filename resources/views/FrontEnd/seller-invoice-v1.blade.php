</html>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>APY RENT A CAR</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Latest compiled and minified CSS -->
	<!-- <link rel="stylesheet" href="{{ asset('assets/bootstrap/pdf.css') }}"> -->
	<style>
		table {
			width: 100%;
			border-collapse: collapse;
		}

		table tr td,
		tbody tr td,
		thead tr th {
			padding: 20px 13px;
		}

		.bg-primary {
			background-color: #ebebeb;
		}

		/* add background odd and even */
		table tr:nth-child(even) {
			background-color: #f2f2f2;
		}

		#tablePanduan tr:nth-child(even) {
			background-color: #ffffff;
		}

		#tablePanduan tr td {
			border-bottom: 1px solid #f2f2f2;
		}

		/* #tableTipeTambahan tr td {
			padding: 4px;
		} */

		#content {
			margin: 15px;
			padding: 5px;
		}

		#tarif tr td {
			border: 1px solid #f2f2f2;
		}

		#generatePDF {
			margin: 20px 0;
		}
	</style>

</head>

<body>

	<!-- Latest compiled and minified JavaScript -->

	<table>
		<tr>
			<td width="50%">
				<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/CarRental.png'))) }}" style="width: 70%;" alt="Image">
			</td>
			<td width="50%">
				<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/apyrentacars.png'))) }}" style="width: 50%;" alt="Image">
			</td>
		</tr>
	</table>

	<div style="margin-bottom: 10px; margin-top: 50px">

		<div width="100%">No. Pesanan</div>
		<div  style="font-size: 60px; font-weight: bold; margin-bottom: 30px; margin-top: 30px">
			{{ $invoice }}
		</div>
	</div>
	<div style="border-left: 2px solid gold; margin-bottom: 30px; margin-top: 30px">
		<div class="bg-primary" style="font-weight: bold; padding: 20px">Tanpa Supir</div>
	</div>
	<table id="tableInfo" style="border: 1px solid #8e8e8e; margin-bottom: 8px;">
		<tr>
			<td colspan="2">
				<div style="font-size: 50px; font-weight: bold;">{{ $product_name }}</div>
			</td>
		</tr>
		<tr> 
			<td width="50%" >Kota/wilayah rental</td>
			<td width="50%" >{{ $wilayah }}</td>
		</tr>
		<tr>
			<td width="50%" >Durasi rental</td>
			<td width="50%" > {{ date("D, d F Y", strtotime($mulai)) }} - {{ date("D, d F Y", strtotime($akhir)) }}
			<br>{{ $durasi }} days</td>
		</tr>
		<tr>
			<td >Permintaan Khusus</td>
			<td></td>
		</tr>
		<tr>
			<td width="50%" >Detail Inventor</td>
			<td width="50%" >{{ date("D, d F Y", strtotime($mulai)) }} - Alokasi Reguler <br>
			{{ date("D, d F Y", strtotime($akhir)) }} - Alokasi Reguler</td>
		</tr>
	</table>


		<table style="margin-bottom: 10px;">
			<tr>
				<td colspan="2" >Detail Rental</td>
			</tr>
			<tr>
			</tr>
			<tr>
				<td style="font-weight: bold; " colspan="2">Detail Pengambilan</td>
			</tr>
			<tr>
				<td width="50%" >Tanggal & Waktu Pengambilan</td>
				<td width="50%" >{{ date("D, d F Y", strtotime($mulai)) }} •  {{$jam_mulai}} GMT+7</td>
			</tr>
		
		</table>
		
	
		<table style="margin-bottom: 10px;">
			<tr>
				<td colspan="2" style="font-weight: bold; ">Detail Selesai</td>
			</tr>
			<tr>
				<td width="50%" >Tanggal & Waktu Selesai </td>
				<td width="50%" > {{ date("D, d F Y", strtotime($akhir)) }}•  {{$jam_akhir}} GMT+7</td>
			</tr>
			
		</table>
	
	<table style="margin-bottom: 10px;">
		<tr>
			<td colspan="2" style="font-weight: bold; ">Detail Penyewa</td>
		</tr>
		<tr>
			<td width="50%" >Nama</td>
			<td width="50%" >{{$customer_name}}</td>
		</tr>
		<tr>
			<td width="50%" >No. Telepon</td>
			<td width="50%" >{{$customer_telpon}}</td>
		</tr>
	</table>

	<table style="margin-bottom: 10px; page-break-after: always;">
		<tr>
			<td colspan="2" style="font-weight: bold; ">Penyedia Rental</td>
		</tr>
		<tr>
			<td width="50%" >Nama Supplier</td>
			<td width="50%" >{{ $seller_name }}</td>
		</tr>
		<tr>
			<td width="50%" >No. Telepon</td>
			<td width="50%" > [{{ $seller_telpon }}]</td>
		</tr>
	</table>

	@if ($plat_nomer > 0)
	<table style="margin-bottom: 10px; page-break-after: always;">
		<tr>
			<td colspan="2" style="font-weight: bold; ">Detail</td>
		</tr>
		<tr>
			<td width="50%" >Series Mobil</td>
			<td width="50%" >{{ $product_name }}</td>
		</tr>
		<tr>
			<td width="50%" >Plat Nomer</td>
			<td width="50%" > [{{ $plat_nomer }}]</td>
		</tr>
	</table>
	@endif
	
	<table id="tarif" style="margin-bottom: 15px; page-break-after: always">
		<tr>
			<td style="border:none">
				<div style="font-weight: bold; ">Tarif</div>
			</td>
		</tr>
		<tr style="border-color: #FFC107;">
			<td style="text-align: left; font-weight: bold;  border-color: #FFC107;">Item</td>
			<td style="text-align: left; font-weight: bold;  border-color: #FFC107;">Jumlah</td>
			<td style="text-align: left; font-weight: bold;  border-color: #FFC107;">Harga/Durasi</td>
			<td style="text-align: left; font-weight: bold;  border-color: #FFC107;">Total</td>
		</tr>
		<tr>
			<td style=" border-color: #FFC107;">{{ $product_name }}</td>
			<td style=" border-color: #FFC107;">{{ $durasi }}</td>
			<td style=" border-color: #FFC107;">{{ formatUang($product_price) }}</td>
			<td style=" border-color: #FFC107;">{{ formatUang($product_price * $durasi) }}</td>
		</tr>
			
		<tr>
			<td style="border-color: #FFC107;"></td>
			<td style="border-color: #FFC107;"></td>
			<td style="border-color: #FFC107;"></td>
			<td style="font-weight: bold;  border-color: #FFC107;">{{ formatUang($price) }}</td>
		</tr>
	</table>

	<table id="tablePanduan page-break-after: always;">
		<tr>
			<td style="font-weight: bold; " colspan="2">Persyaratan Rental Tanpa Supir</td>
		</tr>
		<tr>
			<td width="10%">1</td>
			<td >SIM A/SIM Internasional.</td>
		</tr>
		<tr>
			<td width="10%">2</td>
			<td >Pengemudi harus membagikan kepada penyedia foto SIM A atau SIM Internasional mereka.</td>
		</tr>
		<tr>
			<td width="10%">3</td>
			<td >Foto Diri dengan KTP/Paspor.</td>
		</tr>
		<tr>
			<td width="10%">4</td>
			<td >Pengemudi harus membagikan kepada penyedia foto diri dengan KTP/paspor mereka.</td>
		</tr>
		<tr>
			<td width="10%">5</td>
			<td >E-KTP/paspor.
			</td>
		</tr>
		<tr>
			<td width="10%">6</td>
			<td >Pengemudi harus membagikan kepada penyedia foto e-KTP/paspor mereka.
			</td>
		</tr>
		<tr>
			<td width="10%" >7</td>
			<td >Others (if provider requires additional verification)
			Syarat tambahan seperti NPWP, kartu keluarga, dan/atau nama akun media sosial dapat diminta kepada pengemudi setelah pemesanan jika penyedia membutuhkan verifikasi tambahan.
			</td>
		</tr>
		<tr>
			<td width="10%">8</td>
			<td>Bersedia Di Survey.
			</td>
		</tr>
		
	</table>

	<!-- <table id="tableTipeTambahan">
		<tr>
			<td width="10%" >No</td>
			<td width="50%" >Tipe Tambahan</td>
			<td width="35%" >Harga/Durasi</td>
		</tr>
		<tr>
			<td >1</td>
			<td >Luar Kota Zona 1</td>
			<td >IDR 140.000 / Hari</td>
		</tr>
		<tr>
			<td >2</td>
			<td >Luar Kota Zona 2</td>
			<td >IDR 195.000 / Hari</td>
		</tr>
		<tr>
			<td >3</td>
			<td >Area 0 80KM and Drivers Meals</td>
			<td >IDR 225.000 / Hari</td>
		</tr>
		<tr>
			<td >4</td>
			<td >Area 0 165KM and Drivers Meals</td>
			<td >IDR 390.000 / Hari</td>
		</tr>
		<tr>
			<td >5</td>
			<td >All Inclusive</td>
			<td >IDR 300.000 / Hari</td>
		</tr>
		<tr>
			<td >6</td>
			<td >Akomodasi Sopir</td>
			<td >IDR 150.000 / Malam</td>
		</tr>
		<tr>
			<td >7</td>
			<td >Area 1 160KM and Drivers Meals</td>
			<td >IDR 380.000 / Hari</td>
		</tr>
		<tr>
			<td >8</td>
			<td >Jemput Luar Kota Zona 1</td>
			<td >IDR 225.000 / Pemakaian</td>
		</tr>
		<tr>
			<td >9</td>
			<td >Area 1 200KM and Drivers Meals</td>
			<td >IDR 460.000 / Hari</td>
		</tr>
		<tr>
			<td >10</td>
			<td >Jemput Luar Kota Zona 2 </td>
			<td >IDR 370.000 / Pemakaian</td>
		</tr>
		<tr>
			<td >11</td>
			<td >Area 1 245KM and Drivers Meals</td>
			<td >IDR 545.000 / Har</td>
		</tr>
		<tr>
			<td >12</td>
			<td >Overtime</td>
			<td >IDR 45.000 / Jam</td>
		</tr>
		<tr>
			<td >13</td>
			<td >Area 2 240KM and Drivers Meals</td>
			<td >IDR 530.000 / Hari</td>
		</tr>
		<tr>
			<td >14</td>
			<td >Antar Luar Kota Zona 1</td>
			<td >IDR 225.000 / Pemakaian</td>
		</tr>
		<tr>
			<td >15</td>
			<td >Area 2 280KM and Drivers Meals</td>
			<td >IDR 615.000 / Hari</td>
		</tr>
		<tr>
			<td >16</td>
			<td >Antar Luar Kota Zona 2</td>
			<td >IDR 370.000 / Pemakaian</td>
		</tr>
		<tr>
			<td >17</td>
			<td >Area 2 325KM and Drivers Meals</td>
			<td >IDR 700.000 / Hari</td>
		</tr>
		<tr>
			<td >18</td>
			<td >Area 1 140KM and Driver's Meals</td>
			<td >IDR 340.000 / Hari</td>
		</tr>
		<tr>
			<td >19</td>
			<td >Area 1 180KM and Driver's Meals</td>
			<td >IDR 420.000 / Hari</td>
		</tr>
		<tr>
			<td >20</td>
			<td >Area 2 195KM and Driver's Meals</td>
			<td >IDR 450.000 / Hari</td>
		</tr>
		<tr>
			<td >21</td>
			<td >Area 2 220KM and Driver's Meals </td>
			<td >IDR 495.000 / Hari</td>
		</tr>
		<tr>
			<td ></td>
			<td ></td>
			<td ></td>
		</tr>
		
		<tr style="background-color: #ebebeb;">
			<td colspan="3" style="text-align: center;">Apabila terdapat kendala dan pertanyaan terkait pemesanan, hubungi tim layanan kami.</td>
		</tr>
		<tr style="background-color: #ebebeb;">
			<td ></td>
			<td width="50%" >Customer Service</td>
			<td width="50%" >Email Customer Service</td>
		</tr>
		<tr style="background-color: #ebebeb;">
			<td ></td>
			<td width="50%" >+62816848835</td>
			<td width="50%" >apygroup2@gmail.com</td>
		</tr>
	</table> -->

	<!-- Latest compiled and minified JavaScript -->

</body>

</html>