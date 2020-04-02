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
  .alignleft {
    float: left;
  }
  .alignright {
    float: right;
  }
	</style>
  <link rel="stylesheet" href="">
	<title>MONEY REQUEST</title>
</head>
<body>
  <div class="row">
    <h3 style="text-align: center;">Money Request</h3>
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
              <th>No.</th>
              <th>Keterangan</th>
              <th>Qty</th>
              <th>Unit Price</th>
              <th>Budgeting /
              COGS</th>
              <th>Total Uang Muka
              (Normal / Urgent)</th>
              <th>Actual Cost
              (Settlement)</th>
              <th>Sisa</th>
            </tr>
        </thead>
        <tbody>
            <tr>
              <td></td>
              <td>COGS</td>
              <td></td>
              <td></td>
              <td>{{$datal->cogs}}</td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td></td>
              <td>Gaji</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
        <?php $no = 1 ?>
        @foreach($datas as $data)
            <tr>
              <td>{{$no++}}</td>
              <td>{{$data->nama}}</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <tr>
              <th></th>
              <td>Lain - Lain</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
           </tr>
           <tr>
              <td></td> 
              <td>{{$data->tipe}}</td>
              <td></td>
              <td>{{$data->total_tf}}</td>
              <td></td>
              <td></td>
              <td>{{$data->total_tf}}</td>
              <td></td>
           </tr>
           <tr>
              <td></td> 
              <td>Total Biaya</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
           </tr>
           <tr>
              <td></td> 
              <td>TOTAL</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
           </tr>
           <?php $no = 1 ?>
           <tr>
              <td>{{$no++}}</td> 
              <td>{{$data->nama}}</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
           </tr>
           <tr>
              <td></td> 
              <td>Total Biaya</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
           </tr>
           <tr>
              <td></td> 
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
           </tr>
        </tfoot>
      </table><br>
      
      </div>
      </div>
      
</body>
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
</html>
