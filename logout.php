<?php

include('./functions/init.php');

session_destroy();

if (isset($_COOKIE['username'])) {
    unset($_COOKIE['username']);
}

redirect('login.php');