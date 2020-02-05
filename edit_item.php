<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include 'head_include.php' ?>
        <title></title>
    </head>
    <body>
        <!-- HEADER -->
        <header>
            <?php include 'nav.php' ?>
        </header>

        <main>
            <!-- EDIT LIST -->
            <form id="edit-item" action="editlistitems.php" method="post">
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

                <form enctype="multipart/form-data" action="upload.php" method="post">
                    <!-- IMAGE UPLOAD -->
                    <div>
                        <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
                        <label for="file">File Name:</label>
                        <input type="file" name="fileToProcess" id="file"/>
                        <input type="submit" value="Upload"/>
                    </div>
                </form>
            </form>
        </main>

        <!-- FOOTER -->
        <?php include 'footer.php' ?>

    </body>
</html>
