<?php

include('koneksi.php');
include('function.php');

if (isset($_POST['BtnRegister'])) {
    $username = strtolower(stripslashes($_POST['username']));
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    $query = "SELECT username FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    if (mysqli_fetch_assoc($result)) {
        echo "<script>alert('Username sudah digunakan');</script>";
    } else {
        if ($password1 !== $password2) {
            echo "<script>alert('Password tidak sesuai');</script>";
        } else {
            $password = password_hash($password1, PASSWORD_DEFAULT);
            $query = "INSERT INTO user (username,password,status) VALUES ('$username','$password',0)";

            $result = mysqli_query($conn, $query);

            if ($result) {
                echo "<script>alert('Registrasi berhasil, silahkan minta admin untuk mengaktifkan akun anda');window.location.href = 'index.php';</script>";
            } else {
                echo "<script>alert('Registrasi gagal ;)');</script>";
            }
        }
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        body {
            background-color: #F7F7F7;
        }
    </style>
    <title>Registrasi</title>
</head>

<body>
    <div class="container-fluid pt-5">
        <div class="row justify-content-center">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <img class="img-fluid pt-5 pl-5 pr-5 pb-2" src="https://static.vecteezy.com/system/resources/previews/001/209/481/non_2x/coffee-png.png" alt="">
                        <h3 class="card-title text-center">Login Coffee</h3>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="exampleInputUsername">Username</label>
                                <input type="text" class="form-control" name="username" id="exampleInputUsername" aria-describedby="emailHelp">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" name="password1" id="exampleInputPassword1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword2   ">Konfirmasi Password</label>
                                <input type="password" class="form-control" name="password2" id="exampleInputPassword2  ">
                            </div>
                            <button type="submit" name="BtnRegister" class="btn btn-primary">Registrasi</button>
                        </form>
                    </div>
                </div>
                <a class="float-right" href="index.php">Sudah punya akun</a>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>