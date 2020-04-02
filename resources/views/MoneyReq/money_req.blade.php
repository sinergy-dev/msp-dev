@extends('template.template_admin-lte')
@section('content')

  <section class="content-header">
    <h1>
      Money Request
    </h1>
    <ol class="breadcrumb">
      <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Money Request</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header">
        <div class="pull-right">
          <button type="button" class="btn btn-sm btn-primary" style="width: 150px" data-target="#modalAddIncident" data-toggle="modal"><i class="fa fa-plus"> </i> &nbspMoney request </button>
        </div>
      </div>

      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped dataTable" id="datastable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>ID Project</th>
                <th>Project Name</th>
                <th>COGS</th>
                <th>Sales Name</th>
                <th>Note</th>
                <th>Detail</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1 ?>
              @foreach($datas as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $data->id_project }}</td>
                <td>{{ $data->project_name }}</td>
                <td><i class="money">{{ $data->cogs}}</i></td>
                <td>{{ $data->name }}</td>
                <td>{{ $data->cogs_note }}</td>
                <td><a href="{{ url('detail_money_req',$data->id_money_req) }}"><button class="btn btn-sm btn-primary">Detail</button></a></td>
                <td>
                  <button class="btn btn-sm btn-warning" data-target="#modalEditMoney" data-toggle="modal" onclick="moneyreq('{{$data->id_money_req}}','{{$data->id_project}}','{{$data->project_name}}','{{$data->cogs}}','{{$data->cogs_note}}')">Edit</button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="box"><br>
    <center><h4 class="modal-title"><b>Changelog</b></h4></center>
    <div class="box-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped dataTable" id="datastable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>ID Project</th>
                <th>Project Name</th>
                <th>COGS Awal</th>
                <th>Update COGS</th>
                <th>Sales Name</th>
                <th>Note</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1 ?>
              @foreach($datas as $data)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $data->id_project }}</td>
                <td>{{ $data->project_name }}</td>
                <td><i class="money">{{ $data->cogs }}</i></td>
                <td><i class="money">{{ $data->cogs_akhir }}</i></td>
                <td>{{ $data->name }}</td>
                <td>{{ $data->cogs_note }}</a></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

    <!--MODAL-->
    <!--MODAL ADD-->
    <div class="modal fade" id="modalAddIncident" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content modal-md">
        <div class="modal-header">
          <center><h3 class="modal-title"><b>Add Money Request</b></h3></center>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('/store_money_req')}}" id="modalAddIncident" name="modalAddIncident">
            @csrf

            <div class="form-group">
                <label>ID Project</label>
                <input type="form-control" class="form-control" id="id_project" name="id_project" required>
            </div>

            <div class="form-group">
                <label>Project Name</label>
                <input type="form-control" class="form-control" id="project_name" name="project_name" required>
            </div>

            <div class="form-group">
                <label>Cogs</label>
                <input type="form-control" class="form-control money" id="cogs" name="cogs" required>
            </div>

            <div class="form-group">
              <label>Note</label>
              <textarea class="form-control" id="cogs_note" name="cogs_note" required></textarea>
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
  
  <!--MODAL EDIT-->
  <div class="modal fade" id="modalEditMoney" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content modal-md">
        <div class="modal-header">
          <center><h3 class="modal-title"><b>Edit Money Request</b></h3></center>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('/update_money_req')}}" id="modalEditMoney" name="modalEditMoney">
            @csrf

            <div class="form-group">
              <label>ID Project</label>
              <input type="form-control" id="edit_id_money" class="form-control" name="edit_id_money" readonly>
            </div>
            
            <div class="form-group">
              <label>ID Project</label>
              <input type="form-control" name="edit_id_project" class="form-control" id="edit_id_project" readonly>
            </div>

            <div class="form-group">
              <label>Project Name</label>
              <input type="form-control" name="edit_project_name" class="form-control" id="edit_project_name" readonly>
            </div>

            <div class="form-group">
              <label>Cogs Awal</label>
              <input type="form-control" class="form-control" id="edit_cogs" name="edit_cogs" readonly>
            </div>

            <div class="form-group">
              <label>Cogs</label>
              <input type="form-control" class="form-control" id="edit_cogs" name="edit_cogs" required>
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
</section>

@endsection

@section('script')
  <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery.mask.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
  <script type="text/javascript">
    $('.money').mask('000,000,000,000,000', {reverse: true});
     $('#datastable').DataTable( {
        "scrollX": true} );

     function moneyreq(id_money_req,id_project,project_name,cogs,cogs_note) {
      $('#edit_id_money').val(id_money_req);
      $('#edit_id_project').val(id_project);
      $('#edit_project_name').val(project_name);
      $('#edit_cogs').val(cogs);
      $('#edit_cogs_note').val(cogs_note);
      $('#')
      
    }
  </script>
  <script type="text/javascript">
    var rupiah = document.getElementById('rupiah');
    rupiah.addEventListener('keyup', function(e){
      rupiah.value = formatRupiah(this.value, 'Rp. ');
    });

    function formatRupiah(angka, prefix){
      var number_string = angka.replace(/[^,\d]/g, '').toString(),
      split       = number_string.split(','),
      sisa        = split[0].length % 3,
      rupiah        = split[0].substr(0, sisa),
      ribuan        = split[0].substr(sisa).match(/\d{3}/gi);

      if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
      }
      rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
      return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
  </script>

  <style type="text/css">

div.table-responsive {
  overflow: auto;
  white-space: nowrap;
  }

/*div.table-responsive a {
  display: inline-block;
  color: white;
  text-align: center;
  padding: 10px;
  text-decoration: none;
}*/

/* width */
::-webkit-scrollbar {
  width: 20px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
::-webkit-scrollbar-thumb {
  background: #888; 
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background-color: #ffb523;
}
  </style>
@endsection