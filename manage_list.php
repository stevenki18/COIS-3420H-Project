<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'head_include.php' ?>
        <title>Manage List</title>
    </head>

    <body>
        <!-- HEADER -->
        <header>
            <?php include 'nav.php' ?>
        </header>

        <main>
            <!-- DISPLAY LIST -->
            <h1>Bucket List Name</h1>
            <form id="edit-list-item" action="#" method="post">
                <fieldset>
                    <legend>Bucket List Items</legend>
                    
                    <!-- FIRST ITEM -->
                    <div>
                        <input type="checkbox" id="checkbox-1" name="items[]" value="1"/>
                        <label for="checkbox-1">List item 1</label>
                        <button type="button" name="ci-1" id="edit-btn"><i class="fa fa-edit"></i></button>
                        <?php include 'edit_item.php' ?>
                    </div>
                    
                    <!-- SECOND ITEM -->
                    <div>
                        <input type="checkbox" id="checkbox-2" name="items[]" value="2"/>
                        <label for="checkbox-2">List item 2</label>
                        <button type="button" name="ci-2" id="edit-btn"><i class="fa fa-edit"></i></button>
                        <?php include 'edit_item.php' ?>
                    </div>
                    
                    <!-- THIRD ITEM -->
                    <div>
                        <input type="checkbox" id="checkbox-3" name="items[]" value="3"/>
                        <label for="checkbox-3">List item 3</label>
                        <button type="button" name="ci-3" id="edit-btn"><i class="fa fa-edit"></i></button>
                        <?php include 'edit_item.php' ?>
                    </div>

                </fieldset>
            </form>
        </main>

        <!-- FOOTER -->
        <?php include 'footer.php' ?>

    </body>
</html>
