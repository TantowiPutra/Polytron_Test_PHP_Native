<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header('Location: login.php');
}

$username = $_SESSION['username'];
$password = $_SESSION['password'];

require_once 'koneksi.php';

$sql = "SELECT * FROM locations";
$result = mysqli_query($connect, $sql);

$sql = "SELECT * FROM items";
$result2 = mysqli_query($connect, $sql);


// Mendapatkan total tambah
   $sql_tambah = "SELECT COUNT(id) AS total_tambah FROM transaction_history WHERE proof LIKE 'TAMBAH%'";
   $sql_tambah_query = mysqli_query($connect, $sql_tambah);
   $sql_tambah_fetch_assoc = mysqli_fetch_assoc($sql_tambah_query);

// Mendapatkan total kurang
   $sql_kurang = "SELECT COUNT(id) AS total_kurang FROM transaction_history WHERE proof LIKE 'KURANG%'";
   $sql_kurang_query = mysqli_query($connect, $sql_kurang);
   $sql_kurang_fetch_assoc = mysqli_fetch_assoc($sql_kurang_query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/dashboard.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body>
    <h1 class="text-align-center mb-4">Polytron Product Stock Management System</h1>
    <h3 class="text-align-center mb-4">Welcome Back, <?php echo $username ?> &#128513;</h3>
    <div style="display: flex; justify-content: space-between; max-width: 40%; margin: auto;">
        <a href="add_location.php"><button style="padding: 10px;">TAMBAH LOKASI</button></a>
        <a href="transaction_history.php"><button style="padding: 10px;">CEK HISTORY TRANSAKSI</button></a>
        <a href="product_stock.php"><button style="padding: 10px;">CEK STOK BARANG</button></a>
        <a href="logout.php"><button style="padding: 10px;">LOGOUT</button></a>
    </div>
    <hr style="margin-bottom: 30px; margin-top: 30px;">
    <?php
    if (isset($_SESSION['isInvalid'])) {
        if (strlen($_SESSION['isInvalid']) > 0) {
    ?>
            <div class="alert alert-warning alert-dismissible fade show position-fixed justify-content-center box-shadow-template mb-3" style="left: 33%; width: 500px; height: 100px; z-index: 2; top: 20%;" role="alert">
                <?php echo $_SESSION['isInvalid'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
    <?php
        }
    }
    $_SESSION['isInvalid'] = "";
    ?>

    <form action="stock_process.php" method="POST">
        <div style="
            border: 1px solid black;
            max-width: fit-content;
            margin: auto;
            padding: 20px;
        " class="shadow card">
            <h2 class="text-align-center">Maintenance Stock</h2>
            <table style="border: none;" cellpadding="10px">
                <tbody>
                    <tr style="border: none;">
                        <td style="border: none;">
                            Jenis Transaksi:
                        </td>
                        <td style="border: none;">
                            <input type="radio" name="tipe_transaksi" id="masuk" value="TAMBAH" required onchange="setProof()"
                            <?php
                                if(isset($_SESSION['transaction_type'])){
                                    if($_SESSION['transaction_type'] == "TAMBAH"){
                                        echo "checked";
                                    }
                                }
                                $_SESSION['transaction_type'] = "";
                            ?> 
                            >
                            <label for="masuk">Masuk</label>
                            <input type="radio" name="tipe_transaksi" id="keluar" value="KURANG" required
                            onchange="setProof()"
                                <?php
                                    if(isset($_SESSION['transaction_type'])){
                                        if($_SESSION['transaction_type'] == "KURANG"){
                                            echo "checked";
                                        }
                                    }
                                    $_SESSION['transaction_type'] = "";
                                ?> 
                            >
                            <label for="keluar">Keluar</label>
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none;">
                            Bukti:
                        </td>
                        <td style="border: none;">
                            <input type="text" name="bukti" id="bukti" required placeholder="TAMBAH00" max="50" readonly
                            <?php
                                if(isset($_SESSION['proof'])){
                                    echo "value=\"" . $_SESSION['proof'] . "\"";
                                }
                                $_SESSION['proof'] = "";
                            ?> 
                            >
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none;">
                            Lokasi:
                        </td>
                        <td style="border: none;">
                            <select name="lokasi" id="lokasi">
                                <?php
                                while ($data = mysqli_fetch_array($result)) {
                                ?>
                                    <option value="<?php echo $data['id'] ?>">
                                            <?php echo $data['location_code'] ?>
                                    </option>
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
                            <input list="itemcode" name="kodebarang" id="kodebarang" pattern="[P][S]-.{1,}" required placeholder="PS-PLD24T500" max="50"
                            <?php
                                if(isset($_SESSION['item_code'])){
                                    echo "value=\"" . $_SESSION['item_code'] . "\"";
                                }
                                $_SESSION['item_code'] = "";
                            ?>  
                            >
                            <datalist id="itemcode">
                                <?php while ($data = mysqli_fetch_array($result2)) {
                                    echo $data['item_code'] ?>
                                    <option value="<?php echo $data['item_code'] ?>"><?php echo $data['item_code'] ?></option>
                                <?php } ?>
                            </datalist>
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none;">
                            Nama Barang:
                        </td>
                        <td style="border: none;">
                            <input class="datepicker" list="itemname" name="namabarang" id="namabarang" required placeholder="CINEMAX LED" max="50" 
                            <?php
                                if(isset($_SESSION['item_name'])){
                                    echo "value=\"" . $_SESSION['item_name'] . "\"";
                                }
                                $_SESSION['item_name'] = "";
                            ?>        
                            >
                            <datalist id="itemname">
                                <?php while ($data = mysqli_fetch_array($result2)) { ?>
                                    <option value="<?php echo $data['item_name'] ?>">
                                    <?php } ?>
                            </datalist>
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none;">
                            Tgl Transaksi:
                        </td>
                        <td style="border: none;">
                            <input type="datetime-local" step="1" name="tanggal_transaksi" id="tanggal_transaksi" required
                            <?php
                                if(isset($_SESSION['transaction_time'])){
                                    echo "value=\"" . $_SESSION['transaction_time'] . "\"";
                                }
                                $_SESSION['transaction_time'] = "";
                            ?> >
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none;">
                            Quantity:
                        </td>
                        <td style="border: none;">
                            <input type="number" name="quantity" id="quantity" min="1" required placeholder="10" max="9999999"
                            <?php
                                if(isset($_SESSION['quantity'])){
                                    echo "value=\"" . $_SESSION['quantity'] . "\"";
                                }
                                $_SESSION['quantity'] = "";
                            ?> 
                            >
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
        function setProof() {
            if (document.getElementById('masuk').checked || document.getElementById('keluar').checked) {
                if (document.getElementById('masuk').checked) {
                    document.getElementById('bukti').value = "TAMBAH0".concat("<?php echo $sql_tambah_fetch_assoc['total_tambah'] + 1; ?>");
                } else if(document.getElementById('keluar').checked){
                    document.getElementById('bukti').value = "KURANG0".concat("<?php echo $sql_kurang_fetch_assoc['total_kurang'] + 1; ?>");
                }
            }
        }
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

</html>