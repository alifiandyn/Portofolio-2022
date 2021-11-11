<?php

include('../koneksi.php');
include('../function.php');
$id_order = $_POST['id_order'];
$result = mysqli_query($conn, "SELECT detail_order.*, product.name_product FROM detail_order JOIN product ON detail_order.id_product = product.id WHERE detail_order.id_order = $id_order");
$detail_order = [];
while ($order = mysqli_fetch_assoc($result)) {
    $detail_order[] = $order;
}
echo json_encode($detail_order);
