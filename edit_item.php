<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
            $PAGE_TITLE = "Edit List Item";
            include 'include/head_include.php'; 
        ?> 
        <link type="text/css" rel="stylesheet" href="css/form.css" />
    </head>
    <body>
        <!-- HEADER -->
        <header>
            <?php include 'nav.php' ?>
        </header>

        <main>
            <header>
                <!-- LIST Item Name -->
                <h1>My List Item</h1>
            </header>

            <!-- EDIT LIST -->
            <form id="edit-item" action="process/processedit.php" method="post">
                <!-- BUCKET LIST ITEM -->
                <div>
                    <label for="item">Bucket List Item:</label>
                    <input type="text" id="item" name="item" placeholder="Enter a Bucket List Item..."/>
                </div>

                <!-- ITEM DESCRIPTION -->
                <div>
                    <label for="description">Bucket List Item:</label>
                    <input type="text" id="description" name="description" placeholder="Enter a description about your item..."/>
                </div>

                <!-- IMAGE -->
                <form enctype="multipart/form-data" action="upload.php" method="post">
                    <!-- IMAGE UPLOAD -->
                    <div>
                        <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
                        <label for="file">File Name:</label>
                        <input type="file" name="fileToProcess" id="file"/>
                    </div>
                </form>

                <!-- SUBMIT -->
                <input type="submit" value="Edit"/>
            </form>
        </main>

        <!-- FOOTER -->
        <?php include 'include/footer.php' ?>

    </body>
</html>
