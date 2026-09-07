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
    $category=$_POST['category'];
    $subcat=$_POST['subcategory'];
    $productname=$_POST['productName'];
    $productcompany=$_POST['productCompany'];
    $productprice=$_POST['productprice'];
    $productpricebd=$_POST['productpricebd'];
    $productdescription=$_POST['productDescription'];
    $productscharge=$_POST['productShippingcharge'];
    $productavailability=$_POST['productAvailability'];
    $productimage1=$_FILES["productimage1"]["name"];
    $productimage2=$_FILES["productimage2"]["name"];
    $productimage3=$_FILES["productimage3"]["name"];
$extension1 = substr($productimage1,strlen($productimage1)-4,strlen($productimage1));
$extension2 = substr($productimage2,strlen($productimage2)-4,strlen($productimage2));
$extension3 = substr($productimage3,strlen($productimage3)-4,strlen($productimage3));
//Renaming the  image file
$imgnewfile1=md5($productimage1.time()).$extension1;
$imgnewfile2=md5($productimage2.time()).$extension2;
$imgnewfile3=md5($productimage3.time()).$extension3;
$addedby=$_SESSION['aid'];


    move_uploaded_file($_FILES["productimage1"]["tmp_name"],"productimages/".$imgnewfile1);
    move_uploaded_file($_FILES["productimage2"]["tmp_name"],"productimages/".$imgnewfile2);
    move_uploaded_file($_FILES["productimage3"]["tmp_name"],"productimages/".$imgnewfile3);
$sql=mysqli_query($con,"insert into products(category,subCategory,productName,productCompany,productPrice,productDescription,shippingCharge,productAvailability,productImage1,productImage2,productImage3,productPriceBeforeDiscount,addedBy) values('$category','$subcat','$productname','$productcompany','$productprice','$productdescription','$productscharge','$productavailability','$imgnewfile1','$imgnewfile2','$imgnewfile3','$productpricebd','$addedby')");
echo "<script>alert('Product Added added successfully');</script>";
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
        <title>Shopping | Add Products</title>
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
                margin-top: 0.75rem;
                padding-top: 0.5rem;
            }
            @media (max-width: 768px) {
                .form-row {
                    grid-template-columns: 1fr;
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
                            <h1 class="mt-4">Add Product</h1>
                            <ol class="breadcrumb mb-4">
                                <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Add Product</li>
                            </ol>
                        </div>
                        <div class="card mb-4">
                            <div class="card-body">
<form  method="post" enctype="multipart/form-data" class="form-section">                                
<div class="form-row">
<div class="form-label">Category Name</div>
<div>
<select name="category" id="category" class="form-control" onChange="getSubcat(this.value);" required>
<option value="">Select Category</option> 
<?php $query=mysqli_query($con,"select * from category");
while($row=mysqli_fetch_array($query))
{?>

<option value="<?php echo $row['id'];?>"><?php echo $row['categoryName'];?></option>
<?php } ?>
</select>    
</div>
</div>

<div class="form-row">
<div class="form-label">Sub Category name</div>
<div><select   name="subcategory"  id="subcategory" class="form-control" required>
</select>
</div>
</div>

<div class="form-row">
<div class="form-label">Product Name</div>
<div><input type="text"    name="productName"  placeholder="Enter Product Name" class="form-control" required>
</div>
</div>

<div class="form-row">
<div class="form-label">Product Company</div>
<div><input type="text"    name="productCompany"  placeholder="Enter Product Comapny Name" class="form-control" required>
</div>
</div>

<div class="form-row">
<div class="form-label">Product Price Before Discount</div>
<div><input type="text"    name="productpricebd"  placeholder="Enter Product Price" class="form-control" required>
</div>
</div>

<div class="form-row">
<div class="form-label">Product Price After Discount(Selling Price)</div>
<div><input type="text"    name="productprice"  placeholder="Enter Product Price" class="form-control" required>
</div>
</div>

<div class="form-row">
<div class="form-label">Product Description</div>
<div><textarea  name="productDescription"  placeholder="Enter Product Description" rows="6" class="form-control"></textarea>
</div>
</div>

<div class="form-row">
<div class="form-label">Product Shipping Charge</div>
<div><input type="text"    name="productShippingcharge"  placeholder="Enter Product Shipping Charge" class="form-control" required>
</div>
</div>

<div class="form-row">
<div class="form-label">Product Availability</div>
<div><select   name="productAvailability"  id="productAvailability" class="form-control" required>
<option value="">Select</option>
<option value="In Stock">In Stock</option>
<option value="Out of Stock">Out of Stock</option>
</select>
</div>
</div>

<div class="form-row">
<div class="form-label">Product Featured Image</div>
<div><input type="file" name="productimage1" id="productimage1"  class="form-control" accept="image/*" title="Accept images only" required>
</div>
</div>

<div class="form-row">
<div class="form-label">Product Image 2</div>
<div><input type="file" name="productimage2"  class="form-control" accept="image/*" title="Accept images only" required>
</div>
</div>


<div class="form-row">
<div class="form-label">Product Image 3</div>
<div><input type="file" name="productimage3"  class="form-control" accept="image/*" title="Accept images only" required>
</div>
</div>

<div class="form-row submit-row">
<div></div>
<div><button type="submit" name="submit" class="btn btn-primary">Submit</button></div>
</div>

</form>
                            </div>
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
