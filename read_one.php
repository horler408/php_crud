<?php
    // set page title
    $page_title = "Read One";

    // Setting parameter for id
    $id = isset($_GET["id"]) ? $_GET['id'] : die("Record ID Not Found!");
            
    // Including the database connection
    include_once "./config/database.php";

    // Including Header Layout
    include_once "./layout_head.php";

            try {
                $query = "SELECT id, name, description, price, image FROM products WHERE id = ? LIMIT 0,1";
                $stmt = $conn->prepare($query);

                $stmt->bindParam(1, $id);

                $stmt->execute();

                // Store retrieved data to a variable
                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                // To declare the result of fetched array
                $name = $row["name"];
                $description = $row["description"];
                $price = $row["price"];
                $image = htmlspecialchars($row["image"], ENT_QUOTES);



            }catch(PDOException $e) {
                die("Error: " .$e->getMessage());
            }

        ?>
 
        <table class="table table-hover table-responsive table-bordered">
            <tr>
                <td>Name</td>
                <td><?php echo htmlspecialchars($name, ENT_QUOTES); ?></td>
            </tr>

            <tr>
                <td>Description</td>
                <td><?php echo htmlspecialchars($description, ENT_QUOTES); ?></td>
            </tr>

            <tr>
                <td>Price</td>
                <td><?php echo htmlspecialchars($price, ENT_QUOTES); ?></td>
            </tr>

            <tr>
                <td>Image</td>
                <td><?php echo $image ? "<img src='uploads/{$image}' style='width:300px' />" : "No Image Found!" ?></td>
            </tr>

            <tr>
                <td></td>
                <td><a href="index.php" class="btn btn-danger">Back to home page</a></td>
            </tr>
        </table>
 
    <?php
    include_once "./layout_foot.php";

?>