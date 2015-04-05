<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <link href="css/metro-bootstrap.css" rel="stylesheet">
    <link href="css/metro-bootstrap-responsive.css" rel="stylesheet">
    <link href="css/iconFont.css" rel="stylesheet">
    <link href="css/docs.css" rel="stylesheet">
    <link href="js/prettify/prettify.css" rel="stylesheet">

    <!-- Load JavaScript Libraries -->
    <script src="js/jquery/jquery.min.js"></script>
    <script src="js/jquery/jquery.widget.min.js"></script>
    <script src="js/jquery/jquery.mousewheel.js"></script>
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
                                <li class="title">Statistics</li>
                                <li><a href="statistics_main.php"><i class="icon-home"></i>Statistics</a></li>
                                <li class="stick bg-red active"><a href="top_chart.php"><i class="icon-rocket"></i>Top Chart</a></li>
                                <li class="stick bg-cyan">
                                    <a class="dropdown-toggle" href="#"><i class="icon-android"></i>Comparison</a>
                                    <ul class="dropdown-menu" data-role="dropdown">
                                        <li><a href="product_compare.php">Product Selling</a></li>
                                        <li class="divider"></li>
                                        <li><a href="salesman_compare.php">Salesman Performance</a></li>
                                        <li class="divider"></li>
                                        <li><a href="store_compare.php">Store Comparison</a></li>
                                        <li class="divider"></li>
                                        <li><a href="region_compare.php">Region Comparison</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class='span8'>
                        <table class="table striped" id="dataTables-1">
                            <legend>Top Product</legend>
                            <thead>
                                <tr>
                                    <th class="text-left">Name</th>
                                    <th class="text-left">Product Kind</th>
                                    <th class="text-left">Price</th>
                                    <th class="text-left">Total Sell</th>
                                    <th class="text-left">Profit</th>
                                </tr>
                            </thead>
                            <tbody>    
                                <?php
                                    require_once("Includes/db.php");
                                    $result = db::getInstance()->get_product_comp();
                                    $row = mysqli_fetch_array($result);
                                        echo "<tr class=\"error\"><td>" . htmlentities($row["name"]) . "</td>";
                                        echo "<td>" . htmlentities($row["product_kind"]) . "</td>";
                                        echo "<td>" . htmlentities($row["price"]) . "</td>";
                                        echo "<td>" . htmlentities($row["total_sell"]) . "</td>";
                                        echo "<td>" . htmlentities($row["profit"]) . "</td></tr>";                         
                                        mysqli_free_result($result);
                                ?>
                            </tbody>
                        </table>
                        <table class="table striped" id="dataTables-1">
                            <legend>Top Salesman</legend>
                            <thead>
                                <tr>
                                    <th class="text-left">Name</th>
                                    <th class="text-left">Email</th>
                                    <th class="text-left">Store</th>
                                    <th class="text-left">Total Order Selling</th>
                                </tr>
                            </thead>
                            <tbody>    
                                <?php
                                    $result = db::getInstance()->get_salesman_comp();
                                    $row = mysqli_fetch_array($result);
                                        echo "<tr class=\"success\"><td>" . htmlentities($row["salesman_name"]) . "</td>";
                                        echo "<td>" . htmlentities($row["email"]) . "</td>";
                                        echo "<td>" . htmlentities($row["store_id"]) . "</td>";
                                        echo "<td>" . htmlentities($row["total_order"]) . "</td></tr>";                    
                                        mysqli_free_result($result);
                                ?>
                            </tbody>
                        </table>
                        <table class="table striped" id="dataTables-1">
                            <legend>Top Store</legend>
                            <thead>
                                <tr>
                                    <th class="text-left">Id</th>
                                    <th class="text-left">Store Manager</th>
                                    <th class="text-left">Street</th>
                                    <th class="text-left">City</th>
                                    <th class="text-left">State</th>
                                    <th class="text-left">Zipcode</th>
                                    <th class="text-left">Total Order Selling</th>
                                </tr>
                            </thead>
                            <tbody>    
                                <?php
                                    $result = db::getInstance()->get_store_comp();
                                    $row = mysqli_fetch_array($result);
                                        echo "<tr class=\"warning\"><td>" . htmlentities($row["store_id"]) . "</td>";
                                        echo "<td>" . htmlentities($row["manager_name"]) . "</td>";
                                        echo "<td>" . htmlentities($row["street_name"]) . "</td>";
                                        echo "<td>" . htmlentities($row["city"]) . "</td>";
                                        echo "<td>" . htmlentities($row["state"]) . "</td>";
                                        echo "<td>" . htmlentities($row["zip_code"]) . "</td>";
                                        echo "<td>" . htmlentities($row["total_order"]) . "</td></tr>";                 
                                        mysqli_free_result($result);
                                ?>
                            </tbody>
                        </table>
                        <table class="table striped" id="dataTables-1">
                            <legend>Top Region</legend>
                            <thead>
                                <tr>
                                    <th class="text-left">Name</th>
                                    <th class="text-left">Region Manager</th>
                                    <th class="text-left">Total Order Selling</th>
                                </tr>
                            </thead>
                            <tbody>    
                                <?php
                                    $result = db::getInstance()->get_region_comp();
                                    $row = mysqli_fetch_array($result);
                                        echo "<tr class=\"info\"><td>" . htmlentities($row["region_name"]) . "</td>";
                                        echo "<td>" . htmlentities($row["region_manager_name"]) . "</td>";
                                        echo "<td>" . htmlentities($row["total_order"]) . "</td></tr>";                 
                                        mysqli_free_result($result);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>



