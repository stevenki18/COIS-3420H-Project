"use strict";

window.addEventListener('DOMContentLoaded', () => {
  const emailIsValid = string => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(string);

  /*--------------------------------------
  |
  |           LOGIN PAGE
  |     FORGOT PASSWORD HANDLER
  |
  --------------------------------------*/
  if(document.title == "Login"){
    document.getElementById("forgot").addEventListener("click", () => {
      const checker = document.querySelector("#forgotCheck");
      const changer = document.querySelector("#forgotChange");

      // Set up the modal sections
      checker.classList.remove("hidden");
      changer.classList.add("hidden");

      const username = document.querySelector("#forgotCheck>input");
      const email = document.querySelector("#forgotCheck>input:last-of-type");
      username.value = "";
      email.value = "";

      // Open Modal
      document.getElementById('forgotpass').style.display='block';

      // Process forgot-checker
      document.getElementById("forgot-check").addEventListener("click", event => {

        console.log("Checking for account...");
        console.log(username.value);
        console.log(email.value);
        const userError = document.querySelector("#forgotCheck>span");
        const emailError = document.querySelector("#forgotCheck>span:last-of-type");

        userError.classList.add("hidden");
        emailError.classList.add("hidden");

        let valid = true;

        if (username.value == "") {
          userError.classList.remove("hidden");
          valid = false;
        }else if(email.value == ""){
          emailError.classList.remove("hidden");
          valid = false;
        }else if(!emailIsValid(email.value)){
          emailError.classList.remove("hidden");
          valid = false;
        }

        if (valid){
          event.preventDefault();
          // Process POST
          const XHR = new XMLHttpRequest();

          let urlEncodeData = "", urlEncodeDataPairs = [];

          urlEncodeDataPairs.push(encodeURIComponent("username") + '=' + encodeURIComponent(username.value));
          urlEncodeDataPairs.push(encodeURIComponent("email") + '=' + encodeURIComponent(email.value));
          urlEncodeDataPairs.push(encodeURIComponent("forgot-check") + '=' + encodeURIComponent(""));


          urlEncodeData = urlEncodeDataPairs.join('&').replace(/%20/g, '+');

          XHR.addEventListener("load", function(event) {
            if(event.target.responseText == "User Found"){
              alert("User Found");
              checker.classList.add("hidden");
              changer.classList.remove("hidden");

              var password = document.querySelector('#forgotChange>input');
              var meter = document.getElementById('forgotpassword-strength');
              var text = document.getElementById('forgotpassword-strength-text');

              passwordStrength(password,meter,text);

              // Process forgot-changer
              document.getElementById("forgot-change").addEventListener("click", event => {

                console.log("Changing Password..." + username.value);
                const password = document.querySelector("#forgotChange>input");
                const confpassword = document.querySelector("#forgotChange>input:last-of-type");
                const passError = document.querySelector("#forgotChange>span");
                const confError = document.querySelector("#forgotChange>span:last-of-type");

                passError.classList.add("hidden");
                confError.classList.add("hidden");
                let valid = true;

                if (password.value == "" || confpassword.value == "") {
                  passError.classList.remove("hidden");
                  confError.classList.remove("hidden");
                  valid = false;
                }else if(password.value != confpassword.value){
                  confError.classList.remove("hidden");
                  valid = false;
                }

                if(valid){
                  event.preventDefault();
                  let data = {username:username.value, password:password.value};
                  processChangePass(data);
                }
              });
            }
            else
            {
              alert("Account not found.");
            }
          });

          XHR.addEventListener("error", function(event){
            alert('Oops! Something went wrong.');
          });

          XHR.open("POST", "process/process_forgotpass.php");

          XHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

          XHR.send(urlEncodeData);
        }
      });
    });
  }

  /*--------------------------------------
  |
  |           VIEW LIST PAGE
  |   REMOVE LIST
  |   ADD/EDIT/REMOVE ITEM
  |
  --------------------------------------*/
  if (document.title == "View List") {
    console.log(document.title);

    // ADD AN ITEM TO A LIST
    let add_item_button = document.getElementById("additem");
    if(add_item_button != null){
      add_item_button.addEventListener("click", event => {
        document.getElementById('add-modal').style.display = 'block';

        document.getElementById("addItemToDB").addEventListener("click", event => {
          const itemName = document.getElementById("itemname");
          const itemError = document.querySelector("#itemname~span");

          itemError.classList.add("hidden");
          let valid = true;

          if (itemName.value == "") {
            itemError.classList.remove("hidden");
            valid = false;
          }

          if (!valid)
            event.preventDefault();

        });
      }); // END OF ADD ITEM
    }

    // REMOVE A LIST
    let remove_list_button = document.getElementById("removeList");
    if(remove_list_button != null){
      remove_list_button.addEventListener("click", event => {
        document.getElementById('removelist-modal').style.display = 'block';
      }); // END OF REMOVE ITEM
    }

    // EDIT A LIST ITEM
    const edit_button = document.querySelectorAll(".editbutton");
    edit_button.forEach(edit_button =>
      edit_button.addEventListener("click", function () {
        var id = edit_button.value;
        console.log("You are about to edit item: " + id);
        location.href = 'edit_item.php?item=' + id;
      })); // END OF EDIT ITEM

    // REMOVE A LIST ITEM
    const remove_button = document.querySelectorAll(".removebutton");
    remove_button.forEach(remove_button =>
      remove_button.addEventListener("click", function () {
        var listItemId = remove_button.value;

        var response = confirm("This will permanently delete this item from your list");

        if(response){
          var post = new XMLHttpRequest();
          
          let urlEncodeData = "", urlEncodeDataPairs = [];

          urlEncodeDataPairs.push(encodeURIComponent("deleteItem") + '=' + encodeURIComponent(""));
          urlEncodeDataPairs.push(encodeURIComponent("itemDeleted") + '=' + encodeURIComponent(listItemId));
          urlEncodeData = urlEncodeDataPairs.join('&').replace(/%20/g, '+');

          post.open("POST", window.location.href);
          post.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          post.send(urlEncodeData);
        }
      })); // END OF EDIT ITEM

  } // END OF MANAGE LIST PAGE


  /*--------------------------------------
  |
  |           EDIT LIST ITEM PAGE
  |   CANCEL BUTTON
  |
  --------------------------------------*/
  if (document.title == "Edit List Item") {
    document.querySelector("button[name=Cancel]").addEventListener("click", () => {
      var list = document.querySelector("main span").textContent;
      location.href = 'view_list.php?list=' + list;
    });
  } // END OF EDIT LIST ITEM PAGE


  /*--------------------------------------
  |
  |               LIST PAGE
  |   ADD LIST
  |
  --------------------------------------*/
  if (document.title == "Lists") {
    var addlist = document.querySelector("#addlist");
    if(addlist != null){
      addlist.addEventListener("click", () => {
        document.getElementById('create-modal').style.display = 'block';

        // ADD LIST
        document.getElementById("addListToDB").addEventListener("click", event => {
          const listName = document.getElementById("listName");
          const listError = document.querySelector("#listName~span");

          listError.classList.add("hidden");
          let valid = true;

          if (listName.value == "") {
            listError.classList.remove("hidden");
            valid = false;
          }

          if (!valid)
            event.preventDefault();

        });
      });}
  } // END OF LIST PAGE


  /*--------------------------------------
  |
  |           SAMPLE LIST PAGE
  |            VIEW LIST PAGE
  |  VIEW ITEM
  |  SAMPLE ADD ITEM REDIRECT
  |
  --------------------------------------*/
  if (document.title == "Sample List" || document.title == "View List" || document.title == "Results") {
    // VIEW A LIST ITEM
    const view_button = document.querySelectorAll(".viewbutton");

    view_button.forEach(view_button =>
      view_button.addEventListener("click", function () {
        var id = view_button.value;
        let itemid = view_button.value;
        console.log("You are about to view item: " + itemid);

        document.getElementById('view-modal').style.display = 'block';

        var xhttp = new XMLHttpRequest();
        xhttp.open("GET", "api/formfill.php?itemid=" + itemid);

        xhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            let data = JSON.parse(this.responseText);

            document.getElementById("item").value = data.name;
            document.getElementById("description").value = data.description;

            let datefield = document.getElementById("complete");

            if (data.completion != null) {
              datefield.value = data.completion;
              datefield.parentElement.classList.remove("hidden");
            } else {
              datefield.parentElement.classList.add("hidden");
            }

          }
        };
        xhttp.send();
      })); // END OF VIEW ITEM

    if(document.title == "Sample List"){
      const redirect = document.getElementById("additem");

      redirect.addEventListener("click", ev =>{
        location.href="login.php";
      });
    }
  }// END OF SAMPLE LIST AND MANAGE LIST PAGE


  /*--------------------------------------
  |
  |            GLOBAL FUNCTIONS
  |   SET MAX DATE
  |   PASSWORD STRENGTH
  |
  --------------------------------------*/
  // MAX DATE
  var complete = document.getElementById("complete");
  var birthdate = document.getElementById("birthdate");

  if(complete != null || birthdate != null){
    // <!-- SET MAXIMUM DATE THAT LIST ITEM CAN BE COMPLETED -->
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; //January is 0!
    var yyyy = today.getFullYear();
    if (dd < 10) {
      dd = '0' + dd
    }
    if (mm < 10) {
      mm = '0' + mm
    }

    today = yyyy + '-' + mm + '-' + dd;

    if(complete != null)
      complete.setAttribute("max", today);

    else
      birthdate.setAttribute("max", today);
  }


  // CHECKS PASSWORD STRENGTH
  if (document.title == "Account Information"){
    var password = document.getElementById('password');
    var meter = document.getElementById('password-strength');
    var text = document.getElementById('password-strength-text');
    // If user is logged in (Change password in edit accoutn)
    if(password == null){
      password = document.getElementById('new_password');
      meter = document.getElementById('newpassword-strength');
      text = document.getElementById('newpassword-strength-text');
    }

    passwordStrength(password,meter,text);

  }

  /*--------------------------------------
  |
  |           ALL PAGES (NAV)
  |   ADD LIST
  |
  --------------------------------------*/
  var addlistlink = document.querySelector("#add-list-nav");
  if(addlistlink != null){
    addlistlink.addEventListener("click", event => {
      document.getElementById('create-modal').style.display = 'block';

      document.getElementById("addListToDB").addEventListener("click", event => {
        const listName = document.getElementById("listName");
        const listError = document.querySelector("#listName~span");

        listError.classList.add("hidden");
        let valid = true;

        if (listName.value == "") {
          listError.classList.remove("hidden");
          valid = false;
        }

        if (!valid)
          event.preventDefault();

      });
    });
  }// end if addlistlink != null


  /*--------------------------------------
  |
  |        CLOSE BUTTONS FOR MODALS
  |
  --------------------------------------*/
  // Enable close on all modal windows
  const close = document.querySelectorAll(".close");
  close.forEach(close => {
    close.addEventListener("click", (ev) => {
      // console.log(ev.target.parentElement.parentElement.parentElement);
      ev.target.parentElement.parentElement.parentElement.style.display = 'none';
    });
  }); // End close foreach

}); // END OF DOMContentLoaded

