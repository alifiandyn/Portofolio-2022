<?php
include('koneksi.php');
include('function.php');

$id = $_GET['id'];
$id_order = $_GET['id_order'];

date_default_timezone_set("Asia/Bangkok");
$date = date_create();
date_timestamp_set($date, time());
$timestamp = date_format($date, "Y-m-d H:i:s");

$query = "UPDATE detail_order SET status_order = 1, done_task='$timestamp' WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if ($result) {
    echo "<script>alert('Task sudah diselesaikan:)');window.location.href = 'admin-task.php?id=" . $id_order . "';</script>";
} else {
    echo "<script>alert('Task dihapus;)');window.location.href = 'admin-task.php';</script>";
}
