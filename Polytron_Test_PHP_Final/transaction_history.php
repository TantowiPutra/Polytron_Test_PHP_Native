<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header('Location: login.php');
}

$username = $_SESSION['username'];
$password = $_SESSION['password'];

require_once 'koneksi.php';

// Tangkap Data Stock Product
$sql = "SELECT * FROM
            transaction_history th 
                JOIN items i
                    ON th.FK_itemcode = i.item_code
                JOIN locations c
                    ON th.FK_locationcode = c.location_code
                JOIN users u
                    ON th.FK_user = u.id 
    ";

if(isset($_POST['search_bukti'])){
    $search = addslashes($_POST['search_bukti']);
    $sql = $sql . "WHERE bukti LIKE '%$search%'";
}

$result = mysqli_query($connect, $sql);

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <h1 class="text-align-center mb-4">Transaction History</h1>
    <h3 class="text-align-center mb-4">Sejarah Transaksi</h3>
    <div style="display: flex; justify-content: space-between; max-width: 30%; margin: auto;">
        <a href="product_stock.php"><button style="padding: 10px;">CEK STOK BARANG</button></a>
        <a href="dashboard.php"><button style="padding: 10px;">KEMBALI</button></a>
        <a href="logout.php"><button style="padding: 10px;">LOGOUT</button></a>
    </div>
    <hr style="margin-bottom: 30px; margin-top: 30px;">

    <div class="center mb-4" style="text-align: center;">
        <form action="transaction_history.php" method="POST">
            <input type="text" name = "search_bukti" id="search_bukti">
            <button type="submit">CARI BUKTI</button>
        </form>
    </div>

    <!-- Menampilkan data Transaksi -->
    <div class="center" style="margin-bottom: 300px;">
        <h1 class="text-align-center">Transaction History</h1>
        <table cellpadding="30px" class="center table table-striped shadow" style="max-width: 80%;">
            <thead>
                <tr>
                    <td>Bukti</td>
                    <td>Tgl</td>
                    <td>Jam</td>
                    <td>Lokasi</td>
                    <td>Kode Barang</td>
                    <td>Nama Barang</td>
                    <td>Tgl Masuk</td>
                    <td>Qty Trn</td>
                    <td>Prog</td>
                    <td>Operator</td>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($data = mysqli_fetch_array($result)) {
                    $bukti = $data['proof'];
                    $time = $data['transaction_time'];
                    $lokasi = $data['location_code'];
                    $item_code = $data['item_code'];
                    $date_input = $data['date_input'];
                    $quantity = $data['quantity'];
                    $prog = $data['prog'];
                    $operator = $data['username'];
                    $item_name = $data['item_name'];
                ?>
                    <tr>
                        <td><?php echo $bukti ?></td>
                        <td><?php echo date("d/m/Y", strtotime($time)); ?></td>
                        <td>
                            <?php echo date("H:i:s", strtotime($time)); ?>
                        </td>
                        <td><?php echo $lokasi ?></td>
                        <td><?php echo $item_code ?></td>
                        <td><?php echo $item_name?></td>
                        <td>
                            <?php echo date('d/m/Y', strtotime($date_input)) ?>
                        </td>
                        <td style="text-align: right;"><?php echo number_format(($prog == "K") ? "-$quantity" : "$quantity") ?></td>
                        <td>
                            <?php
                            if ($prog == "T") {
                                echo "TAMBAH";
                            } else {
                                echo "KURANG";
                            }
                            ?>
                        </td>
                        <td><?php echo $operator ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</body>

</html>