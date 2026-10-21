<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
    header("Location: index.php");
    exit;
}

$lang = $_SESSION['lang'];
$kamus = [
    'id' => [
        'judul' => 'Sistem Informasi Inventaris Barang',
        'selamat_datang' => 'Selamat datang',
        'keluar' => 'Keluar',
        'tambah_data' => 'Tambah Data Barang'
    ],
    'en' => [
        'judul' => 'Inventory Information System',
        'selamat_datang' => 'Welcome',
        'keluar' => 'Logout',
        'tambah_data' => 'Add Item Data'
    ]
];
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo $kamus[$lang]['judul']; ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 40px 20px;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 900px;
            margin: 0 auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .btn {
            background-color: #2ecc71;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 10px;
        }
        .btn-logout { background-color: #e74c3c; }
        .btn-edit { color: #2980b9; text-decoration: none; font-weight: bold; }
        .btn-delete { color: #e74c3c; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div style="text-align: right; margin-bottom: 20px;">
            <a href="?lang=id" style="text-decoration: none; color: #3498db;">Indonesia</a> | 
            <a href="?lang=en" style="text-decoration: none; color: #3498db;">English</a>
        </div>
        
        <h2><?php echo $kamus[$lang]['judul']; ?></h2>
        <p><?php echo $kamus[$lang]['selamat_datang']; ?>, <b><?php echo $_SESSION['user']; ?></b>!</p>
        
        <a href="logout.php" class="btn btn-logout"><?php echo $kamus[$lang]['keluar']; ?></a>
        <hr style="border: 1px solid #eee; margin: 20px 0;">
        
        <a href="tambah.php" class="btn"><?php echo $kamus[$lang]['tambah_data']; ?></a>
        
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM barang ORDER BY id DESC");
                $no = 1;
                while ($row = $stmt->fetch()) {
                    $harga_format = "Rp " . number_format($row['harga'], 0, ',', '.');
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . htmlspecialchars($row['kode_barang']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nama_barang']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['jumlah']) . "</td>";
                    echo "<td>" . $harga_format . "</td>";
                    echo "<td>
                            <a href='edit.php?id=" . $row['id'] . "' class='btn-edit'>Edit</a> | 
                            <a href='hapus.php?id=" . $row['id'] . "' class='btn-delete' onclick=\"return confirm('Yakin ingin menghapus?');\">Hapus</a>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>