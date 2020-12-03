<?php include_once "header.php"; ?>
<?php 
//    if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
//        header("Location: login.php");
//    }
?>
    <!-- Start Header Area -->
    <header class="header_area sticky-header">
		<div class="main_menu">
			<nav class="navbar navbar-expand-lg navbar-light main_box">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<a class="navbar-brand logo_h" href="index.php"><h2>AP Shoping</h2></a>
					
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse offset" id="navbarSupportedContent">
						<ul class="nav navbar-nav menu_nav ml-auto">
							<li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
							<li class="nav-item submenu dropdown">
								<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
								 aria-expanded="false">categories</a>
								<ul class="dropdown-menu">
                                         <?php 
                                            $stat = $pdo -> prepare("SELECT * FROM categories");
                                            $stat -> execute();
                                            $result = $stat -> fetchAll();

                                            foreach($result as $value){
                                        ?>
                                                <li class="nav-item"><a class="nav-link" href="categories.php?id=<?php echo escape($value['id']) ?>"><?php echo escape($value['cat_name']); ?></a></li>
                                        <?php
                                            }
                                        ?>
                                    </ul>
							</li>
							<li class="nav-item submenu dropdown">
								<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
								 aria-expanded="false">Blog</a>
								<ul class="dropdown-menu">
									<li class="nav-item"><a class="nav-link" href="blog.html">Blog</a></li>
									<li class="nav-item"><a class="nav-link" href="single-blog.html">Blog Details</a></li>
								</ul>
							</li>
							<li class="nav-item"><a class="nav-link" href="login.php">log in</a></li>
							<li class="nav-item"><a class="nav-link" href="register.php">registration</a></li>
						</ul>
						<ul class="nav navbar-nav navbar-right">
						    <?php
                                $cart = 0;
                                if(isset($_SESSION['cart'])){
                                    foreach ($_SESSION['cart'] as $key => $qty){
                                        $cart += $qty;
                                    }
                                }
                            
                            ?>
							<li class="nav-item"><a href="cart.php" class="cart"><span class="ti-bag"> <?php echo $cart; ?> </span></a></li>
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
    <!-- Start Banner Area -->
    <section class="banner-area organic-breadcrumb">
        <div class="container">
            <div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
                <div class="col-first">
                    <h1>Shopping Cart</h1>
                    <nav class="d-flex align-items-center">
                        <a href="index.html">Home<span class="lnr lnr-arrow-right"></span></a>
                        <a href="category.html">Cart</a>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!--================Cart Area =================-->
    <section class="cart_area">
        <div class="container">
            <div class="cart_inner">
                <div class="table-responsive">
                   <?php 
                        if(isset($_SESSION['cart'])) :?>
                        
                        <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col">Price</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Total</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           <?php 
                                $total = 0;
                                foreach ($_SESSION['cart'] as $key => $qty) :
                                      
                                    $id = str_replace('id','',$key);
                                    
                                    $stat = $pdo -> prepare("SELECT * FROM products WHERE pro_id=".$id);
                                    $stat -> execute();
                                    $result = $stat -> fetch(PDO::FETCH_ASSOC);
                                    
                                    $total += $result['pro_price'] * $qty;
                                ?>
                                <tr>
                                <td>
                                    <div class="media">
                                        <div class="d-flex">
                                            <img src="admin/images/<?php echo escape($result['pro_image']) ?>" alt="" width="100px">
                                        </div>
                                        <div class="media-body">
                                            <p><?php echo escape($result['pro_name']); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <h5><?php echo escape($result['pro_price']); ?></h5>
                                </td>
                                <td>
                                    <div class="product_count">
                                        <input type="text" name="qty" id="sst" maxlength="12" value="<?php echo $qty ?>" title="Quantity:"
                                            class="input-text qty">
                                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                                            class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                                        <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                                            class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                                    </div>
                                </td>
                                <td>
                                    <h5><?php echo escape($result['pro_price'] * $qty) ?></h5>
                                </td>
                                <td>
                                    <a class="primary-btn" href="move_item.php?id=<?php echo escape($result['pro_id']) ?>" style="line-height:35px;border-radius:5px">move</a>
                                </td>
                                <td></td>
                            </tr>
                            
                            <?php endforeach ?>
                            
                            <tr class="bottom_button">
                                <td>
                                    <a class="gray_btn" href="#">Update Cart</a>
                                </td>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td></td>
                                <td></td>
                                <td>
                                    <div class="cupon_text d-flex align-items-center">
                                        <a class="primary-btn" href="clearall.php">clearall</a>
                                        <a class="primary-btn" href="index.php">shoping</a>
                                        <a class="primary-btn" href="sale_order.php">order submit</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>

                                </td>
                                <td>

                                </td>
                                <td>
                                    <h5>Subtotal</h5>
                                </td>
                                <td>
                                    <h5><?php echo $total ?></h5>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                        
                    <?php endif ?>
                    
                </div>
            </div>
        </div>
    </section>
    <!--================End Cart Area =================-->
<?php include_once "footer.php"; ?>