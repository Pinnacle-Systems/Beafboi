<?php
if (isset($page)) {
    include_once('admin/managers/category_manager.php');
    $categories = getCategoriesByFilterAndLimit(1, "null", "null");
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
            <div class="container my-3"> <a class="navbar-brand logo" href="index.php"><img src=""></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item <?php if ($page == "home") echo 'active'; ?>"> <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a> </li>
                        <!--<li class="nav-item"> <a class="nav-link" href="#">About</a> </li>-->
                        <li class="nav-item dropdown <?php if ($page == "products") echo 'active'; ?>"> <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Products </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown"> 
                                <?php
                                for ($i = 0; $i < sizeof($categories); $i++) {
                                    ?>
                                    <a class="dropdown-item dd2" href="products.php?category=<?php echo $categories[$i]['CATEGORY_MASTER_ID']; ?>"><?php echo $categories[$i]['CATEGORY_NAME']; ?></a>
                                    <?php
                                }
                                ?>
                                <!--              <div class="dropdown-divider"></div>-->
                        </li>
                        <li class="nav-item <?php if ($page == "contact") echo 'active'; ?>"> <a class="nav-link" href="contact_us.php">Contact us</a> </li>
                    </ul>
                    <!--                    <form class="form-inline ml-3 my-lg-0">
                                            <button class="btn btn-warning font-weight-bold dd2 text-white" type="submit">Sign In</button>
                                        </form>-->
                </div>
            </div>
        </nav>
    </div>
    <!--------------Nav bar ends here------------------>
    <?php
}
?>