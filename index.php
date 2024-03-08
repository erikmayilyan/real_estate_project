<?php include 'header.php'; ?>

<div class="slider" style="background-image: url(<?php echo BASE_URL; ?>uploads/banner-home.jpg)">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="item">
                    <div class="text">
                        <h2>Discover Your New Home</h2>
                        <p>
                            You can get your desired awesome properties, homes, condos etc. here by name, category or location.
                        </p>
                    </div>
                    <div class="search-section">
                        <form action="<?php echo BASE_URL; ?>properties.php" method="post">
                            <div class="inner">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="Property Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <select name="location_id" class="form-select select2">
                                                <option value="">All Locations</option>
                                                <?php
                                                $statement = $conn->prepare("SELECT * FROM locations ORDER BY name ASC");
                                                $statement->execute();
                                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($result as $row) {
                                                  ?>
                                                    <option value="<?php echo $row['id']; ?>">
                                                      <?php echo $row['name']; ?>
                                                    </option>
                                                  <?php
                                                };
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <select name="type_id" class="form-select select2">
                                                <option value="">All Types</option>
                                                <?php
                                                $statement = $conn->prepare("SELECT * FROM types ORDER BY name ASC");
                                                $statement->execute();
                                                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                                                foreach ($result as $row) {
                                                  ?>
                                                    <option value="<?php echo $row['id']; ?>">
                                                      <?php echo $row['name']; ?>
                                                    </option>
                                                  <?php
                                                };
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <input type="hidden" name="amenity_id" value="">
                                        <input type="hidden" name="purpose" value="">
                                        <input type="hidden" name="bedrooms" value="">
                                        <input type="hidden" name="bathrooms" value="">
                                        <input type="hidden" name="price" value="">
                                        <input type="hidden" name="p" value="1">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                            Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="property">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading">
                    <h2>Featured Properties</h2>
                    <p>Find out the awesome properties that you must love</p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php 
            $limit = 6; // Set the limit value
            $statement = $conn->prepare("SELECT 
                                        p.*, 
                                        l.name as location_name,
                                        t.name as type_name,
                                        a.full_name as full_name,
                                        a.company,
                                        a.photo
                                        FROM 
                                        properties p
                                        JOIN locations l 
                                        ON p.location_id = l.id
                                        JOIN types t
                                        ON p.type_id = t.id
                                        JOIN agents a
                                        ON p.agent_id = a.id
                                        WHERE p.is_featured=? AND p.agent_id NOT IN (
                                          SELECT a.id 
                                          FROM agents a
                                          JOIN orders o
                                          ON a.id = o.agent_id
                                          WHERE o.expire_date < ? AND o.currently_active=?
                                        )
                                        LIMIT ?");
            $statement->bindValue(1, 'Yes');
            $statement->bindValue(2, date('Y-m-d'));
            $statement->bindValue(3, '1', PDO::PARAM_INT); 
            $statement->bindValue(4, $limit, PDO::PARAM_INT);            
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            $total = $statement->rowCount();
            if (!$total) {
                ?>
                <div class="col-md-12">
                    No Property Found
                </div>
                <?php
            } else {
              foreach ($result as $row) {
              ?>
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="item">
                        <div class="photo">
                            <img class="main" src="<?php echo BASE_URL; ?>uploads/<?php echo $row['featured_photo']; ?>" alt="">
                            <div class="top">
                                <div class="status-<?php if ($row['purpose'] == 'Rent') { echo 'rent'; } else { echo 'sale'; } ?>">
                                    For <?php echo $row['purpose']; ?>
                                </div>
                                <div class="featured">
                                    Featured
                                </div>
                            </div>
                            <div class="price">
                              $<?php echo $row['price']; ?>
                            </div>
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
                                    <div class="i1">
                                      <?php echo $row['size']; ?> sqft
                                    </div>
                                    <div class="i2">
                                      <?php echo $row['bedroom']; ?> Bed
                                    </div>
                                    <div class="i3">
                                      <?php echo $row['bathroom']; ?> bath
                                    </div>
                                </div>
                                <div class="address">
                                    <i class="fas fa-map-marker-alt"></i> <?php echo $row['address']; ?>
                                </div>
                                <div class="type-location">
                                    <div class="i1">
                                        <i class="fas fa-edit"></i> <?php echo $row['type_name']; ?>
                                    </div>
                                    <div class="i2">
                                        <i class="fas fa-location-arrow"></i> <?php echo $row['location_name']; ?>
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
                                      <?php echo $row['full_name']; ?> (<?php echo $row['company']; ?>)
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              <?php
              }
            }
            ?>
        </div>
    </div>
</div>

<div class="why-choose" style="background-image: url('<?php echo BASE_URL; ?>uploads/why-choose.jpg')">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading">
                    <h2>Why Choose Us</h2>
                    <p>
                        Describing why we are best in the property business
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            $statement = $conn->prepare("SELECT * FROM why_choose_items ORDER BY id ASC");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
            ?>
              <div class="col-md-4">
                  <div class="inner">
                      <div class="icon">
                          <i class="<?php echo $row['icon']; ?>"></i>
                      </div>
                      <div class="text">
                          <h2><?php echo $row['heading']; ?></h2>
                          <p class="text-white"><?php echo $row['text']; ?></p>
                      </div>
                  </div>
              </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<div class="agent">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading">
                    <h2>Agents</h2>
                    <p>
                        Meet our expert property agents from the following list
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
            $statement = $conn->prepare("SELECT * FROM agents WHERE status=?");
            $statement->execute([1]);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
             ?>
                <div class="col-lg-3 col-md-3">
                    <div class="item">
                        <div class="photo">
                            <a href="<?php echo BASE_URL; ?>agent/<?php echo $row['id']; ?>">
                                <?php if ($row['photo'] == '') { ?>
                                    <img src="<?php echo BASE_URL; ?>uploads/default.png" alt="">
                                <?php } else { ?>
                                    <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo']; ?>" alt="">
                                <?php } ?>
                            </a>
                        </div>
                        <div class="text">
                            <h2>
                                <a href="<?php echo BASE_URL; ?>agent/<?php echo $row['id']; ?>">
                                    <?php echo $row['full_name']; ?>
                                </a>
                            </h2>
                        </div>
                    </div>
                </div>
             <?php
            }
            ?>
        </div>
    </div>
