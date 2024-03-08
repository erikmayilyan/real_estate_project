<?php 

include 'layouts/top.php';

if (!isset($_SESSION['admin'])) {
  header('Location: '.ADMIN_URL.'login.php');
  exit;
};

try {
  $statement = $conn->prepare("DELETE FROM wishlists WHERE customer_id=?");
  $statement->execute([$_REQUEST['id']]);

  $statement = $conn->prepare("DELETE FROM messages WHERE customer_id=?");
  $statement->execute([$_REQUEST['id']]);

  $statement = $conn->prepare("DELETE FROM messages_replies WHERE customer_id=?");
  $statement->execute([$_REQUEST['id']]);

  $statement = $conn->prepare("SELECT * FROM customers WHERE id=?");
  $statement->execute([$_REQUEST['id']]);
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    $photo = $row['photo'];
    if ($photo != '') {
      unlink('../uploads/'.$photo);
    }
  };

  $statement = $conn->prepare("DELETE FROM customers WHERE id=?");
  $statement->execute([$_REQUEST['id']]);

  $success_message = "Customer is deleted successfully.";
  $_SESSION['success_message'] = $success_message;
  header('Location: '.ADMIN_URL.'customer-view.php');
  exit;
} catch (Exception $e) {
  $error_message = $e->getMessage();
  $_SESSION['error_message'] = $error_message;
  header('Location: '.ADMIN_URL.'customer-view.php');
  exit;
};

?>