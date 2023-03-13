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

$isAlready = false;
// Query untuk search
if (isset($_POST['search_location'])) {
    if ($_POST['search_location'] != null) {
        $search = $_POST['search_location'];

        $sql = $sql . "WHERE location_code = '$search'";
        $sql2 = $sql2 . "WHERE location_code = '$search'";
    }

    if (isset($_POST['search_item_code'])) {
        if ($_POST['search_item_code'] != null) {
            $search = $_POST['search_item_code'];

            $sql = $sql . "AND item_code = '$search'";
            $sql2 = $sql2 . "AND item_code = '$search'";
            $isAlready = true;
        }
    }
}

if ($isAlready == false) {
    if (isset($_POST['search_item_code'])) {
        if ($_POST['search_item_code'] != null) {
            $search = $_POST['search_item_code'];

            $sql = $sql . "WHERE item_code = '$search'";
            $sql2 = $sql2 . "WHERE item_code = '$search'";
        }
    }
}

if (isset($_POST['search_item_code']) || isset($_POST['search_location'])) {
    $sql = $sql . "AND balance > '0'";
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
</head>

<body>
    <h1 class="text-align-center mb-4">Product Stock</h1>
    <h3 class="text-align-center mb-4">Stok Produk</h3>
    <div style="display: flex; justify-content: space-between; max-width: 30%; margin: auto;">
        <a href="transaction_history.php"><button style="padding: 10px;">CEK HISTORY TRANSAKSI</button></a>
        <a href="dashboard.php"><button style="padding: 10px;">KEMBALI</button></a>
        <a href="logout.php"><button style="padding: 10px;">LOGOUT</button></a>
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
                <label for="search_location">Cari Item Code: </label>
                <select name="search_item_code" id="search_item_coded">
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
            <button type="submit" class="mt-3">SUBMIT</button>
        </form>
    </div>

    <!-- Menampilkan data Transaksi -->
    <div class="center" style="margin-bottom: 30px;">
        <h1 class="text-align-center mt-4">Product Stock</h1>
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
</body>

</html>