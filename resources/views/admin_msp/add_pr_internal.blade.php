@extends('template.template_admin-lte')
@section('content')
<style type="text/css">

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  resize: vertical;
}

label {
  padding: 12px 12px 12px 0;
  display: inline-block;
}

.container-form {
  border-radius: 5px;
  background-color: #fff;
  padding: 20px;
  border-style: solid;
  border-color: rgb(212, 217, 219);
}

.col-25 {
  float: left;
  width: 25%;
  margin-top: 6px;
}

.col-75 {
  float: left;
  width: 75%;
  margin-top: 6px;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
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



input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}

.radios {
  display: block;
  position: relative;
  padding-left: 35px;
  margin-bottom: 12px;
  cursor: pointer;
  font-size: 14px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default radio button */
.radios input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

/* Create a custom radio button */
.checkmark {
  position: absolute;
  top: 0;
  left: 0;
  height: 25px;
  width: 25px;
  background-color: #0d1b33;
  border-radius: 50%;
}

/* On radiosmouse-over, add a grey background color */
.radios:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the radio button is checked, add a blue background */
.radios input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the indicator (the dot/circle - hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the indicator (dot/circle) when checked */
.radios input:checked ~ .checkmark:after {
  display: block;
}

/* Style the indicator (dot/circle) */
.radios .checkmark:after {
  top: 9px;
  left: 9px;
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background: white;
}
</style>

<section class="content-header">
  <h1>
    Add Purchase Request MSP
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">PR Asset</li>
    <li class="active">MSP</li>
    <li class="active">Add</li>
  </ol>
</section>

<section class="content">
  

  <div class="box">
    <div class="box-header">
      
    </div>

    <div class="box-body">
      <form method="POST" action="{{url('store_pr_msp')}}" id="modal_pr_asset" name="modal_pr_asset">
        @csrf
        <div class="row">

          <div class="col-sm-7">
            <legend>Purchase Request</legend>
          </div>


          <div class="col-sm-7">
            <input type="" value="internal" name="tipe_pr" hidden>
            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">To</label>
              <div class="col-sm-10">
                <input class="form-control" name="to" id="to" type="text" placeholder="Enter To">
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Description</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="description" id="description" type="text" placeholder="Enter Description"></textarea>
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Title</label>
              <div class="col-sm-10">
                <input type="text" name="title" id="title" class="form-control" placeholder="Enter Title">
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Attn.</label>
              <div class="col-sm-10">
                <input type="text" name="attention" id="attention" class="form-control" placeholder="Enter Attention" >
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-2 control-label">Subj.</label>
              <div class="col-sm-10">
                <textarea type="text" name="subject" id="subject" class="form-control" placeholder="Enter Subject" ></textarea>
              </div>
            </div> 
          </div>

          <div class="col-sm-5">
            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-4 control-label">Date</label>
              <div class="col-sm-8">
                <input class="form-control" id="today" name="date" type="date" >
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-4 control-label">Issuance</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" placeholder="Enter Issuance" name="issuance" id="issuance">
              </div>
            </div>

            <div class="form-group row" style="margin-left: -12px">
              <label class="col-sm-4 control-label">Project</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" placeholder="Enter Project" name="project" id="project" >
              </div>
            </div>
          </div>

          <div class="col-md-12"  id="btn_submit">
            <br>
            <button type="submit" class="btn btn-primary"><i class="fa fa-check"> </i>&nbspSubmit</button>
          </div>
        </div>
          
      </form>
    </div>
  </div>


</section>

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
  <script type="text/javascript" src="{{asset('js/jquery.mask.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/select2.min.js')}}"></script>
  <script type="text/javascript">
  	function showMe(e) {
	// i am spammy!
	  alert(e.value);
	}

    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
         $("#alert").slideUp(300);
    });


    $(".dismisbar").click(function(){
      $(".notification-bar").slideUp(300);
    });

    $('.hover-biru').click(function(){
      $('#add_id_pro').modal('show');
      // $("#munculkan").toggle("slow");
    })

    $("#id_project").select2();

    $('#owner_pr').select2();

    let today = new Date().toISOString().substr(0, 10);
    document.querySelector("#today").value = today;
  </script>
@endsection