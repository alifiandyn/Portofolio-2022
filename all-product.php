<?php
session_start();

include('koneksi.php');
include('function.php');

$result = mysqli_query($conn, 'SELECT * FROM product');
if (!$result) {
    echo mysqli_error($conn);
}
function is_decimal($n)
{
    // Note that floor returns a float 
    return is_numeric($n) && floor($n) != $n;
}
$input = 12;
$i = 0;
// for ($i; $i <= $input; $i++) {
//     $wle = (($i * $input) / 7);
//     if (is_decimal($wle) == 1) {
//         $hasil = $i + 7;
//         echo $hasil . "<br>";
//     }
// }

// echo (is_decimal(2.666666667));

while ($input >= $i) {
    $wle = (($i * $input) / 9);
    if (is_decimal($wle) == 1) {
        $hasil = $i + 7;
        echo $hasil . "<br>";
    }
    $i++;
}

die;
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

    <title>Happy Coffee</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Coffee Shop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="food-product.php">Makanan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="beverage-product.php">Minuman</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <?php while ($product = mysqli_fetch_assoc($result)) : ?>
                            <div class="card m-2" style="width: 18rem;">
                                <img src="img/<?= $product['img']; ?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $product['name_product']; ?></h5>
                                    <div class="product-description">
                                        <p class="card-text"><?= $product['description']; ?></p>
                                    </div>
                                    <h7 class="card-text price"><i><?= rupiah($product['price']); ?></i></h7>
                                    <button onclick="AddOrder(<?= $product['id']; ?>)" class="btn btn-primary float-right" id="ButtonOrder<?= $product['id']; ?>">Tambah</button>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <form action="input-order.php" method="POST">
                                <h5 class="card-title text-center">Pesanan Anda</h5>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nama </label>
                                    <input type="text" class="form-control" placeholder="Enter nama pemesan" name="customer">
                                </div>
                                List Pesanan
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Produk</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody id="Order">
                                    </tbody>
                                    <tfooter>
                                        <th colspan="2">Total Harga</th>
                                        <td id="totalhargaorder"></td>
                                    </tfooter>
                                </table>
                                <input type="hidden" name="totalharga" value="" id="totalharga">
                                <!-- <button type="submit" class="btn btn-success" id="Tambah_Order">Buat Pesanan</button> -->
                                <button type="submit" class="btn btn-success">Buat Pesanan</button>
                            </form>
                        </div>
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
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
    <script>
        var totalhargaorder = 0;

        var disabledOrder = [];

        function TotalHargaOrder() {
            $('#totalharga').val(totalhargaorder);
            $('#totalhargaorder').html(totalhargaorder);
        }

        TotalHargaOrder();

        function AddOrder(id) {
            console.log(disabledOrder);
            $(function() {
                $.ajax({
                    type: "POST",
                    url: "Ajax/add_order.php",
                    data: {
                        id_product: id
                    },
                    dataType: 'JSON',
                    success: function(result) {
                        $("#Order").append(`
                                    <tr>
                                        <input type="hidden" name="detailorder[id_product][]" value="` + result.id + `">
                                        <td scope="col">` + result.name_product + `</td>
                                        <td scope="col"><input type="number" class="form-control" min="1" placeholder="0" id="Jumlah` + result.id + `" name="detailorder[kuantitas][]"></td>
                                        <td scope="col" id="TotalHargaInfo` + result.id + `">0</td>
                                        <input type="hidden" id="TotalHarga` + result.id + `"name="detailorder[total_harga][]" value="` + result.id + `">
                                    </tr>
                        `);
                        $("#ButtonOrder" + id).attr("disabled", true);
                        $('#Jumlah' + result.id).change(function(TotalHarga) {
                            var jumlah_order = $('#Jumlah' + result.id).val();
                            var price = result.price;
                            var totalharga = jumlah_order * price;
                            $('#TotalHargaInfo' + result.id).html(totalharga);
                            $('#TotalHarga' + result.id).val(totalharga);
                            disabledOrder.push([id, jumlah_order, totalharga]);
                            totalhargaorder = totalhargaorder + totalharga;
                            TotalHargaOrder();
                        });
                    }
                });
            });
        }
    </script>
</body>

</html>