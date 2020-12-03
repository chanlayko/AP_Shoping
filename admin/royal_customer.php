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

<!-- header -->
<?php include_once ("header.php"); ?>    
<!-- nvabar include -->
<?php include_once ("navbar.php"); ?>

  <!-- Content Wrapper. Contains page content --> 
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Weekly Reprot</h1>
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
                <h5 class="m-0">Featured</h5>
              </div>
              <?php 
                
//                $curDate = date("Y-m-d");
//                $fromDate = date("Y-m-d",strtotime($curDate . '+1 day'));
//                $toDate = date("Y-m-d",strtotime($curDate . '-7 day'));
                
                $sql = "SELECT * FROM sale_orders WHERE sal_total_price >= 20000 ORDER BY sal_id DESC";
                $pdostat = $pdo -> prepare($sql);
                $pdostat -> execute();
                $result = $pdostat -> fetchAll();                        
                
              ?>
              <div class="card-body">
                   <div class="form-group">
                    <table class="table table-bordered table-striped table-hover" id="J_table">
                        <thead class="text-center">
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>User</th>
                                <th>Total Amount</th>
                                <th>Order Date</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php 

                                if($result){
                                    $i = 1;
                                    foreach($result as $value){
                                       $userStat = $pdo -> prepare("SELECT * FROM users WHERE id=".$value['sal_user_id']); 
                                       $userStat -> execute();
                                       $userResult = $userStat -> fetchAll();
                                ?>
                                    <tr>
                                        <td><?php echo $i ?></td>
                                        <td><?php echo escape($userResult[0]['name']) ?></td>
                                        <td><?php echo escape($value['sal_total_price']) ?></td>
                                        <td><?php echo escape(date("Y-m-d",strtotime($value['sal_order_date']))) ?></td>
                                    </tr>  

                                <?php
                                    $i++;
                                    }
                                }



                            ?>
                           
                        </tbody>
                    </table>

                   </div>
              </div>
              <!-- /.card-body -->
              
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

 <?php include_once("footer.php"); ?>
 <script>
         $(document).ready(function() {
            $('#J_table').DataTable();
        } );
</script>