<html class="gr__192_168_2_143" style="height: auto; min-height: 100%;"><head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>MSP - SIMSApp</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="http://192.168.2.143/template2/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="http://192.168.2.143/template2/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="http://192.168.2.143/template2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="http://192.168.2.143/template2/bower_components/Ionicons/css/ionicons.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="http://192.168.2.143/template2/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="http://192.168.2.143/template2/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="http://192.168.2.143/template2/dist/css/AdminLTE.css">
  <link rel="stylesheet" type="text/css" href="http://192.168.2.143/css/style.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="http://192.168.2.143/template2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="http://192.168.2.143/template2/bower_components/select2/dist/css/select2.min.css">
  <!-- Fixed Column -->
  <link href="http://192.168.2.143/css/fixedColumns.dataTables.min.css" rel="stylesheet">
  <link href="http://192.168.2.143/css/fixedColumns.bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="http://192.168.2.143/template2/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="http://192.168.2.143/template2/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="http://192.168.2.143/template2/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Morris charts -->
  <link rel="stylesheet" href="http://192.168.2.143/template2/bower_components/morris.js/morris.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="http://192.168.2.143/template2/dist/css/AdminLTE.min.css">
  <!--Swal-->
  <script src="http://192.168.2.143/js/sweetalert2.min.js"></script>
  <script src="http://192.168.2.143/js/sweetalert2.js"></script>

  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="http://192.168.2.143/template2/dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style type="text/css">
    .loader {
      border: 16px solid #f3f3f3;
      border-radius: 50%;
      border-top: 16px solid blue;
      border-right: 16px solid green;
      border-bottom: 16px solid red;
      border-left: 16px solid pink;
      width: 120px;
      height: 120px;
      -webkit-animation: spin 2s linear infinite;
      animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
      0% { -webkit-transform: rotate(0deg); }
      100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes  spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    .dropbtn {
      background-color: #4CAF50;
      color: white;
      font-size: 12px;
      border: none;
      width: 140px;
      height: 30px;
      border-radius: 5px;
    }

    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #f1f1f1;
      min-width: 140px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
    }


    .dropdown-content .year:hover {background-color: #ddd;}

    .dropdown:hover .dropdown-content {display: block;}

    .dropdown:hover .dropbtn {background-color: #3e8e41;}

    .transparant-filter{
      background-color: Transparent;
      background-repeat:no-repeat;
      border: none;
      cursor:pointer;
      overflow: hidden;
      outline:none;
    }

    .transparant{
      background-color: Transparent;
      background-repeat:no-repeat;
      border: none;
      cursor:pointer;
      overflow: hidden;
      outline:none;
      width: 25px;
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
    .warning {
        background:#fff8c4 ;
        border:1px solid #f2c779;
    }
    .notice {
        background:#e3f7fc;
        border:1px solid #8ed9f6;
    }
    div div ol li a{
      font-size: 14px;
    }

    div div i{
      font-size: 14px;
    }

      color:#fff;
        background-color:dodgerBlue;
      }

     .inputWithIconn.inputIconBg i{
        background-color:#aaa;
        color:#fff;
        padding:7px 4px;
        border-radius:4px 0 0 4px;
      }

     .inputWithIconn{
        position:relative;
      }

      .inputWithIconn i{
        position:absolute;
        left:0;
        top:28px;
        padding:9px 8px;
        color:#aaa;
        transition:.3s;
      }

      .inputWithIconn input[type=text]{
        padding-left:40px;
      }
      label.status-lose:hover{
        border-radius: 10%;
        background-color: grey;
        text-align: center;
        width: 75px;
        height: 30px;
        color: white;
        padding-top: 3px;
        cursor: zoom-in;
      }
      table.center{
        text-align: center;
      }

      .stats_item_number {
        white-space: nowrap;
        font-size: 2.25rem;
        line-height: 2.5rem;
        
        &:before {
          display: none;
        }
      }

      .txt_success {
        color: #2EAB6F;
      }

      .txt_warn {
        color: #f2562b;
      }

      .txt_sd {
        color: #04dda3;
      }

      .txt_tp{
        color: #f7e127;
      }

      .txt_win{
        color: #246d18;
      }

      .txt_lose{
        color: #e5140d;
      }

      .txt_smaller {
        font-size: .75em;
      }

      .flipY {
        transform: scaleY(-1);
        border-bottom-color: #fff;
      }

      .txt_faded {
        opacity: .65;
      }

      .txt_primary{
        color: #007bff;
      }

      .card {
        position: relative;
        margin-bottom: 24px;
        background-color: #fff;
        -webkit-box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
      }
  </style>
<style type="text/css">/* Chart.js */
@-webkit-keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}@keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}.chartjs-render-monitor{-webkit-animation:chartjs-render-animation 0.001s;animation:chartjs-render-animation 0.001s;}</style><style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;box-sizing: content-box;z-index: 10000;}.jqsfield { color: white;font: 10px arial, san serif;text-align: left;}</style></head>
<body class="skin-blue sidebar-mini" data-gr-c-s-loaded="true" style="height: auto; min-height: 100%;">

