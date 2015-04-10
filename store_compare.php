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
                                <li class="title">Statistics</li>
                                <li><a href="statistics_main.php"><i class="icon-home"></i>Statistics</a></li>
                                <li class="stick bg-red"><a href="top_chart.php"><i class="icon-rocket"></i>Top Chart</a></li>
                                <li class="stick bg-cyan">
                                    <a class="dropdown-toggle" href="#"><i class="icon-android"></i>Comparison</a>
                                    <ul class="dropdown-menu" data-role="dropdown">
                                        <li><a href="product_compare.php">Product Selling</a></li>
                                        <li class="divider"></li>
                                        <li><a href="salesman_compare.php">Salesman Performance</a></li>
                                        <li class="divider"></li>
                                        <li class="active"><a href="store_compare.php">Store Comparison</a></li>
                                        <li class="divider"></li>
                                        <li><a href="region_compare.php">Region Comparison</a></li>
                                        <li class="divider"></li>
                                        <li><a href="customer_compare.php">Customer Comparison</a></li>
                                        <li class="divider"></li>
                                        <li><a href="business_product.php">Business Analysis</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    <div class='span8'>
                        <table class="table striped" id="dataTables-1">
                            <legend>Store Comparison</legend>
                            <thead>
                                <tr>
                                    <th class="text-left">Id</th>
                                    <th class="text-left">Store Name</th>
                                    <th class="text-left">Store Manager</th>
                                    <th class="text-left">Street</th>
                                    <th class="text-left">City</th>
                                    <th class="text-left">State</th>
                                    <th class="text-left">Zip Code</th>
                                    <th class="text-left">Total Order Selling</th>
                                </tr>
                            </thead>
                            <tbody>    
                                <?php
                                    require_once("Includes/db.php");
                                    $result = db::getInstance()->get_store_comp();
                                    while($row = mysqli_fetch_array($result)){
                                        echo "<tr><td>" . htmlentities($row["StoreID"]) . "</td>";
                                        echo "<td>" . htmlentities($row["Store_Name"]) . "</td>";
                                        echo "<td>" . htmlentities($row["Store_Manager"]) . "</td>";
                                        echo "<td>" . htmlentities($row["Street"]) . "</td>";
                                        echo "<td>" . htmlentities($row["City"]) . "</td>";
                                        echo "<td>" . htmlentities($row["State"]) . "</td>";
                                        echo "<td>" . htmlentities($row["Zipcode"]) . "</td>";
                                        echo "<td>" . htmlentities($row["total_order"]) . "</td></tr>";
                                    }
                                        mysqli_free_result($result);
                                ?>
                            </tbody>
                        </table>
                        <script>
                            $(function(){
                                $('#dataTables-1').dataTable( {
                                    "bProcessing": true,
                                } );
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>



