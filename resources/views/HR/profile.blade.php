@extends('template.template_admin-lte')
@section('content')

  <section class="content-header">
    <h1>
      Profile
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-user"></i> User Profile</a></li>
    </ol>
  </section>

  <section class="content">
    <div class="box">
      <div class="box-body">
        @if (session('success'))
          <div class="alert-box notice">
              {{ session('success') }}
          </div>
        @endif
        <div class="row">
          <div class="col-md-12 col-xs-12">
            <div class="photos-profile pull-left">
              @if(Auth::User()->gambar == NULL)
                <img class="profile-user img-responsive" src="https://www.mycustomer.com/sites/all/modules/custom/sm_pp_user_profile/img/default-user.png" alt="Yuki" style="width: 100%;height:275px;position: relative;">
              @elseif(Auth::User()->gambar != NULL)
                <img class="profile-user img-responsive" src="{{ asset('image/'.$user_profile->gambar)}}" alt="Avatar" style="border:solid white;" data-toggle="modal" data-target="#pict_profile" onclick="nik_profile('{{$user_profile->nik}}')">
              @endif
            </div>
            <div class="pull-left">
              <div class="profile">
                <h1>{{$user_profile->name}}</h1>
                @if(Auth::User()->id_division == 'SALES' && Auth::User()->id_territory != ''  || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_territory == 'DVG' || Auth::User()->id_territory == 'DPG') 
                <h6><b>{{$user_profile->name_division}} {{$user_profile->name_territory}} {{$user_profile->name_position}}</b></h6>
                @elseif(Auth::User()->id_division == 'TECHNICAL')
                <h6><b>{{$user_profile->name_division}} {{$user_profile->name_position}}</b></h6>
                @elseif(Auth::User()->id_division == 'TECHNICAL PRESALES')
                <h6><b>{{$user_profile->name_division}} {{$user_profile->name_position}}</b></h6>
                @elseif(Auth::User()->id_division == 'PMO')
                <h6><b>{{$user_profile->name_division}} {{$user_profile->name_position}}</b></h6>
                @elseif(Auth::User()->id_division == 'FINANCE')
                <h6><b>{{$user_profile->name_division}} {{$user_profile->name_position}}</b></h6>
                @endif
                <h6 class="pull-left"><i class="fa fa-address-card"></i><b>&nbsp&nbsp {{$user_profile->nik}} </b></h6>
                <h6 class="pull-left"><i class="fa fa-envelope"></i><b>&nbsp&nbsp {{$user_profile->email}} </b></h6> 
                <h6 class="pull-left"><i class="fa fa-phone"></i><b>&nbsp&nbsp +62{{$user_profile->phone}} </b></h6>
              </div>
              <div class="pull-left">
                <button class="btn btn-md btn-primary btn-edit" type="button" style="width: 150px"><i class="fa fa-edit"></i> Update Profile</button>
                <a href="{{url('show_cuti')}}"><button class="btn btn-md btn-success" style="width: 150px"><i class="fa fa-user"></i> Leaving Permite</button></a>
                <div class="nav-tabs-custom" style="margin-top:50px">

                <ul class="nav nav-tabs">
                    <li class="active">
                      <a href="#about" data-toggle="tab">About</a>
                    </li>
                    <li>
                      <a href="" data-toggle="tab"></a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane active" id="about">
                    </div>
                    <div class="tab-pane" id="">
                    </div>
                </div>
              </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
  	        <!-- <div class="photos-profile">
  	            @if(Auth::User()->gambar == NULL)
  	              <img class="profile-user img-responsive" src="https://www.mycustomer.com/sites/all/modules/custom/sm_pp_user_profile/img/default-user.png" alt="Yuki" style="width: 100%;height:275px;position: relative;">
  	            @elseif(Auth::User()->gambar != NULL)
  	              <img class="profile-user img-responsive" src="{{ asset('image/'.$user_profile->gambar)}}" alt="Avatar" style="border:solid white;" data-toggle="modal" data-target="#pict_profile" onclick="nik_profile('{{$user_profile->nik}}')">
  	            @endif
  	        </div> -->

  	        <!-- <div class="photos">
  	          <div class="box-body">
  	            <table>
  	            <tr>
  	              <td><h4><b>{{$user_profile->name}}</b></h4></td>
  	            </tr>
  	            @if(Auth::User()->id_division == 'SALES' && Auth::User()->id_territory != ''  || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_territory == 'DVG' || Auth::User()->id_territory == 'DPG') 
  	            <tr>
  	              <td><b>{{$user_profile->name_division}}</b>&nbsp<b>{{$user_profile->name_territory}}</b></td>
  	            </tr>
  	            @elseif(Auth::User()->id_division == 'TECHNICAL')
  	            <tr><td><b>{{$user_profile->name_division}}</b></td></tr>
  	            @elseif(Auth::User()->id_division == 'TECHNICAL PRESALES')
  	            <tr><td><b>{{$user_profile->id_division}}</b></td></tr>
  	            @elseif(Auth::User()->id_division == 'PMO')
  	            <tr><td><b>{{$user_profile->name_division}}</b></td></tr>
  	            @elseif(Auth::User()->id_division == 'FINANCE')
  	            <tr><td><b>{{$user_profile->name_division}}</b></td></tr>
  	            @elseif(Auth::User()->id_division == 'SALES' && Auth::User()->id_teritory == '')
  	            <tr>
  	              <td><b>{{$user_profile->name_division}}</b>&nbsp<b>MSP</b></td>
  	            </tr>
  	            @endif
  	            <tr><td><b>{{$user_profile->name_position}}</b></td></tr>
  	          </table>
  	          </div>
  	        </div><br>
  	        <div class="kkk">
  	          <div class="box-body">
  	          <button class="btn btn-sm btn-primary margin-top btn-edit" type="button" style="width: 250px"><i class="fa fa-edit"></i> Edit Profile</button><br>
  	          <a href="{{url('/profile')}}"><button class="btn btn-sm btn-warning margin-top" style="width: 250px"><i class="fa fa-key"></i> Edit Password</button></a>
  	          @if(Auth::User()->id_position == 'EXPERT SALES' || Auth::User()->id_position == 'EXPERT ENGINEER')
  	          @else
  	          <a href="{{url('show_cuti')}}"><button class="btn btn-sm btn-success margin-top" style="width: 250px"><i class="fa fa-user"></i> Leaving Permite</button></a>
  	          @endif
  	          </div>
  	        </div> -->
	       
          </div>
