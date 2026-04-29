<?php
include 'db.php';

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();

        if(password_verify($password, $row['password'])){
            echo "Login Successful";
        } else {
            echo "Wrong Password";
        }
    } else {
        echo "User Not Found";
    }
}
?>

<form method="post">
<h2>Login</h2>
Username: <input type="text" name="username"><br><br>
Password: <input type="password" name="password"><br><br>
<input type="submit" name="login" value="Login">
</form>
