@extends('template.template_admin-lte')
@section('content')

<section class="content-header">
  <h1>
    @if(Auth::user()->id_division == 'FINANCE')
    Claim
    @else
    Warehouse
    @endif
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Report</li>
  </ol>
</section>

<section class="content">
  <div class="box">
    <div class="box-header">
      
    </div>
    <div class="box-body">
      <table class="table table-bordered table-striped dataTable" id="data_Table" width="100%" cellspacing="0">
        <thead>
          @if(Auth::User()->id_division == 'FINANCE')
          <tr>
            <th>No</th>
            <th>Date</th>
            <th>Personnel</th>
            <th>Type</th>
            <th>Description</th>
            <th>Amount</th>
            <th>ID Project</th>
            <th>Remarks</th>
            <th>Status</th>
          </tr>
          @else
          <tr>
            <th style="width: 10px"><center>No</center></th>
            <th style="width: 150px"><center>MSPCode</center></th>
            <th style="width: 25px"><center>Stock</center></th>
            <th style="width: 35px"><center>Unit</center></th>
            <th><center>Description</center></th>
          </tr>
          @endif
        </thead>
        <tbody id="products-list" name="products-list">
          @if(Auth::User()->id_division == 'FINANCE')
            @foreach($datas as $data)
            <tr>
              <td>{{ $data->no }}</td>
              <td>{{$data->date}}</td>
              <td>{{$data->name}}</td>
              <td>{{$data->type}}</td>
              <td>{{$data->description}}</td>
              <td class="money">{{$data->amount}}</td>
              <td>{{$data->id_project}}</td>
              <td>{{$data->remarks}}</td>

              @if(Auth::User()->id_position == 'ADMIN' || Auth::User()->id_position == 'HR MANAGER' || Auth::User()->id_division == 'FINANCE')
              <td>
                @if($data->status == 'FINANCE')
                <label class="status-open">PENDING</label>
                @elseif($data->status == 'TRANSFER')
                <label class="status-sd">TRANSFER</label>
                @elseif($data->status == 'ADMIN')
                <label class="status-lose">PENDING</label>
                @elseif($data->status == 'HRD')
                <label class="status-lose">PENDING</label>
                @endif
              </td>
              @endif
            </tr>
            @endforeach
          @else
          <?php $no = 1;?>
            @foreach($datas as $data)
            <tr>
              <td>{{$no++ }}</td>
              <td>{{$data->kode_barang}}</td>
              <td>{{$data->qty}}</td>
              <td>{{$data->unit}}</td>
              <td>{{$data->nama}}</td>
            </tr>
            @endforeach
          @endif
        </tbody>
      </table>
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
     $('.money').mask('000,000,000,000,000', {reverse: true});

     $('#data_Table').DataTable({
       "pageLength": 50,
     });
   </script>
@endsection