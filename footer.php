
<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="item">
                    <h2 class="heading">Important Links</h2>
                    <ul class="useful-links">
                        <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
                        <li><a href="<?php echo BASE_URL; ?>properties.php?name=&location_id=&type_id=&amenity_id=&status=&bedrooms=&bathrooms=&price=&p1=1">Properties</a></li>
                        <li><a href="<?php echo BASE_URL; ?>agents/1">Agents</a></li>
                        <li><a href="<?php echo BASE_URL; ?>blog">Blog</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="item">
                    <h2 class="heading">Locations</h2>
                    <ul class="useful-links">
                    <?php 
                    $statement = $conn->prepare("SELECT * FROM locations LIMIT 4");
                    $statement->execute();
                    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $row) {
                    ?>
                      <li><a href="<?php echo BASE_URL; ?>location/<?php echo $row['slug']; ?>"><?php echo $row['name']; ?></a></li>
                    <?php
                    }
                    ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="item">
                    <h2 class="heading">Contact</h2>
                    <div class="list-item">
                        <div class="left">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="right">
                            5 Best Avenue, Vancouver, Canada 
                        </div>
                    </div>
                    <div class="list-item">
                        <div class="left">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="right">contact@gmal.com</div>
                    </div>
                    <div class="list-item">
                        <div class="left">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="right">222-222-1212</div>
                    </div>
                    <ul class="social">
                        <li>
                            <a href=""><i class="fab fa-facebook-f"></i></a>
                        </li>
                        <li>
                            <a href=""><i class="fab fa-twitter"></i></a>
                        </li>
                        <li>
                            <a href=""><i class="fab fa-pinterest-p"></i></a>
                        </li>
                        <li>
                            <a href=""><i class="fab fa-linkedin-in"></i></a>
                        </li>
                        <li>
                            <a href=""><i class="fab fa-instagram"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="copyright">
                    This Project is For Poftfolio Purposes. All Rights Reserved 2024
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="right">
                    <ul>
                        <li><a href="<?php echo BASE_URL; ?>terms-of-use">Terms of Use</a></li>
                        <li>
                            <a href="<?php echo BASE_URL; ?>privacy-policy">Privacy Policy</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="scroll-top">
    <i class="fas fa-angle-up"></i>
</div>

<script src="<?php echo BASE_URL; ?>dist/js/custom.js"></script>

<?php
  if (isset($error_message)) :
?>
    <script>
      iziToast.show({
        message: '<?php echo $error_message; ?>',
        position: 'bottomRight',
        color: 'red'
      })
    </script>
<?php
  endif;
?>

<?php
  if (isset($success_message)) :
?>
    <script>
      iziToast.show({
        message: '<?php echo $success_message; ?>',
        position: 'bottomRight',
        color: 'green'
      })
    </script>
<?php
  endif;
?>

<?php
if (isset($_SESSION['success_message'])) {
?>
  <script>
    iziToast.show({
      message: '<?php echo $_SESSION['success_message']; ?>',
      position: 'bottomRight',
      color: 'green'
    })
  </script>
<?php
  unset($_SESSION['success_message']);
}
?>

<?php
if (isset($_SESSION['error_message'])) {
?>
  <script>
    iziToast.show({
      message: '<?php echo $_SESSION['error_message']; ?>',
      position: 'bottomRight',
      color: 'red'
    })
  </script>
<?php
  unset($_SESSION['error_message']);
}
?>

</body>
</html>