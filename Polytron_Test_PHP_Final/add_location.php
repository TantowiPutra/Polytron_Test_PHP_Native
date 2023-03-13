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
    <link rel="stylesheet" type="text/css" href="css/dashboard.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <h1 class="text-align-center mb-4">Polytron Product Stock Management System</h1>
    <h3 class="text-align-center mb-4">Welcome Back, <?php echo $username ?> &#128513;</h3>
    <div style="display: flex; justify-content: space-between; max-width: 40%; margin: auto;">
        <a href="dashboard.php"><button style="padding: 10px;">DASHBOARD</button></a>
        <a href="transaction_history.php"><button style="padding: 10px;">CEK HISTORY TRANSAKSI</button></a>
        <a href="product_stock.php"><button style="padding: 10px;">CEK STOK BARANG</button></a>
        <a href="logout.php"><button style="padding: 10px;">LOGOUT</button></a>
    </div>
    <hr style="margin-bottom: 30px; margin-top: 30px;">

    <form action="validate_lokasi.php" method="POST">
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
                        <input type="text" name="lokasi" id="lokasi" max="255" required pattern="[G][B][J][0-9]{1,}">
                    </td>
                </tr>
            </tbody>
        </table>
        <div style="text-align: center;">
                <button type="submit">POSTING</button>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>