<?php
    session_start();
    $item_code = trim(strtoupper(addslashes($_POST['item_code'])));
    $item_name = trim(strtoupper(addslashes($_POST['item_name'])));
    require_once 'koneksi.php';

    $sql = "SELECT * FROM items WHERE item_code = '$item_code' ";
    $execute_query = mysqli_query($connect, $sql);

    function redirect($message, $parameter)
    {
        global $item_name, $item_code;
        $_SESSION['isInvalid'] = $message;
        $_SESSION['isTrue'] = $parameter;
        $_SESSION['item_code'] = $item_code;
        $_SESSION['item_name'] = $item_name;
        
        header("Location: add_product.php");
    }

    if(mysqli_num_rows($execute_query) > 0)
    {
        redirect("Kode Barang sudah Terdaftar!", "F");
    }else{
        $_SESSION['item_code'] = $item_code;
        $_SESSION['item_name'] = $item_name;
        header("Location: confirmation2.php");
    }
?>