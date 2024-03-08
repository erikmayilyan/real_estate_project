<?php 

include 'layouts/top.php';

if (!isset($_SESSION['admin'])) {
  header('Location: '.ADMIN_URL.'login.php');
  exit;
};

$statement = $conn->prepare("DELETE FROM packages WHERE id=?");
$statement->execute([$_REQUEST['id']]);

$success_message = "Package is deleted successfully.";
$_SESSION['$success_message'] = $success_message;
header('Location: '.ADMIN_URL.'package-view.php');
exit;
?>
