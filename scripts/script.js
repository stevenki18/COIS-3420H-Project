/*-------------------------------------------------------
|
|   PAGE:           script.js
|
|   DESCRIPTION:    All javascript that is applied to
|                   the site can be found here
|
-------------------------------------------------------*/
"use strict";

/*--------------------------------------
|
|           DOM CONTENT LOADED
|
--------------------------------------*/
window.addEventListener('DOMContentLoaded', () => {
    const emailIsValid = string => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(string);

    const close = document.querySelectorAll(".close");
    const view_button = document.querySelectorAll(".viewbutton");

    var addlistlink = document.querySelector("#add-list-nav");
    var addlist = document.querySelector("#addlist");
    var complete = document.getElementById("complete");
    var birthdate = document.getElementById("birthdate");
    var imagelink = document.getElementById("image");
    var navIcon = document.getElementById("nav-icon");
    var viewList = document.querySelectorAll(".viewList");

    /*--------------------------------------
    |
    |   PAGE:       Login
    |   
    |   HANDLES:    Forgot password modal
    |               and register redirect
    |
    --------------------------------------*/
    if (document.title == "Login") {
        
        /*-----------------------------
        |
        |   OPEN FORGOT PASSWORD MODAL
        |
        -----------------------------*/
        document.getElementById("forgot").addEventListener("click", () => {
            const checker = document.querySelector("#forgotCheck");
            const changer = document.querySelector("#forgotChange");
            const username = document.querySelector("#forgotCheck>input");
            const email = document.querySelector("#forgotCheck>input:last-of-type");
            
            // Set up the modal sections
            checker.classList.remove("hidden");
            changer.classList.add("hidden");

            // Open Modal
            document.getElementById('forgotpass').style.display = 'block';

            // Process forgot-checker
            document.getElementById("forgot-check").addEventListener("click", event => {
                let valid = true;
                const userError = document.querySelector("#forgotCheck>span");
                const emailError = document.querySelector("#forgotCheck>span:last-of-type");

                userError.classList.add("hidden");
                emailError.classList.add("hidden");

                if (username.value == "") {
                    userError.classList.remove("hidden");
                    valid = false;
                }
                
                else if (email.value == "") {
                    emailError.classList.remove("hidden");
                    valid = false;
                }
                
                else if (!emailIsValid(email.value)) {
                    emailError.classList.remove("hidden");
                    valid = false;
                }

                if (valid) {
                    event.preventDefault();
                    // Process POST
                    const XHR = new XMLHttpRequest();

                    let urlEncodeData = "", urlEncodeDataPairs = [];

                    urlEncodeDataPairs.push(encodeURIComponent("username") + '=' + encodeURIComponent(username.value));
                    urlEncodeDataPairs.push(encodeURIComponent("email") + '=' + encodeURIComponent(email.value));
                    urlEncodeDataPairs.push(encodeURIComponent("forgot-check") + '=' + encodeURIComponent(""));

                    urlEncodeData = urlEncodeDataPairs.join('&').replace(/%20/g, '+');

                    XHR.addEventListener("load", function (event) {
                        // SWITCH TO PASSWORD RESET OPTION
                        if (event.target.responseText == "User Found") {
                            alert("User Found");
                            checker.classList.add("hidden");
                            changer.classList.remove("hidden");

                            var password = document.querySelector('#forgotChange>input');
                            var meter = document.getElementById('forgotpassword-strength');
                            var text = document.getElementById('forgotpassword-strength-text');

                            passwordStrength(password, meter, text);

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
                                }
                                
                                else if (password.value != confpassword.value) {
                                    confError.classList.remove("hidden");
                                    valid = false;
                                }

                                if (valid) {
                                    event.preventDefault();
                                    let data = {
                                        username: username.value,
                                        password: password.value
                                    };
                                    processChangePass(data);
                                }
                            });
                        } 
                        else
                            alert("Account not found.");
                    });

                    XHR.addEventListener("error", function (event) {
                        alert('Oops! Something went wrong.');
                    });

                    XHR.open("POST", "process/process_forgotpass.php");

                    XHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    XHR.send(urlEncodeData);
                }
            });
        });

        /*-----------------------------
        |
        |   REDIRECT TO ACCOUNTS PAGE
        |
        -----------------------------*/
        document.getElementById("register").addEventListener("click", event => {
            location = "accounts.php";
        });

    } // END OF LOGIN PAGE


    /*--------------------------------------
    |
    |   PAGE:       View List
    |
    |   HANDLES:    Edit/remove list and
    |               add/edit/remove item
    |
    --------------------------------------*/
    if (document.title == "View List") {

        let remove_list_button = document.getElementById("removeList");
        let edit_list_button = document.getElementById("editList");
        let add_item_button = document.getElementById("additem");
        const edit_button = document.querySelectorAll(".editbutton");
        const remove_button = document.querySelectorAll(".removebutton");

        /*---------------------------*/
        /*----- LIST OPERATIONS -----*/
        /*---------------------------*/

        /*-----------------------------
        |
        |          REMOVE LIST
        |
        -----------------------------*/
        if (remove_list_button != null) {
            remove_list_button.addEventListener("click", event => {
                var url = new URL(window.location.href);
                var listNo = url.searchParams.get("list");

                // PROMPT USER TO INPUT LIST NAME TO CONFIRM DELETE
                var response = prompt("Enter the list name to delete it", "");

                // IF FILLED OUT POST TO SELF
                if (response) {
                    var post = new XMLHttpRequest();
                    let urlEncodeData = "", urlEncodeDataPairs = [];

                    urlEncodeDataPairs.push(encodeURIComponent("deleteList") + '=' + encodeURIComponent(""));
                    urlEncodeDataPairs.push(encodeURIComponent("listName") + '=' + encodeURIComponent(response));
                    urlEncodeData = urlEncodeDataPairs.join('&').replace(/%20/g, '+');

                    // SUCCESSFUL DELETE; REDIRECT
                    post.addEventListener("load", function (event) {
                        console.log("List " + listNo + "removed.")
                        location.href = "display_list.php";
                    });

                    post.open("POST", window.location.href);
                    post.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    post.send(urlEncodeData);
                }
            }); // END OF REMOVE LIST
        }// END OF REMOVE LIST

        
        /*-----------------------------
        |
        |          EDIT LIST
        |
        -----------------------------*/
        if (edit_list_button != null) {
            edit_list_button.addEventListener("click", event => {
                let listName = document.querySelector("h1").innerText;
                let listView = document.querySelector("h1 i");
                let editButton = document.getElementById("addListToDB");
                let listNumber = document.createElement("input");

                // GET ADDITIONAL INFO FROM URL (?LIST=##)
                let urlParam = new URLSearchParams(window.location.search);
                let list = urlParam.get('list');

                // EDIT LIST REUSES THE ADD LIST MODAL AND PROCESSES IN THE SAME PAGE
                // PROCESS_ADD_LIST.PHP
                document.getElementById('create-modal').style.display = 'block';
                document.querySelector("label[for=listName]").innerHTML = "List Name";
                document.getElementById("listName").value = listName;

                if (listView.classList == "fa fa-unlock")
                    document.getElementById("viewableList").checked = true;

                editButton.name = "edit_list";
                editButton.innerHTML = "Update List";

                listNumber.classList.add("hidden");
                listNumber.name = "listNo";
                listNumber.value = list;

                editButton.parentElement.appendChild(listNumber);
            });
        }// END OF EDIT LIST


        /*---------------------------*/
        /*----- ITEM OPERATIONS -----*/
        /*---------------------------*/

        /*-----------------------------
        |
        |          ADD ITEM
        |
        -----------------------------*/
        if (add_item_button != null) {
            add_item_button.addEventListener("click", event => {
                document.getElementById('add-modal').style.display = 'block';

                // FORM VALIDATION
                document.getElementById("addItemToDB").addEventListener("click", event => {
                    const itemName = document.getElementById("itemname");
                    const itemError = document.querySelector("#itemname~span");
                    let valid = true;

                    itemError.classList.add("hidden");
                    
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
                    
                    // REMOVES ERROR IF PRESENT
                    document.querySelector("#itemname~span").classList.add("hidden");

                    // JSON FETCH FOR A RANDOM PUBLIC ITEM
                    var xhttp = new XMLHttpRequest();
                    xhttp.open("GET", "api/response.php?randid=1");

                    // FILL APPROPRIATE FIELDS
                    xhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            let data = JSON.parse(this.responseText);

                            document.getElementById("itemname").value = data.name;
                            document.getElementById("luckydescription").value = data.description;

                            if (data != null)
                                document.getElementById("luckydescription").parentElement.classList.remove("hidden");
                            
                            else
                                document.getElementById("luckydescription").parentElement.classList.add("hidden");
                            

                        }
                    };

                    xhttp.send();

                });

            }); 
        }// END OF ADD ITEM


        /*-----------------------------
        |
        |          EDIT ITEM
        |
        -----------------------------*/
        if (edit_button != null) {
            edit_button.forEach(edit_button =>
                edit_button.addEventListener("click", function () {
                    // REDIRECT TO EDIT ITEM PAGE
                    location.href = 'edit_item.php?item=' + edit_button.value;
                })); 
        }// END OF EDIT ITEM

        
        /*-----------------------------
        |
        |          REMOVE ITEM
        |
        -----------------------------*/
        if (remove_button != null) {
            remove_button.forEach(remove_button =>
                remove_button.addEventListener("click", function () {
                    var listItemId = remove_button.value;

                    // PROMPT USER TO INPUT ITEM NAME TO CONFIRM DELETE
                    var response = prompt("Enter the item name to delete it", "");

                    // IF FILLED OUT POST TO SELF
                    if (response) {
                        var post = new XMLHttpRequest();

                        let urlEncodeData = "", urlEncodeDataPairs = [];

                        urlEncodeDataPairs.push(encodeURIComponent("deleteItem") + '=' + encodeURIComponent(""));
                        urlEncodeDataPairs.push(encodeURIComponent("itemDeleted") + '=' + encodeURIComponent(listItemId));
                        urlEncodeDataPairs.push(encodeURIComponent("itemName") + '=' + encodeURIComponent(response));
                        urlEncodeData = urlEncodeDataPairs.join('&').replace(/%20/g, '+');

                        // SUCCESSFUL DELETE; REDIRECT
                        post.addEventListener("load", function (event) {
                            console.log("Item " + listItemId + "removed.")
                            location.href = window.location.href;
                        });

                        post.open("POST", window.location.href);
                        post.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        post.send(urlEncodeData);
                    }
                })); 
        }// END OF REMOVE ITEM

    }// END OF VIEW LIST PAGE


    /*--------------------------------------
    |
    |   PAGE:       Edit List
    |
    |   HANDLES:    Cancel button and image
    |               removal as well as form 
    |               validation
    |
    --------------------------------------*/
    if (document.title == "Edit List Item") {
        var itemName = document.getElementById('itemname');
        var nameError = document.querySelector("#itemname~span");
        var compError = document.querySelector("#complete~span");
        var filePath = document.getElementById('file');
        var fileError = document.querySelector("#file~span");
        var editButton = document.querySelector('button[name=save]');
        var clearButton = document.querySelector("button[name=Clear]");
        var cancelButton = document.querySelector("button[name=Cancel]")
        var removeImgButton = document.querySelector("button[name=remove-image]");
        let valid = true;


        /*-----------------------------
        |
        |          ITEM NAME
        |
        |   ** FOCUS AND BLUR
        |
        -----------------------------*/
        // FOCUS
        itemName.addEventListener("focus", event => {
            itemName.style.border = "";
            nameError.classList.add("hidden");
        });// END OF FOCUS

        // BLUR
        itemName.addEventListener("blur", event => {
            if (itemName.value == "") {
                itemName.style.border = "red";
                nameError.classList.remove("hidden");
                valid = false;
            }

            if (itemName.value != "") {
                itemName.style.border = "";
                fileError.classList.add("hidden");
                valid = true;
            }
        });// END OF BLUR


        /*-----------------------------
        |
        |        COMPLETION DATE
        |
        |   ** FOCUS AND BLUR
        |
        |   ** FIX FOR SAFARI AS THERE
        |      IS NO DATE PICKER SO 
        |      DATE MUST BE ENTERED AS
        |      STRING
        |
        -----------------------------*/
        // FOCUS
        complete.addEventListener("focus", (ev) => {
            complete.style.border = "";
            compError.classList.add("hidden");
        });// END OF FOCUS

        // BLUR
        complete.addEventListener("blur", (ev) => {
            if (complete.value != "") {
                if (complete.value < "1900-01-01" || complete.value > getTodaysDate()) {
                    complete.style.borderColor = "red";
                    compError.classList.remove("hidden");
                    valid = false;
                }
            }
        });// END OF BLUR


        /*-----------------------------
        |
        |        FILE PATH
        |
        |   ** FOCUS AND BLUR
        |
        -----------------------------*/
        if (filePath != null) {
            // FOCUS
            filePath.addEventListener("focus", event => {
                fileError.classList.add("hidden");
            });// FOCUS

            // BLUR
            filePath.addEventListener("blur", event => {
                if (filePath.files[0] != null && filePath.files[0].size > 1000000) {
                    fileError.classList.remove("hidden");
                    valid = false;
                    clearButton.classList.remove("hidden");
                }
                else if (filePath.files[0] != null)
                    clearButton.classList.remove("hidden");
            });// END OF BLUR
        }// END OF FILE PATH


        /*-----------------------------
        |
        |         CLEAR BUTTON
        |
        -----------------------------*/
        if (clearButton != null) {
            clearButton.addEventListener("click", event => {
                filePath.value = "";
                document.querySelector("#file~span").classList.add("hidden");
                clearButton.classList.add("hidden");
            });
        }// END OF CLEAR BUTTON


        /*-----------------------------
        |
        |         EDIT BUTTON
        |
        -----------------------------*/
        editButton.addEventListener("click", event => {
            if (!valid)
                event.preventDefault();
        });// END OF EDIT BUTTON


        /*-----------------------------
        |
        |        REMOVE IMAGE
        |
        -----------------------------*/
        if (removeImgButton != null) {
            removeImgButton.addEventListener("click", event => {
                event.preventDefault();

                // PROMPT USER TO CONFIRM DELETE
                var response = confirm("Are you sure you want to delete the image?");

                // IF FILLED OUT POST TO SELF
                if (response) {
                    var post = new XMLHttpRequest();
                    let urlEncodeData = "", urlEncodeDataPairs = [];

                    urlEncodeDataPairs.push(encodeURIComponent("remove-image") + '=' + encodeURIComponent(""));
                    urlEncodeData = urlEncodeDataPairs.join('&').replace(/%20/g, '+');

                    // SUCCESSFULL DELETE; RELOAD
                    post.addEventListener("load", function (event) {
                        location.reload();
                    });

                    post.open("POST", window.location.href);
                    post.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    post.send(urlEncodeData);
                }
            });
        }// END OF REMOVE IMAG


        /*-----------------------------
        |
        |         CANCEL BUTTON
        |
        -----------------------------*/
        cancelButton.addEventListener("click", () => {
            location.href = 'view_list.php?list=' + cancelButton.value;
        });// END OF CANCEL

    } // END OF EDIT LIST ITEM PAGE


    /*--------------------------------------
    |
    |   PAGE:       Account Information
    |
    |   HANDLES:    Password strength and 
    |               delete account as well 
    |               as form validation
    |
    --------------------------------------*/
    if (document.title == "Account Information") {

        let header = document.querySelector("h1").innerHTML;
        let userField = document.getElementById('username');
        let userError = document.querySelector("#username~span");
        var meter = document.getElementById('password-strength');
        var text = document.getElementById('password-strength-text');
        let passwordConf = document.getElementById('password_confirm');
        let passError = document.querySelector("#password_confirm~span");
        let strengthError = document.querySelector("#newpassword-strength-text~span");
        let first = document.getElementById('firstname');
        let firstError = document.querySelector("#firstname~span");
        let last = document.getElementById('lastname');
        let lastError = document.querySelector("#lastname~span");
        let email = document.getElementById('email');
        let emailError = document.querySelector("#email~span");
        let birthdateError = document.querySelector("#birthdate~span");
        let valid = true;


        /*-----------------------------
        |
        |          ITEM NAME
        |
        |   ** FOCUS AND BLUR
        |
        -----------------------------*/
        // FOCUS
        birthdate.addEventListener("focus", (ev) => {
            birthdate.style.border = "";
            birthdateError.classList.add("hidden");
        });// END OF FOCUS

        // BLUR
        birthdate.addEventListener("blur", (ev) => {
            if (birthdate.value != "") {
                if (birthdate.value < "1900-01-01" || birthdate.value > getTodaysDate()) {
                    birthdate.style.borderColor = "red";
                    birthdateError.classList.remove("hidden");
                    valid = false;
                }
            }
        });// END OF BLUR


        
        if (header == "Register") {
            var password = document.getElementById('password');
            strengthError = document.querySelector("#password-strength-text~span");
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

                if (username != "") {
                    var xhttp = new XMLHttpRequest();
                    xhttp.open("GET", "api/response.php?username=" + username);

                    xhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            var data = JSON.parse(this.responseText);

                            if (data != null) {
                                if (data['username'] == username) {
                                    userError.innerHTML = "Sorry that username is already taken";
                                    userError.classList.remove("hidden");
                                    userField.style.borderColor = "red";
                                    valid = false;
                                } else {
                                    userError.classList.add("hidden");
                                    userField.style.borderColor = "black";
                                    valid = true;
                                }
                            }
                        }
                    };
                    xhttp.send();
                } else {
                    userError.innerHTML = "Please enter a username";
                    userError.classList.remove("hidden");
                    userField.style.borderColor = "red";
                    valid = false;
                }

            });
        }

        if (header == "Edit Account Information") {
            var newpassword = document.getElementById('new_password');
            strengthError = document.querySelector("#newpassword-strength-text~span");
            var updateAccount = document.getElementById("update");
            var deleteAccount = document.querySelector("button[name=deleteAccount]");
            password = document.getElementById('new_password');
            meter = document.getElementById('newpassword-strength');
            text = document.getElementById('newpassword-strength-text');

            newpassword.value = null;
        }

        passwordStrength(password, meter, text);

        // PASSWORD FOCUS
        password.addEventListener("focus", event => {
            strengthError.classList.add("hidden");
            password.style.borderColor = "";
        });

        // PASSWORD BLUR
        password.addEventListener("blur", event => {
            if ((header == "Edit Account Information" && password.value != "") || header == "Register") {
                if (meter.value < 2) {
                    strengthError.classList.remove("hidden");
                    password.style.borderColor = "red";
                    valid = false;
                } else {
                    strengthError.classList.add("hidden");
                    password.style.borderColor = "black";
                    valid = true;
                }
            }
        });






        // REGISTRATION VALIDATION
        if (addAccount != null) {
            addAccount.addEventListener("click", event => {

                // CHECK PASSWORDS
                if (password.value == "" || password.value != passwordConf.value) {
                    password.style.borderColor = "red";
                    passError.classList.remove("hidden");
                    valid = false;
                }

                // CHECK FIRST NAME
                if (firstname.value == "") {
                    firstname.style.borderColor = "red";
                    firstError.classList.remove("hidden");
                    valid = false;
                }

                // CHECK LAST NAME
                if (lastname.value == "") {
                    lastname.style.borderColor = "red";
                    lastError.classList.remove("hidden");
                    valid = false;
                }

                // CHECK EMAIL
                if (email.value == "" || !emailIsValid(email.value)) {
                    email.style.borderColor = "red";
                    emailError.classList.remove("hidden");
                    valid = false;
                }

                // CHECK BIRTHDAY
                if (birthdate.value != "") {
                    if (birthdate.value < "1900-01-01" || birthdate.value > getTodaysDate()) {
                        birthdate.style.borderColor = "red";
                        birthdateError.classList.remove("hidden");
                        valid = false;
                    }
                }

                if (!tac.checked) {
                    tac.style.borderColor = "red";
                    tacError.classList.remove("hidden");
                    valid = false;
                }

                if (!valid)
                    event.preventDefault();

            });
        }

        // UPDATE VALIDATION
        if (updateAccount != null) {
            updateAccount.addEventListener("click", event => {
                // CHECK PASSWORDS
                if (password.value != "") {
                    if (password.value != passwordConf.value) {
                        password.style.borderColor = "red";
                        passError.classList.remove("hidden");
                        valid = false;
                    }
                }

                // CHECK FIRST NAME
                if (firstname.value == "") {
                    firstname.style.borderColor = "red";
                    firstError.classList.remove("hidden");
                    valid = false;
                }

                // CHECK LAST NAME
                if (lastname.value == "") {
                    lastname.style.borderColor = "red";
                    lastError.classList.remove("hidden");
                    valid = false;
                }

                // CHECK EMAIL
                if (email.value == "" || !emailIsValid(email.value)) {
                    email.style.borderColor = "red";
                    emailError.classList.remove("hidden");
                    valid = false;
                }

                // CHECK BIRTHDAY
                if (birthdate.value != "") {
                    if (birthdate.value < "1900-01-01" || birthdate.value > getTodaysDate()) {
                        birthdate.style.borderColor = "red";
                        birthdateError.classList.remove("hidden");
                        valid = false;
                    }
                }

                if (!valid)
                    event.preventDefault();
            });
        }
        // DELETE ACCOUNT
        if (deleteAccount != null) {
            deleteAccount.addEventListener("click", event => {
                var response = prompt("This will permanently delete your account. \nYou will have no way to restore your account or retrieve list/list items after this process. \nEnter Username to confirm", "");

                if (response == username.value) {
                    var post = new XMLHttpRequest();

                    let urlEncodeData = "",
                        urlEncodeDataPairs = [];

                    urlEncodeDataPairs.push(encodeURIComponent("deleteAccount") + '=' + encodeURIComponent(""));
                    urlEncodeData = urlEncodeDataPairs.join('&').replace(/%20/g, '+');

                    post.addEventListener("load", function (event) {
                        console.log("Account Deleted.")
                        const XHR = new XMLHttpRequest();

                        let urlEncodeData = "",
                            urlEncodeDataPairs = [];

                        urlEncodeDataPairs.push(encodeURIComponent("logout") + '=' + encodeURIComponent(""));

                        urlEncodeData = urlEncodeDataPairs.join('&').replace(/%20/g, '+');

                        XHR.addEventListener("load", function (event) {
                            console.log(event.target.responseText);
                            if (event.target.responseText == "Logged Out") {
                                alert("Successfully Logged Out");
                                location.href = "login.php";
                            } else {
                                alert("Information Passed, but not logged out");
                            }
                        });

                        XHR.addEventListener("error", function (event) {
                            alert('Oops! Something went wrong.');
                        });

                        XHR.open("POST", "login.php");

                        XHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                        XHR.send(urlEncodeData);
                        location.href = "login.php";
                    });

                    post.open("POST", window.location.href);
                    post.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    post.send(urlEncodeData);
                }

            });
        }
    } // END OF ACCOUNT PAGE

    
    /*--------------------------------------
    |
    |           VIEW ITEM
    |  SAMPLE ADD ITEM REDIRECT
    |
    --------------------------------------*/
    // VIEW A LIST ITEM

    if (view_button != null) {
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
                        if (data.picpath != null) {
                            imagelink.classList.remove("hidden");
                            imagelink.setAttribute("src", data.picpath);
                            imagelink.setAttribute("alt", data.name);
                        } else {
                            imagelink.classList.add("hidden");
                        }

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
            })
        );
    } // END OF VIEW ITEM

    if (document.title == "Sample List") {
        const redirect = document.getElementById("additem");

        redirect.addEventListener("click", ev => {
            location.href = "login.php";
        });
    }


    /*--------------------------------------
    |
    |               ADD LISTS
    | FROM NAV OR ON MANAGE PAGE
    |
    --------------------------------------*/
    if (addlistlink != null) {
        addlistlink.addEventListener("click", event => {
            let addButton = document.getElementById("addListToDB");
            const listName = document.getElementById("listName");
            const listError = document.querySelector("#listName~span");

            document.getElementById("listName").value = "";

            addButton.name = "submitList";
            addButton.innerHTML = "Add List";
            listError.classList.add("hidden");

            document.getElementById('create-modal').style.display = 'block';

            document.getElementById("addListToDB").addEventListener("click", event => {
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
    } // end if addlistlink != null

    if (addlist != null) {
        addlist.addEventListener("click", () => {
            let addButton = document.getElementById("addListToDB");
            document.getElementById("listName").value = "";

            addButton.name = "submitList";
            addButton.innerHTML = "Add List";

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
    } // END OF ADD LIST

    /*--------------------------------------
    |
    |        OPEN IMAGE IN MODAL
    |
    --------------------------------------*/
    if (imagelink != null) {
        imagelink.addEventListener("click", function () {
            document.getElementById('image-modal').style.display = 'block';

            // Get the image and insert it inside the modal - use its "alt" text as a caption
            var img = document.getElementById("myImg");
            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;

        });
    } // END OF IMAGE CLICK



    /*--------------------------------------
    |
    |        CLOSE BUTTONS FOR MODALS
    |
    --------------------------------------*/
    // Enable close on all modal windows
    if (close != null) {
        close.forEach(close => {
            close.addEventListener("click", (ev) => {
                ev.target.parentElement.parentElement.parentElement.style.display = 'none';
            });
        }); // End close foreach
    } // END OF CLOSE

    /*--------------------------------------
    |
    |             SET MAX DATE
    |
    --------------------------------------*/
    // MAX DATE
    if (complete != null || birthdate != null) {
        // <!-- SET MAXIMUM DATE THAT LIST ITEM CAN BE COMPLETED -->
        if (complete != null) {
            complete.setAttribute("max", getTodaysDate());
            if (complete.type != "date") {
                complete.setAttribute("placeholder", "yyyy-mm-dd");
                // Complete validation (if not supported)
            }
        } else {
            birthdate.setAttribute("max", getTodaysDate());
            if (birthdate.type != "date") {
                birthdate.setAttribute("placeholder", "yyyy-mm-dd");
            }
        }
    } // END OF MAX DATE


    /*--------------------------------------
    |
    |             DROP DOWN ON NAV
    |
    --------------------------------------*/
    // LISTS DROPDOWN
    navIcon.addEventListener("click", () => {
        var listsdropdown = document.getElementById("myTopnav");
        console.log(listsdropdown);
        if (listsdropdown.className === "topnav") {
            listsdropdown.className += " responsive";
        } else {
            listsdropdown.className = "topnav";
        }
    }); // END OF LISTS DROPDOWN


    // EDIT A LIST ITEM
    if (viewList != null) {
        viewList.forEach(viewList =>
            viewList.addEventListener("click", event => {
                location.href = "view_list.php?list=" + viewList.value;
            }));
    } // END OF EDIT ITEM

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
function processChangePass(data) {
    const XHR = new XMLHttpRequest();

    let urlEncodeData = "",
        urlEncodeDataPairs = [];

    urlEncodeDataPairs.push(encodeURIComponent("username") + '=' + encodeURIComponent(data['username']));
    urlEncodeDataPairs.push(encodeURIComponent("new_password") + '=' + encodeURIComponent(data['password']));
    urlEncodeDataPairs.push(encodeURIComponent("forgot-change") + '=' + encodeURIComponent(""));


    urlEncodeData = urlEncodeDataPairs.join('&').replace(/%20/g, '+');

    XHR.addEventListener("load", function (event) {
        if (event.target.responseText == "Success") {
            alert("Password Changed");
            location.href = "login.php";
        } else {
            alert("Information Passed, password not changed");
        }
    });

    XHR.addEventListener("error", function (event) {
        alert('Oops! Something went wrong.');
    });

    XHR.open("POST", "process/process_forgotpass.php");

    XHR.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    XHR.send(urlEncodeData);
} // END OF PROCESS CHANGE PASS

/*--------------------------------------
|
|           getTodaysDate()
| Get the current date in the format
| yyyy-mm-dd
|
--------------------------------------*/
function getTodaysDate() {
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
} // END OF GET TODAYS DATE

/*--------------------------------------
|
|    passwordStrength(password, meter, text)
| Live update of password strength
| Applies to Acccount information, Forgot Password
|
--------------------------------------*/
function passwordStrength(password, meter, text) {
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
} // END OF PASSWORD STRENGTH