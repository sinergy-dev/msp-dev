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
      <a href="{{url('/inventory')}}"><button class="btn btn-sm btn-danger margin-bottom" style="width: 150px"><i class="fa fa-back"></i>&nbsp back to List Inventory</button></a>
      <div class="card mb-3">
        <div class="card-header">
           <i class="fa fa-table"></i>&nbsp<b>Detail Inventory Product Table</b>
        </div>

        @if($qty_total != 0)
        <button class="btn btn-sm btn-warning btn_sn pull-right margin-left margin-top" value="{{$id_product->id_product}}"  name="btn_sn" >
            @if($cek_sn > 0)
            <input value="{{$qty_total}}" id="qty_total" name="qty_total" hidden>
            @else
            <input value="{{$qty_now->qty}}" id="qty_total" name="qty_total" hidden>
            @endif
            <input value="{{$id_product->id_barang}}" id="id_barangs" name="id_barangs" hidden>Add SN</button>
        @else
        @endif
        
         
        <div class="card-body">
          @if($qty_now->qty_status == 'F')
          <div class="table-responsive">
            <table class="table table-bordered display no-wrap" id="data_Table" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Category</th>
                  <th>Type</th>
                  <th>Serial Number</th>
                  <th>Status</th>
                  <th>Note</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="products-list" name="products-list">
                <?php $no = 1; ?>
                @foreach($detail as $data)
                <tr>
                  <td>{{$no++}}</td>
                  <td>{{$data->nama}}</td>
                  <td>{{$data->kategori}}</td>
                  <td>{{$data->tipe}}</td>
                  <td>{{$data->serial_number}}</td>
                  <td>
                    @if($data->status == 'PROJECT')
                      DELIVERED
                    @elseif($data->status == 'P')
                      AVAILABLE
                    @endif
                  </td>
                  <td>{{$data->note}}</td>
                  <td>
                    <button class="btn btn-sm btn-primary fa fa-pencil fa-lg" data-target="#modaledit" data-toggle="modal" style="width: 40px;text-align: center;" onclick="warehouse('{{$data->id_detail}}','{{$data->serial_number}}','{{$data->note}}')">
                    </button>
                    <button class="btn btn-sm btn-danger fa fa-trash fa-lg" data-toggle="modal" data-target="#reason_delete" onclick="hapus('{{$data->id_detail}}','{{$data->id_barang}}')" style="width: 40px;text-align: center;">
                    </button>
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
              </tfoot>
            </table>
          </div>
          @else
          @endif
        </div>
      </div>
  </div>
  
</div>

<!--Modal Edit SN-->
<div class="modal fade" id="modaledit" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">Update Serial Number</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ url('update_serial_number') }}" id="modaledit" name="modaledit">
            @csrf
          <input type="text" class="form-control" name="id_detail_edit" id="id_detail_edit" hidden>
      
          <div class="form-group">
            <label for="">Serial Number</label>
            <input type="text" class="form-control" placeholder="Enter Serial Number" name="edit_serial_number" id="edit_serial_number">
          </div> 

          <div class="form-group">
            <label for="">Note(Jika Perlu)</label>
            <textarea type="text" class="form-control" name="note_edit" id="note_edit"></textarea>
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

<!--Modal Delete SN-->
<div class="modal fade" id="reason_delete" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">Kenapa Hapus Barang ?</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{ url('delete_id_detail') }}" id="modalhapus" name="modalhapus">
            @csrf
          <input type="text" class="form-control" name="id_detail_hapus" id="id_detail_hapus" >
          <input type="text" class="form-control" name="id_barang_hapus" id="id_barang_hapus" >

          <div class="form-group">
            <label for="">Note</label>
            <textarea type="text" class="form-control" name="note_hapus" id="note_hapus" required></textarea>
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

<!--Modal SN-->
<div class="modal fade" id="modal-sn" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content modal-sm">
        <div class="modal-body">
          <div class="form-group">
            <form name="sn-modal" id="sn-modal">
              <label>Add Serial Number</label>
              @csrf
                <input type="" class="id_barangs" name="sn_barang" id="sn_barang" hidden>
                <h6>Masukkan Serial Number sebanyak barang yang baru datang !</h6>
                <h6>Stock tanpa SN : <input type="" class="qtys" name="qty" id="qtys" style="border-style: none;font-style: bold;font-size:14px; "></h6><br>
                <textarea class="form-control serial_number" rows="10" name="serial_number" id="serial_number"></textarea>
                <hr>
              <input class="btn btn-sm btn-primary float-right btn-sn" id="btn-sn" type="button" value="submit" disabled>
              <!-- <button type="submit" class="btn btn-xs btn-primary">Submit</button> -->
            </form>
          </div>
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
    function warehouse(id_detail,serial_number,note) {
      $('#id_detail').val(id_detail);
      $('#id_detail_edit').val(id_detail);
      $('#edit_serial_number').val(serial_number);
      $('#note_edit').val(note);
    }

    function hapus(id_detail,id_barang) {
      $('#id_detail_hapus').val(id_detail);
      $('#id_barang_hapus').val(id_barang);
    }

    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
         $("#alert").slideUp(300);
    });

    $("#data_Table").DataTable({
      "scrollX": true,
     "columnDefs": [
        { "width": "15%", "targets": 6},
        { "width": "5%", "targets": 0},
        { "width": "10%", "targets": 7}
      ],
    });


    $('.btn_sn').click(function(){
      var get_qty = document.getElementById("qty_total").value;
      document.getElementById("qtys").value = get_qty; 

      var get_barangs = document.getElementById("id_barangs").value;
      document.getElementById("sn_barang").value = get_barangs; 

      $("#modal-sn").modal("show");
    });

    $(document).on('click', '.btn-sn', function(e){
      var get_qty = document.getElementById("qty_total").value;
      document.getElementById("qtys").value = get_qty; 

      var qty           = $('#qtys').val()
      var lines         = $('#serial_number').val().split('\n');
      var sn            = lines.length;

      if (sn == qty) {
        $.ajax({
          type:"POST",
          url:'/update_serial_number',
          data:$('#sn-modal').serialize(),
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
      } else if (sn == 0) {
        alert('Jumlah tidak sesuai !')
      } else{
        alert('Jumlah tidak sesuai !')
      }
      
    });

    $(document).on('keyup keydown', ".serial_number", function(e){
      $("#btn-sn").prop('disabled', false);

    });

  </script>
@endsection