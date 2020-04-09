<header class="main-header">
  <style type="text/css">
    .user-panel > .image > img {
    width: 100%;
    max-width: 45px;
    max-height: 40px;
    border-radius: 50%;
    position: relative;
    overflow: hidden;
    vertical-align: middle;
    }
    .profile-pic {
      border-radius: 50%;
      border: 0;
    }
  </style>

  <!-- Logo -->
  <a href="{{url('/')}}" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><img src="{{asset('../img/iconmsp2.png')}}" alt="cobaaa" width="30px" height="40px"></img></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>MSP</b>APP</span>
  </a>

  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">      
        
        <!-- Notifications: style can be found in dropdown.less -->
        <li class="dropdown notifications-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i>
            <span class="label label-warning"><small><i class="fa fa-fw fa-circle"></i></small></span>
          </a>
          <ul class="dropdown-menu">
            <li class="header">New Notifications:</li>
            <li>
              <!-- inner menu: contains the actual data -->
              <ul class="menu">
              </ul>
            </li>
            <li class="footer"><a href="#">View all</a></li>
          </ul>
        </li>
        {{-- @if(Auth::User()->id_position == 'HR MANAGER' || Auth::User()->id_position == 'ADMIN' || Auth::User()->id_division == 'FINANCE')
        <li class="dropdown notifications-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i>
            <span class="label label-warning"><small><i class="fa fa-fw fa-circle"></i></small></span>
          </a>
          <ul class="dropdown-menu">
            <li class="header">New Notifications:</li>
            <li>
              <ul class="menu">
                <li>
                  @foreach($notifClaim as $data)
                    @if(Auth::User()->id_position == 'ADMIN')
                      <a class="dropdown-item" href="{{ url('/esm') }}">
                        <span class="text-lose">
                          <strong>
                            <i class="fa fa-long-arrow-up fa-fw"></i>New Claim!</strong>
                            <br>
                        </span>
                        <span>
                          <strong hidden> {{ $data->nik_admin }} </strong>
                          <strong hidden> {{ $data->personnel }} </strong>
                          <strong> <i class="fa fa-circle"></i> {{ $data->type }} </strong>
                        </span><br>
                        <div class="dropdown-message small"></div>
                      </a>
                    @elseif(Auth::User()->id_position == 'HR MANAGER')
                      <a class="dropdown-item" href="{{ url('/esm') }}">
                        <span class="text-initial">
                          <strong>
                            <i class="fa fa-long-arrow-up fa-fw"></i>New Claim!</strong>
                            <br>
                        </span>
                        <span>
                          <strong hidden> {{ $data->nik_admin }} </strong>
                          <strong hidden> {{ $data->personnel }} </strong>
                          <strong> <i class="fa fa-circle"></i> {{ $data->type }} </strong>
                        </span><br>
                        <div class="dropdown-message small"></div>
                      </a>
                    @elseif(Auth::User()->id_division == 'FINANCE')
                      <a class="dropdown-item" href="{{ url('/esm') }}">
                        <span class="text-open">
                          <strong>
                            <i class="fa fa-long-arrow-up fa-fw"></i>New Claim!</strong>
                            <br>
                        </span>
                        <span>
                          <strong hidden> {{ $data->nik_admin }} </strong>
                          <strong hidden> {{ $data->personnel }} </strong>
                          <strong> <i class="fa fa-circle"></i> {{ $data->type }} </strong>
                        </span><br>
                        <div class="dropdown-message small"></div>
                      </a>
                    @endif
                  @endforeach
                </li>
              </ul>
            </li>
            <li class="footer"><a href="#">View all</a></li>
          </ul>
        </li>
        @elseif(Auth::user()->id_position != 'HR' && Auth::user()->id_position != 'ENGINEER' )
        <li class="dropdown notifications-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-bell-o"></i>
            <span class="label label-warning"><small><i class="fa fa-fw fa-circle"></i></small></span>
          </a>
          <ul class="dropdown-menu">
            <li class="header">New Notifications:</li>
            <li>
              <ul class="menu">
                <li>
                  @if(Auth::User()->id_territory != 'DVG')

                  @foreach($notif as $data)
	                  @if($data->nik == Auth::User()->nik && Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES')
	                  <a class="dropdown-item" href="{{ url('/project') }}">
	                    <span class="text-initial">
	                      <strong>
	                        <i class="fa fa-long-arrow-up fa-fw"></i>Created Lead Register</strong>
	                        <br>
	                    </span>
	                    <span>
	                      <strong hidden>{{$data->nik}}</strong>
	                      <strong> <i class="fa fa-circle"></i>&nbsp {!!substr($data->opp_name,0,18)!!}... </strong>
	                    </span><br>
	                    <div class="dropdown-message small"></div>
	                  </a>
	                  @elseif($data->nik == Auth::User()->nik && Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'SALES')
	                  <a class="dropdown-item" href="{{ url('/project') }}">
	                    <span class="text-initial">
	                      <strong>
	                        <i class="fa fa-long-arrow-up fa-fw"></i>Created Lead Register</strong>
	                        <br>
	                    </span>
	                    <span>
	                      <strong hidden>{{$data->nik}}</strong>
	                      <strong> <i class="fa fa-circle"></i>&nbsp {!!substr($data->opp_name,0,18)!!}... </strong>
	                    </span><br>
	                    <div class="dropdown-message small"></div>
	                  </a>
	                  @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES')
	                  <a class="dropdown-item" href="{{ url('/project') }}">
	                    <span class="text-initial">
	                      <strong>
	                        <i class="fa fa-long-arrow-up fa-fw"></i>Created Lead Register</strong>
	                        <br>
	                    </span>
	                    <span>
	                      <strong hidden>{{$data->nik}}</strong>
	                      <strong> <i class="fa fa-circle"></i>&nbsp {!!substr($data->opp_name,0,18)!!}... </strong>
	                    </span><br>
	                    <div class="dropdown-message small"></div>
	                  </a>
	                  @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL')
	                  <a class="dropdown-item" href="{{ url('/project') }}">
	                    <span class="text-initial">
	                      <strong>
	                        <i class="fa fa-long-arrow-up fa-fw"></i>Created Lead Register</strong>
	                        <br>
	                    </span>
	                    <span>
	                      <strong hidden>{{$data->nik}}</strong>
	                      <strong> <i class="fa fa-circle"></i>&nbsp {!!substr($data->opp_name,0,18)!!}... </strong>
	                    </span><br>
	                    <div class="dropdown-message small"></div>
	                  </a>
	                  @elseif(Auth::User()->id_position == 'DIRECTOR')
	                  <a class="dropdown-item" href="{{ url('/project') }}">
	                    <span class="text-initial">
	                      <strong>
	                        <i class="fa fa-long-arrow-up fa-fw"></i>Created Lead Register</strong>
	                        <br>
	                    </span>
	                    <span>
	                      <strong hidden>{{$data->nik}}</strong>
	                      <strong> <i class="fa fa-circle"></i>&nbsp {!!substr($data->opp_name,0,18)!!}... </strong>
	                    </span><br>
	                    <div class="dropdown-message small"></div>
	                  </a>
	                  @endif
                  @endforeach
                  
                  @foreach($notifOpen as $data)
	                    @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES')
	                      @if($data->nik == Auth::User()->nik)
	                        <a class="dropdown-item" href="{{url('detail_project',$data->lead_id)}}">
	                          <span class="text-open">
	                            <strong>
	                              <i class="fa fa-long-arrow-up fa-fw"></i>Open Status</strong>
	                              <br>
	                          </span>
	                          <span>
	                            <strong hidden>{{$data->nik}},{{$data->lead_id}}</strong>
	                            <strong> <i class="fa fa-circle"></i>&nbsp {!!substr($data->opp_name,0,18)!!}... </strong>
	                          </span><br>
	                          <div class="dropdown-message small"></div>
	                        </a>
	                      @endif
	                    @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'TECHNICAL PRESALES')
	                      @if($data->nik == Auth::User()->nik)
	                        <a class="dropdown-item" href="{{url('detail_project',$data->lead_id)}}">
	                          <span class="text-open">
	                            <strong>
	                              <i class="fa fa-long-arrow-up fa-fw"></i>Open Status</strong>
	                              <br>
	                          </span>
	                          <span>
	                            <strong hidden>{{$data->nik}},{{$data->lead_id}}</strong>
	                            <strong> <i class="fa fa-circle"></i>&nbsp {!!substr($data->opp_name,0,18)!!}... </strong>
	                          </span><br>
	                          <div class="dropdown-message small"></div>
	                        </a>
	                      @endif
	                    @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES')
	                      @if($data->nik == Auth::User()->nik)
	                        <a class="dropdown-item" href="{{url('detail_project',$data->lead_id)}}">
	                          <span class="text-open">
	                            <strong>
	                              <i class="fa fa-long-arrow-up fa-fw"></i>Open Status</strong>
	                              <br>
	                          </span>
	                          <span>
	                            <strong hidden>{{$data->nik}},{{$data->lead_id}}</strong>
	                            <strong> <i class="fa fa-circle"></i>&nbsp {!!substr($data->opp_name,0,18)!!}... </strong>
	                          </span><br>
	                          <div class="dropdown-message small"></div>
	                        </a>
	                      @endif
	                    @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'SALES')
	                      @if($data->nik == Auth::User()->nik)
	                        <a class="dropdown-item" href="{{url('detail_project',$data->lead_id)}}">
	                          <span class="text-open">
	                            <strong>
	                              <i class="fa fa-long-arrow-up fa-fw"></i>Open Status</strong>
	                              <br>
	                          </span>
	                          <span>
	                            <strong hidden>{{$data->nik}},{{$data->lead_id}}</strong>
	                            <strong><i  class="fa fa-circle"></i>&nbsp {!!substr($data->opp_name,0,18)!!}...</strong>
	                          </span><br>
	                          <div class="dropdown-message small"></div>
	                        </a>
	                      @endif
	                    @endif
                  @endforeach

                  @foreach($notifsd as $data)
	                    @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES')
	                      @if($data->nik == Auth::User()->nik)
	                        <a class="dropdown-item" href="{{url('detail_project',$data->lead_id)}}">
	                          <span class="text-sd">
	                            <strong>
	                              <i class="fa fa-long-arrow-up fa-fw"></i>Solution Design</strong>
	                              <br>
	                          </span>
	                          <span>
	                            <strong hidden>{{$data->nik}},{{$data->lead_id}}</strong>
	                            <strong> <i class="fa fa-circle"></i>&nbsp {!!substr($data->opp_name,0,18)!!}... </strong>
	                          </span><br>
	                          <div class="dropdown-message small"></div>
	                        </a>
	                      @endif
	                    @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'TECHNICAL PRESALES')
	                      @if($data->nik == Auth::User()->nik)
	                        <a class="dropdown-item" href="{{url('detail_project',$data->lead_id)}}">
	                          <span class="text-sd">
	                            <strong>
	                              <i class="fa fa-long-arrow-up fa-fw"></i>Solution Design</strong>
	                              <br>
	                          </span>
	                          <span>
	                            <strong hidden>{{$data->nik}},{{$data->lead_id}}</strong>
	                            <strong> <i class="fa fa-circle"></i>&nbsp {!!substr($data->opp_name,0,16)!!}... </strong>
	                          </span><br>
	                          <div class="dropdown-message small"></div>
	                        </a>
	                      @endif
	                    @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES')
	                      @if($data->nik == Auth::User()->nik)
	                        <a class="dropdown-item" href="{{url('detail_project',$data->lead_id)}}">
	                          <span class="text-sd">
	                            <strong>
	                              <i class="fa fa-long-arrow-up fa-fw"></i>Solution Design</strong>
	                              <br>
	                          </span>
	                          <span>
	                            <strong hidden>{{$data->nik}},{{$data->lead_id}}</strong>
	                            <strong> <i class="fa fa-circle"></i>&nbsp {!!substr($data->opp_name,0,18)!!}... </strong>
	                          </span><br>
	                          <div class="dropdown-message small"></div>
	                        </a>
	                      @endif
	                    @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'SALES')
	                      @if($data->nik == Auth::User()->nik)
	                        <a class="dropdown-item" href="{{url('detail_project',$data->lead_id)}}">
	                          <span class="text-sd">
	                            <strong>
	                              <i class="fa fa-long-arrow-up fa-fw"></i>Solution Design</strong>
	                              <br>
	                          </span>
	                          <span>
	                            <strong hidden>{{$data->nik}},{{$data->lead_id}}</strong>
	                            <strong> <i class="fa fa-circle"></i>&nbsp {!!substr($data->opp_name,0,16)!!}... </strong>
	                          </span><br>
	                          <div class="dropdown-message small"></div>
	                        </a>
	                      @endif
	                    @endif
                  @endforeach

                  @foreach($notiftp as $data)
	                    @if(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL PRESALES')
	                      @if($data->nik == Auth::User()->nik)
	                        <a class="dropdown-item" href="{{url('detail_project',$data->lead_id)}}">
	                          <span class="text-tp">
	                            <strong>
	                              <i class="fa fa-long-arrow-up fa-fw"></i>Tender Project</strong>
	                              <br>
	                          </span>
	                          <span>
	                            <strong hidden>{{$data->nik}},{{$data->lead_id}}</strong>
	                            <strong> <i class="fa fa-circle"></i>&nbsp {!!substr($data->opp_name,0,18)!!}... </strong>
	                          </span><br>
	                          <div class="dropdown-message small"></div>
	                        </a>
	                      @endif
	                    @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'TECHNICAL PRESALES')
	                      @if($data->nik == Auth::User()->nik)
	                        <a class="dropdown-item" href="{{url('detail_project',$data->lead_id)}}">
	                          <span class="text-tp">
	                            <strong>
	                              <i class="fa fa-long-arrow-up fa-fw"></i>Tender Project</strong>
	                              <br>
	                          </span>
	                          <span>
	                            <strong hidden>{{$data->nik}},{{$data->lead_id}}</strong>
	                            <strong> <i class="fa fa-circle"></i>&nbsp {!!substr($data->opp_name,0,16)!!}... </strong>
	                          </span><br>
	                          <div class="dropdown-message small"></div>
	                        </a>
	                      @endif
	                    @elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'SALES')
	                      @if($data->nik == Auth::User()->nik)
	                        <a class="dropdown-item" href="{{url('detail_project',$data->lead_id)}}">
	                          <span class="text-tp">
	                            <strong>
	                              <i class="fa fa-long-arrow-up fa-fw"></i>Tender Project</strong>
	                              <br>
	                          </span>
	                          <span>
	                            <strong hidden>{{$data->nik}},{{$data->lead_id}}</strong>
	                            <strong> <i class="fa fa-circle"></i>&nbsp {!!substr($data->opp_name,0,18)!!}... </strong>
	                          </span><br>
	                          <div class="dropdown-message small"></div>
	                        </a>
	                      @endif
	                    @elseif(Auth::User()->id_position == 'STAFF' && Auth::User()->id_division == 'SALES')
	                      @if($data->nik == Auth::User()->nik)
	                        <a class="dropdown-item" href="{{url('detail_project',$data->lead_id)}}">
	                          <span class="text-tp">
	                            <strong>
	                              <i class="fa fa-long-arrow-up fa-fw"></i>Tender Project</strong>
	                              <br>
	                          </span>
	                          <span>
	                            <strong hidden>{{$data->nik}},{{$data->lead_id}}</strong>
	                            <strong> <i class="fa fa-circle"></i>&nbsp {!!substr($data->opp_name,0,16)!!}... </strong>
	                          </span><br>
	                          <div class="dropdown-message small"></div>
	                        </a>
	                      @endif
	                    @endif
                  @endforeach

                  @endif
                </li>
              </ul>
            </li>
            <li class="footer"><a href="{{url('project')}}">View all</a></li>
          </ul>
        </li>
        @endif --}}



        <!-- Tasks: style can be found in dropdown.less -->
        <!-- <li class="dropdown tasks-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-flag-o"></i>
            <span class="label label-danger">9</span>
          </a>
          <ul class="dropdown-menu">
            <li class="header">You have 9 tasks</li>
            <li>
              <ul class="menu">
                <li>
                  <a href="#">
                    <h3>
                      Design some buttons
                      <small class="pull-right">20%</small>
                    </h3>
                    <div class="progress xs">
                      <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                           aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">20% Complete</span>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <h3>
                      Create a nice theme
                      <small class="pull-right">40%</small>
                    </h3>
                    <div class="progress xs">
                      <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                           aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">40% Complete</span>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <h3>
                      Some task I need to do
                      <small class="pull-right">60%</small>
                    </h3>
                    <div class="progress xs">
                      <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                           aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">60% Complete</span>
                      </div>
                    </div>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <h3>
                      Make beautiful transitions
                      <small class="pull-right">80%</small>
                    </h3>
                    <div class="progress xs">
                      <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                           aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">80% Complete</span>
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </li>
            <li class="footer">
              <a href="#">View all tasks</a>
            </li>
          </ul>
        </li> -->
        <!-- User Account: style can be found in dropdown.less -->
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            @if(Auth::User()->gambar == NULL)
              <img src="https://www.mycustomer.com/sites/all/modules/custom/sm_pp_user_profile/img/default-user.png" class="user-image" alt="Yuki">
            @else
              <img src="{{asset('image/'.Auth::User()->gambar)}}" class="user-image" alt="User Image">
            @endif
            <span class="hidden-xs">{{ Auth::User()->name }}</span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              {{-- <img src="{{asset('template2/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image"> --}}
              @if(Auth::User()->gambar == NULL)
                <img src="https://www.mycustomer.com/sites/all/modules/custom/sm_pp_user_profile/img/default-user.png" class="img-circle" alt="Yuki">
              @else
                <img src="{{asset('image/'.Auth::User()->gambar)}}" class="img-circle" alt="User Image">
              @endif

              <p>
                {{ Auth::User()->name }} - 
                @if(Auth::user()->id_division == 'HR' && Auth::user()->id_position == 'HR MANAGER')
                  {{ Auth::user()->id_position }}
                @elseif(Auth::user()->id_position == 'EXPERT SALES')
                  {{ Auth::user()->id_position}}
                @else
                  {{ Auth::user()->id_division }} {{ Auth::user()->id_position }}
                @endif
                <small>
                  @if(Auth::User()->id_company == '1') 
                    Sinergy Informasi Pratama
                  @else
                    Multi Solusindo Perkasa
                  @endif
                </small>
                <small>Member since {{ Auth::User()->date_of_entry }}</small>
              </p>
            </li>
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="{{url('profile_user')}}" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <!-- <a href="#" class="btn btn-default btn-flat">Sign out</a> -->
                <a class="btn btn-default btn-flat" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
              </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        {{-- <li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li> --}}
      </ul>
    </div>

  </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        @if(Auth::User()->gambar == NULL)
          <img src="https://www.mycustomer.com/sites/all/modules/custom/sm_pp_user_profile/img/default-user.png" class="img-circle" alt="Yuki">
        @else
          <img src="{{asset('image/'.Auth::User()->gambar)}}" class="user-image" alt="User Image">
        @endif
      </div>
      <div class="pull-left info">
        <p>{{ Auth::User()->name }}</p>
        <a href="#"><i class="fa fa-circle text-success"></i>@if(Auth::User()->id_division == 'TECHNICAL PRESALES')
        TECH. PRESALES @elseif(Auth::User()->id_division == 'TECHNICAL') TECH. @elseif(Auth::User()->id_division == 'HR') @else {{ Auth::user()->id_division }} @endif &nbsp {{ Auth::user()->id_position }} </a>
      </div>
    </div>
    <!-- search form -->
    <!-- <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                <i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form> -->
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      
      <li class="nav-item">
        <a class="nav-link" href="{{ url('/') }}">
          <i class="fa fa-fw fa-dashboard"></i>
          <span class="nav-link-text" style="font-size: 14px">Dashboard</span>
        </a>
      </li>
      @if(Auth::User()->id_territory == 'DVG' && Auth::User()->id_position != 'ADMIN')
      <li class="treeview activeable">
        <a href="#DVGPages" data-parent="#exampleAccordion">
          <i class="fa fa-fw fa-folder-open"></i>
          <span class="nav-link-text" style="font-size: 14px">DVG</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" id="DVGPages">
          <li>
            <a href="{{ url('/config_management') }}" style="font-size: 14px"><i class="fa fa-fw fa-circle-o"></i>Config Management</a>
          </li>
          <li>
            <a href="{{ url('/incident_management') }}" style="font-size: 14px"><i class="fa fa-fw fa-circle-o"></i>Incident Management</a>
          </li>
        </ul>
      </li>
      @endif




      @if(Auth::User()->id_division != 'PMO')
      <li class="treeview activeable">
      	<a href="#SalesMSP" data-parent="#exampleAccordion">
      		<i class="fa fa-fw fa-table"></i>
      		<span class="nav-link-text" style="font-size: 14px">Sales</span>
      		<span class="pull-right-container">
      			<i class="fa fa-angle-left pull-right"></i>
      		</span>
      	</a>
      	<ul class="treeview-menu" id="SalesMSP">
      		@if(Auth::User()->id_position == 'DIRECTOR')
      		<li>
      			<a href="{{url('/project')}}" style="font-size: 14px">Lead Register</a>
      		</li>
      		@elseif(Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL')
      		<li>
      			<a href="{{url('/project')}}" style="font-size: 14px">Lead Register</a>
      		</li>
      		@elseif(Auth::User()->id_division == 'MSM' && Auth::User()->id_position == 'MANAGER')
      		<li>
      			<a href="{{url('/project')}}" style="font-size: 14px">Lead Register</a>
      		</li>
      		@elseif(Auth::User()->id_division == 'SALES')
      		<li>
      			<a href="{{url('/project')}}" style="font-size: 14px">Lead Register</a>
      		</li>
			@elseif(Auth::User()->id_division == 'TECHNICAL PRESALES')
			<li>
      			<a href="{{url('/project')}}" style="font-size: 14px">Lead Register</a>
      		</li>
			@elseif(Auth::User()->id_division == 'FINANCE' && Auth::User()->id_position == 'MANAGER')
			<li>
      			<a href="{{url('/project')}}" style="font-size: 14px">Lead Register</a>
      		</li>
      		@endif

      		<!-- @if(Auth::User()->id_position != 'HR MANAGER')
      		<li>
      			<a href="{{url('/customer')}}" style="font-size: 14px">Customer Data</a>
      		</li>
      		@endif -->
      		@if(Auth::User()->id_company == '1')
      		<li>
      			<a href="{{url('/partnership')}}" style="font-size: 14px">Partnership</a>
      		</li>
      		@endif
      	</ul>
      </li>
      @endif




      
      <!-- @if(Auth::User()->id_division == 'PMO' && Auth::User()->id_position != 'ADMIN')
      <li class="nav-item">
        <a class="nav-link" href="{{url('/project')}}">
          <i class="fa fa-fw fa-book"></i>
          <span class="nav-link-text" style="font-size: 14px">Report</span>
        </a>
      </li>
      @elseif(Auth::User()->id_position == 'ENGINEER MANAGER' || Auth::User()->id_position == 'ENGINEER STAFF')
      <li class="nav-item">
        <a class="nav-link" href="{{url('/project')}}">
          <i class="fa fa-fw fa-book"></i>
          <span class="nav-link-text" style="font-size: 14px">Report</span>
        </a>
      </li>
      @endif -->
   
        @if(Auth::User()->id_company == '2' && Auth::User()->id_division != 'PMO')
        <li class="treeview activeable">
          <a href="#ADMINPages" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-folder"></i>
            <span class="nav-link-text" style="font-size: 14px">Admin</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" id="ADMINPages">
          	@if(Auth::User()->id_position == 'ADMIN' && Auth::User()->id_company == '2' || Auth::User()->email == 'budigunawan@solusindoperkasa.co.id')
            <li>
              <a href="{{url('/pr_msp')}}" style="font-size: 14px"></i>Purchase Request</a>
            </li>
            <li>
              <a href="{{url('/po_msp')}}" style="font-size: 14px;"></i>Purchase Order</a>
            </li>
            <li>
              <a href="{{url('/po_asset_msp')}}" style="font-size: 14px;"></i>PO Asset Management</a>
            </li>
            @elseif(Auth::User()->id_division == 'SALES' || Auth::User()->email == 'kasmiyati@solusindoperkasa.co.id')
            <li>
      			<a href="{{url('/quote')}}" style="font-size: 14px">Quotation</a>
      		</li>
      		@elseif(Auth::User()->id_division == 'TECHNICAL')
      		<li>
      			<a href="{{url('/quote')}}" style="font-size: 14px">Quotation</a>
      		</li>
      		@endif
          </ul>
        </li>
        <!-- <li class="nav-item">
	        <a class="nav-link" href="{{url('/money_req')}}">
	          <i class="fa fa-fw fa-book"></i>
	          <span class="nav-link-text" style="font-size: 14px">Money Request</span>
	        </a>
        </li> -->
        @if(Auth::User()->id_division != 'SALES')
        <li class="nav-item">
          <a class="nav-link" href="{{url('/inventory/do/msp')}}">
            <i class="fa fa-fw fa-folder-open"></i>
            <span class="nav-link-text" style="font-size: 14px">Delivery Order</span>
          </a>
        </li>
        @endif
      @endif

      <!-- @if(Auth::User()->email == 'budigunawan@solusindoperkasa.co.id')
      <li class="nav-item">
        <a class="nav-link" href="{{url('/po_asset_msp')}}">
          <i class="fa fa-credit-card"></i>
          <span class="nav-link-text" style="font-size: 14px">PO Asset Management</span>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{url('/po_msp')}}" class="nav-link">
          <i class="fa fa-fw fa-folder-open"></i>
          <span class="nav-link-text" style="font-size: 14px">Purchase Order</span>
        </a>
      </li>
      @endif -->

      {{-- <li class="nav-item">
        <a class="nav-link" href="{{ url('inventory_report') }}">
          <i class="fa fa-fw fa-folder-open"></i>
          <span class="nav-link-text" style="font-size: 14px">Inventory Report</span>
        </a>
      </li> --}}

      @if(Auth::User()->id_division != 'SALES')
      <li class="treeview activeable">
        
        <a href="#warehouse" data-parent="#exampleAccordion">
          <i class="fa fa-home"></i>
          <span class="nav-link-text" style="font-size: 14px">Warehouse</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" id="warehouse">
          <li>
            <a class="nav-link" href="{{ url('/inventory/msp') }}">
              <span class="nav-link-text" style="font-size: 14px"></i> Master Product</span>
            </a>
          </li>
          @if(Auth::User()->id_division == 'WAREHOUSE')
          <li>
              <a href="{{url('/inventory/do/msp')}}" style="font-size: 14px">Delivery Order</a>
          </li>
          @endif
          <li>
            <a class="nav-link" href="{{ url('/asset_msp') }}">
              <span class="nav-link-text" style="font-size: 14px">Inventory Asset</span>
            </a>
          </li>
          <li class="treeview activeable">
            <a href="#report" data-parent="#exampleAccordion">
              
              <span class="nav-link-text" style="font-size: 14px">Report</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" id="report">
              <li>
                <a class="nav-link" href="{{ url('idpro_report') }}">
                  <span class="nav-link-text" style="font-size: 14px">Per Id Project</span>
                </a>
              </li>
              <li>
                <a class="nav-link" href="{{ url('idpro_report_bydate') }}">
                  <span class="nav-link-text" style="font-size: 14px">Per Id Project by Date</span>
                </a>
              </li>
              <li>
                <a class="nav-link" href="{{ url('month_report') }}">
                  <span class="nav-link-text" style="font-size: 14px">Per Month</span>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </li>
      @endif




      <li class="activeable treeview ">
      	<a href="#FinanceMSP" data-parent="#exampleAccordion">
      		<i class="fa fa-fw fa-credit-card"></i>
      		<span class="nav-link-text" style="font-size: 14px">Finance</span>
      		<span class="pull-right-container">
      			<i class="fa fa-angle-left pull-right"></i>
      		</span>
      	</a>
      	<ul class="treeview-menu" id="FinanceMSP">
      		@if(Auth::User()->id_position != 'HR MANAGER')
      		<li>
      			<a href="{{url('/salesproject')}}" style="font-size: 14px">ID Project</a>
      		</li>
      		<li>
      			<a href="{{url('/po_id_pro')}}" style="font-size: 14px">Mapping ID Project</a>
      		</li>
      		@endif
      		@if(Auth::User()->id_position == 'HR MANAGER')
      		<li>
      			<a href="{{url('/esm')}}" style="font-size: 14px">Claim Management</a>
      		</li>
      		@elseif(Auth::User()->id_division == 'FINANCE' && Auth::User()->id_position == 'STAFF' || Auth::User()->id_division == 'TECHNICAL' && Auth::User()->id_position != 'ADMIN' && Auth::User()->id_company == '1' || Auth::User()->id_division == 'TECHNICAL PRESALES' && Auth::User()->id_company == '1')
      		<li>
      			<a href="{{url('/esm')}}" style="font-size: 14px">Claim Management</a>
      		</li>
      		@endif
      	</ul>
      </li>




      @if(Auth::User()->id_position == 'HR MANAGER' || Auth::User()->id_division == 'FINANCE')
      @else
 <!--      <li class="nav-item">
        <a class="nav-link" href="{{('/sho')}}">
          <i class="fa fa-fw fa-mail-forward"></i>
          <span class="nav-link-text" style="font-size: 14px">Sales Handover</span>
        </a>
      </li> -->
      @endif

      @if(Auth::User()->id_position == 'DIRECTOR' || Auth::User()->id_position == 'MANAGER' && Auth::User()->id_division == 'TECHNICAL' || Auth::User()->id_division == 'SALES' || Auth::User()->id_division == 'TECHNICAL PRESALES')
      <li class="treeview activeable">
        <a href="#ReportTreePages" data-parent="#exampleAccordion">
          <i class="fa fa-fw fa-book"></i>
          <span class="nav-link-text" style="font-size: 14px">Report</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" id="ReportTreePages">
          <li>
            <a href="{{url('/report_range')}}" style="font-size: 14px"></i>Report Range</a>
          </li>
          @if(Auth::User()->email == 'roby@solusindoperkasa.co.id')
            <li>
              <a href="{{url('/report_sales')}}" style="font-size: 14px"></i>Report Sales</a>
            </li>
          @endif
        </ul>
      </li>
      @endif

      <!-- <li class="treeview">
        <a href="#HRPages" data-parent="#exampleAccordion">
          <i class="fa fa-users"></i>
          <span class="nav-link-text" style="font-size: 14px">Human Resource</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" id="HRPages">
          <li>
            <a href="{{url('/show_cuti')}}" style="font-size: 14px"></i>Leaving Permit</a>
          </li>
        </ul>
      </li> -->

    </ul>
  </section>
  <!-- /.sidebar -->
</aside>