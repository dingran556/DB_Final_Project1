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

     if ($_POST['name'] == ""||$_POST['inventory_amount'] == ""||$_POST['product_kind'] == ""||$_POST['cost']==""||$_POST['price'] == "") {
        $IsEmpty = true;
    }

    else if ($_POST['product_id'] == "") {
        db::getInstance()->insert_product($_POST['name'], $_POST['product_kind'],$_POST['cost'],$_POST['inventory_amount'],$_POST['price'],$_POST['category']);
        header('Location: product_main.php');
        exit;
    } 
    else if ($_POST['product_id'] != "") {
        db::getInstance()->update_product($_POST['product_id'], $_POST['name'], $_POST['product_kind'],$_POST['cost'],$_POST['inventory_amount'],$_POST['price'],$_POST['category']);
        header('Location: product_main.php');
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
                Cosmetic Store<small class="on-right">Employee</small>
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
                                <li><a href="product_main.php"><i class="icon-home"></i>Product Home</a></li>
                                <li class="title">View</li>
                                <li class="stick bg-red"><a href="view_product_face_wash.php"></i>Face Wash</a></li>
                                <li class="stick bg-blue"><a href="view_product_moisturizer.php"></i>Moisturizer</a></li>
                                <li class="stick bg-green"><a href="view_product_eyeshadow.php"></i>Eye shadow</a></li>
                                <li class="stick bg-yellow"><a href="view_product_lipstick.php"></i>Lip Stick</a></li>
                                <li class="stick bg-brown"><a href="view_product_remover.php"></i>Remover</a></li>
                                <li class="stick bg-violet"><a href="view_product_fragrance.php"></i>Fragrance</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class='span8'>
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == "POST")
                            $product = array("product_id" => $_POST['product_id'],
                                "name" => $_POST['name'],
                                "product_kind" => $_POST['product_kind'],
                                "cost" => $_POST['cost'],
                                "inventory_amount" => $_POST['inventory_amount'],
                                "price" => $_POST['price'],
                                );
                        else if (array_key_exists("product_id", $_GET)) {
                            //echo $GET['product_id'];
                            $product = mysqli_fetch_array(db::getInstance()->get_product_by_id($_GET['product_id']));
                        } else{
                            $product = array("ProductID" => "",
                                            "Name" => "",
                                            "ProductType" => "",
                                            "Inventory" => "",
                                            "Base_Price" => "",
                                            "Cost" => "",
                                            "Category" => "",
                                            );
                        }

                        ?>
                        <form name="getproduct" action="edit_product.php" method="POST">
                            <fieldset>
                                <legend>Edit Product</legend>
                                <input type="hidden" name="product_id" value="<?php echo $product['ProductID']; ?>" />
                                Product Name:</br>
                                <div class="input-control text" data-role="input-control" >
                                    <input type="text" name="name" value="<?php echo $product['Name']; ?>">
                                    <button class="btn-clear" tabindex="-1"></button>
                                </div>
                                </br>Product Kind:
                                <div class="input-control select" data-role="input-control">
                                    <select name="product_kind">
                                        <option><?php echo $product['ProductType']; ?></option>
                                        <?php
                                            require_once("Includes/db.php");
                                            $result = db::getInstance()->get_all_product_kind();
                                            while($row = mysqli_fetch_array($result)){
                                                if((htmlentities($row["ProductType"]))!= $product['ProductType']){
                                                    echo "<option>". htmlentities($row["ProductType"]) ."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                Cost:
                                <div class="input-control text" data-role="input-control" >
                                    <input type="text" name="cost" value="<?php echo $product['Cost']; ?>">
                                    <button class="btn-clear" tabindex="-1"></button>
                                </div>
                                Inventory Amount:
                                <div class="input-control text" data-role="input-control" >
                                    <input type="text" name="inventory_amount" value="<?php echo $product['Inventory']; ?>">
                                    <button class="btn-clear" tabindex="-1"></button>
                                </div>
                                Price:
                                <div class="input-control text" data-role="input-control" >
                                    <input type="text" name="price" value="<?php echo $product['Base_Price']; ?>">
                                    <button class="btn-clear" tabindex="-1"></button>
                                </div>
                                </br>Product Category:
                                <div class="input-control select" data-role="input-control">
                                    <select name="category">
                                        <option><?php echo $product['Category']; ?></option>
                                        <?php
                                            require_once("Includes/db.php");
                                            $result = db::getInstance()->get_all_product_category();
                                            while($row = mysqli_fetch_array($result)){
                                                if((htmlentities($row["Category"]))!= $product['Category']){
                                                    echo "<option>". htmlentities($row["Category"]) ."</option>";
                                                }
                                            }
                                        ?>
                                    </select>
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





