import { initializeApp } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-app.js";
import { getAuth, GoogleAuthProvider, signInWithPopup } from "https://www.gstatic.com/firebasejs/11.4.0/firebase-auth.js";

const firebaseConfig = {
  apiKey: "AIzaSyDmfM9MSVWb1hu9v1oxAdJvOu6KK1tNJdQ",
  authDomain: "login-86afc.firebaseapp.com",
  projectId: "login-86afc",
  storageBucket: "login-86afc.appspot.com",
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
  provider.setCustomParameters({ prompt: "select_account" }); // <- force choose account
  signInWithPopup(auth, provider)
  .then((result) => {
    const user = result.user;
    console.log(user);

    // Send the email to PHP
    fetch('google_login_handler.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
      },
      body: `email=${encodeURIComponent(user.email)}`
    })
    .then(response => response.text())
    .then(data => {
      if (data.trim() === "success") {
        window.location.href = "Dashboard.php";
      } else {
        alert("Login Failed: " + data);
      }
    });

  }).catch((error) => {
    console.log(error);
  });
});
