<?php
// Check for a valid session (if not redirect back to login)
session_start();
 if(!isset($_SESSION['user'])){
   header("Location:login.php");
 }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php
            $PAGE_TITLE = "Manage List";
            include "includes/meta.php";
        ?>
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
                <h1>My List <span><i class="fa fa-lock"></i></span></h1>

                <!-- START DATE -->
                <div>
                    <!-- h3 styling -->
                    <span>2/9/2020</h3>
                    <p>START DATE</p>
                </div>

                <!-- END DATE -->
                <div>
                    <!-- h3 styling -->
                    <span><span id="todaysdate"></span></h3>
                    <p>END DATE</p>
                </div>

                <!-- EDIT LIST -->
                <div>
                    <!-- h1 styling -->
                    <button type = "button"><i class = "fa fa-edit"></i></button>
                    <button type = "button"><i class = "fa fa-trash"></i></button>
                </div>
            </header>

            <!-- <form id="edit-list" action="edit_item.php" method="post"> -->
                <!-- <fieldset> -->
                  <ul>
                    <!-- FIRST ITEM -->
                    <li>
                        list item 1
                        <button onclick="document.getElementById('view-modal').style.display='block'"><i class = "fa fa-eye"></i></button>
                        <button type="submit" name="Edit Item"><i class="fa fa-edit"></i></button>
                        <button type = "button"><i class = "fa fa-trash"></i></button>
                    </li>

                    <!-- SECOND ITEM -->
                    <li>
                        list item 2
                        <button onclick="document.getElementById('view-modal').style.display='block'"><i class = "fa fa-eye"></i></button>
                        <button type="submit" name="Edit Item"><i class="fa fa-edit"></i></button>
                        <button type = "button"><i class = "fa fa-trash"></i></button>
                    </li>

                    <!-- THIRD ITEM -->
                    <li>
                        List item 3
                        <button onclick="document.getElementById('view-modal').style.display='block'"><i class = "fa fa-eye"></i></button>
                        <button type="submit" name="Edit Item"><i class="fa fa-edit"></i></button>
                        <button type = "button"><i class = "fa fa-trash"></i></button>
                    </li>

                  </ul>
                    <!-- Add item Button -->
                    <button onclick="document.getElementById('add-modal').style.display='block'">ADD NEW ITEM</button>
                <!-- </fieldset> -->
            <!-- </form> -->


            <?php include 'add_item.php' ?>

            <?php include 'view_item.php' ?>

            <?php include 'delete_item.php' ?>
            <!-- Self process delete item -->


        </main>

        <!-- FOOTER -->
        <?php include 'includes/footer.php' ?>

    </body>
</html>
