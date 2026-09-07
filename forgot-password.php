<?php
session_start();
error_reporting(0);
global $con;
require_once __DIR__ . '/includes/config.php';
if (!isset($con) || !$con) {
    throw new RuntimeException('Database connection not initialized.');
}

if (isset($_POST['change'])) {
    $email = trim($_POST['email'] ?? '');
    $contact = trim($_POST['contact'] ?? '');
    $password = hashPassword($_POST['password'] ?? '');
    $query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' and contactno='$contact'");
    $num = mysqli_fetch_array($query);

    if ($num > 0) {
        $extra = "forgot-password.php";
        mysqli_query($con, "update users set password='$password' WHERE email='$email' and contactno='$contact' ");
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("location:http://$host$uri/$extra");
        $_SESSION['errmsg'] = "Password Changed Successfully";
        exit();
    } else {
        $extra = "forgot-password.php";
        $host = $_SERVER['HTTP_HOST'];
        $uri = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        header("location:http://$host$uri/$extra");
        $_SESSION['errmsg'] = "Invalid email id or Contact no";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Reset your Shopping account password securely." />
        <meta name="author" content="Shopping" />
        <title>Shopping | Forgot Password</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script type="text/javascript">
            function valid() {
                if (document.register.password.value != document.register.confirmpassword.value) {
                    alert("Password and Confirm Password Field do not match !!");
                    document.register.confirmpassword.focus();
                    return false;
                }
                return true;
            }
        </script>
    </head>
    <body>
        <?php include_once('includes/header.php'); ?>

        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Forgot Password</h1>
                </div>
            </div>
        </header>

        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-6">
                        <form class="row g-3" name="register" method="post" onsubmit="return valid();">
                            <div class="col-12">
                                <span style="color:red;">
                                    <?php echo htmlentities($_SESSION['errmsg'] ?? ''); ?>
                                    <?php $_SESSION['errmsg'] = ""; ?>
                                </span>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label" for="email">Email Address</label>
                                <input type="email" name="email" class="form-control" id="email" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label" for="contact">Contact No</label>
                                <input type="text" name="contact" class="form-control" id="contact" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label" for="confirmpassword">Confirm Password</label>
                                <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" required>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary" name="change">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <?php include_once('includes/footer.php'); ?>

        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>