<?php 

include 'layouts/top.php';

if (!isset($_SESSION['admin'])) {
  header('Location: '.ADMIN_URL.'login.php');
  exit;
};

try {

  $statement = $conn->prepare("SELECT * FROM properties WHERE type_id=?");
  $statement->execute([$_REQUEST['id']]);
  $total = $statement->rowCount();

  if ($total) {
    throw new Exception("You can not delete this type, because one or more properties still exist under this type!");
  };

  $statement = $conn->prepare("DELETE FROM types WHERE id=?");
  $statement->execute([$_REQUEST['id']]);

  $success_message = "Type is deleted successfully.";
  $_SESSION['success_message'] = $success_message;
  header('Location: '.ADMIN_URL.'type-view.php');
  exit;

} catch (Exception $e) {

  $error_message = $e->getMessage();
  $_SESSION['error_message'] = $error_message;
  header('Location: '.ADMIN_URL.'type-view.php');
  exit;

};

?>