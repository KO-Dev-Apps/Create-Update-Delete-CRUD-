<?php
// KONEKSI DATABASE
$pdo = new PDO("mysql:host=127.0.0.1;dbname=data_penjualan", "root", "");

// PROSES DATA
if ($_POST) {
    $action = $_POST['action'];
    $table = $_POST['table'];
    
    if ($action == 'create') {
        if ($table == 'produk') {
            $pdo->prepare("INSERT INTO produk VALUES (?,?,?,?)")->execute([$_POST['id_produk'], $_POST['nama_produk'], $_POST['harga'], $_POST['stok']]);
        } 
        elseif ($table == 'pelanggan') {
            $pdo->prepare("INSERT INTO pelanggan VALUES (?,?,?)")->execute([$_POST['id_pelanggan'], $_POST['nama_pelanggan'], $_POST['no_hp']]);
        }
        elseif ($table == 'penjualan') {
            $harga = $pdo->prepare("SELECT harga FROM produk WHERE id_produk=?")->execute([$_POST['id_produk']])->fetch()['harga'];
            $total = $harga * $_POST['jumlah'];
            $pdo->prepare("INSERT INTO penjualan VALUES (?,?,?,?,?,?)")->execute([$_POST['id_penjualan'], $_POST['id_produk'], $_POST['id_pelanggan'], $_POST['tanggal'], $_POST['jumlah'], $total]);
        }
    }
    elseif ($action == 'update') {
        if ($table == 'produk') {
            $pdo->prepare("UPDATE produk SET nama_produk=?, harga=?, stok=? WHERE id_produk=?")->execute([$_POST['nama_produk'], $_POST['harga'], $_POST['stok'], $_POST['id']]);
        }
        elseif ($table == 'pelanggan') {
            $pdo->prepare("UPDATE pelanggan SET nama_pelanggan=?, no_hp=? WHERE id_pelanggan=?")->execute([$_POST['nama_pelanggan'], $_POST['no_hp'], $_POST['id']]);
        }
        elseif ($table == 'penjualan') {
            $harga = $pdo->prepare("SELECT harga FROM produk WHERE id_produk=?")->execute([$_POST['id_produk']])->fetch()['harga'];
            $total = $harga * $_POST['jumlah'];
            $pdo->prepare("UPDATE penjualan SET id_produk=?, id_pelanggan=?, tanggal=?, jumlah=?, total_harga=? WHERE id_penjualan=?")->execute([$_POST['id_produk'], $_POST['id_pelanggan'], $_POST['tanggal'], $_POST['jumlah'], $total, $_POST['id']]);
        }
    }
    elseif ($action == 'delete') {
        $pdo->prepare("DELETE FROM $table WHERE id_$table=?")->execute([$_POST['id']]);
    }
    
    header("Location: ?table=$table");
    exit;
}

// AMBIL DATA
$current_table = $_GET['table'] ?? 'produk';
$edit_id = $_GET['edit'] ?? '';
$edit_data = null;

if ($edit_id) {
    $edit_data = $pdo->prepare("SELECT * FROM $current_table WHERE id_$current_table=?")->execute([$edit_id])->fetch();
}

// DATA UNTUK TAMPILAN
$produk_list = $pdo->query("SELECT * FROM produk")->fetchAll();
$pelanggan_list = $pdo->query("SELECT * FROM pelanggan")->fetchAll();
$penjualan_data = $pdo->query("SELECT p.*, pr.nama_produk, pl.nama_pelanggan FROM penjualan p JOIN produk pr ON p.id_produk=pr.id_produk JOIN pelanggan pl ON p.id_pelanggan=pl.id_pelanggan")->fetchAll();
?>

