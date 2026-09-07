<?php session_start();
global $con;
require_once __DIR__ . '/includes/config.php';
if (!isset($con) || !$con) {
    throw new RuntimeException('Database connection not initialized.');
}

if (strlen($_SESSION['id']) == 0) {
    header('location:logout.php');
} else {
    if (isset($_POST['update'])) {
        $currentpwd = $_POST['cpass'] ?? '';
        $newpwd = $_POST['newpass'] ?? '';
        $uid = $_SESSION['id'];
        $sql = mysqli_query($con, "SELECT password FROM users WHERE id = '$uid' LIMIT 1");
        $user = mysqli_fetch_array($sql);

        if ($user && passwordMatches($user['password'], $currentpwd)) {
            $newHash = hashPassword($newpwd);
            $updateQuery = mysqli_query($con, "update users set password='$newHash' where id='$uid'");
            echo "<script>alert('Password Changed Successfully !!');</script>";
            echo "<script type='text/javascript'> document.location ='change-password.php'; </script>";
        } else {
            echo "<script>alert('Current Password not match !!');</script>";
            echo "<script type='text/javascript'> document.location ='change-password.php'; </script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Change your Shopping account password." />
        <meta name="author" content="Shopping" />
        <title>Shopping | Change Password</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="js/jquery.min.js"></script>
        <style>
            :root {
                --shop-primary: #4f46e5;
                --shop-primary-dark: #312e81;
                --shop-bg: #f3f6ff;
                --shop-border: rgba(79, 70, 229, 0.12);
                --shop-shadow: 0 18px 40px rgba(17, 24, 39, 0.10);
            }

            body {
                background: linear-gradient(180deg, #f8faff 0%, #eef4ff 100%);
                color: #1f2937;
            }

            header.bg-dark {
                background: linear-gradient(135deg, #111827 0%, #1f2937 100%) !important;
            }

            form.row {
                background: rgba(255, 255, 255, 0.92);
                border: 1px solid var(--shop-border);
                border-radius: 22px;
                box-shadow: var(--shop-shadow);
                padding: 28px 22px;
            }

            .form-label {
                font-weight: 700;
                color: #374151;
                margin-bottom: 8px;
            }

            .form-control {
                border-radius: 12px;
                border: 1px solid rgba(148, 163, 184, 0.45);
                height: 46px;
                padding: 12px 14px;
                box-shadow: none;
            }

            .form-control:focus {
                border-color: rgba(79, 70, 229, 0.8);
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--shop-primary) 0%, var(--shop-primary-dark) 100%);
                border: 0;
                border-radius: 12px;
                padding: 12px 22px;
                font-weight: 700;
                box-shadow: 0 14px 28px rgba(79, 70, 229, 0.18);
            }

            .btn-primary:hover {
                transform: translateY(-2px);
            }
        </style>
    </head>
    <body>
        <?php include_once('includes/header.php'); ?>

        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Change Password</h1>
                </div>
            </div>
        </header>

        <section class="py-5">
            <div class="container px-4 mt-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-8">
                        <form method="post" name="chngpwd" onSubmit="return valid();" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Current Password</label>
                                <input type="password" class="form-control" id="cpass" name="cpass" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control" id="newpass" name="newpass" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="cnfpass" name="cnfpass" required>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" name="update" id="update" class="btn btn-primary">Update</button>
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
<?php } ?>
