<?php

include 'header.php';
unset($_SESSION['agent']);
$_SESSION['success_message'] = "You are logged out successfully!";
header('Location: '.BASE_URL.'agent-login');
exit;

?>
