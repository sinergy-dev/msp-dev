@extends('template.template')
@section('content')
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Project Inventory</a>
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
           <i class="fa fa-table"></i>&nbsp<b>Project Delivery Order Table</b>
           <a href="{{url('add/do_sip')}}"><button class="btn btn-primary-lead margin-bottom pull-right"><i class="fa fa-plus"> </i>&nbsp Add Project</button></a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered display no-wrap" id="data_Table" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>To</th>
                  <th>From</th>
                  <th>Subject</th>
                  <th>No. DO</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="products-list" name="products-list">
                @foreach($data as $data)
                <tr>
                  <td>{{$data->to}}</td>
                  <td>{{$data->from}}</td>
                  <td>{{$data->subj}}</td>
                  <td>{{$data->no_do}}</td>
                  <td>
                    <a href="{{url('/detail_project_inventory',$data->id_inventory_project)}}"><button class="btn btn-default btn-sm">Detail</button></a>
                    <a href="{{action('WarehouseProjectController@downloadPdfDOSIP',$data->id_inventory_project)}}"><button class="btn btn-primary btn-sm"><i class="fa fa-print"></i>&nbspPdf</button></a>
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

  <!--Modal Add Project-->
<div class="modal fade" id="modal_product" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">Add Project</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="" id="mproject" name="mproject">
            @csrf
          <div class="form-group">
            <label for="">Project Name</label>
            <input type="text" class="form-control" placeholder="Enter Name" name="name" id="name" required>
          </div>

          <div class="form-group">
            <label for="">Product</label>
            <select name="product" id="product" class="form-control">
              <option>-- Select Product --</option>
              @foreach($barang as $data)
              <option value="{{$data->id_barang}}">
                {{$data->nama}}&nbsp&nbsp({{$data->qty}})&nbsp&nbsp<b>({{$data->note}})</b>
              </option>
              @endforeach
            </select><br>

            <label for="">Product Detail</label>
            <select name="detail_product[]" id="detail-product" class="form-control detail-product" style="width: 100%" multiple="multiple">
              <option>-- Select Product --</option>
            </select>
           <!--  <table class="table-bordered">
            	<thead>
            	<tr>
            		<th>Kode Barang</th>
            		<th>Nama Barang</th>
            		<th>Serial Number</th>
            		<th>Action</th>
            	</tr>
            	</thead>
            	<tbody id="mytable">
            		
            	</tbody>
            </table> -->
          </div>

          <div class="form-group">
            <label for="">No. Delivery Order</label>
            <select class="form-control" id="no_do" name="no_do">
              @foreach($do_number as $data)
              <option value="{{$data->no}}">{{$data->no_do}}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="">Date</label>
            <input type="date" class="form-control" placeholder="Enter Name" name="date" id="date" required>
          </div>

         <!--  <div class="form-group">
            <label for="">Note</label>
            <textarea class="form-control" id="note" name="note"></textarea>
          </div> -->


          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
            <!-- <button class="btn btn-primary" id="submit"><i class="fa fa-check"> </i>&nbspSubmit</button> -->
            <button type="button" class="btn btn-primary" id="btn-save" value="add">Save</button>
          </div>
        </form>
        </div>
      </div>
    </div>
</div>



<!--Modal Edit-->
<div class="modal fade" id="modal_edit_category" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">Edit Category</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('update_category')}}" id="modaledit" name="modaledit">
            @csrf
          <input type="text" class="form-control" name="id_category_edit" id="id_category_edit" hidden>
      
          <div class="form-group">
            <label for="">Category</label>
            <input type="text" class="form-control" placeholder="Enter Category" name="category_edit" id="category_edit">
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
  <script type="text/javascript" src="{{asset('js/multiselect.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
  <script type="text/javascript">
    function category(id_category,category) {
      $('#id_category_edit').val(id_category);
      $('#category_edit').val(category);
    }

    function category(kode_barang,serial_number) {
      $('#keterangan_lose').val(serial_number);
    }

    function tipe(id_type,type) {
      $('#id_type_edit').val(id_type);
      $('#type_edit').val(type);
    }

    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
         $("#alert").slideUp(300);
    });

    $('#data_Table').DataTable( {
     "scrollX": true,
    });

    $(".detail-product").select2();

    $('#detail-product').on('change',function(e){
      var coba = $("select#detail-product").val();
      console.log(coba);
    });

    $("#btn-save").click(function(e){

    	var formData = {
          nama_project	: $('#name').val(),
          id_detail_barang: $("select#detail-product").val(),
          no_do    		: $("#no_do").val(),
          tgl_keluar   	: $("#date").val(),
      }

    	console.log(formData);

    	$.ajax({
          type:"POST",
          url:'/inventory/project/store',
          data:$('#mproject').serialize(),
          success: function(result){
	          	swal({
                  title: "Success!",
                  text:  "You have been add product",
                  type: "success",
                  timer: 2000,
                  showConfirmButton: false
	            });
		        setTimeout(function() {
		            window.location.href = window.location;
		        }, 2000);  
          },
      });
    	
    });

   /* $('#modal-detail-product').click(function(e){
      $.ajax({
          type:"GET",
          url:'/dropdownDetailProject?product=' + product,
          data:{
            product:this.value,
          },
          success: function(result){
            $('#mytable').empty();

            var table = "";

            $.each(result[0], function(key, value){
              table = table + '<tr>';
                table = table + '<td>' +value.kode_barang+ '</td>';
                table = table + '<td>' +value.nama+ '</td>';
                table = table + '<td>' +value.serial_number+ '</td>';
                table = table + '<td>' +'<button value="'+value.id_detail+'">Send</button>'+ '</td>';
              table = table + '</tr>';
            });

            $('#mytable').append(table);

          },
      });
    });*/

    $('#product').on('change',function(e){
      console.log(e);

      $.ajax({
          type:"GET",
          url:'/dropdownProject?product=' + product,
          data:{
            product:this.value,
          },
          success: function(result){
          	/*$('#mytable').empty();

          	var table = "";

          	$.each(result[0], function(key, value){
          		table = table + '<tr>';
          		if (value.serial_number == null) {
          		table = table + '<td>' +value.kode_barang+ '</td>';
                table = table + '<td>' +value.nama+ '</td>';
                table = table + '<td>' +' '+ '</td>';
                table = table + '<td>' +'<button value="'+value.id_detail+'">Send</button>'+ '</td>';
                }else{
                table = table + '<td>' +value.kode_barang+ '</td>';
                table = table + '<td>' +value.nama+ '</td>';
                table = table + '<td>' +value.serial_number+ '</td>';
                table = table + '<td>' +'<button value="'+value.id_detail+'">Send</button>'+ '</td>';
                }
          		table = table + '</tr>';
          	});

          	$('#mytable').append(table);*/
            $('#detail-product').html(append)
            var append = "<option>-- Select Product --</option>";

            $.each(result[0], function(key, value){
              
              if (value.serial_number == null) {
                append = append + "<option value="+value.id_detail+">" + value.nama + "</option>";
               
              }else{ 
                append = append + "<option value="+value.id_detail+">" + value.nama + " "+ value.serial_number +"</option>";
              }
              console.log(value.id_detail);
            });

            $('#detail-product').html(append);

          },
      });
      /*console.log(e);*/

      /*var product = $(this).val();

      $.get('/dropdownProject?product=' + product, function(data){
        console.log(data)

        $('#detail-product').empty();
        $.each(data, function(key, value){
          $('#detail-product').append('<option value="'+value.id_detail+'">'+value.nama+ value.serial_number+'</option>');
          console.log(value);
        });

      });*/
    });
  </script>
@endsection