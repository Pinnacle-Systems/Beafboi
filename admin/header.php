<?php
if (isset($page)) {
    ?>
    <div class="header-top-section">
        <!--<div class="container">
          <div class="row">
            <div class="col-12 text-right">
              <h4 class="m-0 py-3" style="color:#f7941d; border-bottom:1px solid rgba(229,188,139,0.5);">Call us at: +545 124 784</h4>
            </div>
          </div>
        </div>-->

        <!--------------Top bar ends here------------------>

        <nav class="navbar navbar-expand-lg navbar-light">
            <!-- <div class="container my-3"> <a class="navbar-brand logo" href="index.php"><img src="../img/logo-food.png"></a> -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item <?php if ($page == "home") echo 'active'; ?>"> <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a> </li>
                        <li class="nav-item <?php if ($page == "category") echo 'active'; ?>"> <a class="nav-link" href="category_master.php">Categories</a> </li>
                        <li class="nav-item <?php if ($page == "product") echo 'active'; ?>"> <a class="nav-link" href="product_master.php">Products</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="logout.php">Logout</a> </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    <!--------------Nav bar ends here------------------>
    <?php
}
?>