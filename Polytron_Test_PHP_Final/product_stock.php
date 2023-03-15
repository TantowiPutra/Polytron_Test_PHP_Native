<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header('Location: login.php');
}

$username = $_SESSION['username'];
$password = $_SESSION['password'];

require_once 'koneksi.php';

// Tangkap Data Item Stock
$sql = "SELECT *
        FROM item_stocks ist
                JOIN 
                    locations l 
                    ON ist.FK_locationcode = l.id
                JOIN 
                    items i 
                    ON ist.FK_itemcode = i.id
    ";

// Menampilkan total stok untuk tiap barang untuk tiap lokasi
$sql2 = "SELECT FK_locationcode,
                    FK_itemcode,
                    item_name,
                    SUM(balance) AS total_stock,
                    l.location_code AS location_code,
                    i.item_code AS item_code
                    FROM item_stocks ist
                JOIN 
                    locations l
                    ON ist.FK_locationcode = l.id
                JOIN items i
                    ON ist.FK_itemcode = i.id 
    ";

$search_array = array();
$counter = 0;

if (isset($_POST['search_location']) && strlen($_POST['search_location'])) {
    $location = $_POST['search_location'];
    array_push($search_array, " location_code = '$location' ");
    $counter++;
}

if (isset($_POST['search_item_code']) && strlen($_POST['search_item_code'])) {
    $item_code = $_POST['search_item_code'];
    array_push($search_array, " item_code = '$item_code' ");
    $counter++;
}

if (isset($_POST['start_date']) && strlen($_POST['start_date'])) {
    $_SESSION['start_date'] = $_POST['start_date'];
    $_SESSION['end_date'] = $_POST['end_date'];
    $start_date = date("Y-m-d", strtotime($_POST['start_date']));
    $end_date = date("Y-m-d", strtotime($_POST['end_date']));
    array_push($search_array, " (date_input BETWEEN '$start_date' AND '$end_date 23:59:59') ");
    $counter++;
}

if ($counter > 0) {
    $sql = $sql . " WHERE ";
    $sql2 = $sql2 . " WHERE ";
}

for ($i = 0; $i < $counter; $i++) {
    $sql = $sql . $search_array[$i];
    $sql2 = $sql2 . $search_array[$i];

    if ($i != $counter - 1) {
        $sql = $sql . " AND ";
        $sql2 = $sql2 . " AND ";
    }
}

$sql = $sql . "ORDER BY i.item_name, ist.date_input ASC";
$sql2 = $sql2 . "GROUP BY FK_locationcode, FK_itemcode ORDER BY FK_locationcode";

// Query Product_Stock
$result = mysqli_query($connect, $sql);

// Query Product_Stock Total
$result_count = mysqli_query($connect, $sql2);

if (!$result) {
    echo "Query Gagal 1";
}

$sql_location = "SELECT * FROM locations";
$search_result_location = mysqli_query($connect, $sql_location);

$sql_item_code = "SELECT * FROM items";
$search_result_code = mysqli_query($connect, $sql_item_code);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Stock</title>
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
    <h1 class="text-align-center mb-4">Product Stock</h1>
    <h3 class="text-align-center mb-4">Stok Produk</h3>
    <div style="display: flex; justify-content: space-between; max-width: 35%; margin: auto;">
        <a style="text-decoration: none;" href="transaction_history.php"><button style="padding: 10px;" class="btn-yellow">CEK HISTORY TRANSAKSI</button></a>
        <a style="text-decoration: none;" href="dashboard.php"><button style="padding: 10px;" class="btn-yellow">KEMBALI</button></a>
        <a style="text-decoration: none;" href="logout.php"><button style="padding: 10px;" class="btn-yellow">LOGOUT</button></a>
    </div>

    <hr style="margin-bottom: 30px; margin-top: 30px;">
    <div style="text-align: center;">
        <form action="product_stock.php" method="POST">
            <div class="mt-3">
                <label for="search_location">Cari Lokasi: </label>
                <select name="search_location" id="search_location">
                    <option value="">Search All</option>
                    <?php
                    while ($data = mysqli_fetch_array($search_result_location)) {
                    ?>
                        <option value="<?php echo $data['location_code'] ?>"><?php echo $data['location_code'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="mt-3">
                <label for="search_location">Cari Kode Barang: </label>
                <select name="search_item_code" id="search_item_code">
                    <option value="">Search All</option>
                    <?php
                    while ($data = mysqli_fetch_array($search_result_code)) {
                    ?>
                        <option value="<?php echo $data['item_code'] ?>"><?php echo $data['item_code'] ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="mt-3">
                <label for="search_location">Range Tanggal: </label>
                <input type="text" name="start_date" id="start_date">
                <span>~</span>
                <input type="text" name="end_date" id="end_date">
            </div>
            <button type="submit" class="mt-3">SUBMIT</button>
        </form>
    </div>

    <!-- Menampilkan data Transaksi -->
    <div class="center" style="margin-bottom: 30px;">
        <h1 class="text-align-center mt-4">Product Stock Transaction</h1>
        <table cellpadding="30px" class="center shadow table-striped table" style="max-width: 80%;">
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
                        <td style="text-align: right;"><?php echo number_format($data['balance']) ?></td>
                        <td><?php echo date('d/m/Y', strtotime($data['date_input'])) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="center" style="margin-bottom: 200px;">
        <h1 class="text-align-center">Stok Produk Total</h1>
        <table cellpadding="30px" class="center shadow table-striped table" style="max-width: 80%;">
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
                        <td><?php echo $data['location_code'] ?></td>
                        <td><?php echo $data['item_code'] ?></td>
                        <td><?php echo $data['item_name'] ?></td>
                        <td style="text-align: right;"><?php echo number_format($data['total_stock']) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <link type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />

    <script>
        const form = document.querySelector('form');
        const field1 = document.getElementById('start_date');
        const field2 = document.getElementById('end_date');
        form.addEventListener('submit', (event) => {
            if (start_date.value && !end_date.value) {
                event.preventDefault(); // Prevent form submission
                alert('Tolong isi tanggal akhir!');
            } else if (!start_date.value && end_date.value) {
                event.preventDefault(); // Prevent form submission
                alert('Tolong isi tanggal awal!');
            }
        });
    </script>

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.js">
    </script>
    <script type="text/javascript" src="https://code.jquery.com/ui/1.12.1/jquery-ui.js">
    </script>
    <script type="text/javascript">
        $(function() {
            $("#start_date").datepicker({
                dateFormat: 'dd-mm-yy'
            });

            $("#end_date").datepicker({
                dateFormat: 'dd-mm-yy'
            });
        });
    </script>
</body>

</html>