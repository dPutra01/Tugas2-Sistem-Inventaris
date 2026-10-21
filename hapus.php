<?php
session_start();
require 'koneksi.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'] ?? '';
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM barang WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

header("Location: index.php");
exit;
?>