<!-- 
          <div class="col-md-8">
            <div class="form-group">
              <div class="box">
                  <div class="box-header width-border">
                    <h2><u>About Me</u></h2>
                  </div>
                  <div class="card-body profile">
                    <h6><i class="fa fa-address-card"></i><b>&nbspNIK &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp {{$user_profile->nik}} </b></h6>
                    <h6><i class="fa fa-user"></i><b>&nbspName&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp {{$user_profile->name}} </b></h6>
                    <h6><i class="fa fa-envelope"></i><b>&nbspEmail &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp {{$user_profile->email}} </b></h6>
                    <h6 id="date_birth"><i class="fa fa-birthday-cake"></i><b>&nbspDate Of Birth &nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp {{date('d F Y', strtotime($user_profile->date_of_birth))}}</b></h6>
                    <h6 id="date_entry"><i class="fa fa-calendar"></i><b>&nbspDate Of Entry   &nbsp&nbsp:&nbsp&nbsp&nbsp {{date('d F Y', strtotime($user_profile->date_of_entry))}}</b></h6>
                    <h6><i class="fa fa-phone"></i><b>&nbspPhone &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp:&nbsp&nbsp&nbsp +62{{$user_profile->phone}} </b></h6>
                  </div>
                  </div>
            </div>
            
            <div class="form-group margin-top-profile">
             	
              	<div class="box">
                  <div class="box-header width-border">
                    <b><i>Company</i></b>
                  </div>
                  <div class="box-body">
                    @if(Auth::User()->id_company == '1')
                    © Sinergy Informasi Pratama.
                    @else
                    © Multi Solusindo Perkasa.
                    @endif
                  </div>
                </div>
                <div class="box">
  		            <div class="box-header width-border">
  		              <b><i>Social Media</i></b>
  		            </div>
  		            <div class="row">
  		              <div class="svg-wrapper" style="margin-left: 25px" >
  		                <svg height="60" width="60" xmlns="http://www.w3.org/2000/svg">
  		                  <rect class="shape" height="60" width="60" />
  		                  <div style="margin-top: -70px" class="logos">
  		                    <a href="https://twitter.com" class="fa fa-twitter icon" target="_blank" style="text-decoration: none"></a> 
  		                  </div>
  		                </svg>
  		              </div>
  		              <div class="svg-wrapper" style="margin-left:10px">
  		                <svg height="60" width="60" xmlns="http://www.w3.org/2000/svg">
  		                  <rect class="shape" height="60" width="60" />
  		                  <div style="margin-top: -70px" class="logos">
  		                    <a href="https://www.linkedin.com/" class="fa fa-linkedin icon" style="text-decoration: none" target="_blank"></a> 
  		                  </div>
  		                </svg>
  		              </div>
  		              <div class="svg-wrapper" style="margin-left: 15px">
  		                <svg height="60" width="60" xmlns="http://www.w3.org/2000/svg">
  		                  <rect class="shape" height="60" width="60" />
  		                  <div style="margin-top: -70px" class="logos">
  		                     <a href="https://www.instagram.com/" class="fa fa-instagram icon" target="_blank" style="text-decoration: none;"></a>
  		                  </div>
  		                </svg>
  		              </div>
  		              <div class="svg-wrapper" style="margin-left:10px">
  		                <svg height="60" width="60" xmlns="http://www.w3.org/2000/svg">
  		                  <rect class="shape" height="60" width="60" />
  		                  <div style="margin-top: -70px" class="logos">
  		                    <a href="https://www.facebook.com/" class="fa fa-facebook icon" target="_blank" style="text-decoration: none;"></a>
  		                  </div>
  		                </svg>
  		              </div>
  		            </div>
	        	    </div>
    	        	<div class="box">
                  <div class="box-header width-border">
                    <b><i>Games</i></b>
                  </div>
    	        		<div class="box-body">
                    <label>Tic Tac Toe</label><br>
                    <a href="#" class="modal_tic_tac_toe"><img src="https://cdn.iconscout.com/icon/premium/png-256-thumb/tic-tac-toe-7-725148.png" style="width: 10%;height: 10%"></a>
    	        		</div>
    	        	</div>
            </div>
          </div> -->

        </div>
      </div>
    </div>

    <!--modal tic tac toe-->
    <div class="modal fade" id="modal_tic">
  	<div class="modal-dialog modal-md">
  		<div class="modal-content">
  			<div class="modal-header">
  				<h4 class="modal-title">Tic Tac Toe</h4>
  			</div>
  			<div class="modal-body">
  				<div class="row">
  					<button onclick="initialize()" class="btn btn-sm btn-primary">Start Game</button>
  					<div class="col-md-6">
	  					<table id="table_game">
					      <tr><td class="td_game"><div id="cell0" onclick="cellClicked(this.id)" class="fixed"></div></td><td class="td_game"><div id="cell1" onclick="cellClicked(this.id)" class="fixed"></div></td><td class="td_game"><div id="cell2" onclick="cellClicked(this.id)" class="fixed"></div></td></tr>
					      <tr><td class="td_game"><div id="cell3" onclick="cellClicked(this.id)" class="fixed"></div></td><td class="td_game"><div id="cell4" onclick="cellClicked(this.id)" class="fixed"></div></td><td class="td_game"><div id="cell5" onclick="cellClicked(this.id)" class="fixed"></div></td></tr>
					      <tr><td class="td_game"><div id="cell6" onclick="cellClicked(this.id)" class="fixed"></div></td><td class="td_game"><div id="cell7" onclick="cellClicked(this.id)" class="fixed"></div></td><td class="td_game"><div id="cell8" onclick="cellClicked(this.id)" class="fixed"></div></td></tr>
						</table>
  					</div>
  					<div class="col-md-3">
  						<table>
					      <tr><th class="th_list">Computer</th><th class="th_list" style="padding-right:10px;padding-left:10px">Seri</th><th class="th_list">Player</th></tr>
					      <tr><td class="td_list" id="computer_score">0</td><td class="td_list" style="padding-right:10px;padding-left:10px" id="tie_score">0</td><td class="td_list" id="player_score">0</td></tr>
						</table>
						<button data-dismiss="modal" class="btn btn-sm btn-danger margin-top" style="width: 165px" onclick="selesai()">End Game</button>
  					</div>
  				</div>
  			</div>
  		</div>
  	</div>
  </div>

  <div class="modal fade" id="modalEdit" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title">Edit Profile</h4>
        </div>
        <div class="modal-body">
          <form method="POST" enctype="multipart/form-data" action="{{url('update_profile')}}" id="modalEditProfile" name="modalEditProfile">
            @csrf
            <input type="text" name="nik_profile" id="nik_profile" value="{{$user_profile->nik}}" hidden>

            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Type Name" value="{{$user_profile->name}}" required>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="text" class="form-control" id="email" name="email"  placeholder="Type Email" value="{{$user_profile->email}}" required>
            </div> 


            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" class="form-control float-right"required id="date_of_birth" name="date_of_birth" value="{{$user_profile->date_of_birth}}">
            </div> 

            <div class="form-group">
                <label class="margin-top">Date of Entry</label>
                <input type="date" class="form-control float-right "required id="date_of_entry" name="date_of_entry" value="{{$user_profile->date_of_entry}}">
            </div>             

            <div class="form-group profileInput inputIconBg">
                <label class="margin-top">Phone</label>
                <input type="number" class="form-control float-right" id="phone" name="phone" value="{{$user_profile->phone}}" onKeyPress="if(this.value.length==11) return false;" >
                <i class="" aria-hidden="true" >+62</i>
            </div>  

            <div class="form-group ">
              <label class="margin-top">Current Password</label>
              <input class="form-control" id="current-password" name="current-password" type="Password"  placeholder="Enter Your Current Password">
            </div>


            <div class="form-group">
              <label class="margin-top">New Password</label>
              <input class="form-control" id="new-password" name="new-password" type="Password" placeholder="Enter New Password">
            </div>

            <div class="form-group">
              <label class="margin-top">Confirm Password</label>
            <input class="form-control" id="new-password-confirm" name="new-password-confirm" type="Password" placeholder="Enter Confirm Password">
            </div>

            <div class="form-group">
              <label class="margin-top">Image</label>
              <div class="col s6">
                 <img src="{{ asset('image/'.$user_profile->gambar) }}" id="tes" style="max-width:100px;max-height:100px;float:left;" />
              </div>
                
              <div class="col-md-4">
                <input type="file" id="inputgambar" name="gambar" class="validate" / >
                <span class="help-block">*<b>Max 2MB</b></span>  
              </div>
            
            </div>      
             
            <div class="modal-footer">
              <button class="btn btn-default" data-dismiss="modal"><i class=" fa fa-times"></i>&nbspClose</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-check"> </i>&nbspSubmit</button>
            </div>
        </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="delete_pict" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content modal-md">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <form action="{{url('profile/delete_pict')}}" method="POST" hidden>
            {!! csrf_field() !!}
            <input type="" name="pick_nik" id="pick_nik" value="{{$user_profile->nik}}">
            <div style="text-align: center;">
              <h3>Are you sure?</h3><br><h3>DELETE PICTURE!</h3>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><b>Close</b></button>
            <button class="btn btn-sm btn-success-raise" type="submit"><b>Yes</b></button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="pict_profile" role="dialog">
    <div class="modal-dialog modal-md">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <form action="{{url('profile/delete_pict')}}" method="POST">
            {!! csrf_field() !!}
            <input type="" name="pick_nik" id="pick_nik" value="{{$user_profile->nik}}" hidden>
            <div style="text-align: center;">
              <h3>Are you sure?</h3><br><h3>DELETE PICTURE!</h3>
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"><b>Close</b></button>
            <button class="btn btn-sm btn-success-raise" type="submit"><b>Yes</b></button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div id="winAnnounce" class="modal modal_tic_tac">
	  <!-- Modal content -->
	  <div class="modal-content">
	    <span class="close" onclick="closeModal('winAnnounce')">&times;</span>
	    <p id="winText"></p>
	  </div>
  </div>
	<!-- The options dialog -->
	<div id="optionsDlg" class="modal modal_tic_tac">
	  <!-- Modal content -->
	  <div class="modal-content">
	    <h2>How would you like to play?</h2>
	      <h3>Difficulty:</h3>
	      <label><input type="radio" name="difficulty" id="r0" value="0">easy&nbsp;</label>
	      <label><input type="radio" name="difficulty" id="r1" value="1" checked>hard</label><br>
	      <h3>Play as:</h3>
	      <label><input type="radio" name="player" id="rx" value="x" checked>X (go first)&nbsp;</label>
	      <label><input type="radio" name="player" id="ro" value="o">O<br></label>
	      <p><button id="okBtn" onclick="getOptions()">Play</button></p>
	  </div>
	</div>

  </section>

