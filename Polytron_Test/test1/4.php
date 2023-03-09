<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Soal 4</title>
</head>

<body>
	<h1>Soal No.4</h1>
	<form action="http://localhost/Polytron_Test/test1/4.php" method="POST">
		<p style="display: inline-block; width: 80px;">Angka : </p>
		<input type="text" name="angka" id="angka">
		<button type="SUBMIT">CHECK</button>
	</form>

	<?php
	if(isset($_POST['angka'])){
		$angka = $_POST['angka'];
		echo "Pembilang: " . getNumber($angka) . " rupiah";
	}else{
		echo "Anda harus memasukan angka!";
	}
		function getNumber($nilai)
		{
			$nilai = abs($nilai);
			$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
			$temp = "";
			if ($nilai < 12) {
				$temp = " " . $huruf[$nilai];
			} else if ($nilai < 20) {
				$temp = getNumber($nilai - 10) . " belas";
			} else if ($nilai < 100) {
				$temp = getNumber($nilai / 10) . " puluh" . getNumber($nilai % 10);
			} else if ($nilai < 200) {
				$temp = " seratus" . getNumber($nilai - 100);
			} else if ($nilai < 1000) {
				$temp = getNumber($nilai / 100) . " ratus" . getNumber($nilai % 100);
			} else if ($nilai < 2000) {
				$temp = " seribu" . getNumber($nilai - 1000);
			} else if ($nilai < 1000000) {
				$temp = getNumber($nilai / 1000) . " ribu" . getNumber($nilai % 1000);
			} else if ($nilai < 1000000000) {
				$temp = getNumber($nilai / 1000000) . " juta" . getNumber($nilai % 1000000);
			} else if ($nilai < 1000000000000) {
				$temp = getNumber($nilai / 1000000000) . " milyar" . getNumber(fmod($nilai, 1000000000));
			} else if ($nilai < 1000000000000000) {
				$temp = getNumber($nilai / 1000000000000) . " trilyun" . getNumber(fmod($nilai, 1000000000000));
			}
			return $temp;
		}
	?>
</body>

</html>