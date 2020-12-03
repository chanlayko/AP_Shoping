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
        if(empty($_POST['name']) || empty($_POST['desc']) || empty($_POST['cat']) || empty($_POST['qut']) || empty($_POST['price']) || empty($_FILES['image'])){
            if(empty($_POST['name'])){
                $nameError = "* Name cannot be Null *";
            }
            if(empty($_POST['desc'])){
                $descError = "* Description cannot be Null *";
            }
            if(empty($_POST['cat'])){
                $catError = "* Category cannot be Null *";
            }
            if(empty($_POST['qut'])){
                $qutError = "* Quantity cannot be Null *";
            }elseif(is_numeric($_POST['qut']) != 1){
                $qutError = "* Quantity should be int value";
            }
            if(empty($_POST['price'])){
                $priceError = "* Price cannot be Null *";
            }elseif(is_numeric($_POST['price']) != 1){
                $priceError = "* Price should be nit value";
            }
            if(empty($_FILES['image'])){
                $imgError = "* Image cannot be Null *";
            }
        }else{
            if(is_numeric($_POST['qut'] != 1)){
                $qutError = "Quantity should be integer value";
            }
            if(is_numeric($_POST['price'] != 1)){
                $priceError = "Price should be integer value";
            }
            if($qutError == '' && $priceError == ''){
                $imgfile = "images/".($_FILES["image"]["name"]);

                $imgfileType = pathinfo($imgfile,PATHINFO_EXTENSION);

                if($imgfileType != 'png' && $imgfileType != 'jpg' && $imgfileType != 'jpeg'){
                    echo "<script>alert('Image may be png ,jpg ,jpeg')</script>";
                }else{
                    $name = $_POST['name'];
                    $desc = $_POST['desc'];
                    $qut = $_POST['qut'];
                    $price = $_POST['price'];
                    $cat = $_POST['cat'];
                    $image = $_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'],$imgfile);

                    $pdostat = $pdo -> prepare("INSERT INTO products(pro_name,pro_description,pro_price,pro_quarlity,pro_category_id,pro_image) VALUES (:name,:desc,:price,:qut,:cat,:img)");
                    $result = $pdostat -> execute(
                        array(':name'=>$name,':desc'=>$desc,':price'=>$price,':qut'=>$qut,':cat'=>$cat,':img'=>$image)
                    );
                    if($result){
                        echo "<script>alert('Sussessfully Create Products Adding');window.location.href='product.php';</script>";
                    }
                }  
            }
            
            
        }
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
              <li class="breadcrumb-item"><a href="#">Product Adding</a></li>
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
                <h5 class="m-0">Product Adding</h5>
              </div>
              <div class="card-body">
                  <form action="" method="post" enctype="multipart/form-data">
                   <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" >
                        <p style="color:red"><?php echo empty($nameError) ? '' : $nameError; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="desc">Description</label>
                        <textarea name="desc" class="form-control" id="desc" cols="20" rows="5"></textarea>
                        <p style="color:red"><?php echo empty($descError) ? '' : $descError; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="cat">Category</label>
                        <select name="cat" id="cat" class="form-control">
                            <option value="">Select Category</option>
                            <?php 
                                $catStat = $pdo -> prepare("SELECT * FROM categories");
                                $catStat -> execute();
                                $catResult = $catStat -> fetchAll();
                            
                                foreach($catResult as $value){
                            ?>
                               <option value="<?php echo escape($value['id']) ?>"><?php echo escape($value['cat_name']) ?></option>
                                              
                            <?php
                                }
                            ?>
                        </select>
                        <p style="color:red"><?php echo empty($catError) ? '' : $catError; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="qut">Quanity</label>
                        <input type="number" class="form-control" id="qut" name="qut" >
                        <p style="color:red"><?php echo empty($qutError) ? '' : $qutError; ?></p>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" >
                        <p style="color:red"><?php echo empty($priceError) ? '' : $priceError; ?></p>
                    </div>
                    <div class="form-group">
                       <label for="image">Image</label><br>
                        <input type="file" name="image" id="image">
                        <p style="color:red"><br><?php echo empty($imgError) ? '' : $imgError; ?></p>
                    </div>
                    <div class="form-group">
                        <a href="#"><input type="submit" value="SUBMIT" name="submit" class="btn btn-primary"></a>
                        <a href="product.php"><input type="button" value="Black" class="btn btn-primary"></a>
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
