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
                    ON th.FK_itemcode = i.id
                JOIN locations c
                    ON th.FK_locationcode = c.id
                JOIN users u
                    ON th.FK_user = u.id
    ";

// Hitung ada berapa banyak field yang akan di search
$counter = 0;
$array_kalimat = array();

if (isset($_REQUEST['session']) && $_REQUEST['session'] == "reset") {
    $_SESSION['search_proof'] = "";
    $_SESSION['transaction_date'] = "";
    $_SESSION['search_location'] = "";
    $_SESSION['search_item'] = "";
}

if (isset($_POST['search_proof']) && strlen($_POST['search_proof']) > 0) {
    $counter++;
    $proof = $_POST['search_proof'];
    $_SESSION['search_proof'] = $proof;
    array_push($array_kalimat, " proof LIKE '%$proof%' ");
}

if (isset($_SESSION['search_proof']) && strlen($_SESSION['search_proof']) > 0) {
    $counter++;
    $proof = $_SESSION['search_proof'];
    array_push($array_kalimat, " proof LIKE '%$proof%' ");
}

if (isset($_POST['transaction_date']) && strlen($_POST['transaction_date']) > 0) {
    $counter++;
    $transaction_date = date("Y-m-d", strtotime($_POST['transaction_date']));
    $_SESSION['transaction_date'] = $transaction_date;
    array_push($array_kalimat, " transaction_time LIKE '%$transaction_date%' ");
}

if (isset($_SESSION['transaction_date']) && strlen($_SESSION['transaction_date']) > 0) {
    $counter++;
    $transaction_date = $_SESSION['transaction_date'];
    array_push($array_kalimat, " transaction_time LIKE '%$transaction_date%' ");
}

if (isset($_POST['search_location']) && strlen($_POST['search_location']) > 0) {
    $counter++;
    $location = $_POST['search_location'];
    $_SESSION['search_location'] = $location;
    array_push($array_kalimat, " location_code LIKE '%$location%' ");
}

if (isset($_SESSION['search_location']) && strlen($_SESSION['search_location']) > 0) {
    $counter++;
    $location = $_SESSION['search_location'];
    array_push($array_kalimat, " location_code LIKE '%$location%' ");
}

if (isset($_POST['search_item']) && strlen($_POST['search_item']) > 0) {
    $counter++;
    $item = $_POST['search_item'];
    $_SESSION['search_item'] = $item;
    array_push($array_kalimat, " item_code LIKE '%$item%' ");
}

if (isset($_SESSION['search_item']) && strlen($_SESSION['search_item']) > 0) {
    $counter++;
    $item = $_SESSION['search_item'];
    array_push($array_kalimat, " item_code LIKE '%$item%' ");
}

if ($counter > 0) {
    $sql = $sql . "WHERE ";
}

for ($i = 0; $i < $counter; $i++) {
    $sql = $sql . $array_kalimat[$i];

    if ($i < $counter - 1) {
        $sql = $sql . " AND ";
    }
}

$result = mysqli_query($connect, $sql);

if (!$result) {
    echo "Query Gagal";
}

$sql_bukti = "SELECT DISTINCT proof FROM transaction_history";
$sql_lokasi = "SELECT * FROM locations";

