<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            $PAGE_TITLE = "Manage List";
            include "includes/meta.php";
        ?>
        <link type="text/css" rel="stylesheet" href="css/form.css" />
    </head>

    <body>
        <!-- HEADER -->
        <header>
            <?php include 'nav.php' ?>
        </header>

        <main>
            <!-- DISPLAY LIST -->
            <header>
                <!-- LIST NAME -->
                <h1>My List</h1>
                <!-- START DATE -->
                <div>
                    <h3>2/9/2020</h3>
                    <p>START DATE</p>
                </div>
                <!-- END DATE -->
                <div>
                    <h3><span id="todaysdate"></span></h3>
                    <p>END DATE</p>
                </div>
            </header>

            <form id="edit-list" action="edit_item.php" method="post">
                <fieldset>
                  <ul>
                    <!-- FIRST ITEM -->
                    <li>
                        <input type="checkbox" id="checkbox-1" name="items[]" value="1"/>
                        <label for="checkbox-1">List item 1</label>
                        <button id="submit" name="Edit Item"><i class="fa fa-edit"></i></button>
                    </li>

                    <!-- SECOND ITEM -->
                    <li>
                        <input type="checkbox" id="checkbox-2" name="items[]" value="2"/>
                        <label for="checkbox-2">List item 2</label>
                        <button id="submit" name="Edit Item"><i class="fa fa-edit"></i></button>
                    </li>

                    <!-- THIRD ITEM -->
                    <li>
                        <input type="checkbox" id="checkbox-3" name="items[]" value="3"/>
                        <label for="checkbox-3">List item 3</label>
                        <button id="submit" name="Edit Item"><i class="fa fa-edit"></i></button>
                    </li>

                  </ul>
                    <!-- Add item Button -->
                    <button type="button" class="modBtn">ADD NEW ITEM</button>
                </fieldset>
            </form>


            <?php include 'add_item.php' ?>

        </main>

        <!-- FOOTER -->
        <?php include 'includes/footer.php' ?>

        <script>
            var dt = new Date();
            document.getElementById("todaysdate").innerHTML = dt.toLocaleDateString();

                // Get the modal
                var modal = document.getElementsByClassName('modal');

                // Get the button that opens the modal
                var btn = document.getElementsByClassName("modBtn");

                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close");

                // When the user clicks the button, open the modal
                btn[2].onclick = function() {
                    modal[2].style.display = "block";
                }

                // When the user clicks on <span> (x), close the modal
                span[2].onclick = function() {
                    modal[2].style.display = "none";
                }


                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                    if (event.target == modal[2]) {
                        modal[2].style.display = "none";
                    }
                }
        </script>

    </body>
</html>
