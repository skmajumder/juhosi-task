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

/** Validate register user */

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
                return;
            }
        }
    }
}