$result_sql_bukti = mysqli_query($connect, $sql_bukti);
$result_sql_lokasi = mysqli_query($connect, $sql_lokasi);
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
    <h1 class="text-align-center mb-4">Transaction History</h1>
    <h3 class="text-align-center mb-4">Sejarah Transaksi</h3>
    <div style="display: flex; justify-content: space-between; max-width: 30%; margin: auto;">
        <a href="product_stock.php" style="text-decoration: none;"><button style="padding: 10px;" class="btn-yellow">CEK STOK BARANG</button></a>
        <a href="dashboard.php" style="text-decoration: none;"><button style="padding: 10px;" class="btn-yellow">KEMBALI</button></a>
        <a href="logout.php" style="text-decoration: none;"><button style="padding: 10px;" class="btn-yellow">LOGOUT</button></a>
    </div>
    <hr style="margin-bottom: 30px; margin-top: 30px;">

    <div class="center mb-4" style="text-align: center;">
        <form action="transaction_history.php" method="POST">
            <table>
                <div class="mt-3">
                    <label for="search_proof" style="margin-right: 8%; text-align: left;">Bukti</label>
                    <input type="text" name="search_proof" id="search_proof" <?php
                                                                                if (isset($_SESSION['search_proof']) && strlen($_SESSION['search_proof']) > 0) {
                                                                                    echo "value=\"" . $_SESSION['search_proof'] . "\"";
                                                                                }
                                                                                ?>>
                </div>

                <div class="mt-3">
                    <label for="transaction_date" style="margin-right: 2%; text-align: left;">Tanggal Transaksi: </label>
                    <input type="text" name="transaction_date" id="transaction_date" <?php
                                                                                        if (isset($_SESSION['transaction_date']) && strlen($_SESSION['transaction_date']) > 0) {
                                                                                            echo "value=\"" . date("d-m-Y", strtotime($_SESSION['transaction_date'])) . "\"";
                                                                                        }
                                                                                        ?>>
                </div>

                <div class="mt-3">
                    <label for="search_location" style="margin-right: 7.5%; text-align: left;">Lokasi</label>
                    <input type="text" name="search_location" id="search_location" <?php
                                                                                    if (isset($_SESSION['search_location']) && strlen($_SESSION['search_location']) > 0) {
                                                                                        echo "value=\"" . $_SESSION['search_location'] . "\"";
                                                                                    }
                                                                                    ?>>
                </div>

                <div class="mt-3">
                    <label for="search_item" style="margin-right: 4.5%; text-align: left;">Kode Barang: </label>
                    <input type="text" name="search_item" id="search_item" <?php
                                                                            if (isset($_SESSION['search_item']) && strlen($_SESSION['search_item']) > 0) {
                                                                                echo "value=\"" . $_SESSION['search_item'] . "\"";
                                                                            }
                                                                            ?>>
                </div>
            </table>
            <button type="submit" class="mt-3">CARI</button>
            <a href="transaction_history.php?session=reset" style="margin-left: 20px;"><button type="button">RESET PENCARIAN</button></a>
        </form>
    </div>

    <!-- Menampilkan data Transaksi -->
    <div class="center" style="margin-bottom: 300px;">
        <h1 class="text-align-center">Transaction History</h1>
        <table cellpadding="30px" class="center table table-striped shadow" style="max-width: 80%;">
            <thead>
                <tr>
                    <td>No. </td>
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
                $batas = 5;
                $halaman = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
                $halaman_awal = ($halaman > 1) ? ($halaman * $batas) - $batas : 0;

                $previous = $halaman - 1;
                $next = $halaman + 1;

                $data = mysqli_query($connect, $sql);
                $jumlah_data = mysqli_num_rows($data);
                $total_halaman = ceil($jumlah_data / $batas);

                $data_paginate = mysqli_query($connect, $sql . "LIMIT $halaman_awal, $batas");
                $nomor = $halaman_awal + 1;

                while ($data = mysqli_fetch_array($data_paginate)) {
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
                        <td><?php echo $nomor++; ?></td>
                        <td><?php echo $bukti ?></td>
                        <td><?php echo date("d/m/Y", strtotime($time)); ?></td>
                        <td>
                            <?php echo date("H:i:s", strtotime($time)); ?>
                        </td>
                        <td><?php echo $lokasi ?></td>
                        <td><?php echo $item_code ?></td>
                        <td><?php echo $item_name ?></td>
                        <td>
                            <?php echo date('d/m/Y', strtotime($date_input)) ?>
                        </td>
                        <td style="text-align: right;"><?php echo number_format(($prog == "KURANG") ? "-$quantity" : "$quantity") ?></td>
                        <td>
                            <?php
                            if ($prog == "TAMBAH") {
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
        <nav>
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <a class="page-link" <?php if ($halaman > 1) {
                                                echo "href='?halaman=$previous'";
                                            } ?>>Previous</a>
                </li>
                <?php
                for ($x = 1; $x <= $total_halaman; $x++) {
                ?>
                    <li class="page-item"><a class="page-link" href="?halaman=<?php echo $x ?>"><?php echo $x; ?></a></li>
                <?php
                }
                ?>
                <li class="page-item">
                    <a class="page-link" <?php if ($halaman < $total_halaman) {
                                                echo "href='?halaman=$next'";
                                            } ?>>Next</a>
                </li>
            </ul>
        </nav>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js">
    </script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js">
    </script>
    <script type="text/javascript">
        $(function() {
            $("#transaction_date").datepicker({
                dateFormat: 'dd-mm-yy'
            });
        });
    </script>
</body>

</html>