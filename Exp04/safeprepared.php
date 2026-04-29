<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include 'faizan.php';

$message = "";

/* ------------------ CSRF TOKEN ------------------ */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/* ------------------ HANDLE FORM ------------------ */
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // CSRF check
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("CSRF validation failed");
    }

    // Input validation
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $message = "All fields are required!";
    } else {

        /* ----------- SQL Injection FIX ----------- */
        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            /* ----------- PASSWORD VERIFY ----------- */
            if (password_verify($password, $user['password'])) {

                // Session fixation protection
                session_regenerate_id(true);

                $_SESSION['user'] = $user['username'];

                $message = "Login Successful! Welcome, " . htmlspecialchars($username, ENT_QUOTES, 'UTF-8');

            } else {
                $message = "Invalid Credentials!";
            }

        } else {
            $message = "Invalid Credentials!";
        }
    }
}
?>
