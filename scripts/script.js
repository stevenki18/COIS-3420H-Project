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

});