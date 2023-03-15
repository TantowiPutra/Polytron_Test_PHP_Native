<?php
session_start();
if (!isset($_SESSION['isLogin'])) {
    header('Location: login.php');
}

require_once 'koneksi.php';

$transaction_type = $_POST['tipe_transaksi'];
$proof = $_POST['bukti'];
$location = $_POST['lokasi'];
$item_code = $_POST['kodebarang'];
$item_name = $_POST['namabarang'];
$transaction_time = date('Y-m-d H:i:s', strtotime($_POST['tanggal_transaksi']));
$quantity = $_POST['quantity'];

$transaction_time = strtoupper(trim(addslashes($transaction_time)));
$proof = strtoupper(trim(addslashes($proof)));
$location = strtoupper(trim(addslashes($location)));
$item_code = strtoupper(trim(addslashes($item_code)));
$item_name = strtoupper(trim(addslashes($item_name)));
$transaction_time = trim(addslashes($transaction_time));
$quantity = strtoupper(trim(addslashes($quantity)));

// Cek apakah kode bukti sudah ada atau belum (harus unique)
$sql = "SELECT * FROM transaction_history
            WHERE proof = '$proof'
    ";

$result = mysqli_query($connect, $sql);

// Jika ada, redirect
if (mysqli_num_rows($result) > 0) {
    redirect("Kode Bukti Sudah Terdaftar!", "F");
}

// Print debug 
// echo $transaction_type . "<br>" . $proof . "<br>" . $location . "<br>" . $item_code . "<br>" . $item_name . "<br>" . $transaction_time . "<br>" . $quantity . "<br>";

// Transaction type = TAMBAH
// proof = TAMBAH00
// location = 1
// Item_code = PS-PLD500
// Nama_Item = CINEMAX LED

// Diasumsukan setiap produk memiliki kode dan nama produk yang unik.

// Tangkap user_id untuk pendataan setiap transaksi
$user_id = $_SESSION['id'];


