@extends('template.template_admin-lte')
@section('content')
<style type="text/css">
  input[type=number]::-webkit-inner-spin-button, 
  input[type=number]::-webkit-outer-spin-button { 
    -webkit-appearance: none; 
    margin: 0; 
  }
</style>

<section class="content-header">
  <h1>
    Return Product Delivery
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Warehouse</li>
    <li class="active">Delivery</li>
    <li class="active">Return</li>
  </ol>
</section>

<section class="content">
  

  <div class="box">
    <div class="box-header">
      
    </div>

    <div class="box-body">
      <form method="POST" action="{{url('store_return_delivery')}}" id="modal_pr_asset" name="modal_pr_asset">
        @csrf
          <legend>Return Product</legend>

            <div class="row">
              <div class="col-sm-12">
                <div class="form-group row" style="margin-left: -12px">
                  <label class="col-sm-1 control-label">Date</label>
                  <div class="col-sm-11">
                  	<input class="form-control" id="today" type="date" readonly>
                  </div>
                </div>
              </div>
            </div>
          <div style="overflow: scroll;">
            <table id="product-add" class="table table-border tab">
              <tr class="tr-header">
                <th width="300">MSP Code</th>
                <th width="300">Description</th>
                <th width="500">ID Project</th>
                <th width="100">Qty</th>
                <th width="100">Unit</th>
              </tr>
              <tr>
                <td style="margin-bottom: 50px;">
                  <br><select class="form-control searchid required" name="product[]" id="product" data-rowid="0" style="font-size: 14px">
                    <option>-- Select MSP Code --</option>
                    @foreach($msp_code as $data)
                        <option value="{{$data->id_product}}">{{$data->kode_barang}} - {{$data->nama}}</option>
                    @endforeach
                  </select>
                </td>
                <td hidden>    
                  <input type="" name="id_barangs[]" id="id_barangs" class="id_barangs" value="" data-rowid="0" hidden>
                </td>
                <td style="margin-bottom: 50px">
                  <br>
                  <textarea type="text" class="form-control name_barangs" data-rowid="0" name="name_product[]" id="information" readonly></textarea>
                </td>
                <td>
                	<br>
                	<select class="form-control searchid id_project" data-rowid="0" name="id_project[]" id="id_project"></select>
                </td>
                <td style="margin-bottom: 50px;">
                  <br>
                 <input type="number" class="form-control" placeholder="qty" name="qty[]" step="any" id="quantity" style="font-size: 14px" required="">
                </td>
                <td style="margin-bottom: 50px">
                  <br><input type="text" class="form-control unit" data-rowid="0" placeholder="Unit" name="unit[]" id="unit" readonly >
                </td>
              </tr>
            </table>
            <div class="col-md-12" id="btn_submit">
              <br>
              <button type="submit" class="btn btn-primary"><i class="fa fa-check"> </i>&nbspSubmit</button>
            </div>
          </div>
      </form>
    </div>
  </div>
</section>

@endsection
@section('script')
<script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
<script type="text/javascript">

	$('.searchid').select2();

	$(document).on('change',"select[id^='product']",function(e) { 
        var rowid = $(this).attr("data-rowid");
         $.ajax({
          type:"GET",
          url:'/dropdownQty',
          data:{
            product:this.value,
          },
          success: function(result){
            $.each(result[0], function(key, value){
              $(".name_barangs[data-rowid='"+rowid+"']").val(value.nama);
              $(".unit[data-rowid='"+rowid+"']").val(value.unit);
              // $(".id_project[data-rowid='"+rowid+"']").val(value.id_project);
            });

          }
        });

        $.ajax({
          type:"GET",
          url:'/dropdownidpro',
          data:{
            product:this.value,
          },
          success: function(result){
            $(".id_project[data-rowid='"+rowid+"']").html(append)
            var append = "<option>-- Select Option --</option>";
            $.each(result[0], function(key, value){
              append = append + "<option>" + value.id_project + "</option>";
            });

            $(".id_project[data-rowid='"+rowid+"']").html(append);
          }
        });
    });

	var i = 0;
    $('#addMore').click(function(){  
           i++;  
           $('#product-add').append('<tr id="row'+i+'"><td style="margin-bottom: 50px;"><br><select class="form-control searchid" name="product[]" id="product" data-rowid="'+i+'" style="font-size: 14px"><option>-- Select MSP Code --</option>@foreach($msp_code as $data)<option value="{{$data->id_product}}">{{$data->kode_barang}} - {{$data->nama}}</option>@endforeach</select></td><td hidden><input type="" name="id_barangs[]" id="id_barangs" class="id_barangs" value="" data-rowid="'+i+'" hidden></td><td style="margin-bottom: 50px"><br><textarea type="text" class="form-control name_barangs" data-rowid="'+i+'" name="name_product[]" id="information" readonly></textarea></td><td><br><select class="form-control searchid" name="id_project[]" id="id_project">@foreach($project_id as $data)<option value="{{$data->id_project}}">{{$data->id_project}}</option>@endforeach</select></td><td style="margin-bottom: 50px;"><br><input type="number" class="form-control" placeholder="qty" name="qty[]" id="quantity" step="any" style="font-size: 14px" ></td><td style="margin-bottom: 50px"><br><input type="text" class="form-control unit" data-rowid="'+i+'" placeholder="Enter unit" name="unit[]" id="unit" readonly ></td><td><a href="javascript:void(0);" id="'+i+'"class="remove"><span class="fa fa-times" style="font-size: 18px;color:red;margin-top: 25px"></span></a></td></tr>');
           initproduk();
    });

    function initproduk()
    {
      $('.searchid').select2();
    }

    $(document).on('click', '.remove', function() {
         var trIndex = $(this).closest("tr").index();
            if(trIndex>1) {
             $(this).closest("tr").remove();
           } else {
             alert("Sorry!! Can't remove first row!");
           }
    });

    $(".coba").keyup(function(){
    	var rowid = $(this).attr("data-rowid");
    	 $(".cobas[data-rowid='" + rowid + "']").val($(".coba[data-rowid='" + rowid + "']").val()).change();
    	console.log(rowid);
    })

	   let today = new Date().toISOString().substr(0, 10);
    document.querySelector("#today").value = today;
</script>
@endsection