<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "master_karyawan";

$sql = "";

$error_message_nik = "";
$error_message_tanggal = "";
$error_message_nama = "";
$error_message_alamat = "";
$error_message_kota = "";
$error_message_gelar = "";
$error_message_gender = "";
$error_message_tanggal_keluar = "";

$nik = "";
$tanggal_masuk = "";
$nama = "";
$alamat = "";
$kota = "";
$gelar = "";
$tanggal_keluar = "";
$gender = "";

$name = "";
$tanggal = "";

// Koneksi Database
require_once 'connect.php';

if (isset($_REQUEST['op'])) {
    $operation = $_REQUEST['op'];
    if ($operation == "delete") {
        require_once 'delete.php';
    } else if ($operation == "insert") {
        require_once 'insert.php';
    } else if ($operation == "exupdate") {
        require_once 'update.php';
    }
} else {
    require_once 'init.php';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
        .center {
            text-align: center;
        }

        body {
            padding: 20px;
        }

        .row {
            vertical-align: top;
        }

        .bg-lightyellow {
            background-color: lightgoldenrodyellow;
        }
    </style>
</head>

<body>
    <h1 class="center mb-5 p-4" style="border-bottom: solid 5px black;">Database Master Karyawan</h1>
    <form action="case.php?op=search" method="POST">
        <div class="mb-3 d-flex justify-content-center shadow-sm card p-2 mx-auto px-4 py-3 bg-lightyellow" style="flex-direction: column; max-width: 40%;">
            <h3 class="w-100">Cari Karyawan</h3>
            <div>
                <div class="col-auto">
                    <label for="name" class="col-form-label">Nama Karyawan: </label>
                </div>
                <div class="col-auto">
                    <input type="text" id="name" name="name" class="form-control" aria-describedby="passwordHelpInline">
                </div>
            </div>

            <div>
                <div class="col-auto">
                    <label for="date" class="col-form-label">Tanggal Masuk: </label>
                </div>
                <div class="col-auto">
                    <input type="date" id="date" name="date" class="form-control" aria-describedby="passwordHelpInline">
                </div>
            </div>

            <button class="btn btn-success mt-3 mx-auto" style="width: 200px;">MULAI PENCARIAN</button>
        </div>
    </form>

    <div class="row">
        <div class="col-md-4">
            <?php
            $url = "";
            if (isset($_REQUEST['op']) && $_REQUEST['op'] == "update") {
                $id = $_REQUEST['id'];
                $url = "case.php?op=exupdate&id=$id";
            } else {
                $url = "case.php?op=insert";
            }
            ?>
            <form action="<?php echo $url ?>" method="POST" class="w-100 mx-auto mb-3 p-5" style="background-color: lightblue;">
                <h1 class="mb-5">
                    <?php
                    if (isset($_REQUEST['op']) && $_REQUEST['op'] == "update") {
                        echo "Update Karyawan";
                    } else {
                        echo "Tambah Karyawan";
                    }
                    ?>
                </h1>
                <?php
                if (isset($_REQUEST['op']) && $_REQUEST['op'] == "update") {
                    require_once 'fetch_single.php';
                }
                ?>

                <div class="mb-3">
                    <label for="nik" class="form-label">Masukan NIK</label>
                    <input type="text" class="form-control" id="nik" name="nik" aria-describedby="emailHelp" value="<?php echo $nik ?>">

                    <?php
                    if ($error_message_nik != null) {
                    ?>
                        <div class="text text-danger">
                            <?php echo $error_message_nik ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="mb-3">
                    <label for="tglMasuk" class="form-label">Masukan Tanggal Masuk</label>
                    <input type="date" min="<?php echo date('Y-m-d') ?>" class="form-control" id="tglMasuk" name="tglMasuk" aria-describedby="emailHelp" value="<?php echo $tanggal_masuk ?>">
                    <?php
                    if ($error_message_tanggal != null) {
                    ?>
                        <div class="text text-danger">
                            <?php echo $error_message_tanggal ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="mb-3">
                    <label for="nama" class="form-label">Masukan Nama</label>
                    <input type="text" class="form-control" id="nama" name="nama" aria-describedby="emailHelp" value="<?php echo $nama ?>">
                    <?php
                    if ($error_message_nama != null) {
                    ?>
                        <div class="text text-danger">
                            <?php echo $error_message_nama ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">Masukan Alamat</label>
                    <input type="text" class="form-control" id="alamat" name="alamat" aria-describedby="emailHelp" value="<?php echo $alamat ?>">
                    <?php
                    if ($error_message_alamat != null) {
                    ?>
                        <div class="text text-danger">
                            <?php echo $error_message_alamat ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="mb-3">
                    <label for="kota" class="form-label">Masukan Kota</label>
                    <input type="text" class="form-control" id="kota" name="kota" aria-describedby="emailHelp" value="<?php echo $kota ?>">
                    <?php
                    if ($error_message_kota != null) {
                    ?>
                        <div class="text text-danger">
                            <?php echo $error_message_kota ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="mb-3">
                    <label for="gelar" class="form-label">Masukan Gelar</label>
                    <input type="text" list="gelar-list" class="form-control" id="gelar" name="gelar" value="<?php echo $gelar ?>">
                    <datalist id="gelar-list">
                        <option value="sma">SMA</option>
                        <option value="smk">SMK</option>
                        <option value="s1">S1</option>
                        <option value="d3">D3</option>
                        <option value="d4">D4</option>
                        <option value="s2">S2</option>
                        <option value="s3">S3</option>
                    </datalist>
                    <?php
                    if ($error_message_gelar != null) {
                    ?>
                        <div class="text text-danger">
                            <?php echo $error_message_gelar ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <div class="mb-3">
                    <label for="gender" class="form-label">Pilih Gender</label>
                    <select name="gender" id="gender" class="p-2">
                        <option value="">- Pilih Gender -</option>
                        <option value="L" <?php echo ($gender == "L") ? "selected" : '' ?>>Laki - Laki</option>
                        <option value="P" <?php echo ($gender == "P") ? "selected" : '' ?>>Perempuan</option>
                    </select>
                    <?php
                    if ($error_message_gender != null) {
                    ?>
                        <div class="text text-danger">
                            <?php echo $error_message_gender ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>

                <?php
                if (isset($_REQUEST['op']) && $_REQUEST['op'] == "update") {
                ?>
                    <div class="mb-3">
                        <label for="tglMasuk" class="form-label">Masukan Tanggal Keluar</label>
                        <input type="date" min="<?php echo date('Y-m-d', strtotime(date('Y-m-d') . "+1 months")) ?>" class="form-control" id="tglKeluar" name="tglKeluar" aria-describedby="emailHelp" value="<?php echo $tanggal_keluar ?>">
                        <?php
                        if ($error_message_tanggal != null) {
                        ?>
                            <div class="text text-danger">
                                <?php echo $error_message_tanggal ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>

                <?php
                }
                ?>

                <button type="submit" class="btn btn-primary">
                    <?php
                    if (isset($_REQUEST['op']) && $_REQUEST['op'] == "update") {
                        echo "UPDATE";
                    } else {
                        echo "TAMBAH";
                    }
                    ?>
                </button>
            </form>
        </div>

        <div class="col-md-8">
            <h1>Daftar Karyawan</h1>
            <hr>
            <table class="table mx-auto w-100 mt-5 table-secondary" cellpadding="60px">
                <thead>
                    <tr>
                        <th scope="col">Edit</th>
                        <th scope="col">NIK</th>
                        <th scope="col">Tanggal Masuk</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Kota</th>
                        <th scope="col">Gelar</th>
                        <th scope="col">Tanggal Keluar</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Get Data from Database
                    if (isset($_REQUEST['op']) && $_REQUEST['op'] == "search" && (isset($_POST['name']) || isset($_POST['date'])) && ($_POST['name'] != null || $_POST['date'] != null)) {
                        if (isset($_POST['name'])) {
                            $nama = $_POST['name'];
                        } else {
                            $nama = "";
                        }

                        if (isset($_POST['date'])) {
                            $tanggal = $_POST['date'];
                        } else {
                            $tanggal = "";
                        }

                        $date = date("Y-m-d");
                        if ($nama == null) {
                            $sql = "SELECT * FROM karyawan WHERE TglMasuk = '$tanggal' AND (TglKeluar IS NULL OR TglKeluar > '$date')";
                        } else if ($tanggal == null) {
                            $sql = "SELECT * FROM karyawan WHERE Nama LIKE '%$nama%' AND (TglKeluar IS NULL OR TglKeluar > '$date');";
                        } else {
                            $sql = "SELECT * FROM karyawan WHERE Nama LIKE '%$nama%' AND TglMasuk = '$tanggal' AND (TglKeluar IS NULL OR TglKeluar > '$date')";
                        }
                    } else {
                        $sql = "SELECT * FROM karyawan";
                    }

                    $query_execute = mysqli_query($connect, $sql);
                    while ($data = mysqli_fetch_array($query_execute)) {
                        $id = $data['id'];
                        $NIK = $data['NIK'];
                        $tgl_masuk = date('d-m-Y', strtotime($data['TglMasuk']));
                        $nama = $data['Nama'];
                        $alamat = $data['Alamat'];
                        $kota = $data['Kota'];
                        $gelar = $data['Gelar'];
                        $tgl_keluar = null;
                        $gender = $data['Gender'];
                        if ($data['TglKeluar'] != null) {
                            $tgl_keluar = date('d-m-Y', strtotime($data['TglKeluar']));
                        }
                    ?>
                        <tr>
                            <th scope="col">
                                <?php
                                if ($tgl_keluar > date('d-m-Y') || $tgl_keluar == null) {
                                ?>
                                    <form action="case.php?op=update&id=<?php echo $id ?>&tgl=<?php echo $tgl_keluar ?>" method="POST">
                                        <button type="submit" class="btn btn-warning">Update</button>
                                    </form>
                                <?php } ?>
                            </th>
                            <th scope="col"><?php echo $NIK ?></th>
                            <th scope="col"><?php echo $tgl_masuk ?></th>
                            <th scope="col"><?php echo $nama ?></th>
                            <th scope="col"><?php echo $alamat ?></th>
                            <th scope="col"><?php echo $kota ?></th>
                            <th scope="col"><?php echo $gelar ?></th>
                            <th scope="col"><?php echo $tgl_keluar ?></th>
                            <th scope="col"><?php echo $gender == "L" ? "LAKI-LAKI" : "PEREMPUAN" ?></th>
                            <th scope="col">
                                <?php
                                if ($tgl_keluar > date('d-m-Y') || $tgl_keluar == null) {
                                ?>
                                    <form action="case.php?op=delete&id=<?php echo $id ?>&tgl=<?php echo $tanggal_keluar ?>" method="POST">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                <?php } ?>
                            </th>
                        </tr>
                    <?php
                    }
                    ?>

                </tbody>
            </table>

            <h1>Daftar Gelar dan Gender</h1>
            <hr>
            <?php
            $sql = "SELECT Gelar,
                            COUNT(CASE WHEN Gender = 'L' THEN 1 END) AS 'Laki-Laki',
                            COUNT(CASE WHEN Gender = 'P' THEN 1 END) AS 'Perempuan'
                            FROM karyawan
                            GROUP BY Gelar;";
            $query_execute = mysqli_query($connect, $sql);
            ?>
            <table class="table table-secondary">
                <thead>
                    <tr>
                        <th scope="col">Gelar</th>
                        <th scope="col">Laki-Laki</th>
                        <th scope="col">Perempuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($data = mysqli_fetch_array($query_execute)) {
                    ?>
                        <tr>
                            <th scope="col"><?php echo $data['Gelar'] ?></th>
                            <th scope="col"><?php echo $data['Laki-Laki'] ?></th>
                            <th scope="col"><?php echo $data['Perempuan'] ?></th>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</table>
</body>

</html>