<!-- HTML -->
<!DOCTYPE html>
<html>
<head>
    <title>CRUD Sederhana</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding:20px; background:#f8f9fa; }
        .container { max-width:1400px; }
        .card { margin-bottom:20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Sistem CRUD</h1>
        <h1 class="text-center mb-4">Toko Elektronik Mas Eko</h1>
        
        <!-- MENU -->
        <ul class="nav nav-tabs mb-4">
            <li class="nav-item"><a class="nav-link <?= $current_table=='produk'?'active':'' ?>" href="?table=produk">📦 Produk</a></li>
            <li class="nav-item"><a class="nav-link <?= $current_table=='pelanggan'?'active':'' ?>" href="?table=pelanggan">👥 Pelanggan</a></li>
            <li class="nav-item"><a class="nav-link <?= $current_table=='penjualan'?'active':'' ?>" href="?table=penjualan">💰 Penjualan</a></li>
        </ul>

        <!-- FORM PRODUK -->
        <?php if($current_table == 'produk'): ?>
        <div class="card">
            <div class="card-body">
                <h4><?= $edit_id ? 'Edit Produk' : 'Tambah Produk' ?></h4>
                <form method="POST">
                    <input type="hidden" name="action" value="<?= $edit_id ? 'update' : 'create' ?>">
                    <input type="hidden" name="table" value="produk">
                    <?php if($edit_id): ?><input type="hidden" name="id" value="<?= $edit_data['id_produk'] ?>"><?php endif; ?>
                    
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label>ID Produk</label>
                            <input type="text" class="form-control" name="id_produk" value="<?= $edit_data['id_produk'] ?? '' ?>" <?= $edit_id ? 'readonly' : '' ?> required>
                        </div>
                        <div class="col-md-3"><label>Nama</label><input type="text" class="form-control" name="nama_produk" value="<?= $edit_data['nama_produk'] ?? '' ?>" required></div>
                        <div class="col-md-3"><label>Harga</label><input type="number" class="form-control" name="harga" value="<?= $edit_data['harga'] ?? '' ?>" required></div>
                        <div class="col-md-3"><label>Stok</label><input type="number" class="form-control" name="stok" value="<?= $edit_data['stok'] ?? '' ?>" required></div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3"><?= $edit_id ? 'Update' : 'Simpan' ?></button>
                    <?php if($edit_id): ?><a href="?table=produk" class="btn btn-secondary mt-3">Batal</a><?php endif; ?>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4>Data Produk</h4>
                <table class="table table-striped">
                    <thead><tr><th>ID</th><th>Nama</th><th>Harga</th><th>Stok</th><th>Aksi</th></tr></thead>
                    <tbody>
                        <?php foreach($produk_list as $row): ?>
                        <tr>
                            <td><?= $row['id_produk'] ?></td>
                            <td><?= $row['nama_produk'] ?></td>
                            <td>Rp <?= number_format($row['harga']) ?></td>
                            <td><?= $row['stok'] ?></td>
                            <td>
                                <a href="?table=produk&edit=<?= $row['id_produk'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <form method="POST" style="display:inline">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="table" value="produk">
                                    <input type="hidden" name="id" value="<?= $row['id_produk'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

        <!-- FORM PELANGGAN -->
        <?php if($current_table == 'pelanggan'): ?>
        <div class="card">
            <div class="card-body">
                <h4><?= $edit_id ? 'Edit Pelanggan' : 'Tambah Pelanggan' ?></h4>
                <form method="POST">
                    <input type="hidden" name="action" value="<?= $edit_id ? 'update' : 'create' ?>">
                    <input type="hidden" name="table" value="pelanggan">
                    <?php if($edit_id): ?><input type="hidden" name="id" value="<?= $edit_data['id_pelanggan'] ?>"><?php endif; ?>
                    
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label>ID Pelanggan</label>
                            <input type="text" class="form-control" name="id_pelanggan" value="<?= $edit_data['id_pelanggan'] ?? '' ?>" <?= $edit_id ? 'readonly' : '' ?> required>
                        </div>
                        <div class="col-md-4"><label>Nama</label><input type="text" class="form-control" name="nama_pelanggan" value="<?= $edit_data['nama_pelanggan'] ?? '' ?>" required></div>
                        <div class="col-md-4"><label>No HP</label><input type="text" class="form-control" name="no_hp" value="<?= $edit_data['no_hp'] ?? '' ?>" required></div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3"><?= $edit_id ? 'Update' : 'Simpan' ?></button>
                    <?php if($edit_id): ?><a href="?table=pelanggan" class="btn btn-secondary mt-3">Batal</a><?php endif; ?>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4>Data Pelanggan</h4>
                <table class="table table-striped">
                    <thead><tr><th>ID</th><th>Nama</th><th>No HP</th><th>Aksi</th></tr></thead>
                    <tbody>
                        <?php foreach($pelanggan_list as $row): ?>
                        <tr>
                            <td><?= $row['id_pelanggan'] ?></td>
                            <td><?= $row['nama_pelanggan'] ?></td>
                            <td><?= $row['no_hp'] ?></td>
                            <td>
                                <a href="?table=pelanggan&edit=<?= $row['id_pelanggan'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <form method="POST" style="display:inline">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="table" value="pelanggan">
                                    <input type="hidden" name="id" value="<?= $row['id_pelanggan'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

        <!-- FORM PENJUALAN -->
        <?php if($current_table == 'penjualan'): ?>
        <div class="card">
            <div class="card-body">
                <h4><?= $edit_id ? 'Edit Penjualan' : 'Tambah Penjualan' ?></h4>
                <form method="POST">
                    <input type="hidden" name="action" value="<?= $edit_id ? 'update' : 'create' ?>">
                    <input type="hidden" name="table" value="penjualan">
                    <?php if($edit_id): ?><input type="hidden" name="id" value="<?= $edit_data['id_penjualan'] ?>"><?php endif; ?>
                    
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label>ID Penjualan</label>
                            <input type="text" class="form-control" name="id_penjualan" value="<?= $edit_data['id_penjualan'] ?? '' ?>" <?= $edit_id ? 'readonly' : '' ?> required>
                        </div>
                        <div class="col-md-2">
                            <label>Produk</label>
                            <select class="form-select" name="id_produk" required>
                                <option value="">Pilih Produk</option>
                                <?php foreach($produk_list as $p): ?>
                                <option value="<?= $p['id_produk'] ?>" <?= ($edit_data['id_produk']??'')==$p['id_produk']?'selected':'' ?>><?= $p['id_produk'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Pelanggan</label>
                            <select class="form-select" name="id_pelanggan" required>
                                <option value="">Pilih Pelanggan</option>
                                <?php foreach($pelanggan_list as $p): ?>
                                <option value="<?= $p['id_pelanggan'] ?>" <?= ($edit_data['id_pelanggan']??'')==$p['id_pelanggan']?'selected':'' ?>><?= $p['id_pelanggan'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2"><label>Tanggal</label><input type="date" class="form-control" name="tanggal" value="<?= $edit_data['tanggal']??date('Y-m-d') ?>" required></div>
                        <div class="col-md-2"><label>Jumlah</label><input type="number" class="form-control" name="jumlah" value="<?= $edit_data['jumlah']??'' ?>" required></div>
                        <div class="col-md-2"><label>Total</label><input type="text" class="form-control" value="Auto" readonly></div>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3"><?= $edit_id ? 'Update' : 'Simpan' ?></button>
                    <?php if($edit_id): ?><a href="?table=penjualan" class="btn btn-secondary mt-3">Batal</a><?php endif; ?>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h4>Data Penjualan</h4>
                <table class="table table-striped">
                    <thead><tr><th>ID</th><th>Produk</th><th>Pelanggan</th><th>Tanggal</th><th>Jumlah</th><th>Total</th><th>Aksi</th></tr></thead>
                    <tbody>
                        <?php foreach($penjualan_data as $row): ?>
                        <tr>
                            <td><?= $row['id_penjualan'] ?></td>
                            <td><?= $row['nama_produk'] ?></td>
                            <td><?= $row['nama_pelanggan'] ?></td>
                            <td><?= $row['tanggal'] ?></td>
                            <td><?= $row['jumlah'] ?></td>
                            <td>Rp <?= number_format($row['total_harga']) ?></td>
                            <td>
                                <a href="?table=penjualan&edit=<?= $row['id_penjualan'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <form method="POST" style="display:inline">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="table" value="penjualan">
                                    <input type="hidden" name="id" value="<?= $row['id_penjualan'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>