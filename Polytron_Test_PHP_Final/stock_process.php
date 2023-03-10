<?php
    session_start();
    if(!isset($_SESSION['isLogin'])){
        header('Location: login.php');
    }
    $transaction_type = $_POST['tipe_transaksi'];
    $proof = $_POST['bukti'];
    $location = $_POST['lokasi'];
    $item_code = $_POST['kodebarang'];
    $item_name = $_POST['namabarang'];
    $transaction_time = $_POST['tanggal_transaksi'];
    $quantity = $_POST['quantity'];

    // Print debug 
    // echo $transaction_type . "<br>" . $proof . "<br>". $location ."<br>".$item_code ."<br>".$item_name ."<br>".$transaction_time."<br>".$quantity . "<br>";

    // Diasumsukan setiap produk memiliki kode dan nama produk yang unik.
    require_once 'koneksi.php';

    // Tangkap user_id 
    $user_id = $_SESSION['id'];

    $sql = "SELECT * 
                FROM items 
                WHERE item_code = '$item_code' AND item_name = '$item_name'";

    $result = mysqli_query($connect, $sql);
    if(!$result){
        echo "Failed to run query1";
    }

    if($transaction_type == "T"){
        //  Jika akan melakukan penambahan stok produk yang sudah ada/produk baru

        //  Jika terdapat == 1 hasil dari pencarian produk sesuai dengan input, maka akan langsung ditambahkan ke tabel stok dan transaction history (tidak menambah produk baru);
        if(mysqli_num_rows($result) == 1){
            echo "Produk sudah ada";
        }else{
            // Jika produk yang spesifik tidak tersedia, cek validitas nama dan kode produk baru yang akan diinput karena harus unique. Jika tidak unique, tampilkan error message.
            $sql = "SELECT * 
                    FROM items
                    WHERE item_code = '$item_code' || item_name = '$item_name'
                 ";

            $result = mysqli_query($connect, $sql);
            
            if(mysqli_num_rows($result) > 0){
                echo "Input tidak valid";
            }else{
                // Tambah Produk ke Tabel Produk
                $sql = "INSERT INTO items(item_code, item_name)
                        VALUES('$item_code', '$item_name')
                ";

                $result = mysqli_query($connect, $sql);
                if(!$result){
                    echo "Failed to run query2";
                }

                // Tambah history penambahan ke transaction_history
                $sql = "INSERT INTO transaction_history
                                    (bukti, FK_locationcode, transaction_time, FK_itemcode, tgl_masuk, quantity, prog, FK_user)
                                VALUES
                                    ('$proof', '$location', '$transaction_time', '$item_code', '$transaction_time', '$quantity', '$transaction_type', '$user_id');
                        ";
                $result = mysqli_query($connect, $sql);
                if(!$result){
                    echo "Failed to run query3";
                }

                // Tambah stock produk ke tabel stock_product
                $date = date('Y-m-d', strtotime($transaction_time)); // Ambil hanya date dari waktu yang di input oleh user
                $sql = "INSERT INTO item_stocks(FK_locationcode, FK_itemcode, saldo, tgl_masuk)
                        VALUES('$location', '$item_code', '$quantity', '$date')
                ";
                $result = mysqli_query($connect, $sql);
                if(!$result){
                    echo "Failed to run query3";
                }

            }

        } 
    }else if($transaction_type == "K"){ // Melakukan pengurangan jumlah produk yang sudah ada dan memiliki stok yang tersisa
    
    }
?>