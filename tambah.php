<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode = htmlspecialchars($_POST['kode_barang']);
    $nama = htmlspecialchars($_POST['nama_barang']);
    $jumlah = filter_var($_POST['jumlah'], FILTER_SANITIZE_NUMBER_INT);
    $harga = filter_var($_POST['harga'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    if (empty($kode) || empty($nama) || empty($jumlah) || empty($harga)) {
        $error = "Semua kolom wajib diisi!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO barang (kode_barang, nama_barang, jumlah, harga) VALUES (:kode, :nama, :jumlah, :harga)");
        $stmt->execute(['kode' => $kode, 'nama' => $nama, 'jumlah' => $jumlah, 'harga' => $harga]);
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Data</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 50px 20px;
            display: flex;
            justify-content: center;
        }
        .container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
            width: 100%;
            max-width: 500px;
        }
        input[type="text"], input[type="number"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button, .btn-batal {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
            text-decoration: none;
            display: inline-block;
        }
        button[type="submit"] { background-color: #2ecc71; color: white; margin-right: 10px; }
        .btn-batal { background-color: #95a5a6; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Tambah Data Barang</h2>
        <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
        <form method="POST" action="">
            <label>Kode Barang:</label><br>
            <input type="text" name="kode_barang" required><br>
            <label>Nama Barang:</label><br>
            <input type="text" name="nama_barang" required><br>
            <label>Jumlah:</label><br>
            <input type="number" name="jumlah" required><br>
            <label>Harga:</label><br>
            <input type="number" step="0.01" name="harga" required><br>
            
            <button type="submit">Simpan</button>
            <a href="index.php" class="btn-batal">Batal</a>
        </form>
    </div>
</body>
</html>