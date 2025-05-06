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
              <img src="../assets/img/user2-160x160.jpg" class="user-image rounded-circle shadow" alt="User Image" />
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
          <img src="../assets/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow" />
          <span class="brand-text fw-light">Bug Tracker</span>
        </a>
      </div>
      <div class="sidebar-wrapper">
        <nav class="mt-2">
          <!--begin::Sidebar Menu-->
          <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
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
            <li class="nav-item">
              <a href="../auth/login.php" class="nav-link text-danger">
                <p>
                  Logout
                </p>
                <i class="nav-icon bi bi-box-arrow-in-right"></i>
              </a>
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
              <h3 class="mb-0">Admin Home</h3>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="">Home /</a></li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="app-content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box text-bg-primary">
                <div class="p-4 text-center">
                  <h3 class="">View Bugs</h3>
                </div>
                <a href="viewBugs.php"
                  class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                  Go to page <i class="bi bi-link-45deg"></i>
                </a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box text-bg-success">
                <div class="p-4 text-center">
                  <h3 class="">Add Project</h3>
                </div>
                <a href="addProject.php"
                  class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                  Go to page <i class="bi bi-link-45deg"></i>
                </a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box text-white bg-warning">
                <div class="p-4 text-center">
                  <h3 class="">Add Staff</h3>
                </div>
                <a href="addStaff.php"
                  class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                  Go to page <i class="bi bi-link-45deg"></i>
                </a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box text-bg-danger">
                <div class="p-4 text-center">
                  <h3 class="">Add Bug</h3>
                </div>
                <a href="addBug.php"
                  class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                  Go to page <i class="bi bi-link-45deg"></i>
                </a>
              </div>
            </div>
            <!-- ./col -->
          </div>
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