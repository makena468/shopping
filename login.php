<?php
session_start();
global $con;
require_once __DIR__ . '/includes/config.php';
if (!isset($con) || !$con) {
    throw new RuntimeException('Database connection not initialized.');
}

function loginPasswordIsValid($storedHash, $inputPassword) {
    return passwordMatches($storedHash, $inputPassword);
}

if (isset($_POST['submit'])) {
    $name = trim($_POST['fullname'] ?? '');
    $email = trim($_POST['emailid'] ?? '');
    $contactno = trim($_POST['contactno'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name === '' || $email === '' || $contactno === '' || $password === '') {
        $_SESSION['errmsg'] = 'All fields are required.';
    } else {
        $stmt = $con->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $_SESSION['errmsg'] = 'Email already registered.';
        } else {
            $hashed = hashPassword($password);
            $insert = $con->prepare('INSERT INTO users (name, email, contactno, password) VALUES (?, ?, ?, ?)');
            $insert->bind_param('ssss', $name, $email, $contactno, $hashed);
            if ($insert->execute()) {
                $_SESSION['successmsg'] = 'Registration successful. Please login.';
                header('Location: login.php');
                exit();
            } else {
                $_SESSION['errmsg'] = 'Registration failed. Please try again.';
            }
            $insert->close();
        }
        $stmt->close();
    }
}

if (isset($_POST['login'])) {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $_SESSION['errmsg'] = 'Please enter your email and password.';
        header('Location: login.php');
        exit();
    }

    $stmt = $con->prepare('SELECT id, name, password FROM users WHERE email = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && loginPasswordIsValid($user['password'], $password)) {
        $_SESSION['login'] = $email;
        $_SESSION['id'] = (int) $user['id'];
        $_SESSION['username'] = $user['name'];

        $uip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $log = $con->prepare('INSERT INTO userlog (userEmail, userip, status) VALUES (?, ?, 1)');
        $log->bind_param('ss', $email, $uip);
        $log->execute();
        $log->close();

        if (strpos((string) $user['password'], '$2') !== 0 && md5($password) === $user['password']) {
            $newHash = hashPassword($password);
            $update = $con->prepare('UPDATE users SET password = ? WHERE id = ?');
            $update->bind_param('si', $newHash, $_SESSION['id']);
            $update->execute();
            $update->close();
        }

        header('Location: my-account.php');
        exit();
    }

    $_SESSION['errmsg'] = 'Invalid email or password';
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Login | Shopping</title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/css/main.css" />
        <link rel="stylesheet" href="assets/css/font-awesome.min.css" />
        <link rel="shortcut icon" href="assets/images/favicon.ico" />
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

            .sign-in-page {
                padding-top: 18px;
            }

            .sign-in, .create-new-account {
                background: rgba(255, 255, 255, 0.90);
                border: 1px solid var(--shop-border);
                border-radius: 22px;
                box-shadow: var(--shop-shadow);
                padding: 30px 28px;
            }

            .checkout-subtitle {
                color: var(--shop-primary-dark);
                font-size: 28px;
                font-weight: 800;
                margin-bottom: 22px;
                letter-spacing: 0.02em;
            }

            .register-form .form-group {
                margin-bottom: 18px;
            }

            .register-form .info-title {
                display: block;
                color: #374151;
                font-weight: 700;
                margin-bottom: 8px;
            }

            .register-form .form-control,
            .register-form .unicase-form-control {
                border-radius: 12px !important;
                border: 1px solid rgba(148, 163, 184, 0.45);
                box-shadow: none;
                padding: 12px 14px;
                height: 46px;
                transition: all 0.2s ease;
            }

            .register-form .form-control:focus {
                border-color: rgba(79, 70, 229, 0.8);
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
            }

            .btn-primary.checkout-page-button {
                background: linear-gradient(135deg, var(--shop-primary) 0%, var(--shop-primary-dark) 100%);
                border: 0;
                border-radius: 12px;
                color: #fff;
                font-weight: 700;
                padding: 12px 22px;
                box-shadow: 0 14px 28px rgba(79, 70, 229, 0.18);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
            }

            .btn-primary.checkout-page-button:hover {
                transform: translateY(-2px);
                box-shadow: 0 18px 32px rgba(79, 70, 229, 0.22);
            }

            .alert {
                border-radius: 12px;
                border: 0;
                padding: 12px 14px;
                margin-bottom: 18px;
                font-weight: 600;
            }

            .alert-danger {
                background: rgba(239, 68, 68, 0.08);
                color: #991b1b;
            }

            .alert-success {
                background: rgba(16, 185, 129, 0.08);
                color: #065f46;
            }

            @media (max-width: 767px) {
                .sign-in, .create-new-account {
                    margin-bottom: 24px;
                }
            }
        </style>
    </head>
    <body class="cnt-home">
        <?php include('includes/top-header.php'); ?>
        <?php include('includes/main-header.php'); ?>
        <?php include('includes/menu-bar.php'); ?>

        <div class="breadcrumb">
            <div class="container">
                <div class="breadcrumb-inner">
                    <ul class="list-inline list-unstyled">
                        <li><a href="index.php">Home</a></li>
                        <li class='active'>Login / Register</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="body-content outer-top-bd">
            <div class="container">
                <div class="sign-in-page inner-bottom-sm">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 sign-in">
                            <h4 class="checkout-subtitle">Sign in</h4>
                            <?php if (!empty($_SESSION['errmsg'])): ?>
                                <div class="alert alert-danger"><?php echo htmlspecialchars($_SESSION['errmsg']); unset($_SESSION['errmsg']); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($_SESSION['successmsg'])): ?>
                                <div class="alert alert-success"><?php echo htmlspecialchars($_SESSION['successmsg']); unset($_SESSION['successmsg']); ?></div>
                            <?php endif; ?>

                            <form class="register-form" method="post">
                                <div class="form-group">
                                    <label class="info-title" for="email">Email Address <span>*</span></label>
                                    <input type="email" class="form-control unicase-form-control text-input" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label class="info-title" for="password">Password <span>*</span></label>
                                    <input type="password" class="form-control unicase-form-control text-input" id="password" name="password" required>
                                </div>
                                <button type="submit" name="login" class="btn-upper btn btn-primary checkout-page-button">Login</button>
                            </form>
                        </div>

                        <div class="col-md-6 col-sm-6 create-new-account">
                            <h4 class="checkout-subtitle">Create a new account</h4>
                            <form class="register-form" method="post">
                                <div class="form-group">
                                    <label class="info-title" for="fullname">Full Name <span>*</span></label>
                                    <input type="text" class="form-control unicase-form-control text-input" id="fullname" name="fullname" required>
                                </div>
                                <div class="form-group">
                                    <label class="info-title" for="emailid">Email Address <span>*</span></label>
                                    <input type="email" class="form-control unicase-form-control text-input" id="emailid" name="emailid" required>
                                </div>
                                <div class="form-group">
                                    <label class="info-title" for="contactno">Contact Number <span>*</span></label>
                                    <input type="text" class="form-control unicase-form-control text-input" id="contactno" name="contactno" pattern="[0-9]{10}" title="10 numeric characters only" required>
                                </div>
                                <div class="form-group">
                                    <label class="info-title" for="newpassword">Password <span>*</span></label>
                                    <input type="password" class="form-control unicase-form-control text-input" id="newpassword" name="password" required>
                                </div>
                                <button type="submit" name="submit" class="btn-upper btn btn-primary checkout-page-button">Create Account</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include('includes/footer.php'); ?>
    </body>
</html>
