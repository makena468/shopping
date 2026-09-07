<?php session_start();
error_reporting(0);
global $con;
require_once __DIR__ . '/includes/config.php';
if (!isset($con) || !$con) {
    throw new RuntimeException('Database connection not initialized.');
}

if(strlen( $_SESSION["aid"])==0)
{   
header('location:logout.php');
} else {


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shopping Portal | Between Dates Sales Report</title>
        <link href="css/styles.css" rel="stylesheet" />
        <style>
            body {
                background: linear-gradient(180deg, #f8fafc 0%, #eef2ff 100%);
            }
            .container-fluid.px-4 {
                padding-top: 1.5rem;
            }
            .page-header {
                margin-bottom: 1.5rem;
            }
            .page-header h1 {
                font-size: 2.1rem;
                font-weight: 700;
                color: #1f2937;
                margin-bottom: 0.5rem;
            }
            .breadcrumb {
                background: rgba(255,255,255,0.72);
                border: 1px solid rgba(148,163,184,0.18);
                border-radius: 12px;
                padding: 0.7rem 1rem;
                box-shadow: 0 8px 20px rgba(15,23,42,0.04);
            }
            .card {
                background: #fff;
                border: 1px solid rgba(148,163,184,0.18);
                box-shadow: 0 12px 24px rgba(15,23,42,0.06);
                border-radius: 18px;
                overflow: hidden;
            }
            .card-body {
                padding: 1.5rem;
            }
            .form-section {
                display: grid;
                gap: 1.2rem;
            }
            .form-row {
                display: grid;
                grid-template-columns: minmax(160px, 220px) minmax(0, 1fr);
                align-items: center;
                gap: 1rem;
            }
            .form-label {
                font-size: 0.92rem;
                font-weight: 600;
                color: #334155;
            }
            .form-control {
                background: #f8fafc;
                border: 1px solid #dfe7f1;
                border-radius: 12px;
                min-height: 45px;
                padding: 0.75rem 0.9rem;
                color: #0f172a;
                box-shadow: none;
            }
            .form-control:focus {
                background: #fff;
                border-color: #a5b4fc;
                box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.12);
            }
            .btn-primary {
                background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
                border: none;
                border-radius: 12px;
                padding: 0.8rem 1.5rem;
                font-weight: 700;
                box-shadow: 0 12px 20px rgba(79,70,229,0.22);
            }
            .btn-primary:hover {
                background: linear-gradient(135deg, #4338ca 0%, #6d28d9 100%);
            }
            .report-title {
                color: #3730a3;
                font-weight: 700;
                margin: 0 0 1rem;
                text-align: center;
            }
            .modern-admin-table {
                width: 100%;
                border-collapse: separate;
                border-spacing: 0;
                margin-bottom: 0;
            }
            .modern-admin-table thead th {
                background: #eef2ff;
                color: #3730a3;
                font-size: 0.8rem;
                font-weight: 700;
                letter-spacing: 0.04em;
                text-transform: uppercase;
                border-bottom: 1px solid #dfe7ff;
                padding: 0.9rem 0.8rem;
            }
            .modern-admin-table tbody td {
                padding: 0.9rem 0.8rem;
                border-bottom: 1px solid #edf2f7;
                color: #334155;
            }
            .modern-admin-table tbody tr:hover {
                background: #f8faff;
            }
            .grand-total {
                font-weight: 700;
                color: #111827;
                background: #f8fafc;
            }
            @media (max-width: 768px) {
                .form-row {
                    grid-template-columns: 1fr;
                }
            }
        </style>
        <script src="js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body>
   <?php include_once('includes/header.php');?>
        <div id="layoutSidenav">
   <?php include_once('includes/sidebar.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <div class="page-header">
                            <h1 class="mt-4">B/w Dates Sales Report</h1>
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">B/w Dates Sales Report</li>
                            </ol>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
<form method="post" class="form-section">                                
<div class="form-row">
<div class="form-label">From Date</div>
<div><input type="date"  name="fromdate" class="form-control" required></div>
</div>

<div class="form-row">
<div class="form-label">To Date</div>
<div><input type="date"  name="todate" class="form-control" required></div>
</div>

<div class="form-row" style="grid-template-columns: 1fr;">
<div style="display:flex; justify-content:center;">
    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
</div>
</div>

</form>
                            </div>
                        </div>
                    </div>
<?php if (isset($_POST['submit'])) { 
$fdate=$_POST['fromdate'];
$tdate=$_POST['todate'];
?>

<div class="card mb-4">
    <div class="card-body">
<h4 class="report-title">Sales Report Form <?php echo $fdate;?> To <?php echo $tdate;?></h4>
<hr />
                                <table class="modern-admin-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Total Amount </th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php $query=mysqli_query($con,"SELECT sum(totalAmount) as totalamount,month(orderDate) as ordermonth,year(orderDate) as orderyear
    FROM `orders` where orderDate between '$fdate' and '$tdate' group by ordermonth,orderyear");
$cnt=1;
while($row=mysqli_fetch_array($query))
{
?>  

                                <tr>
                                            <td><?php echo htmlentities($cnt);?></td>
                                            <td><?php echo htmlentities($row['ordermonth']."-".$row['orderyear']);?></td>
                                            <td> <?php echo htmlentities($tamount=$row['totalamount']);?></td>
                                        </tr>
                                        <?php
$gamount+=$tamount;
                                         $cnt=$cnt+1; } ?>
                                       <tr class="grand-total">
                                           <th colspan="2">Grand Total</th>
                                           <th><?php echo $gamount; ?></th>
                                       </tr>

                                    </tbody>
                                </table>
                            </div>
</div>
<?php } ?>

                </main>
          <?php include_once('includes/footer.php');?>
            </div>
        </div>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
         <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
<?php } ?>
