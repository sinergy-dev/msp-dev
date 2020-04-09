@extends('template.template_admin-lte')
@section('content')

<style type="text/css">
  td.details-control {
    text-align: center;
    vertical-align: middle;
    cursor: pointer;
  }

  .header{
    background-color: #dddddd;
  }

  /*.header th:nth-child(2){
    background-color: #dddddd;
  }*/


</style>

<section class="content-header">
  <h1>
    Id Project Mapping
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Delivery Person</li>
    <li class="active">SIP</li>
  </ol>
</section>

<section class="content">
  <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-table"></i>&nbsp<b>Id Project</b></h3>

      </div>

      <div class="box-body">
        <div style="margin-bottom: 10px">
          <button class="btn btn-success btn-sm add-messenger" data-toggle="modal" data-target="#modaltambahmapping" style="width: 70px;"><i class="fa fa-plus"></i> Add</button>
        </div>
        
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="nav-tabs-custom">
              <ul class="nav nav-tabs" id="myTab">
                    <!-- <li class="nav-item active">
                        <a class="nav-link" id="all" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true" onclick="changeTerritory('today')">
                            Today
                        </a>
                    </li>
                    <li>
                      <a class="nav-link" id="all" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true" onclick="changeTerritory('done')">
                            Done
                        </a>
                    </li>
                    <li>
                      <a class="nav-link" id="all" data-toggle="tab" href="#all" role="tab" aria-controls="all" aria-selected="true" onclick="changeTerritory('requested')">
                            Requested
                        </a>
                    </li> -->
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active"  role="tabpanel" >
                    <div class="table-responsive">
                       <table class="table table-bordered table-striped dataTable" id="data_po" width="100%" cellspacing="0">
                        <thead>
                          <tr class="header">
                            <th>No PO</th>
                            <th>Id Project</th>
                            <th>Location</th>
                            <th>Created By</th>
                            <th>Date</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                       </table>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
        
      </div>

    </div>

    <!--modal add-->
    <div class="modal fade" id="modaltambahmapping" role="dialog">
      <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content modal-md">
          <div class="modal-header">
            <h4 class="modal-title">Add Mapping Id Project</h4>
          </div>
          <div class="modal-body">
            <form method="POST" action="{{url('/store_po_idpro')}}" id="" name="">
              @csrf

              <div class="form-group">
                <label>No PO</label>
                <select class="form-control" id="no_po" name="no_po" style="width: 100%">
                  <option>Select No PO</option>
                  @foreach($no_po as $data)
                  <option value="{{$data->id}}">{{$data->no_po}}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label>ID Project</label>
                <select class="form-control" id="id_project" name="id_project" style="width: 100%">
                  <option>Select Id Project</option>
                  @foreach($id_pro as $data)
                  <option value="{{$data->id_project}}">{{$data->id_project}}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <label>Lokasi</label>
                <input type="text" name="lokasi" id="lokasi" class="form-control">
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
                <button type="submit" class="btn btn-primary btn-submit"><i class="fa fa-check"> </i>&nbspSubmit</button>
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
  <script type="text/javascript" src="{{asset('js/dataTables.fixedColumns.min.js')}}"></script>
  <script type="text/javascript">

    $('#no_po').select2();
    $('#id_project').select2();

    initdata();

    /*$('#data_po tbody').on('click', 'td.details-control', function () {
      var tr = $(this).closest('tr');
      var row = $("#data_po").DataTable().row( tr );
      if ( row.child.isShown() ) {
        row.child.hide();
        tr.removeClass('shown');
        $(this).closest('tr > td').children().attr("class","fa fa-plus");
      }
      else {
        var tr2 = $(this).closest('tr > td').children()
        // console.log($(this))
        $.ajax({
          type:"GET",
          url:"{{url('')}}",
          data:{
            id:row.data().id
          },
          success:function(result){
            // console.log('asdfadf')
            row.child( format(row.data(),result)).show();
            tr.addClass('shown');
            tr2.attr("class","fa fa-minus");
          }
        })
        
      }
    });*/

    function initdata(){
    $("#data_po").DataTable({
      "ajax":{
        "type":"GET",
        "url":"{{url('getdatapo')}}",
        "dataSrc": function (json){
            no = 1;
            json.data.forEach(function(data,index){
              data.index = no;
              no++;
            });
            return json.data;
          }
      },
      "columns": [
        { "data": "no_po" },
        { "data": "id_project" },
        { "data": "lokasi" },
        { "data": "name" },
        { "data": "created_at" }
      ],
      "searching": true,
      "lengthChange": false,
      "info":false,
      "scrollX": false,
      "order": [[ 1, "asc" ]],

      "drawCallback": function ( settings ) {
        var api = this.api(),data;
        var rows = api.rows( {page:'current'} ).nodes();
        var last=null;
        api.column(0, {page:'current'} ).data().each( function ( group, i ) {
              if ( last !== group ) {
                  $(rows).eq( i ).before(
                      '<tr class="group"><td colspan="3">'+'<b>'+group+'</b>'+'</td></tr>'
                  );
                  last = group;
              }
        });

      }
    })
  }

  
  </script>
@endsection