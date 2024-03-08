<?php 

include 'layouts/top.php';

if (!isset($_SESSION['admin'])) {
  header('Location: '.ADMIN_URL.'login.php');
  exit;
};

if (isset($_POST['form_submit'])) {
  try {
    if ($_POST['title'] == "") {
      throw new Exception("Title can not be empty");
    };

    $statement = $conn->prepare("SELECT * FROM posts WHERE title=?");
    $statement->execute([$_POST['title']]);
    $total = $statement->rowCount();
    if ($total) {
      throw new Exception("Title already exists");
    };

    if ($_POST['slug'] == "") {
      throw new Exception("Slug can not be empty");
    };

    if (!preg_match('/^[a-z0-9-]+$/', $_POST['slug'])) {
      throw new Exception("Invalid slug format.");
    };

    $statement = $conn->prepare("SELECT * FROM posts WHERE slug=?");
    $statement->execute([$_POST['slug']]);
    $total = $statement->rowCount();
    if ($total) {
      throw new Exception("Slug already exists");
    };

    if ($_POST['short_description'] == "") {
      throw new Exception("Short description can not be empty");
    };

    if ($_POST['description'] == "") {
      throw new Exception("Description can not be empty");
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

    move_uploaded_file($path_tmp, '../uploads/'.$filename);

    $statement = $conn->prepare("INSERT INTO posts (title, slug, short_description, description, photo, posted_on, total_view) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $statement->execute([$_POST['title'], $_POST['slug'], $_POST['short_description'], $_POST['description'], $filename, date('Y-m-d'), 1]);

    $success_message = "Post is added successfully";

    $_SESSION['success_message'] = $success_message;
    header('Location: '.ADMIN_URL.'post-view.php');
    exit;
  } catch (Exception $e) {
    $error_message = $e->getMessage();
  }
};

?>

<div class="main-content">
  <section class="section">
      <div class="section-header justify-content-between">
          <h1>Add Post</h1>
          <div class="ml-auto">
              <a href="<?php echo ADMIN_URL; ?>post-view.php" class="btn btn-primary"><i class="fas fa-plus"></i> View All</a>
          </div>
      </div>
      <div class="section-body">
          <div class="row">
              <div class="col-md-12">
                  <div class="card">
                      <div class="card-body">
                          <form action="" method="post" enctype="multipart/form-data">
                              <div class="form-group mb-3">
                                  <label>Photo *</label>
                                  <input 
                                    type="file" 
                                    name="photo"
                                  >
                              </div>
                              <div class="form-group mb-3">
                                  <label>Title *</label>
                                  <textarea
                                    type="text"
                                    class="form-control"
                                    name="title"
                                    autocomplete="off"
                                    value="<?php if (isset($_POST['title'])) { echo $_POST['title']; } ?>"
                                  ></textarea>
                              </div>
                              <div class="form-group mb-3">
                                  <label>Slug *</label>
                                  <textarea
                                    type="text"
                                    class="form-control"
                                    name="slug"
                                    autocomplete="off"
                                    value="<?php if (isset($_POST['slug'])) { echo $_POST['slug']; } ?>"
                                  ></textarea>
                              </div>
                              <div class="form-group mb-3">
                                  <label>Short Desciption *</label>
                                  <textarea
                                    name="short_description"
                                    class="form-control h_100"
                                    cols="30"
                                    rows="10"
                                  >
                                    <?php if (isset($_POST['short_description'])) { echo $_POST['short_description']; } ?>
                                  </textarea>
                              </div>
                              <div class="form-group mb-3">
                                  <label>Desciption *</label>
                                  <textarea
                                    name="description"
                                    class="form-control h_100"
                                    cols="30"
                                    rows="10"
                                  >
                                    <?php if (isset($_POST['description'])) { echo $_POST['description']; } ?>
                                  </textarea>
                              </div>
                              <div class="form-group">
                                  <button type="submit" class="btn btn-primary" name="form_submit">Submit</button>
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