<?php 
    // set page title
    $page_title = "Create Page";

    // To include the database
    include_once './config/database.php';

    // To include the header html
    include_once "./layout_head.php";

    if($_POST) {
        try {
            $query = "INSERT INTO products SET name=:name, description=:description, price=:price, image=:image, created=:created";
            //$query = "INSERT INTO products VALUES(null, $name, $description, $price, $image, $created)";

            // prepare query for execution
            $stmt = $conn->prepare($query);

            // Posted Values
            $name = htmlspecialchars(strip_tags($_POST["name"]));
            $description = htmlspecialchars(strip_tags($_POST["description"]));
            $price = htmlspecialchars(strip_tags($_POST["price"]));
            // To accept image input
            $image = !empty($_FILES["image"]["name"]) ? sha1_file($_FILES["image"]["tmp_name"]) . "-" . basename($_FILES["image"]["name"]) : "";
            $image = htmlspecialchars(strip_tags($image));

            // Bind the parameters
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':image', $image);

            // To specify time of insertion to database
            $created=date('Y-m-d H:i:s');
            $stmt->bindParam(':created', $created);

            // To execute the query
            if($stmt->execute()) {
                echo "<div class='alert alert-success'>Record was saved</div>";

                // Codes that upload the image
                if($image) {
                    $target_directory = "uploads/";
                    $target_file = $target_directory . $image;
                    $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

                    $file_upload_error_message = "";

                    // To make sure real image is attached
                    $check = getimagesize($_FILES["image"]["tmp_name"]);
                    if($check !== false) {

                    }else {
                        $file_upload_error_message .= "<div>Not an Image</div>";
                    }

                    // Allowed file types
                    $allowed_file_types = array("jpg", "jpeg", "gif", "png");
                    if(!in_array($file_type, $allowed_file_types)) {
                        $file_upload_error_message .= "<div>Only JPEG, JPG, PNG, and GIF files are aloowed.</div>";
                    }

                    // To ensure file does not alreadt exist
                    if(file_exists($target_file)) {
                        $file_upload_error_message .= "<div>Image alredy exixt, change the file name and try again</div>";
                    }

                    // Allowed file size
                    if($_FILES["image"]["size"] > 1024000) {
                        $file_upload_error_message .= "<div>Image size must not exceed 1Mb</div>";
                    }

                    // To ensure uploads folder exists
                    // If not, create it
                    if(!is_dir($target_directory)) {
                        mkdir($target_directory, 0777, true);
                    }

                    // If No errors
                    if(empty($file_upload_error_message)) {
                        //This means there is no error
                        if(move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                            // Photo was uploaded
                        }else {
                            echo "<div class='alert alert-danger'>";
                                echo "<div>Unable to upload the image</div>";
                                echo "<div>Update the record to upload the image.</div>";
                            echo "</div>";
                        }
                    }else {
                        // This means there are errors
                        echo "<div class='alert alert-danger'>";
                            echo "<div>{$file_upload_error_message}</div>";
                            echo "<div>Update the record to upload the image.</div>";
                        echo "</div>";
                    }
                }
            }else {
                echo "<div class='alert alert-danger'>Unable to save record</div>";
                
                // If Image field is empty

            }
        }catch(PDOException $e){
            die("Error: " .$e->getMessage());
        }
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <table class="table table-hover table-responsive table-bordered">
            <tr>
                <td>Name</td>
                <td><input type="text" name="name" class="form-control" required /></td>
            </tr>

            <tr>
                <td>Description</td>
                <td><textarea name="description" class="form-control" required></textarea></td>
            </tr>

            <tr>
                <td>Price</td>
                <td><input type="text" name="price" class="form-control" required /></td>
            </tr>

            <tr>
                <td>Photo</td>
                <td><input type="file" name="image" /></td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <input type="submit" value="Save" class="btn btn-primary" />
                    <a href="index.php" class="btn btn-danger">Back to home page</a>
                </td>
            </tr>
        </table>
    </form>
    <?php
    // To include footer html
    include_once "layout_foot.php";
?>
