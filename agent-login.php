<?php 

include 'header.php';

if (isset($_SESSION['agent'])) {
  header('Location: '.BASE_URL.'agent-dashboard');
  exit;
}

if (isset($_POST['form_submit'])) {
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

    $statement = $conn->prepare('SELECT * FROM agents WHERE email=? AND status=?');
    $statement->execute([$_POST['email'], 1]);
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
      $_SESSION['agent'] = $result;
      header('Location: ' . BASE_URL . 'agent-dashboard');
      exit();
    };

  } catch (Exception $e) {
    $error_message = $e->getMessage();
  }
};

?>

<div class="page-top" style="background-image: url('<?php echo BASE_URL; ?>uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Agent Login</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                <div class="login-form">
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="" class="form-label">Email Address *</label>
                            <input type="text" name="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Password *</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary bg-website" name="form_submit">
                                Login
                            </button>
                            <a href="<?php echo BASE_URL; ?>agent-forget-password" class="primary-color">Forget Password?</a>
                        </div>
                        <div class="mb-3">
                            <a href="<?php echo BASE_URL; ?>agent-registration" class="primary-color">Don't have an account? Create Account</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php' ?>