@endsection

@section('script')

<style type="text/css">
  .alert-box {
      color:#555;
      border-radius:10px;
      font-family:Tahoma,Geneva,Arial,sans-serif;font-size:14px;
      padding:10px 36px;
      margin:10px;
  }

  .success {
      background:#e9ffd9 ;
      border:1px solid #a6ca8a;
  }

  .notice {
      background:#e3f7fc;
      border:1px solid #8ed9f6;
  }
  .modal_tic_tac_toe:hover{
    opacity: 0.8;   
  }

  .photos {
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    max-width: 300px;
    margin: auto;
    text-align: left;
    font-family: arial; 
    border-radius: 0%;
  }

  .photos-profile{
    position: relative;
    width: 250px;
    height: 250px;
    overflow: hidden;
    border-radius: 100%;
    border: solid white 9px;
  }

  .photos-profile img{
    width: 100%;
    height: auto;

  }

  

  .kkk {
    max-width: 300px;
    margin: auto;
    text-align: left;
    font-family: arial; 
    border-radius: 0%;
  }

  .margin-top-profile{
    margin-top: 5%;
  }

  .fa-twitter.icon {
  /*  background: #55ACEE;*/
    color: #55ACEE;
  }
  .fa-linkedin.icon {
    /*background: #007bb5;*/
    color: #007bb5;
  }
  .fa-instagram.icon {
    /*background: #e6005c;*/
    color: #e6005c;
  }
  .fa-facebook.icon {
 /*   background: #3333ff;*/
    color: #3333ff;
  }
  .icon {
    padding: 20px;
    font-size: 25px;
    width: 60px;
    height: 60px;
    text-align: center;
    text-decoration: none;
    margin: 5px 2px;
    border-radius: 50%;
  }
  .profile h6{
      position: relative;
      padding: 6px 12px 6px 0px;
      font-size: 16px;

      
  }
  .profile h6:nth-child(odd){
   
  }
  div div ol li a{
    font-size: 14px;
  }

  div div i{
    font-size: 14px;
  }

  .profileInput input[type=number]{
    padding-left:45px;
  }

  input[type=number]:focus{
    border-color:dodgerBlue;
    box-shadow:0 0 8px 0 dodgerBlue;
  }

 .profileInput.inputIconBg input[type=number]:focus + i{
    color:#fff;
    background-color:dodgerBlue;
  }

 .profileInput.inputIconBg i{
    background-color:#aaa;
    color:#fff;
    padding:8px 7px;
    border-radius:4px 0 0 4px;
  }

 .profileInput{
    position:relative;
  }

 .profileInput i{
    position:absolute;
    left:0;
    top:53px;
    padding:9px 8px;
    color:#aaa;
    transition:.3s;
  }
  .shape {
  stroke-dasharray: 30 30;
  stroke-dashoffset: -100;
  stroke-width: 8px;
  fill: transparent;
  stroke: #444 !important;
  border-bottom: 5px solid black;
  transition: stroke-width 1s, stroke-dashoffset 1s, stroke-dasharray 1s;
}
.svg-wrapper:hover .shape {
  stroke-width: 2px;
  stroke-dashoffset: 0;
  stroke-dasharray: 760;
}
.logos a:hover{
  color: grey!important;
}

