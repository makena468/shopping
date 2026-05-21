<?php 
session_start();
// error_reporting(0); // Removed for security
include('includes/config.php');

// Update cart quantities
if(isset($_POST['submit'])){
	if(!empty($_SESSION['cart'])){
		foreach($_POST['quantity'] as $key => $val){
			$val = intval($val);
			if($val==0){
				unset($_SESSION['cart'][$key]);
			}else{
				$_SESSION['cart'][$key]['quantity']=$val;
			}
		}
		echo "<script>alert('Your Cart has been Updated');</script>";
	}
}

// Remove product from cart
if(isset($_POST['remove_code']))
{
	if(!empty($_SESSION['cart'])){
		foreach($_POST['remove_code'] as $key){
			unset($_SESSION['cart'][$key]);
		}
		echo "<script>alert('Your Cart has been Updated');</script>";
	}
}

// Place order
if(isset($_POST['ordersubmit'])) 
{
	if(strlen($_SESSION['login'] ?? '') == 0)
    {   
		header('location:login.php');
		exit();
	}
	else{
		$quantity = $_POST['quantity'] ?? [];
		$pdd = $_SESSION['pid'] ?? [];
		$value = array_combine($pdd, $quantity);

		foreach($value as $qty => $val34){
			$qty = intval($qty);
			$val34 = intval($val34);
			$stmt = $con->prepare("INSERT INTO orders(userId, productId, quantity) VALUES(?, ?, ?)");
			$stmt->bind_param("iii", $_SESSION['id'], $qty, $val34);
			$stmt->execute();
		}
		header('location:payment-method.php');
		exit();
	}
}

// Update billing address
if(isset($_POST['update']))
{
	$baddress = trim($_POST['billingaddress'] ?? '');
	$bstate = trim($_POST['bilingstate'] ?? '');
	$bcity = trim($_POST['billingcity'] ?? '');
	$bpincode = trim($_POST['billingpincode'] ?? '');
	
	$stmt = $con->prepare("UPDATE users SET billingAddress=?, billingState=?, billingCity=?, billingPincode=? WHERE id=?");
	$stmt->bind_param("ssssi", $baddress, $bstate, $bcity, $bpincode, $_SESSION['id']);
	if($stmt->execute()){
		echo "<script>alert('Billing Address has been updated');</script>";
	}
}

// Update shipping address
if(isset($_POST['shipupdate']))
{
	$saddress = trim($_POST['shippingaddress'] ?? '');
	$sstate = trim($_POST['shippingstate'] ?? '');
	$scity = trim($_POST['shippingcity'] ?? '');
	$spincode = trim($_POST['shippingpincode'] ?? '');
	
	$stmt = $con->prepare("UPDATE users SET shippingAddress=?, shippingState=?, shippingCity=?, shippingPincode=? WHERE id=?");
	$stmt->bind_param("ssssi", $saddress, $sstate, $scity, $spincode, $_SESSION['id']);
	if($stmt->execute()){
		echo "<script>alert('Shipping Address has been updated');</script>";
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- ... (keep your existing head, I shortened for brevity) -->
	<title>My Cart</title>
	<!-- Include your CSS links -->
</head>
<body class="cnt-home">
	<!-- Header -->
	<?php include('includes/top-header.php');?>
	<?php include('includes/main-header.php');?>
	<?php include('includes/menu-bar.php');?>

	<!-- Rest of your HTML remains mostly the same, but escaped outputs -->
	<!-- ... -->
</body>
</html>