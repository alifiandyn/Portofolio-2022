<?php
session_start();
if (!isset($_SESSION["login"])) {
    echo "<script>alert('Anda belum login, silahkan login terlebih dahulu untuk melanjutkan');window.location.href = 'index.php';</script>";
}

include('koneksi.php');
include('function.php');

$result = mysqli_query($conn, 'SELECT * FROM detail_order JOIN product_order ON detail_order.id_order = product_order.id JOIN product ON detail_order.id_product = product.id WHERE detail_order.status_order =1 AND product_order.status_order = 1');
if (!$result) {
    echo mysqli_error($conn);
}

$total_income_data = mysqli_query($conn, 'SELECT SUM(price) AS total_income FROM detail_order;');
$total_income = mysqli_fetch_assoc($total_income_data);

$total_order_data = mysqli_query($conn, 'SELECT SUM(qty) AS total_order FROM detail_order;');
$total_order = mysqli_fetch_assoc($total_order_data);

$averange_time_data = mysqli_query($conn, 'SELECT AVG(T1.aging) FROM (SELECT TIMEDIFF(done_task, date_order) AS aging FROM detail_order JOIN product_order ON detail_order.id_order = product_order.id WHERE detail_order.status_order =1 AND product_order.status_order = 1) as T1');
$averange_time = mysqli_fetch_array($averange_time_data);

?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/custom.css">

    <title>Admin Page</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Coffee Shop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="admin-page.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin-task.php">Task</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin-product.php">Product</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="">History<span class="sr-only">(current)</span></a>
                </li>
            </ul>
            <span class="navbar-text">
                <a class="nav-link" href="#">Logout</a>
            </span>
        </div>
    </nav>
    <div class="main-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="card-body pb-1">
                    <table class="table table-bordered table-dark">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama Pemesan</th>
                                <th scope="col">Produk</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Waktu Pesan</th>
                                <th scope="col">Waktu Penyelesaian</th>
                                <th scope="col">Aging</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php while ($order = mysqli_fetch_assoc($result)) : ?>
                                <?php
                                $in = strtotime($order['date_order']);
                                $out = strtotime($order['done_task']);
                                $aging = ($out - $in) / 60;
                                ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $order['customer']; ?></td>
                                    <td><?= $order['name_product']; ?></td>
                                    <td><?= $order['qty']; ?></td>
                                    <td><?= rupiah($order['price']); ?></td>
                                    <td><?= $order['date_order']; ?></td>
                                    <td><?= $order['done_task']; ?></td>
                                    <td><?= floor($aging) . " Menit"; ?></td>
                                </tr>
                                <?php $i++; ?>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4"></div>
                <div class="col-md-4"></div>
                <div class="col-md-4 p-0">
                    <!-- <div class="card"> -->
                    <div class="card-body pt-1">
                        <ul class="list-group list-group-flush">
                            <table class="table table-bordered table-dark">
                                <tbody>
                                    <tr>
                                        <th scope="row">Waktu rata-rata</th>
                                        <td><?= $averange_time[0]; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Total pesanan</th>
                                        <td><?= $total_order['total_order']; ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Total pendapatan</th>
                                        <td><?= rupiah($total_income['total_income']); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </ul>
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer bg-dark">
        <div class="footer-text p-3">
            Terimakasih sudah mengunjungi website kami<br><b>-Happy Coffee-</b>
        </div>
    </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
</body>

</html>