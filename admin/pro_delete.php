<?php 
    require_once "../confiy/confiy.php";
    
    $pdostat = $pdo -> prepare("DELETE FROM products WHERE pro_id=".$_GET['id']);
    $result = $pdostat -> execute();
    
    header("Location: product.php");

?>