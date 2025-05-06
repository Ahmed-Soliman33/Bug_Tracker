<?php
session_start();
if (!isset($_SESSION["userRole"])) {

    header("location:../auth/login.php ");
} else {
    if ($_SESSION["userRole"] != "admin") {
        header("location: ../auth/login.php ");
    }
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Admin Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
        integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI=" crossorigin="anonymous" />
    <link rel="stylesheet" href="../assets/css/adminlte.css" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        <nav class="app-header navbar navbar-expand bg-body">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Start Navbar Links-->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                    <li class="nav-item d-none d-md-block">
                        <a href="index.php" class="nav-link">Home</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-chat-text"></i>
                            <span class="navbar-badge badge text-bg-danger">3</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown user-menu">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="../assets/img/user2-160x160.jpg" class="user-image rounded-circle shadow"
                                alt="User Image" />
                            <span class="d-none d-md-inline">Ahmed Soliman</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <!--begin::Sidebar Brand-->
            <div class="sidebar-brand">
                <!--begin::Brand Link-->
                <a href="../index.html" class="brand-link">
                    <!--begin::Brand Image-->
                    <img src="../assets/img/AdminLTELogo.png" alt="AdminLTE Logo"
                        class="brand-image opacity-75 shadow" />
                    <span class="brand-text fw-light">Bug Tracker</span>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <!--begin::Sidebar Menu-->
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <p>
                                    Bugs
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="viewBugs.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>View Bugs</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="addBug.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Add Bug</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <p>
                                    Projects
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="viewProjects.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>View Projects</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="addProject.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Add Project</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <p>
                                    Staff
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="viewStaff.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>View Staff</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="addStaff.php" class="nav-link">
                                        <i class="nav-icon bi bi-circle"></i>
                                        <p>Add Staff</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">View Bugs</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="">Home /</a></li>
                            </ol>
                        </div>
                    </div>
                    <div class="">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="card-title">Bugs Table</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Bug</th>
                                            <th>Developer</th>
                                            <th style="width: 40px">Status</th>
                                            <th>Project</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="align-middle">
                                            <td>1.</td>
                                            <td>Update software</td>
                                            <td>
                                                <div class="progress progress-xs">
                                                    <div class="progress-bar progress-bar-danger" style="width: 55%">
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="badge text-bg-danger">55%</span></td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td>2.</td>
                                            <td>Clean database</td>
                                            <td>
                                                <div class="progress progress-xs">
                                                    <div class="progress-bar text-bg-warning" style="width: 70%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge text-bg-warning">70%</span></td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td>3.</td>
                                            <td>Cron job running</td>
                                            <td>
                                                <div class="progress progress-xs progress-striped active">
                                                    <div class="progress-bar text-bg-primary" style="width: 30%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge text-bg-primary">30%</span></td>
                                        </tr>
                                        <tr class="align-middle">
                                            <td>4.</td>
                                            <td>Fix and squish bugs</td>
                                            <td>
                                                <div class="progress progress-xs progress-striped active">
                                                    <div class="progress-bar text-bg-success" style="width: 90%"></div>
                                                </div>
                                            </td>
                                            <td><span class="badge text-bg-success">90%</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <ul class="pagination pagination-sm m-0 float-end">
                                    <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-content">
                <div class="container-fluid">

                </div>
        </main>
        <footer class="app-footer" style="font-size: 14px">
            <div class="float-end d-none d-sm-inline" style="font-size: 14px">
                Anything you want
            </div>
            <strong style="font-size: 14px">
                Copyright &copy; 2014-2024&nbsp;
                <a href="./general.html" class="text-decoration-none">Bug Tracker</a>.
            </strong>
            All rights reserved.
            <!--end::Copyright-->
        </footer>
    </div>

    <script src="../assets/js/adminlte.js"></script>
</body>

</html>