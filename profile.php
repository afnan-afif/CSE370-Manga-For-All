<?php
  $title = 'My Profile — MangaForAll';
  $active = 'profile';
  require __DIR__ . '/header.php';
?>
  <h2 class="page-title">My Profile</h2>

  <section class="grid profile-grid">
    <div class="card stack">
      <h3 class="section-title">User Information</h3>
      <p><strong>Username:</strong> MangaFan99</p>
      <p><strong>Email:</strong> user@email.com</p>
      <p><strong>Joined:</strong> Jan 2025</p>
    </div>

    <div class="card stack">
      <h3 class="section-title">My Reviews</h3>
      <p><strong>Attack on Manga:</strong> ★★★★☆ — Great story!</p>
      <p><strong>One Manga:</strong> ★★★☆☆ — Decent read.</p>
    </div>

    <div class="card stack">
      <h3 class="section-title">My Wishlist</h3>
      <ul class="stack" style="list-style: disc; padding-left: 18px;">
        <li>Attack on Manga</li>
        <li>One Manga</li>
      </ul>
    </div>

    <div class="card stack">
      <h3 class="section-title">My Bookmarks</h3>
      <ul class="stack" style="list-style: disc; padding-left: 18px;">
        <li>Chapter 12 of Attack on Manga</li>
        <li>Chapter 5 of One Manga</li>
      </ul>
    </div>
  </section>
<?php require __DIR__ . '/footer.php'; ?>
