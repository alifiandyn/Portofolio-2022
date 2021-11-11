<?php
session_start();
if (!isset($_SESSION["login"])) {
    echo "<script>alert('Anda belum login, silahkan login terlebih dahulu untuk melanjutkan');window.location.href = 'index.php';</script>";
}

include('koneksi.php');
include('function.php');

$result = mysqli_query($conn, 'SELECT * FROM product');
if (!$result) {
    echo mysqli_error($conn);
}

if (isset($_POST['AddProduct'])) {
    $NamaProduct = $_POST['NamaProduct'];
    $DeskripsiProduct = $_POST['DeskripsiProduct'];
    $HargaProduct = $_POST['HargaProduct'];
    $KategoriProduct = $_POST['kategori'];
    $StatusProduct = $_POST['status'];

    $FotoProduct = $_FILES['FotoProduk']['name'];
    $UkuranFile = $_FILES['FotoProduk']['size'];
    $Error = $_FILES['FotoProduk']['error'];
    $tmpName = $_FILES['FotoProduk']['tmp_name'];
    if ($Error === 4) {
        echo "<script>alert('Gagal menambahkan produk, foto belum ditambahkan!');</script>";
    }
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $FotoProduct);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>alert('Gagal menambahkan produk, file yang diupload bukan gambar!');</script>";
    }
    move_uploaded_file($tmpName, 'img/' . $FotoProduct);

    $query = "INSERT INTO product (name_product,description,img,price,category_product,status_product) VALUES ('$NamaProduct','$DeskripsiProduct','$FotoProduct','$HargaProduct','$KategoriProduct','$StatusProduct')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Produk berhasil ditambahkan:)');window.location.href = 'admin-product.php';</script>";
    } else {
        echo "<script>alert('Produk gagal ditambahkan;)');window.location.href = 'admin-product.php';</script>";
    }
}

