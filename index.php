<?php
    // set page title
    $page_title = "Home Page";

    // To include the database
    include_once './config/database.php';

    // To include the header html
    include_once "./layout_head.php";

    // Pagination Variables
    $page = isset($_GET['page']) ? $_GET['page'] : 1;

    $per_page = 5;

    // To calculate for the query LIMIT clause
    $from_record_num = ($per_page * $page) - $per_page;

    // Delete message prompt
    $action = isset($_GET['action']) ? $_GET['action'] : "";

    if($action == 'deleted') {
        echo "<div class='alert alert-success'>Product deleted successfully!</div>";
    }

    // Select all the data
    $query = "SELECT id, name, description, price FROM products ORDER BY id DESC LIMIT :from_record_num, :per_page";
    $stm = $conn->prepare($query);

    // To bind the parameters
    $stm->bindParam(':from_record_num', $from_record_num, PDO::PARAM_INT);
    $stm->bindParam(':per_page', $per_page, PDO::PARAM_INT);

    $stm->execute();

    // To get number of rows returned
    $num = $stm->rowCount();

    // Link to create records
    echo "<a href='create.php' class='btn btn-primary m-b-1em'>Create New Product</a>";

    // To check for Records in the database
    if($num > 0) {
        // Data from databse is retrieved
        echo "<table class='table table-hover table-responsive table-bordered'>";
            // Table Headings
            echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>Name</th>";
                echo "<th>Description</th>";
                echo "<th>Price</th>";
                echo "<th>Actions</th>";
            echo "</tr>";

            // Table body
            while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                echo "<tr>";
                    echo "<td>{$id}</td>";
                    echo "<td>{$name}</td>";
                    echo "<td>{$description}</td>";
                    echo "<td>#{$price}</td>";
                    echo "<td>";
                        // Link to show Single Item
                        echo "<a href='read_one.php?id={$id}' class='btn btn-info m-r-1em m-b-1em'>Read</a>";
                        // Link to edit a product
                        echo "<a href='update.php?id={$id}' class='btn btn-primary m-r-1em m-b-1em'>Edit</a>";
                        // Link to delete a product
                        echo "<a href='#' onclick='deleteProduct({$id});' class='btn btn-danger m-b-1em'>Delete</a>";
                    echo "</td>";
                echo "</tr>";
            }

        echo "</table>";

        // PAGINATION
        $query = "SELECT COUNT(*) as total_rows FROM products";
        $stmt = $conn->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_rows = $row['total_rows'];

        // Paginate Records
        $page_url = "index.php?";
        include_once "./paging.php";
    }else {
        echo "<div class='alert alert-danger'>No Records Found! </div>";
    }

    // To include footer html
    include_once "layout_foot.php";
?>