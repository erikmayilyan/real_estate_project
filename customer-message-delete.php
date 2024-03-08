<?php 

include 'header.php';

if (!isset($_SESSION['customer'])) {
  header('Location: '.BASE_URL.'customer-login');
  exit;
};

$statement = $conn->prepare("DELETE FROM messages WHERE id=? AND customer_id=?");
$statement->execute([$_REQUEST['id'], $_SESSION['customer']['id']]);
$total = $statement->rowCount();
if (!$total) {
  header('Location: '.BASE_URL.'customer-login');
  exit;
} else {
  $statement = $conn->prepare("DELETE FROM messages WHERE id=? AND customer_id=?");
  $statement->execute([$_REQUEST['id'], $_SESSION['customer']['id']]);
  
  $statement = $conn->prepare("DELETE FROM messages_replies WHERE message_id=? AND customer_id=?");
  $statement->execute([$_REQUEST['id'], $_SESSION['customer']['id']]);
  
  $success_message = "Message is deleted successfully.";
  $_SESSION['success_message'] = $success_message;
  header('Location: '.BASE_URL.'customer-messages');
  exit;
};

?>