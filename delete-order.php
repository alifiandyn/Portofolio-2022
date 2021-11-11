<?php
include('koneksi.php');
include('function.php');

$id = $_GET['id'];
$query = "UPDATE product_order SET status_order = 0 WHERE id = '$id'";

$result = mysqli_query($conn, $query);

if ($result) {
    echo "<script>alert('Order berhasil dibatalkan:)');window.location.href = 'admin-task.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus order;)');window.location.href = 'admin-task.php';</script>";
}
