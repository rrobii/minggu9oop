<?php
session_start();
require_once 'User.php';

if (!isset($_SESSION['id'])) {
    header("location:login.php");
    exit();
}

$user = new User();
$currentUser = $user->getUser($_SESSION['id']);

if (!$currentUser) {
    session_destroy();
    header("location:login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>
    <h2>Welcome, <?php echo $currentUser['user_fullname']; ?></h2>
    <p>Email: <?php echo $currentUser['user_email']; ?></p>
    <p>Level: <?php echo $currentUser['level']; ?></p>
    <a href="edit.php">Edit Profile</a>
    <a href="logout.php">Logout</a>
    <?php if ($currentUser['level'] == 1): ?>
        <h3>User List</h3>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Fullname</th>
                <th>Action</th>
            </tr>
            <?php
            $users = $user->getAllUsers();
            foreach($users as $row):
            ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['user_email']; ?></td>
                <td><?php echo $row['user_fullname']; ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <a href="hapus.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>