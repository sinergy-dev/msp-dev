@extends('template.template_admin-lte')
@section('content')

<section class="content-header">

  <h1>
    Report Lead
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Report Lead</li>
  </ol>
  
</section>

<section class="content">
  
  <div class="box">
    
    <div class="box-header with-border">
          <div class="pull-right">
            <button type="button" class="btn btn-xs btn-warning dropdown-toggle float-right" data-toggle="dropdown" >
            Export <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
              <li><a class="dropdown-item" href="{{action('ReportController@downloadPdflead')}}"> PDF </a></li>
              <li><a class="dropdown-item" href="{{action('ReportController@exportExcelLead')}}"> EXCEL </a></li>
            </ul>
            <!-- <button type="button" class="btn btn-warning-eksport dropdown-toggle float-right  margin-left-customt" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <b><i class="fa fa-download"></i> Export</b>
            </button>
            <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 30px, 0px);">
              <a class="dropdown-item" href="{{action('ReportController@downloadPdflead')}}"> PDF </a>
              <a class="dropdown-item" href="{{action('ReportController@exportExcelLead')}}"> EXCEL </a>
            </div> -->
          </div>
    </div>

    <div class="box-body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped dataTable" id="data_Table" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Lead ID</th>
              <th>Customer</th>
              <th>Opty Name</th>
              <th>Create Date</th>
              <th>Owner</th>
              <th>Amount</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody id="products-list" name="products-list">
            @foreach($lead as $data)
            <tr>
              <td>{{ $data->lead_id }}</td>
              <td>{{ $data->brand_name}}</td>
              <td>{{ $data->opp_name }}</td>
              <td>{!!substr($data->created_at,0,10)!!}</td>
              <td>{{ $data->name }}</td>
              @if($data->amount != NULL)
              <td><i  class="money">{{ $data->amount }},00</i></td>
              @else
              <td></td>
              @endif
              <td>
                @if($data->result == 'OPEN')
                  <label class="status-initial">INITIAL</label>
                @elseif($data->result == '')
                  <label class="status-open">OPEN</label>
                @elseif($data->result == 'SD')
                  <label class="status-sd">SD</label>
                @elseif($data->result == 'TP')
                  <label class="status-tp">TP</label>
                @elseif($data->result == 'WIN')
                  <label class="status-win">WIN</label>
                @else
                  <label class="status-lose">LOSE</label>
                @endif
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            @if(Auth::User()->id_territory != NULL)
              <th colspan="5" style="text-align: right;">Total Amount:</th>
              <th><i>Rp</i><i  class="money">{{$total_ter}},00</i></p></th>
              <th></th>
            @elseif(Auth::User()->id_position == 'DIRECTOR')
              <th colspan="5" style="text-align: right;">Total Amount:</th>
              <th><i>Rp</i><i  class="money">{{$total_ter}},00</i></p></th>
              <th></th>
            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL')
              <th colspan="5" style="text-align: right;">Total Amount:</th>
              <th><i>Rp</i><i  class="money">{{$total_ter}},00</i></p></th>
              <th></th>
            @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES')
              <th colspan="5" style="text-align: right;">Total Amount:</th>
              <th><i>Rp</i><i  class="money">{{$total_ter}},00</i></p></th>
              <th></th>
            @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'TECHNICAL PRESALES')
              <th colspan="5" style="text-align: right;">Total Amount:</th>
              <th><i>Rp</i><i  class="money">{{$total_ter}},00</i></p></th>
              <th></th>
            @elseif(Auth::User()->id_division == 'SALES')
              <th colspan="5" style="text-align: right;">Total Amount:</th>
              <th><i>Rp</i><i  class="money">{{$total_ter}},00</i></p></th>
              <th></th>
            @endif
          </tfoot>
        </table>
      </div>
    </div>

  </div>

</section>

@endsection

@section('script')
   <script type="text/javascript" src="{{asset('js/jquery.mask.min.js')}}"></script>
   <script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
   <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/dataTables.fixedColumns.min.js')}}"></script>

   <script type="text/javascript">
     $('.money').mask('000,000,000,000,000.00', {reverse: true});

     $('#data_Table').DataTable( {
        // "scrollX": true,
        "order": [[ 0, "desc" ]],
     } );
   </script>
@endsection