#table_game {
    position: relative;
    font-size: 120px;
    margin: 1% auto;
    border-collapse: collapse;
}
.td_game {
    border: 4px solid rgb(230, 230, 230);
    width: 90px;
    height: 90px;
    padding: 0;
    vertical-align: middle;
    text-align: center;
}
.fixed {
    width: 90px;
    height: 90px;
    line-height: 90px;
    display: block;
    overflow: hidden;
    cursor: pointer;
}
.fixed {
    width: 90px;
    height: 90px;
    line-height: 90px;
    display: block;
    overflow: hidden;
    cursor: pointer;
}
.td_list {
    text-align: center;
    font-size: 1em;
    font-weight: bold;
}
.th_list {
    font-size: 1em;
    font-weight: bold;
    text-align: center;
    text-decoration: underline;
}
.x {
    color: darksalmon;
    position: relative;
    top: -8px;
    font-size: 1.2em;
    cursor: default;
}
.o {
    color: aquamarine;
    position: relative;
    top: -7px;
    font-size: 1.0em;
    cursor: default;
}
.win-color {
    background-color: rgb(240, 240, 240);
}


/* modal content */
.modal_tic_tac {
    background-color: rgb(240, 240, 240);
    color: rgb(32, 32, 32);
    font-size: 1em;
    font-weight: bold;
    /* 16 % from the top and centered */
    margin: 16% auto;
    padding: 20px;
    border: 2px solid black;
    border-radius: 10px;
    width: 380px;
    max-width: 80%;
}
.modal-content p {
    margin: 0;
    padding: 0;
}

