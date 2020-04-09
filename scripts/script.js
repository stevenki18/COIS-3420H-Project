"use strict";

window.addEventListener('DOMContentLoaded', () => {
  // console.log(document);

  /*--------------------------------------
  |
  |           MANAGE LIST PAGE
  |
  --------------------------------------*/
  if (document.title == "Manage List") {
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

    // Enable close on all modal windows
    const close = document.querySelectorAll(".close");
    console.log(close);

    close.forEach(close => {
      close.addEventListener("click", (ev) => {
        console.log(ev.target.parentElement.parentElement.parentElement);
        ev.target.parentElement.parentElement.parentElement.style.display = 'none';
      });
    }); // End close foreach

    // EDIT A LIST ITEM
    const edit_button = document.querySelectorAll(".editbutton");

    edit_button.forEach(edit_button =>
      edit_button.addEventListener("click", function () {
        var id = edit_button.value;
        console.log("You are about to edit item: " + id);
        location.href = 'edit_item.php?item=' + id;
      })); // END OF EDIT ITEM
  } // END OF MANAGE LIST PAGE


  /*--------------------------------------
  |
  |           EDIT LIST ITEM PAGE
  |
  --------------------------------------*/
  if (document.title == "Edit List Item") {
    document.querySelector("button[name=Cancel]").addEventListener("click", () => {
      var list = document.querySelector("main span").textContent;
      location.href = 'view_list.php?list=' + list;
    });


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
    document.getElementById("complete").setAttribute("max", today);
  } // END OF EDIT LIST ITEM PAGE


  /*--------------------------------------
  |
  |           SAMPLE LIST PAGE
  |
  --------------------------------------*/
  if (document.title == "Sample List") {
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

    // Enable close on all modal windows
    const close = document.querySelectorAll(".close");
    console.log(close);

    close.forEach(close => {
      close.addEventListener("click", (ev) => {
        console.log(ev.target.parentElement.parentElement.parentElement);
        ev.target.parentElement.parentElement.parentElement.style.display = 'none';
      });
    }); // End close foreach
  }// END OF SAMPLE LIST AND MANAGE LIST PAGE


  /*--------------------------------------
  |
  |           EDIT LIST ITEM PAGE
  |
  --------------------------------------*/
  // if (document.title == "Lists") {
  //   document.querySelector("#addlist").addEventListener("click", () => {
  //     document.getElementById('create-modal').style.display = 'block';
  //
  //     document.getElementById("addListToDB").addEventListener("click", event => {
  //       const listName = document.getElementById("listName");
  //       const listError = document.querySelector("#listName~span");
  //
  //       listError.classList.add("hidden");
  //       let valid = true;
  //
  //       if (listName.value == "") {
  //         listError.classList.remove("hidden");
  //         valid = false;
  //       }
  //
  //       if (!valid)
  //         event.preventDefault();
  //
  //     });
  //   });
  // } // END OF EDIT LIST ITEM PAGE

  /*--------------------------------------
  |
  |           Once NAV has add list
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


});


/* -------------------------------------------------
|
|       GOOGLE SCRIPT STUFF (MODIFIED FOR USE)
|
---------------------------------------------------*/

function onSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();
  console.log('Full Name: ' + profile.getName());
  console.log('Given Name: ' + profile.getGivenName()); // Do not send to your backend! Use an ID token instead.
  console.log('Family Name: ' + profile.getFamilyName());
  console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
  console.log("id: " + googleUser.getId()); // This will be the users password

  let data = {email:profile.getEmail(), firstname:profile.getGivenName(),
              lastname:profile.getFamilyName(), password: googleUser.getId()};

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

  XHR.open("POST", "https://loki.trentu.ca/~stevenki/3420/project/login.php");

  XHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  XHR.send(urlEncodeData);

} // END GOOGLE onSignIn

function createnew(data){
  console.log(data);
  const XHR = new XMLHttpRequest();
  // let formElement = document.querySelector("#login");

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

  XHR.open("POST", "https://loki.trentu.ca/~stevenki/3420/project/accounts.php");

  XHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  XHR.send(urlEncodeData);
} // END CREATE NEW ACCOUNT OFF GOOGLE SIGN IN

function onLoad() {
  console.log("onLoad");
  gapi.load('auth2', function(){
    gapi.auth2.init();
  });
}

var signOutLink = document.querySelector("#signOut");
if(signOutLink != null){
  signOutLink.addEventListener("click", event => {
    event.preventDefault();
    signOut();
    location.href="~logout.php";
  });
}

function signOut() {
  var auth2 = gapi.auth2.getAuthInstance();
  auth2.signOut().then(function () {
    console.log('User signed out.');
  });
}
