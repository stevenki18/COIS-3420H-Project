"use strict";

window.addEventListener('DOMContentLoaded', () => {

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
    const edit_button = document.querySelectorAll("#editbuttons");

    edit_button.forEach(edit_button =>
        edit_button.addEventListener("click", function () {
            var id = edit_button.value;
            location.href='edit_item.php?item='+id;
        })); // END OF EDIT ITEM


});