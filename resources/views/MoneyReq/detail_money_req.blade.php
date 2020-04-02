@extends('template.template_admin-lte')
@section('content')

<style type="text/css">
  input[type=number]::-webkit-inner-spin-button, 
  input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none; 
    margin: 0; 
  }

  .select2{
      width: 100%!important;
  }
</style>

<section class="content-header">
  <h1>
    Detail Money Request
  </h1><br>
  <a href="{{url('/money_req')}}"><button class="btn btn-danger pull-left" style="width: 200px"><i class="fa fa-arrow-circle-o-left"></i>&nbspback to Money Request</button></a> <p>&nbsp</p>
      <br>
  <ol class="breadcrumb">
    <li><a href="{{url('project')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class=""><a href="{{url('money_req')}}">Money Request</a></li>
    <li class="active">Detail</li>
  </ol>
</section>

<section>
  @if (session('update'))
    <div class="alert alert-warning" id="alert">
        {{ session('update') }}
    </div>
  @endif

  @if (session('success'))
    <div class="alert alert-primary" id="alert">
        {{ session('success') }}
    </div>
  @endif

  @if (session('alert'))
    <div class="alert alert-success" id="alert">
        {{ session('alert') }}
    </div>
  @endif
</section>

<section class="content">
    <div class="box">
      <div class="box-header">
        <h5>ID Project    &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: <i>{{$datas->id_project}}</i></h5>
        <h5>Project Name  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: <i>{{$datas->project_name}}</i></h5>
        <h5>Sales         &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: {{ $datas->name }}</i></h5>
        <h5>COGS   &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: Rp <i class="money">{{$datas->cogs}}</i></h5>
        <h5>COGS Akhir  &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp: Rp <i class="money">{{$datas->cogs_akhir}}</i></h5>
        <div class="pull-right">
        <!-- <button type="button" class="btn btn-sm btn-primary" data-target="#modalEditMoney" data-toggle="modal" onclick="detailmoneyreq('{{$datas->id_money_req}}')"><i class="fa fa-plus"> </i> &nbspEdit COGS </button> -->
          <button type="button" class="btn btn-sm btn-primary" data-target="#modalAddDetail" data-toggle="modal" onclick="detailmoneyreq('{{$datas->id_money_req}}', '{{$datas->cogs_akhir}}')"><i class="fa fa-plus"> </i> &nbspAdd Detail </button>
          <a class="" href="{{url('/export_pdf',$datas->id_money_req)}}"><button type="button" class="btn btn-sm btn-warning"><i class="fa fa-download"> </i> &nbspExport </button></a>
          <a class="hidden" href="{{url('/export_pdf2',$datas->id_money_req)}}"><button type="button" class="btn btn-sm btn-default"><i class="fa fa-download"> </i> &nbspExport </button></a>
          <a class="hidden" href="{{url('/export_pdf3',$datas->id_money_req)}}"><button type="button" class="btn btn-sm btn-default"><i class="fa fa-download"> </i> &nbspExport </button></a>
          <a class="hidden" href="{{url('/export1',$datas->id_money_req)}}"><button type="button" class="btn btn-sm btn-default"><i class="fa fa-download"> </i> &nbspExport </button></a>
          <a class="hidden" href="{{url('/export2',$datas->id_money_req)}}"><button type="button" class="btn btn-sm btn-default"><i class="fa fa-download"> </i> &nbspExport </button></a>
          <a class="hidden" href="{{url('/export3',$datas->id_money_req)}}"><button type="button" class="btn btn-sm btn-default"><i class="fa fa-download"> </i> &nbspExport </button></a>
          <a class="hidden" href="{{url('/export_uangsaku1',$datas->id_money_req)}}"><button type="button" class="btn btn-sm btn-default"><i class="fa fa-download"> </i> &nbspExport </button></a>
          <a class="hidden" href="{{url('/export_uangsaku2',$datas->id_money_req)}}"><button type="button" class="btn btn-sm btn-default"><i class="fa fa-download"> </i> &nbspExport </button></a>
          <a class="hidden" href="{{url('/export_uangsaku3',$datas->id_money_req)}}"><button type="button" class="btn btn-sm btn-default"><i class="fa fa-download"> </i> &nbspExport </button></a>
        </div>
      </div>

      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped dataTable" id="datastable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Date</th>
                <th>Type</th>
                <th>Total Transfer</th>
                <th>Tranfer to</th>
                <th>No Rek</th>
                <th>Note</th>
                <!-- <th>Action</th> -->
              </tr>
            </thead>
            <tbody>
              <?php $no = 1 ?>
              @foreach($data as $tampilmoney)
                @if($tampilmoney->tipe != null)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $tampilmoney->date }}</td>
                    <td>{{ $tampilmoney->tipe }}</td>
                    <td class="money">{{ $tampilmoney->total_tf}}</td>
                    <td>{{ $tampilmoney->nama }}</td>
                    <td>{{ $tampilmoney->transfer }}</td>
                    <td>{{ $tampilmoney->note }}</td>
                  </tr>
                  @else
                @endif
              
              @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!--MODAL EDIT-->
	<div class="modal fade" id="modalEditMoney" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content modal-md">
        <div class="modal-header">
          <center><h3 class="modal-title"><b>Edit Money Request</b></h3></center>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('/changelog_money_req')}}" id="modalEditMoney" name="modalEditMoney">
            @csrf

            <div class="form-group">
              <label>ID Project</label>
              <input type="form-control" id="edit_id_money" name="edit_id_money" readonly>
            </div>
            
            <div class="form-group">
              <label>ID Project</label>
              <input type="form-control" name="edit_id_project" id="edit_id_project" readonly>
            </div>

            <div class="form-group">
              <label>Project Name</label>
              <input type="form-control" name="edit_project_name" id="edit_project_name" readonly>
            </div>

            <div class="form-group">
              <label>Cogs</label>
              <input type="form-control" class="form-control" id="update_cogs" name="update_cogs" required>
            </div>

            <div class="form-group">
              <label>Note</label>
              <textarea class="form-control" id="edit_cogs_note" name="edit_cogs_note" required></textarea>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
              <button type="submit" class="btn btn-success"><i class="fa fa-check"> </i>&nbspUpdate</button>
            </div>
        </form>
        </div>
      </div>
    </div>
  </div>    


  <!--MODAL ADD-->
    <div class="modal fade" id="modalAddDetail" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <center><h3 class="modal-title"><b>Add Detail</b></h3></center>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ url('/changelog_money_req')}}" id="modalAddDetail" name="modalAddDetail">
            @csrf

            <div class="hidden">
                <label></label>
                <input type="text" class="form-control" id="id_money_req" name="id_money_req" hidden>
            </div>

            <div class="form-group">
                <label>Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>

            <div class="form-group">
                <label>Tipe</label>
                <select class="form-control" id="tipe" name="tipe" required>
                  <option value="Gaji">Gaji</option>
                  <option value="Transportasi">Transportasi</option>
                  <option value="Akomodasi">Akomodasi</option>
                  <option value="Pulsa">Pulsa</option>
                  <option value="Over Bagasi">Biaya over bagasi</option>
                </select>
            </div>

            <table class="table">
              <tr>
                <th>Nama</th>
                <th>Total Transfer</th>
                <th>No Rek</th>
                <th><a href="javascript:void(0);" style="font-size:18px" id="addMoreYa"><span class="fa fa-plus"></span></a></th>
              </tr>
              <tbody id="product-add">
              <tr>
                <td>
                  <select class="form-control" id="nama" name="nama[]">
                    <option value="Budi Rahmad Sidiq">Budi Rahmad Sidiq</option>
                    <option value="Riyan Jati Diri">Riyan Jati Diri</option>
                    <option value="Priyono">Priyono</option>
                    <option value="Pujianto">Pujianto</option>
                    <option value="Sumitra">Sumitra</option>
                    <option value="Tarsono Nano">Tarsono Nano</option>
                    <option value="Darman">Darman</option>
                    <option value="Karyanto">Karyanto</option>
                    <option value="Kusnadi">Kusnadi</option>
                    <option value="Agung Supriyanto">Agung Supriyanto</option>
                    <option value="Khakim Mubarok">Khakim Mubarok</option>
                    <option value="Dwi Haryanto">Dwi Haryanto</option>
                    <option value="Cipto">Cipto</option>
                    <option value="Casdulah">Casdulah</option>
                    <option value="Arif Purnomo">Arif Purnomo</option>
                    <option value="Castro">Castro</option>
                    <option value="Ahmad Jaelani">Ahmad Jaelani</option>
                    <option value="Rinto">Rinto</option>
                    <option value="Sukamto">Sukamto</option>
                    <option value="Giyanto">Giyanto</option>
                    <option value="Sarifudin">Sarifudin</option>
                    <option value="Rusli">Rusli</option>
                    <option value="Joni Iskandar">Joni Iskandar</option>
                    <option value="Suwarno">Suwarno</option>
                    <option value="Surnanto">Surnanto</option>
                    <option value="Herman">Herman</option>
                    <option value="Panca Budi Santoso">Panca Budi Santoso</option>
                    <option value="Nir SUgeng">Nir Sugeng</option>
                    <option value="Mujiono">Mujiono</option>
                    <option value="Rudiyanto">Rudiyanto</option>
                    <option value="Farid Noor Afandi">Farid Noor Afandi</option>
                    <option value="Moh. Amin">Moh. Amin</option>
                    <option value="Mulyanto">Mulyanto</option>
                    <option value="Yusak Sharon">Yusak Sharon</option>
                    <option value="Basuki">Basuki</option>
                    <option value="Roendi">Roendi</option>
                    <option value="Feroza Anggita Rosyidin">Feroza Anggita Rosyidin</option>
                    <option value="Indarto">Indarto</option>
                    <option value="M. Sobirin">M. Sobirin</option>
                    <option value="Nurcahya">Nurcahya</option>
                    <option value="Surtaka">Surtaka</option>
                    <option value="Edi Prasetyo">Edi Prasetyo</option>
                    <option value="Mulyanto 2">Mulyanto</option>
                    <option value="Yudi Santoso">Yudi Santoso</option>
                    <option value="Acep">Acep</option>
                    <option value="Edvan Chandra">Edvan Chandra</option>
                    <option value="Alwi">Alwi</option>
                  </select>
                </td>
                <td><input type="text" name="total_transfer[]" id="total_transfer" class="form-control total_transfer money" data-rowid="0"></td>
                <td>
                  <select class="form-control" id="transfer" name="transfer[]">
                    <option value="7540050648">7540050648</option>
                    <option value="123">123</option>
                    <option value="7540999800">7540999800</option>
                    <option value="7540341952">7540341952</option>
                    <option value="7540405748">7540405748</option>
                    <option value="7540412957">7540412957</option>
                    <option value="3020425848">3020425848</option>
                    <option value="7540404261">7540404261</option>
                    <option value="7540412060">7540412060</option>
                    <option value="2881374716">2881374716</option>
                    <option value="7540364014">7540364014</option>
                    <option value="3011332488">3011332488</option>
                    <option value="2881423962">2881423962</option>
                    <option value="7540544721">7540544721</option>
                    <option value="7540365801">7540365801</option>
                    <option value="3020569092">3020569092</option>
                    <option value="7560248223">7560248223</option>
                    <option value="124">124</option>
                    <option value="7540361767">7540361767</option>
                    <option value="125">125</option>
                    <option value="0970598511">0970598511</option>
                    <option value="126">126</option>
                    <option value="127">127</option>
                    <option value="128">128</option>
                    <option value="129">129</option>
                    <option value="7540010379">7540010379</option>
                    <option value="4361415781">4361415781</option>
                    <option value="130">130</option>
                    <option value="7540047221">7540047221</option>
                    <option value="7540464191">7540464191</option>
                    <option value="8640291738">8640291738</option>
                    <option value="131">131</option>
                    <option value="132">132</option>
                    <option value="6560123963">6560123963</option>
                    <option value="0671375369">0671375369</option>
                    <option value="3020554354">3020554354</option>
                    <option value="4451645883">4451645883</option>
                    <option value="133">132</option>
                    <option value="134">134</option>
                    <option value="3020580665">3020580665</option>
                    <option value="135">135</option>
                    <option value="136">136</option>
                    <option value="7540341952">7540341952</option>
                    <option value="7540238663">7540238663</option>
                    <option value="137">137</option>
                    <option value="2881760420">2881760420</option>
                    <option value="5440091557">5440091557</option>
                  </select>
                </td>
                <td><a href='javascript:void(0);'  class='remove'><span class='fa fa-times' style="font-size: 18px;color: red"></span></a></td>
              </tr>
              </tbody>
            </table>

            <div>
              <label>Note</label>
              <textarea name="note" id="note" class="form-control" required></textarea>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"> </i>&nbspSubmit</button>
            </div>
        </form>
        </div>
      </div>
    </div>
  </div>

  <!-- MODAL EDIT COGS -->
  <!-- <div class="modal fade" id="modalEditMoney" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content modal-md">
        <div class="modal-header">
          <center><h3 class="modal-title"><b>Edit COGS</b></h3></center>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ url('/update_money_req') }}" id="modalEditMoney" name="modalEditMoney">
            @csrf

            <input type="text" id="edit_id_money_req" name="edit_id_money_req" hidden>

            <div class="form-group">
                <label>Cogs</label>
                <input type="form-control" class="form-control" id="edit_cogs" name="edit_cogs" required>
            </div>

            <div class="form-group">
            	<label>Note</label>
            	<textarea name="edit_note" id="edit_note" class="form-control" required></textarea>
            </div>

            <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"> </i>&nbspSubmit</button>
            </div>
        </form>
        </div>
      </div>
    </div>
  </div> -->
