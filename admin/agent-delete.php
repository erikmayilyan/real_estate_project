<?php 

include 'layouts/top.php';

if (!isset($_SESSION['admin'])) {
  header('Location: '.ADMIN_URL.'login.php');
  exit;
};

try {

  $statement = $conn->prepare("DELETE FROM messages WHERE agent_id=?");
  $statement->execute([$_REQUEST['id']]);

  $statement = $conn->prepare("DELETE FROM messages_replies WHERE agent_id=?");
  $statement->execute([$_REQUEST['id']]);

  $statement = $conn->prepare("SELECT * FROM agents WHERE id=?");
  $statement->execute([$_REQUEST['id']]);
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    $photo = $row['photo'];
    if ($photo != '') {
      unlink('../uploads/'.$photo);
    }
  };

  $statement = $conn->prepare("DELETE FROM agents WHERE id=?");
  $statement->execute([$_REQUEST['id']]);

  $statement = $conn->prepare("DELETE FROM orders WHERE agent_id=?");
  $statement->execute([$_REQUEST['id']]);

  $statement = $conn->prepare("SELECT * FROM properties WHERE agent_id=?");
  $statement->execute([$_REQUEST['id']]);
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  foreach ($result as $row) {
    unlink('../uploads/'.$row['featured_photo']);

    $statement1 = $conn->prepare("SELECT * FROM property_photos WHERE property_id=?");
    $statement1->execute([$row['id']]);
    $result1 = $statement1->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result1 as $row1) {
      unlink('../uploads/'.$row1['photo']);
    };

    $statement1 = $conn->prepare("DELETE FROM property_photos WHERE property_id=?");
    $statement1->execute([$row['id']]);

    $statement1 = $conn->prepare("DELETE FROM property_videos WHERE property_id=?");
    $statement1->execute([$row['id']]);
  };

  $statement = $conn->prepare("DELETE FROM properties WHERE agent_id=?");
  $statement->execute([$_REQUEST['id']]);

  $success_message = "Agent is deleted successfully.";
  $_SESSION['success_message'] = $success_message;
  header('Location: '.ADMIN_URL.'agent-view.php');
  exit;
} catch (Exception $e) {
  $error_message = $e->getMessage();
  $_SESSION['error_message'] = $error_message;
  header('Location: '.ADMIN_URL.'agent-view.php');
  exit;
};

?>