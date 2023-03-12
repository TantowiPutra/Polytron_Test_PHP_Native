<?php
// Tes Commit

//  Drop All Table
$connect->query('SET foreign_key_checks = 0');
if ($result = $connect->query("SHOW TABLES"))
{
    while($row = $result->fetch_array(MYSQLI_NUM))
    {
        $connect->query('DROP TABLE IF EXISTS '.$row[0]);
    }
}
$connect->query('SET foreign_key_checks = 1');

// Create Table User
$sql = "CREATE TABLE users (
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(50) NOT NULL,
        address VARCHAR(50) NOT NULL,
        gender VARCHAR(2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

$result = mysqli_query($connect, $sql);
if(!$result){
    echo "Failed to run query";
}

$sql = "INSERT INTO users (username, password, address, gender)
        VALUES('Tantowi', 'towi123', 'Pondok Lestari', 'L'),
        ('Imelda', 'imelda123', 'Pondok Lestari', 'P'),
        ('Kevin', 'kevin123', 'Pondok Lestari', 'L'),
        ('Terrence', 'terrence123', 'Pondok Lestari', 'P')";

$result = mysqli_query($connect, $sql);
if(!$result){
    echo "Failed to run query";
}

// Create Table Location
$sql = "CREATE TABLE locations(
        id INT(11) AUTO_INCREMENT UNIQUE,
        location_code VARCHAR(50) NOT NULL PRIMARY KEY,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

$result = mysqli_query($connect, $sql);
if(!$result){
    echo "Failed to run query";
}

$sql = "INSERT INTO locations(location_code) VALUES ('GBJ01'), ('GBJ02'), ('GBJ03')";
$result = mysqli_query($connect, $sql);
if(!$result){
    echo "Failed to run query";
}

// Create Table Items
$sql = "CREATE TABLE items(
        id INT(11) AUTO_INCREMENT UNIQUE,
        item_code VARCHAR(50) PRIMARY KEY,
        item_name VARCHAR(50) UNIQUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )
";

$result = mysqli_query($connect, $sql);
if(!$result){
    echo "Failed to run query";
}

$sql = "INSERT INTO items(item_code, item_name) 
        VALUES('PS-PLD24T500', 'CINEMAX LED'), 
              ('PS-PLD24T600', 'ELECTRIC MOTOR'), 
              ('PS-PLD24T700', 'PENTAB EX');";

$result = mysqli_query($connect, $sql);
if(!$result){
    echo "Failed to run query";
}

// Create Table Item Stock
$sql = "CREATE TABLE item_stocks (
        id INT(11) AUTO_INCREMENT UNIQUE, 
        FK_locationcode VARCHAR(50) NOT NULL,
        FK_itemcode VARCHAR(50) NOT NULL,
        saldo BIGINT(50) NOT NULL,
        tgl_masuk DATETIME NOT NULL,
        FOREIGN KEY(`FK_itemcode`) REFERENCES items(`item_code`),
        FOREIGN KEY(`FK_locationcode`) REFERENCES locations(`location_code`),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

$result = mysqli_query($connect, $sql);
if(!$result){
    echo "Failed to run query";
}

$sql = "INSERT INTO item_stocks(FK_locationcode, FK_itemcode, tgl_masuk, saldo) 
        VALUES 
        ('GBJ01', 'PS-PLD24T500', '2018-05-16 10:00:00', 30),
        ('GBJ01', 'PS-PLD24T500', '2018-05-17 10:00:00', 60),
        ('GBJ01', 'PS-PLD24T500', '2018-05-18 10:00:00', 90),
        ('GBJ01', 'PS-PLD24T500', '2018-05-19 10:00:00', 120),
        ('GBJ02', 'PS-PLD24T600', '2018-05-16 10:00:00', 30),
        ('GBJ03', 'PS-PLD24T700', '2018-05-16 10:00:00', 30)
";

$result = mysqli_query($connect, $sql);
if(!$result){
    echo "Failed to run query";
}

// Create Table Transaction History
$sql = "CREATE TABLE transaction_history(
        id INT(11) AUTO_INCREMENT PRIMARY KEY UNIQUE,
        bukti VARCHAR(50) NOT NULL UNIQUE,
        FK_locationcode VARCHAR(50) NOT NULL,
        transaction_time DATETIME NOT NULL,
        FK_itemcode VARCHAR(50) NOT NULL,
        tgl_masuk DATE NOT NULL,
        quantity BIGINT(50) NOT NULL,
        prog VARCHAR(50) NOT NULL,
        FK_user INT(11) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY(`FK_itemcode`) REFERENCES items(`item_code`),
        FOREIGN KEY(`FK_locationcode`) REFERENCES locations(`location_code`),
        FOREIGN KEY(`FK_user`) REFERENCES users(`id`)
    )
";

$result = mysqli_query($connect, $sql);
if(!$result){
    echo "Failed to run query";
}

$sql = "INSERT INTO transaction_history(bukti, transaction_time, FK_locationcode, FK_itemcode, tgl_masuk, quantity, prog, FK_user) VALUES
        ('TAMBAH01','2018-05-16 10:00:00', 'GBJ01', 'PS-PLD24T500', '2018-05-16', 60, 'T', '1'),
        ('KURANG02','2019-05-16 10:00:00', 'GBJ01', 'PS-PLD24T500', '2018-05-16', 30, 'K', '2'),
        ('TAMBAH03','2018-05-16 10:00:00', 'GBJ02', 'PS-PLD24T600', '2018-05-16', 60, 'T', '3'),
        ('KURANG04','2019-05-09 10:00:00', 'GBJ02', 'PS-PLD24T600', '2018-05-16', 30, 'K', '4'),
        ('TAMBAH05','2018-05-16 10:00:00', 'GBJ03', 'PS-PLD24T700', '2018-05-16', 60, 'T', '1'),
        ('KURANG06','2019-05-03 10:00:00', 'GBJ03', 'PS-PLD24T700', '2018-05-16', 30, 'K', '2')
        ";

$result = mysqli_query($connect, $sql);
if(!$result){
    echo "Failed to run query";
}
