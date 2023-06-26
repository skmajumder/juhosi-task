<?php

function validation_errors($error_message)
{
    $error_message = <<<DELIMITER
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Holy guacamole!</strong>
            $error_message
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
DELIMITER;
    return $error_message;
}

function clean($string)
{
    return htmlentities($string);
}

function redirect($location)
{
    return header("Location: {$location}");
}

function set_message($message)
{
    if (!empty($message))
        $_SESSION['message'] = $message;
    else
        $_SESSION = "";
}

function display_message()
{
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

function token_generator()
{
    $_SESSION['token'] = md5(uniqid(mt_rand(), true));
    return $token = $_SESSION['token'];
}

function send_email($email, $subject, $message, $headers)
{
    return mail($email, $subject, $message, $headers);
}

function email_exists($email)
{
    $sql = "SELECT id FROM users WHERE email = '$email'";
    $result = query($sql);
    confirm($result);
    if (row_count($result) == 1) return true;
    else return false;
}

function username_exists($user_name)
{
    $sql = "SELECT id FROM users WHERE username = '$user_name'";
    $result = query($sql);
    confirm($result);
    if (row_count($result) == 1) return true;
    else return false;
}

function get_logged_in()
{
    if (isset($_SESSION['username']) || isset($_COOKIE['username'])) {
        return true;
    } else {
        return false;
    }
}

/**
 * @return void
 * Validate register user
 */

function validate_user_registration()
{
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $user_name = clean($_POST['username']);
        $email = clean($_POST['email']);
        $password = clean($_POST['password']);
        $confirm_password = clean($_POST['confirm-password']);

        if (username_exists($user_name)) {
            $errors[] = "<span class='server_error_message'> ID(UserName) taken, Try another</span>";
        }

        if (email_exists($email)) {
            $errors[] = "<span class='server_error_message'>This email {$email} already exits, Try another.</span>";
        }

        if (empty($user_name)) {
            $errors[] = "<span class='server_error_message'>ID (Username) can't be empty</span>";
        }

        if (empty($email)) {
            $errors[] = "<span class='server_error_message'>email can't be empty</span>";
        }

        if (empty($password)) {
            $errors[] = "<span class='server_error_message'>Password Can't Empty</span>";
        }

        if (empty($confirm_password)) {
            $errors[] = "<span class='server_error_message'>input confirm password</span>";
        }

        if ($confirm_password !== $password) {
            $errors[] = "<span class='server_error_message'>Passwords do not match.</span>";
        }

        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo validation_errors($error);
            }
        } else {
            if (register_user($user_name, $email, $password)) {
                set_message('<div class="alert alert-success" role="alert">Registration Successful. Please Check Your Email for Activation Link</div>');
                redirect("confirm-user.php");
            } else {
                set_message('<div class="alert alert-danger" role="alert">Sorry! User Registration is Failed</div>');
                redirect("failed-user.php");
            }
        }
    }
}

function register_user($user_name, $email, $password)
{
    $esc_username = escape_sql($user_name);
    $esc_email = escape_sql($email);
    $esc_password = escape_sql($password);

    if (email_exists($esc_email) || username_exists($esc_username)) {
        return false;
    }

    $encryptedPassword = md5($esc_password);
    $validation_code = md5($email . microtime());

    /** validation complete, now inserting user data into DB */
    $sql = "INSERT INTO users(username, password, email, role, validation_code, active)";
    $sql .= " VALUES('$esc_username', '$encryptedPassword', '$esc_email', 'customer', '$validation_code', 0)";

    $result = query($sql);
    confirm($result);
//    TODO: Complete email activation
//    $subject = "Activate your Account.";
//    $message = "
//            Hi,
//            - Your Registration has been complete, Now active your account.
//            - Go to http://localhost/juhosi-task/activate.php?email=$esc_email&code=$validation_code
//        ";
//    $headers = "From: noreply@yourwebsite.com";
//    send_email($esc_email, $subject, $message, $headers);

    return true;
}

function activate_user()
{
    if ($_SERVER['REQUEST_METHOD'] == "GET") {
        if (isset($_GET['email']) && isset($_GET['code'])) {
            $email = clean($_GET['email']);
            $validation_code = clean($_GET['code']);
            $esc_email = escape_sql($email);
            $esc_validation_code = escape_sql($validation_code);

            $sql = "SELECT id FROM users WHERE email = '$esc_email' AND validation_code = '$esc_validation_code'";
            $result = query($sql);
            confirm($result);
            if (row_count($result) == 1) {
                $sql_2 = "UPDATE users SET active = 1, validation_code = 0 WHERE email = '$esc_email' AND validation_code = '$esc_validation_code'";
                $result_2 = query($sql_2);
                confirm($result_2);
                set_message("<h3>Account has been activated.</h3>");
                redirect("login.php");
            } else {
                set_message("<h3>Error! User Activation failed</h3>");
                redirect("register.php");
            }
        } else {
            set_message("<h3>Error! User Activation failed</h3>");
            redirect("register.php");
        }
    }
}

function validate_user_login()
{
    $errors = [];
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $username = clean($_POST['username']);
        $password = clean($_POST['password']);
        $remember = isset($_POST['remember']);

        if (empty($username)) {
            $errors[] = "<span class='server_error_message'>Username Can&acute;t be Empty.</span>";
        }
        if (empty($password)) {
            $errors[] = "<span class='server_error_message'>Password Can&acute;t be Empty.</span>";
        }

        if (!empty($errors)) {
            foreach ($errors as $error) echo validation_errors($error);
        } else {
            if (login_user($username, $password, $remember)) {
                login_user_profile_redirect();
            } else {
                set_message("<h3>Error! User login failed</h3>");
            }
        }
    }
}

function login_user($username, $password, $remember)
{
    $esc_username = escape_sql($username);
    $esc_password = escape_sql($password);
    $esc_remember = escape_sql($remember);

    if (!username_exists($esc_username)) {
        return false;
    }

    $sql = "SELECT id, password FROM users WHERE username = '$esc_username' AND active = 1 AND validation_code = 0";
    $result = query($sql);
    confirm($result);
    if (row_count($result) == 1) {
        $row = fetch_array($result);
        $db_password = $row['password'];
        $useID = $row['id'];

        if (md5($esc_password) === $db_password) {
            $_SESSION['username'] = $esc_username;
            $_SESSION['userID'] = $useID;
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function login_user_profile_redirect()
{
    if (get_logged_in()) {
        $sql = "SELECT role FROM users WHERE username = '" . escape_sql($_SESSION['username']) . "' AND active = 1 AND validation_code = 0";
        $result = query($sql);
        confirm($result);

        if (row_count($result) == 1) {
            $row = fetch_array($result);
            $userRole = $row['role'];
            $_SESSION['logged_id'] = $row['id'];
            $_SESSION['userRole'] = $row['role'];

            if ($userRole === 'admin') {
                redirect('admin.php');
            }
            if ($userRole === 'customer') {
                redirect('customer.php');
            }
        }
    }
}