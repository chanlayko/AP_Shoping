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
                <h3 class="card-title">Adding Description</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php
                    if(isset($_POST['submit'])){
                         if(empty($_POST['name']) || empty($_POST['desc'])){
                            if(empty($_POST['name'])){
                                $nameError = "* Name cannot be Null *";
                            }
                            if(empty($_POST['desc'])){
                                $descError = "* Description cannot be Null *";
                            }
                        }else{
                            $name = $_POST['name'];
                            $desc = $_POST['desc'];

                            $pdostat = $pdo -> prepare("INSERT INTO categories(cat_name,cat_description) VALUES (:cat_name,:cat_desc)");
                            $reault = $pdostat -> execute(
                                array(":cat_name"=>$name,":cat_desc"=>$desc)
                            );
                             
                            if($reault){
                                echo "<script>alert('Sussessfully Adding Category');window.location.href='category.php';</script>";
                              }

                        }
                    }
               
               
               
               ?>
              <form action="" method="post">
                <div class="card-body">
                <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                 <div class="form-group">
                    <label for="exampleName">Name</label>
                    <input type="text" class="form-control" name="name" id="exampleName" placeholder="Enter Your Name">
                    <p style="color:red"><?php echo empty($nameError) ? '' : $nameError; ?></p>

                  </div>
                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="desc" id="description" class="form-control" cols="30" rows="7" placeholder="Text Description"></textarea>
                    <p style="color:red"><?php echo empty($descError) ? '' : $descError; ?></p>

                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                  <a href="category.php"><button class="btn btn-primary">Black</button></a>
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

             