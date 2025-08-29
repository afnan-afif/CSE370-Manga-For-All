<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "❌ Passwords do not match!";
    } else {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO Users (username, email, joining_date, no_of_chapters_read) 
                VALUES ('$username', '$email', CURDATE(), 0)";
        
        if ($conn->query($sql) === TRUE) {
            $user_id = $conn->insert_id;
            $sql2 = "INSERT INTO User_auth (user_id, password_hash, admin_id) 
                     VALUES ($user_id, '$password_hash', NULL)";
            $conn->query($sql2);

            // Auto-login after registration
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['is_admin'] = false;

            header("Location: user_dashboard.php");
            exit();
        } else {
            $error = "❌ Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - MangaForAll</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
  <h1>MangaForAll</h1>
  <nav>
      <a href="index.php">Home</a>
      <a href="manga.php">Manga</a>
      <a href="forum.php">Forum</a>
      <?php
      if (isset($_SESSION['user_id'])) {
          echo '<a href="profile.php">Profile</a>';
          echo '<a href="logout.php">Logout</a>';
      } else {
          echo '<a href="login.php">Login</a>';
          echo '<a href="register.php">Register</a>';
      }
      ?>
  </nav>
</header>

<main>
  <h2 class="page-title">Register</h2>
  <form action="register.php" method="POST" class="auth-form">
      <input type="text" name="username" placeholder="Username" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="password" name="confirm_password" placeholder="Confirm Password" required>
      <button type="submit">Register</button>
  </form>
  <?php if(isset($error)) echo "<p style='color:red; text-align:center;'>$error</p>"; ?>
</main>

<footer>
  <p>© 2025 MangaForAll. All rights reserved.</p>
</footer>
</body>
</html>
