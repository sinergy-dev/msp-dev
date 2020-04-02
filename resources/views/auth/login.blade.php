<!DOCTYPE html>
<html lang="en" class="fullscreen-bg">

<head>
  <title>App Solusindo</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <!-- VENDOR CSS -->
  <link rel="stylesheet" href="{{asset('/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('/vendor2/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('/vendor2/linearicons/style.css')}}">
  <!-- MAIN CSS -->
  <link rel="stylesheet" href="{{asset('/css/main.css')}}">
  <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
  <link rel="stylesheet" href="{{asset('/css/demo.css')}}">
  <!-- GOOGLE FONTS -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- ICONS -->
  <link rel="apple-touch-icon" href="{{asset('/img/logopng.png')}}">
  <link rel="icon" type="image/png" href="{{asset('/img/iconmsp2.png')}}">
  <style type="text/css">
  body {
    background-image: url("../img/mspfixx.jpg");

    height: 100%;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
  }
</style>
<script type="text/javascript">
  $(document).ready(function(){
    $("#alert").fadeTo(2000, 500).slideUp(500, function(){
      $("#alert").slideUp(400);
    });
  })
  
</script>
</head>

<body class="bg-wall">
  <!-- WRAPPER -->
  <div id="wrapper">
    <div class="vertical-align-wrap">
      <div class="vertical-align-middle">
        <div style="width: 400px" class="auth-box">
            <div class="content">
              <div class="header">
                <div class="logo text-center"><img src="{{asset('/img/msplogin.png')}}" width="150" height="60" alt="Klorofil Logo"></div>
                <p class="lead">Solusindo Integrated Management System</p>
              </div>
              <center> <form style="width: 300px" class="form-horizontal" role="form" method="POST" action="{{ route('login') }}">
                  {{ csrf_field() }}
                  @if(session()->has('message'))
                      <div class="alert alert-warning notification-bar" id="alert">
                          {{ session()->get('message') }}
                      </div>
                  @endif
                  <div  class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                      <label for="email" class="control-label sr-only">Email</label>
                      <div class="col-md-12">
                          <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
                          @if ($errors->has('email'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('email') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>
                  <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                      <label for="password" class="control-label sr-only">Password</label>
                      <div class="col-md-12">
                          <input id="password" type="password" class="form-control" name="password" placeholder="Password" required>
                          @if ($errors->has('password'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('password') }}</strong>
                              </span>
                          @endif
                      </div>
                  </div>
                  <button type="submit" class="btn btn-primary btn-block">
                    Login
                  </button>
              </form></center>
            </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
  <!-- END WRAPPER -->
</body>
</html>

