<?php
// Partials: header.php
// Usage:
//   $title = 'Page Title';
//   $active = 'manga'; // home|manga|forum|profile|login|logout
//   require __DIR__ . '/header.php';
if (!isset($title)) { $title = 'MangaForAll'; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo htmlspecialchars($title); ?></title>
  <link rel="stylesheet" href="/css/style.css" />
</head>
<body>
<header class="site-header">
  <div class="container navbar">
    <a class="brand" href="/index.php"><span class="dot" aria-hidden="true"></span><span>MangaForAll</span></a>
    <nav class="nav" aria-label="Primary">
      <a href="/index.php" <?php if(($active ?? '')==='home') echo 'aria-current="page"'; ?>>Home</a>
      <a href="/pages/manga.php" <?php if(($active ?? '')==='manga') echo 'aria-current="page"'; ?>>Manga</a>
      <a href="/pages/forum.php" <?php if(($active ?? '')==='forum') echo 'aria-current="page"'; ?>>Forum</a>
      <a href="/pages/profile.php" <?php if(($active ?? '')==='profile') echo 'aria-current="page"'; ?>>Profile</a>
      <?php if(($active ?? '')==='logout'): ?>
        <a href="/logout.php" aria-current="page">Logout</a>
      <?php else: ?>
        <a href="/login.php" <?php if(($active ?? '')==='login') echo 'aria-current="page"'; ?>>Login</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
<main class="container stack">
