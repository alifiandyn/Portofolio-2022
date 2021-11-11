<?php
include "koneksi.php";

// Cek ID dari table product_order
$query = "SELECT id FROM product_order";
$result = mysqli_query($conn, $query);
$num_rows = mysqli_num_rows($result);
if ($num_rows == 0) {
    $id_order = 1;
} else {
    // Mendapat ID terakhir dari table product_order
    $query = "SELECT id FROM product_order ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    $product = mysqli_fetch_assoc($result);
    $id_order = $product['id'] + 1;
    // Mendapat ID terakhir dari table product_order
}

// Set Variable
$customer = $_POST["customer"];
$totalharga = $_POST["totalharga"];
$statusorder = 1;
$jumlahorder = count($_POST['detailorder']['id_product']);
// Set Variable

// Input data table product_order
$query = "INSERT INTO product_order (id,customer,total_price,status_order) VALUES ('$id_order','$customer','$totalharga','$statusorder')";
$result = mysqli_query($conn, $query);
// Input data table product_order

// Input data table detail_order
$i = 0;
while ($i < $jumlahorder) {
    $id_product = $_POST['detailorder']['id_product'][$i];
    $kuantitas = $_POST['detailorder']['kuantitas'][$i];
    $total_harga = $_POST['detailorder']['total_harga'][$i];
    $query = "INSERT INTO detail_order (id,id_order,id_product,qty,price) VALUES ('','$id_order','$id_product','$kuantitas','$total_harga')";
    $result = mysqli_query($conn, $query);
    $i++;
}
// Input data table detail_order

if ($result) {
    echo "<script>alert('Order berhasil :)');window.location.href = 'all-product.php';</script>";
} else {
    echo "<script>alert('Order gagal ;)');window.location.href = 'all-product.php';</script>";
}