</section>

@endsection
@section('script')
<script type="text/javascript" src="{{asset('js/jquery.mask.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
<script type="text/javascript">
   $('.money').mask('000,000,000,000,000', {reverse: true});

   function initmaskmoney()
   {
    $('.money').mask('000,000,000,000,000', {reverse: true});
   }

   	function detailmoneyreq(id_money_req,cogs_akhir) {
    	$('#id_money_req').val(id_money_req);
      $('#total_cogs').val(cogs_akhir);
   	}

   	function editmoney(id_money_req,cogs,id_project,project_name,cogs_note) {
      $('#edit_id_money').val(id_money_req);
      $('#update_cogs').val(cogs);
      $('#edit_project_name').val(project_name);
      $('#edit_id_project').val(id_project);
      $('#')
    }
   	// function editcogs(id_money_req,cogs,note){
    // 	$('#edit_id_money_req').val(id_money_req);
    // 	$('#edit_cogs').val(id_money_req);
    // 	$('#edit_note').val(id_money_req);
    // }

    var i = 1;
    $('#addMoreYa').click(function(){  
       i++;  
       $('#product-add').append('<tr id="row'+i+'"><td><select type="text" name="nama[]" id="nama" class="form-control" data-rowid="'+i+'"><option value="Budi Rahmad Sidiq">Budi Rahmad Sidiq</option><option value="Riyan Jati Diri">Riyan Jati Diri</option><option value="Priyono">Priyono</option><option value="Pujianto">Pujianto</option><option value="Sumitra">Sumitra</option><option value="Tarsono Nano">Tarsono Nano</option><option value="Darman">Darman</option><option value="Karyanto">Karyanto</option><option value="Kusnadi">Kusnadi</option><option value="Agung Supriyanto">Agung Supriyanto</option><option value="Khakim Mubarok">Khakim Mubarok</option><option value="Dwi Haryanto">Dwi Haryanto</option><option value="Cipto">Cipto</option><option value="Casdulah">Casdulah</option><option value="Arif Purnomo">Arif Purnomo</option><option value="Castro">Castro</option><option value="Ahmad Jaelani">Ahmad Jaelani</option><option value="Rinto">Rinto</option><option value="Sukamto">Sukamto</option><option value="Giyanto">Giyanto</option><option value="Sarifudin">Sarifudin</option><option value="Rusli">Rusli</option><option value="Joni Iskandar">Joni Iskandar</option><option value="Suwarno">Suwarno</option><option value="Surnanto">Surnanto</option><option value="Herman">Herman</option><option value="Panca Budi Santoso">Panca Budi Santoso</option><option value="Nir SUgeng">Nir Sugeng</option><option value="Mujiono">Mujiono</option><option value="Rudiyanto">Rudiyanto</option><option value="Farid Noor Afandi">Farid Noor Afandi</option><option value="Moh. Amin">Moh. Amin</option><option value="Mulyanto">Mulyanto</option><option value="Yusak Sharon">Yusak Sharon</option><option value="Basuki">Basuki</option><option value="Roendi">Roendi</option><option value="Feroza Anggita Rosyidin">Feroza Anggita Rosyidin</option><option value="Indarto">Indarto</option><option value="M. Sobirin">M. Sobirin</option><option value="Nurcahya">Nurcahya</option><option value="Surtaka">Surtaka</option><option value="Edi Prasetyo">Edi Prasetyo</option><option value="Mulyanto 2">Mulyanto</option><option value="Yudi Santoso">Yudi Santoso</option><option value="Acep">Acep</option><option value="Edvan Chandra">Edvan Chandra</option><option value="Alwi">Alwi</option></td><td><input type="text" name="total_transfer[]" id="total_transfer" class="form-control total_transfer money" data-rowid="'+i+'"></td>  <td><select type="text" name="transfer[]" id="transfer" class="form-control" data-rowid="'+i+'"><option value="7540050648">7540050648</option><option value="123">123</option><option value="7540999800">7540999800</option><option value="7540341952">7540341952</option><option value="7540405748">7540405748</option><option value="7540412957">7540412957</option><option value="3020425848">3020425848</option><option value="7540404261">7540404261</option><option value="7540412060">7540412060</option><option value="2881374716">2881374716</option><option value="7540364014">7540364014</option><option value="3011332488">3011332488</option><option value="2881423962">2881423962</option><option value="7540544721">7540544721</option><option value="7540365801">7540365801</option><option value="3020569092">3020569092</option><option value="7560248223">7560248223</option><option value="124">124</option><option value="7540361767">7540361767</option><option value="125">125</option><option value="0970598511">0970598511</option><option value="126">126</option><option value="127">127</option><option value="128">128</option><option value="129">129</option><option value="7540010379">7540010379</option><option value="4361415781">4361415781</option><option value="130">130</option><option value="7540047221">7540047221</option><option value="7540464191">7540464191</option><option value="8640291738">8640291738</option><option value="131">131</option><option value="132">132</option><option value="6560123963">6560123963</option><option value="0671375369">0671375369</option><option value="3020554354">3020554354</option><option value="4451645883">4451645883</option><option value="133">132</option><option value="134">134</option><option value="3020580665">3020580665</option><option value="135">135</option><option value="136">136</option><option value="7540341952">7540341952</option><option value="7540238663">7540238663</option><option value="137">137</option><option value="2881760420">2881760420</option><option value="5440091557">5440091557</option></td><td><a href="javascript:void(0);" id="'+i+'"class="remove"><span class="fa fa-times" style="font-size: 18px;color:red;"></span></a></td></tr>');
       initmaskmoney();
    });

    $(document).on("change", ".total_transfer", function() {
    var rowid = $(this).attr("data-rowid");
    var sum = 0;
    var total = $(this).val().replace(/,/g , "");
    $(".total_transfer").each(function(){
        sum += parseFloat($(this).val().replace(/\,/g,'') || 0);
    });
    $(".total_tf").val(sum);
    });

    $(document).on('click', '.remove', function() {
       var trIndex = $(this).closest("tr").index();
          if(trIndex > 0) {
           $(this).closest("tr").remove();
         } else {
           alert("Sorry!! Can't remove first row!");
         }
    });
</script>
@endsection