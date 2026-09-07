<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        :root {
            --shop-primary: #4f46e5;
            --shop-primary-dark: #312e81;
            --shop-accent: #f59e0b;
            --shop-bg: #f3f6ff;
            --shop-surface: #ffffff;
            --shop-surface-soft: #eef2ff;
            --shop-text: #1f2937;
            --shop-muted: #6b7280;
            --shop-border: rgba(79, 70, 229, 0.12);
            --shop-shadow: 0 18px 40px rgba(17, 24, 39, 0.10);
        }

        body {
            background: linear-gradient(180deg, #f8faff 0%, #eef4ff 100%);
            color: var(--shop-text);
            font-family: 'Roboto', sans-serif;
        }

        body.cnt-home {
            background: linear-gradient(180deg, #f8faff 0%, #eef4ff 100%);
        }

        .top-bar,
        .main-header,
        .header-style-1 .logo,
        .navbar,
        .top-cart-row,
        .header-style-1,
        .search-area {
            background: transparent !important;
        }

        .top-bar {
            background: linear-gradient(135deg, #111827 0%, #1f2937 100%) !important;
            color: #ffffff;
            border-bottom: 0;
            box-shadow: none;
        }

        .top-bar .cnt-account a,
        .top-bar .cnt-block a {
            color: rgba(255, 255, 255, 0.84);
            font-weight: 500;
        }

        .top-bar .cnt-account a:hover,
        .top-bar .cnt-block a:hover {
            color: #ffffff;
        }

        .main-header {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--shop-border);
            box-shadow: 0 10px 25px rgba(15, 23, 42, 0.04);
        }

        .logo a,
        .logo h2,
        .logo h3 {
            color: var(--shop-primary-dark) !important;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .search-area {
            position: relative;
            background: #ffffff;
            border: 1px solid rgba(79, 70, 229, 0.14);
            border-radius: 999px;
            overflow: hidden;
            box-shadow: 0 10px 24px rgba(79, 70, 229, 0.08);
        }

        .search-field {
            border: 0 !important;
            background: transparent !important;
            padding: 13px 58px 13px 20px !important;
            height: auto !important;
            color: var(--shop-text) !important;
            font-size: 14px !important;
        }

        .search-button {
            position: absolute;
            right: 8px;
            top: 8px;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 0;
            background: linear-gradient(135deg, var(--shop-primary) 0%, var(--shop-primary-dark) 100%);
            color: #fff;
            box-shadow: 0 12px 20px rgba(79, 70, 229, 0.25);
        }

        .search-button:before {
            content: '\f002';
            font-family: 'FontAwesome';
            font-size: 15px;
        }

        .dropdown-cart .lnk-cart {
            background: var(--shop-surface-soft);
            border: 1px solid rgba(79, 70, 229, 0.10);
            border-radius: 16px;
            padding: 12px 18px;
            color: var(--shop-text);
        }

        .dropdown-cart .lnk-cart .basket {
            background: var(--shop-primary);
            color: #fff;
            border-radius: 12px;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dropdown-cart .basket-item-count .count {
            background: var(--shop-accent);
            color: #fff;
            border-radius: 999px;
            font-weight: 700;
        }

        .breadcrumb {
            background: transparent;
            padding: 24px 0 12px;
        }

        .breadcrumb-inner {
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid var(--shop-border);
            border-radius: 14px;
            padding: 12px 16px;
            box-shadow: 0 10px 20px rgba(15, 23, 42, 0.04);
        }

        .breadcrumb-inner li a,
        .breadcrumb-inner li.active {
            color: var(--shop-primary-dark);
            font-weight: 600;
        }

        .body-content {
            padding-top: 20px;
        }

        .product,
        .products,
        .info-box,
        .my-wishlist-page .table,
        .table-responsive,
        .footer,
        .dropdown-menu,
        .cart-item,
        .side-menu {
            border-radius: 20px;
        }

        .product {
            background: #fff;
            border: 1px solid rgba(148, 163, 184, 0.2);
            box-shadow: var(--shop-shadow);
            overflow: hidden;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .product:hover {
            transform: translateY(-4px);
            box-shadow: 0 22px 45px rgba(17, 24, 39, 0.14);
        }

        .product-image {
            background: linear-gradient(135deg, rgba(79, 70, 229, 0.06), rgba(245, 158, 11, 0.08));
            padding: 18px;
        }

        .product-image img {
            border-radius: 16px;
            object-fit: cover;
        }

        .product-info {
            padding: 18px 18px 12px;
        }

        .product-info .name a {
            color: var(--shop-text);
            font-weight: 700;
            line-height: 1.4;
        }

        .product-price {
            margin-top: 12px;
        }

        .product-price .price {
            color: var(--shop-primary-dark);
            font-size: 20px;
            font-weight: 800;
        }

        .product-price .price-before-discount {
            color: var(--shop-muted);
            font-size: 12px;
            text-decoration: line-through;
            margin-left: 8px;
        }

        .action {
            padding: 0 18px 18px;
        }

        .btn,
        .btn-primary,
        .btn-info,
        .btn-default,
        .btn-upper {
            border-radius: 12px !important;
            font-weight: 700 !important;
            letter-spacing: 0.02em;
            transition: all 0.2s ease !important;
        }

        .btn-primary,
        .btn-info,
        .btn-upper {
            background: linear-gradient(135deg, var(--shop-primary) 0%, var(--shop-primary-dark) 100%) !important;
            border: 0 !important;
            color: #fff !important;
            box-shadow: 0 12px 25px rgba(79, 70, 229, 0.20);
        }

        .btn-primary:hover,
        .btn-info:hover,
        .btn-upper:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 30px rgba(79, 70, 229, 0.26);
        }

        .btn-light {
            background: #f8fafc;
            border: 1px solid rgba(148, 163, 184, 0.4);
            color: var(--shop-text);
        }

        .info-boxes {
            margin-top: 24px;
            margin-bottom: 24px;
        }

        .info-box {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid var(--shop-border);
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.05);
            padding: 20px;
        }

        .info-box .icon,
        .info-box .fa {
            background: linear-gradient(135deg, var(--shop-primary) 0%, var(--shop-primary-dark) 100%);
            color: #fff;
            border-radius: 12px;
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .info-box-heading {
            margin-top: 4px;
            margin-bottom: 8px;
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 0.04em;
            color: var(--shop-primary-dark);
        }

        .wishlist-table {
            border-collapse: separate;
            border-spacing: 0 16px;
            width: 100%;
        }

        .wishlist-table thead th {
            background: transparent;
            border: 0;
            color: var(--shop-primary-dark);
            font-size: 28px;
            font-weight: 800;
            padding: 0 0 8px;
        }

        .wishlist-table tbody tr {
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid var(--shop-border);
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.05);
        }

        .wishlist-table tbody tr td {
            border-top: 0;
            border-bottom: 0;
            padding: 18px 20px;
            vertical-align: middle;
        }

        .wishlist-table tbody tr td:first-child {
            border-top-left-radius: 18px;
            border-bottom-left-radius: 18px;
        }

        .wishlist-table tbody tr td:last-child {
            border-top-right-radius: 18px;
            border-bottom-right-radius: 18px;
        }

        .wishlist-table img {
            border-radius: 14px;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.12);
        }

        .wishlist-table .product-name {
            margin-bottom: 10px;
        }

        .wishlist-table .product-name a {
            color: var(--shop-text);
            font-size: 18px;
            font-weight: 700;
        }

        .wishlist-table .price {
            color: var(--shop-primary-dark);
            font-size: 18px;
            font-weight: 700;
        }

        .wishlist-table .empty-state {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid var(--shop-border);
            border-radius: 18px;
            color: var(--shop-muted);
            font-size: 18px;
            font-weight: 700;
            text-align: center;
            padding: 28px 20px;
        }

        .close-btn a {
            width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50% !important;
        }

        .dropdown-menu {
            border: 1px solid var(--shop-border);
            box-shadow: var(--shop-shadow);
        }

        .footer {
            background: linear-gradient(135deg, #0f172a 0%, #111827 100%);
            color: rgba(255, 255, 255, 0.82);
            margin-top: 40px;
            border-top: 0;
        }

        .footer .module-title,
        .footer .about-us,
        .footer p,
        .footer td,
        .footer a {
            color: rgba(255, 255, 255, 0.82);
        }

        .footer .module-title {
            color: #fff;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .footer .logo a {
            color: #fff !important;
        }

        .footer .table {
            background: transparent;
        }

        @media (max-width: 767px) {
            .main-header {
                padding: 10px 0;
            }

            .wishlist-table thead {
                display: none;
            }

            .wishlist-table tbody tr td {
                display: block;
                width: 100%;
                text-align: center;
            }

            .wishlist-table tbody tr td:last-child {
                padding-top: 0;
            }
        }
    </style>
</head>
<body>
    <footer id="footer" class="footer color-bg">
          <div class="links-social inner-top-sm">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-4">
                         <!-- ============================================================= CONTACT INFO ============================================================= -->
    <div class="contact-info">
        <div class="footer-logo">
            <div class="logo">
                <a href="index.php">
                    
    <h3>Shopping</h3>
                </a>
            </div><!-- /.logo -->
        
        </div><!-- /.footer-logo -->

        <div class="module-body m-t-20">
            <p class="about-us"> To leverage technology to improve everyday life in Africa by offering convenient, affordable, and safe online shopping.</p>

        </div>

    </div>          	</div>

                    <div class="col-xs-12 col-sm-6 col-md-4">
    <div class="contact-timing">
        <div class="module-heading">
            <h4 class="module-title">opening time</h4>
        </div><!-- /.module-heading -->

        <div class="module-body outer-top-xs">
            <div class="table-responsive">
                <table class="table">
                    <tbody>
                        <tr><td>Monday-Friday:</td><td class="pull-right">08.00 To 18.00</td></tr>
                        <tr><td>Saturday:</td><td class="pull-right">09.00 To 20.00</td></tr>
                        <tr><td>Sunday:</td><td class="pull-right">10.00 To 20.00</td></tr>
                    </tbody>
                </table>
            </div><!-- /.table-responsive -->
        </div><!-- /.module-body -->
    </div><!-- /.contact-timing -->
    <!-- ============================================================= CONTACT TIMING : END ============================================================= -->            	</div><!-- /.col -->

                    <div class="col-xs-12 col-sm-6 col-md-4">
                         <!-- ============================================================= INFORMATION============================================================= -->
    <div class="contact-information">
        <div class="module-heading">
            <h4 class="module-title">information</h4>
        </div><!-- /.module-heading -->

        <div class="module-body outer-top-xs">
            <ul class="toggle-footer">
                <li class="media">
                    <div class="pull-left">
                         <span class="icon fa-stack fa-lg">
                          <i class="fa fa-circle fa-stack-2x"></i>
                          <i class="fa fa-map-marker fa-stack-1x fa-inverse"></i>
                        </span>
                    </div>
                    <div class="media-body">
                        <p>Nairobi, Kenya</p>
                    </div>
                </li>

                  <li class="media">
                    <div class="pull-left">
                         <span class="icon fa-stack fa-lg">
                          <i class="fa fa-circle fa-stack-2x"></i>
                          <i class="fa fa-mobile fa-stack-1x fa-inverse"></i>
                        </span>
                    </div>
                    <div class="media-body">
                        <p>+254748005793<br>+254735106138</p>
                    </div>
                </li>

                  <li class="media">
                    <div class="pull-left">
                         <span class="icon fa-stack fa-lg">
                          <i class="fa fa-circle fa-stack-2x"></i>
                          <i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
                        </span>
                    </div>
                    <div class="media-body">
                        <span><a href="#">benjaminmakena0@gmail.com</a></span>
                    </div>
                </li>
                  
                </ul>
        </div><!-- /.module-body -->
    </div><!-- /.contact-timing -->
    <!-- ============================================================= INFORMATION : END ============================================================= -->            	</div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </div><!-- /.links-social -->
</footer>
</body>
</html>

