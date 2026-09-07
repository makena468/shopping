<?php session_start();
global $con;
require_once __DIR__ . '/includes/config.php';
if (!isset($con) || !$con) {
    throw new RuntimeException('Database connection not initialized.');
}

error_reporting(0);

if (isset($_POST['submit'])) {
    $name = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['emailid'] ?? '');
    $contactno = trim($_POST['contactnumber'] ?? '');
    $password = hashPassword($_POST['inputuserpwd'] ?? '');
    $sql = mysqli_query($con, "select id from users where email='$email'");
    $count = mysqli_num_rows($sql);

    if ($count == 0) {
        $query = mysqli_query($con, "insert into users(name,email,contactno,password) values('$name','$email','$contactno','$password')");
        if ($query) {
            echo "<script>alert('You are successfully registered');</script>";
            echo "<script type='text/javascript'> document.location ='login.php'; </script>";
        } else {
            echo "<script>alert('Registration failed. Please try again.');</script>";
            echo "<script type='text/javascript'> document.location ='signup.php'; </script>";
        }
    } else {
        echo "<script>alert('Email id already registered with another account. Please try with another email id.');</script>";
        echo "<script type='text/javascript'> document.location ='signup.php'; </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="Create a Shopping account to place orders and manage your profile." />
        <meta name="author" content="Shopping" />
        <title>Shopping | User Sign Up</title>
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

            #user-email-status {
                display: block;
                margin-top: 8px;
                color: #4b5563;
                font-weight: 600;
            }
        </style>
        <script>
            function emailAvailability() {
                $("#loaderIcon").show();
                jQuery.ajax({
                    url: "check_availability.php",
                    data: 'email=' + $("#emailid").val(),
                    type: "POST",
                    success: function(data) {
                        $("#user-email-status").html(data);
                        $("#loaderIcon").hide();
                    },
                    error: function() {}
                });
            }
        </script>
    </head>
    <body>
        <?php include_once('includes/header.php'); ?>

        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">User Signup</h1>
                    <p class="lead fw-normal text-white-50 mb-0">One time registration is required for Shopping</p>
                </div>
            </div>
        </header>

        <section class="py-5">
            <div class="container px-4 mt-5">
                <div class="row justify-content-center">
                    <div class="col-12 col-lg-8">
                        <form method="post" name="signup" class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="fullname" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email Id</label>
                                <input type="email" name="emailid" id="emailid" class="form-control" onBlur="emailAvailability()" required>
                                <span id="user-email-status" style="font-size:12px;"></span>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Contact Number</label>
                                <input type="text" name="contactnumber" pattern="[0-9]{10}" title="10 numeric characters only" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Password</label>
                                <input type="password" name="inputuserpwd" class="form-control" required>
                            </div>

                            <div class="col-12 text-center">
                                <button type="submit" name="submit" id="submit" class="btn btn-primary">Register</button>
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
