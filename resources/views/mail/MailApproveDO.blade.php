<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
	<style type="text/css">
		table {
		  border-collapse: collapse;
		}

		table, th, td {
		  border: 0px solid grey;
		  padding-top: 14px;
		}

		table, th {
			padding-left: 15px;
		}

		#bg_ket {
			border-radius: 10px;
		}

		#bg_cuti {
			border-radius: 2px;
		}

		#txt_center {
			text-align: center;
		}

		.money:before{
			content:"Rp";
		}

		/*.centered{
			position: absolute;
		  	top: 50%;
		  	left: 50%;
		  	transform: translate(-50%, -40%);
		}*/

		.button {
			border: none;
			color: white;
			padding: 15px 32px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 4px 2px;
			cursor: pointer;
			background-color: #7868e6;
			border-radius: 4px;
		}
	</style>
</head>
<body style="width:600px;margin-left:auto;margin-right:auto;color: #000000">
	@if($details->status_kirim == 'PM')
		<div style="line-height: 1.5em">
			<center><img src="{{ asset('image/msplogin.png')}}" style="width: 50%; height: 50%;"></center>
		</div>
		<div style="line-height: 1.5em;padding-left: 13px;">
			<div style="font-family: 'Montserrat','Helvetica Neue',Helvetica,Arial,sans-serif;">
				<p>
					Hello Ferry Hartono,
				</p>
				<p>
					<br><b>Approval Delivery Order,</b> berikut rinciannya:
				</p>
				<div id="bg_ket" style="background-color: #ececec; padding: 10px">

					<center><b>{{$details->no_do}} - {{$details->to_agen}}</b></center>
					<table style="text-align: left;margin: 5px; font-size: 14px">
						<tr>
							<th>MSP Code</th>
							<th>Name</th>
							<th>Quantity</th>
							<th>Unit</th>
						</tr>
						@foreach($detail_barang as $data)
						<tr style="text-align: left; margin: 10px; font-size: 14px">
							<td>{{$data->kode_barang}}</td>
							<td>{{$data->nama}}</td>
							<td>{{$data->qty_transac}}</td>
							<td>{{$data->unit}}</td>
						</tr>
						@endforeach
					</table>
				</div>
				<p style="font-size: 16px">
					Silahkan klik link berikut ini untuk melihat Detail Delivery Order.<br>
				</p>
				<center><a href="{{url('/detail/do/msp/',$details->id_transaction)}}" target="_blank"><button class="button">Delivery Order</button></a></center>
				<p style="font-size: 16px">
					Mohon di periksa kembali, jika ada kesalahan atau pertanyaan silahkan hubungi Team Developer (Ext: 384) atau email ke development@sinergy.co.id.<br>
					Terima kasih.
				</p>
				<p style="font-size: 16px">
					Best Regard,
				</p><br>
				<p style="font-size: 16px">
					Tech - Dev
				</p>
			</div>
		</div>
	@elseif($details->status_kirim == 'pending')
		<div style="line-height: 1.5em">
			<center><img src="{{ asset('image/msplogin.png')}}" style="width: 50%; height: 50%;"></center>
		</div>
		<div style="line-height: 1.5em;padding-left: 13px;">
			<div style="font-family: 'Montserrat','Helvetica Neue',Helvetica,Arial,sans-serif;">
				<p>
					Hello Indra Lesmana,
				</p>
				<p>
					<br><b>Delivery Order telah disetujui,</b> berikut rinciannya:
				</p>
				<div id="bg_ket" style="background-color: #ececec; padding: 10px">

					<center><b>{{$details->no_do}} - {{$details->to_agen}}</b></center>
					<table style="text-align: left;margin: 5px; font-size: 14px">
						<tr>
							<th>MSP Code</th>
							<th>Name</th>
							<th>Quantity</th>
							<th>Unit</th>
						</tr>
						@foreach($detail_barang as $data)
						<tr style="text-align: left; margin: 10px; font-size: 14px">
							<td>{{$data->kode_barang}}</td>
							<td>{{$data->nama}}</td>
							<td>{{$data->qty_transac}}</td>
							<td>{{$data->unit}}</td>
						</tr>
						@endforeach
					</table>
				</div>
				<p style="font-size: 16px">
					Silahkan klik link berikut ini untuk melihat Detail Delivery Order.<br>
				</p>
				<center><a href="{{url('/detail/do/msp',$details->id_transaction)}}" target="_blank"><button class="button">Delivery Order</button></a></center>
				<p style="font-size: 16px">
					Mohon di periksa kembali, jika ada kesalahan atau pertanyaan silahkan hubungi Team Developer (Ext: 384) atau email ke development@sinergy.co.id.<br>
					Terima kasih.
				</p>
				<p style="font-size: 16px">
					Best Regard,
				</p><br>
				<p style="font-size: 16px">
					Tech - Dev
				</p>
			</div>
		</div>
	@endif
</body>
<footer style="display:block;width:600px;margin-left:auto;margin-right:auto;">
	<div style="background-color: #7868e6; padding: 20px; color: #ffffff; font-size: 12px; font-family: 'Montserrat','Helvetica Neue',Helvetica,Arial,sans-serif;">
		<p>
			<center>PT. Sinergy Informasi Pratama</center>
		</p>
		<p>
			<center>Jl. Puri Raya, Blok A 2/3 No. 33-35 Puri Indah, Kembangan, Jakarta, Indonesia 11610</center>
		</p>
		<p>
			<center><i class="fa fa-phone"></i>021 - 58355599</center>
		</p>
	</div>
</footer>
</html>