<?php
include 'layouts/top.php'; 

if (isset($_SESSION['admin'])) {
    header('Location: ' . ADMIN_URL . 'dashboard.php');
    exit; 
}

if (isset($_POST['form_login'])) {
  try {
    if (empty($_POST['email'])) {
        throw new Exception('Email can not be empty!');
    };
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      throw new Exception('Email is invalid!');
    };
    if ($_POST['password'] == '') {
      throw new Exception('Password can not be empty');
    };

    $statement = $conn->prepare('SELECT * FROM admins WHERE email=?');
    $statement->execute([$_POST['email']]);
    $total = $statement->rowCount();
    if (!$total) {
      throw new Exception('Email is not found');
    } else {
      $result = $statement->fetch(PDO::FETCH_ASSOC);
      if (!$result) {
          throw new Exception('Email is not found');
      }
      $password = $result['password'];
      if (!password_verify($_POST['password'], $password)) {
          throw new Exception('Password does not match!');
      }
      $_SESSION['admin'] = $result;
      header('Location: ' . ADMIN_URL . 'dashboard.php');
      exit();
    };

  } catch (Exception $e) {
    $error_message = $e->getMessage();
  }
};
?>

<section class="section">
    <div class="container container-login">
        <div class="row">
            <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                <div class="card card-primary border-box">
                    <div class="card-header card-header-auth">
                        <h4 class="text-center">Admin Panel Login</h4>
                    </div>
                    <div class="card-body card-body-auth">
                        <form method="POST" action="">
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email Address" autocomplete="off" value="" autofocus>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="password"  placeholder="Password" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg w_100_p" name="form_login">
                                    Login
                                </button>
                            </div>
                            <div class="form-group">
                                <div>
                                    <a href="<?php echo ADMIN_URL; ?>forget-password.php">
                                        Forget Password?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'layouts/footer.php';
?>