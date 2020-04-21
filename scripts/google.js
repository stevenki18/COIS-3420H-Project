/*-------------------------------------------------------
|
|   FILE:           google.js
|
|   DESCRIPTION:    Handles Google sign and account
|                   creation
|
|   SOURCE:         https://developers.google.com/identity/sign-in/web/sign-in
|
-------------------------------------------------------*/


/*--------------------------------------
|
|               ON SIGN IN
|
--------------------------------------*/
function onSignIn(googleUser) {
    // Google Sign in (gets basic profile and creates account if not exists)
    var profile = googleUser.getBasicProfile();

    console.log('Full Name: ' + profile.getName());
    console.log('Given Name: ' + profile.getGivenName());   // Do not send to your backend! Use an ID token instead.
    console.log('Family Name: ' + profile.getFamilyName());
    console.log('Email: ' + profile.getEmail());            // This is null if the 'email' scope is not present.
    console.log("id: " + googleUser.getId());               // This will be the users password

    let pass = googleUser.getAuthResponse().id_token.substring(0, 20);
    let data = {
        email: profile.getEmail(),
        firstname: profile.getGivenName(),
        lastname: profile.getFamilyName(),
        password: pass
    };

    googleSignin(data);

}// END ON SIGN IN


/*--------------------------------------
|
|               GOOGLE SIGN IN
|
--------------------------------------*/
function googleSignin(data) {
    const XHR = new XMLHttpRequest();

    let urlEncodeData = "", urlEncodeDataPairs = [];

    urlEncodeDataPairs.push(encodeURIComponent("email") + '=' + encodeURIComponent(data['email']));
    urlEncodeDataPairs.push(encodeURIComponent("password") + '=' + encodeURIComponent(data['password']));
    urlEncodeDataPairs.push(encodeURIComponent("g-login") + '=' + encodeURIComponent(""));

    urlEncodeData = urlEncodeDataPairs.join('&').replace(/%20/g, '+');

    XHR.addEventListener("load", function (event) {
        if (event.target.responseText == "No Username") {
            console.log("creating new user");
            createnew(data);
        }

        else if (event.target.responseText == "Success") {
            console.log("Account found, redirecting");
            location.href = "display_list.php";
        }
    });

    XHR.addEventListener("error", function (event) {
        alert('Oops! Something went wrong.');
    });

    XHR.open("POST", "login.php");

    XHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    XHR.send(urlEncodeData);
}// END OF GOOGLE SIGN IN


/*--------------------------------------
|
|               CREATE NEW
|
--------------------------------------*/
function createnew(data) {
    // Create a new account from the google signin
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

    XHR.addEventListener("load", function (event) {
        if (event.target.responseText == "Success") {
            alert("Account Created");
            location.href = "display_list.php";
        }
        else
            alert("Information Passed, but account not created");

    });

    XHR.addEventListener("error", function (event) {
        alert('Oops! Something went wrong.');
    });

    XHR.open("POST", "accounts.php");

    XHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    XHR.send(urlEncodeData);
} // END CREATE NEW ACCOUNT OFF GOOGLE SIGN IN


/*--------------------------------------
|
|           DOM CONTENT LOADED
|
--------------------------------------*/
document.addEventListener("DOMContentLoaded", () => {

    /*--------------------------------------
    |
    |                SIGN OUT
    |
    --------------------------------------*/
    var signOutLink = document.querySelector("#signOut");
    if (signOutLink != null) {
        signOutLink.addEventListener("click", event => {
            event.preventDefault();

            try {
                signOut();
            } catch (err) {
                console.log(err);
            }

            const XHR = new XMLHttpRequest();

            let urlEncodeData = "", urlEncodeDataPairs = [];

            urlEncodeDataPairs.push(encodeURIComponent("logout") + '=' + encodeURIComponent(""));

            urlEncodeData = urlEncodeDataPairs.join('&').replace(/%20/g, '+');

            XHR.addEventListener("load", function (event) {
                console.log(event.target.responseText);
                if (event.target.responseText == "Logged Out")
                    location.href = "login.php";

                else
                    alert("ERROR ON LOGOUT");
            });

            XHR.addEventListener("error", function (event) {
                alert('Oops! Something went wrong.');
            });

            XHR.open("POST", "login.php");

            XHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            XHR.send(urlEncodeData);
        });
    } // END OF SIGN OUT
}); // END OF DOM CONTENT LOADED


/*--------------------------------------
|
|              ON LOAD
|
--------------------------------------*/
function onLoad() {
    // REQUIRED to log out googleUser (Needs to run on every page)
    // SOMETIMES DOES NOT LOAD AND WILL NOT SIGN OUT GOOGLE USE (HORRIBLE LOOP)
    console.log("onLoad");
    gapi.load('auth2', function () {
        gapi.auth2.init();
    });
}// END OF ON LOAD


/*--------------------------------------
|
|                GOOGLE OUT
|
--------------------------------------*/
function signOut() {
    var auth2 = window.gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
        console.log('User signed out.');
    });
}// END OF GOOGLE OUT
