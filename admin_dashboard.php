<?php
  $title = 'Admin Dashboard — MangaForAll';
  $active = 'logout'; // show Logout in nav for admins
  require __DIR__ . '/header.php';
?>
  <h2 class="page-title">Admin Dashboard</h2>
  <p class="subtitle">Moderation and content controls at a glance.</p>

  <section class="kpis">
    <div class="card kpi"><span>Posts moderated</span><strong>25</strong></div>
    <div class="card kpi"><span>Comments moderated</span><strong>80</strong></div>
    <div class="card kpi"><span>Contents added</span><strong>12</strong></div>
    <div class="card kpi"><span>Contents removed</span><strong>3</strong></div>
  </section>

  <section class="grid" style="grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));">
    <article class="card stack">
      <h3 class="section-title">Moderator Panel</h3>
      <button class="btn" type="button">View Reports</button>
    </article>

    <article class="card stack">
      <h3 class="section-title">Content Manager</h3>
      <div class="grid" style="grid-template-columns: 1fr 1fr;">
        <button class="btn" type="button">Add Manga</button>
        <button class="btn ghost" type="button">Remove Manga</button>
      </div>
    </article>
  </section>
<?php require __DIR__ . '/footer.php'; ?>
