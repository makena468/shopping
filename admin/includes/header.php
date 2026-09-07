<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="dashboard.php">Shopping Portal</a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0" method="post" action="search-orders.php">
                <div class="input-group">
                    <input class="form-control" type="text" name="searchinputdata" placeholder="Enter Name or Order No." aria-label="Search for..." aria-describedby="btnNavbarSearch" required />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="submit" name="search"><i class="fas fa-search"></i></button>
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="admin-profile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="change-password.php">Change Password</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </nav>

        <style>
            :root {
                --admin-primary: #4f46e5;
                --admin-primary-dark: #312e81;
                --admin-accent: #f59e0b;
                --admin-bg: #f3f6ff;
                --admin-surface: rgba(255,255,255,0.90);
                --admin-border: rgba(79, 70, 229, 0.14);
                --admin-shadow: 0 18px 38px rgba(17, 24, 39, 0.10);
            }

            body.sb-nav-fixed {
                background: linear-gradient(180deg, #f8faff 0%, #eef4ff 100%);
                color: #1f2937;
            }

            .sb-topnav {
                background: linear-gradient(135deg, #111827 0%, #1f2937 100%) !important;
                border-bottom: 1px solid rgba(255,255,255,0.08);
                box-shadow: 0 12px 30px rgba(15, 23, 42, 0.18);
            }

            .sb-topnav .navbar-brand,
            .sb-topnav .nav-link {
                color: #ffffff !important;
            }

            .sb-topnav .btn-primary {
                background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%);
                border: 0;
                border-radius: 12px;
                box-shadow: 0 12px 25px rgba(79, 70, 229, 0.18);
            }

            .sb-topnav .form-control {
                border-radius: 12px 0 0 12px;
                border: 0;
                box-shadow: none;
            }

            .sb-sidenav {
                background: linear-gradient(180deg, #0f172a 0%, #111827 100%) !important;
                border-right: 1px solid rgba(148, 163, 184, 0.18);
            }

            .sb-sidenav .nav-link,
            .sb-sidenav .sb-sidenav-menu-heading,
            .sb-sidenav-footer {
                color: rgba(255,255,255,0.82) !important;
            }

            .sb-sidenav .nav-link {
                border-radius: 12px;
                margin: 4px 10px;
                padding: 10px 14px;
                transition: all 0.2s ease;
            }

            .sb-sidenav .nav-link:hover,
            .sb-sidenav .nav-link.active {
                background: rgba(79, 70, 229, 0.18);
                color: #ffffff !important;
            }

            .sb-sidenav-menu-nested {
                margin-left: 12px;
                border-left: 1px solid rgba(148, 163, 184, 0.12);
            }

            .sb-sidenav .sb-sidenav-footer {
                background: rgba(9, 14, 24, 0.35);
                border-top: 1px solid rgba(148,163,184,0.16);
            }

            .card {
                border: 1px solid var(--admin-border) !important;
                border-radius: 20px !important;
                box-shadow: var(--admin-shadow);
                overflow: hidden;
                background: var(--admin-surface) !important;
            }

            .card .card-footer {
                background: rgba(255,255,255,0.12);
                border-top: 0;
                padding: 12px 16px;
            }

            .card .card-body {
                padding: 18px 16px 14px;
            }

            .breadcrumb {
                background: rgba(255,255,255,0.70);
                border: 1px solid var(--admin-border);
                border-radius: 14px;
                box-shadow: 0 10px 22px rgba(15,23,42,0.04);
                padding: 12px 16px;
            }

            .container-fluid {
                padding-top: 16px;
            }

            .table {
                border-radius: 18px;
                overflow: hidden;
            }

            .table thead th {
                background: linear-gradient(135deg, #eef2ff, #f8fafc);
                color: var(--admin-primary-dark);
                font-weight: 800;
                letter-spacing: 0.04em;
                text-transform: uppercase;
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--admin-primary) 0%, var(--admin-primary-dark) 100%);
                border: 0;
                border-radius: 12px;
                box-shadow: 0 12px 24px rgba(79, 70, 229, 0.18);
            }

            .btn-primary:hover {
                transform: translateY(-2px);
            }
        </style>