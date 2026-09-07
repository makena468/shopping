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
//Dashboard COunt
$ret=mysqli_query($con,"select count(id) as totalorders,
count(if((orderStatus='' || orderStatus is null),0,null)) as neworders,
count(if(orderStatus='Packed', 0,null)) as packedorders,
count(if(orderStatus='Dispatched',  0,null)) as dispatchedorders,
count(if(orderStatus='In Transit',  0,null)) as intransitorders,
count(if(orderStatus='Out For Delivery', 0,null)) as outfdorders,
count(if(orderStatus='Delivered', 0,null)) as deliveredorders,
count(if(orderStatus='Cancelled', 0,null)) as cancelledorders
from orders;");
$results=mysqli_fetch_array($ret);
$torders=$results['totalorders'];
$norders=$results['neworders'];
$porders=$results['packedorders'];
$dtorders=$results['dispatchedorders'];
$intorders=$results['intransitorders'];
$otforders=$results['outfdorders'];
$deliveredorders=$results['deliveredorders'];
$cancelledorders=$results['cancelledorders'];
//COde for Registered users
$ret1=mysqli_query($con,"select count(id) as totalusers from users;");
$results1=mysqli_fetch_array($ret1);
$tregusers=$results1['totalusers'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shooping Portal | Admin Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
   <?php include_once('includes/header.php');?>


        <div id="layoutSidenav">
          <?php include_once('includes/sidebar.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Dashboard</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                        <style>
                            .dashboard-stat-card {
                                border-radius: 22px !important;
                                overflow: hidden;
                                border: 1px solid rgba(79, 70, 229, 0.12);
                                box-shadow: 0 18px 38px rgba(17, 24, 39, 0.10);
                            }

                            .dashboard-stat-card .card-body {
                                padding: 22px 18px 16px;
                            }

                            .dashboard-stat-card .card-footer {
                                padding: 12px 18px;
                                background: rgba(255,255,255,0.12);
                                border-top: 0;
                            }

                            .dashboard-stat-card .text-lg {
                                font-size: 1.8rem;
                                font-weight: 800;
                            }

                            .dashboard-stat-card .small {
                                font-weight: 700;
                                text-transform: uppercase;
                                letter-spacing: 0.04em;
                            }
                        </style>
           <div class="row">
                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-primary text-white h-100 dashboard-stat-card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Manage All Orders</div>
                                                <div class="text-lg fw-bold"><?php echo $torders; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <a class="text-white stretched-link" href="all-orders.php">View Details</a>
                              
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-danger text-white h-100 dashboard-stat-card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Manage New Orders</div>
                                                <div class="text-lg fw-bold"><?php echo $norders; ?></div>
                                            </div>
                                 
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <a class="text-white stretched-link" href="new-order.php">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-warning text-white h-100 dashboard-stat-card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Manage Packed Orders</div>
                                                <div class="text-lg fw-bold"><?php echo $porders; ?></div>
                                            </div>
                                   
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <a class="text-white stretched-link" href="packed-orders.php">View Tasks</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-secondary text-white h-100 dashboard-stat-card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Manage Dispatched Orders</div>
                                                <div class="text-lg fw-bold"><?php echo $dtorders; ?></div>
                                            </div>
    
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <a class="text-white stretched-link" href="dispatched-orders.php">View Requests</a>
                                    </div>
                                </div>
                            </div>
                        </div>
<!-------------------------------------->
     <div class="row">
                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-warning text-white h-100 dashboard-stat-card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">In Transit Orders</div>
                                                <div class="text-lg fw-bold"><?php echo $intorders; ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <a class="text-white stretched-link" href="intransit-orders.php">View Details</a>
                              
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-primary text-white h-100 dashboard-stat-card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Out for Delivery Orders</div>
                                                <div class="text-lg fw-bold"><?php echo $otforders; ?></div>
                                            </div>
                                 
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <a class="text-white stretched-link" href="outfordelivery-orders.php">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-success text-white h-100 dashboard-stat-card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Delivered Orders</div>
                                                <div class="text-lg fw-bold"><?php echo $deliveredorders; ?></div>
                                            </div>
                                   
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <a class="text-white stretched-link" href="delivered-orders.php">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-black text-white h-100 dashboard-stat-card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Manage Registered Users</div>
                                                <div class="text-lg fw-bold"><?php echo $tregusers; ?></div>
                                            </div>
    
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <a class="text-white stretched-link" href="registered-users.php">View Requests</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-------------->
                             <div class="row">
                               <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-danger text-white h-100 dashboard-stat-card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Manage Cancelled Orders</div>
                                                <div class="text-lg fw-bold"><?php echo $cancelledorders; ?></div>
                                            </div>
                                 
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <a class="text-white stretched-link" href="cancelled-orders.php">View Details</a>
                                    </div>
                                </div>
                            </div>
                        </div>



               
                    </div>
                </main>
   <?php include_once('includes/footer.php');?>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html>
<?php } ?>