<!-- ./wrapper -->
<div class="wrapper" style="height: auto; min-height: 100%;">

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
  <a href="http://192.168.2.143" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><img src="../img/logopng.png" alt="cobaaa" width="30px" height="40px"></span>
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
        <!-- Messages: style can be found in dropdown.less-->
        <!-- <li class="dropdown messages-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-envelope-o"></i>
            <span class="label label-success">4</span>
          </a>
          <ul class="dropdown-menu">
            <li class="header">You have 4 messages</li>
            <li>
              <ul class="menu">
                <li>
                  <a href="#">
                    <div class="pull-left">
                      <img src="http://192.168.2.143/template2/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                      Support Team
                      <small><i class="fa fa-clock-o"></i> 5 mins</small>
                    </h4>
                    <p>Why not buy a new awesome theme?</p>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <div class="pull-left">
                      <img src="http://192.168.2.143/template2/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                      AdminLTE Design Team
                      <small><i class="fa fa-clock-o"></i> 2 hours</small>
                    </h4>
                    <p>Why not buy a new awesome theme?</p>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <div class="pull-left">
                      <img src="http://192.168.2.143/template2/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                      Developers
                      <small><i class="fa fa-clock-o"></i> Today</small>
                    </h4>
                    <p>Why not buy a new awesome theme?</p>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <div class="pull-left">
                      <img src="http://192.168.2.143/template2/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                      Sales Department
                      <small><i class="fa fa-clock-o"></i> Yesterday</small>
                    </h4>
                    <p>Why not buy a new awesome theme?</p>
                  </a>
                </li>
                <li>
                  <a href="#">
                    <div class="pull-left">
                      <img src="http://192.168.2.143/template2/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                    </div>
                    <h4>
                      Reviewers
                      <small><i class="fa fa-clock-o"></i> 2 days</small>
                    </h4>
                    <p>Why not buy a new awesome theme?</p>
                  </a>
                </li>
              </ul>
            </li>
            <li class="footer"><a href="#">See All Messages</a></li>
          </ul>
        </li> -->
        
        
        
        <!-- Notifications: style can be found in dropdown.less -->
        



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
                          <img src="https://www.mycustomer.com/sites/all/modules/custom/sm_pp_user_profile/img/default-user.png" class="user-image" alt="Yuki">
                        <span class="hidden-xs">Indra</span>
          </a>
          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              
                              <img src="https://www.mycustomer.com/sites/all/modules/custom/sm_pp_user_profile/img/default-user.png" class="img-circle" alt="Yuki">
              
              <p>
                Indra - 
                                  WAREHOUSE STAFF
                                <small>
                                      Multi Solusindo Perkasa
                                  </small>
                <small>Member since 2018-01-01</small>
              </p>
            </li>
            <!-- Menu Body -->
            <!-- <li class="user-body">
              <div class="row">
                <div class="col-xs-4 text-center">
                  <a href="#">Followers</a>
                </div>
                <div class="col-xs-4 text-center">
                  <a href="#">Sales</a>
                </div>
                <div class="col-xs-4 text-center">
                  <a href="#">Friends</a>
                </div>
              </div>
            </li> -->
            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="http://192.168.2.143/profile_user" class="btn btn-default btn-flat">Profile</a>
              </div>
              <div class="pull-right">
                <!-- <a href="#" class="btn btn-default btn-flat">Sign out</a> -->
                <a class="btn btn-default btn-flat" href="http://192.168.2.143/logout" onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="http://192.168.2.143/logout" method="POST" style="display: none;">
                    <input type="hidden" name="_token" value="wREFe9jIkVXh9lktLZjiDGkISaUgRhf7UV9xNLt3">                </form>
              </div>
            </li>
          </ul>
        </li>
        <!-- Control Sidebar Toggle Button -->
        
      </ul>
    </div>

  </nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar" style="height: auto;">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
                  <img src="https://www.mycustomer.com/sites/all/modules/custom/sm_pp_user_profile/img/default-user.png" class="img-circle" alt="Yuki">
              </div>
      <div class="pull-left info">
        <p>Indra</p>
        <a href="#"><i class="fa fa-circle text-success"></i> WAREHOUSE  &nbsp; STAFF </a>
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
    <ul class="sidebar-menu tree" data-widget="tree">
      <li class="header">MAIN NAVIGATION</li>
      
      <li class="nav-item">
        <a class="nav-link" href="http://192.168.2.143">
          <i class="fa fa-fw fa-dashboard"></i>
          <span class="nav-link-text" style="font-size: 14px">Dashboard</span>
        </a>
      </li>
            
      
      
      
      
      <li class="nav-item">
        <a class="nav-link" href="http://192.168.2.143/inventory_report">
          <i class="fa fa-fw fa-folder-open"></i>
          <span class="nav-link-text" style="font-size: 14px">Inventory Report</span>
        </a>
      </li>


      <!--  -->

      <!--  -->

              <li class="treeview">
          <a href="#INPages" data-parent="#exampleAccordion">
            <i class="fa fa-fw fa-folder-open"></i>
            <span class="nav-link-text" style="font-size: 14px">Warehouse</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu" id="INPages">
            <li class="treeview">
              <a href="#DetInPage" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-circle"></i>
              <span class="nav-link-text" style="font-size: 14px">Inventory</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu" id="DetInPage">
              <li>
                <a href="http://192.168.2.143/inventory/msp" style="font-size: 14px"><i class="fa fa-fw fa-circle-o"></i>Master Data</a>
              </li>
              <li>
                <a href="http://192.168.2.143/do-sup/index" style="font-size: 14px"><i class="fa fa-fw fa-circle-o"></i>DO-SUP</a>
              </li>
            </ul>
            </li>
            <li>
              <a href="http://192.168.2.143/inventory/do/msp" style="font-size: 14px"><i class="fa fa-fw fa-circle-o"></i>Delivery Order</a>
            </li>
            <li>
              <a href="http://192.168.2.143/asset_msp" style="font-size: 14px"><i class="fa fa-fw fa-circle-o"></i>Asset Management</a>
            </li>
          </ul>
        </li>
      
            <li class="nav-item">
        <a class="nav-link" href="http://192.168.2.143/customer">
          <i class="fa fa-fw fa-folder-open"></i>
          <span class="nav-link-text" style="font-size: 14px">Customer Data</span>
        </a>
      </li>
      
      <li class="nav-item">
        <a class="nav-link" href="http://192.168.2.143/salesproject">
          <i class="fa fa-fw fa-laptop"></i>
          <span class="nav-link-text" style="font-size: 14px">ID Project</span>
        </a>
      </li>
      
            
      <!--  -->
      
      <!-- Header ID Project -->

      <!--  -->

      <!--       <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Products">
        <a class="nav-link" href="http://192.168.2.143/warehouse">
          <i class="fa fa-fw fa-cubes"></i>
          <span class="nav-link-text">Warehouse</span>
        </a>
      </li>
       -->

            <li class="nav-item">
        <a class="nav-link" href="/sho">
          <i class="fa fa-fw fa-mail-forward"></i>
          <span class="nav-link-text" style="font-size: 14px">Sales Handover</span>
        </a>
      </li>
            <!-- -->
      <!-- Report -->

      <!--  -->

          </ul>
  </section>
  <!-- /.sidebar -->
