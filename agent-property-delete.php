<?php 

include 'header.php';

if (!isset($_SESSION['agent'])) {
  header('Location: '.BASE_URL.'agent-login');
  exit;
};

$statement = $conn->prepare("SELECT * FROM properties WHERE id=? AND agent_id=?");
$statement->execute([$_REQUEST['id'], $_SESSION['agent']['id']]);
$total = $statement->rowCount();
if (!$total) {
  header('Location: '.BASE_URL.'agent-login');
  exit;
};

$statement = $conn->prepare("SELECT * FROM properties WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
unlink('uploads/'.$result[0]['featured_photo']);

$statement = $conn->prepare("DELETE FROM properties WHERE id=?");
$statement->execute([$_REQUEST['id']]);

$statement = $conn->prepare("SELECT * FROM property_photos WHERE property_id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
  unlink('uploads/'.$row['photo']);
};

$statement = $conn->prepare("DELETE FROM property_photos WHERE property_id=?");
$statement->execute([$_REQUEST['id']]);

$statement = $conn->prepare("DELETE FROM property_videos WHERE property_id=?");
$statement->execute([$_REQUEST['id']]);

$success_message = "Property is deleted successfully.";
$_SESSION['$success_message'] = $success_message;
header('Location: '.BASE_URL.'agent-properties.php');
exit;

?>