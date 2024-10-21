<?php
require_once 'User.php';

$user = new User();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $fullname = $_POST['fullname'];
    
    $result = $user->register($email, $password, $fullname);
    
    if ($result === true) {
        header("location:login.php");
        exit();
    } else {
        $error = $result;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <?php if(isset($error)) { echo "<p style='color:red'>$error</p>"; } ?>
    <form method="post" action="">
        <label>Email:</label><br>
        <input type="email" name="email" required><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br>
        <label>Nama Lengkap:</label><br>
        <input type="text" name="fullname" required><br><br>
        <input type="submit" value="Register">
    </form>
    <p>Sudah punya akun? <a href="login.php">Login disini</a></p>
</body>
</html>