</aside>  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="min-height: 734.254px;">
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
    Add Delivery Order MSP
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Delivery Order</li>
    <li class="active">MSP</li>
    <li class="active">Add</li>
  </ol>
</section>

<section class="content">
  

  <div class="box">
    <div class="box-header">
      
    </div>

    <div class="box-body">
          <form method="POST" action="http://192.168.2.143/inventory/store/do/msp" id="modal_pr_asset" name="modal_pr_asset">
            <input type="hidden" name="_token" value="wREFe9jIkVXh9lktLZjiDGkISaUgRhf7UV9xNLt3">                <div class="row">
          <div class="col-sm-11">
              <div class="form-group row" style="margin-left: -12px">
                <label class="col-sm-2 control-label">Date</label>
                <div class="col-sm-10">
                  <input class="form-control" id="today" type="date" readonly="">
                </div>
              </div>
          </div>
        </div>
        
                <input type="" name="id_pam_set" id="id_pam_set" hidden=""><table id="product-add" class="table">
          
          <tbody><tr class="tr-header">
            <th>MSP Code</th>
            <th>Description</th>
            <th>Stock</th>
            <th>Qty</th>
            <th>Unit</th>
            <th>
              <div id="kg-header">Kg</div>
            </th>
            <th>
              <div id="vol-header">Vol</div>
            </th>
            <th>
              <div id="plusss">
              <a href="javascript:void(0);" style="font-size:18px" id="addMoreYa"><span class="fa fa-plus"></span></a>
              </div>
            </th>
          </tr>
          <tr>
            <td style="margin-bottom: 50px;">
              <br><select class="form-control produk select2-hidden-accessible" name="product[]" id="product0" data-rowid="0" style="font-size: 14px;width: 300px" tabindex="-1" aria-hidden="true">
                <option>-- Select MSPCode --</option>
                                <option value="300">KBL001 - SUPREME</option>
                                <option value="301">KBL002 - BAPE</option>
                                <option value="303">KBL003 - Kabel UTP</option>
                                <option value="304">AP001 - Pipa pipa</option>
                              </select><span class="select2 select2-container select2-container--default" dir="ltr" style="width: 300px;"><span class="selection"><span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-product0-container"><span class="select2-selection__rendered" id="select2-product0-container" title="-- Select MSPCode --">-- Select MSPCode --</span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span></span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
            </td>
            <td>
              <br>
              <textarea type="text" class="form-control name_barangs" style="width:500px" data-rowid="0" name="information[]" id="information" readonly=""></textarea>
            </td>
            <td>
              <br>
              <input type="text" name="ket_aja[]" id="ket0" class="form-control ket" data-rowid="0" readonly="" style="width: 50px">
            </td>
            <td style="margin-bottom: 50px">
              <br>
              <input type="number" class="form-control qty" placeholder="Qty" name="qty[]" id="qty" data-rowid="0" style="width: 60px" required="">
            </td>
            <td style="margin-bottom: 50px">
              <br>
              <input type="text" class="form-control unit" placeholder="Unit" name="unit[]" id="unit0" data-rowid="0" readonly="" style="width: 100px">
            </td>
            <td style="margin-bottom: 50px">
              <br>
              <div id="ifYes">
              <input type="" name="kg[]" placeholder="Kg" style="width: 50px" class="form-control">
              </div>
            </td>
            <td style="margin-bottom: 50px">
              <br>
              <div id="volYes">
              <input type="" name="vol[]" placeholder="Vol" style="width: 50px" class="form-control">
              </div>
            </td>
            <td>
              <a href="javascript:void(0);" class="remove"><span class="fa fa-times" style="font-size: 18px;color: red;margin-top: 25px"></span></a>
            </td>
          </tr>
        </tbody></table>

        <div class="col-md-12" id="submit-btn">
          <br>
          <button type="submit" class="btn btn-primary"><i class="fa fa-check"> </i>&nbsp;Submit</button>
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

  </div>
  <!-- /.content-wrapper -->

      <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.0
    </div>
    <strong>Copyright © 2018 <a href="http://www.sinergy.co.id">Sinergy Informasi Pratama</a>.</strong>
  </footer>

