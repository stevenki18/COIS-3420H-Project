<?php
    // Check for a valid session (if not redirect back to login)
    session_start();
    if(!isset($_SESSION['user']))
    {
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
            <?php include 'includes/nav.php' ?>
        </header>

        <main>
            <!-- DISPLAYS LIST -->
            <header>
                <!-- LIST NAME -->
                <h1>
                    <?= "My List" ?> 
                    <span>
                        <i class="fa fa-lock"></i>
                    </span>
                </h1>

                <!-- START DATE -->
                <div>
                    <!-- h3 styling -->
                    <span>2/9/2020</span>
                    <p>START DATE</p>
                </div>

                <!-- END DATE -->
                <div>
                    <!-- h3 styling -->
                    <span id="todaysdate"></span>
                    <p>END DATE</p>
                </div>

                <!-- EDIT LIST -->
                <div>
                    <!-- h1 styling -->
                    <button type="button"><i class="fa fa-edit"></i></button>
                    <button type="button" class="delete"><i class="fa fa-trash"></i></button>
                </div>
            </header>

            <ul>
                <!-- FIRST ITEM -->
                <li>
                    <span>List Item 1</span>
                    <div>
                        <button onclick="document.getElementById('view-modal').style.display='block'"><i class="fa fa-eye"></i></button>
                        <button type="button" name="Edit Item" onclick="location.href='edit_item.php'"><i class="fa fa-edit"></i></button>
                        <button type="button" class="delete"><i class="fa fa-trash"></i></button>    
                    </div>
                </li>

                <!-- SECOND ITEM -->
                <li>
                    <span>List Item 2</span>
                    <div>
                        <button onclick="document.getElementById('view-modal').style.display='block'"><i class="fa fa-eye"></i></button>
                        <button type="button" name="Edit Item" onclick="location.href='edit_item.php'"><i class="fa fa-edit"></i></button>
                        <button type="button" class="delete"><i class="fa fa-trash"></i></button>    
                    </div>
                </li>

                <!-- THIRD ITEM -->
                <li>
                    <span>List Item 3</span>
                    <div>
                        <button onclick="document.getElementById('view-modal').style.display='block'"><i class="fa fa-eye"></i></button>
                        <button type="button" name="Edit Item" onclick="location.href='edit_item.php'"><i class="fa fa-edit"></i></button>
                        <button type="button" class="delete"><i class="fa fa-trash"></i></button>    
                    </div>
                </li>

                <!-- BUTTON TO ADD ITEMS -->
                <li>
                    <button onclick="document.getElementById('add-modal').style.display='block'">
                        <i class="fa fa-plus"></i>
                    </button>
                </li>

            </ul>

            <?php include 'modals/add_item.php' ?>

            <?php include 'modals/view_item.php' ?>

            <?php //include 'delete_item.php' ?>
            <!-- Self process delete item -->

        </main>

        <!-- FOOTER -->
        <?php include 'includes/footer.php' ?>

    </body>

    <script>
        var dt = new Date();
        document.getElementById("todaysdate").innerHTML = dt.toLocaleDateString();
    </script>

</html>