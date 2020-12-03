<?php 
    session_start();
    require_once "confiy/confiy.php";

    if($_POST){
        $id = $_POST['id'];
        $qty = $_POST['qty'];
        
        $stat = $pdo -> prepare("SELECT * FROM products WHERE pro_id=".$id);
        $stat -> execute();
        $result = $stat -> fetch(PDO::FETCH_ASSOC);
        if($qty > $result['pro_quarlity']){
            echo "<script>alert('Not enough stock');window.location.href='view_detail.php?id=$id'</script>";
        }else{
            if(isset($_SESSION['cart']['id'.$id])){
                $_SESSION['cart']['id'.$id] += $qty;
            }else{
                $_SESSION['cart']['id'.$id] = $qty;
            }
            header("Location:cart.php");
        }
    }

?>