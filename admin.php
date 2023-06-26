<!-- Header -->
<?php include('./includes/header.php'); ?>

<!-- Nav menu -->
<?php include('./includes/nav.php'); ?>

<?php if (get_logged_in() && $_SESSION['userRole'] === 'admin'): ?>
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="mt-4 p-5 bg-light rounded">
                        <h1>Admin Profile</h1>
                        <p>
                            <?php
                            echo $_SESSION['username'];
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
else:
    redirect('index.php');
endif; ?>

<!-- Footer -->
<?php include('./includes/footer.php'); ?>


