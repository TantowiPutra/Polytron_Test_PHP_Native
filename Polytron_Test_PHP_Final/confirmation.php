<?php
    session_start();
    if (!isset($_SESSION['isLogin'])) {
        header('Location: login.php');
    }

    require_once 'koneksi.php';

    $item_name = $_SESSION['new_item_name'];
    $item_code = $_SESSION['new_item_code'];
    $proof = $_SESSION['new_proof'];
    $location =  $_SESSION['new_location'];
    $transaction_time = $_SESSION['new_transaction_time'];
    $transaction_type = $_SESSION['new_transaction_type'];
    $quantity = $_SESSION['new_quantity'];
    $user_id = $_SESSION['id'];

    $sql = "SELECT * FROM locations WHERE id = '$location' LIMIT 1;";
    $execute_query = mysqli_query($connect, $sql);
    $result = mysqli_fetch_assoc($execute_query);

    function redirect($message)
    {
        global $transaction_type, $proof, $location, $item_code, $item_name, $transaction_time, $quantity;

        $_SESSION['isInvalid'] = "$message";
        $_SESSION['transaction_type'] = "$transaction_type";
        $_SESSION['proof'] = "$proof";
        $_SESSION['location'] = "$location";
        $_SESSION['item_code'] = "$item_code";
        $_SESSION['item_name'] = "$item_name";
        $_SESSION['transaction_time'] = "$transaction_time";
        $_SESSION['quantity'] = "$quantity";

        header('Location: dashboard.php');
    }

    if(isset($_REQUEST['input']) && $_REQUEST['input'] == "true"){
        $flag = true;

        $sql = "INSERT INTO items(item_code, item_name)
                        VALUES('$item_code', '$item_name')
                ";

        $result = mysqli_query($connect, $sql);
        if (!$result) {
            echo "Query Gagal1";
            $flag = false;
        }

        $sql = "SELECT * 
                FROM items WHERE item_code = '$item_code' 
                LIMIT 1;
        ";

        $result = mysqli_query($connect, $sql);
        $mysqli_assoc = mysqli_fetch_assoc($result);
        $item_id = $mysqli_assoc['id'];

        // Query insert ke tabel item stocks
        $sql = "INSERT INTO item_stocks(FK_locationcode, FK_itemcode, balance, date_input)
                    VALUES('$location', '$item_id', '$quantity', '$transaction_time')
            ";
        $result = mysqli_query($connect, $sql);
        if (!$result) {
            echo "Query Gagal2";
            $flag = false;
        }

        // Insert ke Transaction History
        $sql = "INSERT INTO transaction_history(proof, FK_locationcode, transaction_time, FK_itemcode, date_input, quantity, prog, FK_user)
            VALUES('$proof', '$location', '$transaction_time', '$item_id', '$transaction_time', '$quantity', '$transaction_type', '$user_id')
            ";

        $result = mysqli_query($connect, $sql);
        if (!$result) {
            echo "Query Gagal3";
            $flag = false;
        }

        if ($flag == true) {
            redirect("Produk Baru Berhasil di Input!");
        } else {
            redirect("Produk Gagal di Input! terdapat perubahan pada database!");
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Validation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body style="text-align: center;">
    <div class="card mx-auto mt-5 shadow" style="width: 400px;">
        <img src="image/thinking.jpg" class="card-img-top" alt="..." style="height: 200px; object-fit: cover; object-position: top;">
        <div class="card-body">
            <h5 class="card-title" style="font-weight: bolder; text-align: center;">Konfirmasi Input Produk Baru</h5>
            <p class="card-text">
                <table cellpadding="10px">
                    <tbody>
                        <tr>
                            <td style="max-width: 300px;">Tipe Transaksi</td>
                            <td style="max-width: 300px;">: </td>
                            <td><?php echo $transaction_type?></td>
                        </tr>
                        <tr>
                            <td style="max-width: 300px;">Kode Produk</td>
                            <td style="max-width: 300px;">: </td>
                            <td><?php echo $item_code?></td>
                        </tr>
                        <tr>
                            <td style="max-width: 300px;">Nama Produk</td>
                            <td style="max-width: 300px;">: </td>
                            <td><?php echo $item_name?></td>
                        </tr>
                        <tr>
                            <td style="max-width: 300px;">Kode Bukti</td>
                            <td style="max-width: 300px;">: </td>
                            <td><?php echo $proof?></td>
                        </tr>
                        <tr>
                            <td style="max-width: 400px;">Waktu Transaksi</td>
                            <td style="max-width: 400px;">: </td>
                            <td><?php echo $transaction_time?></td>
                        </tr>
                        <tr>
                            <td style="max-width: 400px;">Lokasi: </td>
                            <td style="max-width: 400px;">: </td>
                            <td><?php echo $result['location_code']?></td>
                        </tr>
                        <tr>
                            <td style="max-width: 400px;">Kuantitas: </td>
                            <td style="max-width: 400px;">: </td>
                            <td><?php echo $quantity?></td>
                        </tr>
                    </tbody>
                </table>
            </p>
            <a href="dashboard.php" class="btn btn-primary">BATAL</a>
            <a href="confirmation.php?input=true" class="btn btn-primary">TAMBAH</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>