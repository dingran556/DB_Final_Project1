<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <?php

    require_once("Includes/db.php");
    $IsEmpty = false;
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

     if ($_POST['region_manager_name'] == ""||$_POST['email'] == ""||$_POST['salary'] == "") {
        $IsEmpty = true;
    }

    else if ($_POST['region_manager_id'] == "") {
        db::getInstance()->insert_region_manager($_POST['region_manager_name'], $_POST['email'], $_POST['salary']);
        header('Location: view_region_manager.php');
        exit;
    } 
    else if ($_POST['region_manager_id'] != "") {
        db::getInstance()->update_region_manager($_POST['region_manager_id'], $_POST['region_manager_name'], $_POST['email'], $_POST['salary']);
        header('Location: view_region_manager.php');
        exit;
    }
}
?>
    <link href="css/metro-bootstrap.css" rel="stylesheet">
    <link href="css/metro-bootstrap-responsive.css" rel="stylesheet">
    <link href="css/iconFont.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="js/prettify/prettify.css" rel="stylesheet">

    <!-- Load JavaScript Libraries -->
    <script src="js/jquery/jquery.min.js"></script>
    <script src="js/jquery/jquery.widget.min.js"></script>
    <script src="js/jquery/jquery.mousewheel.js"></script>
    <script src="js/jquery/jquery.dataTables.js"></script>
    <script src="js/prettify/prettify.js"></script>

    <!-- Metro UI CSS JavaScript plugins -->
    <script src="js/load-metro.js"></script>  
    
    <script src="js/docs.js"></script>
    <script src="js/github.info.js"></script>

    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body class="metro">
        <nav class="navigation-bar dark">
            <nav class="navigation-bar-content">
            <div class="element">
                IManager
            </div>
 
            <span class="element-divider"></span>
            <a class="element brand" href="index.php"><span class="icon-link-2"></span></a>
            <span class="element-divider"></span>
 
            <div class="element place-right">
                <a class="dropdown-toggle" href="#">
                    <span class="icon-cog"></span>
                </a>
                <ul class="dropdown-menu place-right" data-role="dropdown">
                    <li><a href="store_main.php">Store</a></li>
                    <li><a href="employee_main.php">Staff</a></li>
                    <li><a href="customer_main.php">Customer</a></li>
                    <li><a href="product_main.php">Product</a></li>
                    <li><a href="transaction_main.php">Transaction</a></li> 
                    <li><a href="statistics_main.php">Statistics</a></li>
                </ul>
            </div>
            <span class="element-divider place-right"></span>
            <a class="element place-right" href="welcome.php"><span class="icon-home"></span></a>
            <span class="element-divider place-right"></span>
            <button class="element image-button image-left place-right">
                <?php
                    session_start();
                    if (array_key_exists("user", $_SESSION)) {
                    echo $_SESSION['user'];
                    }
                    else {
                        header('Location: index.php');
                        exit;
                    }
                ?>
                <img src="images/default.png"/>
            </button>
            </nav>
        </nav>
        <div class='container'>
            <h1>
                <a href="/"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                RESTAURANT<small class="on-right">manager</small>
            </h1>

            <nav class="horizontal-menu">
                <ul>
                    <li><a href="store_main.php">Store</a></li>
                    <li><a href="employee_main.php">Staff</a></li>
                    <li><a href="customer_main.php">Customer</a></li>
                    <li><a href="product_main.php">Product</a></li>
                    <li><a href="transaction_main.php">Transaction</a></li> 
                    <li><a href="statistics_main.php">Statistics</a></li>
                </ul>
            </nav>
            <div class="grid fluid">
                <div class='row'>
                    <div class="span3">
                        <nav class="sidebar">
                            <ul>
                                <li class="title">Search</li>
                                <li><a href="employee_main.php"><i class="icon-home"></i>Find employee</a></li>
                                <li class="title">View</li>
                                <li class="stick bg-red active"><a href="view_region_manager.php"><i class="icon-user-3"></i>Region Manager</a></li>
                                <li class="stick bg-green"><a href="view_store_manager.php"><i class="icon-user-2"></i>Store Manager</a></li>
                                <li class="stick bg-blue"><a href="view_salesman.php"><i class="icon-user"></i>Salesman</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class='span8'>
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == "POST")
                            $region_manager = array("region_manager_id" => $_POST['region_manager_id'],
                                "region_manager_name" => $_POST['region_manager_name'],
                                "email" => $_POST['email'],
                                "salary" => $_POST['salary']);
                        else if (array_key_exists("region_manager_id", $_GET)) {
                            $region_manager = mysqli_fetch_array(db::getInstance()->get_region_manager_by_id($_GET['region_manager_id']));
                        } else{
                            $region_manager = array("region_manager_id" => "",
                                        "region_manager_name" => "",
                                        "email" => "",
                                        "salary" => "");
                        }

                        ?>
                        <form name="getregionmanager" action="edit_region_manager.php" method="POST">
                            <fieldset>
                                <legend>Edit RegionManager</legend>
                                <input type="hidden" name="region_manager_id" value="<?php echo $region_manager['region_manager_id']; ?>" />
                                Name:</br>
                                <div class="input-control text" data-role="input-control" >
                                    <input type="text" name="region_manager_name" value="<?php echo $region_manager['region_manager_name']; ?>">
                                    <button class="btn-clear" tabindex="-1"></button>
                                </div>
                                Email:</br>
                                <div class="input-control text" data-role="input-control">
                                    <input type="text" name="email" value="<?php echo $region_manager['email']; ?>">
                                    <button class="btn-clear" tabindex="-1"></button>
                                </div>
                                Salary:</br>
                                <div class="input-control text" data-role="input-control">
                                    <input type="text" name="salary" value="<?php echo $region_manager['salary']; ?>">
                                    <button class="btn-clear" tabindex="-1"></button>
                                </div>
      

                                <input type="submit" value="Save changes">
                                <?php
                                    if($IsEmpty)
                                    echo "Please fill the blank<br/>";
                                ?>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>




