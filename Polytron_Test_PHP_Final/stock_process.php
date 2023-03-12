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

$transaction_time = addslashes($transaction_time);
$proof = addslashes($proof);
$location = addslashes($location);
$item_code = addslashes($item_code);
$item_name = addslashes($item_name);
$transaction_time = addslashes($transaction_time);
$quantity = addslashes($quantity);

// Cek apakah kode bukti sudah ada atau belum (harus unique)
$sql = "SELECT * FROM transaction_history
            WHERE bukti = '$proof'
    ";

$result = mysqli_query($connect, $sql);

// Jika ada, redirect
if (mysqli_num_rows($result)) {
    $_SESSION['isInvalid'] = "Kode Bukti Sudah Terdaftar!";
    header('Location: dashboard.php');
}

// Print debug 
// echo $transaction_type . "<br>" . $proof . "<br>". $location ."<br>".$item_code ."<br>".$item_name ."<br>".$transaction_time."<br>".$quantity . "<br>";

// Diasumsukan setiap produk memiliki kode dan nama produk yang unik.

// Tangkap user_id untuk pendataan setiap transaksi
$user_id = $_SESSION['id'];

if ($transaction_type == "T") {
    // Cek apakah brang yang akan di input sudah ada sebelumnya atau belum
    $sql = "SELECT * 
                FROM items WHERE item_code = '$item_code' 
                           AND item_name = '$item_name'
        ";

    $result = mysqli_query($connect, $sql);
    if (!$result) {
        echo "Query Gagal";
    }

    if (mysqli_num_rows($result) > 0) { // Barang Terdaftar
        // Cek tanggal terakhir produk yang sama pernah ditambah untuk lokasi tersebut
        $sql = "SELECT MAX(tgl_masuk) AS tanggal
                    FROM item_stocks 
                    WHERE 
                        FK_locationcode = '$location' AND
                        FK_itemcode = '$item_code'
            ";

        $result = mysqli_query($connect, $sql);
        $date_db = mysqli_fetch_assoc($result);
        $transaction_time_db = $date_db['tanggal'];
        $date_db = date('Y-m-d', strtotime($transaction_time_db));
        $date_input = date('Y-m-d', strtotime($transaction_time));
        if ($date_input > $date_db) {
            // Jika date input lebih besar dari date input data yang pernah dilakukan untuk lokasi tersebut 
            // dengan data produk yang sama, maka dapat input
            $sql = "INSERT INTO item_stocks(FK_locationcode, FK_itemcode, saldo, tgl_masuk)
                        VALUES('$location', '$item_code', '$quantity', '$transaction_time')
                ";
            $result = mysqli_query($connect, $sql);
            if (!$result) {
                echo "Query Gagal2";
            }

            // Insert ke Transaction History
            $sql = "INSERT INTO transaction_history(bukti, FK_locationcode, transaction_time, FK_itemcode, tgl_masuk,   quantity, prog, FK_user)
                VALUES('$proof', '$location', '$transaction_time', '$item_code', '$transaction_time', '$quantity', '$transaction_type', '$user_id')
                ";

            $result = mysqli_query($connect, $sql);
            if (!$result) {
                echo "Query Gagal3";
            }
            $_SESSION['isInvalid'] = "Sukses Menambah Stok!";
            header('Location: dashboard.php');
        } else {
            $_SESSION['isInvalid'] = "Format tanggal tidak sesuai! produk yang akan ditambahkan harus memperhatikan tanggal terakhir produk tersebut ditambahkan (tanggal harus lebih besar dari $date_db)";
            header('Location: dashboard.php');
        }
    } else {
        $sql = "SELECT * 
                    FROM items WHERE item_code = '$item_code' 
                               OR item_name = '$item_name'
            ";
        $result = mysqli_query($connect, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Fail apabila salah satu dari nama produk ataupun id produk ada yang sama
            $_SESSION['isInvalid'] = "Format Tidak Valid! Pastikan Penambahan Produk Baru Harus Unik Baik Kode dan Nama Produk!";
            header('Location: dashboard.php');
        } else {
            // Karena unique, produk dapat masuk tanpa perlu melewati validasi
            // Query Insert ke tabel items
            $sql = "INSERT INTO items(item_code, item_name)
                        VALUES('$item_code', '$item_name')
                ";
            $result = mysqli_query($connect, $sql);
            if (!$result) {
                echo "Query Gagal1";
            }

            // Query insert ke tabel item stocks
            $sql = "INSERT INTO item_stocks(FK_locationcode, FK_itemcode, saldo, tgl_masuk)
                        VALUES('$location', '$item_code', '$quantity', '$transaction_time')
                ";
            $result = mysqli_query($connect, $sql);
            if (!$result) {
                echo "Query Gagal2";
            }

            // Insert ke Transaction History
            $sql = "INSERT INTO transaction_history(bukti, FK_locationcode, transaction_time, FK_itemcode, tgl_masuk,   quantity, prog, FK_user)
                VALUES('$proof', '$location', '$transaction_time', '$item_code', '$transaction_time', '$quantity', '$transaction_type', '$user_id')
                ";

            $result = mysqli_query($connect, $sql);
            if (!$result) {
                echo "Query Gagal3";
            }
            $_SESSION['isInvalid'] = "Produk Baru Berhasil di Input!";
            header('Location: dashboard.php');
        }
    }
} else if ($transaction_type == "K") { // Melakukan pengurangan jumlah produk yang sudah ada dan memiliki stok yang tersisa
    $sql = "SELECT SUM(saldo) AS total_item
                FROM item_stocks 
                WHERE FK_locationcode = '$location' AND
                      FK_itemcode = '$item_code'
        ";

    $result_find_delete = mysqli_query($connect, $sql);
    $fetch_array = mysqli_fetch_assoc($result_find_delete);
    if ($fetch_array['total_item'] && $fetch_array['total_item'] >= $quantity) {
        // Cek tanggal terakhir produk yang sama pernah ditambah untuk lokasi tersebut
        $sql = "SELECT MAX(tgl_masuk) AS tanggal
                    FROM item_stocks 
                    WHERE 
                        FK_locationcode = '$location' AND
                        FK_itemcode = '$item_code'
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
            $sql = "SELECT *
                    FROM item_stocks ist
                        JOIN items i ON ist.FK_itemcode = i.item_code
                        WHERE
                            FK_locationcode = '$location' AND
                            FK_itemcode = '$item_code' AND
                            item_name = '$item_name'
                    ORDER BY tgl_masuk ASC
            ";

            $result = mysqli_query($connect, $sql);
            while($data = mysqli_fetch_array($result)){
                $quantity = $data['saldo'];
                
            }


        } else {
            $_SESSION['isInvalid'] = "Format tanggal tidak sesuai! produk yang akan dikurangkan harus memperhatikan tanggal terakhir produk tersebut ditambahkan (tanggal harus lebih besar dari $date_db)";
            header('Location: dashboard.php');
        }
    } else {
        $_SESSION['isInvalid'] = "Barang yang diminta tidak tersedia atau stok tidak mencukupi. Sisa stok saat ini: " . $fetch_array['total_item'] . " " . 'Total Quantity Diminta: ' . $quantity;
        header('Location: dashboard.php');
    }
}
