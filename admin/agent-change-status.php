<?php 

include 'layouts/top.php';

if (!isset($_SESSION['admin'])) {
  header('Location: '.ADMIN_URL.'login.php');
  exit;
};

$statement = $conn->prepare("SELECT * FROM agents WHERE id=?");
$statement->execute(array($_REQUEST['id']));
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
foreach ($result as $row) {
  $status = $row['status'];
}

if ($status == 1) {
  $statement = $conn->prepare("UPDATE agents SET status=? WHERE id=?");
  $statement->execute(array(0, $_REQUEST['id']));
  header('Location: '.ADMIN_URL.'agent-view.php');
} else {
  $statement = $conn->prepare("UPDATE agents SET status=? WHERE id=?");
  $statement->execute(array(1, $_REQUEST['id']));
  header('Location: '.ADMIN_URL.'agent-view.php');
}

?>