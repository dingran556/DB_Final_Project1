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

     if ($_POST['manager_name'] == ""||$_POST['street'] == ""||$_POST['city'] == ""||$_POST['state'] == ""||$_POST['zipcode'] == ""||$_POST['email'] == ""||$_POST['salary'] == ""||$_POST['store_id'] == "") {
        $IsEmpty = true;
    }

    else if ($_POST['store_manager_id'] == "") {
        db::getInstance()->insert_store_manager($_POST['manager_name'],$_POST['street'], $_POST['city'], $_POST['state'], $_POST['zipcode'],$_POST['email'], $_POST['salary'], $_POST['store_id']);
        header('Location: view_store_manager.php');
        exit;
    } 
    else if ($_POST['store_manager_id'] != "") {
        db::getInstance()->update_store_manager($_POST['store_manager_id'], $_POST['manager_name'], $_POST['street'], $_POST['city'], $_POST['state'], $_POST['zipcode'],$_POST['email'], $_POST['salary'], $_POST['store_id']);
        echo $_POST['store_manager_id']; 
        header('Location: view_store_manager.php');
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
                                <li class="title">Search</li>
                                <li><a href="employee_main.php"><i class="icon-home"></i>Find employee</a></li>
                                <li class="title">View</li>
                                <li class="stick bg-red"><a href="view_region_manager.php"><i class="icon-user-3"></i>Region Manager</a></li>
                                <li class="stick bg-green active"><a href="view_store_manager.php"><i class="icon-user-2"></i>Store Manager</a></li>
                                <li class="stick bg-blue"><a href="view_salesman.php"><i class="icon-user"></i>Salesman</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class='span8'>
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == "POST")
                            $store_manager = array("store_manager_id" => $_POST['store_manager_id'],
                                "manager_name" => $_POST['manager_name'],
                                "street" => $_POST['street'],
                                "city" => $_POST['city'],
                                "state" => $_POST['state'],
                                "zipcode" => $_POST['zipcode'],
                                "email" => $_POST['email'],
                                "salary" => $_POST['salary'],
                                'store_id' => $_POST['store_id']);
                        else if (array_key_exists("store_manager_id", $_GET)) {
                            $store_manager = mysqli_fetch_array(db::getInstance()->get_store_manager_by_id($_GET['store_manager_id']));
                        } else{
                            $store_manager = array("EmployeeID" => "",
                                        "Name" => "",
                                        "Street" => "",
                                        "City" => "",
                                        "State" => "",
                                        "Zipcode" => "",
                                        'Email' => "",
                                        'Salary' => "",
                                        'Assigned_Store' => "",
                                );
                        }

                        ?>
                        <form name="getstoremanager" action="edit_store_manager.php" method="POST">
                            <fieldset>
                                <legend>Edit Store Manager</legend>
                                <input type="hidden" name="store_manager_id" value="<?php echo $store_manager['EmployeeID']; ?>" />
                                Name:</br>
                                <div class="input-control text" data-role="input-control" >
                                    <input type="text" name="manager_name" value="<?php echo $store_manager['Name']; ?>">
                                    <button class="btn-clear" tabindex="-1"></button>
                                </div>
                                Street:</br>
                                <div class="input-control text" data-role="input-control">
                                    <input type="text" name="street" value="<?php echo $store_manager['Street']; ?>">
                                    <button class="btn-clear" tabindex="-1"></button>
                                </div>
                                City:</br>
                                <div class="input-control text" data-role="input-control">
                                    <input type="text" name="city" value="<?php echo $store_manager['City']; ?>">
                                    <button class="btn-clear" tabindex="-1"></button>
                                </div>
                                State:</br>
                                <div class="input-control text" data-role="input-control">
                                    <input type="text" name="state" value="<?php echo $store_manager['State']; ?>">
                                    <button class="btn-clear" tabindex="-1"></button>
                                </div>
                                Zip Code:</br>
                                <div class="input-control text" data-role="input-control">
                                    <input type="text" name="zipcode" value="<?php echo $store_manager['Zipcode']; ?>">
                                    <button class="btn-clear" tabindex="-1"></button>
                                </div>
                                Email:</br>
                                <div class="input-control text" data-role="input-control">
                                    <input type="text" name="email" value="<?php echo $store_manager['Email']; ?>">
                                    <button class="btn-clear" tabindex="-1"></button>
                                </div>
                                Salary:</br>
                                <div class="input-control text" data-role="input-control">
                                    <input type="text" name="salary" value="<?php echo $store_manager['Salary']; ?>">
                                    <button class="btn-clear" tabindex="-1"></button>
                                </div>
                                </br>Store ID:
                                <div class="input-control select" data-role="input-control">
                                    <select name="store_id">
                                        <option><?php echo $store_manager['Assigned_Store']; ?></option>
                                        <?php
                                            require_once("Includes/db.php");
                                            $result = db::getInstance()->get_all_store_id();
                                            while($row = mysqli_fetch_array($result)){
                                                if((htmlentities($row["StoreID"]))!= $salesman['Assigned_Store']){
                                                    echo "<option>". htmlentities($row["StoreID"]) ."</option>";
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



