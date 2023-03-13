<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soal 6</title>
</head>

<body>
    <h1>Soal No.6</h1>
    <form action="6.php" method="POST">
        <p style="display: inline-block; width: 80px;">Angka : </p>
        <input type="text" name="angka" id="angka">
        <button type="SUBMIT">CHECK</button>
    </form>

    <?php
    if(isset($_POST['angka'])){
        echo "Hasil: <br><hr>";
        $angka = (int) $_POST['angka'];
        for($i = 1; $i <= $angka; $i++){
            if($i % 2 != 0){
                for($j = 1; $j <= $angka; $j++){
                    echo "$j "; 
                }
                echo "<br>";
            }else if($i % 2 == 0){
                for($j = $angka; $j > 0; $j--){
                    echo "$j "; 
                }
                echo "<br>";
            }
        }
    }else{
        echo "Seluruh field harus diisi!";
    }
    ?>
</body>

</html>