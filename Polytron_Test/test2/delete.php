<?php
$user_id = $_REQUEST['id'];
$tanggal_keluar = $_REQUEST['tgl'];
echo "$tanggal_keluar";

if($tanggal_keluar == null){
    $sql = "DELETE FROM karyawan WHERE id = '$user_id'";
    $query_execute = mysqli_query($connect, $sql);
    if (mysqli_query($connect, $sql)) {
    } else {
    echo "Error delete data: " . mysqli_error($connect);
    }
}
?>