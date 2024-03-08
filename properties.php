<?php 
include 'header.php';

if (isset($_GET['name']) && !empty($_GET['name'])) {
  $property_name = '%' . $_GET['name'] . '%';
  $c_name = ' AND p.name LIKE \''.$property_name.'\'';
} else {
  $c_name = '';
};

if (isset($_GET['location_id']) && !empty($_GET['location_id'])) {
  if ($_GET['location_id'] == 'All Locations') {
    $c_location_id = '';
  } else {
    $c_location_id = ' AND location_id='.$_GET['location_id'];
  }
} else {
  $c_location_id = '';
};

if (isset($_GET['type_id']) && !empty($_GET['type_id'])) {
  if ($_GET['type_id'] == 'All types') {
    $c_type_id = '';
  } else {
    $c_type_id = ' AND type_id='.$_GET['type_id'];
  }
} else {
  $c_type_id = '';
};

if (isset($_GET['amenity_id']) && !empty($_GET['amenity_id'])) {
  if ($_GET['amenity_id'] == 'All types') {
    $c_amenity_id = '';
  } else {
    $c_amenity_id = ' AND FIND_IN_SET("'.$_GET['amenity_id'].'", amenities) > 0';
  }
} else {
  $c_amenity_id = '';
};

if (isset($_GET['status']) && !empty($_GET['status'])) {
  if ($_GET['status'] == 'Both Statuses') {
    $c_status = '';
  } else {
    $c_status = ' AND purpose=\''.$_GET['status'].'\'';
  }
} else {
  $c_status = '';
};

if (isset($_GET['bedrooms']) && !empty($_GET['bedrooms'])) {
  if ($_GET['bedrooms'] == 'All Bedrooms') {
    $c_bedrooms = '';
  } else {
    $c_bedrooms = ' AND bedroom='.$_GET['bedrooms'];
  }
} else {
  $c_bedrooms = '';
};

if (isset($_GET['bathrooms']) && !empty($_GET['bathrooms'])) {
  if ($_GET['bathrooms'] == 'All Bathrooms') {
    $c_bathrooms = '';
  } else {
    $c_bathrooms = ' AND bathroom='.$_GET['bathrooms'];
  }
} else {
  $c_bathrooms = '';
};

if (isset($_GET['bathrooms']) && !empty($_GET['bathrooms'])) {
  if ($_GET['bathrooms'] == 'All Bathrooms') {
    $c_bathrooms = '';
  } else {
    $c_bathrooms = ' AND bathroom='.$_GET['bathrooms'];
  }
} else {
  $c_bathrooms = '';
};

if (isset($_GET['price']) && !empty($_GET['price'])) {
  if ($_GET['price'] == 'All Prices') {
    $c_price = '';
  } else {
    list($minPrice, $maxPrice) = explode('-', $_GET['price']);
    $c_price = ' AND price>='.$minPrice.' AND price <= '.$maxPrice;
  }
} else {
  $c_price = '';
};
?>

<div class="page-top" style="background-image: url('uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Property Listing</h2>
            </div>
        </div>
    </div>
</div>

