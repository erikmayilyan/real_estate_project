<?php
ob_start();
session_start();
include 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$arr = array();

$statement = $conn->prepare("SELECT * FROM admins WHERE id=?");
$statement->execute(array(1));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
  $admin_email = $row['email'];
};

if (isset($_POST['email'])) {
    try {
        if ($_POST['name'] == '') {
            throw new Exception("Name can not be empty");
        };

        if ($_POST['email'] == '') {
            throw new Exception("Email is required");
        };

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Email is invalid");
        };

        if ($_POST['message'] == '') {
            throw new Exception("Message can not be empty");
        };

        $email_message = 'Name: '.$_POST['name'].'<br>';
        $email_message .= 'Email: '.$_POST['email'].'<br>';
        $email_message .= 'Message: <br>'.nl2br($_POST['message']).'<br>';

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = SMTP_ENCRYPTION;
        $mail->Port = SMTP_PORT;
        $mail->setFrom(SMTP_FROM);
        $mail->addAddress($admin_email);
        $mail->isHTML(true);
        $mail->Subject = 'Contact Form Message';
        $mail->Body = $email_message;
        $mail->SMTPOptions = [
          'ssl' => [
              'verify_peer' => false,
              'verify_peer_name' => false,
              'allow_self_signed' => true,
          ],
        ];
        $mail->send();

        $arr['success_message'] = 'Your email is sent successfully! You will get reply soon.';
    } catch (Exception $e) {
        $error_message = $e->getMessage();
        $arr['error_message'] = $error_message;
    }
};

echo json_encode($arr);

?>