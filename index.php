<?php
  $title = 'MangaForAll — Home';
  $active = 'home';
  require __DIR__ . 'header.php';
?>
  <h2 class="page-title">Welcome to MangaForAll</h2>
  <p class="subtitle">Read. Discuss. Collect. Repeat.</p>

  <section class="grid" style="grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));">
    <article class="card stack">
      <h3>Jump into the Library</h3>
      <p class="meta">Browse series and keep your wishlist updated.</p>
      <a class="btn" href="manga.php">Open Library</a>
    </article>

    <article class="card stack">
      <h3>Join the Community</h3>
      <p class="meta">Ask, answer, and argue about your favorites.</p>
      <a class="btn" href="/forum.php">Go to Forum</a>
    </article>

    <article class="card stack">
      <h3>Your Profile</h3>
      <p class="meta">See bookmarks, reviews, and settings.</p>
      <a class="btn" href="/profile.php">View Profile</a>
    </article>
  </section>
<?php require __DIR__ . '/footer.php'; ?>
