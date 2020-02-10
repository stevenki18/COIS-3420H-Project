<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            $PAGE_TITLE = "Manage List";
            include "head_include.php"
        ?>
        <link type="text/css" rel="stylesheet" href="css/manage.css" />
        <link type="text/css" rel="stylesheet" href="css/edit.css" />
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
            
            <form id="edit-list" action="#" method="post">
                <fieldset>
                    <!-- FIRST ITEM -->
                    <div>
                        <input type="checkbox" id="checkbox-1" name="items[]" value="1"/>
                        <label for="checkbox-1">List item 1</label>
                        <button type="button" name="ci-1" id="edit-item"><i class="fa fa-edit"></i></button>
                        <?php //include 'edit_item.php' ?>
                    </div>
                    
                    <!-- SECOND ITEM -->
                    <div>
                        <input type="checkbox" id="checkbox-2" name="items[]" value="2"/>
                        <label for="checkbox-2">List item 2</label>
                        <button type="button" name="ci-2" id="edit-item"><i class="fa fa-edit"></i></button>
                        <?php //include 'edit_item.php' ?>
                    </div>
                    
                    <!-- THIRD ITEM -->
                    <div>
                        <input type="checkbox" id="checkbox-3" name="items[]" value="3"/>
                        <label for="checkbox-3">List item 3</label>
                        <button type="button" name="ci-3" id="edit-item"><i class="fa fa-edit"></i></button>
                        <?php //include 'edit_item.php' ?>
                    </div>
                </fieldset>
            </form>
        </main>

        <!-- FOOTER -->
        <?php include 'footer.php' ?>

        <script>
            var dt = new Date();
            document.getElementById("todaysdate").innerHTML = dt.toLocaleDateString();
        </script>

    </body>
</html>
