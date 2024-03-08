<?php 

include 'layouts/top.php';

if (!isset($_SESSION['admin'])) {
  header('Location: '.ADMIN_URL.'login.php');
  exit;
};

try {
  $statement = $conn->prepare("SELECT * FROM orders WHERE id=? AND currently_active=?");
  $statement->execute([$_REQUEST['id'], 1]);
  $total = $statement->rowCount();

  if ($total) {
    throw new Exception("You can not delete order that is currently active.");
  };
  
  $statement = $conn->prepare("DELETE FROM orders WHERE id=?");
  $statement->execute([$_REQUEST['id']]);

  $success_message = "Order is deleted successfully.";
  $_SESSION['success_message'] = $success_message;
  header('Location: '.ADMIN_URL.'order-view.php');
  exit;

} catch (Exception $e) {

  $error_message = $e->getMessage();
  $_SESSION['error_message'] = $error_message;
  header('Location: '.ADMIN_URL.'order-view.php');
  exit;

};

?>