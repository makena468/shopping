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

if(isset($_GET['del']))
		  {
		          mysqli_query($con,"delete from products where id = '".$_GET['id']."'");
                  $_SESSION['delmsg']="Product deleted !!";
		  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin| Manage Products</title>
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
			border: 1px solid rgba(148, 163, 184, 0.18);
			box-shadow: 0 12px 24px rgba(15, 23, 42, 0.06);
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
		.table-actions {
			display: flex;
			align-items: center;
			gap: 0.5rem;
		}
		.action-link {
			display: inline-flex;
			align-items: center;
			justify-content: center;
			width: 36px;
			height: 36px;
			border-radius: 10px;
			background: #eef2ff;
			color: #4338ca;
			transition: 0.2s ease;
		}
		.action-link:hover {
			background: #dfe7ff;
			color: #312e81;
			text-decoration: none;
		}
		.action-link.delete {
			background: #fef2f2;
			color: #dc2626;
		}
		.action-link.delete:hover {
			background: #fee2e2;
			color: #b91c1c;
		}
	</style>
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
								<h3>Manage Products</h3>
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

							
								<table cellpadding="0" cellspacing="0" border="0" class="datatable-1 table table-bordered table-striped display modern-admin-table" width="100%">
									<thead>
										<tr>
											<th>#</th>
											<th>Product Name</th>
											<th>Category </th>
											<th>Subcategory</th>
											<th>Company Name</th>
											<th>Product Creation Date</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>

<?php $query=mysqli_query($con,"select products.*,category.categoryName,subcategory.subcategory from products join category on category.id=products.category join subcategory on subcategory.id=products.subCategory");
$cnt=1;
while($row=mysqli_fetch_array($query))
{
?>																																																																																																	
										<tr>
											<td><?php echo htmlentities($cnt);?></td>
											<td><?php echo htmlentities($row['productName']);?></td>
											<td><?php echo htmlentities($row['categoryName']);?></td>
											<td> <?php echo htmlentities($row['subcategory']);?></td>
											<td><?php echo htmlentities($row['productCompany']);?></td>
											<td><?php echo htmlentities($row['postingDate']);?></td>
											<td>
												<div class="table-actions">
													<a href="edit-products.php?id=<?php echo $row['id']?>" class="action-link" title="Edit product"><i class="icon-edit"></i></a>
													<a href="manage-products.php?id=<?php echo $row['id']?>&del=delete" class="action-link delete" onClick="return confirm('Are you sure you want to delete?')" title="Delete product"><i class="icon-remove-sign"></i></a>
												</div>
											</td>
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