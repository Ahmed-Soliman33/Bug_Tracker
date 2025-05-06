<?php
require_once '../../Models/User.php';
require_once '../../Controllers/AuthController.php';
$errMsg = "";

if (isset($_GET["logout"])) {
  session_start();
  session_destroy();
}
if (isset($_POST['email']) && isset($_POST['password'])) {
  if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $user = new User;
    $auth = new AuthController;
    $user->email = $_POST['email'];
    $user->password = $_POST['password'];
    if (!$auth->login($user)) {
      if (!isset($_SESSION["userId"])) {
        session_start();
      }
      $errMsg = $_SESSION["errMsg"];
    } else {
      if (!isset($_SESSION["userId"])) {
      }
      session_start();
      if ($_SESSION["userRole"] == "admin") {
        header("location: ../admin/index.php");
      } else if ($_SESSION["userRole"] == "staff") {
        header("location: ../staff/index.php");
      } else {
        header("location: ../customer/index.php");
      }

    }


  } else {
    $errMsg = "Please fill all fields";
  }
}

?>




<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Login - Bug Tracker</title>

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="title" content="Login page" />


  <link rel="stylesheet" href="../assets/css/adminlte.css" />
</head>

<body class="login-page bg-body-secondary">
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <a href="../index2.html" class="link-dark text-center link-offset-2 link-opacity-100 link-opacity-50-hover">
          <h1 class="mb-0"><b>Bug Tracker</b>App</h1>
        </a>
      </div>
      <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form id="formAuthentication" class="mb-3" action="login.php" method="POST">
          <div class="input-group mb-1">
            <div class="form-floating">
              <input id="loginEmail" type="email" class="form-control" name="email" value=""
                placeholder="nter your Email" />
              <label for="loginEmail">Email</label>
            </div>
            <div class="input-group-text"><span class="bi bi-envelope"></span></div>
          </div>
          <div class="input-group mb-1">
            <div class="form-floating">
              <input id="loginPassword" type="password" class="form-control" placeholder="Enter Your Password"
                name="password" />
              <label for="loginPassword">Password </label>
            </div>
            <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
          </div>
          <!--begin::Row-->
          <div class="row">
            <div class="col-8 d-inline-flex align-items-center">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                <label class="form-check-label" for="flexCheckDefault"> Remember Me </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Sign In</button>
              </div>
            </div>
            <!-- /.col -->
          </div>
          <!--end::Row-->
        </form>
        <p class="mb-0">
          <a href="register.php" class="text-center"> Register a new acount </a>
        </p>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <script src="../assets/js/adminlte.js"></script>
</body>

</html>