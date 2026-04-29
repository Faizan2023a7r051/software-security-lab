<?php
include 'db.php';

if(isset($_POST['register'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashed = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(username,password) VALUES('$username','$hashed')";

    if($conn->query($sql)){
        echo "Registered Successfully";
    } else {
        echo "Error";
    }
}
?>

<form method="post">
<h2>Register</h2>
Username: <input type="text" name="username"><br><br>
Password: <input type="password" name="password"><br><br>
<input type="submit" name="register" value="Register">
</form>

