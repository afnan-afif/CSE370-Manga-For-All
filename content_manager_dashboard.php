<?php
session_start();

// Only allow content managers
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'content_manager') {
    header("Location: login.php");
    exit();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Content Manager';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Content Manager Dashboard - MangaForAll</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
  <h1>MangaForAll - Content Manager</h1>
  <nav>
      <a href="index.php">Home</a>
      <a href="manga.php">Manga</a>
      <a href="add_manga.php">Add Manga</a>
      <a href="logout.php">Logout</a>
  </nav>
</header>

<main>
  <h2 class="page-title">Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
  <ul>
      <li><a href="add_manga.php">Add or Manage Manga</a></li>
      <li><a href="manga.php">View Manga List</a></li>
      <li><a href="logout.php">Logout</a></li>
  </ul>
</main>

<footer>
  <p>© 2025 MangaForAll. All rights reserved.</p>
</footer>
</body>
</html>