</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript">
document.onkeypress = function (evt) {
  evt = evt || window.event;
  var modal = document.getElementsByClassName("modal")[0];
  if (evt.keyCode === 27) {
      modal.style.display = "none";
  }
};

// When the user clicks anywhere outside of the modal dialog, close it
window.onclick = function (evt) {
    var modal = document.getElementsByClassName("modal")[0];
    if (evt.target === modal) {
        modal.style.display = "none";
    }
};

//==================================
// HELPER FUNCTIONS
//==================================
function sumArray(array) {
    var sum = 0,
        i = 0;
    for (i = 0; i < array.length; i++) {
        sum += array[i];
    }
    return sum;
}

function isInArray(element, array) {
    if (array.indexOf(element) > -1) {
        return true;
    }
    return false;
}

function shuffleArray(array) {
    var counter = array.length,
        temp,
        index;
    while (counter > 0) {
        index = Math.floor(Math.random() * counter);
        counter--;
        temp = array[counter];
        array[counter] = array[index];
        array[index] = temp;
    }
    return array;
}

function intRandom(min, max) {
    var rand = min + Math.random() * (max + 1 - min);
    return Math.floor(rand);
}

// GLOBAL VARIABLES
var moves = 0,
    winner = 0,
    x = 1,
    o = 3,
    player = x,
    computer = o,
    whoseTurn = x,
    gameOver = false,
    score = {
        ties: 0,
        player: 0,
        computer: 0
    },
    xText = "<span class=\"x\">&times;</class>",
    oText = "<span class=\"o\">o</class>",
    playerText = xText,
    computerText = oText,
    difficulty = 1,
    myGrid = null;

//==================================
// GRID OBJECT
//==================================

// Grid constructor
//=================
function Grid() {
    this.cells = new Array(9);
}

// Grid methods
//=============

// Get free cells in an array.
// Returns an array of indices in the original Grid.cells array, not the values
// of the array elements.
// Their values can be accessed as Grid.cells[index].
Grid.prototype.getFreeCellIndices = function () {
    var i = 0,
        resultArray = [];
    for (i = 0; i < this.cells.length; i++) {
        if (this.cells[i] === 0) {
            resultArray.push(i);
        }
    }
    // console.log("resultArray: " + resultArray.toString());
    // debugger;
    return resultArray;
};

// Get a row (accepts 0, 1, or 2 as argument).
// Returns the values of the elements.
Grid.prototype.getRowValues = function (index) {
    if (index !== 0 && index !== 1 && index !== 2) {
        console.error("Wrong arg for getRowValues!");
        return undefined;
    }
    var i = index * 3;
    return this.cells.slice(i, i + 3);
};

// Get a row (accepts 0, 1, or 2 as argument).
// Returns an array with the indices, not their values.
Grid.prototype.getRowIndices = function (index) {
    if (index !== 0 && index !== 1 && index !== 2) {
        console.error("Wrong arg for getRowIndices!");
        return undefined;
    }
    var row = [];
    index = index * 3;
    row.push(index);
    row.push(index + 1);
    row.push(index + 2);
    return row;
};

// get a column (values)
Grid.prototype.getColumnValues = function (index) {
    if (index !== 0 && index !== 1 && index !== 2) {
        console.error("Wrong arg for getColumnValues!");
        return undefined;
    }
    var i, column = [];
    for (i = index; i < this.cells.length; i += 3) {
        column.push(this.cells[i]);
    }
    return column;
};

