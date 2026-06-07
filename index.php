<?php
require_once __DIR__ . '/classes/Siswa.php';

$siswaObj = new Siswa();

// Proses hapus
if (isset($_GET['hapus'])) {
    $siswaObj->delete((int)$_GET['hapus']);
    header('Location: index.php?msg=hapus');
    exit;
}

$search  = isset($_GET['search']) ? trim($_GET['search']) : '';
$result  = $siswaObj->getAll($search);
$total   = $siswaObj->count();
$msg     = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manajemen Siswa</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  :root {
    --bg:       #0f1117;
    --surface:  #1a1d27;
    --card:     #21253a;
    --border:   #2e3348;
    --accent:   #4f8ef7;
    --accent2:  #7c3aed;
    --green:    #22c55e;
    --red:      #ef4444;
    --yellow:   #f59e0b;
    --text:     #e8eaf0;
    --muted:    #7880a0;
    --radius:   14px;
  }
  * { margin:0; padding:0; box-sizing:border-box; }
  body {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--bg);
    color: var(--text);
    min-height: 100vh;
  }

  /* SIDEBAR */
  .sidebar {
    position: fixed; top:0; left:0;
    width: 240px; height: 100vh;
    background: var(--surface);
    border-right: 1px solid var(--border);
    display: flex; flex-direction: column;
    padding: 24px 16px;
    z-index: 100;
  }
  .sidebar-logo {
    display: flex; align-items: center; gap: 10px;
    padding: 0 8px 24px;
    border-bottom: 1px solid var(--border);
    margin-bottom: 24px;
  }
  .logo-icon {
    width: 36px; height: 36px; border-radius: 10px;
    background: linear-gradient(135deg, var(--accent), var(--accent2));
    display: flex; align-items: center; justify-content: center;
    font-size: 18px;
  }
  .logo-text { font-weight: 800; font-size: 16px; letter-spacing: -.3px; }
  .logo-text span { color: var(--accent); }
  .nav-item {
    display: flex; align-items: center; gap: 10px;
    padding: 10px 12px; border-radius: 10px;
    color: var(--muted); text-decoration: none;
    font-size: 14px; font-weight: 500;
    transition: all .2s;
  }
  .nav-item:hover, .nav-item.active {
    background: var(--card); color: var(--text);
  }
  .nav-item.active { color: var(--accent); }

  /* MAIN */
  .main { margin-left: 240px; padding: 32px; }

  /* TOPBAR */
  .topbar {
    display: flex; align-items: center;
    justify-content: space-between;
    margin-bottom: 32px;
  }
  .page-title { font-size: 24px; font-weight: 800; }
  .page-title span { color: var(--accent); }

  /* STATS */
  .stats { display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; margin-bottom: 28px; }
  .stat-card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 20px 24px;
    display: flex; align-items: center; gap: 16px;
  }
  .stat-icon {
    width: 48px; height: 48px; border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; flex-shrink: 0;
  }
  .stat-icon.blue  { background: rgba(79,142,247,.15); }
  .stat-icon.green { background: rgba(34,197,94,.15); }
  .stat-icon.purple{ background: rgba(124,58,237,.15); }
  .stat-label { font-size: 12px; color: var(--muted); margin-bottom: 4px; font-weight: 500; }
  .stat-value { font-size: 26px; font-weight: 800; }

  /* TOOLBAR */
  .toolbar {
    display: flex; align-items: center; gap: 12px;
    margin-bottom: 16px;
  }
  .search-wrap {
    flex: 1; position: relative;
  }
  .search-wrap input {
    width: 100%; padding: 10px 16px 10px 40px;
    background: var(--card); border: 1px solid var(--border);
    border-radius: 10px; color: var(--text);
    font-family: inherit; font-size: 14px;
    outline: none; transition: border .2s;
  }
  .search-wrap input:focus { border-color: var(--accent); }
  .search-wrap .ico {
    position: absolute; left: 12px; top: 50%;
    transform: translateY(-50%); color: var(--muted); font-size: 16px;
  }
  .btn {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 18px; border-radius: 10px;
    font-family: inherit; font-size: 14px; font-weight: 600;
    border: none; cursor: pointer; text-decoration: none;
    transition: all .2s; white-space: nowrap;
  }
  .btn-primary { background: var(--accent); color: #fff; }
  .btn-primary:hover { background: #3a7be8; }
  .btn-danger  { background: rgba(239,68,68,.15); color: var(--red); }
  .btn-danger:hover { background: rgba(239,68,68,.25); }
  .btn-edit    { background: rgba(79,142,247,.12); color: var(--accent); }
  .btn-edit:hover { background: rgba(79,142,247,.25); }
  .btn-sm { padding: 6px 12px; font-size: 13px; }

  /* TABLE */
  .table-wrap {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow: hidden;
  }
  table { width: 100%; border-collapse: collapse; }
  thead th {
    padding: 14px 16px;
    background: var(--surface);
    font-size: 12px; font-weight: 700;
    text-transform: uppercase; letter-spacing: .6px;
    color: var(--muted);
    text-align: left;
    border-bottom: 1px solid var(--border);
  }
  tbody tr { border-bottom: 1px solid var(--border); transition: background .15s; }
  tbody tr:last-child { border-bottom: none; }
  tbody tr:hover { background: rgba(79,142,247,.04); }
  td { padding: 14px 16px; font-size: 14px; vertical-align: middle; }

  .badge {
    display: inline-flex; align-items: center;
    padding: 4px 10px; border-radius: 20px;
    font-size: 12px; font-weight: 600;
  }
  .badge-laki   { background: rgba(79,142,247,.15); color: #7eb8ff; }
  .badge-perempuan { background: rgba(236,72,153,.15); color: #f9a8d4; }

  .avatar {
    width: 34px; height: 34px; border-radius: 50%;
    display: inline-flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 14px;
    background: linear-gradient(135deg, var(--accent), var(--accent2));
    color: #fff; flex-shrink: 0;
  }
  .cell-nama { display: flex; align-items: center; gap: 10px; }
  .td-actions { display: flex; gap: 6px; }

  /* ALERT */
  .alert {
    padding: 12px 18px; border-radius: 10px;
    margin-bottom: 20px; font-size: 14px; font-weight: 500;
    display: flex; align-items: center; gap: 8px;
  }
  .alert-success { background: rgba(34,197,94,.12); border: 1px solid rgba(34,197,94,.3); color: var(--green); }
  .alert-danger  { background: rgba(239,68,68,.12);  border: 1px solid rgba(239,68,68,.3);  color: var(--red); }

  .empty { text-align: center; padding: 48px; color: var(--muted); }
  .empty .ico { font-size: 48px; margin-bottom: 12px; }
</style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-icon">🎓</div>
    <div class="logo-text">Siswa<span>DB</span></div>
  </div>
  <a href="index.php" class="nav-item active">📋 &nbsp;Data Siswa</a>
  <a href="pages/tambah.php" class="nav-item">➕ &nbsp;Tambah Siswa</a>
</aside>

<!-- MAIN CONTENT -->
<main class="main">
  <div class="topbar">
    <div class="page-title">Data <span>Siswa</span></div>
  </div>

  <?php if ($msg === 'tambah'): ?>
    <div class="alert alert-success">✅ Siswa berhasil ditambahkan.</div>
  <?php elseif ($msg === 'edit'): ?>
    <div class="alert alert-success">✅ Data siswa berhasil diperbarui.</div>
  <?php elseif ($msg === 'hapus'): ?>
    <div class="alert alert-success">🗑️ Data siswa berhasil dihapus.</div>
  <?php endif; ?>

  <!-- STATS -->
  <div class="stats">
    <div class="stat-card">
      <div class="stat-icon blue">👥</div>
      <div>
        <div class="stat-label">Total Siswa</div>
        <div class="stat-value"><?= $total ?></div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon green">🔍</div>
      <div>
        <div class="stat-label">Hasil Pencarian</div>
        <div class="stat-value"><?= $result ? $result->num_rows : 0 ?></div>
      </div>
    </div>
    <div class="stat-card">
      <div class="stat-icon purple">📅</div>
      <div>
        <div class="stat-label">Tahun Ajaran</div>
        <div class="stat-value">2024/25</div>
      </div>
    </div>
  </div>

  <!-- TOOLBAR -->
  <div class="toolbar">
    <form method="GET" class="search-wrap">
      <span class="ico">🔍</span>
      <input type="text" name="search" placeholder="Cari nama, NIS, atau kelas..."
             value="<?= htmlspecialchars($search) ?>">
    </form>
    <a href="pages/tambah.php" class="btn btn-primary">➕ Tambah Siswa</a>
  </div>

  <!-- TABLE -->
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Siswa</th>
          <th>NIS</th>
          <th>Kelas</th>
          <th>Jenis Kelamin</th>
          <th>No. Telepon</th>
          <th>Tgl Masuk</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0):
              $no = 1;
              while ($row = $result->fetch_assoc()):
                $inisial = strtoupper(substr($row['nama'], 0, 1));
        ?>
        <tr>
          <td style="color:var(--muted)"><?= $no++ ?></td>
          <td>
            <div class="cell-nama">
              <div class="avatar"><?= $inisial ?></div>
              <div>
                <div style="font-weight:600"><?= htmlspecialchars($row['nama']) ?></div>
                <div style="font-size:12px;color:var(--muted)"><?= htmlspecialchars($row['email']) ?></div>
              </div>
            </div>
          </td>
          <td style="font-family:monospace;font-size:13px"><?= htmlspecialchars($row['nis']) ?></td>
          <td><span style="font-weight:600"><?= htmlspecialchars($row['kelas']) ?></span></td>
          <td>
            <?php if ($row['jenis_kelamin'] === 'Laki-laki'): ?>
              <span class="badge badge-laki">♂ Laki-laki</span>
            <?php else: ?>
              <span class="badge badge-perempuan">♀ Perempuan</span>
            <?php endif; ?>
          </td>
          <td><?= htmlspecialchars($row['no_telepon'] ?: '-') ?></td>
          <td style="color:var(--muted);font-size:13px">
            <?= $row['tanggal_masuk'] ? date('d M Y', strtotime($row['tanggal_masuk'])) : '-' ?>
          </td>
          <td>
            <div class="td-actions">
              <a href="pages/edit.php?id=<?= $row['id'] ?>" class="btn btn-edit btn-sm">✏️ Edit</a>
              <a href="index.php?hapus=<?= $row['id'] ?>"
                 class="btn btn-danger btn-sm"
                 onclick="return confirm('Hapus data <?= htmlspecialchars($row['nama']) ?>?')">🗑️</a>
            </div>
          </td>
        </tr>
        <?php endwhile; else: ?>
        <tr>
          <td colspan="8">
            <div class="empty">
              <div class="ico">📭</div>
              <div>Tidak ada data siswa ditemukan.</div>
            </div>
          </td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</main>

</body>
</html>
