<?php
$nik = "";
$tanggal_masuk = "";
$nama = "";
$alamat = "";
$kota = "";
$gelar = "";
$tanggal_keluar = "";
$gender = "";
$isTrue = true;

if (isset($_POST['nik'])) {
    $nik = $_POST['nik'];
    if (!ctype_alnum($nik) || strlen($nik) != 12) {
        $error_message_nik = "NIK HARUS ALPHA NUMERIC DENGAN PANJANG 12 KARAKTER!";
        $isTrue = false;
    }
}

if (isset($_POST['tglMasuk'])) {
    $tanggal_masuk = $_POST['tglMasuk'];
    if($tanggal_masuk == null){
        $error_message_tanggal = "TANGGAL TIDAK BOLEH KOSONG!";
        $isTrue = false;
    }
}

if (isset($_POST['nama'])) {
    $nama = $_POST['nama'];
    if (strlen($nama) < 3 || strlen($nama) > 25) {
        $error_message_nama = "NAMA HARUS DIANTARA 3-25 KARAKTER!";
        $isTrue = false;
    }
}

if (isset($_POST['alamat'])) {
    $alamat = $_POST['alamat'];
    $alamat_lowercase = strtolower($alamat);
    echo strpos($alamat_lowercase, "jalan");
    echo strpos($alamat_lowercase, "jl");
    if(!strstr($alamat_lowercase, "jalan") && !strstr($alamat_lowercase, "jl")){
        $error_message_alamat = "ALAMAT HARUS MENGANDUNG KATA 'jalan' ATAU 'jl' !";
        $isTrue = false;
    }
}

if (isset($_POST['kota'])) {
    $kota = $_POST['kota'];
    if(strlen($kota) < 3 || strlen($kota) > 25){
        $error_message_kota = "KOTA HARUS TERDIRI SETIDAKNYA DARI 3 BUAH KARAKTER!";
        $isTrue = false;
    }
}

if (isset($_POST['gelar'])) {
    $gelar = $_POST['gelar'];
    $gelar_lowercase = strtolower($gelar);
    if((strcmp($gelar_lowercase, 'sma') != 0 
    && strcmp($gelar_lowercase, 'smk') != 0 
    && strcmp($gelar_lowercase, 's1') != 0
    && strcmp($gelar_lowercase, 'd3') != 0
    && strcmp($gelar_lowercase, 'd4') != 0
    && strcmp($gelar_lowercase, 's2') != 0
    && strcmp($gelar_lowercase, 's3') !=0) || strlen($gelar_lowercase) < 1){
            $error_message_gelar = "GELAR HANYA BOLEH DIPILIH: SMK, S1, D3, D4, S2, dan S3 DAN TIDAK KOSONG!";
            $isTrue = false;
        }
}

if (isset($_POST['gender'])) {
    $gender = $_POST['gender'];
    if(strlen($gender) < 1){
        $error_message_gender = "ANDA HARUS MEMILIH GENDER!";
        $isTrue = false;
    }
}

// Eksekusi Insert Data
if($isTrue == true){

    $nik = strtoupper($nik);
    $tanggal_masuk = strtoupper($tanggal_masuk);
    $nama = strtoupper($nama);
    $alamat = strtoupper($alamat);
    $kota = strtoupper($kota);
    $gelar = strtoupper($gelar);

    $sql = "INSERT INTO karyawan (NIK, TglMasuk, Nama, Alamat, Kota, Gelar, Gender, TglKeluar)VALUES
    ('$nik', '$tanggal_masuk', '$nama', '$alamat', '$kota', '$gelar', '$gender', null);";

    $result = mysqli_query($connect, $sql);

    // Reset Fields
    $nik = "";
    $tanggal_masuk = "";
    $nama = "";
    $alamat = "";
    $kota = "";
    $gelar = "";
    $gender = "";
}

?>