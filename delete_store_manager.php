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
        db::getInstance()->delete_store_manager ($_POST["store_manager_id"]);
        if(mysqli_error()){
            echo "<script type='text/javascript'>alert('fialed');</script>";
        }
        header('Location: view_store_manager.php' );
        ?>
    </body>
</html>
