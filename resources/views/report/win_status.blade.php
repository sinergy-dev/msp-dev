@extends('template.template_admin-lte')
@section('content')

<section class="content-header">
  <h1>
    Report Win
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Report Win</li>
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
              <li><a class="dropdown-item" href="{{action('ReportController@downloadPdfwin')}}"> PDF </a></li>
              <li><a class="dropdown-item" href="{{action('ReportController@exportExcelWin')}}"> EXCEL </a></li>
            </ul>
        </div>
   </div>
    <div class="box-body">
      <div class="table-responsive">
            <table class="table table-bordered table-striped dataTable nowrap" id="data_Table" width="100%" cellspacing="0">
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
                @foreach($win as $data)
                <tr>
                  <td>{{ $data->lead_id }}</td>
                  <td>{{ $data->brand_name}}</td>
                  <td>{{ $data->opp_name }}</td>
                  <td>{{ $data->created_at}}</td>
                  <td>{{ $data->name }}</td>
                  @if($data->amount != NULL)
                  <td><i  class="money">{{ $data->amount }},00</i></td>
                  @else
                  <td></td>
                  @endif
                  <td>
                    <label class="status-win">Win</label>
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
               <!--  @if(Auth::User()->id_division != 'FINANCE')
                  <th colspan="5" style="text-align: right;">Total Amount:</th>
                  <th><i>Rp</i><i  class="money">{{$total_ter}},00</i></p></th>
                  <th colspan="2"></th>
                @endif -->
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
    "order": [[ 0, "desc" ]],
      // scrollX:        true,
      scrollCollapse: true,
      fixedColumns:   {
          leftColumns: 4
      },
    });
   </script>
@endsection