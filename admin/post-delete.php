<?php 

include 'layouts/top.php';

if (!isset($_SESSION['admin'])) {
  header('Location: '.ADMIN_URL.'login.php');
  exit;
};

$statement = $conn->prepare("SELECT * FROM posts WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);
unlink('../uploads/'.$result[0]['photo']);

$statement = $conn->prepare("DELETE FROM posts WHERE id=?");
$statement->execute([$_REQUEST['id']]);

$success_message = "Post is deleted successfully.";
$_SESSION['success_message'] = $success_message;
header('Location: '.ADMIN_URL.'post-view.php');
exit;

?>