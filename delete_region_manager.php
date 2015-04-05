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
        db::getInstance()->delete_region_manager ($_POST["region_manager_id"]);
        header('Location: view_region_manager.php' );
        ?>
    </body>
</html>
