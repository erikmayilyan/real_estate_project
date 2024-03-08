<?php

include 'layouts/top.php';
unset($_SESSION['admin']);
header('Location: '.ADMIN_URL.'login.php');
exit;

?>