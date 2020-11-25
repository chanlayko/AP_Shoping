<?php include_once('header.php') ?>
<?php 
    if(!empty($_POST['search'])) { 
        setcookie('search',empty($_POST['search']), time() + (86400 * 30), "/");
    }else{
        if(empty($_GET['pageno'])){
            unset($_COOKIE['search']);
            setcookie('search', null, -1, '/');
        }
    }
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
							<li class="nav-item"><a href="#" class="cart"><span class="ti-bag"></span></a></li>
							<li class="nav-item">
								<button class="search"><span class="lnr lnr-magnifier" id="search"></span></button>
							</li>
						</ul>
					</div>
				</div>
			</nav>
		</div>
<?php include_once "search_nav.php" ?>
	</header>
	<!-- End Header Area -->

	<!-- Start Banner Area -->
	<section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Welcome To Online Shop</h1>
					
				</div>
			</div>
		</div>
	</section>
	<!-- End Banner Area -->
    <div class="container">
		<div class="row">

<?php include_once "nav_siber.php" ?>  <!-- //--//--// nav_siver //--//--// -->
           
     <?php 

        if(!empty($_GET['pageno'])){
            $pageno = $_GET['pageno'];
        }else{
            $pageno = 1;
        }
        $numOfrecs = 6;
        $offset = ($pageno - 1) * $numOfrecs;

        if(empty($_POST['search']) && empty($_COOKIE['search'])){
            $pdostat = $pdo -> prepare("SELECT * FROM products ORDER BY pro_id DESC");
            $pdostat -> execute();
            $RowResult = $pdostat -> fetchAll();
            $total_pages = ceil(count($RowResult) / $numOfrecs);

            $pdostat = $pdo -> prepare("SELECT * FROM products ORDER BY pro_id DESC LIMIT $offset,$numOfrecs");
            $pdostat -> execute();
            $result = $pdostat -> fetchAll();                        
        }else{
            $searchkey = $_POST['search'] ? $_POST['search'] : $_COOKIE['search'];
            $pdostat = $pdo -> prepare("SELECT * FROM products WHERE pro_name LIKE '%$searchkey%' ORDER BY pro_id DESC");
            $pdostat -> execute();
            $RowResult = $pdostat -> fetchAll();
            $total_pages = ceil(count($RowResult) / $numOfrecs);

            $pdostat = $pdo -> prepare("SELECT * FROM products WHERE pro_name LIKE '%$searchkey%' ORDER BY pro_id DESC LIMIT $offset,$numOfrecs");
            $pdostat -> execute();
            $result = $pdostat -> fetchAll();
        }                 
    ?>
                
            <div class="col-xl-9 col-lg-8 col-md-7">
				<div class="filter-bar d-flex flex-wrap align-items-center">
					<div class="pagination">
					    <a href="?pageno=1" class="fir">First</a>
						<a href="<?php if($pageno <= 1){ echo '#';}else{ echo "?pageno=".($pageno-1);} ?>" class="prev-arrow  <?php if($pageno <= 1){ echo 'disabled';} ?>">
						    <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
				        </a>
						<a href="#" class="active"><?php echo $pageno; ?></a>
						<a href="<?php if($pageno >= $total_pages){ echo '#';}else{ echo "?pageno=".($pageno+1);} ?>" class="next-arrow <?php if($pageno >= $total_pages){echo 'disabled';}?>">
						    <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
				        </a>
						<a href="?pageno=<?php echo $total_pages ?>" class="las">Last</a>
					</div>
				</div>
				<!-- End Filter Bar -->
				<!-- Start Best Seller -->
				<section class="lattest-product-area pb-40 category-list">
					<div class="row">
						<!-- single product -->
                    <?php 
                        foreach($result as $value){
                        ?>
						<div class="col-lg-4 col-md-6">
							<div class="single-product">
                                <a href="view_detail.php?id=<?php echo escape($value['pro_id']) ?>"><img class="img-fluid" src="admin/images/<?php echo escape($value['pro_image']) ?>" alt=""></a>
                                <div class="product-details">
                                    <h6><?php echo escape($value['pro_name']) ?></h6>
                                    <div class="price">
                                        <h6><?php echo escape($value['pro_price']) ?></h6>
                                        <h6 class="l-through">$210.00</h6>
                                    </div>
                                    <div class="prd-bottom">

                                        <a href="" class="social-info">
                                            <span class="ti-bag"></span>
                                            <p class="hover-text">add to bag</p>
                                        </a>
                                        <a href="view_detail.php?id=<?php echo escape($value['pro_id']) ?>" class="social-info">
                                            <span class="lnr lnr-move"></span>
                                            <p class="hover-text">view more</p>
                                        </a>
                                    </div>
                                </div>
							</div>
						</div>
                        <?php
                        }

                    ?>
					</div>
				</section>
             </div>
        </div>
    </div>


				<!-- End Best Seller -->
<?php include('footer.php');?>
