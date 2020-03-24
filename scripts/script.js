"use strict";

window.addEventListener('DOMContentLoaded', () => {

    // ADD AN ITEM TO A LIST
    document.querySelector("#additem").addEventListener("click", event => {
        document.getElementById('add-modal').style.display='block';
        
        document.querySelector("#addToList button").addEventListener("click", event =>{
            const itemName = document.querySelector("#itemname");
            const itemError = document.querySelector("#itemname~span");

            let valid = true;
            listError.classList.add("hidden");
            validateItem();
            
            if(!valid)
                event.preventDefault();
            
            else
                window.location("index.php");
            // VALIDATE ITEM NAME
            function validateItem(){
                if(itemName.value == ""){
                    itemError.classList.remove("hidden");
                    valid = false;
                }
            }
        }); 
    }); // END OF ADDING ITEM


    const edit_button = document.querySelectorAll("#editbuttons");
    
    edit_button.forEach(edit_button => 
        edit_button.addEventListener("click", function() {
            var id = edit_button.value;
            location.href='edit_item.php';
            var xhttp = new XMLHttpRequest();
            xhttp.open("GET", "api/formfill.php?itemid="+id);
            xhttp.onreadystatechange = function(){
                if (this.readyState == 4 && this.status == 200){
                    document.getElementById("itemname").value = this.data['name'];

                    if(this.data['private'] == 1)
                        document.getElementById("viewable").value = false;

                    else if(this.data['private'] == 0)
                        document.getElementById("viewable").value = true;

                    document.getElementById("description").value = this.data['description'];

                    document.getElementById("completion").value = this.data['completion'];
                }
            }
            
            xhttp.send();
    }));

});