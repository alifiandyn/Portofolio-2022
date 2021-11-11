<?php
include('koneksi.php');
include('function.php');

$id = $_GET['id'];
$query = "DELETE FROM product WHERE id = '$id'";

$result = mysqli_query($conn, $query);

if ($result) {
    echo "<script>alert('Produk berhasil dihapus:)');window.location.href = 'admin-product.php';</script>";
} else {
    echo "<script>alert('Produk gagal dihapus;)');window.location.href = 'admin-product.php';</script>";
}
