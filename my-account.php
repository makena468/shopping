<?php
session_start();
global $con;
require_once __DIR__ . '/includes/config.php';
if (!isset($con) || !$con) {
    throw new RuntimeException('Database connection not initialized.');
}

if (empty($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}

if (isset($_POST['update'])) {
    $name = trim($_POST['name'] ?? '');
    $contactno = trim($_POST['contactno'] ?? '');

    if ($name === '' || $contactno === '') {
        echo "<script>alert('Name and contact number are required.');</script>";
    } else {
        $stmt = $con->prepare('UPDATE users SET name = ?, contactno = ? WHERE id = ?');
        $stmt->bind_param('ssi', $name, $contactno, $_SESSION['id']);
        if ($stmt->execute()) {
            $_SESSION['username'] = $name;
            echo "<script>alert('Your info has been updated');</script>";
        }
        $stmt->close();
    }
}

if (isset($_POST['submit'])) {
    $current = $_POST['cpass'] ?? '';
    $newpass = $_POST['newpass'] ?? '';
    $confirmpass = $_POST['cnfpass'] ?? '';

    if ($current === '' || $newpass === '' || $confirmpass === '') {
        echo "<script>alert('All password fields are required.');</script>";
    } else if ($newpass !== $confirmpass) {
        echo "<script>alert('New password and confirm password do not match.');</script>";
    } else {
        $stmt = $con->prepare('SELECT password FROM users WHERE id = ? LIMIT 1');
        $stmt->bind_param('i', $_SESSION['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user && passwordMatches($user['password'], $current)) {
            $hashed = hashPassword($newpass);
            $update = $con->prepare('UPDATE users SET password = ? WHERE id = ?');
            $update->bind_param('si', $hashed, $_SESSION['id']);
            if ($update->execute()) {
                echo "<script>alert('Password Changed Successfully !!');</script>";
            }
            $update->close();
        } else {
            echo "<script>alert('Current Password not match !!');</script>";
        }
    }
}

$userQuery = $con->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
$userQuery->bind_param('i', $_SESSION['id']);
$userQuery->execute();
$userResult = $userQuery->get_result();
$user = $userResult->fetch_assoc();
$userQuery->close();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <title>My Account</title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/css/red.css">
        <link rel="stylesheet" href="assets/css/owl.carousel.css">
        <link rel="stylesheet" href="assets/css/owl.transitions.css">
        <link href="assets/css/lightbox.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/animate.min.css">
        <link rel="stylesheet" href="assets/css/rateit.css">
        <link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <style>
            :root {
                --shop-primary: #4f46e5;
                --shop-primary-dark: #312e81;
                --shop-accent: #f59e0b;
                --shop-bg: #f3f6ff;
                --shop-surface: #ffffff;
                --shop-border: rgba(79, 70, 229, 0.12);
                --shop-shadow: 0 18px 40px rgba(17, 24, 39, 0.10);
            }

            body.cnt-home {
                background: linear-gradient(180deg, #f8faff 0%, #eef4ff 100%);
            }

            .breadcrumb {
                background: transparent;
                padding: 28px 0 12px;
            }

            .breadcrumb-inner {
                background: rgba(255, 255, 255, 0.80);
                border: 1px solid var(--shop-border);
                border-radius: 18px;
                box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
                padding: 14px 18px;
            }

            .checkout-box {
                padding-top: 20px;
            }

            .checkout-steps .panel {
                background: rgba(255, 255, 255, 0.92);
                border: 1px solid var(--shop-border);
                border-radius: 20px;
                box-shadow: var(--shop-shadow);
                overflow: hidden;
                margin-bottom: 22px;
            }

            .checkout-steps .panel-heading {
                background: linear-gradient(135deg, #eef2ff, #f8fafc);
                border-bottom: 1px solid var(--shop-border);
                padding: 18px 20px;
            }

            .unicase-checkout-title a {
                color: var(--shop-primary-dark);
                font-weight: 800;
                letter-spacing: 0.02em;
            }

            .panel-body {
                padding: 26px 22px 24px;
            }

            .already-registered-login,
            .register-form {
                background: transparent;
            }

            .register-form .form-group {
                margin-bottom: 18px;
            }

            .info-title {
                display: block;
                color: #374151;
                font-weight: 700;
                margin-bottom: 8px;
            }

            .form-control.unicase-form-control,
            .form-control {
                border-radius: 12px !important;
                border: 1px solid rgba(148, 163, 184, 0.45);
                height: 46px;
                padding: 12px 14px;
                box-shadow: none;
            }

            .form-control:focus {
                border-color: rgba(79, 70, 229, 0.8);
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
            }

            .btn-primary.checkout-page-button {
                background: linear-gradient(135deg, var(--shop-primary) 0%, var(--shop-primary-dark) 100%);
                border: 0;
                border-radius: 12px;
                color: #fff;
                font-weight: 700;
                padding: 12px 20px;
                box-shadow: 0 14px 28px rgba(79, 70, 229, 0.18);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .btn-primary.checkout-page-button:hover {
                transform: translateY(-2px);
                box-shadow: 0 18px 32px rgba(79, 70, 229, 0.22);
            }
        </style>
        <script type="text/javascript">
        function valid() {
            if(document.chngpwd.cpass.value==""){
                alert("Current Password is Empty !!");
                document.chngpwd.cpass.focus();
                return false;
            } else if(document.chngpwd.newpass.value==""){
                alert("New Password is Empty !!");
                document.chngpwd.newpass.focus();
                return false;
            } else if(document.chngpwd.cnfpass.value==""){
                alert("Confirm Password is Empty !!");
                document.chngpwd.cnfpass.focus();
                return false;
            } else if(document.chngpwd.newpass.value!= document.chngpwd.cnfpass.value){
                alert("Password and Confirm Password Field do not match !!");
                document.chngpwd.cnfpass.focus();
                return false;
            }
            return true;
        }
        </script>
    </head>
    <body class="cnt-home">
        <header class="header-style-1">
            <?php include('includes/top-header.php'); ?>
            <?php include('includes/main-header.php'); ?>
            <?php include('includes/menu-bar.php'); ?>
        </header>

        <div class="breadcrumb">
            <div class="container">
                <div class="breadcrumb-inner">
                    <ul class="list-inline list-unstyled">
                        <li><a href="index.php">Home</a></li>
                        <li class='active'>My Account</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="body-content outer-top-bd">
            <div class="container">
                <div class="checkout-box inner-bottom-sm">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="panel-group checkout-steps" id="accordion">
                                <div class="panel panel-default checkout-step-01">
                                    <div class="panel-heading">
                                        <h4 class="unicase-checkout-title">
                                            <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                                <span>1</span>My Profile
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse in">
                                        <div class="panel-body">
                                            <div class="row">
                                                <h4>Personal info</h4>
                                                <div class="col-md-12 col-sm-12 already-registered-login">
                                                    <form class="register-form" role="form" method="post">
                                                        <div class="form-group">
                                                            <label class="info-title" for="name">Name<span>*</span></label>
                                                            <input type="text" class="form-control unicase-form-control text-input" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>" id="name" name="name" required="required">
                                                        </div>

                                                        <div class="form-group">
                                                            <label class="info-title" for="exampleInputEmail1">Email Address <span>*</span></label>
                                                            <input type="email" class="form-control unicase-form-control text-input" id="exampleInputEmail1" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="info-title" for="contactno">Contact No. <span>*</span></label>
                                                            <input type="text" class="form-control unicase-form-control text-input" id="contactno" name="contactno" required="required" value="<?php echo htmlspecialchars($user['contactno'] ?? ''); ?>" maxlength="10">
                                                        </div>
                                                        <button type="submit" name="update" class="btn-upper btn btn-primary checkout-page-button">Update</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default checkout-step-02">
                                    <div class="panel-heading">
                                        <h4 class="unicase-checkout-title">
                                            <a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapseTwo">
                                                <span>2</span>Change Password
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            <form class="register-form" role="form" method="post" name="chngpwd" onSubmit="return valid();">
                                                <div class="form-group">
                                                    <label class="info-title" for="cpass">Current Password<span>*</span></label>
                                                    <input type="password" class="form-control unicase-form-control text-input" id="cpass" name="cpass" required="required">
                                                </div>

                                                <div class="form-group">
                                                    <label class="info-title" for="newpass">New Password <span>*</span></label>
                                                    <input type="password" class="form-control unicase-form-control text-input" id="newpass" name="newpass" required="required">
                                                </div>

                                                <div class="form-group">
                                                    <label class="info-title" for="cnfpass">Confirm New Password <span>*</span></label>
                                                    <input type="password" class="form-control unicase-form-control text-input" id="cnfpass" name="cnfpass" required="required">
                                                </div>
                                                <button type="submit" name="submit" class="btn-upper btn btn-primary checkout-page-button">Change</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include('includes/footer.php'); ?>
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>