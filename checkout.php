<?php
session_start();
include('includes/config.php');

// Security headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");

if (!isset($_SESSION['login'])) {
    header('location: login.php');
    exit();
}

// Remove error_reporting(0)
// ini_set('display_errors', 0);

// Basic CSRF token
default_csrf();

function default_csrf() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

if (isset($_POST['submit'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('CSRF token validation failed');
    }

    $address = trim($_POST['billingaddress'] ?? '');
    $billing = trim($_POST['bilingstate'] ?? ''); // note: typo in original
    $city = trim($_POST['billingcity'] ?? '');
    $pincode = trim($_POST['billingpincode'] ?? '');

    if (empty($address) || empty($city)) {
        echo "<script>alert('Please fill all required fields');</script>";
    } else {
        $id = intval($_SESSION['id']);
        $stmt = $con->prepare("UPDATE users SET billingAddress=?, billingState=?, billingCity=?, billingPincode=? WHERE id=?");
        $stmt->bind_param("ssssi", $address, $billing, $city, $pincode, $id);
        $stmt->execute();

        // Insert order with prepared statements
        $order_status = 'in Process';
        $stmt2 = $con->prepare("INSERT INTO orders (userId, address, city, pincode, orderStatus) VALUES (?, ?, ?, ?, ?)");
        $stmt2->bind_param("issss", $id, $address, $city, $pincode, $order_status);
        if ($stmt2->execute()) {
            $order_id = $con->insert_id;
            // Process cart items...
            echo "<script>alert('Order placed successfully! Order ID: $order_id');</script>";
            unset($_SESSION['cart']);
            header("location: order-history.php");
            exit();
        }
    }
}
?>

<!-- HTML form part with CSRF -->
<form method="post">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    <!-- existing form fields -->
</form>