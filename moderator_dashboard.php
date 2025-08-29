<?php
session_start();

// Only allow moderators
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'moderator') {
    header("Location: login.php");
    exit();
}

$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Moderator';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Moderator Dashboard - MangaForAll</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
  <h1>MangaForAll - Moderator</h1>
  <nav>
      <a href="index.php">Home</a>
      <a href="forum.php">Manage Forum</a>
      <a href="logout.php">Logout</a>
  </nav>
</header>

<main>
  <h2 class="page-title">Welcome, <?php echo htmlspecialchars($username); ?>!</h2>
  <ul>
      <li><a href="forum.php">Moderate Forum Posts & Comments</a></li>
      <li><a href="logout.php">Logout</a></li>
  </ul>
</main>

<footer>
  <p>© 2025 MangaForAll. All rights reserved.</p>
</footer>
</body>
</html>
