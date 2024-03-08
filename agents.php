<?php include 'header.php' ?>

<div class="page-top" style="background-image: url('<?php echo BASE_URL; ?>uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Agents</h2>
            </div>
        </div>
    </div>
</div>

<div class="agent pb_40">
    <div class="container">
        <div class="row">
            <?php
              $per_page = 16;
              $q = $conn->prepare("SELECT * FROM agents WHERE status=?");
              $q->execute([1]);
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

              foreach ($res as $row) {
                if (!in_array($row['id'], $arr1)) {
                  continue;
                };
                ?>
                  <div class="col-lg-3 col-md-4 col-sm-6">
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
            };

            if ($total_pages > 1) {

                if (isset($_REQUEST['p'])) {
                  if ($_REQUEST['p'] == 1) {
                    echo '<a class="links" href="javascript:void;" style="background:#ddd;"> << </a>';
                  } else {
                    echo '<a class="links" href="'.BASE_URL.'agents/'.($_REQUEST['p']-1).'"> << </a>';
                  }
                } else {
                  echo '<a class="links" href="javascript:void;" style="background:#ddd;"> << </a>';
                };

                for ($i=1; $i <= $total_pages; $i++) {
                  echo '<a class="links" href="'.BASE_URL.'agents/'.$i.'">'.$i.'</a>';
                };

                if (isset($_REQUEST['p'])) {
                  if ($_REQUEST['p'] == $total_pages) {
                    echo '<a class="links" href="javascript:void;" style="background:#ddd;"> >> </a>';
                  } else {
                    echo '<a class="links" href="'.BASE_URL.'agents/'.($_REQUEST['p']+1).'"> >> </a>';
                  }
                } else {
                  echo '<a class="links" href="'.BASE_URL.'/2"> >> </a>';
                };

            };

            
            ?>
        </div>
    </div>
</div>

<?php include 'footer.php' ?>