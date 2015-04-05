<?php
require_once("Includes/db.php");
$logonSuccess = false;
// verify user's credentials
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $logonSuccess = (db::getInstance()->verify_users($_POST['user'], $_POST['userpassword']));
    if ($logonSuccess == true) {
        $_SESSION['user'] = $_POST['user'];
        header('Location: welcome.php');
        exit;
    }
}
?>
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
    <body class='metro'>
        <div class="container">

            <br><br><br><br><br><br><br><br><br><br><br>
            <div class='grid fluid'>
                <div class='row'>    
                    <div class="span5">  
                        <form name="logon" action="index.php" method="POST" >
                            <fieldset>
                                <legend>LOG<i class='icon-user'></i>IN</legend>
                                <label>Username: </label>
                                <div class="input-control text" data-role="input-control">
                                    <input type="text" name="user" placeholder="type username" autofocus>
                                    <button class="btn-clear" tabindex="-1"></button>
                                </div>
                                <label>Password: </label>
                                <div class="input-control password" data-role="input-control">
                                    <input type="password" name="userpassword"placeholder="type password">
                                    <button class="btn-reveal" tabindex="-1"></button>
                                </div>
                                <button class="button success">Log in</button>

                            </fieldset>
                        </form>
                        Customer? click <a href="customer_view_product.php">here</a>
                    </div>
                    <div class='span6'>
                        <div class="tile double live" data-role="live-tile"  style="height:250px;width:500px">
                            <div class="tile-content image">
                                <img src="images/Cosmetics01.jpg">
                            </div>
                            <div class="tile-content image">
                                <img src="images/Cosmetics02.jpg">
                            </div>
                            <div class="tile-content image">
                                <img src="images/Cosmetics03.jpg">
                            </div>
                            <div class="tile-content image">
                                <img src="images/Cosmetics04.jpg">
                            </div>

                            <div class="tile-status bg-dark opacity">
                                <span class="label">Welcome To Online Cosmetic Store!</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (!$logonSuccess)
                    echo "Invalid name and/or password";
            }
            ?>
        </div>
    </body>
</html>