
 import { initializeApp } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-app.js";
  import { getAuth ,GoogleAuthProvider, signInWithPopup } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-auth.js";

  const firebaseConfig = {
    apiKey: "AIzaSyDmfM9MSVWb1hu9v1oxAdJvOu6KK1tNJdQ",
    authDomain: "login-86afc.firebaseapp.com",
    projectId: "login-86afc",
    storageBucket: "login-86afc.firebasestorage.app",
    messagingSenderId: "429315573140",
    appId: "1:429315573140:web:f58d361bcb9c2fdc2cbb81",
    measurementId: "G-JWHP6CM1GH"
  };

  // Initialize Firebase
  const app = initializeApp(firebaseConfig);
	const auth = getAuth();
	auth.languageCode = 'en';
  const provider = new GoogleAuthProvider();


  const googlelogin = document.getElementById('google-login-btn');
  googlelogin.addEventListener('click', function(){
	  signInWithPopup(auth, provider)
	  .then((result) => {
	    const credential = GoogleAuthProvider.credentialFromResult(result);
	    const user = result.user;
	    console.log(user);
	    window.location.href = "Shoppage.php";

	  }).catch((error) => {
	    const errorCode = error.code;
	    const errorMessage = error.message;
	  });


	  } )
