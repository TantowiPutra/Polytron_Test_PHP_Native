<?php
    session_start();
    if(!isset($_SESSION['isLogin'])){
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
    <h1 class="text-align-center">Transaction History</h1>
    <h3 class="text-align-center">Sejarah Transaksi</h3>
    <div style="display: flex; justify-content: center; margin: auto;">
        <a href="dashboard.php"><button style="padding: 10px;">KEMBALI</button></a>
    </div>
    <hr style="margin-bottom: 30px; margin-top: 30px;">

    <!-- Menampilkan data Transaksi -->
    <div class="center">
        <h1 class="text-align-center">Transaction History</h1>
        <table cellpadding="30px" class="center">
            <thead>
                <tr>
                    <td>Bukti</td>
                    <td>Tgl</td>
                    <td>Jam</td>
                    <td>Lokasi</td>
                    <td>Kode Barang</td>
                    <td>Tgl Masuk</td>
                    <td>Qty Trn</td>
                    <td>Prog</td>
                    <td>Operator</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    while($data = mysqli_fetch_array($result)){
                    $bukti = $data['bukti'];
                    $time = $data['transaction_time'];
                    $lokasi = $data['location_code'];
                    $item_code = $data['item_code'];
                    $date_input = $data['tgl_masuk'];
                    $quantity = $data['quantity'];
                    $prog = $data['prog'];
                    $operator = $data['username'];
                ?>
                    <tr>
                        <td><?php echo $bukti?></td>
                        <td><?php echo date("d/m/Y",strtotime($time));?></td>
                        <td>
                            <?php echo date("H:i:s",strtotime($time));?>
                        </td>
                        <td><?php echo $lokasi?></td>
                        <td><?php echo $item_code?></td>
                        <td>
                            <?php echo date('d/m/Y', strtotime($date_input))?>
                        </td>
                        <td style="text-align: right;"><?php echo $quantity?></td>
                        <td>
                            <?php
                            if($prog == "T"){
                                echo "TAMBAH";
                            }else{
                                echo "KURANG";
                            }
                            ?>
                        </td>
                        <td><?php echo $operator?></td>
                    </tr>
                <?php 
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>