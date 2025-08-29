<?php
  $title = 'Forum — MangaForAll';
  $active = 'forum';
  require __DIR__ . '/../partials/header.php';
?>
  <h2 class="page-title">Community Forum</h2>

  <article class="card post">
    <h3>Best Manga of 2025?</h3>
    <p class="meta">Posted by <strong>User123</strong> · 2 hours ago</p>
    <p>Which manga are you enjoying the most right now?</p>

    <div class="comments stack">
      <p><strong>Commenter1:</strong> Definitely Attack on Manga!</p>
      <p><strong>Commenter2:</strong> One Manga has been great.</p>
    </div>

    <div class="stack">
      <label for="reply" class="section-title">Reply</label>
      <textarea id="reply" class="textarea" rows="3" placeholder="Write a comment..."></textarea>
      <button class="btn" type="button">Post Reply</button>
    </div>
  </article>
<?php require __DIR__ . '/../partials/footer.php'; ?>