// get a column (indices)
Grid.prototype.getColumnIndices = function (index) {
    if (index !== 0 && index !== 1 && index !== 2) {
        console.error("Wrong arg for getColumnIndices!");
        return undefined;
    }
    var i, column = [];
    for (i = index; i < this.cells.length; i += 3) {
        column.push(i);
    }
    return column;
};

// get diagonal cells
// arg 0: from top-left
// arg 1: from top-right
Grid.prototype.getDiagValues = function (arg) {
    var cells = [];
    if (arg !== 1 && arg !== 0) {
        console.error("Wrong arg for getDiagValues!");
        return undefined;
    } else if (arg === 0) {
        cells.push(this.cells[0]);
        cells.push(this.cells[4]);
        cells.push(this.cells[8]);
    } else {
        cells.push(this.cells[2]);
        cells.push(this.cells[4]);
        cells.push(this.cells[6]);
    }
    return cells;
};

// get diagonal cells
// arg 0: from top-left
// arg 1: from top-right
Grid.prototype.getDiagIndices = function (arg) {
    if (arg !== 1 && arg !== 0) {
        console.error("Wrong arg for getDiagIndices!");
        return undefined;
    } else if (arg === 0) {
        return [0, 4, 8];
    } else {
        return [2, 4, 6];
    }
};

// Get first index with two in a row (accepts computer or player as argument)
Grid.prototype.getFirstWithTwoInARow = function (agent) {
    if (agent !== computer && agent !== player) {
        console.error("Function getFirstWithTwoInARow accepts only player or computer as argument.");
        return undefined;
    }
    var sum = agent * 2,
        freeCells = shuffleArray(this.getFreeCellIndices());
    for (var i = 0; i < freeCells.length; i++) {
        for (var j = 0; j < 3; j++) {
            var rowV = this.getRowValues(j);
            var rowI = this.getRowIndices(j);
            var colV = this.getColumnValues(j);
            var colI = this.getColumnIndices(j);
            if (sumArray(rowV) == sum && isInArray(freeCells[i], rowI)) {
                return freeCells[i];
            } else if (sumArray(colV) == sum && isInArray(freeCells[i], colI)) {
                return freeCells[i];
            }
        }
        for (j = 0; j < 2; j++) {
            var diagV = this.getDiagValues(j);
            var diagI = this.getDiagIndices(j);
            if (sumArray(diagV) == sum && isInArray(freeCells[i], diagI)) {
                return freeCells[i];
            }
        }
    }
    return false;
};

Grid.prototype.reset = function () {
    for (var i = 0; i < this.cells.length; i++) {
        this.cells[i] = 0;
    }
    return true;
};

//==================================
// MAIN FUNCTIONS
//==================================

// executed when the page loads
function initialize() {
    myGrid = new Grid();
    moves = 0;
    winner = 0;
    gameOver = false;
    whoseTurn = player; // default, this may change
    for (var i = 0; i <= myGrid.cells.length - 1; i++) {
        myGrid.cells[i] = 0;
    }
    // setTimeout(assignRoles, 500);
    setTimeout(showOptions, 500);
    // debugger;
}

// Ask player if they want to play as X or O. X goes first.
function assignRoles() {
    askUser("Do you want to go first?");
    document.getElementById("yesBtn").addEventListener("click", makePlayerX);
    document.getElementById("noBtn").addEventListener("click", makePlayerO);
}

function makePlayerX() {
    player = x;
    computer = o;
    whoseTurn = player;
    playerText = xText;
    computerText = oText;
    document.getElementById("userFeedback").style.display = "none";
    document.getElementById("yesBtn").removeEventListener("click", makePlayerX);
    document.getElementById("noBtn").removeEventListener("click", makePlayerO);
}

function makePlayerO() {
    player = o;
    computer = x;
    whoseTurn = computer;
    playerText = oText;
    computerText = xText;
    setTimeout(makeComputerMove, 400);
    document.getElementById("userFeedback").style.display = "none";
    document.getElementById("yesBtn").removeEventListener("click", makePlayerX);
    document.getElementById("noBtn").removeEventListener("click", makePlayerO);
}

// executed when player clicks one of the table cells
function cellClicked(id) {
    // The last character of the id corresponds to the numeric index in Grid.cells:
    var idName = id.toString();
    var cell = parseInt(idName[idName.length - 1]);
    if (myGrid.cells[cell] > 0 || whoseTurn !== player || gameOver) {
        // cell is already occupied or something else is wrong
        return false;
    }
    moves += 1;
    document.getElementById(id).innerHTML = playerText;
    // randomize orientation (for looks only)
    var rand = Math.random();
    if (rand < 0.3) {
        document.getElementById(id).style.transform = "rotate(180deg)";
    } else if (rand > 0.6) {
        document.getElementById(id).style.transform = "rotate(90deg)";
    }
    document.getElementById(id).style.cursor = "default";
    myGrid.cells[cell] = player;
    // Test if we have a winner:
    if (moves >= 5) {
        winner = checkWin();
    }
    if (winner === 0) {
        whoseTurn = computer;
        makeComputerMove();
    }
    return true;
}

