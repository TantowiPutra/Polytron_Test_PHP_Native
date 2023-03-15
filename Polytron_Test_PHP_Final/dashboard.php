<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header('Location: login.php');
}

$username = $_SESSION['username'];
$password = $_SESSION['password'];

require_once 'koneksi.php';

// Query Daftar Lokasi
$sql = "SELECT * FROM locations";
$result = mysqli_query($connect, $sql);

// Query Daftar Barang
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

// Mendapatkan data nama admin
$sql_user = "SELECT * FROM users";
$execute_user = mysqli_query($connect, $sql_user);
?>

<script>
    const item_code = [];
    const item_name = [];

    <?php while ($data = mysqli_fetch_array($result2)) { ?>
        item_code.push("<?php echo $data['item_code'] ?>");
        item_name.push("<?php echo $data['item_name'] ?>");
    <?php } ?>
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/dashboard.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        .btn-yellow {
            font-weight: 600 !important;
            font-size: 14px !important;
            color: #000000;
            background-color: #eaff00 !important;
            padding: 10px 30px !important;
            border: solid #e2f200 2px;
            box-shadow: rgb(0, 0, 0) 0px 0px 0px 0px !important;
            border-radius: 50px !important;
            transition: 1265ms !important;
            transform: translateY(0) !important;
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            cursor: pointer !important;

        }

        .btn-yellow:hover {
            transition: 1265ms !important;
            padding: 10px 26px !important;
            transform: translateY(-0px) !important;
            background-color: #fff !important;
            color: #ff8c00 !important;
            border: solid 2px #ff8c00 !important;
        }
    </style>
</head>

<body>
    <h1 class="text-align-center mb-4">Polytron Product Stock Management System</h1>
    <h3 class="text-align-center mb-4">Welcome Back, <?php echo $username ?> &#128513;</h3>
    <div style="display: flex; justify-content: space-between; max-width: 70%; margin: auto;">
        <button type="button" class="btn btn-yellow" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
            DAFTAR ADMIN
        </button>
        <a style="text-decoration: none;" href="add_location.php"><button class="btn-yellow" style="padding: 10px;">TAMBAH LOKASI</button></a>
        <a style="text-decoration: none;" href="transaction_history.php"><button class="btn-yellow" style="padding: 10px;">CEK HISTORY TRANSAKSI</button></a>
        <a style="text-decoration: none;" href="product_stock.php"><button class="btn-yellow" style="padding: 10px;">CEK STOK BARANG</button></a>
        <a style="text-decoration: none;" href="logout.php"><button class="btn-yellow" style="padding: 10px;">LOGOUT</button></a>
    </div>
    <hr style="margin-bottom: 30px; margin-top: 30px;">
    <?php
    if (isset($_SESSION['isInvalid'])) {
        if (strlen($_SESSION['isInvalid']) > 0) {
    ?>
            <div class="alert <?php
                                if (isset($_SESSION['isSuccess'])) {
                                    if ($_SESSION['isSuccess'] == "T") {
                                        echo " alert-success ";
                                    } else {
                                        echo " alert-danger ";
                                    }
                                }
                                ?> alert-dismissible fade show position-fixed justify-content-center box-shadow-template mb-3" style="left: 33%; width: 500px; height: 100px; z-index: 2; top: 20%;" role="alert">
                <?php echo $_SESSION['isInvalid'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
    <?php
        }
    }
    $_SESSION['isInvalid'] = "";
    ?>

    <form action="stock_process.php" method="POST" data-aos="fade-up" data-aos-duration="1500">
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
                                if (isset($_SESSION['transaction_type'])) {
                                    if ($_SESSION['transaction_type'] == "TAMBAH") {
                                        echo "checked";
                                    }
                                }
                                $_SESSION['transaction_type'] = "";
                            ?>>

                            <label for="masuk">Masuk</label>
                            <input type="radio" name="tipe_transaksi" id="keluar" value="KURANG" required onchange="setProof()" 
                            <?php
                                if (isset($_SESSION['transaction_type'])) {
                                    if ($_SESSION['transaction_type'] == "KURANG") {
                                        echo "checked";
                                    }
                                }
                                $_SESSION['transaction_type'] = "";
                            ?>>
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
                                if (isset($_SESSION['proof'])) {
                                    echo "value=\"" . $_SESSION['proof'] . "\"";
                                }
                                $_SESSION['proof'] = "";
                            ?>>
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
                            <input list="itemcode" name="kodebarang" id="kodebarang1" pattern="[Pp][Ss]-.{1,}" required placeholder="PS-PLD24T500" max="50" onchange="findItemName()" style="text-transform:uppercase" 
                            <?php
                                if (isset($_SESSION['item_code'])) {
                                    echo "value=\"" . $_SESSION['item_code'] . "\"";
                                }
                                $_SESSION['item_code'] = "";
                            ?>>
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
                            <input class="datepicker" list="itemname" name="namabarang" id="namabarang" required placeholder="CINEMAX LED" maxlength="50" style="text-transform:uppercase" 
                            <?php
                                if (isset($_SESSION['item_name'])) {
                                    echo "value=\"" . $_SESSION['item_name'] . "\"";
                                }
                                $_SESSION['item_name'] = "";
                            ?>>
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
                                if (isset($_SESSION['transaction_time'])) {
                                    echo "value=\"" . $_SESSION['transaction_time'] . "\"";
                                }
                                $_SESSION['transaction_time'] = "";
                            ?>>
                        </td>
                    </tr>
                    <tr style="border: none;">
                        <td style="border: none;">
                            Quantity:
                        </td>
                        <td style="border: none;">
                            <input type="number" name="quantity" id="quantity" min="1" required placeholder="10" max="9999999" 
                        <?php
                            if (isset($_SESSION['quantity'])) {
                            echo "value=\"" . $_SESSION['quantity'] . "\"";
                            }
                            $_SESSION['quantity'] = "";
                        ?>>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div style="text-align: center;">
                <button type="submit">POSTING</button>
                <a href="dashboard.php"><button type="button">RESET</button></a>
            </div>
        </div>
    </form>

    <script>
        function setProof() {
            if (document.getElementById('masuk').checked || document.getElementById('keluar').checked) {
                if (document.getElementById('masuk').checked) {
                    document.getElementById('bukti').value = "TAMBAH0".concat("<?php echo $sql_tambah_fetch_assoc['total_tambah'] + 1; ?>");
                } else if (document.getElementById('keluar').checked) {
                    document.getElementById('bukti').value = "KURANG0".concat("<?php echo $sql_kurang_fetch_assoc['total_kurang'] + 1; ?>");
                }
            }
        }
    </script>

    <script>
        function findItemName() {
            let item_code_find = document.getElementById("kodebarang1").value;
            for (let i = 0; i < item_code.length; i++) {
                if (item_code_find == item_code[i]) {
                    document.getElementById('namabarang').value = item_name[i];
                }
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel"><b>Daftar Admin Stock</b></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Address</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Tanggal Bergabung</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($data = mysqli_fetch_array($execute_user)) { ?>
                                <tr>
                                    <td><?php echo $data['username'] ?></td>
                                    <td><?php echo $data['address'] ?></td>
                                    <td><?php echo $data['gender'] ?></td>
                                    <td><?php echo $data['created_at'] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html>