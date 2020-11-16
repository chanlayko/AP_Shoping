<?php 
    require_once "../confiy/confiy.php";
    
    $sql = "DELETE FROM categories WHERE id=".$_GET['id'];
    $pdostat = $pdo -> prepare($sql);
    $result = $pdostat -> execute();
    
    header("Location: category.php");

?>