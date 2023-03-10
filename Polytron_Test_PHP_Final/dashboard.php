<?php
    session_start();
    if(!isset($_SESSION['isLogin'])){
        header('Location: login.php');
    }

    $username = $_SESSION['username'];
    $password = $_SESSION['password'];

    require_once 'koneksi.php';
    $sql = "SELECT * FROM locations";
    $result = mysqli_query($connect, $sql);

    $sql = "SELECT * FROM items";
    $result2 = mysqli_query($connect, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/dashboard.css"/>
</head>
<body>
    <h1 class="text-align-center">Polytron Product Stock Management System</h1>
    <h3 class="text-align-center">Welcome Back, <?php echo $username?> &#128513;</h3>
    <div style="display: flex; justify-content: space-between; max-width: 30%; margin: auto;">
        <a href="transaction_history.php"><button style="padding: 10px;">CEK HISTORY TRANSAKSI</button></a>
        <a href="product_stock.php"><button style="padding: 10px;">CEK STOK BARANG</button></a>
        <a href="logout.php"><button style="padding: 10px;">LOGOUT</button></a>
    </div>
    <hr style="margin-bottom: 30px; margin-top: 30px;">

    <form action="stock_process.php" method="POST">
        <div style="
            border: 1px solid black;
            max-width: fit-content;
            margin: auto;
            padding: 20px;
        ">
            <h2 class="text-align-center">Maintenance Stock</h2>
            <?php
                if(isset($_SESSION['isInvalid'])){
                    if(strlen($_SESSION['isInvalid']) > 0){
            ?>
                <h4 class="text-align-center" style="color: red;">
                    <?php echo $_SESSION['isInvalid']?>
                </h4>

            <?php }} $_SESSION['isInvalid'] = "";?>
            <table style="border: none;" cellpadding="10px">
                <tbody>
                    <tr style="border: none;">
                        <td style="border: none;">
                            Jenis Transaksi: 
                        </td>
                        <td style="border: none;">
                            <input type="radio" name="tipe_transaksi" id="masuk" value="T" required checked="checked">
                            <label for="masuk">Masuk</label>
                            <input type="radio" name="tipe_transaksi" id="keluar" value="K" required>
                            <label for="keluar">Keluar</label>
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none;">
                            Bukti:
                        </td>
                        <td style="border: none;">
                            <input type="text" name="bukti" id="bukti" onchange="formatCheck()" required value="TAMBAH00">
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none;">
                        Lokasi:
                        </td>
                        <td style="border: none;">
                            <select name="lokasi" id="lokasi">
                            <?php
                                    while($data = mysqli_fetch_array($result)){
                                ?>   
                                    <option value="<?php echo $data['location_code']?>" selected><?php echo $data['location_code']?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none;">
                        Kode Barang:
                        </td>
                        <td style="border: none;">
                            <input list="itemcode" name="kodebarang" id="kodebarang" pattern="[P][S]-.{9}" required value="PS-PLD24T500">
                            <datalist id="itemcode">
                                <?php while($data = mysqli_fetch_array($result2)) {?>
                                    <option value="<?php echo $data['item_code']?>"><?php echo $data['item_code']?></option>
                                <?php 
                                    }
                                ?>
                            </datalist>
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none;">
                        Nama Barang:
                        </td>
                        <td style="border: none;">
                            <input list="item_name" name="namabarang" id="namabarang" required value="CINEMAX LED">
                            <datalist id="item_name">
                                <?php while($data = mysqli_fetch_array($result2)) {?>
                                    <option value="<?php echo $data['item_name']?>"><?php echo $data['item_name']?></option>
                                <?php 
                                    }
                                ?>
                            </datalist>
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none;">
                        Tgl Transaksi:
                        </td>
                        <td style="border: none;">
                            <input type="datetime-local" step="1" name="tanggal_transaksi" id="tanggal_transaksi" required>
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none;">
                        Quantity:
                        </td>
                        <td style="border: none;">
                            <input type="number" name="quantity" id="quantity" min="1" required value="10">
                        </td>
                    </tr>
                </tbody>
            </table>
            <div style="text-align: center;">
                <button type="submit">POSTING</button>
                <a href="dashboard.php"><button type="button">EXIT</button></a>
            </div>
        </div>
    </form>
    
    <script>
        function formatCheck(){
            if(document.getElementById('masuk').checked || document.getElementById('keluar').checked){
                if(document.getElementById('masuk').checked){
                    document.getElementById('bukti').pattern = "[tT][aA][mM][bB][aA][hH][0-9][0-9]{1,}";
                }else{
                    document.getElementById('bukti').pattern = "[kK][uU][rR][aA][nN][gG][0-9][0-9]{1,}";
                }
            }
        }
    </script>
</body>
</html>