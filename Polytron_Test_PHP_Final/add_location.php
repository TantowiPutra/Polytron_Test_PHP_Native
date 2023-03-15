<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header('Location: login.php');
}

$username = $_SESSION['username'];
$password = $_SESSION['password'];

require_once 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Lokasi</title>
    <link rel="stylesheet" type="text/css" href="css/dashboard.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        .btn-yellow{
        font-weight: 600!important;
        font-size: 14px!important;
        color: #000000;
        background-color: #eaff00!important;
        padding: 10px 30px!important;
        border: solid #e2f200 2px;
        box-shadow: rgb(0, 0, 0) 0px 0px 0px 0px!important;
        border-radius: 50px!important;
        transition : 1265ms!important;
        transform: translateY(0)!important;
        display: flex!important;
        flex-direction: row!important;
        align-items: center!important;
        cursor: pointer!important;

        }

        .btn-yellow:hover{
        transition : 1265ms!important;
        padding: 10px 26px!important;
        transform : translateY(-0px)!important;
        background-color: #fff!important;
        color: #ff8c00!important;
        border: solid 2px #ff8c00!important;
        }
    </style>
</head>

<body>
    <h1 class="text-align-center mb-4">Polytron Product Stock Management System</h1>
    <h3 class="text-align-center mb-4">Welcome Back, <?php echo $username ?> &#128513;</h3>
    <div style="display: flex; justify-content: space-between; max-width: 55%; margin: auto;">
        <a style="text-decoration: none;" href="dashboard.php"><button style="padding: 10px;" class="btn-yellow">DASHBOARD</button></a>
        <a style="text-decoration: none;" href="transaction_history.php"><button style="padding: 10px;" class="btn-yellow">CEK HISTORY TRANSAKSI</button></a>
        <a style="text-decoration: none;" href="product_stock.php"><button style="padding: 10px;" class="btn-yellow">CEK STOK BARANG</button></a>
        <a style="text-decoration: none;" href="logout.php"><button style="padding: 10px;" class="btn-yellow">LOGOUT</button></a>
    </div>
    <hr style="margin-bottom: 30px; margin-top: 30px;">

    <form action="validate_lokasi.php" method="POST" data-aos="fade-up" data-aos-duration="1800">
        <div style="
            border: 1px solid black;
            max-width: fit-content;
            margin: auto;
            padding: 20px;
        " class="shadow card"> 
        <h2 class="text-align-center">Tambah Lokasi</h2>
        <?php if(isset($_SESSION['isInvalid'])) { ?>
            <h5 class="text text-warning center"><?php echo $_SESSION['isInvalid']; $_SESSION['isInvalid'] = "";?></h5>
        <?php } ?>
        <table style="border: none;" cellpadding="20px">
            <tbody style="border: none;">
                <tr style="border: none;">
                    <td style="border: none;">
                        Kode Lokasi:
                    </td>
                    <td style="border: none;">
                        <input type="text" name="lokasi" id="lokasi" max="255" required pattern="[Gg][Bb][Jj][0-9]{1,}">
                    </td>
                </tr>
            </tbody>
        </table>
        <div style="text-align: center;">
                <button type="submit">POSTING</button>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>

</html>