</div>



<div class="location pb_40" style="background-color: #e1e5f7">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading">
                    <h2>Locations</h2>
                    <p>
                        Check out all the properties of important locations
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
              $statement = $conn->prepare("SELECT l.id, l.name, l.slug, l.photo, COUNT(p.id) AS property_count 
                                           FROM locations l
                                           LEFT JOIN properties p
                                           ON l.id = p.location_id
                                           GROUP BY l.id
                                           HAVING property_count > 0
                                           ORDER BY name DESC 
                                           LIMIT 8");
              $statement->execute();
              $result = $statement->fetchAll(PDO::FETCH_ASSOC);
              foreach ($result as $row) {
                ?>
                  <div class="col-lg-3 col-md-4 col-sm-6">
                      <div class="item">
                          <div class="photo">
                              <a href="<?php echo BASE_URL; ?>location/<?php echo $row['slug']; ?>"><img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo']; ?>" alt=""></a>
                          </div>
                          <div class="text">
                              <h2>
                                <a href="<?php echo BASE_URL; ?>location/<?php echo $row['slug']; ?>">
                                  <?php echo $row['name']; ?>
                                </a>
                              </h2>
                              <h4>(<?php echo $row['property_count']; ?> Properties)</h4>
                          </div>
                      </div>
                  </div>
                <?php
              };
            ?>
        </div>
    </div>
</div>

<div class="blog">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="heading">
                    <h2>Latest News</h2>
                    <p>
                        Check our latest news from the following section
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php 
            $statement = $conn->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT 3");
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
            ?>
            <div class="col-lg-4 col-md-6">
                <div class="item">
                    <div class="photo">
                        <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['photo']; ?>" alt="" />
                    </div>
                    <div class="text">
                        <h2>
                            <a href="<?php echo BASE_URL; ?>post/<?php echo $row['slug']; ?>">
                                <?php echo $row['title']; ?>
                            </a>
                        </h2>
                        <div class="short-des">
                            <p>
                                <?php echo $row['short_description']; ?>
                            </p>
                        </div>
                        <div class="button">
                            <a href="<?php echo BASE_URL; ?>post/<?php echo $row['slug']; ?>" class="btn btn-primary">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            };
            ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>