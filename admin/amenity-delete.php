<?php 

include 'layouts/top.php';

if (!isset($_SESSION['admin'])) {
  header('Location: '.ADMIN_URL.'login.php');
  exit;
};

try {
  $statement = $conn->prepare("SELECT * FROM properties WHERE FIND_IN_SET(?, amenities)");
  $statement->execute([$_REQUEST['id']]);
  $total = $statement->rowCount();

  if ($total) {
    throw new Exception("This amenity is used in properties. So, it can not be deleted!");
  };
  
  $statement = $conn->prepare("DELETE FROM amenities WHERE id=?");
  $statement->execute([$_REQUEST['id']]);

  $success_message = "Amenity is deleted successfully.";
  $_SESSION['success_message'] = $success_message;
  header('Location: '.ADMIN_URL.'amenity-view.php');
  exit;
} catch (Exception $e) {
  $error_message = $e->getMessage();
  $_SESSION['error_message'] = $error_message;
  header('Location: '.ADMIN_URL.'amenity-view.php');
  exit;
};

?>