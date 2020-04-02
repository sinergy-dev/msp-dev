@extends('template.template_admin-lte')
@section('content')
<section class="content">
  <div class="row">
    <div class="box">
      <div class="box-body">
        <div class="form-group">
          <input type="" class="form-control" name="customer" id="customer">
        </div>
        
        <button class="btn btn-md btn-warning btn-push" onclick="buildDashboard()">Push data</button>
      </div>
      
    </div>
  </div>
</section>
  
@endsection
@section('script')
  <!-- The core Firebase JS SDK is always required and must be listed first -->
  <script src="https://www.gstatic.com/firebasejs/7.6.0/firebase-app.js"></script>
  <script src="https://www.gstatic.com/firebasejs/7.6.0/firebase-database.js"></script>
  <!-- TODO: Add SDKs for Firebase products that you want to use
       https://firebase.google.com/docs/web/setup#available-libraries -->
  <script src="https://www.gstatic.com/firebasejs/7.6.0/firebase-analytics.js"></script>

  <script>
    // Your web app's Firebase configuration
    
    // firebase.analytics();
    
    $(document).ready(function(){
      //  var firebaseConfig = {
      //   apiKey: "AIzaSyB6x3YRmX_QRqcOT2L1egfx6q4pAp3aHyQ",
      //   authDomain: "notif1-363bf.firebaseapp.com",
      //   databaseURL: "https://notif1-363bf.firebaseio.com",
      //   projectId: "notif1-363bf",
      //   storageBucket: "notif1-363bf.appspot.com",
      //   messagingSenderId: "889170064319",
      //   appId: "1:889170064319:web:9b6ae99fdd24657143270a"
      // };
      // // Initialize Firebase
      // firebase.initializeApp(firebaseConfig);

      var firebaseConfig = {
        apiKey: "AIzaSyAcDiVje0RzU5ZpRPwXacHjOFv5AaXRjfI",
        authDomain: "test-project-64a66.firebaseapp.com",
        databaseURL: "https://test-project-64a66.firebaseio.com",
        projectId: "test-project-64a66",
        storageBucket: "test-project-64a66.appspot.com",
        messagingSenderId: "261840044936",
        appId: "1:261840044936:web:7a4e1a47e67afab8"
      };
      // Initialize Firebase
      firebase.initializeApp(firebaseConfig);

      // var firebaseConfig = {
      //   apiKey: "AIzaSyB6NOF2lsSfMGCtFE6vTDbSImeiG3IEeys",
      //   authDomain: "sales-notif.firebaseapp.com",
      //   databaseURL: "https://sales-notif.firebaseio.com",
      //   projectId: "sales-notif",
      //   storageBucket: "sales-notif.appspot.com",
      //   messagingSenderId: "702195459650",
      //   appId: "1:702195459650:web:14a74a1ca2f106bd0f2fdb",
      //   measurementId: "G-YF8RXLDEKV"
      // };
      // // Initialize Firebase
      // firebase.initializeApp(firebaseConfig);

    
    

      // var tampil = firebase.database().ref('project/project_dashboard');
      // tampil.on('value',function(snapshot){
      //   // updateLastest(snapshot.val())
      //   console.log(snapshot.val());
      //   console.log('abc');
      // });

      $(".btn-push").click(function(){

        

      })

    })

    function buildDashboard(argument){
      $.ajax({
          type:"GET",
          url:"firebase/store",
          data:{
            _token: "{{ csrf_token() }}",
            customer:$("#customer").val(),
          },
          success:function(result){
          },
          complete:function() {
            var tampil = firebase.database().ref('/test/');
            tampil.limitToLast(1).on('child_added',function(snapshot){
              getNotif(argument);
              // updateLastest(snapshot.val())
              console.log(snapshot.val());
              console.log('abc');
            });
          }
        })
    }

    function getNotif(argument) {
    if (!("Notification" in window)) {
      alert("This browser does not support desktop notification");
    } else if (Notification.permission === "granted") {
      var notification = new Notification(argument);
    } else if (Notification.permission !== "denied") {
      Notification.requestPermission().then(function (permission) {
        if (permission === "granted") {
          var notification = new Notification("Hai " + argument.customer);
        }
      });
    }

    notification.onclick = function(event) {
      event.preventDefault()
      console.log('click')
    }
  }
  </script>


@endsection