<?php
session_start();
global $con;
require_once __DIR__ . '/includes/config.php';
if (!isset($con) || !$con) {
    throw new RuntimeException('Database connection not initialized.');
}

if (empty($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}

if (isset($_GET['del'])) {
    $wid = intval($_GET['del']);
    $stmt = $con->prepare('DELETE FROM wishlist WHERE id = ? AND userId = ?');
    $stmt->bind_param('ii', $wid, $_SESSION['id']);
    $stmt->execute();
    $stmt->close();
    header('Location: my-wishlist.php');
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'add' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $con->prepare('DELETE FROM wishlist WHERE productId = ? AND userId = ?');
    $stmt->bind_param('ii', $id, $_SESSION['id']);
    $stmt->execute();
    $stmt->close();

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
    } else {
        $productStmt = $con->prepare('SELECT id, productName, productPrice FROM products WHERE id = ? LIMIT 1');
        $productStmt->bind_param('i', $id);
        $productStmt->execute();
        $productResult = $productStmt->get_result();
        $product = $productResult->fetch_assoc();
        $productStmt->close();

        if ($product) {
            $_SESSION['cart'][$product['id']] = array(
                'quantity' => 1,
                'price' => (float) $product['productPrice']
            );
        }
    }

    header('Location: my-wishlist.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
        <title>My Wishlist</title>
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/main.css">
        <link rel="stylesheet" href="assets/css/red.css">
        <link rel="stylesheet" href="assets/css/owl.carousel.css">
        <link rel="stylesheet" href="assets/css/owl.transitions.css">
        <link href="assets/css/lightbox.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/animate.min.css">
        <link rel="stylesheet" href="assets/css/rateit.css">
        <link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="assets/images/favicon.ico">
    </head>
    <body class="cnt-home">
        <header class="header-style-1">
            <?php include('includes/top-header.php'); ?>
            <?php include('includes/main-header.php'); ?>
            <?php include('includes/menu-bar.php'); ?>
        </header>

        <div class="breadcrumb">
            <div class="container">
                <div class="breadcrumb-inner">
                    <ul class="list-inline list-unstyled">
                        <li><a href="index.php">Home</a></li>
                        <li class='active'>Wishlist</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="body-content outer-top-bd">
            <div class="container">
                <div class="my-wishlist-page inner-bottom-sm">
                    <div class="row">
                        <div class="col-md-12 my-wishlist">
                            <div class="table-responsive">
                                <table class="table wishlist-table">
                                    <thead>
                                        <tr>
                                            <th colspan="4">My Wishlist</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $ret = $con->prepare('SELECT w.id AS wid, w.productId AS pid, p.productName AS pname, p.productPrice AS pprice, p.productImage1 AS pimage FROM wishlist w INNER JOIN products p ON p.id = w.productId WHERE w.userId = ? ORDER BY w.postingDate DESC');
                                        $ret->bind_param('i', $_SESSION['id']);
                                        $ret->execute();
                                        $wishlistResult = $ret->get_result();
                                        $num = $wishlistResult->num_rows;

                                        if ($num > 0) {
                                            while ($row = $wishlistResult->fetch_assoc()) {
                                                $imagePath = 'admin/productimages/' . $row['pid'] . '/' . $row['pimage'];
                                        ?>
                                        <tr>
                                            <td class="col-md-2">
                                                <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="<?php echo htmlspecialchars($row['pname']); ?>" width="60" height="100">
                                            </td>
                                            <td class="col-md-6">
                                                <div class="product-name"><a href="product-details.php?pid=<?php echo intval($row['pid']); ?>"><?php echo htmlspecialchars($row['pname']); ?></a></div>
                                                <div class="price">Ksh. <?php echo number_format((float) $row['pprice'], 2); ?>
                                                </div>
                                            </td>
                                            <td class="col-md-2">
                                                <a href="my-wishlist.php?action=add&id=<?php echo intval($row['pid']); ?>" class="btn-upper btn btn-primary btn-block">Add to cart</a>
                                            </td>
                                            <td class="col-md-2 close-btn">
                                                <a href="my-wishlist.php?del=<?php echo intval($row['wid']); ?>" onClick="return confirm('Are you sure you want to delete this item from your wishlist?')" class="btn btn-light"><i class="fa fa-times"></i></a>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        } else {
                                        ?>
                                        <tr>
                                            <td colspan="4" class="empty-state">Your Wishlist is Empty</td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include('includes/footer.php'); ?>
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>