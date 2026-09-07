<?php session_start();
global $con;
require_once __DIR__ . '/includes/config.php';
if (!isset($con) || !$con) {
    throw new RuntimeException('Database connection not initialized.');
}

$grantotal = isset($_SESSION['grandTotal']) ? (float) $_SESSION['grandTotal'] : 0;

if(strlen($_SESSION['id'])==0)
{   header('location:logout.php');
}else{

// For Address Insertion
if(isset($_POST['submit'])){
$uid=$_SESSION['id'];    
//Getting Post Values
$baddress=$_POST['baddress'];
$bcity=$_POST['bcity'];
$bstate=$_POST['bstate'];
$bpincode=$_POST['bpincode'];
$bcountry=$_POST['bcountry'];
$saddress=$_POST['saddress'];
$scity=$_POST['scity'];
$sstate=$_POST['sstate'];
$spincode=$_POST['spincode'];
$scountry=$_POST['scountry'];

$sql=mysqli_query($con,"insert into addresses(userId,billingAddress,billingCity,billingState,billingPincode,billingCountry,shippingAddress,shippingCity,shippingState,shippingPincode,shippingCountry) values('$uid','$baddress','$bcity','$bstate','$bpincode','$bcountry','$saddress','$scity','$sstate','$spincode','$scountry')");
if($sql)
{
    echo "<script>alert('You Address added successfully');</script>";
    echo "<script type='text/javascript'> document.location ='manage-addresses.php'; </script>";
}
else{
echo "<script>alert('Something went wrong. Please try again.');</script>";
    echo "<script type='text/javascript'> document.location ='manage-addresses.php'; </script>";
}
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shopping  | Checkout</title>
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

            .container {
                position: relative;
            }

            .table,
            form[name="address"] {
                background: rgba(255, 255, 255, 0.92);
                border: 1px solid var(--shop-border);
                border-radius: 20px;
                box-shadow: var(--shop-shadow);
            }

            .table {
                border-collapse: separate;
                border-spacing: 0;
                overflow: hidden;
            }

            .table th {
                background: linear-gradient(135deg, #eef2ff, #f8fafc);
                color: var(--shop-primary-dark);
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.04em;
            }

            .table td {
                vertical-align: middle;
                padding: 14px 12px;
            }

            .form-control {
                border-radius: 12px;
                border: 1px solid rgba(148, 163, 184, 0.45);
                height: 42px;
                padding: 10px 12px;
                box-shadow: none;
            }

            .form-control:focus {
                border-color: rgba(79, 70, 229, 0.8);
                box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.12);
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--shop-primary) 0%, var(--shop-primary-dark) 100%);
                border: 0;
                border-radius: 12px;
                padding: 10px 18px;
                font-weight: 700;
                box-shadow: 0 14px 28px rgba(79, 70, 229, 0.18);
            }

            .btn-primary:hover {
                transform: translateY(-2px);
            }

            .row.mt-3 {
                align-items: center;
            }
        </style>
    </head>
    <body>
<?php include_once('includes/header.php');?>
        <!-- Header-->
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">


                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Already Listed Addresses</h1>
                </div>

            </div>
        </header>
        <!-- Section-->
        <section class="py-5">
            <div class="container px-4  mt-5">
     



<h5>Already Listed Addresses</h5>
<?php 
$uid=$_SESSION['id'];
$query=mysqli_query($con,"select * from addresses where userId='$uid'");
$count=mysqli_num_rows($query);
if($count==0):
echo "<font color='red'>No addresses Found.</font>";
else:
 ?>
 <form method="post">
    <input type="hidden" name="grandtotal" value="<?php echo $grantotal; ?>">
<div class="row">
<div class="col-6">
      <table class="table">
            <thead>
                <tr>
                    <th colspan="4"><h5>Billing Address</h5></th>
                </tr>
            </thead>
            <tr>
                <thead>
                    <th width="250">Adresss</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Pincode</th>
                    <th>Country</th>
            
                </thead>
            </tr>
            </table>  

</div>
<div class="col-6">
          <table class="table">
            <thead>
                <tr>
                    <th colspan="4"><h5>Shipping Address</h5></th>
                </tr>
            </thead>
            <tr>
                <thead>
                    <th width="250">Adresss</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Pincode</th>
                    <th>Country</th>
            
                </thead>
            </tr>
            </tbody>
            </table> 
