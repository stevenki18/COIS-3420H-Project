"use strict";

window.addEventListener('DOMContentLoaded', () => {
  console.log(document);

  // Applies to manage List page
  if(document.title == "Manage List"){
    console.log(document.title);

    // ADD AN ITEM TO A LIST
    document.getElementById("additem").addEventListener("click", event => {
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

    // EDIT A LIST ITEM
    const edit_button = document.querySelectorAll(".editbutton");

    edit_button.forEach(edit_button =>
        edit_button.addEventListener("click", function () {
            var id = edit_button.value;
            console.log("You are about to edit item: " + id);
            location.href='edit_item.php?item='+id;
        })); // END OF EDIT ITEM

    // VIEW A LIST ITEM
    const view_button = document.querySelectorAll(".viewbutton");

    view_button.forEach(view_button =>
        view_button.addEventListener("click", function () {
            var id = view_button.value;
            let itemid = view_button.value;
            console.log("You are about to view item: " + itemid);

            document.getElementById('view-modal').style.display = 'block';


            var xhttp = new XMLHttpRequest();
            xhttp.open("GET", "api/formfill.php?itemid="+itemid);

            xhttp.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200){
                  let data = JSON.parse(this.responseText);
                  // console.log(data);

                  document.getElementById("item").value = data.name;
                  document.getElementById("description").value = data.description;

                  let datefield = document.getElementById("complete");

                  if(data.completion != null){
                    datefield.value = data.completion;
                    datefield.parentElement.classList.remove("hidden");
                  }else{
                    datefield.parentElement.classList.add("hidden");
                  }

                }
            };

            xhttp.send();


        })); // END OF View ITEM

    // Enable close on all modal windows
    const close = document.querySelectorAll(".close");
    console.log(close);

    close.forEach(close => {
      close.addEventListener("click", (ev)=> {
      console.log(ev.target.parentElement.parentElement.parentElement);
      ev.target.parentElement.parentElement.parentElement.style.display = 'none';
      });
    }); // End close foreach


  } // End if Manage List Page


  if(document.title == "Edit List Item"){
    document.querySelector("button[name=Cancel]").addEventListener("click", () => {
      location.href='manage_list.php';
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
  } // End if Edit List Item page

});
