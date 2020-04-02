@extends('template.template_admin-lte')
@section('content')

<script src="https://ajax.googleapis.com/ajax/lins/jqeury/1.12.0/jqeury.min.js"></script>
<script src="http://www.position-absolute.com/creation/print/jquery.printPage.js"></script>
<style type="text/css">
	textarea{
		white-space: pre-line; 
		white-space: pre-wrap
	}
	.alert-box {
    color:#555;
    border-radius:10px;
    font-family:Tahoma,Geneva,Arial,sans-serif;font-size:14px;
    padding:10px 36px;
    margin:10px;
	}
	.alert-box span {
	    font-weight:bold;
	    text-transform:uppercase;
	}
	.error {
	    background:#ffecec;
	    border:1px solid #f5aca6;
	}
	.success {
	    background:#e9ffd9 ;
	    border:1px solid #a6ca8a;
	}
	.form-control-medium{
	    display: block;
	    width: 60%;
	    padding: .375rem .75rem;
	    padding-top: 0.375rem;
	    padding-right: 0.75rem;
	    padding-bottom: 0.375rem;
	    padding-left: 0.75rem;
	    font-size: 1rem;
	    line-height: 1.5;
	    color: #495057;
	    background-color: #fff;
	    background-clip: padding-box;
	    border: 1px solid #ced4da;
	    border-radius: .40rem;
	    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
	}
	.form-control-produk{
	    display: block;
	    width: 140%;
	    padding: .375rem .75rem;
	    padding-top: 0.375rem;
	    padding-right: 0.75rem;
	    padding-bottom: 0.375rem;
	    padding-left: 0.75rem;
	    font-size: 1rem;
	    line-height: 1.5;
	    color: #495057;
	    background-color: #fff;
	    background-clip: padding-box;
	    border: 1px solid #ced4da;
	    border-radius: .40rem;
	    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
	}
	/*for modal*/
	  input[type=text]:focus{
	    border-color:dodgerBlue;
	    box-shadow:0 0 8px 0 dodgerBlue;
	  }

	  .modalIcon input[type=text]{
	    padding-left:40px;
	  }


	  .modalIcon.inputIconBg input[type=text]:focus + i{
	    color:#fff;
	    background-color:dodgerBlue;
	  }

	 .modalIcon.inputIconBg i{
	    background-color:#aaa;
	    color:#fff;
	    padding:7px 4px ;
	    border-radius:4px 0 0 4px;
	  }

	.modalIcon{
	    position:relative;
	  }

	 .modalIcon i{
	    position:absolute;
	    left:9px;
	    top:0px;
	    padding:9px 8px;
	    color:#aaa;
	    transition:.3s;
	  }


	  .newIcon input[type=text]{
	    padding-left:34px;
	  }

	  .newIcon.inputIconBg input[type=text]:focus + i{
	    color:#fff;
	    background-color:dodgerBlue;
	  }

	 .newIcon.inputIconBg i{
	    background-color:#aaa;
	    color:#fff;
	    padding:6px 6px ;
	    border-radius:4px 0 0 4px;
	  }

	.newIcon{
	    position:relative;
	  }

	 .newIcon i{
	    position:absolute;
	    left:0px;
	    top:34px;
	    padding:9px 8px;
	    color:#aaa;
	    transition:.3s;
	  }
</style>

<section class="content-header">
  <h1>
    Purchase Order Asset Management
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Admin</li>
    <li class="active">Purchase Order Asset Management</li>
  </ol>
</section>
  
