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
                            display_message();
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section section-table my-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Item/Customer</th>
                                <th>Customer 1</th>
                                <th>Customer 2</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Quantity</td>
                                <td>Customer 1 Quantity</td>
                                <td>Customer 2 Quantity</td>
                                <td>Total quantity of Customer 1 & 2</td>
                            </tr>
                            <tr>
                                <td>Weight</td>
                                <td>Customer 1 Weight</td>
                                <td>Customer 2 Weight</td>
                                <td>Total Weight of Customer 1 & 2</td>
                            </tr>
                            <tr>
                                <td>Box Count</td>
                                <td>Customer 1 Box Count</td>
                                <td>Customer 2 Box Count</td>
                                <td>Total Box Count of Customer 1 & 2</td>
                            </tr>
                            <!-- Add more rows as needed -->
                            </tbody>
                        </table>
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


