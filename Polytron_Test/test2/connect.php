<?php
$connect = mysqli_connect($host, $user, $password, $database);
if ($connect) {
    // echo "Succesfully Connected to Database";
} else {
    throw new exception("Failed to Connect Database: " . mysqli_connect_error());
}
?>