</div>  

<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="http://192.168.2.143/template2/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="http://192.168.2.143/template2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="http://192.168.2.143/template2/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="http://192.168.2.143/template2/dist/js/adminlte.min.js"></script>
<!-- Sparkline -->
<script src="http://192.168.2.143/template2/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap  -->
<script src="http://192.168.2.143/template2/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="http://192.168.2.143/template2/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- DataTables -->
<script src="http://192.168.2.143/template2/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="http://192.168.2.143/template2/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="http://192.168.2.143/template2/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- ChartJS -->
<script src="http://192.168.2.143/template2/bower_components/chart.js/Chart.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) --><!-- 
<script src="http://192.168.2.143/template2/dist/js/pages/dashboard2.js"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="http://192.168.2.143/template2/dist/js/demo.js"></script>
<!-- Select2 -->
<script src="http://192.168.2.143/template2/bower_components/select2/dist/js/select2.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>

<script src="http://192.168.2.143/vendor/chart.js/Chart.min.js"></script>
<script src="http://192.168.2.143/js/sb-admin-charts.min.js"></script>
<!-- DataTables -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>

  <script type="text/javascript" src="http://192.168.2.143/js/jquery.mask.js"></script>
  <script type="text/javascript" src="http://192.168.2.143/js/select2.min.js"></script>
  <script type="text/javascript">
    function showMe(e) {
  // i am spammy!
    alert(e.value);
  }

    $('.produk').select2();

    $('.searchid').select2();

    function initproduk(){
      $('.produk').select2();
    }

    function yesnoCheck() {
      if (document.getElementById('yesCheck').checked) {
      document.getElementById('product-add').style.display = 'block'; 
      document.getElementById('plusss').style.display = 'block'; 
      document.getElementById('pluss').style.display = 'none';  
      document.getElementById('kg-header').style.display = 'block';
      document.getElementById('vol-header').style.display = 'block';
      document.getElementById('ifYes').style.display = 'block';
      document.getElementById('volYes').style.display = 'block';
      document.getElementById('submit-btn').style.display = 'block';
      $("#product-add").find("tr:gt(1)").remove();
      }
      else {
      document.getElementById('product-add').style.display = 'block'; 
      document.getElementById('pluss').style.display = 'block';
      document.getElementById('plusss').style.display = 'none';
      document.getElementById('kg-header').style.display = 'none';
      document.getElementById('vol-header').style.display = 'none';
      document.getElementById('ifYes').style.display = 'none'; 
      document.getElementById('volYes').style.display = 'none';
      document.getElementById('submit-btn').style.display = 'block'; 
      $("#product-add").find("tr:gt(1)").remove();
      }
    }


    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
         $("#alert").slideUp(300);
    });

    $('#data_Table').DataTable( {
     "scrollX": true,
    });

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
              $(".ket[data-rowid='"+rowid+"']").val(value.qty);
              $(".unit[data-rowid='"+rowid+"']").val(value.unit);
            });

          document.getElementById('addMore').style.display = 'block'; 
          document.getElementById('addMoreYa').style.display = 'block';

          }
        });
      });

    var i = 0;
    $('#addMore').click(function(){  
           i++;  
           $('#product-add').append('<tr id="row'+i+'"><td><br><select class="form-control produk" name="product[]" data-rowid="'+i+'" id="product'+i+'" style="font-size: 14px;width: 300px"><option>-- Select MSPCode --</option><option value="300" >KBL001 - SUPREME</option><option value="301" >KBL002 - BAPE</option><option value="303" >KBL003 - Kabel UTP</option><option value="304" >AP001 - Pipa pipa</option></select></td><td><br><textarea type="text" class="form-control name_barangs" style="width:500px" data-rowid="'+i+'" name="information[]" id="information" readonly></textarea></td><td><br><input type="text" name="ket_aja[]" id="ket0" class="form-control ket" data-rowid="'+i+'" readonly style="width: 50px"></td><td><br><input type="number" class="form-control qty" placeholder="Qty" name="qty[]" id="qty" data-rowid="'+i+'" style="width:60px"></td><td><br><input type="text" readonly class="form-control unit" placeholder="Unit" name="unit[]" id="unit'+i+'" data-rowid="'+i+'" style="width:100px"></td><td style="margin-bottom: 50px"><br><div id="ifYes" style="display: none"><input type="" name="kg[]" placeholder="Kg" style="width: 50px" class="form-control"></div></td><td style="margin-bottom: 50px"><br><div id="volYes" style="display: none"><input type="" name="vol[]" placeholder="Vol" style="width: 50px" class="form-control"></div></td><td><a href="javascript:void(0);" id="'+i+'"class="remove"><span class="fa fa-times" style="font-size: 18px;color:red;margin-top: 25px"></span></a></td></tr>');
           initproduk();
    });

    $('#addMoreYa').click(function(){  
           i++;  
           $('#product-add').append('<tr id="row'+i+'"><td><br><select class="form-control produk" name="product[]" data-rowid="'+i+'" id="product'+i+'" style="font-size: 14px;width: 300px"><option>-- Select MSPCode --</option><option value="300" >KBL001 - SUPREME</option><option value="301" >KBL002 - BAPE</option><option value="303" >KBL003 - Kabel UTP</option><option value="304" >AP001 - Pipa pipa</option></select></td><td><br><textarea type="text" class="form-control name_barangs" style="width:500px" data-rowid="'+i+'" name="information[]" id="information" readonly></textarea></td><td><br><input type="text" name="ket_aja[]" id="ket0" class="form-control ket" data-rowid="'+i+'" readonly style="width: 50px"></td><td><br><input type="number" class="form-control qty" placeholder="Qty" name="qty[]" id="qty" data-rowid="'+i+'" style="width:60px"></td><td><br><input type="text" readonly class="form-control unit" placeholder="Unit" name="unit[]" id="unit'+i+'" data-rowid="'+i+'" style="width:100px"></td><td style="margin-bottom: 50px"><br><div id="ifYes"><input type="" name="kg[]" placeholder="Kg" style="width: 50px" class="form-control"></div></td><td style="margin-bottom: 50px"><br><div id="volYes"><input type="" name="vol[]" placeholder="Vol" style="width: 50px" class="form-control"></div></td><td><br><a href="javascript:void(0);" id="'+i+'"class="remove"><span class="fa fa-times" style="font-size: 18px;color:red;margin-top:5px"></span></a></td></tr>');
           initproduk();
    });

    $(document).on('click', '.remove', function() {
         var trIndex = $(this).closest("tr").index();
            if(trIndex>1) {
             $(this).closest("tr").remove();
           } else {
             alert("Sorry!! Can't remove first row!");
           }
    });

    $(document).on('keyup keydown', ".qty", function(e){
    var rowid = $(this).attr("data-rowid");
    var qty_before = $(".ket[data-rowid='"+rowid+"']").val();
    console.log(qty_before);
        if ($(this).val() > parseFloat(qty_before)
            && e.keyCode != 46
            && e.keyCode != 8
           ) {
           e.preventDefault();     
           $(this).val(qty_before);
        }
    });

    $(".dismisbar").click(function(){
      $(".notification-bar").slideUp(300);
    });

    let today = new Date().toISOString().substr(0, 10);
    document.querySelector("#todays").value = today;
  </script>



</body></html>