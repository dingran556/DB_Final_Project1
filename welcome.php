<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>


    <head>
        <meta charset="UTF-8">
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
        <script src="js/metro/metro-global.js"></script>
        <script src="js/metro/metro-locale.js"></script>
        <script src="js/metro/metro-calendar.js"></script>
        <!-- Metro UI CSS JavaScript plugins -->
        <script src="js/load-metro.js"></script>  
    
        <script src="js/docs.js"></script>
        <script src="js/github.info.js"></script>
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
               <a href="javascript:history.go(-1)"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                Cosmetic Store<small class="on-right">Employee</small>
            </h1>

            <nav class="horizontal-menu">
                <ul>
                    <li><a href="store_main.php">Store</a></li>
                    <li><a href="employee_main.php">Staff</a><s/li>
                    <li><a href="customer_main.php">Customer</a></li>
                    <li><a href="product_main.php">Product</a></li>
                    <li><a href="transaction_main.php">Transaction</a></li> 
                    <li><a href="statistics_main.php">Statistics</a></li>
                </ul>
            </nav>
            <div class="grid fluid">
                <div class='row'>
                    <div class='span8'>
                        <h1>Welcome!  <?php echo strtoupper($_SESSION['user']);?></h1>
                    </div>
                    <div class="span4">
                       <div class="calendar small" data-role="calendar"></div>
                       <object type="application/x-shockwave-flash" style="outline:none;" data="http://cdn.abowman.com/widgets/fish/fish.swf?" width="300" height="200"><param name="movie" value="http://cdn.abowman.com/widgets/fish/fish.swf?"></param><param name="AllowScriptAccess" value="always"></param><param name="wmode" value="opaque"></param><param name="scale" value="noscale"/><param name="salign" value="tl"/></object>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

