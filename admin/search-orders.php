<?php session_start();
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
        <title>Shooping Portal | Manage Searched Orders</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
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
            .card-header {
                background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
                color: #fff;
                border-bottom: none;
                font-weight: 600;
                padding: 1rem 1.25rem;
            }
            .card-body {
                padding: 1.25rem;
            }
            .search-title {
                margin: 0 0 1rem;
                color: #3730a3;
                text-align: center;
                font-weight: 700;
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
                vertical-align: middle;
            }
            .modern-admin-table tbody tr:hover {
                background: #f8faff;
            }
            .action-link {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 42px;
                height: 42px;
                border-radius: 12px;
                background: #eef2ff;
                color: #4338ca;
                transition: 0.2s ease;
            }
            .action-link:hover {
                background: #e0e7ff;
                color: #312e81;
                text-decoration: none;
            }
        </style>
        <script src="js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
 <?php include_once('includes/header.php');?>
        <div id="layoutSidenav">
       <?php include_once('includes/sidebar.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <div class="page-header">
                            <h1 class="mt-4">Manage Searched Orders</h1>
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Manage Searched Orders</li>
                            </ol>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                               All Order Details
                            </div>
                            <div class="card-body">

<?php
if(isset($_POST['search'])){
$searchinput=$_POST['searchinputdata'];
?>
<h4 class="search-title">Search Result against <?php echo $searchinput;?></h4>
<hr />
                                <table class="modern-admin-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Order No.</th>
                                            <th>Order By</th>
                                            <th>Order Amount</th>
                                            <th>Order Date</th>
                                            <th>Order Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php $query=mysqli_query($con,"SELECT orders.id,orderNumber,totalAmount,orderStatus,orderDate,users.name,users.contactno 
    FROM `orders` join users on users.id=orders.userId where (users.name like '%$searchinput%' || orders.orderNumber like '%$searchinput%')");
$cnt=1;
while($row=mysqli_fetch_array($query))
{
?>  

                                <tr>
                                            <td><?php echo htmlentities($cnt);?></td>
                                            <td><?php echo htmlentities($row['orderNumber']);?></td>
                                            <td><?php echo htmlentities($row['name']);?></td>
                                            <td> <?php echo htmlentities($row['totalAmount']);?></td>
                                            <td><?php echo htmlentities($row['orderDate']);?></td>
                                            <td><?php echo htmlentities($row['orderStatus']);?></td>
                                            <td>
                                            <a href="order-details.php?orderid=<?php echo $row['id']?>" class="action-link" target="_blank" title="View Order Details">
                                                <i class="fas fa-file"></i></a></td>
                                        </tr>
                                        <?php $cnt=$cnt+1; } ?>
                                       
                                    </tbody>
                                </table>
<?php } ?>

                            </div>
                        </div>
                    </div>
                </main>
<?php include_once('includes/footer.php');?>
                </footer>
            </div>
        </div>
        <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
<?php } ?>