<div class="property-result">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12">
                <div class="property-filter">
                    <form action="" method="get">
                        <div class="widget">
                            <h2>Find Anything</h2>
                            <input 
                              type="text" 
                              name="name" 
                              class="form-control" 
                              placeholder="Property Name" 
                              value="<?php if (isset($_GET['name'])) { echo $_GET['name']; } ?>"
                            />
                        </div>

                        <div class="widget">
                            <h2>Location</h2>
                            <select name="location_id" class="form-control select2" onchange="this.form.submit()">
                                <option value="">All Locations</option>
                                <?php 
                                    $statement = $conn->prepare("SELECT * FROM locations ORDER BY name ASC");
                                    $statement->execute();
                                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $row) {
                                ?>
                                    <option value="<?php echo $row['id']; ?>" <?php if (isset($_GET['location_id']) && $_GET['location_id'] == $row['id']) { echo 'selected'; } ?>>
                                        <?php echo $row['name']; ?>
                                    </option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>

                        <div class="widget">
                            <h2>Type</h2>
                            <select name="type_id" class="form-control select2" onchange="this.form.submit()">
                                <option value="">All Types</option>
                                <?php 
                                  $statement = $conn->prepare("SELECT * FROM types ORDER BY name ASC");
                                  $statement->execute();
                                  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                  foreach ($result as $row) {
                                ?>
                                  <option value="<?php echo $row['id']; ?>" <?php if (isset($_GET['type_id'])) { if ($_GET['type_id'] == $row['id']) { echo 'selected'; } } ?>>
                                    <?php echo $row['name']; ?>
                                  </option>
                                <?php
                                  }
                                ?>
                            </select>
                        </div>

                        <div class="widget">
                            <h2>Amenities</h2>
                            <select name="amenity_id" class="form-control select2" onchange="this.form.submit()">
                                <option value="">All Amenities</option>
                                <?php 
                                  $statement = $conn->prepare("SELECT * FROM amenities ORDER BY name ASC");
                                  $statement->execute();
                                  $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                  foreach ($result as $row) {
                                ?>
                                  <option value="<?php echo $row['id']; ?>" <?php if (isset($_GET['amenity_id'])) { if ($_GET['amenity_id'] == $row['id']) { echo 'selected'; } } ?>>
                                    <?php echo $row['name']; ?>
                                  </option>
                                <?php
                                  }
                                ?>
                            </select>
                        </div>

                        <div class="widget">
                            <h2>Status</h2>
                            <select name="status" class="form-control select2" onchange="this.form.submit()">
                                <option value="">Both Statuses</option>
                                <option value="Rent" <?php if (isset($_GET['status'])) { if ($_GET['status'] == 'Rent') { echo 'selected'; } } ?>>For Rent</option>
                                <option value="Sale" <?php if (isset($_GET['status'])) { if ($_GET['status'] == 'Sale') { echo 'selected'; } } ?>>For Sale</option>
                            </select>
                        </div>

                        <div class="widget">
                            <h2>Bedrooms</h2>
                            <select name="bedrooms" class="form-control select2" onchange="this.form.submit()">
                                <option value="">All Bedrooms</option>
                                <?php
                                  for ($i=1; $i<=10; $i++) {
                                    ?>
                                      <option value="<?php echo $i; ?>" <?php if (isset($_GET['bedrooms'])) { if ($_GET['bedrooms'] == $i) { echo 'selected'; } } ?>>
                                        <?php echo $i; ?>
                                      </option>
                                    <?php
                                  };
                                ?>
                            </select>
                        </div>

                        <div class="widget">
                            <h2>Bathrooms</h2>
                            <select name="bathrooms" class="form-control select2" onchange="this.form.submit()">
                                <option value="">All Bathrooms</option>
                                <?php
                                  for ($i=1; $i<=10; $i++) {
                                    ?>
                                      <option value="<?php echo $i; ?>" <?php if (isset($_GET['bathrooms'])) { if ($_GET['bathrooms'] == $i) { echo 'selected'; } } ?>>
                                        <?php echo $i; ?>
                                      </option>
                                    <?php
                                  };
                                ?>
                            </select>
                        </div>

                        <div class="widget">
                            <h2>Min Price</h2>
                            <select name="price" class="form-control select2" onchange="this.form.submit()">
                                <option value="">All Prices</option>
                                <option value="1-50000" <?php if (isset($_GET['price'])) { if ($_GET['price'] == '1-50000') { echo 'selected'; } } ?>>$1-$50000</option>
                                <option value="50001-100000" <?php if (isset($_GET['price'])) { if ($_GET['price'] == '50001-100000') { echo 'selected'; } } ?>>$50001-$100000</option>
                                <option value="100001-200000" <?php if (isset($_GET['price'])) { if ($_GET['price'] == '100001-200000') { echo 'selected'; } } ?>>$100001-$200000</option>
                                <option value="200001-500000" <?php if (isset($_GET['price'])) { if ($_GET['price'] == '200001-500000') { echo 'selected'; } } ?>>$200001-$500000</option>
                                <option value="500001-1000000" <?php if (isset($_GET['price'])) { if ($_GET['price'] == '500001-1000000') { echo 'selected'; } } ?>>$500001-$1000000</option>
                                <option value="1000001-10000000" <?php if (isset($_GET['price'])) { if ($_GET['price'] == '1000001-10000000') { echo 'selected'; } } ?>>$1000001-$10000000</option>
                            </select>
                        </div>

                        <div class="filter-button">
                            <input type="hidden" name="p1" value="1">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-8 col-md-12">
                <div class="property">
                    <div class="container">
                        <div class="row">
                            <?php
                              $query = '';
                              $query = $c_name.$c_location_id.$c_type_id.$c_amenity_id.$c_status.$c_bedrooms.$c_bathrooms.$c_price;
                              $per_page = 4;
                              $q = $conn->prepare("SELECT p.*, l.name as location_name, t.name as type_name, a.full_name, a.company, a.photo
                                                   FROM properties p
                                                   JOIN locations l
                                                   ON p.location_id = l.id
                                                   JOIN types t
                                                   ON p.type_id = t.id
                                                   JOIN agents a
                                                   ON p.agent_id = a.id
                                                   WHERE 1=1".$query." AND p.agent_id NOT IN (
                                                    SELECT a.id 
                                                    FROM agents a
                                                    JOIN orders o
                                                    ON a.id = o.agent_id
                                                    WHERE o.expire_date < ? AND o.currently_active=?
                                                  ) ORDER BY is_featured DESC");
                              $q->execute([date('Y-m-d'), 1]);
                              $total = $q->rowCount();
                              $total_pages = ceil($total/$per_page);
                              if (!isset($_REQUEST['p'])) {
                                $start = 1;
                              } else {
                                $start = $per_page * ($_REQUEST['p']-1) + 1;
                              };

                              $j = 0;
                              $k = 0;
                              $arr1 = [];
                              $res = $q->fetchAll();
                              foreach ($res as $row) {
                                $j++;
                                if ($j >= $start) {
                                  $k++;
                                  if ($k > $per_page) {
                                    break;
                                  };
                                  $arr1[] = $row['id'];
                                }
                              };

                              $total_rows = $q->rowCount();
                              foreach ($res as $row) {
                                if (!in_array($row['id'], $arr1)) {
                                  continue;
                                };

                                ?>
                                  <div class="col-lg-6 col-md-6 col-sm-12">
                                      <div class="item">
                                          <div class="photo">
                                              <img class="main" src="<?php echo BASE_URL; ?>uploads/<?php echo $row['featured_photo']; ?>" alt="">
                                              <div class="top">
                                                  <div class="status-<?php if ($row['purpose'] == 'Rent') { echo 'rent'; } else { echo 'sale'; } ?>">
                                                      For <?php echo $row['purpose']; ?>
                                                  </div>
                                                  <?php if ($row['is_featured'] == 'Yes') { ?>
                                                    <div class="featured">
                                                        Featured
                                                    </div>
                                                  <?php } ?>
                                              </div>
                                              <div class="price">$<?php echo $row['price']; ?></div>
                                              <div class="wishlist">
                                                <a href="<?php echo BASE_URL; ?>customer-wishlist-add.php?id=<?php echo $row['id']; ?>">
                                                  <i class="far fa-heart"></i>
                                                </a>
                                              </div>
                                          </div>
                                          <div class="text">
                                              <h3>
                                                <a href="<?php echo BASE_URL; ?>property/<?php echo $row['id']; ?>/<?php echo $row['slug']; ?>">
                                                  <?php echo $row['name']; ?>
                                                </a>
                                              </h3>
                                              <div class="detail">
                                                  <div class="stat">
                                                      <div class="i1"><?php echo $row['size']; ?> sqft</div>
                                                      <div class="i2"><?php echo $row['bedroom']; ?> Bed</div>
                                                      <div class="i3"><?php echo $row['bathroom']; ?> Bath</div>
                                                  </div>
                                                  <div class="address">
                                                      <i class="fas fa-map-marker-alt"></i> <?php echo $row['address']; ?>
                                                  </div>
                                                  <div class="type-location">
                                                      <div class="i1">
                                                          <i class="fas fa-edit"></i> <?php echo $row['location_name']; ?>
                                                      </div>
                                                      <div class="i2">
                                                          <i class="fas fa-location-arrow"></i> <?php echo $row['type_name']; ?>
                                                      </div>
                                                  </div>
                                                  <div class="agent-section">
                                                      <?php 
                                                      if ($row['photo'] == '') {
                                                      ?>
                                                        <img class="agent-photo" src="<?php echo BASE_URL; ?>uploads/default.png" alt="">
                                                      <?php
                                                      } else {
                                                      ?>
                                                        <img class="agent-photo" src="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo']; ?>" alt="">
                                                      <?php
                                                      }
                                                      ?>
                                                      <a href="">
                                                          <?php echo $row['full_name']; ?>
                                                      </a>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                <?php
                              };

                              if ($total_rows) {

                                if (isset($_GET['location_id']) && isset($_GET['type_id'])) {
                                  $common_url_part = BASE_URL.'properties.php?name='.$_GET['name'].'&location_id='.$_GET['location_id'].'&type_id='.$_GET['type_id'].'&amenity_id='.$_GET['amenity_id'].'&status='.$_GET['status'].'&bedrooms='.$_GET['bedrooms'].'&bathrooms='.$_GET['bathrooms'].'&price='.$_GET['price'];
  
                                  ?>
                                  <div class="col-md-12">
                                      <?php
                                      if (isset($_REQUEST['p'])) {
                                        if ($_REQUEST['p'] == 1) {
                                          echo '<a class="links links_gray" href="javascript:void;" style="background:#ddd;"> << </a>';
                                        } else {
                                          echo '<a class="links" href="'.$common_url_part.'&p='.($_REQUEST['p']-1).'"> << </a>';
                                        };
                                      } else {
                                        echo '<a class="links links_gray" href="javascript:void;"> << </a>';
                                      };
      
                                      for ($i=1; $i<=$total_pages; $i++) {
                                        echo '<a class="links" href="'.$common_url_part.'&p='.$i.'">'.$i.'</a>';
                                      };
      
                                      if (isset($_REQUEST['p'])) {
                                        if ($_REQUEST['p'] == $total_pages) {
                                          echo '<a class="links links_gray" href="javascript:void;"> >> </a>';
                                        } else {
                                          echo '<a class="links" href="'.$common_url_part.'&p='.($_REQUEST['p']+1).'"> >> </a>';
                                        }
                                      } else {
                                        echo '<a class="links" href="'.$common_url_part.'&p=2"> >> </a>';
                                      }
                                      ?>
                                  </div>
                                  <?php
                                };

                              };
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
include 'footer.php'; 
?>