/*--------------------------- ADDITIONAL FUNCTIONS ---------------------------*/

/*--------------------------------------
|
|        processChangePass(data)
| Changes password for forgot password
|
--------------------------------------*/
function processChangePass(data){
  const XHR = new XMLHttpRequest();

  let urlEncodeData = "", urlEncodeDataPairs = [];

  urlEncodeDataPairs.push(encodeURIComponent("username") + '=' + encodeURIComponent(data['username']));
  urlEncodeDataPairs.push(encodeURIComponent("new_password") + '=' + encodeURIComponent(data['password']));
  urlEncodeDataPairs.push(encodeURIComponent("forgot-change") + '=' + encodeURIComponent(""));


  urlEncodeData = urlEncodeDataPairs.join('&').replace(/%20/g, '+');

  XHR.addEventListener("load", function(event) {
    if(event.target.responseText == "Success"){
      alert("Password Changed");
      location.href="login.php";
    }
    else {
      alert("Information Passed, password not changed");
    }
  });

  XHR.addEventListener("error", function(event){
    alert('Oops! Something went wrong.');
  });

  XHR.open("POST", "process/process_forgotpass.php");

  XHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  XHR.send(urlEncodeData);
}

/*--------------------------------------
|
|    passwordStrength(password, meter, text)
| Live update of password strength
| Applies to Acccount information, Forgot Password
|
--------------------------------------*/
function passwordStrength(password, meter, text){
  var strength = {
    0: "Weakest",
    1: "Weak",
    2: "OK",
    3: "Good",
    4: "Strong"
  }

  password.addEventListener('keyup', () => {
    var val = password.value;
    var result = zxcvbn(val);

    // This updates the password strength meter
    meter.value = result.score;

    // This updates the password meter text
    if (val !== "") {
      text.innerHTML = "Password Strength: " + strength[result.score];
    } else {
      text.innerHTML = "";
    }
  });
}

function viewItemButton(){

}
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

} // END GOOGLE onSignIn

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

// REQUIRED to log out googleUser (Needs to run on every page)
function onLoad() {
  console.log("onLoad");
  gapi.load('auth2', function(){
    gapi.auth2.init();
  });
}

// Signout button
document.addEventListener("DOMContentLoaded", () =>{
  var signOutLink = document.querySelector("#signOut");
  if(signOutLink != null){
    signOutLink.addEventListener("click", event => {
      event.preventDefault();

      signOut();

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

// Google Signout
function signOut() {
  var auth2 = gapi.auth2.getAuthInstance();
  auth2.signOut().then(function () {
    console.log('User signed out.');
  });
}
