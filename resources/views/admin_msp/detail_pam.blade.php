@extends('template.template_admin-lte')
@section('content')
<style type="text/css">
.rotate{
  /* Safari */
-webkit-transform: rotate(-90deg);

/* Firefox */
-moz-transform: rotate(-90deg);

/* IE */
-ms-transform: rotate(-90deg);

/* Opera */
-o-transform: rotate(-90deg);
}

.inEdit{
      background-color: #dae0ea;
      border: 1px solid #333 ;
      border-radius: 4px;
}
</style>

<section class="content-header">
  <h1>
    Detail PR Asset Management
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Admin</li>
    <li class="active">PR Asset Management</li>
    <li class="active">Detail</li>
  </ol>
</section>

<section class="content">
  <div class="box">
    <div class="box-header with-border">
      <h6 class="card-title mb-1 pull-left">{{$tampilkan->no_pr}}</h6>
      <h6 class="card-title mb-1 pull-right">{{$tampilkan->date}}</h6>
    </div>
  
    <div class="box-body">
      <div class="card-body py-2 small">
        <h4 class="pull-left">From : {{$tampilkan->name}}</h4>
        <h5 class="pull-right"></i>To  : {{$tampilkan->to_agen}}</h5>
        <br><br><br>
        <h6 class="pull-left">
          <div>
          <table class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th colspan="7" style="text-align: center;">LIST PRODUK</th>
              </tr>
              <tr>
                <th>NO ID</th>
                <th>MSP Code</th>
                <th>Nama Produk</th>
                <th>Qty</th>
                <!-- <th>Price</th>
                <th>Total Price</th> -->
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1;?>
              @foreach($produks as $data)
              <tr data-id="{{$data->id_product}}">
                <!-- <td><input type="" class="transparant" name="" value="{{$data->id_product}}" readonly></td> -->
                <td>{{$no++}}</td>
                <td>{{$data->msp_code}}</td>
                <td>{{$data->name_product}}</td>
                <td>{{$data->qty}}</td>
                <!-- <td><b class="money">{{$data->nominal}}</b></td>
                <td><b class="money">{{$data->total_nominal}}</b></td> -->
                <!-- <td></td>
                <td></td> -->
                <td>
                  <!-- <button class="btn btn-sm btn-primary" data-target="#update_produk" onclick="produk('{{$data->id_product}}','{{$data->msp_code}}','{{$data->name_product}}','{{$data->qty}}','{{$data->nominal}}')" data-toggle="modal" style="width: 30px;height: 30px"><i class="fa fa-edit fa-lg"></i></button> -->
                  @if($count_pam <= 1)
                  @else
                  <a href="{{ url('delete_produk_msp?id_product='. $data->id_product) }}"> <button style="width: 30px;height: 30px" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')"><i class="fa fa-trash"></i></button></a>
                    @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        </h6>
      </div>
    </div>
  </div>

  <div class="box">
    <div class="box-header with-border">Quotation</div>
    <iframe src="{{ asset('pdf/'.$tampilkan->file)  }}" width="100%" height="500px"></iframe>
  </div>

  <div class="box">
    <div class="box-header with-border">
      <i class="fa fa-table"></i> Changes Log
      <div class="pull-right">
        @if(Auth::User()->id_position == 'HR MANAGER' && Auth::User()->id_division == 'HR' || Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'FINANCE')
          @if($tampilkan->status == 'HRD')
            <button class="btn btn-warning pull-right" style="width: 125px" data-target="#keterangan" data-toggle="modal" onclick="return_hr('{{$data->id_pam}}')"><i class="fa fa-spinner" ></i>&nbspReturn</button>
          @endif
        @endif
      </div>
    </div>

    <div class="box-body">
      @if(Auth::User()->id_position == 'HR MANAGER' && Auth::User()->id_division == 'HR')
        <div class="table-responsive">
          <table class="table table-bordered table-striped display nowrap" id="datastable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Date</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Submit Oleh</th>
              </tr>
            </thead>
            <?php $no = 1; ?>
            <tbody id="products-list" name="products-list">
              @foreach($detail_pam as $data)
                    <tr>
                      <td>{{$no++}}</td>
                      <td>{{$data->created_at}}</td>
                      <td>{{$data->keterangan}}</td>
                      <td>{{$data->status}}</td>
                      <td>{{$data->name}}</td>
                    </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'FINANCE')
        <div class="table-responsive">
          <table class="table table-bordered table-striped display nowrap" id="datastable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Date</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Submit Oleh</th>
              </tr>
            </thead>
            <?php $no = 1; ?>
            <tbody id="products-list" name="products-list">
              @foreach($detail_pam as $data)
                    <tr>
                      <td>{{$no++}}</td>
                      <td>{{$data->created_at}}</td>
                      <td>{{$data->keterangan}}</td>
                      <td>{{$data->status}}</td>
                      <td>{{$data->name}}</td>
                    </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @else
        <div class="table-responsive">
          <table class="table table-bordered table-striped display nowrap" id="datastable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>No</th>
                <th>Date</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th>Submit Oleh</th>
              </tr>
            </thead>
            <?php $no = 1; ?>
            <tbody id="products-list" name="products-list">
              @foreach($detail_pam as $data)
                    <tr>
                      <td>{{$no++}}</td>
                      <td>{{$data->created_at}}</td>
                      <td>{{$data->keterangan}}</td>
                      <td>{{$data->status}}</td>
                      <td>{{$data->name}}</td>
                    </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>
  </div>
