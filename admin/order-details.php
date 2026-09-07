<?php
session_start();
require_once __DIR__ . '/includes/config.php';
if(strlen($_SESSION["aid"])==0) {
	header('location:logout.php');
	exit;
}

$orderid = isset($_GET['orderid']) ? intval($_GET['orderid']) : 0;
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<title>Shopping | Order Details</title>
		<link href="css/styles.css" rel="stylesheet" />
		<style>
			/* keep existing admin styles compact */
			.modern-detail-table { width:100%; border-collapse: collapse; background:#fff; }
			.modern-detail-table th { background:#eef2ff; color:#3730a3; padding:0.8rem; text-align:left; width:25%; }
			.modern-detail-table td { padding:0.8rem; border-bottom:1px solid #edf2f7; }
			.order-history-table { width:100%; border-collapse: collapse; margin-top:1rem; }
			.order-history-table th, .order-history-table td { padding:0.6rem; border-bottom:1px solid #edf2f7; }
			.btn-primary { background:linear-gradient(135deg,#4f46e5 0%,#7c3aed 100%); color:#fff; padding:0.6rem 1rem; border-radius:8px; text-decoration:none; }
		</style>
	</head>
	<body class="sb-nav-fixed">
<?php include_once('includes/header.php'); ?>
		<div id="layoutSidenav">
<?php include_once('includes/sidebar.php'); ?>
			<div id="layoutSidenav_content">
				<main>
					<div class="container-fluid px-4">
						<h1 class="mt-4">Order Details</h1>
						<ol class="breadcrumb mb-4">
							<li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
							<li class="breadcrumb-item active">Order Details</li>
						</ol>

						<div class="card mb-4">
							<div class="card-header">Order #<?php echo htmlentities($orderid);?></div>
							<div class="card-body">
<?php if ($orderid <= 0) { ?>
								<p>Invalid order id. <a href="all-orders.php">Back to orders</a></p>
<?php } else {
	$sql = "SELECT orders.id as oid, orders.orderNumber, orders.orderDate, orders.orderStatus, orders.totalAmount, users.name as username, users.email as useremail, users.contactno as usercontact, users.shippingAddress, users.shippingCity, users.shippingState, users.shippingPincode, users.billingAddress, users.billingCity, users.billingState, users.billingPincode, products.productName as productname, products.productPrice as productprice, products.shippingCharge as shippingcharge, orders.quantity, products.id as pid, products.productImage1 FROM orders JOIN users ON orders.userId=users.id JOIN products ON products.id=orders.productId WHERE orders.id='".intval($orderid)."' LIMIT 1";
	$res = mysqli_query($con, $sql);
	$row = $res ? mysqli_fetch_assoc($res) : false;
	if (!$row) { ?>
								<p>Order not found. <a href="all-orders.php">Back to orders</a></p>
	<?php } else {
?>
								<table class="modern-detail-table">
									<tbody>
										<tr>
											<th>Order Id</th>
											<td><?php echo htmlentities($row['oid']);?></td>
											<th>Order Date</th>
											<td><?php echo htmlentities($row['orderDate']);?></td>
										</tr>
										<tr>
											<th>Username</th>
											<td><?php echo htmlentities($row['username']);?></td>
											<th>Contact</th>
											<td><?php echo htmlentities($row['useremail']);?> / <?php echo htmlentities($row['usercontact']);?></td>
										</tr>
										<tr>
											<th>Billing Address</th>
											<td><?php echo htmlentities(($row['billingAddress'] ?? '') . ', ' . ($row['billingCity'] ?? '') . ', ' . ($row['billingState'] ?? '') . ' - ' . ($row['billingPincode'] ?? ''));?></td>
											<th>Shipping Address</th>
											<td><?php echo htmlentities(($row['shippingAddress'] ?? '') . ', ' . ($row['shippingCity'] ?? '') . ', ' . ($row['shippingState'] ?? '') . ' - ' . ($row['shippingPincode'] ?? ''));?></td>
										</tr>
										<tr>
											<th>Product</th>
											<td><?php echo htmlentities($row['productname']);?></td>
											<th>Image</th>
											<td><img src="productimages/<?php echo htmlentities($row['pid'] . '/' . $row['productImage1']); ?>" width="100" alt=""></td>
										</tr>
										<tr>
											<th>Quantity</th>
											<td><?php echo htmlentities($row['quantity']);?></td>
											<th>Price</th>
											<td><?php echo htmlentities($row['productprice']);?></td>
										</tr>
										<tr>
											<th>Shipping Charge</th>
											<td><?php echo htmlentities($row['shippingcharge']);?></td>
											<th>Grand Total</th>
											<td><?php echo htmlentities((float)$row['quantity'] * (float)$row['productprice'] + (float)$row['shippingcharge']);?></td>
										</tr>
									</tbody>
								</table>

								<?php
								// Order history
								$ret = mysqli_query($con, "SELECT * FROM ordertrackhistory WHERE orderId='" . intval($orderid) . "' ORDER BY postingDate DESC");
								$count = $ret ? mysqli_num_rows($ret) : 0;
								if ($count > 0) {
								?>
								<table class="order-history-table">
									<tr><th colspan="3">Order History</th></tr>
									<tr><th>Remark</th><th>Status</th><th>Date</th></tr>
									<?php while ($h = mysqli_fetch_assoc($ret)) { ?>
										<tr>
											<td><?php echo htmlentities($h['remark']);?></td>
											<td><?php echo htmlentities($h['status']);?></td>
											<td><?php echo htmlentities($h['postingDate']);?></td>
										</tr>
									<?php } ?>
								</table>
								<?php } ?>

								<p style="margin-top:1rem;"><a href="updateorder.php?oid=<?php echo urlencode($orderid);?>" class="btn-primary" target="_blank">Take Action</a></p>
	<?php }
} ?>
							</div>
						</div>
					</div>
				</main>
<?php include_once('includes/footer.php'); ?>
			</div>
		</div>
		<script src="js/bootstrap.bundle.min.js"></script>
		<script src="js/scripts.js"></script>
	</body>
</html>