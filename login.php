<?php include_once('header.php') ?>

 <?php 
  
    if(isset($_POST['login'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $pdostat = $pdo->prepare("SELECT * FROM users WHERE email=:email");
        $pdostat -> bindValue(":email",$email); 
        $pdostat -> execute();
        $user = $pdostat -> fetch(PDO::FETCH_ASSOC);
        if($user){
            if(password_verify($password,$user['password'])){
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user'] = $user['name'];
                $_SESSION['role'] = 1;
                $_SESSION['logged_in'] = time();
                
                header("Location: admin/product.php");
            }
        }
        echo "<script>alert('Incorrect credentials !!')</script>";
        
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
							<li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
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
							<li class="nav-item active"><a class="nav-link" href="login.php">log in</a></li>
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
    <section class="banner-area organic-breadcrumb">
		<div class="container">
			<div class="breadcrumb-banner d-flex flex-wrap align-items-center justify-content-end">
				<div class="col-first">
					<h1>Login/Register</h1>
					<nav class="d-flex align-items-center">
						<a href="index.php">Home<span class="lnr lnr-arrow-right"></span></a>
						<a href="register.php">Login/Register</a>
					</nav>
				</div>
			</div>
		</div>
	</section>
	<!-- Start Banner Area -->
	
	<!-- End Banner Area -->

	<!--================Login Box Area =================-->
	<section class="login_box_area section_gap">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<div class="login_box_img">
						<img class="img-fluid" src="img/login.jpg" alt="">
						<div class="hover">
							<h4>New to our website?</h4>
							<p>There are advances being made in science and technology everyday, and a good example of this is the</p>
							<a class="primary-btn" href="register.php">Create an Account</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="login_form_inner">
						<h3>Log in to enter</h3>
						<form class="row login_form" action="login.php" method="post" id="contactForm" novalidate="novalidate">
						  <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
							<div class="col-md-12 form-group">
								<input type="email" class="form-control" id="email" name="email" placeholder="User email" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Useremail'">
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control" id="password" name="password" placeholder="Password" onfocus="this.placeholder = ''" onblur="this.placeholder = 'password'">
							</div>
							<div class="col-md-12 form-group">
							
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" name="login" class="primary-btn">Log In</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
        </div>
    </div>
</div>


	<!--================End Login Box Area =================-->
<?php include_once('footer.php') ?>