if (isset($_POST['EditProduct'])) {
    $IdProduct = $_POST['IdProduct'];
    $NamaProduct = $_POST['EditNamaProduct'];
    $DeskripsiProduct = $_POST['EditDeskripsiProduct'];
    $HargaProduct = $_POST['EditHargaProduct'];
    $KategoriProduct = $_POST['Editkategori'];
    $StatusProduct = $_POST['Editstatus'];

    $FotoProduct = $_FILES['EditFotoProduk']['name'];
    $UkuranFile = $_FILES['EditFotoProduk']['size'];
    $Error = $_FILES['EditFotoProduk']['error'];
    $tmpName = $_FILES['EditFotoProduk']['tmp_name'];
    if ($Error === 4) {
        echo "<script>alert('Gagal mengupdate produk, foto belum ditambahkan!');window.location.href = 'admin-product.php';</script>";
    }
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $FotoProduct);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>alert('Gagal mengupdate produk, file yang diupload bukan gambar!');window.location.href = 'admin-product.php';</script>";
    }
    move_uploaded_file($tmpName, 'img/' . $FotoProduct);

    $query = "UPDATE product SET name_product='$NamaProduct', description='$DeskripsiProduct', img='$FotoProduct', price='$HargaProduct',category_product='$KategoriProduct', status_product='$StatusProduct' WHERE id='$IdProduct'";

    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>alert('Produk berhasil diupdate:)');window.location.href = 'admin-product.php';</script>";
    } else {
        echo "<script>alert('Produk gagal diupdate;)');window.location.href = 'admin-product.php';</script>";
    }
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
                <li class="nav-item">
                    <a class="nav-link" href="admin-task.php">Task</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Product<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin-history.php">History</a>
                </li>
            </ul>
            <span class="navbar-text">
                <a class="nav-link" href="logout.php">Logout</a>
            </span>
        </div>
    </nav>
    <div class="main-content">
        <div class="container">
            <button class="btn btn-primary mb-2" data-toggle="modal" data-target="#ModalAddProduct">Add New Product</button>
            <table class="table table-bordered table-dark">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Produk</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Status</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php while ($product = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><?= $product['name_product']; ?></td>
                            <td><?= $product['category_product'] == 1 ? "Minuman" : "Makanan"; ?></td>
                            <td><?= rupiah($product['price']); ?></td>
                            <td><?= $product['status_product'] == 1 ? "Aktif" : "Tidak aktif"; ?></td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <button type="button" class="btn btn-success" onclick="EditProduct('<?= $product['id']; ?>');" data-toggle="modal" data-target="#ModalEditProduct">Edit</button>
                                    <a type="button" class="btn btn-danger" href="delete-product.php?id=<?= $product['id']; ?>">Delete</a>
                                </div>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer bg-dark">
        <div class="footer-text p-3">
            Terimakasih sudah mengunjungi website kami<br><b>-Happy Coffee-</b>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="ModalAddProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="NamaProduct">Nama Produk</label>
                            <input type="text" class="form-control" name="NamaProduct" id="NamaProduct" placeholder="Bebi buncis telur asin">
                        </div>
                        <div class="form-group">
                            <label for="DeskripsiProduct">Deskripsi Produk</label>
                            <input type="text" class="form-control" name="DeskripsiProduct" id="DeskripsiProduct" placeholder="Memiliki cita rasa yang unik dan aroma yang khas">
                        </div>
                        <div class="form-group">
                            <label for="HargaProduct">Harga</label>
                            <input type="number" class="form-control" name="HargaProduct" id="HargaProduct" placeholder="10000">
                        </div>
                        <div class="">
                            <label class="mr-4">Kategori</label>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline1" name="kategori" class="custom-control-input" value="2" checked="checked">
                                <label class="custom-control-label" for="customRadioInline1">Makanan</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline2" name="kategori" class="custom-control-input" value="1">
                                <label class="custom-control-label" for="customRadioInline2">Minuman</label>
                            </div>
                        </div>
                        <div class="">
                            <label class="mr-4">Status</label>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline1" name="status" class="custom-control-input" value="1" checked="checked">
                                <label class="custom-control-label" for="customRadioInline1">Aktif</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline2" name="status" class="custom-control-input" value="0">
                                <label class="custom-control-label" for="customRadioInline2">Tidak aktif</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="HargaProduct">Foto</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="customFile" name="FotoProduk">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="AddProduct">Tambah Produk</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="ModalEditProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div id="modalEdit">
                            <!-- Content Via AJAX -->
                        </div>
                    </form>
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
        $('.custom-file-input').on('change', function() {
            var fileName = document.getElementById("customFile").files[0].name;
            $('.custom-file-label').html(fileName);
        })

        function EditProduct(id) {
            $.ajax({
                url: 'Ajax/edit_order.php',
                data: {
                    id: id
                },
                type: 'POST',
                dataType: 'json',
                success: function(result) {
                    console.log(result)
                    var modal = $('#modalEdit');
                    modal.empty();
                    modal.append(`
                        <input type="hidden" name="IdProduct" value="` + result.id + `">
                        <div class="form-group">
                            <label for="NamaProduct">Nama Produk</label>
                            <input type="text" class="form-control" name="EditNamaProduct" id="NamaProduct" placeholder="Bebi buncis telur asin" value="` + result.name_product + `">
                        </div>
                        <div class="form-group">
                            <label for="DeskripsiProduct">Deskripsi Produk</label>
                            <input type="text" class="form-control" name="EditDeskripsiProduct" id="DeskripsiProduct" placeholder="Memiliki cita rasa yang unik dan aroma yang khas" value="` + result.description + `">
                        </div>
                        <div class="form-group">
                            <label for="HargaProduct">Harga</label>
                            <input type="number" class="form-control" name="EditHargaProduct" id="HargaProduct" placeholder="Memiliki cita rasa yang unik dan aroma yang khas" value="` + result.price + `">
                        </div>
                        <div class="">
                            <label class="mr-4">Kategori</label>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customKategoriRadioInline1" name="Editkategori" class="custom-control-input" value="2">
                                <label class="custom-control-label" for="customKategoriRadioInline1">Makanan</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customKategoriRadioInline2" name="Editkategori" class="custom-control-input" value="1">
                                <label class="custom-control-label" for="customKategoriRadioInline2">Minuman</label>
                            </div>
                        </div>
                        <div class="">
                            <label class="mr-4">Status</label>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customStatusRadioInline1" name="Editstatus" class="custom-control-input" value="1" checked="checked">
                                <label class="custom-control-label" for="customStatusRadioInline1">Aktif</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customStatusRadioInline2" name="Editstatus" class="custom-control-input" value="0">
                                <label class="custom-control-label" for="customStatusRadioInline2">Tidak aktif</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="HargaProduct">Foto</label>
                            <div class="custom-file">
                                <input type="file" class="edit-custom-file-input" id="customFile" name="EditFotoProduk" value="` + result.img + `">
                                <label class="custom-file-label" for="customFile">` + result.img + `</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="EditProduct">Edit Produk</button>
                    </div>
                    `);
                    if (result.category_product == 1) {
                        $("#customKategoriRadioInline2").attr("checked", "checked");
                    } else {
                        $("#customKategoriRadioInline1").attr("checked", "checked");
                    }
                    if (result.status_product == 1) {
                        $("#customStatusRadioInline1").attr("checked", "checked");
                    } else {
                        $("#customStatusRadioInline2").attr("checked", "checked");
                    }
                    $('edit-custom-file-input').on('change', function() {
                        var fileName = document.getElementById("customFile").files[0].name;
                        $('.custom-file-label').html(fileName);
                    })
                },
                error: function(err) {
                    console.log(err),
                        alert(err.responseText)
                }
            })
        }
    </script>
</body>

</html>