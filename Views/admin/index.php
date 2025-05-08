<?php
$page_title = "";
if (isset($_GET["page"])) {
  if (!empty($_GET["page"])) {
    $page_title = $_GET["page"];
  }
}



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
  <div class="app-wrapper">



    <?php
    $userName = $_SESSION["userName"];
    $currentPage = "admin";
    require_once '../layouts/header.php';
    ?>

    <!-- Side Bar -->
    <?php
    $currentPage = "admin";
    require_once '../layouts/sidebar.php';
    ?>

    <main class="app-main">
      <div class="app-content-header">
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-6">
              <h3 class="mb-0">Admin Home</h3>
            </div>
          </div>
        </div>
      </div>
      <div class="app-content">
        <div class="container-fluid">

          <?php
    


          if ($page_title == "viewBugs") {

            require_once '../viewBugs.php';

          } else if ($page_title == 'addProject') {

            require_once '../addProject.php';
          } else if ($page_title == 'addStaff') {

            require_once '../addStaff.php';
          } else if ($page_title == 'addBug') {

            require_once '../addBug.php';
          } else if ($page_title == 'viewProjects') {

            require_once '../viewProjects.php';
          } else if ($page_title == 'viewStaff') {


            require_once '../viewStaff.php';

          } else if ($page_title == 'chat') {
            require_once '../chat.php';
          } else {
            ?>

                        <div class="row">
                          <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box text-bg-primary">
                              <div class="p-4 text-center">
                                <h3 class="">View Bugs</h3>
                              </div>
                              <a href="index.php?page=viewBugs"
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
                              <a href="index.php?page=addProject"
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
                              <a href="index.php?page=addStaff"
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
                              <a href="index.php?page=addBug"
                                class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                Go to page <i class="bi bi-link-45deg"></i>
                              </a>
                            </div>
                          </div>
                          <!-- ./col -->
                        </div>

            <?php
          }
          ?>


        </div>
    </main>
    <!-- Footer -->
    <?php
    require_once '../layouts/footer.php';
    ?>

  </div>
  <script src="../assets/js/adminlte.js"></script>
</body>

</html>