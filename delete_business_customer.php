<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require_once("Includes/db.php");
        db::getInstance()->delete_business_customer($_POST["customer_id"]);
        header('Location: view_business_customer.php' );
        ?>
    </body>
</html>
