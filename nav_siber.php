<div class="col-xl-3 col-lg-4 col-md-5">
    <div class="sidebar-categories">
        <div class="head">Browse Categories</div>
        <ul class="main-categories">
            <li class="main-nav-list">
              <?php 
                    $stat = $pdo -> prepare("SELECT * FROM categories");
                    $stat -> execute();
                    $result = $stat -> fetchAll();
                    
                    foreach($result as $value){
                ?>
                    <a href="categories.php?id=<?php echo escape($value['id']) ?>"><?php echo escape($value['cat_name']) ?></a>
                <?php
                    }
                ?>
            </li>
        </ul> 
    </div>
</div>