<?php 
session_start();
error_reporting(0);
global $con;
require_once __DIR__ . '/includes/config.php';
if (!isset($con) || !$con) {
    throw new RuntimeException('Database connection not initialized.');
}

$orderId = isset($_GET['orderid']) ? intval($_GET['orderid']) : (isset($_GET['oid']) ? intval($_GET['oid']) : 0);
$orderNumber = isset($_GET['onumber']) ? trim((string) $_GET['onumber']) : '';

if ($orderId <= 0 && $orderNumber === '') {
    $message = 'No order selected.';
} else {
    $sql = "SELECT o.*, u.name, u.email, u.contactno, u.shippingAddress, u.shippingCity, u.shippingState, u.shippingPincode, p.productName, p.productPrice, p.productImage1, p.id AS pid
            FROM orders o
            JOIN users u ON u.id = o.userId
            JOIN products p ON p.id = o.productId
            WHERE " . (($orderId > 0) ? "o.id = " . intval($orderId) : "o.orderNumber = '" . mysqli_real_escape_string($con, $orderNumber) . "'") . "
            LIMIT 1";
    $result = mysqli_query($con, $sql);
    $order = $result ? mysqli_fetch_assoc($result) : null;
    if (!$order) {
        $message = 'Order not found.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Order Details</title>
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        body { background: #f4f7fb; color: #1f2937; }
        .detail-card { max-width: 980px; margin: 40px auto; background: #fff; border-radius: 18px; border: 1px solid rgba(148,163,184,0.18); box-shadow: 0 12px 24px rgba(15,23,42,0.06); overflow: hidden; }
        .detail-header { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); color: #fff; padding: 22px 24px; font-size: 1.6rem; font-weight: 700; }
        .detail-body { padding: 24px; }
        table { width:100%; border-collapse: collapse; }
        th, td { padding: 12px 14px; border-bottom: 1px solid #edf2f7; text-align:left; vertical-align: top; }
        th { background:#eef2ff; color:#3730a3; width:22%; }
        .btn { display:inline-block; padding:10px 16px; border-radius:10px; background:#4f46e5; color:#fff; text-decoration:none; font-weight:700; }
        .muted { color:#64748b; }
    </style>
</head>
<body>
<?php include_once('includes/header.php'); ?>
<div class="detail-card">
    <div class="detail-header">Order Details</div>
    <div class="detail-body">
<?php if (!empty($message)) { ?>
        <p><?php echo htmlentities($message); ?></p>
        <p><a class="btn" href="my-orders.php">Back to My Orders</a></p>
<?php } else { ?>
        <table>
            <tr>
                <th>Order Number</th>
                <td><?php echo htmlentities($order['orderNumber']); ?></td>
                <th>Order Date</th>
                <td><?php echo htmlentities($order['orderDate']); ?></td>
            </tr>
            <tr>
                <th>Order Status</th>
                <td><?php echo htmlentities($order['orderStatus'] ?: 'Not Processed Yet'); ?></td>
                <th>Payment Method</th>
                <td><?php echo htmlentities($order['paymentMethod'] ?: 'N/A'); ?></td>
            </tr>
            <tr>
                <th>Customer</th>
                <td><?php echo htmlentities($order['name']); ?></td>
                <th>Contact</th>
                <td><?php echo htmlentities($order['email']); ?> / <?php echo htmlentities($order['contactno']); ?></td>
            </tr>
            <tr>
                <th>Shipping Address</th>
                <td><?php echo htmlentities(($order['shippingAddress'] ?? '') . ', ' . ($order['shippingCity'] ?? '') . ', ' . ($order['shippingState'] ?? '') . ' - ' . ($order['shippingPincode'] ?? '')); ?></td>
                <th>Product</th>
                <td><?php echo htmlentities($order['productName']); ?></td>
            </tr>
            <tr>
                <th>Quantity</th>
                <td><?php echo htmlentities($order['quantity']); ?></td>
                <th>Unit Price</th>
                <td><?php echo htmlentities($order['productPrice']); ?></td>
            </tr>
            <tr>
                <th>Transaction Type</th>
                <td><?php echo htmlentities($order['txnType'] ?: 'N/A'); ?></td>
                <th>Grand Total</th>
                <td><?php echo htmlentities($order['totalAmount'] ?: ($order['quantity'] * $order['productPrice'])); ?></td>
            </tr>
            <tr>
                <th>Product Image</th>
                <td colspan="3">
                    <?php if (!empty($order['productImage1'])) { ?>
                        <img src="admin/productimages/<?php echo urlencode($order['pid'] . '/' . $order['productImage1']); ?>" alt="Product image" width="120" />
                    <?php } else { ?>
                        <span class="muted">No image available</span>
                    <?php } ?>
                </td>
            </tr>
        </table>
        <p style="margin-top:20px;"><a class="btn" href="my-orders.php">Back to My Orders</a></p>
<?php } ?>
    </div>
</div>
<?php include_once('includes/footer.php'); ?>
</body>
</html>