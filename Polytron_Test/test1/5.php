<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soal 5</title>
</head>

<body>
    <h1>Soal No.5</h1>
    <form action="http://localhost/Polytron_Test/test1/5.php" method="POST">
        <p style="display: inline-block; width: 80px;">Iterasi : </p>
        <input type="text" name="angka" id="angka">
        <button type="SUBMIT">CHECK</button>
    </form>

    <?php
    $deret = array(1, 1);

    if (isset($_POST['angka'])) {
        $angka = $_POST['angka'];
        if((int) $angka < 0) echo "Angka tidak boleh bernilai negatif";

        for ($i = 2; $i < $angka; $i++) {
            array_push($deret, $deret[$i - 1] + $deret[$i - 2]);
        }

        echo "Hasil: ";
        for ($i = 0; $i < $angka; $i++) {
            echo "$deret[$i] ";
        }
    } else {
        echo "<br>Field tidak boleh kosong!<br>";
    }
    ?>
</body>

</html>