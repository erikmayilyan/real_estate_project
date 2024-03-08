<?php 

include 'layouts/top.php';

if (!isset($_SESSION['admin'])) {
  header('Location: '.ADMIN_URL.'login.php');
  exit;
};

try {

  $statement = $conn->prepare("SELECT * FROM properties WHERE location_id=?");
  $statement->execute([$_REQUEST['id']]);
  $total = $statement->rowCount();

  if ($total) {
    throw new Exception("You can not delete this location, because one or more properties still exist under this location!");
  };

  $statement = $conn->prepare("SELECT * FROM locations WHERE id=?");
  $statement->execute([$_REQUEST['id']]);
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  unlink('../uploads/'.$result[0]['photo']);

  $statement = $conn->prepare("DELETE FROM locations WHERE id=?");
  $statement->execute([$_REQUEST['id']]);

  $success_message = "Location is deleted successfully.";
  $_SESSION['success_message'] = $success_message;
  header('Location: '.ADMIN_URL.'location-view.php');
  exit;

} catch (Exception $e) {

  $error_message = $e->getMessage();
  $_SESSION['error_message'] = $error_message;
  header('Location: '.ADMIN_URL.'location-view.php');
  exit;

}

?>
