<?php
$id = $_REQUEST['id'];
$sql = "SELECT * 
        FROM karyawan 
        WHERE id = '$id'";
        
$query_execute = mysqli_query($connect, $sql);
$result = mysqli_fetch_assoc($query_execute);
$nik = $result['NIK'];
$tanggal_masuk = $result['TglMasuk'];
$nama = $result['Nama'];
$alamat = $result['Alamat'];
$kota = $result['Kota'];
$gelar = $result['Gelar'];
$gender = $result['Gender'];
$tanggal_keluar = $result['TglKeluar'];
?>