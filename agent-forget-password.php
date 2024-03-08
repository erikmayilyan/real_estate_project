<?php 

include 'header.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['agent'])) {
  header('Location: '.BASE_URL.'agent-login');
  exit;
};

if (isset($_POST['form_submit'])) {
  try {
    if (empty($_POST['email'])) {
        throw new Exception('Email can not be empty!');
    };
    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      throw new Exception('Email is invalid!');
    };

    $statement = $conn->prepare('SELECT * FROM agents WHERE email=?');
    $statement->execute([$_POST['email']]);
    $total = $statement->rowCount();
    if (!$total) {
      throw new Exception('Email is not found');
    };

    $token = time();
    $statement = $conn->prepare('UPDATE agents SET token=? WHERE email=?');
    $statement->execute([$token, $_POST['email']]);

    $email_message = "Please click the following link in order to reset the password: ";
    $email_message .= '<a href="'.BASE_URL.'agent-reset-password.php?email='.$_POST['email'].'&token='.$token.'">Reset Password</a>';

    $mail = new PHPMailer(true);
    try {
      $mail->isSMTP();
      $mail->Host = SMTP_HOST;
      $mail->SMTPAuth = true;
      $mail->Username = SMTP_USERNAME;
      $mail->Password = SMTP_PASSWORD;
      $mail->SMTPSecure = SMTP_ENCRYPTION;
      $mail->Port = SMTP_PORT;
      $mail->setFrom(SMTP_FROM);
      $mail->addAddress($_POST['email']);
      $mail->isHTML(true);
      $mail->Subject = 'Reset Password';
      $mail->Body = $email_message;
      $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true,
        ],
      ];
      $mail->send();
      $success_message = 'Please check your email and follow the instruction to reset the password!';
    } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo} ";
    }
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
                <h2>Agent Forget Password</h2>
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
                            <button type="submit" name="form_submit" class="btn btn-primary bg-website">
                                Submit
                            </button>
                            <a href="<?php echo BASE_URL; ?>agent-login" class="primary-color">Back to Login Page</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php' ?>