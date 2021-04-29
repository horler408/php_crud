<?php
    $id = isset($_GET["id"]) ? $_GET["id"] : die("Product ID not found!");

    // set page title
    $page_title = "Update Product";

    // To include the database
    include_once './config/database.php';

    // To include the header html
    include_once "./layout_head.php";

    // Codes that fetched the data to be updated
    try {
        $query = "SELECT id, name, description, price FROM products WHERE id = ? LIMIT 0,1";
        $stmt = $conn->prepare($query);

        $stmt->bindParam(1, $id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $name = $row['name'];
        $description = $row['description'];
        $price = $row['price'];

    }catch(PDOException $e) {
        die("ERROR: " .$e->getMessage());
    }

    // Code that saves the updated data
    if($_POST) {
        try {
            $query = "UPDATE products SET name=:name, description=:description, price=:price WHERE id=:id";
            $stmt = $conn->prepare($query);

            $name = htmlspecialchars(strip_tags($_POST['name']));
            $description = htmlspecialchars(strip_tags($_POST['description']));
            $price = htmlspecialchars(strip_tags($_POST['price']));

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':id', $id);

            if($stmt->execute()) {
                echo "<div class='alert alert-success'>Product updated successfully</div>";
            }else {
                echo "<div class='alert alert-danger'>Unable to update product, please try again.</div>";
            }

        }catch(PDOException $e) {
            die("Error: " .$e.getMessage());
        }
    }
    ?>

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . "?id={$id}"); ?>" method="post">
        <table class="table table-hover table-responsive table-bordered">
            <tr>
                <td>Name</td>
                <td><input type="text" name="name" value="<?php echo htmlspecialchars($name, ENT_QUOTES) ?>" class="form-control" /></td>
            </tr>

            <tr>
                <td>Description</td>
                <td><textarea name="description" class="form-control"><?php echo htmlspecialchars($description, ENT_QUOTES); ?></textarea></td>
            </tr>

            <tr>
                <td>Price</td>
                <td><input type="text" name="price" value="<?php echo htmlspecialchars($price, ENT_QUOTES) ?>" class="form-control" /></td>
            </tr>

            <tr>
                <td></td>
                <td>
                    <input type="submit" value="Save Changes" class="btn btn-primary" />
                    <a href="index.php" class="btn btn-danger">Return to home page</a>
                </td>
            </tr>
        </table>
    </form>
    
    <?php
    // To include footer html
    include_once "layout_foot.php";
?>
