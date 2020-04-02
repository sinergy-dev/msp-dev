<!DOCTYPE html>
<html>
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<style type="text/css">
    table, th, td {
  		border: 1px solid black;
  		font-family: calibri;
  		font-size: 13px;
  		padding: 8px;
	}
	table {
		border-collapse: collapse;
		width: 100%;
    border-color: white;
	}
	p {
		font-family: calibri;
		font-size: 13px;
	}
	h3 {
		font-family: calibri;
		font-size: 30px;
	}
	h5 {
		font-family: calibri;
	}
	</style>

  <link rel="stylesheet" href="">
	<title>DATA TRANSFER</title>
</head>
<body>
  <div class="row">

    <h3 style="text-align: center;">BERITA ACARA SEMENTARA</h3>
    <h3 style="text-align: center;">(MINGGUAN)</h3>
    <div style="float: right;">
    <img src="/img/logomsp.jpg" style="width:140px;height:60px;"></img>
    <h5 style="padding-left: 15px">Tanggal : {{$datasatu->date}}</h5>
    </div>
  </div>
  <div class="row">
  <br>
  <p>
  Nama Project : {{$datal->project_name}}<br>
  Project ID : {{$datal->id_project}}<br>
  Alamat :<br>
  Mulai :<br>
  Selesai :<br>
  Jumlah Node :<br>
  PO/Surat Tugas/RO by Email :
  </p>
	<table id="pseudo-demo" class="page">
        <thead>
        	<tr>
            	<th>NO.</th>
            	<th>Nama Tukang</th>
            	<th></th>
              	<th colspan="7">Absensi (Gaji + Uang Makan + Akomodasi) Pekerjaan Instalasi Tanggal</th>
              	<th></th>
              	<th></th>
              	<th></th>
              	<th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1 ?>
        @foreach($datas as $data)
            <tr>
             	<td>{{$no++}}</td>
             	<td>{{$data->nama}}</td>
             	<td></td>
             	<td>{{$data->date}}</td>
             	<td>{{$data->date}}</td>
             	<td>{{$data->date}}</td>
             	<td>{{$data->date}}</td>
             	<td>{{$data->date}}</td>
             	<td>{{$data->date}}</td>
             	<td>{{$data->date}}</td>
             	<td>{{$data->date}}</td>
             	<td></td>
             	<td></td>
             	<td></td>
            </tr>
          @endforeach
        </tbody>
    </table><br>
    <footer>
      <table class="tablew" style="border: 0px;">
    <tbody>
      <tr>
        <td style="text-align: left; padding-left: 105px; border: none; font-size: 13px;">
          Approval,
        </td>
        <td style="text-align: right; padding-right: 100px; border: none; font-size: 13px;">
          Mengetahui, 
        </td>
      </tr>
      <tr>
        <td style="border: none;"></td>
        <td style="border: none;"></td>
      </tr>
      <tr>
        <td style="border: none;"></td>
        <td style="border: none;"></td>
      </tr>
      <tr>
        <td style="border: none;"></td>
        <td style="border: none;"></td>
      </tr>
      <tr>
        <td style="text-align: left; padding-left: 25px; border: none; font-size: 13px;">
        <b>Dwi / Sinung &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Edvan / Fuad / Lucas</b></td>
        <td style="text-align: right; padding-right: 45px; border: none; font-size: 13px;">
        <b> Ferry Hartono &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Diandra
        </b></td>
      </tr>
      <tr>
        <td style="text-align: left; padding-left: 25px; border: none; font-size: 12px;">
          Kepala Teknisi &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Project Manager
        </td>
        <td style="text-align: right; padding-right: 25px; border: none; font-size: 12px;">
          Direktur Operasional &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp Finance Division
        </td>
      </tr>
    </tbody>
  </table>
    </footer>

    @section('script')
	<script type="text/javascript" src="{{asset('js/jquery.mask.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
	<script type="text/javascript">
   		$('.money').mask('000,000,000,000,000', {reverse: true});

   	function initmaskmoney()
   	{
    	$('.money').mask('000,000,000,000,000', {reverse: true});
   	}
</script>
@endsection
</html>