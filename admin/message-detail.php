<?php 

include 'layouts/top.php';

if (!isset($_SESSION['admin'])) {
  header('Location: '.ADMIN_URL.'login.php');
  exit;
};

$statement = $conn->prepare("SELECT 
                              m.*,
                              c.full_name AS customer_name,
                              c.email AS customer_email,
                              c.photo AS customer_photo,
                              a.full_name AS agent_name,
                              a.email AS agent_email,
                              a.photo AS agent_photo
                             FROM messages m
                             JOIN customers c
                             ON m.customer_id = c.id
                             JOIN agents a
                             ON m.agent_id = a.id
                             WHERE m.id=?");
$statement->execute([$_REQUEST['id']]);
$result = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="main-content">
  <section class="section">
    <div class="section-header justify-content-between">
        <h1>Subject: <?php echo $result[0]['subject']; ?></h1>
        <div class="ml-auto">
            <a href="<?php echo ADMIN_URL; ?>message-view.php" class="btn btn-primary"><i class="fas fa-plus"></i> Back to Previous Page</a>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <div class="card-body">
                        <div class="message-heading">
                            All Replies
                        </div>
                    </div>
                </div>

                <?php
                $statement = $conn->prepare("SELECT 
                                              mr.*,
                                              c.full_name AS customer_name,
                                              c.email AS customer_email,
                                              c.photo AS customer_photo,
                                              a.full_name AS agent_name,
                                              a.email AS agent_email,
                                              a.photo AS agent_photo
                                            FROM messages_replies mr
                                            JOIN customers c
                                            ON mr.customer_id = c.id
                                            JOIN agents a
                                            ON mr.agent_id = a.id
                                            WHERE mr.message_id=?
                                            ORDER BY mr.id ASC");
                $statement->execute([$_REQUEST['id']]);
                $result = $statement->fetchAll(PDO::FETCH_ASSOC);
                $total = $statement->rowCount();
                if (!$total) {
                  echo '<div class="message-item text-danger">No reply found!</div>';
                }
                foreach ($result as $row) {
                ?>
                    <div class="message-item message-item-main">
                        <div class="message-top">
                            <div class="photo">
                                <?php 
                                if ($row['sender'] == 'Customer') {
                                  if ($row['customer_photo'] == '') {
                                ?>
                                    <img src="<?php echo BASE_URL; ?>uploads/default.png" alt="">
                                <?php 
                                  } else {
                                ?>
                                    <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['customer_photo']; ?>" alt="">
                                <?php
                                  }
                                };
                                ?>

                                <?php   
                                if ($row['sender'] == 'Agent') {
                                  if ($row['agent_photo'] == '') {
                                ?>
                                    <img src="<?php echo BASE_URL; ?>uploads/default.png" alt="">
                                <?php 
                                  } else {
                                ?>
                                    <img src="<?php echo BASE_URL; ?>uploads/<?php echo $row['agent_photo']; ?>" alt="">
                                <?php
                                  }
                                };
                                ?>
                            </div>
                            <div class="text">
                                <h6>
                                    <?php 
                                    if ($row['sender'] == 'Customer') {
                                    ?>
                                        <?php echo $row['customer_name']; ?>
                                        <span class="badge rounded-pill text-bg-primary">Customer</span>
                                    <?php
                                    } else {
                                    ?>
                                        <?php echo $row['agent_name']; ?>
                                        <span class="badge rounded-pill text-bg-success">Agent</span>
                                    <?php
                                    };
                                    ?>
                                </h6>
                                <p>
                                    Posted on: <?php echo $row['reply_on']; ?>
                                </p>
                            </div>
                        </div>
                        <div class="message-bottom">
                            <?php echo $row['reply']; ?>
                        </div>
                    </div>
                <?php
                }
                ?>

            </div>
        </div>
    </div>
  </section>
</div>

<?php include 'layouts/footer.php' ?>