</div>
</div>
<!-- Fecthing Values-->
<?php while ($result=mysqli_fetch_array($query)) { ?>
<div class="row">
<div class="col-6">
      <table class="table">

            <tbody> 

                <tr>
            
                    <td width="250"><?php echo $result['billingAddress'];?></td>
                    <td><?php echo $result['billingCity'];?></td>
                    <td><?php echo $result['billingState'];?></td>
                    <td><?php echo $result['billingPincode'];?></td>
                    <td><?php echo $result['billingCountry'];?></td>
                </tr>
            </tbody>
            </table>  

</div>
<div class="col-6">
          <table class="table">
            <tbody> 
                <tr>
                    <td width="250"><?php echo $result['shippingAddress'];?></td>
                    <td><?php echo $result['shippingCity'];?></td>
                    <td><?php echo $result['shippingState'];?></td>
                    <td><?php echo $result['shippingPincode'];?></td>
                    <td><?php echo $result['shippingCountry'];?></td>
                </tr>
            </tbody>
            </table> 
</div>
</div>


<?php } endif;?>

</form>

<hr />
<form method="post" name="address">

     <div class="row">
        <!--Billing Addresss --->
        <div class="col-6">
               <div class="row">
         <div class="col-9" align="center"><h5>New Billing Address</h5><br /></div>
         <hr />
     </div>
     <div class="row">
         <div class="col-3">Address</div>
         <div class="col-6"><input type="text" name="baddress" id="baddress" class="form-control" required ></div>
     </div>
       <div class="row mt-3">
         <div class="col-3">City</div>
         <div class="col-6"><input type="text" name="bcity" id="bcity"  class="form-control" required>
         </div>
          

     </div>

       <div class="row mt-3">
         <div class="col-3">State</div>
         <div class="col-6"><input type="text" name="bstate" id="bstate" class="form-control" required></div>
     </div>

          <div class="row mt-3">
         <div class="col-3">Pincode</div>
         <div class="col-6"><input type="text" name="bpincode" id="bpincode" pattern="[0-9]+" title="only numbers" maxlength="6" class="form-control" required></div>
     </div>

           <div class="row mt-3">
         <div class="col-3">Country</div>
         <div class="col-6"><input type="text" name="bcountry" id="bcountry" class="form-control" required></div>
     </div>
 </div>
        <!--Shipping Addresss --->
        <div class="col-6">
               <div class="row">
         <div class="col-9" align="center"><h5>New Shipping Address</h5> 
            <input type="checkbox" name="adcheck" value="1"/>
            <small>Shipping Adress same as billing Address</small></div>
         <hr />
     </div>
     <div class="row">
         <div class="col-3">Address</div>
         <div class="col-6"><input type="text" name="saddress"  id="saddress" class="form-control" required ></div>
     </div>
       <div class="row mt-3">
         <div class="col-3">City</div>
         <div class="col-6"><input type="text" name="scity" id="scity" class="form-control" required>
         </div>
          
     </div>

       <div class="row mt-3">
         <div class="col-3">State</div>
         <div class="col-6"><input type="text" name="sstate" id="sstate" class="form-control" required></div>
     </div>

          <div class="row mt-3">
         <div class="col-3">Pincode</div>
         <div class="col-6"><input type="text" name="spincode" id="spincode" pattern="[0-9]+" title="only numbers" maxlength="6" class="form-control" required></div>
     </div>

           <div class="row mt-3">
         <div class="col-3">Country</div>
         <div class="col-6"><input type="text" name="scountry" id="scountry" class="form-control" required></div>
     </div>

      
 </div>
         <div class="row mt-3">
                 <div class="col-5">&nbsp;</div>
         <div class="col-6"><input type="submit" name="submit" id="submit" class="btn btn-primary" value="Add" required></div>
     </div>

</div>
 </form>

              
            </div>

 
</div>
        </section>
        <!-- Footer-->
   <?php include_once('includes/footer.php'); ?>
        <!-- Bootstrap core JS-->
        <script src="js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
        <script type="text/javascript">
    $(document).ready(function(){
        $('input[type="checkbox"]').click(function(){
            if($(this).prop("checked") == true){
                $('#saddress').val($('#baddress').val() );
                $('#scity').val($('#bcity').val());
                $('#sstate').val($('#bstate').val());
                $('#spincode').val( $('#bpincode').val());
                  $('#scountry').val($('#bcountry').val() );
            } 
            
        });
    });
</script>
    </body>
</html>
<?php } ?>
