<?php
require_once '../../Models/User.php';
require_once '../../Controllers/AuthController.php';

if (!isset($_SESSION["userId"])) {
  session_start();
}
$errMsg = "";
if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['name'])) {
  if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['name'])) {
    $user = new User($_POST['name'], $_POST['email'], $_POST['password'], "customer");
    $auth = new AuthController;
    if ($auth->register($user)) {
      header("location: ../customer/index.php");
      exit();
    } else {
      $errMsg = $_SESSION["errMsg"] ?? "Registration failed.";
    }
  } else {
    $errMsg = "Please fill all fields";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Register Page</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="title" content="Register Page" />
  <link rel="stylesheet" href="../assets/css/adminlte.css" />
</head>

<body class="register-page bg-body-secondary">
  <div class="register-box">
    <div class="card card-outline card-primary">
      <div class="card-header">
        <a href="../index2.html" class="link-dark text-center link-offset-2 link-opacity-100 link-opacity-50-hover">
          <h1 class="mb-0"><b>Bug Tracker</b>App</h1>
        </a>
      </div>
      <div class="card-body register-card-body">
        <p class="register-box-msg">Register a new membership</p>
        <?php if (!empty($errMsg)): ?>
          <div class="alert alert-danger"><?php echo htmlspecialchars($errMsg); ?></div>
        <?php endif; ?>
        <form id="formAuthentication" class="mb-3" action="register.php" method="POST">
          <div class="input-group mb-1">
            <div class="form-floating">
              <input name="name" id="registerFullName" type="text" class="form-control" placeholder=""
                value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" />
              <label for="registerFullName">Full Name</label>
            </div>
            <div class="input-group-text">
              <span class="bi bi-person"></span>
            </div>
          </div>
          <div class="input-group mb-1">
            <div class="form-floating">
              <input name="email" id="registerEmail" type="email" class="form-control" placeholder=""
                value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" />
              <label for="registerEmail">Email</label>
            </div>
            <div class="input-group-text">
              <span class="bi bi-envelope"></span>
            </div>
          </div>
          <div class="input-group mb-1">
            <div class="form-floating">
              <input name="password" id="registerPassword" type="password" class="form-control" placeholder="" />
              <label for="registerPassword">Password</label>
            </div>
            <div class="input-group-text">
              <span class="bi bi-lock-fill"></span>
            </div>
          </div>
          <div class="row">
            <div class="col-8 d-inline-flex align-items-center">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" />
                <label class="form-check-label" for="flexCheckDefault">
                  I agree to the terms
                </label>
              </div>
            </div>
            <div class="col-4">
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Sign Up</button>
              </div>
            </div>
          </div>
        </form>
        <p class="mb-0">
          <a href="login.php" class="link-primary text-center">
            I already have an account
          </a>
        </p>
      </div>
    </div>
  </div>
  <script src="../assets/js/adminlte.js"></script>
</body>

</html>