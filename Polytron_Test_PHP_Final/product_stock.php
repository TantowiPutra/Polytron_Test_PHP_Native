<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header('Location: login.php');
}

$username = $_SESSION['username'];
$password = $_SESSION['password'];

require_once 'koneksi.php';

// Tangkap Data Transaction History
$sql = "SELECT * FROM item_stocks ist
                JOIN 
                    locations l 
                    ON ist.FK_locationcode = l.location_code
                JOIN 
                    items i 
                    ON ist.FK_itemcode = i.item_code
        ORDER BY ist.FK_locationcode, ist.tgl_masuk ASC
    ";

// Menampilkan total stok untuk tiap barang untuk tiap lokasi
$sql2 = "SELECT FK_locationcode,
                    FK_itemcode,
                    item_name,
                    SUM(saldo) AS total_stock
                    FROM item_stocks ist
                JOIN 
                    locations l
                    ON ist.FK_locationcode = l.location_code
                JOIN items i
                    ON ist.FK_itemcode = i.item_code
            GROUP BY FK_locationcode, FK_itemcode
            ORDER BY FK_locationcode
    ";

$result = mysqli_query($connect, $sql);
$result_count = mysqli_query($connect, $sql2);

if (!$result) {
    echo "Query Gagal";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
    <link rel="stylesheet" type="text/css" href="css/dashboard.css" />
</head>

<body>
    <h1 class="text-align-center">Product Stock</h1>
    <h3 class="text-align-center">Stok Produk</h3>
    <div style="display: flex; justify-content: center; margin: auto;">
        <a href="dashboard.php"><button style="padding: 10px;">KEMBALI</button></a>
    </div>
    <hr style="margin-bottom: 30px; margin-top: 30px;">

    <!-- Menampilkan data Transaksi -->
    <div class="center" style="margin-bottom: 30px;">
        <h1 class="text-align-center">Product Stock</h1>
        <table cellpadding="30px" class="center">
            <thead>
                <tr>
                    <td>Lokasi</td>
                    <td>Kode Barang</td>
                    <td>Nama Barang</td>
                    <td>Saldo</td>
                    <td>Tgl Masuk</td>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_array($result)) { ?>
                    <tr>
                        <td><?php echo $data['location_code'] ?></td>
                        <td><?php echo $data['item_code'] ?></td>
                        <td><?php echo $data['item_name'] ?></td>
                        <td><?php echo $data['saldo'] ?></td>
                        <td><?php echo date('d/m/Y', strtotime($data['tgl_masuk'])) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="center" style="margin-bottom: 200px;">
        <h1 class="text-align-center">Stok Produk Total</h1>
        <table cellpadding="30px" class="center">
            <thead>
                <tr>
                    <td>Kode Lokasi</td>
                    <td>Kode Produk</td>
                    <td>Nama Produk</td>
                    <td>Stok Total</td>
                </tr>
            </thead>
            <tbody>
                <?php while ($data = mysqli_fetch_array($result_count)) { ?>
                    <tr>
                        <td><?php echo $data['FK_locationcode'] ?></td>
                        <td><?php echo $data['FK_itemcode'] ?></td>
                        <td><?php echo $data['item_name'] ?></td>
                        <td><?php echo $data['total_stock'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>