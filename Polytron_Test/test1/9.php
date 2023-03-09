<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soal 3</title>
</head>

<body>
    <h1>Soal No.9</h1>
    <form action="http://localhost/Polytron_Test/test1/9.php" method="POST">
        <p style="display: inline-block; width: 50px;">Input : </p>
        <input type="text" name="input" id="input">
        <button type="SUBMIT">CHECK</button>
    </form>

    <?php
    if (isset($_POST['input'])) {
        $angka = (string)(int) $_POST['input'];
        if ($angka > 999) {
            $string_length = strlen($angka);
            $current = strlen($angka) % 3;

            echo "Hasil: ";
            for ($i = 0; $i < $current; $i++) {
                echo "$angka[$i]";
            }

            if(strlen($angka) % 3 != 0){
                echo ".";
            }

            while ($current < $string_length) {
                if ($current + 3 != $string_length) {
                    echo $angka[$current];
                    echo $angka[$current + 1];
                    echo $angka[$current + 2];
                    echo ".";
                } else {
                    echo $angka[$current];
                    echo $angka[$current + 1];
                    echo $angka[$current + 2];
                }

                $current += 3;
            }
        } else {
            echo "Hasil : $angka";
        }
    }
    ?>
</body>

</html>