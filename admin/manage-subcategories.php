<?php session_start();
global $con;
require_once __DIR__ . '/includes/config.php';
if (!isset($con) || !$con) {
    throw new RuntimeException('Database connection not initialized.');
}

error_reporting(0);
if(strlen( $_SESSION["aid"])==0)
{   
header('location:logout.php');
} else {

if(isset($_GET['del']))
{
mysqli_query($con,"delete from subcategory where id = '".$_GET['id']."'");
echo "<script>alert('Data Deleted');</script>";
echo "<script>window.location.href='manage-subcategories.php'</script>";
}


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shopping  | Manage Sub-Categories</title>
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
                            <h1 class="mt-4">Manage SubCategories</h1>
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Manage SubCategories</li>
                            </ol>
                        </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                               SubCategories Details
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple" class="modern-admin-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Sub Category</th>
                                            <th>Category</th>
                                            <th>Creation date</th>
                                            <th>Last Updated</th>
                                            <th>Created by</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                        <th>#</th>

                                            <th>Sub Category</th>                                           
                                            <th>Category</th>
                                            <th>Creation date</th>
                                            <th>Last Updated</th>
                                            <th>Created by</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
<?php $query=mysqli_query($con,"select category.categoryName,subcategory.subcategoryName as subcatname,subcategory.creationDate,subcategory.updationDate,subcategory.id as subid,tbladmin.username from subcategory join category on subcategory.categoryid=category.id join tbladmin on tbladmin.id=subcategory.createdBy");
$cnt=1;
while($row=mysqli_fetch_array($query))
{
?>  

                                <tr>
                                            <td><?php echo htmlentities($cnt);?></td>
                                            <td><?php echo htmlentities($row['subcatname']);?></td>
                                            <td><?php echo htmlentities($row['categoryName']);?></td>
                                            <td> <?php echo htmlentities($row['creationDate']);?></td>
                                            <td><?php echo htmlentities($row['updationDate']);?></td>
                                            <td><?php echo htmlentities($row['username']);?></td>
                                            <td>
                                                <div class="table-actions">
                                                    <a href="edit-subcategory.php?id=<?php echo $row['subid']?>" class="action-link" title="Edit subcategory"><i class="fas fa-edit"></i></a>
                                                    <a href="manage-subcategories.php?id=<?php echo $row['subid']?>&del=delete" class="action-link delete" onClick="return confirm('Are you sure you want to delete?')" title="Delete subcategory"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $cnt=$cnt+1; } ?>
                                       
                                    </tbody>
                                </table>
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
