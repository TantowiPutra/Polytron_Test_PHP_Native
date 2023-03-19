<?php
    session_start();
    require_once 'koneksi.php';

    $kode_lokasi = trim(addslashes(strtoupper($_POST['lokasi'])));
    $sql = "SELECT * FROM locations
            WHERE location_code = '$kode_lokasi'
    ";

    function redirect($message, $parameter)
    {
        global $kode_lokasi;
        $_SESSION['location_code'] = $kode_lokasi;
        $_SESSION['isInvalid'] = $message;
        $_SESSION['isTrue'] = $parameter;

        header('Location: add_location.php');
    }

    session_start();
    $result = mysqli_query($connect, $sql);
    if(mysqli_num_rows($result) > 0){
        redirect("Kode lokasi sudah terdaftar!", "F");
    }else{
        $sql = "INSERT INTO locations(location_code) VALUES('$kode_lokasi')";
        mysqli_query($connect, $sql);
    
        redirect("Kode lokasi berhasil didaftarkan!", "T");
    }
?>