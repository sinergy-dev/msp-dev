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
    <h3 style="text-align: center;">Data Transfer</h3>
    <div style="float: right;">
    <img src="/img/logomsp.jpg" style="width:140px;height:60px;"></img>
    <h5 style="padding-left: 15px">Tanggal :{{$datasatu->date}}</h5>
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
              <th>No</th>
              <th>Nama Tukang</th>
                <th>No. AC</th>
                <th>Bank</th>
                <th>Atas Nama</th>
                <th>Nilai yang ditransfer</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1 ?>
        @foreach($datas as $data)
            <tr>
              <td style="text-align: center;">{{$no++}}</td>
              <td>{{$data->nama}}</td>
              <td><b>6240785518</b></td>
              <td><b>BCA</b></td>
              <td><b>Edi Kusmana</b></td>
              <td><b><i class="money" style="text-align: right;">Rp{{$data->total_tf}}</i></b></td>
            </tr>
          @endforeach
        </tbody>
        <tfoot>
            <tr>
              <th colspan="5">TOTAL TRANSFER</th>
              <td></td>
           </tr>
        </tfoot>
    </table>

  </div>
 
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