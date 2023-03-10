<?php
    session_start();
    if(!isset($_SESSION['isLogin'])){
        header('Location: login.php');
    }

    require_once 'koneksi.php';

    $transaction_type = $_POST['tipe_transaksi'];
    $proof = $_POST['bukti'];
    $location = $_POST['lokasi'];
    $item_code = $_POST['kodebarang'];
    $item_name = $_POST['namabarang'];
    $transaction_time = $_POST['tanggal_transaksi'];
    $quantity = $_POST['quantity'];

    // Cek apakah kode bukti sudah ada atau belum (harus unique)
    $sql = "SELECT * FROM transaction_history
            WHERE bukti = '$proof'
    ";

    $result = mysqli_query($connect, $sql);

    // Jika ada, redirect
    if(mysqli_num_rows($result)){
        $_SESSION['isInvalid'] = "Kode Bukti Sudah Terdaftar!";
        header('Location: dashboard.php');
    }

    // Print debug 
    // echo $transaction_type . "<br>" . $proof . "<br>". $location ."<br>".$item_code ."<br>".$item_name ."<br>".$transaction_time."<br>".$quantity . "<br>";

    // Diasumsukan setiap produk memiliki kode dan nama produk yang unik.

    // Tangkap user_id 
    $user_id = $_SESSION['id'];

    if($transaction_type == "T"){
        
    }else if($transaction_type == "K"){ // Melakukan pengurangan jumlah produk yang sudah ada dan memiliki stok yang tersisa
    
    }
?>