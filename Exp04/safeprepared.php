<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'faizan.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // â ï¸  INTENTIONALLY VULNERABLE â NO sanitization (SQLi + XSS for lab use)
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQLi vulnerability: raw user input injected directly into query
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        // XSS vulnerability: username echoed back without escaping
        $message = "Login Successful! Welcome, " . $username;
    } else {
        $message = "Invalid Credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login â Lab Demo</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
 min-height: 100vh;
        }

        .card {
            background: #fff;
            padding: 2rem 2.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 380px;
        }

        h2 {
            margin-bottom: 1.5rem;
            font-size: 1.4rem;
            color: #333;
            text-align: center;
        }

        .message {
            margin-bottom: 1rem;
            padding: 0.75rem 1rem;
            border-radius: 6px;
            font-size: 0.9rem;
            background: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 0.3rem;
            font-size: 0.85rem;
            color: #555;
font-weight: 600;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 0.6rem 0.8rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 0.95rem;
            margin-bottom: 1rem;
            transition: border-color 0.2s;
        }

        input:focus {
            outline: none;
            border-color: #4a90e2;
        }

        button {
            width: 100%;
            padding: 0.75rem;
            background: #4a90e2;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s;
        }

        button:hover { background: #357abd; }

        .warning {
            margin-top: 1.2rem;
            font-size: 0.75rem;
            color: #999;
            text-align: center;
        }
</style>
</head>
<body>
    <div class="card">
        <h2>ð System Login</h2>

        <?php if ($message): ?>
            <!-- XSS: $message contains unsanitized $username â intentional for lab -->
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter username">

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter password">

            <button type="submit">Login</button>
        </form>

        <p class="warning"></p>
    </div>
</body>
</html>
