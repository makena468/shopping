<?php
session_start();
global $con;
require_once __DIR__ . '/includes/config.php';
if (!isset($con) || !$con) {
    throw new RuntimeException('Database connection not initialized.');
}

if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
date_default_timezone_set('Asia/Kolkata');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin| Pending Orders</title>
	<link type="text/css" href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link type="text/css" href="css/theme.css" rel="stylesheet">
	<link type="text/css" href="images/icons/css/font-awesome.css" rel="stylesheet">
	<link type="text/css" href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600' rel='stylesheet'>
	<style>
		body {
			background: linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
		}
		.wrapper {
			padding: 24px 0 40px;
		}
		.content {
			background: transparent;
		}
		.module {
			background: #fff;
			border: 1px solid rgba(148,163,184,0.18);
			box-shadow: 0 12px 24px rgba(15,23,42,0.06);
			border-radius: 18px;
			overflow: hidden;
		}
		.module-head {
			background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
			padding: 18px 22px;
			border-bottom: none;
		}
		.module-head h3 {
			margin: 0;
			color: #fff;
			font-size: 1.7rem;
			font-weight: 700;
		}
		.module-body {
			padding: 22px;
		}
		.alert {
			border-radius: 12px;
			padding: 14px 16px;
			margin-bottom: 18px;
		}
		.modern-admin-table {
			width: 100%;
			border-collapse: separate;
			border-spacing: 0;
			background: #fff;
		}
		.modern-admin-table thead th {
			background: #eef2ff;
			color: #3730a3;
			font-size: 0.8rem;
			font-weight: 700;
			letter-spacing: 0.04em;
			text-transform: uppercase;
			padding: 0.9rem 0.8rem;
			border-bottom: 1px solid #dfe7ff;
		}
		.modern-admin-table tbody td {
			padding: 0.9rem 0.8rem;
			border-bottom: 1px solid #edf2f7;
			color: #334155;
			vertical-align: middle;
		}
		.modern-admin-table tbody tr:hover {
			background: #f8faff;
		}
		.btn-info {
			background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
			border: none;
			border-radius: 10px;
			padding: 0.55rem 1rem;
			font-weight: 600;
			color: #fff;
		}
		.btn-info:hover {
			background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
			color: #fff;
		}
	</style>
	<script language="javascript" type="text/javascript">
var popUpWin=0;
function popUpWindow(URLStr, left, top, width, height)
{
 if(popUpWin)
{
if(!popUpWin.closed) popUpWin.close();
}
popUpWin = open(URLStr,'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,copyhistory=yes,width='+600+',height='+600+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}

</script>
</head>
<body>
<?php include('include/header.php');?>

	<div class="wrapper">
		<div class="container">
			<div class="row">
<?php include('include/sidebar.php');?>				
			<div class="span9">
					<div class="content">

	<div class="module">
							<div class="module-head">
								<h3>Delivered Orders</h3>
							</div>
							<div class="module-body table">
	<?php if(isset($_GET['del']))
{?>
									<div class="alert alert-error">
										<button type="button" class="close" data-dismiss="alert">×</button>
									<strong>Oh snap!</strong> 	<?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?>
									</div>
<?php } ?>

									<br />

							
								<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display table-responsive modern-admin-table" >
								<thead>
									<tr>
										<th>#</th>
										<th> Name</th>
										<th width="50">Email /Contact no</th>
										<th>Product </th>
										<th>Order Date</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
<?php 
$st='Delivered';
$query=mysqli_query($con,"select users.name as username,users.email as useremail,users.contactno as usercontact,users.shippingAddress as shippingaddress,users.shippingCity as shippingcity,users.shippingState as shippingstate,users.shippingPincode as shippingpincode,products.productName as productname,products.shippingCharge as shippingcharge,orders.quantity as quantity,orders.orderDate as orderdate,products.productPrice as productprice,orders.id as id  from orders join users on  orders.userId=users.id join products on products.id=orders.productId where orders.orderStatus='$st'");
$cnt=1;
while($row=mysqli_fetch_array($query))
{
?>																																																																																														
									<tr>
										<td><?php echo htmlentities($cnt);?></td>
										<td><?php echo htmlentities($row['username']);?></td>
										<td><?php echo htmlentities($row['useremail']);?>/<?php echo htmlentities($row['usercontact']);?></td>
										<td><?php echo htmlentities($row['productname']);?></td>
										<td><?php echo htmlentities($row['orderdate']);?></td>
										<td><a href="order-details.php?orderid=<?php echo htmlentities($row['id']);?>" title="Order Details" target="_blank" class="btn btn-info">Details</a></td>
									</tr>

									<?php $cnt=$cnt+1; } ?>
								</tbody>
							</table>
							</div>
						</div>						

						
						
					</div><!--/.content-->
				</div><!--/.span9-->
			</div>
		</div><!--/.container-->
	</div><!--/.wrapper-->

<?php include('include/footer.php');?>

	<script src="scripts/jquery-1.9.1.min.js" type="text/javascript"></script>
	<script src="scripts/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
	<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="scripts/flot/jquery.flot.js" type="text/javascript"></script>
	<script src="scripts/datatables/jquery.dataTables.js"></script>
	<script>
		$(document).ready(function() {
			$('.datatable-1').dataTable();
			$('.dataTables_paginate').addClass("btn-group datatable-pagination");
			$('.dataTables_paginate > a').wrapInner('<span />');
			$('.dataTables_paginate > a:first-child').append('<i class="icon-chevron-left shaded"></i>');
			$('.dataTables_paginate > a:last-child').append('<i class="icon-chevron-right shaded"></i>');
		} );
	</script>
</body>
<?php } ?>