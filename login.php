<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        die("❌ Please fill in both fields.");
    }

    // 1️⃣ Check Users table
    $sqlUser = "SELECT u.user_id, ua.password_hash 
                FROM Users u 
                JOIN User_auth ua ON u.user_id = ua.user_id
                WHERE u.username = '$username'";
    $resultUser = $conn->query($sqlUser);

    if ($resultUser && $resultUser->num_rows > 0) {
        $row = $resultUser->fetch_assoc();
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['role'] = 'user';
            header("Location: user_dashboard.php");
            exit();
        } else {
            die("❌ Incorrect password for user.");
        }
    }

    // 2️⃣ Check ContentManager table
    $sqlCM = "SELECT cm.content_manager_id, cm.password_hash 
              FROM ContentManager cm 
              WHERE cm.username = '$username'";
    $resultCM = $conn->query($sqlCM);

    if ($resultCM && $resultCM->num_rows > 0) {
        $row = $resultCM->fetch_assoc();
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['admin_id'] = $row['content_manager_id'];
            $_SESSION['role'] = 'content_manager';
            header("Location: admin_dashboard.php");
            exit();
        } else {
            die("❌ Incorrect password for content manager.");
        }
    }

    // 3️⃣ Check Moderator table
    $sqlMod = "SELECT m.moderator_id, m.password_hash 
               FROM Moderator m 
               WHERE m.username = '$username'";
    $resultMod = $conn->query($sqlMod);

    if ($resultMod && $resultMod->num_rows > 0) {
        $row = $resultMod->fetch_assoc();
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['admin_id'] = $row['moderator_id'];
            $_SESSION['role'] = 'moderator';
            header("Location: moderator_dashboard.php");
            exit();
        } else {
            die("❌ Incorrect password for moderator.");
        }
    }

    die("❌ Username not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login - MangaForAll</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1>Login</h1>
<form method="POST" action="login.php">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
</body>
</html>
