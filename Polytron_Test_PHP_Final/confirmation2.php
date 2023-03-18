<?php
// Halaman Confirmation2 (Revisi Confirmation)
session_start();
require_once 'koneksi.php';

date_default_timezone_set("Asia/Jakarta");
$item_code = $_SESSION['item_code'];
$item_name = $_SESSION['item_name'];
$transaction_date = date("d-m-Y");

function redirect($message, $parameter)
    {
        global $item_name, $item_code;
        $_SESSION['isInvalid'] = $message;
        $_SESSION['isTrue'] = $parameter;
        $_SESSION['item_code'] = $item_code;
        $_SESSION['item_name'] = $item_name;
        
        header("Location: add_product.php");
    }

if(isset($_REQUEST['input'])){
    if($_REQUEST['input'] == "true"){
        $sql = "INSERT INTO items(item_code, item_name) VALUES('$item_code', '$item_name')";
        mysqli_query($connect, $sql);
        redirect("Berhasil menambahkan produk baru", "T");
    }else if($_REQUEST['input'] == "false"){
        redirect("Anda Telah Membatalkan Input!", "W");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Input</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body style="text-align: center;">
    <div class="card mx-auto mt-5 shadow" style="width: 400px;">
        <img src="./image/thinking.jpg" class="card-img-top" alt="..." style="height: 200px; object-fit: cover; object-position: top;">
        <div class="card-body">
            <h5 class="card-title" style="font-weight: bolder; text-align: center;">Konfirmasi Input Produk Baru</h5>
            <p class="card-text">
            <table cellpadding="10px" style="margin: auto;">
                <tbody>
                    <tr>
                        <td style="max-width: 300px;">Kode Produk</td>
                        <td style="max-width: 300px;">: </td>
                        <td><?php echo $item_code ?></td>
                    </tr>
                    <tr>
                        <td style="max-width: 300px;">Nama Produk</td>
                        <td style="max-width: 300px;">: </td>
                        <td><?php echo $item_name ?></td>
                    </tr>
                    <tr>
                        <td style="max-width: 300px;">Tanggal Transaksi</td>
                        <td style="max-width: 300px;">: </td>
                        <td><?php echo $transaction_date ?></td>
                    </tr>
                </tbody>
            </table>
            </p>
            <a href="confirmation2.php?input=false" class="btn btn-primary">BATAL</a>
            <a href="confirmation2.php?input=true" class="btn btn-primary">TAMBAH</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>