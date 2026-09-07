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
        $name = $_POST['fullname'];
        $uid = $_SESSION['id'];
        $contactno = $_POST['contactnumber'];
        $query = mysqli_query($con, "update users set name='$name',contactno='$contactno' where id='$uid'");

        if ($query) {
            echo "<script>alert('Profile Updated successfully');</script>";
            echo "<script type='text/javascript'> document.location ='my-profile.php'; </script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
            echo "<script type='text/javascript'> document.location ='my-profile.php'; </script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Edit your Shopping account profile details." />
        <meta name="author" content="Shopping" />
        <title>Shopping | My Profile</title>
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
                <?php
                $uid = $_SESSION['id'];
                $query = mysqli_query($con, "select * from users where id='$uid'");
                while ($result = mysqli_fetch_array($query)) {
                ?>
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder"><?php echo htmlentities($result['name']); ?>'s Profile</h1>
                </div>
            </div>
        </header>

        <section class="py-5">
            <div class="container px-4 mt-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-8">
                        <form method="post" name="profile" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="fullname" value="<?php echo htmlentities($result['name']); ?>" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email Id</label>
                                <input type="email" name="emailid" id="emailid" class="form-control" value="<?php echo htmlentities($result['email']); ?>" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Contact Number</label>
                                <input type="text" name="contactnumber" value="<?php echo htmlentities($result['contactno']); ?>" pattern="[0-9]{10}" title="10 numeric characters only" class="form-control" required>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" name="update" id="update" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <?php } ?>

        <?php include_once('includes/footer.php'); ?>

        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
<?php } ?>
