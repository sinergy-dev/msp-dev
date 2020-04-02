@extends('template.template')
@section('content')

  <div class="content-wrapper">
    <div class="container-fluid">
      
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Config Management</a>
        </li>
      </ol>

      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> Config Management Table
          <div class="pull-right">
            <button type="button" class="btn btn-success-sales pull-right float-right margin-left-custom" data-target="#modalAdd" data-toggle="modal"><i class="fa fa-plus"> </i> &nbspAdd CM </button>
            <button type="button" class="btn btn-warning-eksport dropdown-toggle float-right  margin-left-customt" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <b><i class="fa fa-download"></i> Export</b>
            </button>
          <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 30px, 0px);">
            <a class="dropdown-item" href="{{action('CMController@downloadPDF')}}"> PDF </a>
            <a class="dropdown-item" href="{{action('CMController@exportExcel')}}"> EXCEL </a>
          </div>
          </div>
          <!-- <button type="button" class="btn btn-success-sales pull-right float-right margin-left-custom" data-target="#modalAdd" data-toggle="modal"><i class="fa fa-plus"> </i> &nbspAdd CM </button>
          <div class="pull-right">
            <a href="{{action('CMController@downloadPDF')}}" class="btn btn-warning float-right margin-left-custom"><i class="fa fa-cloud-download"></i>&nbsp&nbspExport PDF</a>
            <a href="{{action('CMController@exportExcel')}}" class="btn btn-warning float-right margin-left-custom"><i class="fa fa-cloud-download"></i>&nbsp&nbspExport XLS</a>
          </div> -->
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered display nowrap" id="datastable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Tanggal</th>
                  <th>PIC</th>
                  <th>Hostname</th>
                  <th>Perangkat</th>
                  <th>Perubahan</th>
                  <th>Resiko</th>
                  <th>Downtime</th>
                  <th>Keterangan</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="products-list" name="products-list">
                <?php $no = 1; ?>
                @foreach($datas as $data)
                <tr>
                  <td>{{ $no++ }}</td>
                  <td>{{ $data->tgl }}</td>
                  <td>{{ $data->name }}</td>
                  <td>{{ $data->hostname }}</td>
                  <td>{{ $data->perangkat }}</td>
                  <td>{{ $data->perubahan }}</td>
                  <td>{{ $data->resiko }}</td>
                  <td>{{ $data->downtime }}</td>
                  <td>{{ $data->keterangan }}</td>
                  <td>
                    <button class="btn btn-sm btn-primary fa fa-pencil fa-lg" data-target="#modalEdit" data-toggle="modal" style="width: 40px;height: 40px;text-align: center;" onclick="config('{{$data->no}}','{{$data->tgl}}','{{$data->nik_pic}}','{{$data->hostname}}','{{$data->perangkat}}','{{$data->perubahan}}','{{$data->resiko}}','{{$data->downtime}}','{{$data->keterangan}}')">
                    </button>
                    <a href="{{ url('delete_cm', $data->no) }}"><button class="btn btn-sm btn-danger fa fa-trash fa-lg" style="width: 40px;height: 40px;text-align: center;" onclick="return confirm('Are you sure want to delete this data?')">
                    </button></a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
  </div>
</div>

<!-- MODAL ADD -->
<div class="modal fade" id="modalAdd" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content modal-md">
          <div class="modal-header">
            <h4 class="modal-title">Add Config Management</h4>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{url('/store_cm')}}" id="modalAddCM" name="modalAddCM">
              @csrf

              <div class="form-group">
              	  <label for="">PIC</label>
		            <select class="form-control" id="nik_pic" name="nik_pic">
		              <option value=""> Select PIC </option>
		              @foreach($owner as $data)
		                @if($data->id_territory == 'DVG')
		                  <option value="{{$data->nik}}">{{$data->name}}</option>
		                @endif
		              @endforeach
		            </select>
              	  <label>Tanggal</label>
              	  <input type="date" class="form-control" id="tanggal_config" name="tanggal_config" required>
                  <label>Hostname</label>
                  <input class="form-control" id="hostname" name="hostname" required>
                  <label>Perangkat</label>
                  <input class="form-control" id="perangkat" name="perangkat" required>
                  <label>Perubahan</label>
                  <input class="form-control" id="perubahan" name="perubahan" required>
                  <label>Resiko</label>
                  <input class="form-control" id="resiko" name="resiko" required>
                  <label>Downtime</label>
                  <input class="form-control" id="downtime" name="downtime" required>
                  <label>Keterangan</label>
                  <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
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

<!-- MODAL EDIT -->
<div class="modal fade" id="modalEdit" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">Edit Config Management</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('/update_cm')}}" id="modalEditCM" name="modalEditCM">
            @csrf

            <div class="form-group" hidden>
                <label>No</label>
                <input class="form-control" id="edit_no" name="no" readonly>
            </div>

            <div class="form-group">
              <label for="">PIC</label>
		            <select class="form-control" id="edit_nik_pic" name="nik_pic">
		              <option value=""> Select PIC </option>
		              @foreach($owner as $data)
		                @if($data->id_territory == 'DVG')
		                  <option value="{{$data->nik}}">{{$data->name}}</option>
		                @endif
		              @endforeach
		            </select>
          	  <label>Tanggal</label>
          	  <input type="date" class="form-control" id="edit_tanggal_config" name="tanggal_config" required>
              <label>Hostname</label>
              <input class="form-control" id="edit_hostname" name="hostname" required>
              <label>Perangkat</label>
              <input class="form-control" id="edit_perangkat" name="perangkat" required>
              <label>Perubahan</label>
              <input class="form-control" id="edit_perubahan" name="perubahan" required>
              <label>Resiko</label>
              <input class="form-control" id="edit_resiko" name="resiko" required>
              <label>Downtime</label>
              <input class="form-control" id="edit_downtime" name="downtime" required>
              <label>Keterangan</label>
              <textarea class="form-control" id="edit_keterangan" name="keterangan"></textarea>
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

@endsection

@section('script')
  <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery.mask.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
  <script type="text/javascript">
     $('#datastable').DataTable( {
        "scrollX": true
        } );

    function config(no, tgl,nik_pic, hostname, perangkat, perubahan, resiko, downtime, keterangan) {
      $('#edit_no').val(no);
      $('#edit_tanggal_config').val(tgl);
      $('#edit_nik_pic').val(nik_pic);
      $('#edit_hostname').val(hostname);
      $('#edit_perangkat').val(perangkat);
      $('#edit_perubahan').val(perubahan);
      $('#edit_resiko').val(resiko);
      $('#edit_downtime').val(downtime);
      $('#edit_keterangan').val(keterangan);
    }
  </script>
@endsection