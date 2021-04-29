<?php
    // To include database connection
    include_once "./config/database.php";

    try {
        $id = isset($_GET['id']) ? $_GET['id'] : die("Product ID not Found!");

        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(1, $id);

        if($stmt->execute()) {
            header('Location: index.php?action=deleted');
        }else {
            die('Unable to delete product');
        }
    }catch(PDOException $e) {
        die("ERROR: " .$e.getMessage());
    }
?>