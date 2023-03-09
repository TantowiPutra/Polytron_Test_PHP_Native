<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soal 3</title>
</head>

<body>
    <h1>Soal No.3</h1>
    <form action="http://localhost/Polytron_Test/test1/3.php" method="POST">
        <p style="display: inline-block; width: 80px;">Kalimat : </p>
        <input type="text" name="kalimat" id="kalimat">
        <button type="SUBMIT">CHECK</button>
    </form>

    <?php
    if (isset($_POST['kalimat'])) {
        $kalimat = $_POST['kalimat'];

        echo "Hasil: <br><hr>";
        for ($i = 0; $i < strlen($kalimat); $i++) {
            if (!ctype_space($kalimat[$i])) {
                echo "$kalimat[$i]";
            } else {
                echo "<br>";
            }
        }
    } else {
        echo "<br>Field tidak boleh kosong<br>";
    }
    ?>
</body>

</html>