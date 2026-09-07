<?php
session_start();
global $con;
require_once __DIR__ . '/includes/config.php';
if (!isset($con) || !$con) {
    throw new RuntimeException('Database connection not initialized.');
}

if (isset($_POST['submit'])) {
    if (!empty($_SESSION['cart'])) {
        foreach ($_POST['quantity'] ?? [] as $productId => $value) {
            $productId = intval($productId);
            $qty = max(1, intval($value));
            if (isset($_SESSION['cart'][$productId])) {
                $_SESSION['cart'][$productId]['quantity'] = $qty;
            }
        }
        echo "<script>alert('Your Cart has been Updated');</script>";
    }
}

if (isset($_POST['remove_code']) && !empty($_POST['remove_code'])) {
    foreach ($_POST['remove_code'] as $productId) {
        $productId = intval($productId);
        unset($_SESSION['cart'][$productId]);
    }
    echo "<script>alert('Your Cart has been Updated');</script>";
}

// Place order
if (isset($_POST['ordersubmit'])) {
    if (empty($_SESSION['login'])) {
        header('Location: login.php');
        exit();
    }

    if (empty($_SESSION['cart'])) {
        echo "<script>alert('Your cart is empty.');</script>";
    } else {
        header('Location: checkout.php');
        exit();
    }
}

