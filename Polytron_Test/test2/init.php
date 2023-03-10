<?php
// Define the SQL statement to get all table names in the database
$sql = "SHOW TABLES";

if (mysqli_query($connect, $sql)) {
    // echo "Table users created successfully";
} else {
    echo "Error creating table: " . mysqli_error($connect);
}

// Execute the SQL statement using the mysqli_query function
$result = mysqli_query($connect, $sql);

// Loop through the result set and drop each table
while ($row = mysqli_fetch_array($result)) {
    $tableName = $row[0];
    mysqli_query($connect, "DROP TABLE $tableName");
}

// Create Table
$sql = "CREATE TABLE karyawan (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    NIK VARCHAR(50) NOT NULL,
    TglMasuk DATE NOT NULL,
    Nama VARCHAR(50) NOT NULL,
    Alamat VARCHAR(50) NOT NULL,
    Kota VARCHAR(50) NOT NULL,
    Gelar VARCHAR(50) NOT NULL,
    Gender VARCHAR(50) NOT NULL,
    TglKeluar DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

$result = mysqli_query($connect, $sql);
$date = date('Y-m-d');

// Insert data into Database
$sql = "INSERT INTO karyawan (NIK, TglMasuk, Nama, Alamat, Kota, Gelar, Gender, TglKeluar)VALUES
('123456789011', '$date', 'TANTOWI', 'JALAN KEMBANG', 'BANDUNG', 'SMA', 'L', null),
('123456789012', '$date', 'PUTRA', 'JALAN MAWAR', 'JAKARTA', 'SMA',  'P', '2015-02-01'),
('123456789013', '$date', 'AGUNG', 'JALAN SINAR', 'TANGERANG', 'S1',  'P', '2015-02-01'),
('123456789014', '$date', 'SETIAWAN', 'JALAN MANGGIS', 'DEPOK', 'S2',  'L', '2015-02-01'),
('123456789015', '$date', 'TEST123', 'JALAN TENNIS', 'BEKASI', 'D4',  'P', '2024-06-18')
";
$result = mysqli_query($connect, $sql);
