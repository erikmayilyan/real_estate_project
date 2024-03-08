<?php include 'header.php'; ?>

<?php

if (!isset($_SESSION['customer'])) {
  header('Location: '.BASE_URL.'customer-login');
  exit;
};

try {
  $statement = $conn->prepare("SELECT * FROM wishlists WHERE customer_id=? AND property_id=?");
  $statement->execute([$_SESSION['customer']['id'], $_REQUEST['id']]);
  $total = $statement->rowCount();
  if ($total) {
    throw new Exception('Property has already been added to your wishlist.');
  };

  $statement = $conn->prepare("INSERT INTO wishlists (customer_id, property_id) VALUES (?,?)");
  $statement->execute([$_SESSION['customer']['id'], $_REQUEST['id']]);
  $_SESSION['success_message'] = 'Property is added to your wishlist.';
  header('Location: '.BASE_URL.'customer-wishlist');
  exit;
} catch (Exception $e) {
  $_SESSION['error_message'] = $e->getMessage();
  header('Location: '.BASE_URL.'customer-wishlist');
  exit;
};


?>

