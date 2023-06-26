<!-- Header -->
<?php include('./includes/header.php'); ?>

<!-- Nav menu -->
<?php include('./includes/nav.php'); ?>

<?php if (get_logged_in() && $_SESSION['userRole'] === 'customer'): ?>
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="mt-4 p-5 bg-light rounded">
                        <h1>Customer Profile</h1>
                        <p>
                            <?php
                            display_message();
                            echo $_SESSION['username'];
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 py-5">
                    <div class="orderForm p-5">
                        <h2>Order Form</h2>
                        <form>
                            <div class="mb-3">
                                <label for="order-date" class="form-label">Order Date:</label>
                                <input type="date" class="form-control" id="order-date" name="order-date" required>
                            </div>
                            <div class="mb-3">
                                <label for="company" class="form-label">Company:</label>
                                <input type="text" class="form-control" id="company" name="company" required>
                            </div>
                            <div class="mb-3">
                                <label for="owner" class="form-label">Owner:</label>
                                <input type="text" class="form-control" id="owner" name="owner" required>
                            </div>
                            <div class="mb-3">
                                <label for="item" class="form-label">Item:</label>
                                <input type="text" class="form-control" id="item" name="item" required>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity:</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" required>
                            </div>
                            <div class="mb-3">
                                <label for="weight" class="form-label">Weight:</label>
                                <input type="number" class="form-control" id="weight" name="weight" required>
                            </div>
                            <div class="mb-3">
                                <label for="request-shipment" class="form-label">Request for Shipment:</label>
                                <input type="text" class="form-control" id="request-shipment" name="request-shipment"
                                       required>
                            </div>
                            <div class="mb-3">
                                <label for="tracking-id" class="form-label">Tracking ID:</label>
                                <input type="text" class="form-control" id="tracking-id" name="tracking-id" required>
                            </div>
                            <div class="mb-3">
                                <label for="shipment-size" class="form-label">Shipment Size:</label>
                                <input type="text" class="form-control" id="shipment-size" name="shipment-size"
                                       required>
                            </div>
                            <div class="mb-3">
                                <label for="box-count" class="form-label">Box Count:</label>
                                <input type="number" class="form-control" id="box-count" name="box-count" required>
                            </div>
                            <div class="mb-3">
                                <label for="specification" class="form-label">Specification:</label>
                                <textarea class="form-control" id="specification" name="specification"
                                          rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="checklist-quantity" class="form-label">Checklist Quantity:</label>
                                <input type="text" class="form-control" id="checklist-quantity"
                                       name="checklist-quantity" required>
                            </div>
                            <div class="mb-3">
                                <input type="number" class="form-control d-none"
                                       name="userID" value="<?php echo $_SESSION['userID']; ?>" readonly required>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
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