// Executed when player hits restart button.
// ask should be true if we should ask users if they want to play as X or O
function restartGame(ask) {
    if (moves > 0) {
        var response = confirm("Are you sure you want to start over?");
        if (response === false) {
            return;
        }
    }
    gameOver = false;
    moves = 0;
    winner = 0;
    whoseTurn = x;
    myGrid.reset();
    for (var i = 0; i <= 8; i++) {
        var id = "cell" + i.toString();
        document.getElementById(id).innerHTML = "";
        document.getElementById(id).style.cursor = "pointer";
        document.getElementById(id).classList.remove("win-color");
    }
    if (ask === true) {
        // setTimeout(assignRoles, 200);
        setTimeout(showOptions, 200);
    } else if (whoseTurn == computer) {
        setTimeout(makeComputerMove, 800);
    }
}

// The core logic of the game AI:
function makeComputerMove() {
    // debugger;
    if (gameOver) {
        return false;
    }
    var cell = -1,
        myArr = [],
        corners = [0,2,6,8];
    if (moves >= 3) {
        cell = myGrid.getFirstWithTwoInARow(computer);
        if (cell === false) {
            cell = myGrid.getFirstWithTwoInARow(player);
        }
        if (cell === false) {
            if (myGrid.cells[4] === 0 && difficulty == 1) {
                cell = 4;
            } else {
                myArr = myGrid.getFreeCellIndices();
                cell = myArr[intRandom(0, myArr.length - 1)];
            }
        }
        // Avoid a catch-22 situation:
        if (moves == 3 && myGrid.cells[4] == computer && player == x && difficulty == 1) {
            if (myGrid.cells[7] == player && (myGrid.cells[0] == player || myGrid.cells[2] == player)) {
                myArr = [6,8];
                cell = myArr[intRandom(0,1)];
            }
            else if (myGrid.cells[5] == player && (myGrid.cells[0] == player || myGrid.cells[6] == player)) {
                myArr = [2,8];
                cell = myArr[intRandom(0,1)];
            }
            else if (myGrid.cells[3] == player && (myGrid.cells[2] == player || myGrid.cells[8] == player)) {
                myArr = [0,6];
                cell = myArr[intRandom(0,1)];
            }
            else if (myGrid.cells[1] == player && (myGrid.cells[6] == player || myGrid.cells[8] == player)) {
                myArr = [0,2];
                cell = myArr[intRandom(0,1)];
            }
        }
        else if (moves == 3 && myGrid.cells[4] == player && player == x && difficulty == 1) {
            if (myGrid.cells[2] == player && myGrid.cells[6] == computer) {
                cell = 8;
            }
            else if (myGrid.cells[0] == player && myGrid.cells[8] == computer) {
                cell = 6;
            }
            else if (myGrid.cells[8] == player && myGrid.cells[0] == computer) {
                cell = 2;
            }
            else if (myGrid.cells[6] == player && myGrid.cells[2] == computer) {
                cell = 0;
            }
        }
    } else if (moves === 1 && myGrid.cells[4] == player && difficulty == 1) {
        // if player is X and played center, play one of the corners
        cell = corners[intRandom(0,3)];
    } else if (moves === 2 && myGrid.cells[4] == player && computer == x && difficulty == 1) {
        // if player is O and played center, take two opposite corners
        if (myGrid.cells[0] == computer) {
            cell = 8;
        }
        else if (myGrid.cells[2] == computer) {
            cell = 6;
        }
        else if (myGrid.cells[6] == computer) {
            cell = 2;
        }
        else if (myGrid.cells[8] == computer) {
            cell = 0;
        }
    } else if (moves === 0 && intRandom(1,10) < 8) {
        // if computer is X, start with one of the corners sometimes
        cell = corners[intRandom(0,3)];
    } else {
        // choose the center of the board if possible
        if (myGrid.cells[4] === 0 && difficulty == 1) {
            cell = 4;
        } else {
            myArr = myGrid.getFreeCellIndices();
            cell = myArr[intRandom(0, myArr.length - 1)];
        }
    }
    var id = "cell" + cell.toString();
    // console.log("computer chooses " + id);
    document.getElementById(id).innerHTML = computerText;
    document.getElementById(id).style.cursor = "default";
    // randomize rotation of marks on the board to make them look
    // as if they were handwritten
    var rand = Math.random();
    if (rand < 0.3) {
        document.getElementById(id).style.transform = "rotate(180deg)";
    } else if (rand > 0.6) {
        document.getElementById(id).style.transform = "rotate(90deg)";
    }
    myGrid.cells[cell] = computer;
    moves += 1;
    if (moves >= 5) {
        winner = checkWin();
    }
    if (winner === 0 && !gameOver) {
        whoseTurn = player;
    }
}

