<?php session_start();
error_reporting(0);
global $con;
require_once __DIR__ . '/includes/config.php';
if (!isset($con) || !$con) {
    throw new RuntimeException('Database connection not initialized.');
}

if (isset($_POST['submit'])) {
    $username = $_POST['emailid'];
    $cnumber = $_POST['phoneno'];
    $newpassword = hashPassword($_POST['inputPassword']);
    $ret = mysqli_query($con, "SELECT id FROM users WHERE email='$username' and contactno='$cnumber'");
    $num = mysqli_num_rows($ret);

    if ($num > 0) {
        $query = mysqli_query($con, "update users set password='$newpassword' WHERE email='$username' and contactno='$cnumber'");
        echo "<script>alert('Password reset successfully.');</script>";
        echo "<script type='text/javascript'> document.location ='login.php'; </script>";
    } else {
        echo "<script>alert('Invalid Email or Reg Contact Number');</script>";
        echo "<script type='text/javascript'> document.location ='password-recovery.php'; </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Recover access to your Shopping account securely." />
        <meta name="author" content="Shopping" />
        <title>Shopping | Password Recovery</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="js/jquery.min.js"></script>
        <script type="text/javascript">
            function valid() {
                if (document.passwordrecovery.inputPassword.value != document.passwordrecovery.cinputPassword.value) {
                    alert("Password and Confirm Password Field do not match !!");
                    document.passwordrecovery.cinputPassword.focus();
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
                    <h1 class="display-4 fw-bolder">Password Recovery</h1>
                </div>
            </div>
        </header>

        <section class="py-5">
            <div class="container px-4 mt-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-8">
                        <form method="post" name="passwordrecovery" onSubmit="return valid();" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Email Id</label>
                                <input type="email" name="emailid" id="emailid" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Reg. Contact No.</label>
                                <input type="text" name="phoneno" id="phoneno" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" name="inputPassword" id="inputPassword" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="cinputPassword" id="cinputPassword" class="form-control" required>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" name="submit" id="submit" class="btn btn-primary">Submit</button>
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
