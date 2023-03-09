<?php
    if(isset($_POST['tipe_transaksi']) || 
       isset($_POST['bukti']) || 
       isset($_POST['lokasi']) || 
       isset($_POST['kodebarang']) || 
       isset($_POST['namabarang']) || 
       isset($_POST['tanggal_transaksi']) || 
       isset($_POST['quantity']))
    {
       $tipe_transaksi = $_POST['tipe_transaksi'];
       $bukti = $_POST['bukti'];
       $lokasi = $_POST['lokasi'];
       $kode_barang = $_POST['kodebarang'];
       $nama_barang = $_POST['namabarang'];
       $tanggal_transaksi = $_POST['tanggal_transaksi'];
       $quantity = $_POST['quantity'];
    }else{
        header("Location: dashboard.php");
    }
?>