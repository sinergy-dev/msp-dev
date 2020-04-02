@extends('template.template')
@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Product</a>
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
      <div class="card mb-3">
        <div class="card-header">
           <i class="fa fa-table"></i>&nbsp<b>Product Table</b>
           <button class="btn btn-primary-lead margin-bottom pull-right" id="" data-target="#modal_product" data-toggle="modal"><i class="fa fa-plus"> </i>&nbsp Product</button>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="data_Table" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Item Code</th>
                  <th>Name</th>
                  <th>Quantity</th>
                  <th>Description</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="products-list" name="products-list">
                @foreach($data as $data)
                <tr>
                  <td>{{$data->item_code}}</td>
                  <td>{{$data->name_item}}</td>
                  <td>{{$data->quantity}}</td>
                  <td>{{$data->information}}</td>
                  <td>
                    <button class="btn btn-sm btn-primary fa fa-pencil fa-lg" data-target="#modaledit" data-toggle="modal" style="width: 40px;height: 40px;text-align: center;" onclick="warehouse('{{$data->item_code}}','{{$data->item_code}}','{{$data->name_item}}','{{$data->quantity}}','{{$data->information}}')">
                    </button>
                    <a href="{{ url('/warehouse/delete_item', $data->item_code) }}"><button class="btn btn-sm btn-danger fa fa-trash fa-lg" style="width: 40px;height: 40px;text-align: center;" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')">
                    </button></a>
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
              </tfoot>
            </table>
          </div>
        </div>
      </div>
  </div>
  
</div>

  <!--MODAL ADD PROJECT-->
<div class="modal fade" id="modal_product" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">Add Product</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('/warehouse/store')}}" id="modal_product" name="modal_product">
            @csrf
          <div class="form-group">
            <label for="">Item Code</label>
            <input type="text" class="form-control" placeholder="Enter Item Code" name="item_code" id="item_code" required>
          </div>
          <div class="form-group">
            <label for="">Name</label>
            <input type="text" class="form-control" placeholder="Enter Name" name="name" id="name" required>
          </div> 
          <div class="form-group">
            <label for="">Quantity</label>
            <input type="text" class="form-control" placeholder="Enter Quantity" name="quantity" id="quantity" required>
          </div> 
          <div class="form-group">
            <label for="">Description</label>
            <input type="text" class="form-control" placeholder="Enter Information" name="information" id="information" required>
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

<!--Modal Edit-->
<div class="modal fade" id="modaledit" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">Edit Product</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ url('warehouse/update_warehouse') }}" id="modaledit" name="modaledit">
            @csrf
          <input type="text" class="form-control" placeholder="Enter Item Code" name="edit_item_code_before" id="edit_item_code_before" hidden="">
      
          <div class="form-group">
            <label for="">Name</label>
            <input type="text" class="form-control" placeholder="Enter Name" name="edit_name" id="edit_name">
          </div> 
          <div class="form-group">
            <label for="">Quantity</label>
            <input type="text" class="form-control" placeholder="Enter Quantity" name="edit_quantity" id="edit_quantity">
          </div> 
          <div class="form-group">
            <label for="">Description</label>
            <input type="text" class="form-control" placeholder="Enter Information" name="edit_information" id="edit_information">
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

<style type="text/css">
   .transparant{
      background-color: Transparent;
      background-repeat:no-repeat;
      border: none;
      cursor:pointer;
      overflow: hidden;
      outline:none;
      width: 25px;
    }

</style>

@endsection

@section('script')
  <script type="text/javascript" src="{{asset('js/jquery.mask.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
  <script type="text/javascript">
    function warehouse(item_code,item_code,name_item,quantity,information) {
      $('#edit_item_code_before').val(item_code);
      $('#edit_item_code').val(item_code);
      $('#edit_name').val(name_item);
      $('#edit_quantity').val(quantity);
      $('#edit_information').val(information);
    }

    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
         $("#alert").slideUp(300);
    });
  </script>
@endsection