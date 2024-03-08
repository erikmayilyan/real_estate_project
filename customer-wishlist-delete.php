<?php 

include 'header.php';

if (!isset($_SESSION['customer'])) {
  header('Location: '.BASE_URL.'customer-login');
  exit;
};

$statement = $conn->prepare("DELETE FROM wishlists WHERE id=?");
$statement->execute([$_REQUEST['id']]);

$success_message = "Wishlist is deleted successfully.";
$_SESSION['success_message'] = $success_message;
header('Location: '.BASE_URL.'customer-wishlist');
exit;

?>