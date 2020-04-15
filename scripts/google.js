/* -------------------------------------------------
|
|       GOOGLE SCRIPT STUFF (MODIFIED FOR USE)
|
---------------------------------------------------*/
// Google Sign in (gets basic profile and creates account if not exists)
function onSignIn(googleUser) {
    var profile = googleUser.getBasicProfile();
    console.log('Full Name: ' + profile.getName());
    console.log('Given Name: ' + profile.getGivenName()); // Do not send to your backend! Use an ID token instead.
    console.log('Family Name: ' + profile.getFamilyName());
    console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
    console.log("id: " + googleUser.getId()); // This will be the users password
  
    let pass = googleUser.getAuthResponse().id_token.substring(0,20);
    let data = {email:profile.getEmail(), firstname:profile.getGivenName(),
                lastname:profile.getFamilyName(), password: pass};
  
    googleSignin(data);
  
  } // END GOOGLE onSignIn
  
  function googleSignin(data){
    const XHR = new XMLHttpRequest();
    // let formElement = document.querySelector("#login");
  
    let urlEncodeData = "", urlEncodeDataPairs = [];
  
    urlEncodeDataPairs.push(encodeURIComponent("email") + '=' + encodeURIComponent(data['email']));
    urlEncodeDataPairs.push(encodeURIComponent("password") + '=' + encodeURIComponent(data['password']));
    urlEncodeDataPairs.push(encodeURIComponent("g-login") + '=' + encodeURIComponent(""));
  
  
    urlEncodeData = urlEncodeDataPairs.join('&').replace(/%20/g, '+');
  
    XHR.addEventListener("load", function(event) {
      if(event.target.responseText == "No Username"){
        console.log("creating new user");
        createnew(data);
      }
      else if(event.target.responseText == "Success") {
        console.log("Account found, redirecting");
        location.href="display_list.php";
      }
    });
  
    XHR.addEventListener("error", function(event){
      alert('Oops! Something went wrong.');
    });
  
    XHR.open("POST", "login.php");
  
    XHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  
    XHR.send(urlEncodeData);
  }
  
  // Create a new account from the google signin
  function createnew(data){
    console.log(data);
    const XHR = new XMLHttpRequest();
  
    let urlEncodeData = "", urlEncodeDataPairs = [];
  
    urlEncodeDataPairs.push(encodeURIComponent("username") + '=' + encodeURIComponent(data['email']));
    urlEncodeDataPairs.push(encodeURIComponent("password") + '=' + encodeURIComponent(data['password']));
    urlEncodeDataPairs.push(encodeURIComponent("firstname") + '=' + encodeURIComponent(data['firstname']));
    urlEncodeDataPairs.push(encodeURIComponent("lastname") + '=' + encodeURIComponent(data['lastname']));
    urlEncodeDataPairs.push(encodeURIComponent("email") + '=' + encodeURIComponent(data['email']));
    urlEncodeDataPairs.push(encodeURIComponent("g-create") + '=' + encodeURIComponent(""));
  
  
    urlEncodeData = urlEncodeDataPairs.join('&').replace(/%20/g, '+');
  
    XHR.addEventListener("load", function(event) {
      if(event.target.responseText == "Success"){
        alert("Account Created");
        location.href="display_list.php";
      }
      else {
        alert("Information Passed, but account not created");
      }
    });
  
    XHR.addEventListener("error", function(event){
      alert('Oops! Something went wrong.');
    });
  
    XHR.open("POST", "accounts.php");
  
    XHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  
    XHR.send(urlEncodeData);
  } // END CREATE NEW ACCOUNT OFF GOOGLE SIGN IN
  
  // Signout button
  document.addEventListener("DOMContentLoaded", () =>{
    var signOutLink = document.querySelector("#signOut");
    if(signOutLink != null){
      signOutLink.addEventListener("click", event => {
        event.preventDefault();
  
        try{
          signOut();
        }
        catch(err){
          console.log(err);
        }
  
        const XHR = new XMLHttpRequest();
  
        let urlEncodeData = "", urlEncodeDataPairs = [];
  
        urlEncodeDataPairs.push(encodeURIComponent("logout") + '=' + encodeURIComponent(""));
  
        urlEncodeData = urlEncodeDataPairs.join('&').replace(/%20/g, '+');
  
        XHR.addEventListener("load", function(event) {
          console.log(event.target.responseText);
          if(event.target.responseText == "Logged Out"){
            alert("Successfully Logged Out");
            location.href="login.php";
          }
          else {
            alert("Information Passed, but not logged out");
          }
        });
  
        XHR.addEventListener("error", function(event){
          alert('Oops! Something went wrong.');
        });
  
        XHR.open("POST", "login.php");
  
        XHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  
        XHR.send(urlEncodeData);
      });
    } // END if signout !=null
  }); // ONLY if DOMContent is loaded
  
  // REQUIRED to log out googleUser (Needs to run on every page)
  // SOMETIMES DOES NOT LOAD AND WILL NOT SIGN OUT GOOGLE USE (HORRIBLE LOOP)
  function onLoad() {
    console.log("onLoad");
    gapi.load('auth2', function(){
      gapi.auth2.init();
    });
  }
  
  // Google Signout
  function signOut() {
      var auth2 = window.gapi.auth2.getAuthInstance();
      auth2.signOut().then(function () {
        console.log('User signed out.');
    });
  }
  