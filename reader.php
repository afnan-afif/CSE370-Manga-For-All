<?php
/* ============================================
   reader.php — single-file, works by itself
   ============================================ */

/* ====== CONFIG ====== */
$FS_ROOT  = 'D:\\Xampp\\htdocs\\MangaForAll\\Resources'; // disk path to manga root
$URL_ROOT = '/MangaForAll/Resources';                    // URL path to same root
/* ==================== */

/* helpers */
function num_part(string $s): float { return preg_match('/(\d+(?:\.\d+)?)/',$s,$m)?(float)$m[1]:INF; }
function label_num(float $n): string { return rtrim(rtrim(number_format($n,2,'.',''),'0'),'.'); }
function fs_to_url(string $fs,string $FS_ROOT,string $URL_ROOT): string {
  $fs=str_replace('\\','/',$fs); $root=rtrim(str_replace('\\','/',$FS_ROOT),'/');
  return strpos($fs,$root)===0 ? $URL_ROOT.substr($fs,strlen($root)) : $fs;
}
function list_dirs(string $base): array {
  $g = glob(rtrim($base,'\\/').DIRECTORY_SEPARATOR.'*', GLOB_ONLYDIR) ?: [];
  usort($g,'strnatcasecmp'); return $g;
}
function list_images(string $dir): array {
  $g = glob(rtrim($dir,'\\/').DIRECTORY_SEPARATOR.'*.*') ?: [];
  $imgs = array_values(array_filter($g,function($p){
    return in_array(strtolower(pathinfo($p, PATHINFO_EXTENSION)), ['jpg','jpeg','png','webp','gif']);
  }));
  usort($imgs,function($a,$b){ $na=num_part(basename($a)); $nb=num_part(basename($b));
    return $na==$nb ? strnatcmp(basename($a),basename($b)) : (($na<$nb)?-1:1);
  });
  return $imgs;
}

/* inputs and mode */
$manga = isset($_GET['title']) ? trim($_GET['title']) : '';
$chReq = isset($_GET['ch'])    ? trim($_GET['ch'])    : '';
$mode = $manga === '' ? 'list-manga' : ($chReq === '' ? 'list-chapters' : 'render-pages');

