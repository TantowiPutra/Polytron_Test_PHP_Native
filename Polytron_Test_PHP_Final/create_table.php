<?php
// Tes Commit

//  Drop All Table
$connect->query('SET foreign_key_checks = 0');
if ($result = $connect->query("SHOW TABLES")) {
    while ($row = $result->fetch_array(MYSQLI_NUM)) {
        $connect->query('DROP TABLE IF EXISTS ' . $row[0]);
    }
}
$connect->query('SET foreign_key_checks = 1');

// Create Table User
$sql = "CREATE TABLE users (
        id BIGINT(50) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(50) NOT NULL,
        address VARCHAR(50) NOT NULL,
        gender VARCHAR(2) NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP ,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

$result = mysqli_query($connect, $sql);
if (!$result) {
    echo "Failed to run query 1";
}

$sql = "INSERT INTO users (username, password, address, gender)
        VALUES('Tantowi', 'towi123', 'Pondok Lestari', 'L'),
        ('Imelda', 'imelda123', 'Pondok Lestari', 'P'),
        ('Kevin', 'kevin123', 'Pondok Lestari', 'L'),
        ('Terrence', 'terrence123', 'Pondok Lestari', 'P')";

$result = mysqli_query($connect, $sql);
if (!$result) {
    echo "Failed to run query 2";
}

// Create Table Location
$sql = "CREATE TABLE locations(
        id BIGINT(50) UNSIGNED AUTO_INCREMENT UNIQUE PRIMARY KEY,
        location_code VARCHAR(50) NOT NULL UNIQUE,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP ,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

$result = mysqli_query($connect, $sql);
if (!$result) {
    echo "Failed to run query 3";
}

$sql = "INSERT INTO locations(location_code) VALUES ('GBJ01'), ('GBJ02'), ('GBJ03')";
$result = mysqli_query($connect, $sql);
if (!$result) {
    echo "Failed to run query 4";
}

// Create Table Items
$sql = "CREATE TABLE items(
        id BIGINT(50) UNSIGNED AUTO_INCREMENT UNIQUE PRIMARY KEY,
        item_code VARCHAR(50) UNIQUE,
        item_name VARCHAR(50),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP ,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )
";

$result = mysqli_query($connect, $sql);
if (!$result) {
    echo "Failed to run query 5";
}

$sql = "INSERT INTO items(item_code, item_name) 
        VALUES('PS-PLD500', 'CINEMAX LED'), 
              ('PS-PLD600', 'ELECTRIC MOTOR'), 
              ('PS-PLD700', 'PENTAB EX');";

$result = mysqli_query($connect, $sql);
if (!$result) {
    echo "Failed to run query 6";
}

// Create Table Item Stock
$sql = "CREATE TABLE item_stocks (
        id BIGINT(50) UNSIGNED AUTO_INCREMENT UNIQUE PRIMARY KEY, 
        FK_locationcode BIGINT(50) UNSIGNED NOT NULL,
        FK_itemcode BIGINT(50) UNSIGNED NOT NULL,
        balance BIGINT(50) NOT NULL,
        date_input DATETIME NOT NULL,
        FOREIGN KEY(`FK_itemcode`) REFERENCES items(`id`),
        FOREIGN KEY(`FK_locationcode`) REFERENCES locations(`id`),
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP ,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

$result = mysqli_query($connect, $sql);
if (!$result) {
    echo "Failed to run query 7";
}

$sql = "INSERT INTO item_stocks(FK_locationcode, FK_itemcode, date_input, balance) 
        VALUES 
        ('1', '1', '2018-05-16 10:00:00', 30),
        ('1', '1', '2018-05-17 10:00:00', 60),
        ('1', '1', '2018-05-18 10:00:00', 90),
        ('1', '1', '2018-05-19 10:00:00', 120),
        ('2', '2', '2018-05-16 10:00:00', 30),
        ('3', '3', '2018-05-16 10:00:00', 30)
";

$result = mysqli_query($connect, $sql);
if (!$result) {
    echo "Failed to run query 8";
}

// Create Table Transaction History
$sql = "CREATE TABLE transaction_history(
        id BIGINT(50) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        proof VARCHAR(50) NOT NULL,
        FK_locationcode BIGINT(50) UNSIGNED NOT NULL,
        transaction_time DATETIME NOT NULL,
        FK_itemcode BIGINT(50) UNSIGNED NOT NULL,
        date_input DATE NOT NULL,
        quantity BIGINT(50) NOT NULL,
        prog VARCHAR(25) NOT NULL,
        FK_user BIGINT(50) UNSIGNED NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY(`FK_itemcode`) REFERENCES items(`id`),
        FOREIGN KEY(`FK_locationcode`) REFERENCES locations(`id`),
        FOREIGN KEY(`FK_user`) REFERENCES users(`id`)
    )
";

$result = mysqli_query($connect, $sql);
if (!$result) {
    echo "Failed to run query 9";
}

$sql = "INSERT INTO transaction_history(proof, transaction_time, FK_locationcode, FK_itemcode, date_input, quantity, prog, FK_user) VALUES
        ('TAMBAH01','2018-05-16 10:00:00', '1', '1', '2018-05-16', 60, 'TAMBAH', '1'),
        ('KURANG02','2019-05-16 10:00:00', '1', '1', '2018-05-16', 30, 'KURANG', '2'),
        ('TAMBAH03','2018-05-16 10:00:00', '2', '2', '2018-05-16', 60, 'TAMBAH', '3'),
        ('KURANG04','2019-05-09 10:00:00', '2', '2', '2018-05-16', 30, 'KURANG', '4'),
        ('TAMBAH05','2018-05-16 10:00:00', '3', '3', '2018-05-16', 60, 'TAMBAH', '1'),
        ('KURANG06','2019-05-03 10:00:00', '3', '3', '2018-05-16', 30, 'KURANG', '2')
        ";

$result = mysqli_query($connect, $sql);
if (!$result) {
    echo "Failed to run query 10";
}