$cartItems = [];
$grandTotal = 0;
if (!empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $productId => $details) {
        $stmt = $con->prepare('SELECT id, productName, productPrice, productImage1, shippingCharge FROM products WHERE id = ? LIMIT 1');
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $stmt->close();

        if ($product) {
            $qty = max(1, intval($details['quantity']));
            $lineTotal = ((float) $product['productPrice'] + (float) $product['shippingCharge']) * $qty;
            $grandTotal += $lineTotal;

            $cartItems[] = array(
                'id' => (int) $product['id'],
                'name' => $product['productName'],
                'image' => $product['productImage1'],
                'price' => (float) $product['productPrice'],
                'shipping' => (float) $product['shippingCharge'],
                'quantity' => $qty,
                'lineTotal' => $lineTotal
            );
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <style>
        :root {
            --shop-primary: #4f46e5;
            --shop-primary-dark: #312e81;
            --shop-accent: #f59e0b;
            --shop-bg: #f3f6ff;
            --shop-surface: #ffffff;
            --shop-border: rgba(79, 70, 229, 0.12);
            --shop-shadow: 0 18px 40px rgba(17, 24, 39, 0.10);
        }

        body.cnt-home {
            background: linear-gradient(180deg, #f8faff 0%, #eef4ff 100%);
            color: #1f2937;
        }

        .breadcrumb {
            background: transparent;
            padding: 28px 0 12px;
        }

        .breadcrumb-inner {
            background: rgba(255, 255, 255, 0.80);
            border: 1px solid var(--shop-border);
            border-radius: 18px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.04);
            padding: 16px 18px;
        }

        .shopping-cart-inner,
        .shopping-cart-table .table,
        .shopping-cart-table form {
            border-radius: 20px;
        }

        .shopping-cart-table .table {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid var(--shop-border);
            box-shadow: var(--shop-shadow);
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
        }

        .shopping-cart-table thead th {
            background: linear-gradient(135deg, #eef2ff, #f8fafc);
            color: var(--shop-primary-dark);
            border-bottom: 1px solid var(--shop-border);
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 16px 14px;
        }

        .shopping-cart-table tbody td {
            vertical-align: middle;
            padding: 18px 14px;
            border-top: 1px solid rgba(148, 163, 184, 0.20);
            color: #374151;
        }

        .shopping-cart-table .cart-product-description a {
            color: #111827;
            font-weight: 700;
        }

        .shopping-cart-table td.cart-image img {
            border-radius: 16px;
            box-shadow: 0 10px 18px rgba(15, 23, 42, 0.12);
        }

        .shopping-cart-table .form-control {
            border-radius: 12px;
            border: 1px solid rgba(148, 163, 184, 0.4);
            box-shadow: none;
            width: 82px;
            height: 42px;
            text-align: center;
            font-weight: 700;
        }

        .shopping-cart-table .btn,
        .shopping-cart-table .btn-primary,
        .shopping-cart-table .btn-success {
            border-radius: 12px !important;
            padding: 10px 18px;
            font-weight: 700;
            box-shadow: 0 12px 25px rgba(79, 70, 229, 0.18);
            border: 0 !important;
        }

        .shopping-cart-table .btn-primary,
        .shopping-cart-table .btn-success {
            background: linear-gradient(135deg, var(--shop-primary) 0%, var(--shop-primary-dark) 100%);
            color: #fff;
        }

        .shopping-cart-table .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .shopping-cart-table .btn:hover {
            transform: translateY(-2px);
        }

        .shopping-cart-table .text-center {
            color: #4b5563;
            font-weight: 700;
        }

        @media (max-width: 767px) {
            .shopping-cart-table .table {
                display: block;
                overflow-x: auto;
            }
        }
    </style>
</head>
<body class="cnt-home">
    <?php include('includes/top-header.php'); ?>
    <?php include('includes/main-header.php'); ?>
    <?php include('includes/menu-bar.php'); ?>

    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="index.php">Home</a></li>
                    <li class='active'>Shopping Cart</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="body-content outer-top-bd">
        <div class="container">
            <div class="shopping-cart inner-bottom-sm">
                <div class="row">
                    <div class="col-md-12 col-sm-12 shopping-cart-table ">
                        <form name="cart" method="post">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th class="cart-romove item">Remove</th>
                                        <th class="cart-description item">Image</th>
                                        <th class="cart-product-name item">Product Name</th>
                                        <th class="cart-qty item">Quantity</th>
                                        <th class="cart-sub-total item">Price</th>
                                        <th class="cart-sub-total item">Shipping</th>
                                        <th class="cart-total last-item">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($cartItems)): ?>
                                        <?php foreach ($cartItems as $item): ?>
                                            <tr>
                                                <td class="romove-item">
                                                    <input type="checkbox" name="remove_code[]" value="<?php echo $item['id']; ?>">
                                                </td>
                                                <td class="cart-image">
                                                    <a href="product-details.php?pid=<?php echo $item['id']; ?>">
                                                        <img src="admin/productimages/<?php echo $item['id']; ?>/<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" width="80">
                                                    </a>
                                                </td>
                                                <td class="cart-product-name-info">
                                                    <h4 class='cart-product-description'><a href="product-details.php?pid=<?php echo $item['id']; ?>"><?php echo htmlspecialchars($item['name']); ?></a></h4>
                                                </td>
                                                <td class="cart-product-quantity">
                                                    <input type="number" name="quantity[<?php echo $item['id']; ?>]" value="<?php echo $item['quantity']; ?>" min="1" class="form-control" style="width:80px;">
                                                </td>
                                                <td class="cart-product-sub-total"><?php echo number_format($item['price'], 2); ?></td>
                                                <td class="cart-product-sub-total"><?php echo number_format($item['shipping'], 2); ?></td>
                                                <td class="cart-product-grand-total"><?php echo number_format($item['lineTotal'], 2); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td colspan="6" class="text-right"><strong>Grand Total</strong></td>
                                            <td><strong>Ksh. <?php echo number_format($grandTotal, 2); ?></strong></td>
                                        </tr>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="7" class="text-center" style="font-size:18px; font-weight:bold;">Your Cart is Empty</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                            <?php if (!empty($cartItems)): ?>
                                <div class="pull-right">
                                    <button type="submit" name="submit" class="btn btn-primary">Update Cart</button>
                                    <button type="submit" name="ordersubmit" class="btn btn-success">Proceed to Checkout</button>
                                </div>
                            <?php endif; ?>
                        </form>
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