/* resolve chapters/pages if needed */
$chapters = []; $index = 0; $current = null; $pages = [];
if ($mode !== 'list-manga') {
  $mangaDir = rtrim($FS_ROOT,'\\/').DIRECTORY_SEPARATOR.basename($manga);
  if (!is_dir($mangaDir)) { $mode='error'; }
  else {
    foreach (list_dirs($mangaDir) as $d) $chapters[] = ['num'=>num_part(basename($d)),'name'=>basename($d),'dir'=>$d];
    usort($chapters,function($a,$b){ return $a['num']==$b['num'] ? strnatcmp($a['name'],$b['name']) : (($a['num']<$b['num'])?-1:1); });
    if ($mode==='render-pages' && $chapters) {
      $want=(float)$chReq; foreach ($chapters as $i=>$c) if ($c['num']==$want) { $index=$i; break; }
      $current = $chapters[$index] ?? null;
      if ($current) $pages = list_images($current['dir']);
    }
  }
}
?><!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Reader — MangaForAll</title>
<style>
  :root{--bg:#0f172a;--surface:#111827;--surface2:#0b1222;--text:#e5e7eb;--muted:#94a3b8;--brand:#60a5fa;--brand2:#3b82f6;--gap:20px;--radius:14px}
  *{box-sizing:border-box} body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto,Arial;background:var(--bg);color:var(--text);line-height:1.55}
  a{text-decoration:none;color:inherit}
  .container{width:min(1100px,92%);margin:0 auto}
  .stack>*+*{margin-top:var(--gap)} .grid{display:grid;gap:var(--gap)}
  .card{background:linear-gradient(180deg,var(--surface),var(--surface2));border:1px solid rgba(148,163,184,.12);border-radius:var(--radius);padding:16px;box-shadow:0 10px 30px rgba(0,0,0,.35)}
  header{position:sticky;top:0;z-index:10;background:linear-gradient(180deg,rgba(15,23,42,.95),rgba(17,24,39,.85));border-bottom:1px solid rgba(148,163,184,.12)}
  .navbar{display:flex;justify-content:space-between;align-items:center;padding:14px 0}
  .brand{display:flex;align-items:center;gap:10px;font-weight:800} .brand .dot{width:10px;height:10px;border-radius:2px;background:linear-gradient(135deg,var(--brand),#22d3ee);box-shadow:0 0 20px rgba(34,211,238,.5)}
  .nav{display:flex;gap:16px} .nav a{color:var(--muted);padding:8px 12px;border-radius:10px} .nav a:hover{background:rgba(96,165,250,.12);color:var(--text)}
  .page-title{text-align:center;font-weight:800;margin:26px 0} .subtitle{text-align:center;color:var(--muted);margin-top:-10px}
  .btn{background:linear-gradient(135deg,var(--brand),var(--brand2));color:#0b1222;border:1px solid rgba(255,255,255,.08);border-radius:12px;padding:10px 14px;font-weight:700;cursor:pointer;display:inline-block;text-align:center;box-shadow:0 6px 16px rgba(59,130,246,.3)}
  .btn:hover{filter:brightness(1.08);box-shadow:0 10px 22px rgba(59,130,246,.38)} .btn:disabled{opacity:.55;cursor:not-allowed;box-shadow:none}
  .btn.ghost{background:transparent;color:var(--text);border:1px solid rgba(148,163,184,.18);box-shadow:none} .btn.ghost:hover{background:rgba(96,165,250,.1)}
  .manga-grid{grid-template-columns:repeat(auto-fit,minmax(220px,1fr))}
  .reader-shell{max-width:min(1100px,96vw);margin:0 auto}
  .page{padding:0;border-radius:8px;overflow:hidden}
  .page-img{display:block;width:100%;height:auto !important} /* never distort */
  footer{margin-top:40px;border-top:1px solid rgba(148,163,184,.12);background:linear-gradient(180deg,rgba(17,24,39,.85),rgba(15,23,42,.95))}
  footer .container{padding:18px 0;color:var(--muted);text-align:center;font-size:14px}
</style>
</head>
<body>
<header>
  <div class="container navbar">
    <a class="brand" href="/MangaForAll/reader.php"><span class="dot"></span><span>MangaForAll</span></a>
    <nav class="nav">
      <a href="/MangaForAll/reader.php">Reader</a>
      <a href="/MangaForAll/manga.php">Manga</a>
      <a href="/MangaForAll/forum.php">Forum</a>
      <a href="/MangaForAll/profile.php">Profile</a>
    </nav>
  </div>
</header>

<main class="container stack">
<?php if ($mode === 'list-manga'): ?>
  <h2 class="page-title">Choose a Manga</h2>
  <section class="grid manga-grid">
    <?php foreach (list_dirs($FS_ROOT) as $p): $slug=basename($p); ?>
      <article class="card stack">
        <h3><?= htmlspecialchars($slug) ?></h3>
        <a class="btn" href="?title=<?= urlencode($slug) ?>">Open</a>
      </article>
    <?php endforeach; ?>
  </section>

<?php elseif ($mode === 'error'): ?>
  <h2 class="page-title">Reader</h2>
  <p class="subtitle">Manga not found: <?= htmlspecialchars($manga) ?></p>

<?php elseif ($mode === 'list-chapters'): ?>
  <h2 class="page-title"><?= htmlspecialchars($manga) ?></h2>
  <?php if (!$chapters): ?>
    <p class="subtitle">No chapters found.</p>
  <?php else: ?>
    <p class="subtitle">Choose a chapter</p>
    <section class="grid manga-grid">
      <?php foreach ($chapters as $c):
            $label = is_finite($c['num']) ? 'Chapter '.label_num($c['num']) : $c['name']; ?>
        <article class="card stack">
          <h3><?= htmlspecialchars($label) ?></h3>
          <a class="btn" href="?title=<?= urlencode($manga) ?>&ch=<?= $c['num'] ?>">Read</a>
        </article>
      <?php endforeach; ?>
    </section>
  <?php endif; ?>

<?php elseif ($mode === 'render-pages'): ?>
  <?php $label = $current ? label_num($current['num']) : ''; $total=count($chapters); ?>
  <h2 class="page-title"><?= htmlspecialchars($manga) ?></h2>
  <p class="subtitle">Reading Chapter <?= htmlspecialchars($label) ?> (<?= ($index+1).' / '.$total ?>)</p>

  <!-- TOP NAV -->
  <div class="grid" style="grid-template-columns:1fr auto 1fr; align-items:center;">
    <div>
      <?php if ($index>0): $prev=$chapters[$index-1]; ?>
        <a id="prev-chapter-btn" class="btn" href="?title=<?= urlencode($manga) ?>&ch=<?= $prev['num'] ?>">← Prev</a>
      <?php else: ?>
        <button id="prev-chapter-btn" class="btn" disabled>← Prev</button>
      <?php endif; ?>
    </div>
    <div style="text-align:center;">
      <form method="get" action="" style="display:inline">
        <input type="hidden" name="title" value="<?= htmlspecialchars($manga) ?>">
        <select name="ch" class="btn ghost" onchange="this.form.submit()">
          <?php foreach ($chapters as $i=>$c): $lab=is_finite($c['num'])?label_num($c['num']):$c['name']; ?>
            <option value="<?= $c['num'] ?>" <?= $i===$index?'selected':'' ?>>Chapter <?= htmlspecialchars($lab) ?></option>
          <?php endforeach; ?>
        </select>
      </form>
    </div>
    <div style="text-align:right">
      <?php if ($index<$total-1): $next=$chapters[$index+1]; ?>
        <a id="next-chapter-btn" class="btn" href="?title=<?= urlencode($manga) ?>&ch=<?= $next['num'] ?>">Next →</a>
      <?php else: ?>
        <button id="next-chapter-btn" class="btn" disabled>Next →</button>
      <?php endif; ?>
    </div>
  </div>

  <!-- PAGES -->
  <section class="stack reader-shell">
    <?php if (!$pages): ?>
      <article class="card" style="padding:16px"><p class="subtitle">No pages in this chapter.</p></article>
    <?php else: foreach ($pages as $p): $url=fs_to_url($p,$FS_ROOT,$URL_ROOT); ?>
      <article class="card page"><img class="page-img" src="<?= htmlspecialchars($url) ?>" alt="Page"></article>
    <?php endforeach; endif; ?>
  </section>

  <!-- BOTTOM NAV -->
  <div class="grid" style="grid-template-columns:1fr 1fr; gap:12px; align-items:center; padding-bottom:12px;">
    <div>
      <?php if ($index>0): $prev=$chapters[$index-1]; ?>
        <a id="prev-chapter-btn-bottom" class="btn" href="?title=<?= urlencode($manga) ?>&ch=<?= $prev['num'] ?>">← Previous Chapter</a>
      <?php else: ?>
        <button id="prev-chapter-btn-bottom" class="btn" disabled>← Previous Chapter</button>
      <?php endif; ?>
    </div>
    <div style="text-align:right">
      <?php if ($index<$total-1): $next=$chapters[$index+1]; ?>
        <a id="next-chapter-btn-bottom" class="btn" href="?title=<?= urlencode($manga) ?>&ch=<?= $next['num'] ?>">Next Chapter →</a>
      <?php else: ?>
        <button id="next-chapter-btn-bottom" class="btn" disabled>Next Chapter →</button>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>
</main>

<footer><div class="container">© 2025 MangaForAll. All rights reserved.</div></footer>
</body></html>
