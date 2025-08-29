<?php
session_start();

// Only allow regular users
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit();
}

// Username stored in session (set during login)
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'User';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>User Dashboard - MangaForAll</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
  <h1>MangaForAll</h1>
  <nav>
      <a href="index.php">Home</a>
      <a href="manga.php">Manga</a>
      <a href="forum.php">Forum</a>
      <a href="profile.php">Profile</a>
      <a href="logout.php">Logout</a>
  </nav>
</header>

<main>
  <h2 class="page-title">Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
  <ul>
      <li><a href="manga.php">Read Manga</a></li>
      <li><a href="profile.php">My Profile</a></li>
      <li><a href="logout.php">Logout</a></li>
  </ul>
</main>

<footer>
  <p>© 2025 MangaForAll. All rights reserved.</p>
</footer>
</body>
</html>
