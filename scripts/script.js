"use strict";

window.addEventListener('DOMContentLoaded', () => {
  const emailIsValid = string => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(string);

  var addlistlink = document.querySelector("#add-list-nav");
  var addlist = document.querySelector("#addlist");
  const close = document.querySelectorAll(".close");
  var complete = document.getElementById("complete");
  var birthdate = document.getElementById("birthdate");

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
  }// END OF LOGIN PAGE

  /*--------------------------------------
  |
  |           VIEW LIST PAGE
  |   EDIT/REMOVE LIST
  |   ADD/EDIT/REMOVE ITEM
  |
  --------------------------------------*/
  if (document.title == "View List") {
    console.log(document.title);
    
    let remove_list_button = document.getElementById("removeList");
    let edit_list_button = document.getElementById("editList");
    let add_item_button = document.getElementById("additem");
    const edit_button = document.querySelectorAll(".editbutton");
    const remove_button = document.querySelectorAll(".removebutton");

    // REMOVE A LIST
    if(remove_list_button != null){
      remove_list_button.addEventListener("click", event => {
        var url = new URL(window.location.href);
        var listNo = url.searchParams.get("list");

        var response = prompt("Enter the list name to delete it", "");

        if(response){
          var post = new XMLHttpRequest();

          let urlEncodeData = "", urlEncodeDataPairs = [];

          urlEncodeDataPairs.push(encodeURIComponent("deleteList") + '=' + encodeURIComponent(""));
          urlEncodeDataPairs.push(encodeURIComponent("listName") + '=' + encodeURIComponent(response));
          urlEncodeData = urlEncodeDataPairs.join('&').replace(/%20/g, '+');

          post.addEventListener("load", function(event) {
            console.log("List " + listNo + "removed.")
            location.href= "display_list.php";
          });

          post.open("POST", window.location.href);
          post.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
          post.send(urlEncodeData);
        }
      }); // END OF REMOVE LIST
    }

    // EDIT A LIST
    if(edit_list_button != null){
      edit_list_button.addEventListener("click", event => {
        let listName = document.querySelector("h1").innerText;
        let listView = document.querySelector("h1 i");
        let editButton = document.getElementById("addListToDB");
        let listNumber = document.createElement("input");

        // GET ADDITIONAL INFO FROM URL (?LIST=##)
        let urlParam = new URLSearchParams(window.location.search);
        let list = urlParam.get('list');

        document.getElementById('create-modal').style.display = 'block';
        document.querySelector("label[for=listName]").innerHTML = "List Name";
        document.getElementById("listName").value = listName;
        if(listView.classList == "fa fa-unlock")
          document.getElementById("viewableList").checked = true;

        editButton.name = "edit_list";
        editButton.innerHTML = "Edit List";
        
        listNumber.classList.add("hidden");
        listNumber.name = "listNo";
        listNumber.value = list;

        editButton.parentElement.appendChild(listNumber);
      });
    }

    // ADD AN ITEM TO A LIST
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

        // I FEEL LUCKY
        document.getElementById("feelingLucky").addEventListener("click", event => {
          event.preventDefault();
          
          var xhttp = new XMLHttpRequest();
          xhttp.open("GET", "api/response.php?randid=1");

          xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
              let data = JSON.parse(this.responseText);

              document.getElementById("itemname").value = data.name;
              document.getElementById("luckydescription").value = data.description;

              if (data != null) {
                document.getElementById("luckydescription").parentElement.classList.remove("hidden");
              } else {
                document.getElementById("luckydescription").parentElement.classList.add("hidden");
              }

            }
          };
          xhttp.send();

        });

      }); // END OF ADD ITEM
    }

    // EDIT A LIST ITEM
    if(edit_button != null){
      edit_button.forEach(edit_button =>
      edit_button.addEventListener("click", function () {
        var id = edit_button.value;
        console.log("You are about to edit item: " + id);
        location.href = 'edit_item.php?item=' + id;
      })); // END OF EDIT ITEM
    }
    
    // REMOVE A LIST ITEM
    if(remove_button != null){
      remove_button.forEach(remove_button =>
        remove_button.addEventListener("click", function () {
          var listItemId = remove_button.value;
  
          var response = prompt("Enter the item name to delete it", "");
  
          if(response){
            var post = new XMLHttpRequest();
  
            let urlEncodeData = "", urlEncodeDataPairs = [];
  
            urlEncodeDataPairs.push(encodeURIComponent("deleteItem") + '=' + encodeURIComponent(""));
            urlEncodeDataPairs.push(encodeURIComponent("itemDeleted") + '=' + encodeURIComponent(listItemId));
            urlEncodeDataPairs.push(encodeURIComponent("itemName") + '=' + encodeURIComponent(response));
            urlEncodeData = urlEncodeDataPairs.join('&').replace(/%20/g, '+');
  
            post.addEventListener("load", function(event) {
              console.log("Item " + listItemId + "removed.")
              location.href= window.location.href;
            });
  
            post.open("POST", window.location.href);
            post.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            post.send(urlEncodeData);
          }
        })); // END OF REMOVE ITEM
    }

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
  |           SAMPLE LIST PAGE
  |            VIEW LIST PAGE
  |             RESULTS PAGE
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
        xhttp.open("GET", "api/response.php?itemid=" + itemid);

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
  }// END OF SAMPLE/VIEW/RESULTS PAGE


  /*--------------------------------------
  |
  |              ACCOUNT PAGE
  |   PASSWORD STRENGTH
  |   DELETE ACCOUNT
  |
  --------------------------------------*/
  if (document.title == "Account Information"){
    
    let header = document.querySelector("h1").innerHTML;
    
    let userField = document.getElementById('username');
    let userError = document.querySelector("#username~span");

    var meter = document.getElementById('password-strength');
    var text = document.getElementById('password-strength-text');
    let passwordConf = document.getElementById('password_confirm');
    let passError = document.querySelector("#password_confirm~span");

    let first = document.getElementById('firstname');
    let firstError = document.querySelector("#firstname~span");

    let last = document.getElementById('lastname');
    let lastError = document.querySelector("#lastname~span");

    let email = document.getElementById('email');
    let emailError = document.querySelector("#email~span");

    let dob = document.getElementById('birthdate');
    let dobError = document.querySelector("#birthdate~span");

    let valid = true;

    if(header == "Register"){
      var password = document.getElementById('password');
      var tac = document.getElementById('agreebox');
      var tacError = document.querySelector("#agreebox~span");
      var addAccount = document.getElementById('register');

      // USERNAME FOCUS
      userField.addEventListener("focus", event => {
        userError.classList.add("hidden");
        userField.style.borderColor = "";
      });

      // USERNAME BLUR
      userField.addEventListener("blur", event => {
        let username = userField.value;

        if(username != ""){
          var xhttp = new XMLHttpRequest();
          xhttp.open("GET", "api/response.php?username=" + username);

          xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
              var data = JSON.parse(this.responseText);

              if(data['username'] == username){ 
                userError.innerHTML = "Sorry that username is already taken";             
                userError.classList.remove("hidden");
                userField.style.borderColor = "red";
                valid = false;
              }
              else{
                userError.classList.add("hidden");
                userField.style.borderColor = "black";
                valid = true;
              }

            }
          };
          xhttp.send();
        }

        else{
          userError.innerHTML = "Please enter a username";
          userError.classList.remove("hidden");
          userField.style.borderColor = "red";
          valid = false;
        }
        
      });
    }

    if(header == "Edit Account"){
      var password = document.getElementById('new_password');
      var updateAccount = document.getElementById("update");
      var deleteAccount = document.querySelector("button[name=deleteAccount]");

      password.value = null;
    }

    // If user is logged in (Change password in edit account)
    if(password == null){
      password = document.getElementById('new_password');
      meter = document.getElementById('newpassword-strength');
      text = document.getElementById('newpassword-strength-text');
    }
    passwordStrength(password,meter,text);

    // REGISTRATION VALIDATION
    addAccount.addEventListener("click", event => {
       
      // CHECK PASSWORDS
      if(password.value == "" || password.value != passwordConf.value){
        password.style.borderColor = "red";
        passError.classList.remove("hidden");
        valid = false;
      }
      
      // CHECK FIRST NAME
      if(firstname.value == ""){
        firstname.style.borderColor = "red";
        firstError.classList.remove("hidden");
        valid = false;
      }
      
      // CHECK LAST NAME
      if(lastname.value == ""){
        lastname.style.borderColor = "red";
        lastError.classList.remove("hidden");
        valid = false;
      }

      // CHECK EMAIL
      if(email.value == "" || !emailIsValid(email.value)){
        email.style.borderColor = "red";
        emailError.classList.remove("hidden");
        valid = false;
      }

      // CHECK BIRTHDAY
      if(dob.value != ""){
        if(dob.value < "1900-01-01" || dob.value > getTodaysDate()){
          dob.style.borderColor = "red";
          dobError.classList.remove("hidden");
          valid = false;
        }
      }

      if(!tac.checked){
        tac.style.borderColor = "red";
        tacError.classList.remove("hidden");
        valid = false;
      }

      if(!valid)
        preventDefault();

    });

    // UPDATE VALIDATION
    updateAccount.addEventListener("click", event => {
      // CHECK PASSWORDS
      if(password.value != ""){
        if(password.value != passwordConf.value){
          password.style.borderColor = "red";
          passError.classList.remove("hidden");
          valid = false;
        }
      }
      
      // CHECK FIRST NAME
      if(firstname.value == ""){
        firstname.style.borderColor = "red";
        firstError.classList.remove("hidden");
        valid = false;
      }
      
      // CHECK LAST NAME
      if(lastname.value == ""){
        lastname.style.borderColor = "red";
        lastError.classList.remove("hidden");
        valid = false;
      }

      // CHECK EMAIL
      if(email.value == "" || !emailIsValid(email.value)){
        email.style.borderColor = "red";
        emailError.classList.remove("hidden");
        valid = false;
      }

      // CHECK BIRTHDAY
      if(dob.value != ""){
        if(dob.value < "1900-01-01" || dob.value > getTodaysDate()){
          dob.style.borderColor = "red";
          dobError.classList.remove("hidden");
          valid = false;
        }
      }

      if(!valid)
        preventDefault();
    });

    // DELETE ACCOUNT
    deleteAccount.addEventListener("click", event => {
      var response = confirm("This will permanently delete your account. You will have no way to restore your account or retrieve list/list items after this process");

      if(response){
        var post = new XMLHttpRequest();

        let urlEncodeData = "", urlEncodeDataPairs = [];

        urlEncodeDataPairs.push(encodeURIComponent("deleteAccount") + '=' + encodeURIComponent(""));
        urlEncodeData = urlEncodeDataPairs.join('&').replace(/%20/g, '+');

        post.addEventListener("load", function(event) {
          console.log("Account Deleted.")
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
          location.href= "login.php";
        });

        post.open("POST", window.location.href);
        post.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        post.send(urlEncodeData);
      }

    });
  }// END OF ACCOUTN PAGE

  /*--------------------------------------
  |
  |               ADD LISTS
  | FROM NAV OR ON MANAGE PAGE
  |
  --------------------------------------*/
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
    });
  }// END OF ADD LIST


  /*--------------------------------------
  |
  |        CLOSE BUTTONS FOR MODALS
  |
  --------------------------------------*/
  // Enable close on all modal windows
  if(close != null){
    close.forEach(close => {
      close.addEventListener("click", (ev) => {
        ev.target.parentElement.parentElement.parentElement.style.display = 'none';
      });
    }); // End close foreach
  }// END OF CLOSE
  
  /*--------------------------------------
  |
  |             SET MAX DATE
  |
  --------------------------------------*/
  // MAX DATE
  if(complete != null || birthdate != null){
    // <!-- SET MAXIMUM DATE THAT LIST ITEM CAN BE COMPLETED -->
    if(complete != null)
      complete.setAttribute("max", getTodaysDate());

    else
      birthdate.setAttribute("max", getTodaysDate());
  }// END OF MAX DATE

}); // END OF DOMContentLoaded


/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/
/*--------------------------- ADDITIONAL FUNCTIONS ---------------------------*/
/*----------------------------------------------------------------------------*/
/*----------------------------------------------------------------------------*/


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
}// END OF PROCESS CHANGE PASS

/*--------------------------------------
|
|           getTodaysDate()
| Get the current date in the format
| yyyy-mm-dd
|
--------------------------------------*/
function getTodaysDate(){
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

  return today;
}// END OF GET TODAYS DATE

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
}// END OF PASSWORD STRENGTH