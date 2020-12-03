<?php include_once "header.php" ?>

<?php 
    if(!empty($_SESSION['cart'])){
        if($_SESSION['user_id']){
            $userId = $_SESSION['user_id'];
    
            $total = 0;
            foreach ($_SESSION['cart'] as $key => $qty){
                $id = str_replace('id','',$key);
                $stat = $pdo -> prepare("SELECT * FROM products WHERE pro_id=".$id);
                $stat -> execute();
                $result = $stat -> fetch(PDO::FETCH_ASSOC);
                $total = $result['pro_price'] * $qty;
            }

            $saleOStat = $pdo -> prepare("INSERT INTO sale_orders (sal_user_id,sal_total_price,sal_order_date) VALUES (:salUser,:saltotal_price,:salodate)");
            $salResult = $saleOStat -> execute(
                array (':salUser'=>$userId,':saltotal_price'=>$total,':salodate'=>date('Y-m-d H:i:s'))
            );

            if($salResult){
                $salODid = $pdo -> lastInsertId();

                foreach($_SESSION['cart'] as $key => $qty){
                    $id = str_replace('id','',$key);

                    $salODstat = $pdo -> prepare("INSERT INTO sale_orders_detail (salod_order_id,salod_product_id,salod_quarlity) VALUES (:salODid,:salODpro,:salODqty)");
                    $salODResult = $salODstat -> execute(
                        array (':salODid'=>$salODid,':salODpro'=>$id,':salODqty'=>$qty)
                    );

                    $qtyStat = $pdo -> prepare("SELECT pro_quarlity FROM products WHERE pro_id=".$id);
                    $qtyStat -> execute();
                    $qtyResult = $qtyStat -> fetch(PDO::FETCH_ASSOC);

                    $upResult = $qtyResult['pro_quarlity'] - $qty;

                    $upStat = $pdo -> prepare("UPDATE products SET pro_quarlity=:qty WHERE pro_id=".$id);
                    $upResult = $upStat -> execute(
                        array(':qty'=>$upResult)
                    );
                }
            }
            unset($_SESSION['cart']);
        }
    }

?>
	<!-- Start Header Area -->
	<header class="header_area sticky-header">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light main_box">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="index.php"><h4>AP Shopping<h4></a>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
					 aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
						<ul class="nav navbar-nav navbar-right">
							<li class="nav-item"><a href="#" class="cart"><span class="ti-bag"></span></a></li>
							<li class="nav-item">
								<button class="search"><span class="lnr lnr-magnifier" id="search"></span></button>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
		<div class="search_input" id="search_input_box">
			<div class="container">
				<form class="d-flex justify-content-between">
					<input type="text" class="form-control" id="search_input" placeholder="Search Here">
					<button type="submit" class="btn"></button>
					<span class="lnr lnr-cross" id="close_search" title="Close Search"></span>
				</form>
			</div>
		</div>
	</header>
	<!-- End Header Area -->

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Confirmation</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->

	<!--================Order Details Area =================-->
	<section class="order_details section_gap">
		<div class="container">
			<h3 class="title_confirmation">Thank you. Your order has been received.</h3>
		</div>
	</section>
	<!--================End Order Details Area =================-->

	<?php include_once "footer.php" ?>