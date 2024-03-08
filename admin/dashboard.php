<?php
include 'layouts/top.php';

if (!isset($_SESSION['admin'])) {
  header('Location: '.ADMIN_URL.'login.php');
  exit;
};

$statement = $conn->prepare("SELECT * FROM locations");
$statement->execute();
$total_locations = $statement->rowCount();

$statement = $conn->prepare("SELECT * FROM types");
$statement->execute();
$total_types = $statement->rowCount();

$statement = $conn->prepare("SELECT * FROM amenities");
$statement->execute();
$total_amenities = $statement->rowCount();

$statement = $conn->prepare("SELECT * FROM properties");
$statement->execute();
$total_properties = $statement->rowCount();
?>

<div class="main-content">
  <section class="section">
      <div class="section-header">
          <h1>Dashboard</h1>
      </div>
      <div class="row">
          <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                  <div class="card-icon bg-primary">
                      <i class="far fa-user"></i>
                  </div>
                  <div class="card-wrap">
                      <div class="card-header">
                          <h4>Total Locations</h4>
                      </div>
                      <div class="card-body">
                          <?php echo $total_locations; ?>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                  <div class="card-icon bg-danger">
                      <i class="fas fa-book-open"></i>
                  </div>
                  <div class="card-wrap">
                      <div class="card-header">
                          <h4>Total Types</h4>
                      </div>
                      <div class="card-body">
                          <?php echo $total_types; ?>
                      </div>
                  </div>
              </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                  <div class="card-icon bg-warning">
                      <i class="fas fa-bullhorn"></i>
                  </div>
                  <div class="card-wrap">
                      <div class="card-header">
                          <h4>Total Amenities</h4>
                      </div>
                      <div class="card-body">
                          <?php echo $total_amenities; ?>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>

<?php
include 'layouts/footer.php';
?>