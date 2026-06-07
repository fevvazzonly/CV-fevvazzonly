<?php
require_once __DIR__ . '/../classes/Siswa.php';

$siswaObj = new Siswa();
$errors   = [];

// Ambil data
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) { header('Location: ../index.php'); exit; }

$row = $siswaObj->getById($id);
if (!$row) { header('Location: ../index.php'); exit; }

$data = $row;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    $data['id'] = $id;

    if (empty($data['nis']))   $errors[] = 'NIS wajib diisi.';
    if (empty($data['nama']))  $errors[] = 'Nama wajib diisi.';
    if (empty($data['kelas'])) $errors[] = 'Kelas wajib diisi.';

    if (!empty($data['nis']) && $siswaObj->nisExists($data['nis'], $id)) {
        $errors[] = 'NIS sudah digunakan siswa lain.';
    }

    if (empty($errors)) {
        $siswaObj->id            = $id;
        $siswaObj->nis           = $data['nis'];
        $siswaObj->nama          = $data['nama'];
        $siswaObj->jenis_kelamin = $data['jenis_kelamin'];
        $siswaObj->kelas         = $data['kelas'];
        $siswaObj->alamat        = $data['alamat'];
        $siswaObj->no_telepon    = $data['no_telepon'];
        $siswaObj->email         = $data['email'];
        $siswaObj->tanggal_masuk = $data['tanggal_masuk'];

        if ($siswaObj->update()) {
            header('Location: ../index.php?msg=edit');
            exit;
        } else {
            $errors[] = 'Gagal memperbarui data.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Siswa</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  :root { --bg:#0f1117; --surface:#1a1d27; --card:#21253a; --border:#2e3348; --accent:#4f8ef7; --accent2:#7c3aed; --red:#ef4444; --text:#e8eaf0; --muted:#7880a0; --radius:14px; }
  * { margin:0; padding:0; box-sizing:border-box; }
  body { font-family:'Plus Jakarta Sans',sans-serif; background:var(--bg); color:var(--text); min-height:100vh; }
  .sidebar { position:fixed; top:0; left:0; width:240px; height:100vh; background:var(--surface); border-right:1px solid var(--border); display:flex; flex-direction:column; padding:24px 16px; z-index:100; }
  .sidebar-logo { display:flex; align-items:center; gap:10px; padding:0 8px 24px; border-bottom:1px solid var(--border); margin-bottom:24px; }
  .logo-icon { width:36px; height:36px; border-radius:10px; background:linear-gradient(135deg,var(--accent),var(--accent2)); display:flex; align-items:center; justify-content:center; font-size:18px; }
  .logo-text { font-weight:800; font-size:16px; } .logo-text span { color:var(--accent); }
  .nav-item { display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; color:var(--muted); text-decoration:none; font-size:14px; font-weight:500; transition:all .2s; }
  .nav-item:hover,.nav-item.active { background:var(--card); color:var(--text); }
  .main { margin-left:240px; padding:32px; max-width:860px; }
  .page-title { font-size:24px; font-weight:800; margin-bottom:8px; } .page-title span { color:var(--accent); }
  .breadcrumb { font-size:13px; color:var(--muted); margin-bottom:28px; } .breadcrumb a { color:var(--accent); text-decoration:none; }
  .form-card { background:var(--card); border:1px solid var(--border); border-radius:var(--radius); padding:28px; }
  .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
  .form-group { display:flex; flex-direction:column; gap:6px; }
  .form-group.full { grid-column:1/-1; }
  label { font-size:13px; font-weight:600; color:var(--muted); } label .req { color:var(--red); margin-left:3px; }
  input,select,textarea { padding:11px 14px; border-radius:10px; background:var(--surface); border:1px solid var(--border); color:var(--text); font-family:inherit; font-size:14px; outline:none; transition:border .2s; }
  input:focus,select:focus,textarea:focus { border-color:var(--accent); }
  textarea { resize:vertical; min-height:80px; } select option { background:var(--surface); }
  .alert-danger { padding:12px 18px; border-radius:10px; margin-bottom:20px; font-size:14px; background:rgba(239,68,68,.12); border:1px solid rgba(239,68,68,.3); color:var(--red); }
  .alert-danger ul { margin:6px 0 0 18px; }
  .form-actions { display:flex; gap:12px; margin-top:24px; }
  .btn { display:inline-flex; align-items:center; gap:7px; padding:11px 22px; border-radius:10px; font-family:inherit; font-size:14px; font-weight:600; border:none; cursor:pointer; text-decoration:none; transition:all .2s; }
  .btn-primary { background:var(--accent); color:#fff; } .btn-primary:hover { background:#3a7be8; }
  .btn-secondary { background:var(--surface); color:var(--muted); border:1px solid var(--border); } .btn-secondary:hover { color:var(--text); }
  .edit-badge { display:inline-flex; align-items:center; gap:8px; padding:8px 16px; border-radius:8px; background:rgba(245,158,11,.1); border:1px solid rgba(245,158,11,.3); color:#fbbf24; font-size:13px; font-weight:600; margin-bottom:20px; }
</style>
</head>
<body>
<aside class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-icon">🎓</div>
    <div class="logo-text">Siswa<span>DB</span></div>
  </div>
  <a href="../index.php" class="nav-item">📋 &nbsp;Data Siswa</a>
  <a href="tambah.php" class="nav-item">➕ &nbsp;Tambah Siswa</a>
</aside>

<main class="main">
  <div class="page-title">Edit <span>Siswa</span></div>
  <div class="breadcrumb"><a href="../index.php">Data Siswa</a> / Edit Siswa</div>

  <div class="edit-badge">✏️ Mode Edit: <?= htmlspecialchars($row['nama']) ?></div>

  <?php if (!empty($errors)): ?>
  <div class="alert-danger">
    <strong>⚠️ Terdapat kesalahan:</strong>
    <ul><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
  </div>
  <?php endif; ?>

  <div class="form-card">
    <form method="POST">
      <div class="form-grid">
        <div class="form-group">
          <label>NIS <span class="req">*</span></label>
          <input type="text" name="nis" value="<?= htmlspecialchars($data['nis']) ?>" required>
        </div>
        <div class="form-group">
          <label>Nama Lengkap <span class="req">*</span></label>
          <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
        </div>
        <div class="form-group">
          <label>Jenis Kelamin <span class="req">*</span></label>
          <select name="jenis_kelamin" required>
            <option value="">-- Pilih --</option>
            <option value="Laki-laki" <?= $data['jenis_kelamin']==='Laki-laki' ? 'selected':'' ?>>Laki-laki</option>
            <option value="Perempuan" <?= $data['jenis_kelamin']==='Perempuan' ? 'selected':'' ?>>Perempuan</option>
          </select>
        </div>
        <div class="form-group">
          <label>Kelas <span class="req">*</span></label>
          <input type="text" name="kelas" value="<?= htmlspecialchars($data['kelas']) ?>" required>
        </div>
        <div class="form-group">
          <label>No. Telepon</label>
          <input type="text" name="no_telepon" value="<?= htmlspecialchars($data['no_telepon']) ?>">
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" value="<?= htmlspecialchars($data['email']) ?>">
        </div>
        <div class="form-group">
          <label>Tanggal Masuk</label>
          <input type="date" name="tanggal_masuk" value="<?= htmlspecialchars($data['tanggal_masuk']) ?>">
        </div>
        <div class="form-group full">
          <label>Alamat</label>
          <textarea name="alamat"><?= htmlspecialchars($data['alamat']) ?></textarea>
        </div>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">💾 Perbarui Data</button>
        <a href="../index.php" class="btn btn-secondary">← Batal</a>
      </div>
    </form>
  </div>
</main>
</body>
</html>