<section class="content">

  @if(session('success'))
    <div class="alert alert-primary" id="alert">
      {{ session('success') }}
    </div>
  @elseif(session('update_handover'))
    <div class="alert alert-warning" id="alert">
      {{ session('update_handover') }}
    </div>
  @endif

  <div class="box">
    <div class="box-header with-border">
      @if(Auth::User()->id_position == 'ADMIN' || Auth::User()->email == 'budigunawan@solusindoperkasa.co.id')
        <div class="pull-right">
          <!-- <a href="{{url('/add_pam')}}"> -->
            <a href="{{url('/add_po_asset_msp')}}"><button class="btn btn-sm btn-success pull-right float-right margin-left-custom" id="btn-po"><i class="fa fa-plus"> </i>&nbsp PO Asset</button></a>
          <!-- </a> -->
          <!-- <button type="button" class="btn btn-warning-eksport dropdown-toggle float-right  margin-left-customt" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <b><i class="fa fa-download"></i> Export</b>
          </button>
          <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 30px, 0px);">
            <a class="dropdown-item" href="{{action('PAMController@downloadPDF')}}"> PDF </a>
            <a class="dropdown-item" href="{{action('PAMController@exportExcel')}}"> EXCEL </a>
          </div> 	 -->
        </div>
      @endif
    </div>

    <div class="box-body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped" id="datasmu" width="100%" cellspacing="0">
          <thead>
            <tr>
              <!-- <th>No.</th> -->
              <th hidden>ID PAM</th>
              <th>No. Purchase Request</th>
              <th>No. Purchase Order</th>
              <th>Created Date</th>
              <th>To</th>
              <th>Project ID</th>
              <th>Action</th>
              <th>Status Kirim</th>
              <th>No. Invoice</th>
              <th>Status Invoice</th>
              <!-- <th>Action</th> -->
            </tr>
          </thead>
          <tbody id="products-list" name="products-list">
            <?php $no = 1; ?>

              @if(Auth::User()->id_position == 'ADMIN' || Auth::User()->email == 'budigunawan@solusindoperkasa.co.id' || Auth::User()->id_position == 'DIRECTOR' && Auth::User()->id_company == '2')
                {{-- @foreach($pam2 as $data)
                  <tr>
                    <td hidden>{{$data->id_po_asset}}</td>
                    <td>{{$data->no_pr}}</td>
                    @if($data->status_po == 'NEW')
                    <td>{{$data->no_po}}</td>
                    @elseif($data->status_po != 'NEW')
                    <td><a href="{{url('detail_po',$data->id_po_asset)}}">{{$data->no_po}}</a></td>
                    @endif
                    <td>{{$data->date_handover}}</td>
                    <td>{{$data->to_agen}}</td>
                    <td>PO Stock</td>
                    <!-- @if($data->term != NULL)
                    <td>
                    <a href="{{action('POAssetMSPController@downloadPDF2',$data->id_po_asset)}}" target="_blank"><button class="btn btn-md btn-info" style="width: 100%" id="btnprint"><b><i class="fa fa-print"></i> Print to PDF </b></button></a>
                    </td>
                    @elseif($data->term == NULL)
                    <td>
                    <button class="btn btn-md btn-info disabled" style="width: 100%"><b><i class="fa fa-print"></i> Print to EXCEL</b></button>	
                    </td>
                    @endif -->
                    <td>
                      @if($data->status_po == 'NEW' || $data->status_po == 'SAVED')
                      <a href="{{url('add_produk_po', $data->id_po_asset)}}"><button class="btn btn-success" style="width: 85px;text-align: center;"><i class="fa fa-plus"></i>&nbspProduct</button></a>
                      @else
                      <a href="{{url('/copy/do/msp',$data->id_transaction)}}"><button class="btn btn-sm btn-warning" style="width: 60px"><b><i class="fa fa-copy"></i>&nbspCopy</button></b></a>
                      @endif
                    </td>
                    @if($data->status_po == 'DONE')
                    <td><center><label class="status-win">DONE</label></center></td>
                    @elseif($data->status_po == 'PENDING')
                    <td><center><label class="status-open">PENDING</label></center></td>
                    @elseif($data->status_po == 'NEW' || $data->status_po == 'SAVED')
                    <td><center><label class="status-sd">NEW</label></center></td>
                    @elseif($data->status_po == 'FINANCE')
                    <td><center><label class="status-tp" style="width: 100px;">ON PROCESS</label></center></td>
                    @endif
                    <td>{!! nl2br($data->no_invoice) !!}</td>
                    <!-- <td>{{$data->no_invoice}}</td> -->
                    <td>
                      @if($data->status_po == 'FINANCE' || $data->status_po == 'PENDING' || $data->status_po == 'DONE')
                      <center><button class="btn btn-success" data-toggle="modal" data-target="#add_invoice" id="btn_invoice" onclick="update_handover_invoice('{{ $data->id_po_asset }}')"><i class="fa fa-plus"></i>&nbspInvoice</button></center>
                      @else
                      <center><button class="btn btn-success disabled"  id="btn_invoice" ><i class="fa fa-plus"></i>&nbspInvoice</button></center>
                      @endif
                    </td>
                  </tr>
                @endforeach --}}
                @foreach($pam as $data)
                  <tr>
                    <td hidden>{{$data->id_po_asset}}</td>
                    <td>{{$data->no_pr}}</td>
                    @if($data->status_po == 'NEW')
                    <td>{{$data->no_po}}</td>
                    @elseif($data->status_po != 'NEW')
                    <td><a href="{{url('detail_po',$data->id_po_asset)}}">{{$data->no_po}}</a></td>
                    @endif
                    <td>{{$data->date_handover}}</td>
                    <td>{{$data->to_agen}}</td>
                    <td>{{$data->id_project}}</td>
                    <!-- @if($data->term != NULL)
                    <td>
                    <a href="{{action('POAssetMSPController@downloadPDF2',$data->id_po_asset)}}" target="_blank"><button class="btn btn-md btn-info" style="width: 100%" id="btnprint"><b><i class="fa fa-print"></i> Print to PDF </b></button></a>
                    </td>
                    @elseif($data->term == NULL)
                    <td>
                    <button class="btn btn-md btn-info disabled" style="width: 100%"><b><i class="fa fa-print"></i> Print to EXCEL</b></button>	
                    </td>
                    @endif -->
                    <td>
                      @if($data->status_po == 'NEW' || $data->status_po == 'SAVED')
                      <a href="{{url('add_produk_po', $data->id_po_asset)}}"><button class="btn btn-sm btn-success" style="width: 85px;text-align: center;"><i class="fa fa-plus"></i>&nbspProduct</button></a>
                      @else()
                      <a href="{{url('copy_po', $data->id_po_asset)}}"><button class="btn btn-sm btn-warning" style="width: 60px"><b><i class="fa fa-copy"></i>&nbspCopy</b></button></a>
                      @endif
                    </td>
                    @if($data->status_po == 'DONE')
                    <td><center><label class="status-win">DONE</label></center></td>
                    @elseif($data->status_po == 'PENDING')
                    <td><center><label class="status-open">PENDING</label></center></td>
                    @elseif($data->status_po == 'NEW' || $data->status_po == 'SAVED')
                    <td><center><label class="status-sd">NEW</label></center></td>
                    @elseif($data->status_po == 'FINANCE')
                    <td><center><label class="status-tp" style="width: 100px;">ON PROCESS</label></center></td>
                    @endif
                    <td>{!! nl2br($data->no_invoice) !!}</td>
                    <!-- <td>{{$data->no_invoice}}</td> -->
                    <td>
                      @if($data->status_po == 'FINANCE' || $data->status_po == 'PENDING' || $data->status_po == 'DONE')
                      <center><button class="btn btn-sm btn-success" data-toggle="modal" data-target="#add_invoice" id="btn_invoice" onclick="update_handover_invoice('{{ $data->id_po_asset }}')"><i class="fa fa-plus"></i>&nbspInvoice</button></center>
                      @else
                      <center><button class="btn btn-sm btn-success disabled"  id="btn_invoice" ><i class="fa fa-plus"></i>&nbspInvoice</button></center>
                      @endif
                    </td>
                  </tr>
                @endforeach
              @endif
          </tbody>
          <tfoot>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</section>

  <div class="modal fade" id="add_invoice" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Add Invoice</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('/update_handover_invoice_po_msp')}}">
            @csrf
          <div class="form-group">
            <label>Invoice Number</label>
            <textarea id="invoice_number" name="invoice_number" class="form-control"></textarea>
            <input type="text" id="id_invoice_po" name="id_invoice_po" hidden>
          </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i>&nbspClose</button>
              <button type="submit" class="btn btn-success btn-sm" style="width: 150px"><i class="fa fa-check"></i>&nbsp Update_handover</button>
            </div>
        </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="update_handover_po" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Update_handover Purchase Order</h4>
        </div>
        <div class="modal-body">
          <form method="POST" action="{{url('/update_handover_term_po_msp')}}" id="modalProgress" name="modalProgress">
            @csrf
          <div class="form-group">
            <input type="" id="id_pam" name="id_pam" class="form-control">
          </div>
          <div class="form-group">
            <label for="sow">Terms & Condition</label>
            <textarea name="term_edit" id="term_edit" class="form-control" required=""></textarea>
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


  <div class="modal fade" id="add_po" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Form Add PO</h4>
        </div>
        <form method="" action="" id="store_po" name="store_lead">
          @csrf
          <div class="modal-body">
            <div class="form-group">
              <label>No. Purchase Request</label>
              <select name="pr_number" id="pr-number" class="form-control" style="width: 850px;">
                <option value="">-- Select Purchase Request --</option>
                @foreach($datas as $data)
                <option style="margin-top: 20px;" value="{{$data->id_pam}}">{{$data->no_pr}} - {{$data->subject}}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <table class="table table-bordered">
                <thead>
                <tr>
                  <th rowspan="2" style="text-align: center;vertical-align:center;">No PR</th>
                  <th rowspan="2" style="text-align: center;vertical-align:center;">Subject</th>
                  <th rowspan="2" style="text-align: center;vertical-align:center;">To</th>
                  <th rowspan="2" style="text-align: center;vertical-align:center;">Terms and Condition</th>
                </tr>
                </thead>
                <tbody id="mytable">
                  
                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer">
            <table class="">
                <tbody id="footer-table">
                  
                </tbody>
            </table>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection

