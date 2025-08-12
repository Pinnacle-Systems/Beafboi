<?php
session_start();
if (isset($_SESSION['email']) && isset($_SESSION['token'])) {
    exit(header("location:index.php"));
}
$msg = "";
if (isset($_POST['email']) && isset($_POST['password'])) {
  
    include_once('managers/admin_manager.php');
    $email = $_POST['email'];
    $password = $_POST['password'];
    $admin = getAdminByEmailAndPassword($email, $password);

    if (sizeof($admin) > 0 && $admin['ADMIN_EMAIL'] == $email) {
        $token = setAdminToken($email, 50);
        if ($token != '') {
            $_SESSION['email'] = $email;
            $_SESSION['token'] = $token;
            exit(header("location:index.php"));
        } else {
            $msg = "Something Went wrong. Please try again later";
        }
    } else {
        $msg = "Invalid Login";
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <link rel="stylesheet" href="../css/bootstrap.css">
        <style>
            *{
                margin:0px;
                padding:0px;
            }
            body{
                width:100%;
                height:100%;
                background-color: #ebeeef;
            }
            .login-container{
                background: #fff;
                width:calc(100% - 20px);
                max-width: 600px;
                position:relative;
                top:50%;
                left:50%;
                transform:translate(-50%,-50%);
                border-radius: 10px;
                overflow: hidden;
            }
            .login100-form-title {
                width: 100%;
                position: relative;
                z-index: 1;
                display: -webkit-box;
                display: -webkit-flex;
                display: -moz-box;
                display: -ms-flexbox;
                display: flex;
                flex-wrap: wrap;
                flex-direction: column;
                align-items: center;
                background-repeat: no-repeat;
                background-size: cover;
                background-position: center;
                padding: 60px 0px 64px;
            }
            .login100-form-title::before {
                content: "";
                display: block;
                position: absolute;
                z-index: -1;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                background-color: rgba(54,84,99,.7);
            }
            .title{
                font-family: Poppins-Bold;
                font-size: 30px;
                color: #fff;
                text-transform: uppercase;
                line-height: 1.2;
                text-align: center;
            }
            .textfield{
                border:none;
                border-bottom: 1px solid #555;
                border-radius: 0px;
            }
        </style>
    </head>
    <body>
        <div class="login-container">
            <div class="login100-form-title" style="background-image: url(../img/bg-01.jpg);">
                <span class="title">
                    Sign In
                </span>
            </div>
            <div class="pl-2 pl-sm-5 pr-2 pr-sm-5 mt-5 mb-5">
                <form action="login.php" method="post" autocomplete="off">
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-3 col-form-label">Email</label>
                        <div class="col-sm-9 col-9">
                            <input type="email" class="form-control shadow-none textfield" name="email" id="email">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-3 col-form-label">Password</label>
                        <div class="col-sm-9 col-9">
                            <input type="password" class="form-control shadow-none textfield" name="password" id="password" >
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <input type="submit" value="Login" class="btn btn-success mb-2 pl-5 pr-5 shadow-none" style="border-radius: 25px;" />
                        <div style="color: red;font-size: small;text-align: center" class="col-12">
                            <?php echo $msg; ?>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>