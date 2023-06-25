<!-- Header -->
<?php include('includes/header.php'); ?>

<!-- Nav menu -->
<?php include('includes/nav.php'); ?>

<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="mt-4 p-5 bg-light rounded">
                    <h1>Register</h1>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section register-info">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 py-5 text-center">
                <?php validate_user_registration(); ?>
            </div>
        </div>
    </div>
</section>

<section class="section section-register">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-3 py-5">
                <form id="registrationForm" method="post" onsubmit="return validateForm()">
                    <div class="mb-3">
                        <label for="username" class="form-label">ID (Username):</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" minlength="6" id="password" name="password"
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="confirm-password" class="form-label">Confirm Password:</label>
                        <input type="password" class="form-control" minlength="6" id="confirm-password"
                               name="confirm-password"
                               required>
                    </div>
                    <button type="submit" name="register-submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>
</section>


<!-- Footer -->
<?php include('includes/footer.php'); ?>


