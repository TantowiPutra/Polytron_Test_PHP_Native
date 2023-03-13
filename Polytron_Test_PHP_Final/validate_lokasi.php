<?php
    require_once 'koneksi.php';

    $kode_lokasi = strtoupper($_POST['lokasi']);
    $sql = "SELECT * FROM locations
            WHERE location_code = '$kode_lokasi'
    ";

    session_start();
    $result = mysqli_query($connect, $sql);
    if(mysqli_num_rows($result) > 0){
        $_SESSION['isInvalid'] = "Kode lokasi sudah terdaftar!";
        header('Location: add_location.php');
    }else{
        $sql = "INSERT INTO locations(location_code) VALUES('$kode_lokasi')";
        mysqli_query($connect, $sql);
    
        $_SESSION['isInvalid'] = "Kode lokasi berhasil didaftarkan!";
        header('Location: add_location.php');
    }
?>