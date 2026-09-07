<?php session_start();
global $con;
require_once __DIR__ . '/includes/config.php';
if (!isset($con) || !$con) {
    throw new RuntimeException('Database connection not initialized.');
}

if(strlen($_SESSION['id'])==0)
{   header('location:logout.php');
}else{
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shopping | My Orders</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <script src="js/jquery.min.js"></script>
        <style>
            :root {
                --shop-primary: #4f46e5;
                --shop-primary-dark: #312e81;
                --shop-bg: #f3f6ff;
                --shop-border: rgba(79, 70, 229, 0.12);
                --shop-shadow: 0 18px 40px rgba(17, 24, 39, 0.10);
            }

            body {
                background: linear-gradient(180deg, #f8faff 0%, #eef4ff 100%);
                color: #1f2937;
            }

            header.bg-dark {
                background: linear-gradient(135deg, #111827 0%, #1f2937 100%) !important;
            }

            .table-responsive {
                background: rgba(255, 255, 255, 0.92);
                border: 1px solid var(--shop-border);
                border-radius: 22px;
                box-shadow: var(--shop-shadow);
                padding: 16px;
            }

            .table {
                margin-bottom: 0;
                border-collapse: separate;
                border-spacing: 0;
            }

            .table th {
                background: linear-gradient(135deg, #eef2ff, #f8fafc);
                color: var(--shop-primary-dark);
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.04em;
                padding: 16px 12px;
            }

            .table td {
                vertical-align: middle;
                padding: 15px 12px;
            }

            .btn-primary,
            .btn-warning {
                border-radius: 12px !important;
                padding: 10px 16px;
                font-weight: 700;
                border: 0;
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--shop-primary) 0%, var(--shop-primary-dark) 100%);
                box-shadow: 0 14px 28px rgba(79, 70, 229, 0.18);
            }

            .btn-warning {
                background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
                color: #fff;
            }
        </style>
    </head>
    <body>
<?php include_once('includes/header.php');?>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">


                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">My Orders</h1>
                </div>

            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4  mt-5">
     

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th colspan="4"><h4>My Orders</h4></th>
                </tr>
            </thead>
            <tr>
                <thead>
                    <th>#</th>
                    <th>Order Number </th>
                    <th>Order Date</th>
                    <th>Transaction Type</th>
                    <th>Total Amount</th>
                    <th>Order Status</th>
                    <th>Action</th>
                </thead>
            </tr>
            <tbody>
<?php
$uid=$_SESSION['id'];
$ret=mysqli_query($con,"select * from orders where userId='$uid'");
$num=mysqli_num_rows($ret);
$cnt=1;
    if($num>0)
    {
while ($row=mysqli_fetch_array($ret)) {

?>

                <tr>
                    <td><?php echo htmlentities($cnt);?></td>
                    <td><?php echo htmlentities($row['orderNumber']);?></td>
                    <td><?php echo htmlentities($row['orderDate']);?></td>
                    <td><?php echo htmlentities($row['txnType']);?></td>
                    <td><?php echo htmlentities($row['totalAmount']);?></td>
                    <td><?php $ostatus=$row['orderStatus'];
                    if( $ostatus==''): echo "Not Processed Yet";
                        else: echo $ostatus; endif;?><br />
                    </td>
                    <td><a href="order-details.php?orderid=<?php echo htmlentities($row['id']);?>" class="btn-upper btn btn-primary">Details</a></td>
                
                </tr>
            
                <?php $cnt++;}  } else{ ?>
                <tr>
                    <td style="font-size: 18px; font-weight:bold ">Not Order Yet.&nbsp;
<a href="shop-categories.php" class="btn-upper btn btn-warning">Continue Shopping</a>
                    </td>

                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
              
            </div>

 
</div>
        </section>

        
        <!-- Footer-->
   <?php include_once('includes/footer.php'); ?>
        <!-- Bootstrap core JS-->
        <script src="js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
<?php } ?>
