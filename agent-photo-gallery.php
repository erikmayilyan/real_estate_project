<?php 

include 'header.php';

if (!isset($_SESSION['agent'])) {
  header('Location: '.BASE_URL.'agent-login');
  exit;
};

$statement = $conn->prepare("SELECT * FROM properties WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['form_submit'])) {
  try {

    $statement = $conn->prepare("SELECT * 
                                 FROM orders 
                                 JOIN packages
                                 ON orders.package_id = packages.id
                                 WHERE orders.agent_id=? AND orders.currently_active=?");
    $statement->execute(array($_SESSION['agent']['id'], 1));
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
      $allowed_photos = $row['allowed_photos'];
    };

    $statement = $conn->prepare("SELECT * FROM property_photos WHERE property_id=?");
    $statement->execute(array($_REQUEST['id']));
    $total_photos = $statement->rowCount();
    if ($total_photos == $allowed_photos) {
      throw new Exception("You have reached your maximum limit of photos. Please upgrade you rpackage to upload more photos or delete existing photos to add new photos.");
    };

    $path = $_FILES['photo']['name'];
    $path_tmp = $_FILES['photo']['tmp_name'];

    if ($path == '') {
      throw new Exception("Please upload a photo");
    };

    $extension = pathinfo($path, PATHINFO_EXTENSION);
    $filename = time().".".$extension;

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $path_tmp);

    if ($mime != 'image/jpeg' && $mime != 'image/png') {
      throw new Exception("Please upload a valid photo");
    };

    if ($_SESSION['admin']['photo'] != '') {
      unlink('../uploads/'.$_SESSION['admin']['photo']);
    };
    move_uploaded_file($path_tmp, 'uploads/'.$filename);
    
    $statement = $conn->prepare("INSERT INTO property_photos (property_id, photo) VALUES (?, ?)");

    $statement->execute(array($_REQUEST['id'], $filename));

    $success_message = "Location is added successfully";

    $_SESSION['success_message'] = $success_message;
    header('Location: '.BASE_URL.'agent-photo-gallery/'.$_REQUEST['id']);
    exit;

  } catch (Exception $e) {
    $error_message = $e->getMessage();
  }
};

if (isset($_POST['form_delete'])) {
  $statement = $conn->prepare("SELECT * FROM property_photos WHERE id=?");
  $statement->execute([$_REQUEST['gallery_id']]);
  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
  $total = $statement->rowCount();
  if (!$total) {
    echo '<div class="col-md-12 text-danger"><p class="text-center">No photo added yet.</p></div>';
  }

  foreach ($result as $row) {
    unlink('uploads/'.$row['photo']);
  };

  $statement = $conn->prepare("DELETE FROM property_photos WHERE id=?");
  $statement->execute([$_REQUEST['gallery_id']]);
  
  $success_message = "Photo is deleted successfully.";
  $_SESSION['success_message'] = $success_message;
  header('Location: '.BASE_URL.'agent-photo-gallery/'.$_REQUEST['id']);
  exit;
};

?>

<div class="page-top" style="background-image: url('<?php echo BASE_URL; ?>')uploads/banner.jpg">
  <div class="bg"></div>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2>Photo Gallery Of "<?php echo $result[0]['name']; ?>"</h2>
      </div>
    </div>
  </div>
</div>

<div class="page-content user-panel">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <?php include 'agent-sidebar.php'; ?>
            </div>
            <div class="col-lg-9 col-md-12">
                <h4>Add Photo</h4>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <input type="file" name="photo" />
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-sm" name="form_submit" value="Submit" />
                        </div>
                    </div>
                </form>

                <h4 class="mt-4">Existing Photos</h4>
                <div class="photo-all">
                    <div class="row">
                        <?php
                            $statement = $conn->prepare("SELECT * FROM property_photos WHERE property_id=?");
                            $statement->execute([$_REQUEST['id']]);
                            $result1 = $statement->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result1 as $row) {
                        ?>
                          <div class="col-md-6 col-lg-3">
                              <div class="item item-delete">
                                  <a href="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo']; ?>" class="magnific">
                                      <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo']; ?>" alt="" />
                                      <div class="icon">
                                          <i class="fas fa-plus"></i>
                                      </div>
                                      <div class="bg"></div>
                                  </a>
                              </div>
                              <form action="" method="post">
                                <input type="hidden" name="gallery_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" href="" name="form_delete" class="badge bg-danger mb_20 custom-delete-button" onClick="return confirm('Are you sure?');">Delete</button>
                              </form>
                          </div>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php' ?>