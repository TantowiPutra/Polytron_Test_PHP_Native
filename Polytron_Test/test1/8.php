<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soal No.8</title>
</head>

<body>
    <form action="http://localhost/Polytron_Test/test1/8.php" method="POST">
        <h1>Soal No.8</h1>
        <div>
            <p style="display: inline-block; width: 80px;">Input : </p>
            <input type="text" name="input" id="input">
        </div>
        <button type="submit">CHECK</button>
    </form>

    <?php
    if (isset($_POST['input'])) {
        $n = $_POST['input'];

        for($k = 0; $k < $n; $k++){
            if($k % 4 == 0){
                // Membuat pola segitiga siku-siku
                echo "<br>";
                for ($i = 1; $i <= $n; $i++) {
                    for ($j = 1; $j <= $i; $j++) {
                        echo "* ";
                    }
                echo "<br>";
            }
            }

            if($k % 4 == 1){
                // Membuat pola segitiga sama kaki
                echo "<br>";
                for ($i = 1; $i <= $n; $i++) {
                    for ($j = 1; $j <= $n - $i; $j++) {
                        echo "&nbsp;&nbsp;&nbsp;";
                    }
                    for ($j = 1; $j <= $i; $j++) {
                        echo "* ";
                    }
                    echo "<br>";
            }
            }

            if($k % 4 == 2){
                // Membuat pola segitiga terbalik
                echo "<br>";
                for ($i = $n; $i >= 1; $i--) {
                    for ($j = 1; $j <= $i; $j++) {
                        echo "* ";
                    }
                    echo "<br>";
            }
            }

            if($k % 4 == 3){
                // Membuat pola segitiga sama kaki terbalik
                echo "<br>";
                for ($i = $n; $i >= 1; $i--) {
                    for ($j = 1; $j <= $n - $i; $j++) {
                        echo "&nbsp;&nbsp;&nbsp;";
                    }
                    for ($j = 1; $j <= $i; $j++) {
                        echo "* ";
                    }
                    echo "<br>";
            }
            }
        }
    }
    ?>
</body>

</html>