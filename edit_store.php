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

     if ($_POST['manager_id'] == ""|| $_POST['region_id'] == ""||$_POST['store_name'] == ""||$_POST['street_name'] == ""||$_POST['city'] == ""||$_POST['state'] == ""||$_POST['zip_code'] == ""){
        $IsEmpty = true;
    }

    else if ($_POST['store_id'] == "") {
        db::getInstance()->insert_store($_POST['manager_id'], $_POST['region_id'], $_POST['store_name'], $_POST['street_name'], $_POST['city'], $_POST['state'], $_POST['zip_code']);
        header('Location: view_store.php');
        exit;
    } 
    else if ($_POST['store_id'] != "") {
        db::getInstance()->update_store($_POST['store_id'], $_POST['manager_id'], $_POST['region_id'], $_POST['store_name'], $_POST['street_name'], $_POST['city'], $_POST['state'], $_POST['zip_code']);
        header('Location: view_store.php');
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
                iManager
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
                Cosmetic Store <small class="on-right">Employee</small>
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
                                <li class="title">Home</li>
                                <li><a href="store_main.php"><i class="icon-home"></i>Store Home</a></li>
                                <li class="stick bg-red"><a href="view_region.php"><i class="icon-cart"></i>Region Info</a></li>
                                <li class="stick bg-blue"><a href="view_store.php"><i class="icon-cart-2"></i>Store Info</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class='span8'>
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == "POST")
                            $store = array("store_id" => $_POST['store_id'],
                                "manager_id" => $_POST['manager_id'],
                                "region_id" => $_POST['region_id'],
                                "store_name" => $_POST['store_name'],
                                "street_name" => $_POST['street_name'],
                                "city" => $_POST['city'],
                                "state" => $_POST['state'],
                                "zip_code" => $_POST['zip_code']);
                        else if (array_key_exists("store_id", $_GET)) {
                            $store = mysqli_fetch_array(db::getInstance()->get_store_by_id($_GET['store_id']));
                        } else{
                            $store = array("StoreID" => "",
                                        "Store_ManagerID" => "",
                                        "Region_ID" => "",
                                        "Store_Name" => "",
                                        "Street" => "",
                                        "City" => "",
                                        "State" => "",
                                        "ZipCode" => "",);
                        }

                        ?>
                        <form name="getstore" action="edit_store.php" method="POST">
                            <fieldset>
                                <legend>Edit Store</legend>
                                <input type="hidden" name="store_id" value="<?php echo $store['StoreID']; ?>" />
                                Store Manager ID:</br>
                                <div class="input-control select" data-role="input-control">
                                    <select name="manager_id">
                                        <option><?php echo $store['Store_ManagerID']; ?></option>
                                        <?php
                                            require_once("Includes/db.php");
                                            $result = db::getInstance()->get_all_store_manager_id();
                                            while($row = mysqli_fetch_array($result)){
                                                if((htmlentities($row["EmployeeID"]))!= $store['Store_ManagerID']){
                                                    echo "<option>". htmlentities($row["EmployeeID"]) ."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                Region ID:</br>
                                <div class="input-control select" data-role="input-control">
                                    <select name="region_id">
                                        <option><?php echo $store['Region_ID']; ?></option>
                                        <?php
                                            require_once("Includes/db.php");
                                            $result = db::getInstance()->get_all_region();
                                            while($row = mysqli_fetch_array($result)){
                                                if((htmlentities($row["RegionID"]))!= $store['Region_ID']){
                                                    echo "<option>". htmlentities($row["RegionID"]) ."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                Store Name:</br>
                                <div class="input-control text" data-role="input-control" >
                                    <input type="text" name="store_name" value="<?php echo $store['Store_Name']; ?>">
                                    <button class="btn-clear" tabindex="-1"></button>
                                </div>
                                Street Name:</br>
                                <div class="input-control text" data-role="input-control" >
                                    <input type="text" name="street_name" value="<?php echo $store['Street']; ?>">
                                    <button class="btn-clear" tabindex="-1"></button>
                                </div>
                                City Name:</br>
                                <div class="input-control text" data-role="input-control" >
                                    <input type="text" name="city" value="<?php echo $store['City']; ?>">
                                    <button class="btn-clear" tabindex="-1"></button>
                                </div>
                                State:</br>
                                <div class="input-control text" data-role="input-control" >
                                    <input type="text" name="state" value="<?php echo $store['State']; ?>">
                                    <button class="btn-clear" tabindex="-1"></button>
                                </div>
                                Zip Code:</br>
                                <div class="input-control text" data-role="input-control" >
                                    <input type="text" name="zip_code" value="<?php echo $store['ZipCode']; ?>">
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






