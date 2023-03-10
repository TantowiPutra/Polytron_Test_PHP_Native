<?php
    session_start();
    if(!isset($_SESSION['isLogin'])){
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
    ";

    $result = mysqli_query($connect, $sql);

    if(!$result){
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
    <link rel="stylesheet" type="text/css" href="css/dashboard.css"/>
</head>
<body>
    <h1 class="text-align-center">Product Stock</h1>
    <h3 class="text-align-center">Stok Produk</h3>
    <div style="display: flex; justify-content: center; margin: auto;">
        <a href="dashboard.php"><button style="padding: 10px;">KEMBALI</button></a>
    </div>
    <hr style="margin-bottom: 30px; margin-top: 30px;">

    <!-- Menampilkan data Transaksi -->
    <div class="center" style="margin-bottom: 300px;">
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
            <?php while($data = mysqli_fetch_array($result)) {?>
                <tr>
                    <td><?php echo $data['location_code']?></td>
                    <td><?php echo $data['item_code']?></td>
                    <td><?php echo $data['item_name']?></td>
                    <td><?php echo $data['saldo']?></td>
                    <td><?php echo date('d/m/Y', strtotime($data['tgl_masuk']))?></td>
                </tr>
            <?php } ?>
        </tbody>
       </table>
    </div>
</body>
</html>