@extends('template.template')
@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Detail Project Transaction</a>
        </li>
      </ol>
    
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
      <a href="{{url('/inventory/project')}}"><button class="btn btn-sm btn-danger margin-bottom" style="width: 150px"><i class="fa fa-back"></i>&nbsp back to List</button></a>
      <div class="card mb-3">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered display no-wrap" id="data_Table" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Description</th>
                  <th>Qty</th>
                  <th>Serial Number</th>
                  <th>Tanggal Keluar</th>
                </tr>
              </thead>
              <tbody id="products-list" name="products-list">
              	@foreach($details as $datam)
                <tr>
                	
                	  <td>{{$datam->nama}}</td>
	                  <td>{{$datam->description}}</td>
	                  <td>{{$datam->qty}}</td>
	                  <td>
                  
                  	@foreach($detail as $data)
                  	<ul>
                  		<li style="list-style: none;margin-left:-40px">
                  			{{$data->serial_number}}
                  		</li>
                  	</ul>
                  	@endforeach
                  </td>
                  <td>{{$datam->tgl_keluar}}</td>
                  @endforeach
                </tr>
              </tbody>
              <tfoot>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
  </div>
  
</div>
@endsection
@section('script')
<script type="text/javascript">
	$('#data_Table').DataTable({

	});
</script>
@endsection