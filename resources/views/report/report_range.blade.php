@extends('template.template_admin-lte')
@section('content')
<!-- bootstrap datepicker -->

  <style type="text/css">
    .btn-warning-export{
      background-color: #ffc107;
      border-color: #ffc107;
    }
  </style>

  <section class="content-header">
    <h1>
      Report Range
    </h1>
    <ol class="breadcrumb">
      <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Report Range</li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-header with-border">

          @if(Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position == 'MANAGER' || Auth::User()->id_division == 'SALES' || Auth::User()->id_division == 'TECHNICAL PRESALES')
          <div class="box-body">
            <tooltip title="Choose Date First" placement="top">
              <button class="btn btn-xs btn-warning float-right  margin-left-custom" id="btnSubmit" disabled onclick="exportPdf()"><i class="fa fa-cloud-download"></i>&nbsp&nbspExport</button>
            </tooltip>
           
            <select class="form-control float-right margin-left-custom" style="width: 200px" id="dropdown2">
            </select>
           
            <select class="form-control pull-right" style="margin-left: 20px;width: 200px" id="dropdown">
              <option >Select Option</option>
               <option value="customer">Customer</option>
               <option value="sales">Sales</option>
               <!-- <option value="territory">Territory</option> -->
               <option value="status">Status</option>
               <option value="priority">Priority</option>
               <option value="win">Win Probability</option>
            </select>

            {{-- <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input type="text" class="form-control pull-right" id="datepicker">
            </div> --}}

            <input type="text" id="enddate" class="form-control pull-right" style="width: 200px" placeholder="DD/MM/YYYY">  
            <p class="pull-right" style="margin-top: 5px">&nbspto&nbsp</p>
            <input type="text" id="startdate" class="form-control pull-right" style="width: 200px" placeholder="DD/MM/YYYY">

          </div>

          @endif

      </div>

      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped" style="border-collapse: noseparate !important;" id="data_all" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Lead ID</th>
                  <th>Customer</th>
                  <th>Opty Name</th>
                  <th>Create Date</th>
                  <th>Closing Date</th>
                  <th>Owner</th>
                  <th>Amount</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($lead as $data)
                <tr>
                  <td>{{ $data->lead_id }}</td>
                  <td>{{ $data->brand_name }}</td>
                  <td>{{ $data->opp_name }}</td>
                  <td>{!!substr($data->created_at,0,10)!!}</td>
                  <td>{{ $data->closing_date }}</td>
                  <td>{{ $data->name }}</td>
                  @if($data->amount != NULL)
                  <td><i  class="money">{{ $data->amount }},00</i></td>
                  @else
                  <td></td>
                  @endif
                  <td>
                    @if($data->result == '')
                      <label class="status-open">OPEN</label>
                    @elseif($data->result == 'SD')
                      <label class="status-sd">SD</label>
                    @elseif($data->result == 'TP')
                      <label class="status-tp">TP</label>
                    @elseif($data->result == 'WIN')
                      <label class="status-win">WIN</label>
                    @elseif($data->result == 'LOSE')
                      <label class="status-lose">LOSE</label>
                    @else
                      <label class="status-initial">INITIAL</label>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

@endsection

@section('script')
<script type="text/javascript" src="{{asset('js/jquery.mask.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/dataTables.fixedColumns.min.js')}}"></script>
<!-- bootstrap datepicker -->
<script src="{{asset('template2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>

<script type="text/javascript">

    $('#enddate').datepicker({
      autoclose: true
    })

    $('#startdate').datepicker({
      autoclose: true
    })  

  	var table = $('#data_all').DataTable( {
        "retrive" : true,
        // "scrollX": true,
        "order": [[ 0, "desc" ]],
        fixedColumns:   {
            leftColumns: 4
        },
    });

  $('.money').mask('000,000,000,000,000.00', {reverse: true});
  $("#dropdown2").on('change',function(){
   if($(this).find('option:selected').text()=="Select Option")
       $("#btnSubmit").attr('disabled',true)
   else
       $("#btnSubmit").attr('disabled',false)
  });
  var enableDisableSubmitBtn = function(){
     var startVal = $('#startdate').val().trim();
     var endVal = $('#enddate').val().trim();
     var disableBtn =  startVal.length == 0 ||  endVal.length == 0;
     $('#dropdown').attr('disabled',disableBtn);
  }
</script>

<script type="text/javascript"> 
  var url = {!! json_encode(url('/')) !!}

  function exportPdf() {
    type = encodeURI($("#dropdown").val())
    date_start = encodeURI(moment($("#startdate").datepicker("getDate")).format("YYYY-MM-DD HH:mm:ss"))
    date_end = encodeURI(moment($("#enddate").datepicker("getDate")).format("YYYY-MM-DD HH:mm:ss"))
    dropdown2 = encodeURI($("#dropdown2").val())
    myUrl = url+"/getCustomerbyDate2?type="+type+"&customer="+dropdown2+"&start="+date_start+"&end="+date_end
    location.assign(myUrl)
  }
