<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? strip_tags($page_title) : "Store Front"; ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link href="<?php echo $home_url . "libs/css/style.css" ?>" rel="stylesheet" />

    <!-- custom css -->
    <style>
    .m-r-1em{ 
        margin-right:1em; 
    }
    .m-b-1em{ 
        margin-bottom:1em; 
    }
    .m-l-1em{ 
        margin-left:1em; 
    }
    .mt0{ 
        margin-top:0;
    }
    </style>
</head>
<body>
    <!-- include the navigation bar -->
    <?php include_once 'navigation.php'; ?>

    <div class="container">
        <div class="page-header">
            <h1><?php echo isset($page_title) ? $page_title : "HorlerTech"; ?></h1>
        </div>