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


if(isset($_POST['submit']))
{
	$category=$_POST['category'];
	$description=$_POST['description'];
	$id=intval($_GET['id']);
$sql=mysqli_query($con,"update category set categoryName='$category',categoryDescription='$description',updationDate='$currentTime' where id='$id'");
$_SESSION['msg']="Category Updated !!";

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin| Category</title>
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
		.form-horizontal .control-group {
			margin-bottom: 18px;
		}
		.control-label {
			font-weight: 600;
			color: #334155;
		}
		.input-xlarge,
		textarea,
		input[type="text"] {
			background: #f8fafc;
			border: 1px solid #dfe7f1;
			border-radius: 12px;
			padding: 12px 14px;
			color: #0f172a;
			box-shadow: none;
		}
		input[type="text"]:focus,
		textarea:focus {
			background: #fff;
			border-color: #a5b4fc;
			box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.12);
		}
		textarea {
			min-height: 120px;
			resize: vertical;
		}
		.btn {
			background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
			border: none;
			border-radius: 12px;
			padding: 10px 22px;
			font-weight: 700;
			color: #fff;
			box-shadow: 0 12px 20px rgba(79,70,229,0.22);
		}
		.btn:hover {
			background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
			color: #fff;
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
								<h3>Category</h3>
							</div>
							<div class="module-body">

									<?php if(isset($_POST['submit']))
{?>
									<div class="alert alert-success">
										<button type="button" class="close" data-dismiss="alert">×</button>
									<strong>Well done!</strong>	<?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
									</div>
<?php } ?>


									<br />

			<form class="form-horizontal row-fluid" name="Category" method="post" >
<?php
$id=intval($_GET['id']);
$query=mysqli_query($con,"select * from category where id='$id'");
while($row=mysqli_fetch_array($query))
{
?>																																																																																																													
<div class="control-group">
<label class="control-label" for="basicinput">Category Name</label>
<div class="controls">
<input type="text" placeholder="Enter category Name"  name="category" value="<?php echo  htmlentities($row['categoryName']);?>" class="span8 tip input-xlarge" required>
</div>
</div>


<div class="control-group">
														<label class="control-label" for="basicinput">Description</label>
														<div class="controls">
															<textarea class="span8" name="description" rows="5"><?php echo  htmlentities($row['categoryDescription']);?></textarea>
														</div>
													</div>
												<?php } ?>	

	<div class="control-group">
														<div class="controls">
															<button type="submit" name="submit" class="btn">Update</button>
														</div>
													</div>
											</form>
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