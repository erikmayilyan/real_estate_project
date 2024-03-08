<?php 

include 'layouts/top.php';

if (!isset($_SESSION['admin'])) {
  header('Location: '.ADMIN_URL.'login.php');
  exit;
};

if (isset($_POST['form_submit'])) {
  try {
    if ($_POST['name'] == "") {
      throw new Exception("Name can not be empty");
    };

    $statement = $conn->prepare("SELECT * FROM amenities WHERE name=? AND id!=?");
    $statement->execute([$_POST['name'], $_REQUEST['id']]);
    $total = $statement->rowCount();
    if ($total) {
      throw new Exception("Name already exists");
    };
    
    $statement = $conn->prepare("UPDATE amenities SET name=? WHERE id=?");
    $statement->execute([$_POST['name'], $_REQUEST['id']]);

    $success_message = "Amenity is updated successfully";

    $_SESSION['success_message'] = $success_message;
    header('Location: '.ADMIN_URL.'amenity-edit.php?id='.$_REQUEST['id']);
    exit;

  } catch (Exception $e) {
    $error_message = $e->getMessage();
  }
};

$statement = $conn->prepare("SELECT * FROM amenities WHERE id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="main-content">
  <section class="section">
      <div class="section-header justify-content-between">
          <h1>Edit Amenity</h1>
          <div class="ml-auto">
              <a href="<?php echo ADMIN_URL; ?>amenity-view.php" class="btn btn-primary"><i class="fas fa-plus"></i> View All</a>
          </div>
      </div>
      <div class="section-body">
          <div class="row">
              <div class="col-md-6">
                  <div class="card">
                      <div class="card-body">
                          <form action="" method="post">
                              <div class="form-group mb-3">
                                  <label>Name *</label>
                                  <input 
                                    type="text" 
                                    class="form-control" 
                                    name="name" 
                                    autocomplete="off"
                                    value="<?php echo $result[0]['name']; ?>"
                                  >
                              </div>
                              <div class="form-group">
                                  <button type="submit" class="btn btn-primary" name="form_submit">Update</button>
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