</script>
<script type="text/javascript">
function initselect(){
	$('.kat_drop').select2();
}
 
  $(document).ready(function(){
    $( "#startdate" ).datepicker({
       dateFormat: 'dd-mm-yy',
       onSelect: function(selected) {
          $("#enddate").datepicker("option","10/03/2015", selected);
          enableDisableSubmitBtn();
          }
    });
    $( "#startdate" ).change(function(){
      console.log($( "#startdate" ).datepicker("getDate"));
      console.log(moment($( "#startdate" ).datepicker("getDate")).format("YYYY-MM-DD HH:mm:ss"));
    });
    $( "#enddate" ).datepicker({
      dateFormat: 'dd-mm-yy' ,
      onSelect: function(selected) {
         $("#startdate").datepicker("option","09/04/2015", selected);
         enableDisableSubmitBtn();
        }
    });
    $( "#enddate" ).change(function(){
      console.log($( "#enddate" ).datepicker("getDate"));
      console.log(moment($( "#enddate" ).datepicker("getDate")).format("YYYY-MM-DD HH:mm:ss"));
    });

      $('#dropdown').change(function(){
          var type = this.value;
          $("#dropdown2").change(function(){
            console.log(this.value);
            $.ajax({
              type:"GET",
              url:"getCustomerbyDate",
              data:{
                customer:this.value,
                type:type,
                start:moment($( "#startdate" ).datepicker("getDate")).format("YYYY-MM-DD HH:mm:ss"),
                end:moment($( "#enddate" ).datepicker("getDate")).format("YYYY-MM-DD HH:mm:ss")
              },
              success: function(result){

              	$('#data_all').DataTable({
              	   "destroy": true,
  			        "lengthChange": false,
  			        "paging": false,
      		    });
              	
              
              	$("#data_all").find("tbody").empty();

                var table = "";

                $.each(result, function(key, value){
                  	if (value != null) {
	                  table = table + '<tr>';
	                  table = table + '<td>' +value.lead_id+ '</td>';
	                  table = table + '<td>' +value.brand_name+ '</td>';
	                  table = table + '<td>' +value.opp_name+ '</td>';
	                  table = table + '<td>' +value.created_at+ '</td>';
	                  table = table + '<td>' +value.closing_date+ '</td>';
	                  table = table + '<td>' +value.name+ '</td>';
	                  if (value.amount == null) {
	                    table = table + '<td>' +' '+ '</td>';
	                  }else{
	                    table = table + '<td>' +'<i class="money">'+value.amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")+'.00'+'</i>'+ '</td>';
	                  }
	                  
	                  if (value.result == 'OPEN') {
	                    table = table + '<td><label class="status-initial">INITIAL</label> </td>';
	                  } else if (value.result == '') {
	                    table = table + '<td><label class="status-open">OPEN</label> </td>';
	                  } else if (value.result == 'SD') {
	                    table = table + '<td><label class="status-sd">SD</label> </td>';
	                  } else if (value.result == 'TP') {
	                    table = table + '<td><label class="status-tp">TP</label> </td>';
	                  } else if (value.result == 'WIN') {
	                    table = table + '<td><label class="status-win">WIN</label> </td>';
	                  } else if (value.result == 'LOSE') {
	                    table = table + '<td><label class="status-lose">LOSE</label> </td>';
	                  }
	                  table = table + '</tr>';
                  	}else {
                  		table = table + '<tr>';
	                  		table = table + '<td>' + ' Not found Data ! ' + '</td>';
	                  	table = table + '</tr>';
	                  
              		}

                });

                $('#data_all').find("tbody").append(table);
                
              },
            });
          });
          $.ajax({
              type:"GET",
              url:"client",
              data:{
                id_client:this.value,
              },
              success: function(result){
                var append = "";
                $('#dropdown2').html(append)
                var append = "<option selected='selected' class='kat_drop'>Select Option</option>";

                if (result[1] == 'customer') {
                $.each(result[0], function(key, value){
                  append = append + "<option>" + value.brand_name + "</option>";
                });
                } else if (result[1] == 'sales') {
                  $.each(result[0], function(key, value){
                  append = append + "<option>" + value.name + "</option>";
                });
                } else if (result[1] == 'status') {
                  var status = [null,'SD', 'TP', 'WIN','LOSE'];
                  console.log(status);
                  $.each(status, function(key, value){
                  console.log(value);
                    if (value == null) {
                      append = append + "<option>" + 'OPEN' + "</option>";
                    }else{
                      append = append + "<option>" + value + "</option>";
                    }
                });
                } else if (result[1] == 'priority') {
                  var prio = ['Contribute', 'Fight', 'Foot Print', 'Guided'];
                  // console.log(prio);
                $.each(prio, function(key, value){
                  console.log(value);
                  append = append + "<option>" + value + "</option>";
                });
                } else if (result[1] == 'win') {
                  var win = ['LOW', 'MEDIUM', 'HIGH'];
                  // console.log(win);
                $.each(win, function(key, value){
                  console.table(value);
                  append = append + "<option>" + value + "</option>";
                });
                }
                $('#dropdown2').html(append);
              },
          });
      });
  });

</script>
@endsection