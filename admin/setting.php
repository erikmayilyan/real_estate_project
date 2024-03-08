<?php 

include 'layouts/top.php';

if (!isset($_SESSION['admin'])) {
  header('Location: '.ADMIN_URL.'login.php');
  exit;
};

if (isset($_POST['form_update'])) {
  try {
    // if ($_POST['terms'] == "") {
    //   throw new Exception("Terms can not be empty");
    // };
    $path_logo = $_FILES['logo']['name'];
    $path_tmp_logo = $_FILES['logo']['tmp_name'];

    if ($path_logo != '') {
      $extension_logo = pathinfo($path_logo, PATHINFO_EXTENSION);
      $filename_logo = "logo.".$extension_logo;

      $finfo_logo = finfo_open(FILEINFO_MIME_TYPE);
      $mime_logo = finfo_file($finfo_logo, $path_tmp_logo);

      if ($mime_logo != 'image/jpeg' && $mime_logo != 'image/png') {
        throw new Exception("Please upload a valid logo");
      };

      unlink('../uploads/'.$_POST['current_logo']);
      move_uploaded_file($path_tmp_logo, '../uploads/'.$filename_logo);
    } else {
      $filename_logo = $_POST['current_logo'];
    };

    $path_favicon = $_FILES['logo']['name'];
    $path_tmp_favicon = $_FILES['logo']['tmp_name'];

    if ($path_favicon != '') {
      $extension_favicon = pathinfo($path_favicon, PATHINFO_EXTENSION);
      $filename_favicon = "favicon.".$extension_favicon;

      $finfo_favicon = finfo_open(FILEINFO_MIME_TYPE);
      $mime_favicon = finfo_file($finfo_favicon, $path_tmp_favicon);

      if ($mime_favicon != 'image/jpeg' && $mime_favicon != 'image/png') {
        throw new Exception("Please upload a valid favicon");
      };

      unlink('../uploads/'.$_POST['current_favicon']);
      move_uploaded_file($path_tmp_favicon, '../uploads/'.$filename_favicon);
    } else {
      $filename_favicon = $_POST['current_favicon'];
    };
    
    $statement = $conn->prepare("UPDATE settings SET logo=?, favicon=? WHERE id=?");
    $statement->execute([$filename_logo, $filename_favicon, 1]);

    $success_message = "Data is updated successfully";

    $_SESSION['success_message'] = $success_message;
    header('Location: '.ADMIN_URL.'setting.php');
    exit;

  } catch (Exception $e) {
    $error_message = $e->getMessage();
  }
};

$statement = $conn->prepare("SELECT * FROM settings WHERE id=?");
$statement->execute([1]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Setting</h1>
    </div>
    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="current_logo" value="<?php echo $result[0]['logo']; ?>">
                <input type="hidden" name="current_favicon" value="<?php echo $result[0]['favicon']; ?>">
                <div class="partial-item">
                    <div class="form-group mb-3">
                        <label>Existing Logo</label>
                        <div>
                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo $result[0]['logo']; ?>" alt="" class="w_100">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Change Logo</label>
                        <div>
                            <input type="file" name="logo">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Existing Favicon</label>
                        <div>
                            <img src="<?php echo BASE_URL; ?>uploads/<?php echo $result[0]['favicon']; ?>" alt="" class="w_100">
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Change Favicon</label>
                        <div>
                            <input type="file" name="logo">
                        </div>
                    </div>
                </div>
                <!-- <div class="partial-item">
                    <div class="form-group mb-3">
                        <label>Heading</label>
                        <input type="text" class="form-control" name="" value="Our Services">
                    </div>
                    <div class="form-group mb-3">
                        <label>Subheading</label>
                        <input type="text" class="form-control" name="" value="You will get some awesome services from us">
                    </div>
                    <div class="form-group mb-3">
                        <label>Status</label>
                        <div class="toggle-container">
                            <input type="checkbox" data-toggle="toggle" data-on="Show" data-off="Hide" data-onstyle="success" data-offstyle="danger" name="" value="Show" checked>
                        </div>
                    </div>
                </div> -->
                <div class="form-group mt_30">
                    <button type="submit" class="btn btn-primary" name="form_update">Update</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include 'layouts/footer.php' ?>