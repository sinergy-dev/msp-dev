const firebaseConfig = {
  apiKey: "AIzaSyB6x3YRmX_QRqcOT2L1egfx6q4pAp3aHyQ",
  authDomain: "notif1-363bf.firebaseapp.com",
  databaseURL: "https://notif1-363bf.firebaseio.com",
  projectId: "notif1-363bf",
  storageBucket: "notif1-363bf.appspot.com",
  messagingSenderId: "889170064319",
  appId: "1:889170064319:web:9b6ae99fdd24657143270a",
  measurementId: "G-YFRWG2PCB8"
};

firebase.initializeApp(firebaseConfig);

//
const messaging  = firebase.messaging();
		messaging
		.requestPermission()
		.then(function(){
			console.log("Notification permission granted");
			return messaging.getToken()
		}).then(function(token){
			console.log(token)
		}).catch(function(err){
			console.log("Unable to get permission to notify", err);
		});

//------------

messaging.onMessage((payload) => {
	console.log(payload);
})