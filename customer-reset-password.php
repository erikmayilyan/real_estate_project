<?php 

include 'header.php';

$state = $conn->prepare('SELECT * FROM customers WHERE email=? AND token=?');
$state->execute([$_REQUEST['email'], $_REQUEST['token']]);
$total = $state->rowCount();
if (!$total) {
  header('Location: '.BASE_URL.'customer-login');
  exit;
};

if (isset($_POST['form_reset_password'])) {
  try {
    if ($_POST['password'] == '' || $_POST['retype_password'] == '') {
      throw new Exception('Password can not be empty!');
    };

    if ($_POST['password'] != $_POST['retype_password']) {
      throw new Exception('Passwords do not match');
    };

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $statement = $conn->prepare('UPDATE customers SET token=?, password=? WHERE email=? AND token=?');
    $statement->execute(['', $password, $_REQUEST['email'], $_REQUEST['token']]);

    $_SESSION['success_message'] = 'Password got resseted successfully! You can login now!';

    header('Location: '.BASE_URL.'customer-login');
    exit();
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
                <h2>Customer Reset Password</h2>
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
                            <label for="" class="form-label">Password *</label>
                            <input type="password" name="password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Retype Password *</label>
                            <input type="password" name="retype_password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <button type="submit" name="form_reset_password" class="btn btn-primary bg-website">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php' ?>