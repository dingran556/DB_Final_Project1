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

        if ($_POST['customer_id'] == "" || $_POST['salesman_name'] == "" || $_POST['date'] == "" || $_POST['remark'] == "") {
            $IsEmpty = true;
        } else if ($_POST['transaction_id'] == "") {
            db::getInstance()->insert_transaction($_POST['customer_id'], $_POST['salesman_name'], $_POST['date'], $_POST['remark']);
            $last_transaction_id = db::getInstance()->insert_id;
            if(!empty($_POST['id'])){
                for($i=0; $i < count($_POST['id']); $i++){
                    $product_id=(string)$_POST['id'][$i];
                    db::getInstance()->insert_order_specify($last_transaction_id, $_POST['id'][$i], $_POST[$product_id]);

                     //echo $_POST['id'][$i]."\n".$_POST[$product_id]."\n".$i."</br>";
    
                    db::getInstance()->reduce_product($_POST['id'][$i], $_POST[$product_id]);                   
            }
            }
            header('Location: transaction_main.php');
            exit;
        } /*else if ($_POST['transaction_id'] != "") {
            db::getInstance()->update_region($_POST['region_id'], $_POST['region_name'], $_POST['region_manager_name']);
            header('Location: view_region.php');
            exit;
        }*/
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
} else {
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
                                <li class="title">Transaction Info</li>
                                <li class="active"><a href="transaction_main.php"><i class="icon-home"></i>Transaction</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class='span8'>
<?php
if ($_SERVER['REQUEST_METHOD'] == "POST")
    $transaction = array("transaction_id" => $_POST['transaction_id'],
        "customer_id" => $_POST['customer_id'],
        "salesman_name" => $_POST['salesman_name'],
        "date" => $_POST['date'],
        "remark" => $_POST['remark']);
/*else if (array_key_exists("region_id", $_GET)) {
    $region = mysqli_fetch_array(db::getInstance()->get_region_by_id($_GET['region_id']));
}*/ else {
    $transaction = array("transaction_id" => "",
        "customer_id" => "",
        "salesman_name" => "",
        "date" => "",
        "remark" => "");
}
?>
                        <form name="getregion" action="edit_transaction.php" method="POST">
                            <fieldset>
                                <legend>Insert Transaction</legend>
                                <input type="hidden" name="transaction_id" value="<?php echo $transaction['transaction_id']; ?>" />
                                Customer Name:</br>
                                <div class="input-control select" data-role="input-control">
                                    <select name="customer_id">
                                        <option><?php echo $transaction['customer_id']; ?></option>
<?php
require_once("Includes/db.php");
$result = db::getInstance()->get_all_customer_id();
while ($row = mysqli_fetch_array($result)) {
        echo "<option>" . htmlentities($row["customer_id"]) . "</option>";
}
mysqli_free_result($result);
?>
                                    </select>
                                </div>
                                Salesman Name:</br>
                                <div class="input-control select" data-role="input-control">
                                    <select name="salesman_name">
                                        <option><?php echo $transaction['salesman_name']; ?></option>
<?php
$result = db::getInstance()->get_all_salesman();
while ($row = mysqli_fetch_array($result)) {
        echo "<option>" . htmlentities($row["salesman_name"]) . "</option>";
}
mysqli_free_result($result);
?>
                                    </select>
                                </div>
                                Date:</br>
                                <div class="input-control text" data-role="datepicker"
                                data-date="2013-01-01"
                                data-format="yyyy-m-d"
                                data-position="top|bottom"
                                data-effect="none|slide|fade">
                                    <input type="text" name="date">
                                    <button class="btn-date"></button>
                                </div>
                                Remark:</br>
                                <div class="input-control textarea" data-role="input-control textarea" >
                                    <textarea name="remark"></textarea>
                                </div>
                                Product:</br>
                                <div class="input-control checkbox">
                                    <?php
                                    $result = db::getInstance()->get_all_product();
                                    while ($row = mysqli_fetch_array($result)):
                                        echo "<label><input type=\"checkbox\" name=\"id[]\" value=\"". htmlentities($row["product_id"]) ."\"/><span class=\"check\"></span>". htmlentities($row["name"]) ."</label>";
                                    ?>
                                    <input type="number" name="<?php echo htmlentities($row["product_id"]); ?>" min="1" max="100">

                                    <?php
                                    endwhile;
                                    mysqli_free_result($result);
                                    ?>
                                </div>

                                </br>
                                <input type="submit" value="Insert">
                                        <?php
                                        if ($IsEmpty)
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






