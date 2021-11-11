<?php
session_start();
if (!isset($_SESSION["login"])) {
    echo "<script>alert('Anda belum login, silahkan login terlebih dahulu untuk melanjutkan');window.location.href = 'index.php';</script>";
}

include('koneksi.php');
include('function.php');

// $after_update_info = $_GET['id'];

// Panggil kembali modal setelah update
// if ($after_update_info) {
//     echo '<script type="text/javascript"> DetailOrder(' . $after_update_info . '); </script>';
// }
// echo $after_update_info;
// Panggil kembali modal setelah update

$result = mysqli_query($conn, 'SELECT * FROM product_order ORDER BY date_order DESC');
if (!$result) {
    echo mysqli_error($conn);
}

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
                <li class="nav-item active">
                    <a class="nav-link" href="#">Task<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin-product.php">Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin-history.php">History</a>
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
                <div class="card-body p-5">
                    <table class="table table-bordered table-dark">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Waktu Pesan</th>
                                <th scope="col">Status</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php while ($order = mysqli_fetch_assoc($result)) : ?>
                                <tr>
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $order['customer']; ?></td>
                                    <td><?= $order['date_order']; ?></td>
                                    <td>
                                        <?php
                                        if ($order['status_order'] == 0) {
                                            echo '<span class="badge badge-pill badge-danger">cancel</span>';
                                        } elseif ($order['status_order'] == 1) {
                                            echo '<span class="badge badge-pill badge-primary">new task</span>';
                                        }
                                        ?>
                                    </td>
                                    <td><?= rupiah($order['total_price']); ?></td>
                                    <td>
                                        <?php if ($order['status_order'] == 1) : ?>
                                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                                <button type="button" class="btn btn-warning" onclick="DetailOrder(<?= $order['id']; ?>)" data-toggle="modal" data-target=".bd-example-modal-lg">Detail</button>
                                                <a type="button" class="btn btn-danger" href="delete-order.php?id=<?= $order['id']; ?>">Cancel</a>
                                            </div>
                                        <?php else : ?>
                                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                                <button type="button" class="btn btn-warning" disabled>Detail</button>
                                                <button type="button" class="btn btn-danger" disabled>Cancel</button>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="footer bg-dark">
        <div class="footer-text p-3">
            Terimakasih sudah mengunjungi website kami<br><b>-Happy Coffee-</b>
        </div>
    </div>

    <!-- Modal Detail Order-->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Name Product</th>
                                <th scope="col">Kuantiti</th>
                                <th scope="col">Status</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="ListDetailOrder">
                        </tbody>
                    </table>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
        <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
        <script>
            function DetailOrder(id) {
                $(function() {
                    $.ajax({
                        type: "POST",
                        url: "Ajax/detail_order.php",
                        data: {
                            id_order: id
                        },
                        dataType: 'JSON',
                        success: function(result) {
                            console.log(result);
                            $("#ListDetailOrder").empty();
                            let i = 1;
                            $.each(result, function(index) {
                                let status_order = "";
                                let disabled_button = "";
                                if (result[index].status_order == 0) {
                                    status_order = '<span class="badge badge-pill badge-primary">new task</span>';
                                } else {
                                    status_order = '<span class="badge badge-pill badge-success">done</span>';
                                    disabled_button = 'disabled';
                                }
                                $("#ListDetailOrder").append(`
                                <tr>
                                    <td>` + i + `</td>             
                                    <td>` + result[index].name_product + `</td>             
                                    <td>` + result[index].qty + `</td>            
                                    <td>` + status_order + `</td>             
                                    <td>` + result[index].price + `</td>              
                                    <td><a href="done-task.php?id=` + result[index].id + `&id_order=` + result[index].id_order + `" class="btn btn-success ` + disabled_button + `">Done</td>             
                                </tr>             
                                `)
                                i++;
                            });
                        }
                    })
                })
            }
        </script>
</body>

</html>