// Redirect user apabila terdapat kesalahan pada input / notifikasi apapun
function redirect($message, $parameter)
{
    global $transaction_type, $proof, $location, $item_code, $item_name, $transaction_time, $quantity;

    $_SESSION['isSuccess'] = "$parameter";
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

if ($transaction_type == "TAMBAH") {
    // Cek apakah brang yang akan di input sudah ada sebelumnya atau belum
    $sql = "SELECT * 
                FROM items WHERE item_code = '$item_code' 
                           AND item_name = '$item_name'
                LIMIT 1;
        ";
    $result = mysqli_query($connect, $sql);
    $mysqli_assoc = mysqli_fetch_assoc($result);
    $item_id = $mysqli_assoc['id'];

    $result = mysqli_query($connect, $sql);
    if (!$result) {
        echo "Query Gagal";
    }

    if (mysqli_num_rows($result) > 0) { // Barang Terdaftar
        // Cek tanggal terakhir produk yang sama pernah ditambah untuk lokasi tersebut
        $sql = "SELECT MAX(date_input) AS tanggal
                    FROM item_stocks 
                    WHERE 
                        FK_locationcode = '$location' AND
                        FK_itemcode = '$item_id'
            ";

        $result = mysqli_query($connect, $sql);
        $date_db = mysqli_fetch_assoc($result);
        $transaction_time_db = $date_db['tanggal'];
        $date_db = date('Y-m-d', strtotime($transaction_time_db));
        $date_input = date('Y-m-d', strtotime($transaction_time));
        if ($date_input > $date_db) {
            // Jika date input lebih besar dari date input data yang pernah dilakukan untuk lokasi tersebut 
            // dengan data produk yang sama, maka dapat input

            // Query untuk mendapatkan id inputan
            $sql = "INSERT INTO item_stocks(FK_locationcode, FK_itemcode, balance, date_input)
                        VALUES('$location', '$item_id', '$quantity', '$transaction_time')
                ";
            $result = mysqli_query($connect, $sql);
            if (!$result) {
                echo "Query Gagal2";
            }

            // Insert ke Transaction History
            $sql = "INSERT INTO transaction_history(proof, FK_locationcode, transaction_time, FK_itemcode, date_input,  quantity, prog, FK_user)
                VALUES('$proof', '$location', '$transaction_time', '$item_id', '$transaction_time', '$quantity', '$transaction_type', '$user_id')
                ";

            $result = mysqli_query($connect, $sql);
            if (!$result) {
                echo "Query Gagal3";
            }
            redirect("Sukses Menambah Stok Produk!", "T");
        } else {
            redirect("Format tanggal tidak sesuai! produk yang akan ditambahkan harus memperhatikan tanggal terakhir produk tersebut ditambahkan (tanggal harus lebih besar dari $date_db)", "F");
        }
    } else {
        $sql = "SELECT * 
                    FROM items WHERE item_code = '$item_code' 
            ";
        $result = mysqli_query($connect, $sql);
        $flag = true;
        if (mysqli_num_rows($result) > 0) {
            // Fail apabila salah satu dari nama produk ataupun id produk ada yang sama
            redirect("Format Tidak Valid! Pastikan Penambahan Kode Produk Baru harus memiliki Kode Barang Unik! (Kode '$item_code' sudah terdaftar)", "F");
        } else {
            // Karena unique, produk dapat masuk tanpa perlu melewati validasi
            // Query Insert ke tabel items
            $_SESSION['new_item_code'] = $item_code;
            $_SESSION['new_item_name'] = $item_name;
            $_SESSION['new_proof'] = $proof;
            $_SESSION['new_location'] = $location;
            $_SESSION['new_transaction_time'] = $transaction_time;
            $_SESSION['new_transaction_type'] = $transaction_type;
            $_SESSION['new_quantity'] = $quantity;

            header("Location: confirmation.php");
            die();
        }
    }
} else if ($transaction_type == "KURANG") { // Melakukan pengurangan jumlah produk yang sudah ada dan memiliki stok yang tersisa
    $sql = "SELECT * 
                    FROM items WHERE item_code = '$item_code' 
                               AND item_name = '$item_name'
                    LIMIT 1;
            ";
    $result = mysqli_query($connect, $sql);
    $mysqli_assoc = mysqli_fetch_assoc($result);
    $item_id = $mysqli_assoc['id'];

    $sql = "SELECT SUM(balance) AS total_item
                FROM item_stocks 
                WHERE FK_locationcode = '$location' AND
                      FK_itemcode = '$item_id'
        ";

    $result_find_delete = mysqli_query($connect, $sql);
    $fetch_array = mysqli_fetch_assoc($result_find_delete);
    if ($fetch_array['total_item'] && $fetch_array['total_item'] >= $quantity) {
        // Cek tanggal terakhir produk yang sama pernah ditambah untuk lokasi tersebut
        $sql = "SELECT MAX(date_input) AS tanggal
                    FROM item_stocks 
                    WHERE 
                        FK_locationcode = '$location' AND
                        FK_itemcode = '$item_id'
            ";

        $result = mysqli_query($connect, $sql);
        $date_db = mysqli_fetch_assoc($result);
        $transaction_time_db = $date_db['tanggal'];
        $date_db = date('Y-m-d', strtotime($transaction_time_db));
        $date_input = date('Y-m-d', strtotime($transaction_time));
        if ($date_input > $date_db) {
            // Tangkap keseluruhan data stok produk yang diminta dan juga lokasi yang sesuai.
            // Barang akan dikurangi secara FIFO (First in First Out), oleh karenanya data stok produk
            // Akan didapatkan secara ascending (menaik) dan stok akan dikurangi dari stock yang paling
            // Pertama kali masuk
            $sql = "SELECT *, ist.id AS idx
                    FROM item_stocks ist
                        JOIN items i ON ist.FK_itemcode = i.id
                        WHERE
                            FK_locationcode = '$location' AND
                            FK_itemcode = '$item_id' AND
                            item_name = '$item_name' AND
                            balance > '0'
                    ORDER BY date_input ASC
            ";

            $result = mysqli_query($connect, $sql);
            $quantity_temp = 0;
            $quantity_temp_2 = 0;
            // echo mysqli_num_rows($result);
            // die();
            while ($data = mysqli_fetch_array($result)) {
                $quantity_db = $data['balance'];
                $stock_id = $data['idx'];

                // Debug
                // echo "Quantity: " . "$quantity" . "<br>";
                // echo "Quantity DB: " . "$quantity_db" . "<br>";
                // echo "Stock_id" . "$stock_id" . "<br>";
                // die();

                $tgl_masuk = date('Y-m-d H:i:s', strtotime($data['date_input']));
                //  Apabila stok yang diminta > dari stok kuantitas pada database
                if ($quantity > $quantity_db) {
                    $quantity_temp = 0;
                    $quantity_temp_2 = $quantity_db;
                    $quantity = $quantity - $quantity_db;
                } else if ($quantity <= $quantity_db) { // Jika kuantitas yang diminta lebih kecil sama dengan stok pada db
                    $quantity_temp = $quantity_db - $quantity;
                    $quantity_temp_2 = $quantity;
                    $quantity = 0;
                }

                // Query update table item_stocks
                $sql = "UPDATE item_stocks
                            SET balance = '$quantity_temp'
                        WHERE id = '$stock_id'
                ";

                // echo "Stock_id: " . "$stock_id" . "<br>";
                // echo "Quantity: " . "$quantity" . "<br>";
                // echo "Quantity DB: " . "$quantity_db" . "<br>";
                // echo "Quantity sisa stok: " . "$quantity_temp" . "<br>";
                // echo "Quantity transaksi: " . "$quantity_temp_2" . "<br>";

                $result2 = mysqli_query($connect, $sql);
                if (!$result2) {
                    echo "Query Gagal";
                }

                // Insert ke Transaction History
                $sql = "INSERT INTO transaction_history(proof, FK_locationcode, transaction_time, FK_itemcode, date_input,   quantity, prog, FK_user)
                VALUES('$proof', '$location', '$transaction_time', '$item_id', '$tgl_masuk', '$quantity_temp_2', '$transaction_type', '$user_id')
                ";

                $result2 = mysqli_query($connect, $sql);
                if (!$result2) {
                    echo "Query Gagal3";
                }

                if ($quantity == 0) {
                    echo "here";
                    break;
                }
            }

            redirect("Produk Berhasil Dikurangi!", "T");
        } else {
            redirect("Format tanggal tidak sesuai! produk yang akan dikurangkan harus memperhatikan tanggal terakhir produk tersebut ditambahkan (tanggal harus lebih besar dari $date_db)", "F");
        }
    } else {
        redirect("Barang yang diminta tidak tersedia atau stok tidak mencukupi. Sisa stok saat ini: " . $fetch_array['total_item'] . " " . 'Total Quantity Diminta: ' . $quantity, "F");
    }
}
