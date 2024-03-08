<?php 

include 'layouts/top.php';

if (!isset($_SESSION['admin'])) {
  header('Location: '.ADMIN_URL.'login.php');
  exit;
};

$statement = $conn->prepare("DELETE FROM messages WHERE id=?");
$statement->execute([$_REQUEST['id']]);

$statement = $conn->prepare("DELETE FROM messages_replies WHERE message_id=?");
$statement->execute([$_REQUEST['id']]);

$success_message = "Message is deleted successfully.";
$_SESSION['success_message'] = $success_message;
header('Location: '.ADMIN_URL.'message-view.php');
exit;

?>