<?php
  $title = 'Manga Library — MangaForAll';
  $active = 'manga';
  require __DIR__ . '/header.php';
?>
  <h2 class="page-title">Manga Library</h2>
  <p class="subtitle">Browse series and jump straight into reading.</p>

  <section class="grid manga-grid">
    <article class="card manga-card">
      <img src="https://via.placeholder.com/480x640" alt="Attack on Manga cover" />
      <h3>Attack on Manga</h3>
      <p class="meta">Author: John Doe</p>
      <p class="meta">Status: <span class="badge">Ongoing</span></p>
      <div class="grid" style="grid-template-columns: 1fr 1fr;">
        <a class="btn" href="/reader.php?title=attack-on-manga">Read</a>
        <button class="btn ghost" type="button">Add to Wishlist</button>
      </div>
    </article>

    <article class="card manga-card">
      <img src="https://via.placeholder.com/480x640" alt="One Manga cover" />
      <h3>One Manga</h3>
      <p class="meta">Author: Jane Smith</p>
      <p class="meta">Status: <span class="badge">Completed</span></p>
      <div class="grid" style="grid-template-columns: 1fr 1fr;">
        <a class="btn" href="/reader.php?title=one-manga">Read</a>
        <button class="btn ghost" type="button">Add to Wishlist</button>
      </div>
    </article>
  </section>
<?php require __DIR__ . '/footer.php'; ?>
