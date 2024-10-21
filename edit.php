<?php
session_start();
require_once 'User.php';

if (!isset($_SESSION['id'])) {
    header("location:login.php");
    exit();
}

$user = new User();
$id = isset($_GET['id']) ? $_GET['id'] : $_SESSION['id'];
$userData = $user->getUser($id);

if (!$userData) {
    header("location:home.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $fullname = $_POST['fullname'];
    $level = $_POST['level'];
    
    $result = $user->updateUser($id, $email, $fullname, $level);
    
    if ($result === true) {
        header("location:home.php");
        exit();
    } else {
        $error = $result;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
</head>
<body>
    <h2>Edit Profile</h2>
    <?php if(isset($error)) { echo "<p style='color:red'>$error</p>"; } ?>
    <form method="post" action="">
        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo $userData['user_email']; ?>" required><br>
        <label>Nama Lengkap:</label><br>
        <input type="text" name="fullname" value="<?php echo $userData['user_fullname']; ?>" required><br>
        <label>Level:</label><br>
        <select name="level">
            <option value="1" <?php if($userData['level'] == 1) echo 'selected'; ?>>Admin</option>
            <option value="2" <?php if($userData['level'] == 2) echo 'selected'; ?>>User</option>
        </select><br><br>
        <input type="submit" value="Update">
    </form>
    <a href="home.php">Back to Home</a>
</body>
</html>