@section('script')
<script type="text/javascript" src="{{asset('js/jquery.mask.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
<script src="https://rawgit.com/jackmoore/autosize/master/dist/autosize.min.js"></script>
<script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
<script type="text/javascript">
  	  $('#datasmu').DataTable({
          // "scrollX": true,
          "order": [[ 6, "desc" ]],
          pageLength:25,
        });

      $('.money').mask('000,000,000,000,000', {reverse: true});

      function update_handover_po(id_po_asset,term){
        $('#id_pam').val(id_po_asset);
        $('#term_edit').val(term);
      }

      function update_handover_invoice(id_po_asset){
        $('#id_invoice_po').val(id_po_asset);
      }

      $("#alert").fadeTo(2000, 500).slideUp(500, function(){
       $("#alert").slideUp(300);
      });  

      $(document).ready(function(){
        $("#btnprint").printPage();
      });

      $(document).on('click', '.btn-submit', function(e){
      $.ajax({
            type:"POST",
            url:'/update_handover_term_po_msp',
            data:$('#store_po').serialize(),
            success: function(result){
                swal({
                    title: "Success!",
                    text:  "You have been Update_handover Purchase Order",
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

      $('#pr-number').select2();

      $('#pr-number').on('change', function(e){
        console.log($('#pr-number').val());
        var no_pr = $('#pr-number').val();

        $.ajax({
          type:"GET",
          url:'/dropdownPR?no_pr=' + no_pr,
          data:{
            no_pr:this.value,
          },
          success:function(result) {
            $('#mytable').empty();

            var table = "";

            $.each(result[0], function(key, value){
              table = table + '<tr>';
                table = table + '<td >' +'<input type="text" name="no_pr" style="width:80px" class="transparant" value="'+value.no_pr+'" readonly>'+ '</td>';
                table = table + '<td >' +'<input type="text" name="subject" class="transparant" style="width:120px" value="'+value.subject+'" readonly>'+ '</td>';
                table = table + '<td >' +'<input type="text" name="to_agen" class="transparant" style="width:170px" value="'+value.to_agen+'" readonly>'+ '</td>';
                table = table + '<td >' +'<textarea class="transparant" style="width:400px;" name="term">'+value.term+'</textarea>'+ '</td>';
                table = table + '<td hidden>' +'<input type="text" name="id_pam" class="" value="'+value.id_pam+'" readonly>'+ '</td>';
                table = table + '<td hidden>' +'<input type="text" name="id_po_asset" class="" value="'+value.id_po_asset+'" readonly>'+ '</td>';
              table = table + '</tr>';
            });
            $('#mytable').append(table);
          }
        });
      });

      $('#pr-number').on('change',function(e){
      console.log($('#pr-number').val());
      var no_pr = $('#pr-number').val();

      $.ajax({
          type:"GET",
          url:'/dropdownSubmitPR?no_pr=' + no_pr,
          data:{
            no_pr:this.value,
          },
          success: function(result){
            $('#footer-table').empty();

            var table = "";

            /*table = table + '<tr>';
            table = table + '<td colspan="6" >'+'<button type="button" name="update_handover" class="btn-update_handover btn btn-sm btn-primary">&nbspSubmit</button>'+ '<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-left:5px"><i class=" fa fa-times"></i>&nbspClose</button>'+ '</td>';
            table = table + '</tr>';*/

            table = table + '<tr>';
            table = table + '<td colspan="6" >'+'<input type="button" name="update_handover" id="btn-submit" class="btn-submit btn btn-sm btn-warning" value="Submit" />'+ '<button type="button" class="btn btn-default" data-dismiss="modal" style="margin-left:5px"><i class=" fa fa-times"></i>&nbspClose</button>'+ '</td>';
            table = table + '</tr>';

            $('#footer-table').append(table);
             
          }
      });
    });

</script>
@endsection

