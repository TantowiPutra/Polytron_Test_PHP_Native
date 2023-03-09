<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soal 1</title>
</head>

<body>
    <h1>Soal No.1</h1>
    <form action="http://localhost/Polytron_Test/test1/1.php" method="POST">
        <div>
            <p style="display: inline-block; width: 80px;">Kalimat : </p>
            <input type="text" id="kalimat" name="kalimat">
        </div>
        <div>
            <p style="display: inline-block; width: 80px;">Abjad : </p>
            <input type="text" id="abjad" name="abjad">
        </div>

        <div>
            <button type="submit">CALCULATE</button>
        </div>
    </form>

    <?php
    if (isset($_POST['kalimat']) && isset($_POST['abjad'])) {
        $kalimat = $_POST['kalimat'];
        $abjad = $_POST['abjad'];
        $count = 0;

        for ($i = 0; $i < strlen($kalimat); $i++) {
            if($kalimat[$i] == $abjad){
                $count += 1;
            }
        }

        echo "<br> Jumlah : $count";
    }
    ?>
</body>

</html>