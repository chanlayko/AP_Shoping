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
   
    if(isset($_POST['submit'])){
        if(empty($_POST['name']) || empty($_POST['desc'])){
            if(empty($_POST['name'])){
                $nameError = "* Name cannot be Null";
            }
            if(empty($_POST['desc'])){
                $descError = "* Description cannot be Null";
            }
        }else{
            $id = $_POST['id'];
            $name = $_POST['name'];
            $desc = $_POST['desc'];
            
            $sql = "UPDATE categories SET cat_name=:name,cat_description=:cat_desc WHERE id='$id'";
            $pdostat = $pdo -> prepare($sql);
            $result = $pdostat -> execute(
                array(":name"=>$name,":cat_desc"=>$desc)
            );

            if($result){
                echo "<script>alert('Sussessfully Updated Categroy');window.location.href='category.php';</script>";
            }
        }
        
    }

    $sql = "SELECT * FROM categories WHERE id=".$_GET['id'];
    $pdostat = $pdo -> prepare($sql);
    $pdostat -> execute();
    $result = $pdostat -> fetchAll();
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
            <h1 class="m-0 text-dark">Category Page</h1>
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
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h5 class="m-0">Edit Category</h5>
              </div>
              <div class="card-body">
                  <form action="" method="post" enctype="multipart/form-data">
                   <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                   <input type="hidden" name="id" value="<?php echo $result[0]['id']; ?>">
                    <div class="form-group">
                        <label for="title">Name</label>
                        <input type="text" class="form-control" value="<?php echo escape($result[0]['cat_name']); ?>" id="title" name="name">
                        <p style="color:red"><?php echo empty($contError) ? '' : $contError; ?></p>

                    </div>
                    <div class="form-group">
                        <label for="content">Description</label>
                        <textarea name="desc" class="form-control" id="content" cols="20" rows="5"><?php echo escape($result[0]['cat_description']); ?></textarea>
                        <p style="color:red"><?php echo empty($contError) ? '' : $contError; ?></p>

                    </div><br>
                    <div class="form-group">
                        <a href="#"><input type="submit" value="SUBMIT" name="submit" class="btn btn-primary"></a>
                        <a href="category.php"><input type="button" value="Black" class="btn btn-primary"></a>
                    </div>
                  </form>
              </div>
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
        
