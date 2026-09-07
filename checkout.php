<?php
session_start();
global $con;
require_once __DIR__ . '/includes/config.php';
if (!isset($con) || !$con) {
    throw new RuntimeException('Database connection not initialized.');
}

// Security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");

if (!isset($_SESSION['login'])) {
    header('location: login.php');
    exit();
}

if (empty($_SESSION['cart'])) {
    header('Location: my-cart.php');
    exit();
}

$cartTotal = 0;
foreach ($_SESSION['cart'] as $productId => $details) {
    $productId = intval($productId);
    $stmt = $con->prepare('SELECT productPrice, shippingCharge FROM products WHERE id = ? LIMIT 1');
    $stmt->bind_param('i', $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();

    if ($product) {
        $quantity = max(1, intval($details['quantity']));
        $cartTotal += ((float) $product['productPrice'] + (float) $product['shippingCharge']) * $quantity;
    }
}

if (isset($_POST['placeorder'])) {
    $billingAddress = trim($_POST['billingaddress'] ?? '');
    $billingState = trim($_POST['bilingstate'] ?? '');
    $billingCity = trim($_POST['billingcity'] ?? '');
    $billingPincode = trim($_POST['billingpincode'] ?? '');
    $shippingAddress = trim($_POST['shippingaddress'] ?? '');
    $shippingState = trim($_POST['shippingstate'] ?? '');
    $shippingCity = trim($_POST['shippingcity'] ?? '');
    $shippingPincode = trim($_POST['shippingpincode'] ?? '');

    if ($billingAddress === '' || $billingState === '' || $billingCity === '' || $billingPincode === '' || $shippingAddress === '' || $shippingState === '' || $shippingCity === '' || $shippingPincode === '') {
        echo "<script>alert('Please fill in all billing and shipping address fields.');</script>";
    } else {
        $stmt = $con->prepare('UPDATE users SET billingAddress = ?, billingState = ?, billingCity = ?, billingPincode = ?, shippingAddress = ?, shippingState = ?, shippingCity = ?, shippingPincode = ? WHERE id = ?');
        $stmt->bind_param('ssssssssi', $billingAddress, $billingState, $billingCity, $billingPincode, $shippingAddress, $shippingState, $shippingCity, $shippingPincode, $_SESSION['id']);
        $stmt->execute();
        $stmt->close();

        foreach ($_SESSION['cart'] as $productId => $details) {
            $productId = intval($productId);
            $quantity = max(1, intval($details['quantity']));
            $orderStmt = $con->prepare('INSERT INTO orders (userId, productId, quantity, orderStatus, paymentMethod, orderDate) VALUES (?, ?, ?, "Pending", NULL, NOW())');
            $orderStmt->bind_param('iii', $_SESSION['id'], $productId, $quantity);
            $orderStmt->execute();
            $orderStmt->close();
        }

        $_SESSION['checkout_total'] = $cartTotal;
        header('Location: payment-method.php');
        exit();
    }
}

$userStmt = $con->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
$userStmt->bind_param('i', $_SESSION['id']);
$userStmt->execute();
$user = $userStmt->get_result()->fetch_assoc();
$userStmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <style>
        :root {
            --shop-primary: #4f46e5;
            --shop-primary-dark: #312e81;
            --shop-bg: #f3f6ff;
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
            padding-top: 16px;
        }

        .register-form {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid var(--shop-border);
            border-radius: 24px;
            box-shadow: var(--shop-shadow);
            padding: 28px 24px;
        }

        .register-form h4 {
            color: var(--shop-primary-dark);
            font-weight: 800;
            margin-bottom: 20px;
        }

        .register-form label {
            display: block;
            color: #374151;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .form-control,
        textarea.form-control {
            border-radius: 12px !important;
            border: 1px solid rgba(148, 163, 184, 0.45);
            box-shadow: none;
            min-height: 46px;
            padding: 12px 14px;
        }

        .form-control:focus,
        textarea.form-control:focus {
            border-color: rgba(79, 70, 229, 0.8);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
        }

        .btn-primary,
        .btn-lg {
            background: linear-gradient(135deg, var(--shop-primary) 0%, var(--shop-primary-dark) 100%);
            border: 0;
            border-radius: 12px;
            color: white;
            padding: 12px 22px;
            font-weight: 700;
            box-shadow: 0 14px 28px rgba(79, 70, 229, 0.18);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
        }

        .text-right h4 {
            margin-bottom: 18px;
            font-weight: 800;
            color: var(--shop-primary-dark);
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
                    <li class='active'>Checkout</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="body-content outer-top-bd">
        <div class="container">
            <div class="checkout-box inner-bottom-sm">
                <div class="row">
                    <div class="col-md-12">
                        <form method="post" class="register-form">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Billing Address</h4>
                                    <div class="form-group">
                                        <label>Billing Address <span>*</span></label>
                                        <textarea class="form-control" name="billingaddress" required><?php echo htmlspecialchars($user['billingAddress'] ?? ''); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Billing State <span>*</span></label>
                                        <input type="text" class="form-control" name="bilingstate" value="<?php echo htmlspecialchars($user['billingState'] ?? ''); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Billing City <span>*</span></label>
                                        <input type="text" class="form-control" name="billingcity" value="<?php echo htmlspecialchars($user['billingCity'] ?? ''); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Billing Pincode <span>*</span></label>
                                        <input type="text" class="form-control" name="billingpincode" value="<?php echo htmlspecialchars($user['billingPincode'] ?? ''); ?>" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h4>Shipping Address</h4>
                                    <div class="form-group">
                                        <label>Shipping Address <span>*</span></label>
                                        <textarea class="form-control" name="shippingaddress" required><?php echo htmlspecialchars($user['shippingAddress'] ?? ''); ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Shipping State <span>*</span></label>
                                        <input type="text" class="form-control" name="shippingstate" value="<?php echo htmlspecialchars($user['shippingState'] ?? ''); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Shipping City <span>*</span></label>
                                        <input type="text" class="form-control" name="shippingcity" value="<?php echo htmlspecialchars($user['shippingCity'] ?? ''); ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Shipping Pincode <span>*</span></label>
                                        <input type="text" class="form-control" name="shippingpincode" value="<?php echo htmlspecialchars($user['shippingPincode'] ?? ''); ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="margin-top:20px;">
                                <div class="col-md-12 text-right">
                                    <h4>Total: Ksh. <?php echo number_format($cartTotal, 2); ?></h4>
                                    <button type="submit" name="placeorder" class="btn btn-primary btn-lg">Continue to Payment</button>
                                </div>
                            </div>
                        </form>
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