// Check if the game is over and determine winner
function checkWin() {
    winner = 0;

    // rows
    for (var i = 0; i <= 2; i++) {
        var row = myGrid.getRowValues(i);
        if (row[0] > 0 && row[0] == row[1] && row[0] == row[2]) {
            if (row[0] == computer) {
                score.computer++;
                winner = computer;
                // console.log("computer wins");
            } else {
                score.player++;
                winner = player;
                // console.log("player wins");
            }
            // Give the winning row/column/diagonal a different bg-color
            var tmpAr = myGrid.getRowIndices(i);
            for (var j = 0; j < tmpAr.length; j++) {
                var str = "cell" + tmpAr[j];
                document.getElementById(str).classList.add("win-color");
            }
            setTimeout(endGame, 1000, winner);
            return winner;
        }
    }

    // columns
    for (i = 0; i <= 2; i++) {
        var col = myGrid.getColumnValues(i);
        if (col[0] > 0 && col[0] == col[1] && col[0] == col[2]) {
            if (col[0] == computer) {
                score.computer++;
                winner = computer;
                // console.log("computer wins");
            } else {
                score.player++;
                winner = player;
                // console.log("player wins");
            }
            // Give the winning row/column/diagonal a different bg-color
            var tmpAr = myGrid.getColumnIndices(i);
            for (var j = 0; j < tmpAr.length; j++) {
                var str = "cell" + tmpAr[j];
                document.getElementById(str).classList.add("win-color");
            }
            setTimeout(endGame, 1000, winner);
            return winner;
        }
    }

    // diagonals
    for (i = 0; i <= 1; i++) {
        var diagonal = myGrid.getDiagValues(i);
        if (diagonal[0] > 0 && diagonal[0] == diagonal[1] && diagonal[0] == diagonal[2]) {
            if (diagonal[0] == computer) {
                score.computer++;
                winner = computer;
                // console.log("computer wins");
            } else {
                score.player++;
                winner = player;
                // console.log("player wins");
            }
            // Give the winning row/column/diagonal a different bg-color
            var tmpAr = myGrid.getDiagIndices(i);
            for (var j = 0; j < tmpAr.length; j++) {
                var str = "cell" + tmpAr[j];
                document.getElementById(str).classList.add("win-color");
            }
            setTimeout(endGame, 1000, winner);
            return winner;
        }
    }

    // If we haven't returned a winner by now, if the board is full, it's a tie
    var myArr = myGrid.getFreeCellIndices();
    if (myArr.length === 0) {
        winner = 10;
        score.ties++;
        endGame(winner);
        return winner;
    }

    return winner;
}

function announceWinner(text) {
    document.getElementById("winText").innerHTML = text;
    document.getElementById("winAnnounce").style.display = "block";
    setTimeout(closeModal, 1400, "winAnnounce");
}

function askUser(text) {
    document.getElementById("questionText").innerHTML = text;
    document.getElementById("userFeedback").style.display = "block";
}

function showOptions() {
    if (player == o) {
        document.getElementById("rx").checked = false;
        document.getElementById("ro").checked = true;
    }
    else if (player == x) {
        document.getElementById("rx").checked = true;
        document.getElementById("ro").checked = false;
    }
    if (difficulty === 0) {
        document.getElementById("r0").checked = true;
        document.getElementById("r1").checked = false;
    }
    else {
        document.getElementById("r0").checked = false;
        document.getElementById("r1").checked = true;
    }
    document.getElementById("optionsDlg").style.display = "block";
}

function getOptions() {
    var diffs = document.getElementsByName('difficulty');
    for (var i = 0; i < diffs.length; i++) {
        if (diffs[i].checked) {
            difficulty = parseInt(diffs[i].value);
            break;
            // debugger;
        }
    }
    if (document.getElementById('rx').checked === true) {
        player = x;
        computer = o;
        whoseTurn = player;
        playerText = xText;
        computerText = oText;
    }
    else {
        player = o;
        computer = x;
        whoseTurn = computer;
        playerText = oText;
        computerText = xText;
        setTimeout(makeComputerMove, 400);
    }
    document.getElementById("optionsDlg").style.display = "none";
}

function closeModal(id) {
    document.getElementById(id).style.display = "none";
}

function endGame(who) {
    if (who == player) {
        announceWinner("Congratulations, you won!");
    } else if (who == computer) {
        announceWinner("Computer wins!");
    } else {
        announceWinner("Seri!");
    }
    gameOver = true;
    whoseTurn = 0;
    moves = 0;
    winner = 0;
    document.getElementById("computer_score").innerHTML = score.computer;
    document.getElementById("tie_score").innerHTML = score.ties;
    document.getElementById("player_score").innerHTML = score.player;
    for (var i = 0; i <= 8; i++) {
        var id = "cell" + i.toString();
        document.getElementById(id).style.cursor = "default";
    }
    setTimeout(restartGame, 800);
}

function selesai(){
	document.getElementById("computer_score").innerHTML = 0;
    document.getElementById("tie_score").innerHTML = 0;
    document.getElementById("player_score").innerHTML = 0; 
}

  $(".modal_tic_tac_toe").click(function(){
	$("#modal_tic").modal("show");
	console.log('coba');
  });

  $(".btn-edit").click(function(){
  	$("#modalEdit").modal("show");
  	console.log('coba');
  });

  function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
              $('#tes').attr('src', e.target.result);
          }

          reader.readAsDataURL(input.files[0]);
      }
  }

  $("#inputgambar").change(function () {
      readURL(this);
  });


  function nik_profile(nik){
    $("#nik_profile").val(nik);
    $("#pick_nik").val(nik);
  }

</script>
@endsection