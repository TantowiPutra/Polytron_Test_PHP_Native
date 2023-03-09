<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soal 2</title>
</head>

<body>
    <form action="http://localhost/Polytron_Test/test1/2.php" method="POST">
        <h1>Soal No.2</h1>
        <div>
            <p style="display: inline-block; width: 80px;">Tanggal : </p>
            <input type="text" name="tanggal" id="tanggal">
        </div>
        <div>
            <p style="display: inline-block; width: 80px;">Bulan : </p>
            <input type="text" name="bulan" id="bulan">
        </div>
        <div>
            <p style="display: inline-block; width: 80px;">Tahun : </p>
            <input type="text" name="tahun" id="tahun">
        </div>

        <button type="submit">CHECK</button>
    </form>

    <?php
    if (isset($_POST['tanggal']) && isset($_POST['bulan']) && isset($_POST['tahun'])) {
        $tanggal = (int) $_POST['tanggal'];
        $bulan = (int) $_POST['bulan'];
        $tahun = (int) $_POST['tahun'];

        $tanggal_string =  $_POST['tanggal'];
        $bulan_string =  $_POST['bulan'];
        $tahun_string =  $_POST['tahun'];

        $isFalse = false;

        if ($tanggal < 1 || $tanggal > 31) {
            echo "ERROR: Format Tanggal Tidak Boleh < 1 atau > 31<br>";
            $isFalse = true;
        }

        if ($bulan < 1 || $bulan > 12) {
            echo "ERROR: Format Bulan Tidak Boleh < 1 atau > 12<br>";
            $isFalse = true;
        }

        if ($tahun < 0) {
            echo "ERROR: Tahun tidak boleh negatif!<br>";
            $isFalse = true;
        }

        if ($isFalse == true) {
            die();
        }

        // Validation Success
        if ($bulan == 1 || $bulan == 3 || $bulan == 5 || $bulan == 7 || $bulan == 8 || $bulan == 10 || $bulan == 12) {
            echo "Format Sudah Benar!<br>";
            die();
        } else if ($bulan == 4 || $bulan == 6 || $bulan == 9 || $bulan == 11) {
            if ($tanggal > 30) {
                echo "ERROR: Bulan $bulan_string hanya sampai tanggal 30!";
                die();
            }
            echo "Format Sudah Benar!<br>";
            die();
        } else if ($bulan == 2) {
            if ($tanggal <= 29) {
                echo "Format Sudah Benar!<br>";
                die();
            } else {
                echo "ERROR: Bulan $bulan_string hanya sampai tanggal 28-29!";
                die();
            }
        }
    } else {
        echo "<br>Seluruh field harus diisi!<br>";
        die();
    }
    ?>
</body>

</html>