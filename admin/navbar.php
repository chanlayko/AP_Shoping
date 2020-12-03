  <div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
       <?php
        $link = $_SERVER['PHP_SELF'];
        $link_array = explode('/',$link);
        $page = end($link_array);
    ?>
    <!-- SEARCH FORM -->
    <?php 
        if($page == 'product.php' || $page == 'category.php' || $page == 'user_admin.php'){
            ?>
                <?php
                  if($page != 'order.php' && $page != 'order_detail.php'){
                  ?>
                    <form class="form-inline ml-3" method="post" action="<?php if($page == 'index.php'){
                        echo 'index.php';
                    }elseif($page == 'category.php'){
                        echo 'category.php';
                    }elseif($page == 'user_admin.php'){
                        echo 'user_admin.php';
                    }
                    ?>">
                     <input type="hidden" name="_token" value="<?php echo $_SESSION['_token']; ?>">
                      <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" name="search" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                          <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                          </button>
                        </div>  
                      </div>
                    </form>

                  <?php
                    }
                  ?>
            <?php
        }
      
      ?>
    
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
              <i class="fas fa-th-large"></i>
            </a>
          </li>
          <li>
              <a href="logout.php">
                  <input type="submit" value="Logout" class="btn">
              </a>
          </li>
        </ul>
  </nav>
  <!-- /.navbar -->
<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AP Shop Panel</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['user']; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="product.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Product
                <span class="right badge badge-danger"></span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="category.php" class="nav-link">
              <i class="nav-icon fas fa-list"></i>
              <p>Category</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="user_admin.php" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>User</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="order.php" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>Order</p>
            </a>
          </li>
          <li class="nav-item has-treeview menu">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Reprot
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="weekly_reprot.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Weekly Reprot</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="monthly_report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly Reprot</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="royal_customer.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Royal Customer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="best_saller_item.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Best Saller Item</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  