<?php 
include 'header.php';
?>

<div class="page-top" style="background-image: url('<?php echo BASE_URL; ?>uploads/banner.jpg')">
    <div class="bg"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Blog</h2>
            </div>
        </div>
    </div>
</div>

<div class="blog">
    <div class="container">
        <div class="row">
            <?php 
            $statement = $conn->prepare("SELECT * FROM posts ORDER BY id DESC");
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

<?php 
include 'footer.php';
?>