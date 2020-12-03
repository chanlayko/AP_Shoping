<?php include_once('header.php') ?>

  <?php 
   
    if(isset($_POST['register'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];
        $password = $_POST['password'];
        
        if(empty($name) || empty($email) || empty($phone) || empty($address) || empty($password) || strlen($password) <4){
            if(empty($name)){
                $nameError = "* Name is Require *";
            }
            if(empty($email)){
                $emailError = "* Email is Require *";
            }
            if(empty($phone)){
                $phoneError = "* Phone is Require *";
            }
            if(empty($address)){
                $addError = "* Address is Require *";
            }
            if(empty($password) || strlen($password) < 4){
                $passError = "* Password is Require *";
            }else{
                $passError = "* Password should be 4 characters at least *";
            }
        }else{
            $password = password_hash($password,PASSWORD_DEFAULT);
            
            $regStat = $pdo -> prepare("SELECT * FROM users WHERE email=:email");
            $regStat -> execute([":email"=>$email]);
            $regResult = $regStat -> fetch(PDO::FETCH_ASSOC);
            if($regResult){
                echo "<script>alert('Emial duplicaed !!')</script>";
            }else{
                $stat = $pdo -> prepare("INSERT INTO users (name,email,password,phone,address) VALUE (:name,:email,:password,:phone,:address)");
                $inqu = $stat -> execute(
                    array(':name'=>$name,':email'=>$email,':password'=>$password,':phone'=>$phone,':address'=>$address)
                );  
                if($inqu){
                    echo "<script>alert('Sussessfully insert your Data');window.location.href='login.php';</script>";
                }
            }
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
							<li class="nav-item active"><a class="nav-link" href="register.php">registration</a></li>
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
	<!-- End Header Area -->

	<!-- Start Banner Area -->
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
							<a class="primary-btn" href="login.php">log in</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="login_form_inner">
						<h3>registarstion in to enter</h3>
						<form class="row login_form" action="register.php" method="post" id="contactForm" novalidate="novalidate">
				            <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
				            
							<div class="col-md-12 form-group">
								<input type="text" class="form-control" id="name" name="name" placeholder="Name" onfocus="this.placeholder = '<?php echo empty($nameError) ? '' : $nameError; ?>'" onblur="this.placeholder = '<?php echo empty($nameError) ? '' : $nameError; ?>'" style="<?php echo empty($nameError) ? '' : 'border: 1px solid red'; ?>" value="">
							</div>
							
							<div class="col-md-12 form-group">
								<input type="email" class="form-control" id="email" name="email" placeholder="Email" onfocus="this.placeholder = '<?php echo empty($emailError) ? '' : $emailError; ?>'" onblur="this.placeholder = '<?php echo empty($emailError) ? '' : $emailError; ?>'" style="<?php echo empty($emailError) ? '' : 'border: 1px solid red'; ?>" value="">
							</div>
							
							<div class="col-md-12 form-group">
								<input type="number" class="form-control" id="phone" name="phone" placeholder="Phone" placeholder="" onfocus="this.placeholder = '<?php echo empty($phoneError) ? '' : $phoneError; ?>'" onblur="this.placeholder = '<?php echo empty($phoneError) ? '' : $phoneError; ?>'" style="<?php echo empty($phoneError) ? '' : 'border: 1px solid red'; ?>" >
							</div>
							
							<div class="col-md-12 form-group">
							    <textarea name="address" class="form-control address" placeholder="Addresses" id="addressReg" cols="30" rows="2" onfocus="this.placeholder = '<?php echo empty($addError) ? '' : $addError; ?>'" onblur="this.placeholder = '<?php echo empty($addError) ? '' : $addError; ?>'" style="<?php echo empty($addError) ? '' : 'border: 1px solid red'; ?>"></textarea>
							</div>
							<div class="col-md-12 form-group">
								<input type="password" class="form-control" id="name" name="password" placeholder="Password" onfocus="this.placeholder = '<?php echo empty($passError) ? '' : $passError; ?>'" onblur="this.placeholder = '<?php echo empty($passError) ? '' : $passError; ?>'" style="<?php echo empty($passError) ? '' : 'border: 1px solid red'; ?>" value="">
							</div>
							<div class="col-md-12 form-group"></div>
							<div class="col-md-12 form-group">
								<button type="submit" value="submit" name="register" class="primary-btn">register</button>
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