<?php
require_once 'koneksi.php';
$isInvalid = "";
session_start();
if (isset($_SESSION['isLogin'])) {
    header('Location: dashboard.php');
}

if (isset($_POST['name']) && isset($_POST['password'])) {
    if (strlen($_POST['name'] > 0 || strlen($_POST['password']) > 0)) {
        // Mencari data user menggunakan query
        $username = addslashes($_POST['name']);
        $password = addslashes($_POST['password']);
        $sql = "SELECT * FROM users WHERE BINARY username = '$username' && BINARY password = '$password'";
        $result = mysqli_query($connect, $sql);
        if (!$result) {
            echo "Query Gagal";
        }

        $fetch_assoc = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) > 0) {
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $password;
            $_SESSION['address'] = $fetch_assoc['address'];
            $_SESSION['gender'] = $fetch_assoc['gender'];
            $_SESSION['id'] = $fetch_assoc['id'];
            $_SESSION['isLogin'] = true;
            header('Location: dashboard.php');
        } else {
            $isInvalid = "User tidak terdaftar!";
        }
    } else {
        $isInvalid = "Semua Field Harus terisi!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>

<body>
    <div class="center fit-content" style="margin-top: 10%; padding: 50px;">
        <h1>Welcome to Polytron Product Management!</h1>
        <h2 class="text-align-center fw-normal">Login page</h2>
        <?php
        if (strlen($isInvalid) > 0) {
        ?>
            <h4 class="text-align-center fw-normal fw-red"><?php echo $isInvalid ?></h4>
        <?php
            $isInvalid = "";
        }
        ?>

        <form action="login.php?op=login_attempt" method="POST" class="center">
            <table cellpadding="10px" class="center">
                <tr>
                    <td>
                        Username :
                    </td>
                    <td>
                        <input type="text" name="name" id="name" max="255" placeholder="ex. Tantowi">
                    </td>
                </tr>
                <tr>
                    <td>
                        Password :
                    </td>
                    <td>
                        <input type="password" name="password" id="password" max="255" placeholder="ex. towi123">
                    </td>
                </tr>
            </table>
            <button type="submit" style="margin-left: 46%; margin-top: 10px;">LOGIN</button>
        </form>

        <h5 class="text-align-center">Made with &#10084; by Tantowi</h2>
    </div>
</body>

</html>