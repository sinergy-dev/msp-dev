@extends('template.template_admin-lte')
@section('content')

  <section class="content-header">
    <h1>
      PO Asset Management - {{ $tampilkan->no_po }}
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Admin</li>
      <li class="active">PR Asset Management</li>
      <li class="active">Detail - {{ $tampilkan->no_po }}</li>
    </ol>
  </section>

  <section class="content">
    <a href="{{url('/po_asset_msp')}}"><button class="btn btn-sm btn-danger pull-left" style="width: 150px"><i class="fa fa-arrow-circle-o-left"></i>&nbspback to List PO Asset</button></a> <p>&nbsp</p>
      <br>
    <div class="box">

      <div class="box-header with-border">
        <h3 class="box-title">Purchase Order</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
          </div>
      </div>

      <div class="box-body">
        <div class="box-header with-border">
          <h6 class="box-title pull-left">{{$tampilkan->no_po}}</h6>
          <h6 class="box-title pull-right">{{$tampilkan->date_handover}}</h6>
        </div>
        <div class="box-body small">
          <h5 class="pull-right"></i>To  : {{$tampilkan->to_agen}}</h5><br>
          <div class="col-sm-12">
            <table class="table table-bordered table-striped" cellspacing="0" width="150%">
              <thead>
                <tr>
                  <th colspan="7" style="text-align: center;">LIST PRODUK</th>
                </tr>
                <tr>
                  <th>NO</th>
                  <th>MSP Code</th>
                  <th>Nama Produk</th>
                  <th>Qty</th>
                  <th>Qty Terima</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <input type="text" hidden name="id_po_asset" id="id_po_asset_status" value="{{$tampilkan->id_po_asset}}">
                <?php $no = 1;?>
                @foreach($produks as $data)
                <tr data-id="{{$data->id_product}}">
                  <td><input type="text" name="" class="transparant" value="{{$data->id_product}}" hidden>{{$no++}}</td>
                  <td>{{$data->kode_barang}}</td>
                  <td>{{$data->name_product}}</td>
                  <td>{{$data->qty_awal}}</td>
                  <td>{{$data->qty_terima}}</td>
                  <td>
                    @if($data->status_po == 'FINANCE' || $data->status_po == 'DONE' || $data->status_po == 'PENDING' || $count_po < 1)
                    <button class="btn btn-sm btn-primary disabled" style="width: 30px;height: 30px"><i class="fa fa-edit"></i></button>
                    @else
                    <button class="btn btn-sm btn-primary" data-target="#update_produk" onclick="produk('{{$data->id_product}}','{{$data->kode_barang}}','{{$data->qty_awal}}')" data-toggle="modal" style="width: 30px;height: 30px"><i class="fa fa-edit"></i></button>
                    @endif
                    @if($data->status_po == 'FINANCE' || $data->status_po == 'DONE' || $data->status_po == 'PENDING' || $count_po < 1)
                    <button style="width: 30px;height: 30px" class="btn btn-sm btn-danger disabled"><i class="fa fa-trash"></i></button></a>
                    @else
                    <a href="{{ url('delete_produk_po_msp?id_product='. $data->id_product) }}"> <button style="width: 30px;height: 30px" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure want to delete this data? And this data is not used in other table')"><i class="fa fa-trash"></i></button></a>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @if($data->status_po == 'SAVED')
            <button class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal_publish" onclick="publish('{{$data->id_po_asset}}')" type="submit" >Publish</button>
            @else
            @endif
          </div>
        </div>
        <div class="card-body small bg-faded">
          <div class="media">
            <div class="media-body">
              <h4></i></h4>
              <h5></i></h5>
              <h6><b class="money"></b></h6>
              <h6></h6>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="modal fade" id="modal_publish" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          <form action="{{url('/publish_status')}}" method="POST">
            {!! csrf_field() !!}
            <input type="" name="id_po" id="id_po" hidden value="{{$tampilkan->id_po_asset}}">
            <div style="text-align: center;">
              <h3>Are you sure to Publish Data ?</h3>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal"><b>Close</b></button>
            <button class="btn btn-sm btn-success" type="submit"><b>Yes</b></button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="update_produk" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update Produk</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('/update_produk_po_msp')}}">
            @csrf
          <input type="" id="id_product_update" name="id_product_update" hidden>
          <div class="form-group">

            <div>
              <label for="sow">MSP Code</label>
              <input type="text" class="form-control" name="msp_code_update" id="msp_code_update" readonly>
            </div><br>

            <div>
              <label for="sow">Qty Awal</label>
              <input type="number" name="qty_awal" id="qty_awal" class="form-control" readonly>
            </div><br>

            <div>
              <label for="sow">Qty</label>
              <input type="number" name="qty_update" id="qty_update" class="form-control">
            </div><br>
           
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
          <input type="" id="no_return_hr" name="no_return_hr" >
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
            <form method="POST" action="{{'/tambah_return_fnc_pr_asset'}}" id="modalProgress" name="modalProgress">
              @csrf
            <input type="" id="no_return_fnc" name="no_return_fnc" >
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

    function produk(id_product,kode_barang,qty_awal){
      $('#id_product_update').val(id_product);
      $('#msp_code_update').val(kode_barang);
      $('#qty_awal').val(qty_awal);
    }

     function return_hr(id_pam){
      $('#no_return_hr').val(id_pam);
     }

     function return_finance(id_pam){
      $('#no_return_fnc').val(id_pam);
     }

     function publish(id_po_asset) {
     	$('#id_po').val(id_po_asset);
     }
</script>
@endsection