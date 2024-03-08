<?php

include_once('header.php');
if (!isset($_REQUEST['email']) || !isset($_REQUEST['token'])) {
  header('Location: ' . BASE_URL);
  exit;
};

$statement = $conn->prepare("SELECT * FROM agents WHERE email=? AND token=?");
$statement->execute([$_REQUEST['email'], $_REQUEST['token']]);
$total = $statement->rowCount();

if ($total) {
  $statement = $conn->prepare("UPDATE agents SET token=?, status=? WHERE email=? AND token=?");
  $statement->execute(['', 1, $_REQUEST['email'], $_REQUEST['token']]);
  $_SESSION['success_message'] = 'Registration verified successfully. Please login now!';
  header('Location: '.BASE_URL.'agent-login');
  exit;
} else {
  header('Location: '.BASE_URL);
  exit;
};
