<?php 
    session_start();
    require_once "../confiy/confiy.php";
    require_once "../confiy/common.php";
    
    if(empty($_SESSION['user_id'] && $_SESSION['logged_in'])){
        header("Location: login.php");
    }
    if($_SESSION['role'] != 1){
         header("Location: login.php");
    }
?>

<!--    header statr -->
<?php include_once ("header.php"); ?>

<!--    nvabar statr -->
<?php include_once ("navbar.php"); ?>
 
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Starter Page</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
           <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Adding Users</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php
               if(isset($_POST['submit'])){
                   if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['phone']) || empty($_POST['address'])){
                            if(empty($_POST['name'])){
                                $nameError = "* Name cannot be Null *";
                            }
                            if(empty($_POST['email'])){
                                $emailError = "* Email cannot be Null *";
                            }
                            if(empty($_POST['phone'])){
                                $phoneError = "* Phone cannot be Null *";
                            }
                            if(empty($_POST['address'])){
                                $addressError = "* Address cannot be Null *";
                            }
                        }elseif(!empty($_POST['password']) && strlen($_POST['password']) < 4){
                            $passError = "* Password show be 4 characters at least *";
                        }else{
                            $id = $_POST['id'];
                            $email = $_POST['email'];
                            $name = $_POST['name'];
                            $phone = $_POST['phone'];
                            $address = $_POST['address'];
                            $password = password_hash($_POST['password'],PASSWORD_DEFAULT);
                       
                            if(empty($_POST['role'])){
                                $role = 0;
                            }else{
                                $role = 1;
                            }

                            $empdostat = $pdo -> prepare("SELECT * FROM users WHERE email=:email AND id!=:id");
                            $empdostat -> execute(array(":email"=>$email,":id"=>$id));
                            $emResult = $empdostat -> fetch(PDO::FETCH_ASSOC);

                            if($emResult){
                                echo "<script>alert('Email duplicated !!')</script>";
                            }else{
                                if($password != null){
                                    $adpdostat = $pdo -> prepare("UPDATE users SET name=:name,email=:email,password=:password,phone=:phone,address=:address,role=:role WHERE id='$id'");
                                }else{
                                    $adpdostat = $pdo -> prepare("UPDATE users SET name=:name,email=:email,phone=:phone,address=:address,role=:role WHERE id='$id'"); 

                                }
                                $adReault = $adpdostat -> execute(
                                    array(":name"=>$name,":email"=>$email,":password"=>$password,":phone"=>$phone,":address"=>$address,":role"=>$role)
                                );
                                if($adReault){
                                    echo "<script>alert('Sussessfully Your Data');window.location.href='user_admin.php';</script>";
                                  }
                            }
                        }  
                    }
               
                    $pdostat = $pdo -> prepare("SELECT * FROM users WHERE id=".$_GET['id']);
                    $pdostat -> execute();
                    $result = $pdostat -> fetchAll();
               
               
               ?>
              <form action="" method="post">
                <div class="card-body">
                 <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                 <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>" >
                  <div class="form-group">
                    <label for="exampleInputEmail1">Your Name</label>
                    <input type="text" class="form-control" name="name"value="<?php echo escape($result[0]['name']); ?>" id="exampleInputEmail1" placeholder="Enter Name">
                    <p style="color:red"><?php echo empty($nameError) ? '' : $nameError; ?></p>
                  </div>
                  
                  <div class="form-group">
                    <label for="exampleInputPassword1">Your Email</label>
                    <input type="email" name="email" value="<?php echo escape($result[0]['email']); ?>" class="form-control" id="exampleInputPassword1" placeholder="Enter Email">
                    <p style="color:red"><?php echo empty($emailError) ? '' : $emailError; ?></p>
                  </div>
                  
                  <div class="form-group">
                    <label for="phone">Your Phone</label>
                    <input type="number" class="form-control" value="<?php echo escape($result[0]['phone']); ?>" id="phone" name="phone">
                    <p style="color:red"><?php echo empty($phoneError) ? '' : $phoneError; ?></p>
                  </div>
                    
                  <div class="form-group">
                    <label for="address">Your Address</label>
                    <textarea name="address" class="form-control" id="address" cols="20" rows="5"><?php echo escape($result[0]['address']); ?></textarea>
                    <p style="color:red"><?php echo empty($addressError) ? '' : $addressError; ?></p>
                 </div>
                    
                  <div class="form-group">
                    <label for="exampleInputPassword">Password <small style="color:gray">This User already has a Password</small></label>
                    <input type="password" name="password" value="" class="form-control" id="exampleInputPassword" placeholder="Password">
                    <p style="color:red"><?php echo empty($passError) ? '' : $passError; ?></p>
                  </div>
                  
                  <div class="form-group">
                   <label for="exampleCheck1">Admin Check</label><br>
                    <input type="checkbox"  id="exampleCheck1" name="role" value="1" <?php echo $result[0]['role'] == 1 ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="exampleCheck1">Check Admin</label>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                  <a href="user_admin.php"><input type="button" class="btn btn-primary" value="Black"></a>
                </div>
              </form>
            </div>
          </div>
          
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

<!--    footer end  -->
<?php include_once ("footer.php") ?>

             