<?php
$uid = $_SESSION['id'] ?? 0;
$loggedInUser = !empty($_SESSION['login']);
$username = $_SESSION['username'] ?? '';
$cartcount = 0;
if ($uid) {
    $ret = mysqli_query($con, "select coalesce(sum(productQty),0) as qtyy from cart where userId='$uid'");
    $result = mysqli_fetch_array($ret);
    $cartcount = intval($result['qtyy'] ?? 0);
}
?>

<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="index.php">Shopping</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about-us.php">About</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="index.php">All Products</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="shop-categories.php">Categor Wise</a></li>
                    </ul>
                </li>
<?php if(!$loggedInUser){?>
          <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Users</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="login.php">Login</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="signup.php">Sign Up</a></li>
                            </ul>
                        </li>
                                     <li class="nav-item"><a class="nav-link" href="admin/">Admin</a></li>
                    <?php } else {?>
                        <li class="nav-item"><a class="nav-link" href="my-wishlist.php">My Wishlist</a></li>
                                  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">My Account</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="my-orders.php">Orders</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="my-account.php">Profile</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="change-password.php">Change Password</a></li>
                                  <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="manage-addresses.php">Adresses</a></li>
                                  <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                     <?php } ?>  
                      <li class="nav-item"><a class="nav-link" href="contact-us.php">Contact us</a></li> 
        
                    </ul>  
<?php if($loggedInUser):?>
<strong>Welcome:</strong> <?php echo htmlspecialchars($username); ?> &nbsp;
<?php endif;?>
                    <form class="d-flex">
                        <a class="btn btn-outline-dark" href="my-cart.php">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill"><?php echo $cartcount; ?></span>
                        </a>
                    </form>

                </div>
            </div>
        </nav>