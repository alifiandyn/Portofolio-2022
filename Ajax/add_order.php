<?php

include('../koneksi.php');
include('../function.php');
$data = $_POST['id_product'];
$result = mysqli_query($conn, "SELECT * FROM product WHERE id=$data");
$order = mysqli_fetch_assoc($result);
echo json_encode($order);
