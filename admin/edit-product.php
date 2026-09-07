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
//For Adding Products
if(isset($_POST['submit']))
{

    $pid=intval($_GET['id']);
    $category=$_POST['category'];
    $subcat=$_POST['subcategory'];
    $productname=$_POST['productName'];
    $productcompany=$_POST['productCompany'];
    $productprice=$_POST['productprice'];
    $productpricebd=$_POST['productpricebd'];
    $productdescription=$_POST['productDescription'];
    $productscharge=$_POST['productShippingcharge'];
    $productavailability=$_POST['productAvailability'];
    $updatedby=$_SESSION['aid'];

$sql=mysqli_query($con,"update products set category='$category',subCategory='$subcat',productName='$productname',productCompany='$productcompany',productPrice='$productprice',productDescription='$productdescription',shippingCharge='$productscharge',productAvailability='$productavailability',productPriceBeforeDiscount='$productpricebd',lastUpdatedBy='$updatedby' where id='$pid'");
echo "<script>alert('Product details updated successfully');</script>";
echo "<script>window.location.href='manage-products.php'</script>";
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
        <title>Shopping Portal | Edit Product</title>
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
                grid-template-columns: minmax(180px, 220px) minmax(0, 1fr);
                align-items: center;
                gap: 1rem;
            }
            .form-label {
                font-size: 0.92rem;
                font-weight: 600;
                color: #334155;
            }
            .form-control,
            select.form-control,
            textarea.form-control {
                background: #f8fafc;
                border: 1px solid #dfe7f1;
                border-radius: 12px;
                min-height: 45px;
                padding: 0.75rem 0.9rem;
                color: #0f172a;
                box-shadow: none;
            }
            .form-control:focus,
            select.form-control:focus,
            textarea.form-control:focus {
                background: #fff;
                border-color: #a5b4fc;
                box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.12);
            }
            textarea.form-control {
                min-height: 120px;
                resize: vertical;
            }
            .image-preview {
                display: flex;
                flex-direction: column;
                gap: 0.75rem;
            }
            .image-preview img {
                display: block;
                width: 220px;
                height: 160px;
                object-fit: cover;
                border-radius: 14px;
                border: 1px solid #dfe7f1;
                background: #f8fafc;
            }
            .image-link {
                color: #4338ca;
                font-weight: 600;
                text-decoration: none;
            }
            .image-link:hover {
                text-decoration: underline;
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
            .submit-row {
                margin-top: 0.5rem;
            }
            @media (max-width: 768px) {
                .form-row {
                    grid-template-columns: 1fr;
                }
                .image-preview img {
                    width: 100%;
                    max-width: 220px;
                }
            }
        </style>
        <script src="js/all.min.js" crossorigin="anonymous"></script>
        <script src="js/jquery-3.5.1.min.js"></script>
   <script>
function getSubcat(val) {
    $.ajax({
    type: "POST",
    url: "get_subcat.php",
    data:'cat_id='+val,
    success: function(data){
        $("#subcategory").html(data);
    }
    });
}
</script>   

    </head>
    <body>
   <?php include_once('includes/header.php');?>
        <div id="layoutSidenav">
   <?php include_once('includes/sidebar.php');?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <div class="page-header">
                            <h1 class="mt-4">Edit Product</h1>
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Edit Product</li>
                            </ol>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">


<?php 
$pid=intval($_GET['id']);
$query=mysqli_query($con,"select products.id as pid,products.productImage1,products.productImage2,products.productImage3,products.productName,category.categoryName,subcategory.subcategoryName as subcatname,products.postingDate,products.updationDate,subcategory.id as subid,tbladmin.username,category.id as catid,products.productCompany,products.productPrice,products.productPriceBeforeDiscount,products.productAvailability,products.productDescription,products.shippingCharge from products join subcategory on products.subCategory=subCategory.id join category on products.category=category.id join tbladmin on tbladmin.id=products.addedBy where  products.id='$pid' order by pid desc");
while($row=mysqli_fetch_array($query))
{
?>                                 
<form  method="post" enctype="multipart/form-data" class="form-section">                                
<div class="form-row">
<div class="form-label">Category Name</div>
<div>
<select name="category" id="category" class="form-control" onChange="getSubcat(this.value);" required>
<option value="<?php echo htmlentities($row['catid']);?>"><?php echo htmlentities($row['categoryName']);?></option> 
<?php $ret=mysqli_query($con,"select * from category");
while($result=mysqli_fetch_array($ret))
{?>

<option value="<?php echo $result['id'];?>"><?php echo $result['categoryName'];?></option>
<?php } ?>
</select>    
</div>
</div>

<div class="form-row">
<div class="form-label">Sub Category name</div>
<div><select   name="subcategory"  id="subcategory" class="form-control" required>
    <option value="<?php echo htmlentities($row['subid']);?>"><?php echo htmlentities($row['subcatname']);?>
</select>
</div>
</div>

<div class="form-row">
<div class="form-label">Product Name</div>
<div><input type="text"    name="productName"  value="<?php echo htmlentities($row['productName']);?>" class="form-control" required>
</div>
</div>

<div class="form-row">
<div class="form-label">Product Company</div>
<div><input type="text"    name="productCompany"  value="<?php echo htmlentities($row['productCompany']);?>" class="form-control" required>
</div>
</div>

<div class="form-row">
<div class="form-label">Product Price Before Discount</div>
<div><input type="text"    name="productpricebd"  value="<?php echo htmlentities($row['productPriceBeforeDiscount']);?>" class="form-control" required>
</div>
</div>

<div class="form-row">
<div class="form-label">Product Price After Discount(Selling Price)</div>
<div><input type="text"    name="productprice"  value="<?php echo htmlentities($row['productPrice']);?>" class="form-control" required>
</div>
</div>

<div class="form-row">
<div class="form-label">Product Description</div>
<div><textarea  name="productDescription"  placeholder="Enter Product Description" rows="6" class="form-control"><?php echo $row['productDescription'];?></textarea>
</div>
</div>

<div class="form-row">
<div class="form-label">Product Shipping Charge</div>
<div><input type="text"    name="productShippingcharge"  value="<?php echo htmlentities($row['shippingCharge']);?>" class="form-control" required>
</div>
</div>

<div class="form-row">
<div class="form-label">Product Availability</div>
<div><select   name="productAvailability"  id="productAvailability" class="form-control" required>
<?php $pa=$row['productAvailability'];
if($pa=='In Stock'):
?>
<option value="In Stock">In Stock</option>
<option value="Out of Stock">Out of Stock</option>
<?php else: ?>
<option value="Out of Stock">Out of Stock</option>    
<option value="In Stock">In Stock</option>
<?php endif; ?>
</select>
</div>
</div>

<div class="form-row">
<div class="form-label">Product Featured Image</div>
<div class="image-preview"><img src="productimages/<?php echo htmlentities($row['productImage1']);?>" width="250"><a href="change-image1.php?id=<?php echo $row['pid'];?>" class="image-link">Change Image</a></div>
</div>

<div class="form-row">
<div class="form-label">Product Image 2</div>
<div class="image-preview"><img src="productimages/<?php echo htmlentities($row['productImage2']);?>" width="250"><a href="change-image2.php?id=<?php echo $row['pid'];?>" class="image-link">Change Image</a></div>
</div>


<div class="form-row">
<div class="form-label">Product Image 3</div>
<div class="image-preview"><img src="productimages/<?php echo htmlentities($row['productImage3']);?>" width="250"><a href="change-image3.php?id=<?php echo $row['pid'];?>" class="image-link">Change Image</a></div>
</div>

<div class="form-row submit-row">
<div></div>
<div><button type="submit" name="submit" class="btn btn-primary">Update</button></div>
</div>

</form>
      
      <?php } ?>                      </div>
                        </div>
                    </div>
                </main>
          <?php include_once('includes/footer.php');?>
            </div>
        </div>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
<?php } ?>
