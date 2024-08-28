<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Apy Rent A Car</title>
</head>
<body bgcolor="#0f3462" style="margin-top:20px;margin-bottom:20px">
  <!-- Main table -->
  <table border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="white" width="650">
  <tbody>
		<tr>
			<td valign="top" colspan="12" width="100.0%" class=" column" style="-webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; mso-table-lspace:0pt; mso-table-rspace:0pt; width:100.0%; text-align:left; padding:0; font-family:'Helvetica Neue', Helvetica, Arial, sans-serif; font-size:16px; line-height:1.5em; color:#000000" align="left">

				<div class="widget-span widget-type-custom_widget " style="" data-widget-type="custom_widget">
					<div class="layout-widget-wrapper">
						<div id="hs_cos_wrapper_module_150964864725218" class="hs_cos_wrapper hs_cos_wrapper_widget hs_cos_wrapper_type_custom_widget" style="color: inherit; font-size: inherit; line-height: inherit;" data-hs-cos-general-type="widget" data-hs-cos-type="custom_widget">
							<table style="-webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; mso-table-lspace:0pt; mso-table-rspace:0pt; border-collapse:collapse !important; background-color:rgba(0, 0, 0, 0.03); width:100%" bgcolor="rgba(0, 0, 0, 0.03)">
								<tbody>
									<tr class="cpi-template-header" style="min-height: 70px;">
										<td >
											<div>
												<a href="">
													<img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/apyrentacars.png'))) }}" style="max-width:150px">
												</a>
											</div>
										</td>
										<td class="cpi-template-title" style="-webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; mso-table-lspace:0pt; mso-table-rspace:0pt; padding:10px 20px 10px 0; color:#000; text-align:right" align="right">
											<div id="hs_cos_wrapper_module_150964864725218_simple_text_field" class="hs_cos_wrapper hs_cos_wrapper_widget hs_cos_wrapper_type_text" style="color: inherit; font-size: inherit; line-height: inherit;" data-hs-cos-general-type="widget" data-hs-cos-type="text">
												Rental Mobil
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
						<!--end layout-widget-wrapper -->
				</div>
						<!--end widget-span -->
			</td>
    	</tr>
    	</tbody>
    <tr>
      <td>
        <!-- Child table -->
		<table border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="white" width="650">
		<!-- <tr>
            <td>
              <h2 style="text-align:center; margin: 0px; padding-bottom: 25px; margin-top: 25px;">
                <i>Company</i><span style="color:lightcoral">Name</span></h2>
            </td>
          </tr>
          <tr>
            <td>
              <img src="" height="50px" style="display:block; margin:auto;padding-bottom: 25px; ">
            </td>
          </tr> -->
          <tr>
            <td style="text-align: left;">
              <h4 style="margin: 0px 30px; padding-bottom: 5px; padding-top: 40px;">Anda dapat pesanan baru!</h4>
              <h5 style="margin: 0px 30px; padding-bottom: 25px; padding-top: 5px;">No. Pesanan: {{ $invoice }}</h5>
              <p style=" margin: 0px 30px; padding-bottom: 5px; line-height: 2; font-size: 15px;">Dear {{ $seller_name }}.
              </p>
              <p style=" margin: 0px 30px; padding-bottom: 15px; line-height: 2; font-size: 15px;">Terima kasih telah memilih Apy Rent A Car sebagai mitra Anda. Pesanan yang Anda dapatkan adalah rental mobil tanpa sopir. Berikut adalah detail pesanan Anda:.
              </p>
              <h2 style="margin: 0px 30px; padding-bottom: 25px; line-height: 2; font-size: 15px;">Mohon untuk menghubungi penumpang 24 – 48 jam sebelum waktu jemput.</h2>
            </td>
          </tr>
         
        </table>

		<table style="border: 1px solid #8e8e8e; margin: 20px;">
			<tr>
				<td colspan="2">
					<div style="font-size: 16px; padding-bottom: 5px; padding-left: 30px; padding-top: 30px;">Detail Pesanan</div>
					<div style="font-size: 24px; font-weight: bold; padding-bottom: 10px; padding-right: 30px; padding-left: 30px; padding-top: 5px;">{{ $product_name }}</div>
					<div style="font-size: 20px; font-weight: bold; padding-bottom: 10px; padding-right: 30px; padding-left: 30px; padding-top: 5px; background: rgba(0, 0, 0, 0.03);">Tanpa Supir</div>
				</td>
			</tr>
			<tr style="background: rgba(0, 0, 0, 0.03);">
				<td width="50%" style="font-size: 20px; padding-bottom: 10px; padding-left: 30px; padding-top: 5px; padding-right: 30px;">Kota/wilayah rental</td>
				<td width="50%" style="font-size: 20px; padding-bottom: 10px; padding-left: 30px; padding-top: 5px; padding-right: 30px;">{{ $wilayah }}</td>
			</tr>
			<tr>
				<td width="50%" style="font-size: 20px; padding-bottom: 10px; padding-left: 30px; padding-top: 5px; padding-right: 30px;">Durasi rental</td>
				<td width="50%" style="font-size: 20px;padding-bottom: 10px; padding-left: 30px; padding-top: 5px; padding-right: 30px;"> {{ date("D, d F Y", strtotime($mulai)) }} - {{ date("D, d F Y", strtotime($akhir)) }}
				<br>{{ $durasi }} days</td>
			</tr>
			
		</table>
		
		<table style="margin-bottom: 20px; margin-top: 10px; margin-left: 20px; margin-right: 20px;">

				<tr>
					<td colspan="2">
						<div style="font-size: 15px; padding-bottom: 5px; padding-left: 30px; padding-top: 10px;">Detail Rental</div>
						<div style="font-size: 20px; font-weight: bold; padding-bottom: 10px; padding-left: 30px; padding-top: 5px;">Detail Pengambilan </div>
					</td>
				</tr>
				<tr style="background: rgba(0, 0, 0, 0.03);">
					<td width="50%" style="font-size: 18px; padding-bottom: 10px; padding-left: 30px; padding-top: 5px;">Tanggal & Waktu Pengambilan</td>
					<td width="50%" style="font-size: 18px; padding-bottom: 10px; padding-left: 30px; padding-top: 5px;">{{ date("D, d F Y", strtotime($mulai)) }} •  {{$jam_mulai}} GMT+7</td>
				</tr>
				
			
				<tr>
					<td colspan="2">
						<!-- <div style="font-size: 18px; padding-bottom: 5px; padding-left: 30px; padding-top: 30px;">Detail Rental</div> -->
						<div style="font-size: 20px; font-weight: bold; padding-bottom: 10px; padding-left: 30px; padding-top: 5px;">Detail Selesai</div>
					</td>
				</tr>
				<tr style="background: rgba(0, 0, 0, 0.03);">
					<td width="50%" style="font-size: 18px; padding-bottom: 10px; padding-left: 30px; padding-top: 5px;">Tanggal & Waktu Selesai</td>
					<td width="50%" style="font-size: 18px; padding-bottom: 10px; padding-left: 30px; padding-top: 5px;">{{ date("D, d F Y", strtotime($akhir)) }} •  {{$jam_akhir}} GMT+7</td>
				</tr>
				
			
		</table>
		<h4 style="margin: 0px 20px; padding-bottom: 5px; padding-top: 10px;">Kontak Pemesan </h4>

		<table style="border: 1px solid #8e8e8e; margin: 20px;">
			<tr style="background: rgba(0, 0, 0, 0.03);">
				<td width="50%" style="font-size: 20px; padding-bottom: 10px; padding-left: 30px; padding-top: 5px; padding-right: 30px;">Nama pemesan</td>
				<td width="50%" style="font-size: 20px; padding-bottom: 10px; padding-left: 30px; padding-top: 5px; padding-right: 30px;">{{$customer_name}}</td>
			</tr>
			<tr>
				<td width="50%" style="font-size: 20px; padding-bottom: 10px; padding-left: 30px; padding-top: 5px; padding-right: 30px;">No. Handphone</td>
				<td width="50%" style="font-size: 20px;padding-bottom: 10px; padding-left: 30px; padding-top: 5px; padding-right: 30px;">{{$customer_telpon}}</td>
			</tr>
			<tr style="background: rgba(0, 0, 0, 0.03);">
				<td width="50%" style="font-size: 20px; padding-bottom: 10px; padding-left: 30px; padding-top: 5px; padding-right: 30px;">Email</td>
				<td width="50%" style="font-size: 20px;padding-bottom: 10px; padding-left: 30px; padding-top: 5px; padding-right: 30px;">{{$customer_email}}</td>
			</tr>
			
		</table>
		<table border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="white" width="650">
		<tr>
            <td style="text-align:center;">
				<h2 style="padding-top: 25px; line-height: 1; margin:0px;">Klik tautan di bawah ini untuk konfirmasi pesanan anda :</h2>
            </td>
          </tr>
		<tr>
            <td>
              <a href="{{ route('mtanpasopir') }}"  style="background-color:#36b445; color:white; padding:15px 97px; outline: none; display: block; margin: auto; border-radius: 31px;
                font-weight: bold; margin-top: 25px; margin-bottom: 25px; border: none; text-align: center; ">Konfirmasi Pesanan</a>
            </td>
          </tr>
		  <tr>
            <td style="text-align: left;">
              <p style=" margin: 0px 30px; padding-bottom: 5px; line-height: 2; font-size: 15px;">Halo {{ $seller_name }}.
              </p>
              <p style=" margin: 0px 30px; padding-bottom: 15px; line-height: 2; font-size: 15px;">Detail lainnya, seperti lokasi dan waktu jemput, tambahan, dan permintaan khusus, dapat Anda temukan pada PDF yang terlampir di email ini dan di Dashboard (Auto Rental Integrated Extranet System).
              </p>
              <h2 style="margin: 0px 30px; padding-bottom: 25px; line-height: 2; font-size: 15px;"> Terima kasih atas kerja samanya.</h2>
			  <h2 style="margin: 0px 30px; padding-bottom: 25px; line-height: 2; font-size: 15px;"> Salam, Apy Rent A Car.</h2>
            </td>
          </tr>
          <tr>
            <td style="text-align:center;">
              <h2 style="padding-top: 25px; line-height: 1; margin:0px;">Need Help?</h2>
              <div style="margin-bottom: 25px; font-size: 15px;margin-top:7px;">Hubungi : APY Rent A Car di (021) 837 92927 / (021) 8354565 atau melalui whatsapp 08111047992
              </div>
            </td>
          </tr>
		</table>
        <!-- /Child table -->
      </td>
    </tr>
  </table>
  <!-- / Main table -->
</body>

</html>