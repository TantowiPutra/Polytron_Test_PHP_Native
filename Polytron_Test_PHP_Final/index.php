<?php
    // Deklarasi sql sebagai variabel global
    $sql = "";
    
    session_start();
    if(isset($_SESSION['isLogin'])){
        header('Location: dashboard.php');
    }

    require_once 'koneksi.php';
    require_once 'create_table.php';
    header('Location: login.php');
?>