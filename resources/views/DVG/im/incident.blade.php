@extends('template.template')
@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Incident Management</a>
        </li>
      </ol>


  <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-table"></i> <b>Incident Management</b>
          <button type="button" class="btn btn-success-sales pull-right float-right margin-left-custom" data-target="#modalAddIncident" data-toggle="modal"><i class="fa fa-plus"> </i> &nbspIncident
          </button>
          <div class="pull-right">
            <button type="button" class="btn btn-warning-eksport dropdown-toggle float-right  margin-left-customt" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><b><i class="fa fa-download"></i> Export</b>
            </button>
          <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 30px, 0px);">
            <a class="dropdown-item" href="{{action('INCIDENTController@downloadPDF')}}"> PDF </a>
            <a class="dropdown-item" href="{{action('INCIDENTController@exportExcelIM')}}"> EXCEL </a>
          </div>
          </div>
      </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered display nowrap" id="datastable" style="width: 100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Date</th>
                  <th>Case</th>
                  <th>User</th>
                  <th>Division</th>
                  <th>Status</th>
                  <th>Solution</th>
                  <th>Time</th>
                  <th>Impact</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach($datas as $data)
                <tr>
                  <td>{{ $data->no }}</td>
                  <td>{{ $data->date }}</td>
                  <td>{{ $data->chase }}</td>
                  <td>{{ $data->user }}</td>
                  <td>{{ $data->division }}</td>
                  <td>{{ $data->status }}</td>
                  <td>{{ $data->solution }}</td>
                  <td>{{ $data->time }}</td>
                  <td>{{ $data->impact }}</td>
                  <td>

                    <button class="btn btn-sm btn-primary fa fa-pencil fa-lg" data-target="#modalEdit" data-toggle="modal" style="width: 40px;height: 40px;text-align: center;" onclick="incident('{{$data->no}}','{{$data->date}}','{{$data->user}}','{{$data->chase}}','{{$data->division}}','{{$data->status}}','{{$data->solution}}','{{$data->time}}','{{$data->impact}}')"></button>

                    <a href="{{ url('delete_incident', $data->no) }}"><button class="btn btn-sm btn-danger fa fa-trash fa-lg" style="width: 40px;height: 40px;text-align: center;" onclick="return confirm('Are you sure want to delete this data?')">
                    </button></a>

                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer small text-muted">Sinergy Informasi Pratama © 2018</div>
      </div>
    </div>

    <!--MODAL-->
    <!--MODAL ADD INCIDENT-->
    <div class="modal fade" id="modalAddIncident" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">Add Incident</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('/store_incident')}}" id="modalAddIncident" name="modalAddIncident">
            @csrf
            
            <!-- <div class="form-group">
                <label>No</label>
                <input class="form-control" id="no" name="no" required>
            </div> -->

            <div class="form-group">
                <label>Date</label>
                <input type="date" class="form-control" id="date" name="date" required>
            </div>

            <div class="form-group">
                <label>Case</label>
                <input type="form-control" class="form-control" id="chase" name="chase" required>
            </div>

            <div class="form-group">
                <label>User</label>
                <input class="form-control" id="user" name="user" required>
            </div>

            <div class="form-group">
                <label>Division</label>
                <select class="form-control" id="division" name="division" required>
                      <option value="DPG">DPG</option>
                      <option value="DVG">DVG</option>
                  </select>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select class="form-control" id="status" name="status" required>
                      <option value="Pending">Pending</option>
                      <option value="Done">Done</option>
                      <option value="Reject">Reject</option>
                  </select>
            </div>

            <div class="form-group">
                <label>Solution</label>
                <input class="form-control" id="solution" name="solution" required>
            </div>

            <div class="form-group">
                <label>Time</label>
                <input class="form-control" id="time" name="time" required>
            </div>

            <div class="form-group">
                <label>Impact</label>
                <input class="form-control" id="impact" name="impact" required>
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
  
  <!--MODAL EDIT INCIDENT-->
  <div class="modal fade" id="modalEdit" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">Edit Incident</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('/update_incident')}}" id="modalEditIM" name="modalEditIM">
            @csrf

            <div class="form-group">
              <label>No</label>
              <input class="form-control" id="no" name="edit_no">
            </div>

            <div class="form-group">
                <label>Date</label>
                <input type="date" class="form-control" id="edit_date" name="edit_date" required>
            </div>

            <div class="form-group">
                <label>Case</label>
                <input type="form-control" class="form-control" id="edit_chase" name="edit_chase" required>
            </div>

            <div class="form-group">
                <label>User</label>
                <input class="form-control" id="edit_user" name="edit_user" required>
            </div>

            <div class="form-group">
                <label>Division</label>
                <select class="form-control" id="edit_division" name="edit_division" required>
                      <option value="DPG">DPG</option>
                      <option value="DVG">DVG</option>
                  </select>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select class="form-control" id="edit_status" name="edit_status" required>
                      <option value="Pending">Pending</option>
                      <option value="Done">Done</option>
                      <option value="Reject">Reject</option>
                  </select>
            </div>

            <div class="form-group">
                <label>Solution</label>
                <input class="form-control" id="edit_solution" name="edit_solution" required>
            </div>

            <div class="form-group">
                <label>Time</label>
                <input class="form-control" id="edit_time" name="edit_time" required>
            </div>

            <div class="form-group">
                <label>Impact</label>
                <input class="form-control" id="edit_impact" name="edit_impact" required>
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

     function incident(no,date,user,chase,id_division,status,solution,time,impact) {
      $('#no').val(no);
      $('#edit_date').val(date);
      $('#edit_user').val(user);
      $('#edit_chase').val(chase);
      $('#edit_division').val(id_division);
      $('#edit_status').val(status);
      $('#edit_solution').val(solution);
      $('#edit_time').val(time);
      $('#edit_impact').val(impact);
    }
  </script>
@endsection