</section>

<!--modal edit produk-->
<div class="modal fade" id="update_produk" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Produk</h4>
        </div>
        <div class="modal-body">
          <form id="editable_produk" name="editable_produk">
            @csrf
          <input type="" id="id_product_update" name="id_product_update" hidden>
          <div class="form-group">

            <div>
            <label for="sow">MSP Code</label>
            <input type="text" class="form-control" name="msp_code_update" id="msp_code_update">
            </div><br>

            <div>
            <label for="sow">Nama Produk</label>
            <input type="text" class="form-control" name="name_product_update" id="name_product_update">
            </div><br>

            <div>
            <label for="sow">Qty</label>
            <input type="number" name="qty_update" id="qty_update" class="form-control">
            </div><br>

            <div>
           	<label for="sow">Nominal</label>
            <div class="modalIcon inputIconBg">
	        <input type="text" class="form-control money" placeholder="Enter Amount" name="nominal_update" id="nominal_update" required>
	        <i class="" style="top: 0px" aria-hidden="true">Rp.</i>
	        </div>
            </div>
           
          </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>&nbspClose</button>
              <button type="submit" class="btn btn-success-absen"><i class="fa fa-check"></i>&nbsp Update</button>
            </div>
        </form>
        </div>
      </div>
    </div>
</div>

@if(Auth::User()->id_position == 'HR MANAGER')
  <div class="modal fade" id="keterangan" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Return</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{'/tambah_return_hr_pr_asset'}}" id="modalProgress" name="modalProgress">
            @csrf
          <input type="" id="no_return_hr" name="no_return_hr" hidden>
          <div class="form-group">
            <label for="sow">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
          </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>&nbspClose</button>
              <button type="submit" class="btn btn-success-absen"><i class="fa fa-check"></i>&nbsp Submit</button>
            </div>
        </form>
        </div>
      </div>
    </div>
  </div>
@elseif(Auth::User()->id_division == 'FINANCE' && Auth::User()->id_position == 'STAFF')
  <div class="modal fade" id="keterangan" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Return</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{'/tambah_return_fnc_pr_asset_msp'}}" id="modalProgress" name="modalProgress">
            @csrf
          <input type="" id="no_return_fnc" name="no_return_fnc" hidden>
          <div class="form-group">
            <label for="sow">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
          </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i>&nbspClose</button>
              <button type="submit" class="btn btn-success-absen"><i class="fa fa-check"></i>&nbsp Submit</button>
            </div>
        </form>
        </div>
      </div>
    </div>
  </div>
@endif
@endsection

@section('script')
<script type="text/javascript" src="{{asset('js/jquery.mask.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
<script type="text/javascript">
     $('.money').mask('000,000,000,000', {reverse: true});

     function return_hr(id_pam){
      $('#no_return_hr').val(id_pam);
     }

     function return_finance(id_pam){
      $('#no_return_fnc').val(id_pam);
     }

     function produk(id_product,msp_code,name_product,qty,nominal){
      $('#id_product_update').val(id_product);
      $('#msp_code_update').val(msp_code);
      $('#name_product_update').val(name_product);
      $('#qty_update').val(qty);
      $('#nominal_update').val(nominal);
     }

     function updateProduk(e) {
		  if(e.keyCode === 13){
		    if (confirm('Are you sure you want to save this thing into the database?')) {
		      e.preventDefault();
		      var id_product = $(this).data('id_product');
		      $.ajax({
		        type: "POST",
		        url: "/update_produk_msp",
		        data:{id_product:id_product},  
		        success: function(data) 
		        { 
		          swal({
                      title: "Success!",
                      text:  "You have been edit product",
                      type: "success",
                      timer: 2000,
                      showConfirmButton: false
                  });
                     setTimeout(function() {
                         window.location.href = window.location;
                      }, 2000); 
		        }
		      });
		    }  
		 }  
		}

		$('#submit').click(function(){            
         var id_product = $(this).data('id_product');
		      $.ajax({
		        type: "POST",
		        url: "/update_produk_msp",
		        data:$('#editable_produk').serialize(),  
		        success: function(data) 
		        { 
		          swal({
                      title: "Success!",
                      text:  "You have been edit product",
                      type: "success",
                      timer: 2000,
                      showConfirmButton: false
                  });
                     setTimeout(function() {
                         window.location.href = window.location;
                      }, 2000); 
		        }
		      });  
    	}); 

		/*    $("body").on("click", "input", function() {
		    alert("My name: " + this.name);
		});*/

     $('.editbtn').click(function () {
        var currentTD = $(this).parents('tr').find('td');
        if ($(this).html() == 'Edit') {
            currentTD = $(this).parents('tr').find('td');
            $.each(currentTD, function () {
                $(this).prop('contenteditable', true)
            });
        } else {
           $.each(currentTD, function () {
                $(this).prop('contenteditable', false)
            });
        }

        $(this).html($(this).html() == 'Edit' ? 'Save' : 'Edit')
    
    });
</script>
@endsection