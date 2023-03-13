<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soal 7</title>
</head>

<body>
    <h1>Soal No.7</h1>
    <form action="7.php" method="POST">
        <p style="display: inline-block; width: 80px;">Nilai Awal : </p>
        <input type="text" name="digit" id="digit">
        <div>
            <p style="display: inline-block; width: 80px;">Iterasi : </p>
            <input type="text" name="iterasi" id="iterasi">
        </div>
        <button type="SUBMIT">CHECK</button>
    </form>

    <?php
    if (isset($_POST['digit']) && isset($_POST['iterasi'])) {
        $digit_input = $_POST['digit'];
        $iterasi = (int) $_POST['iterasi'];

        $digit_input = str_pad($digit_input, 4, "0", STR_PAD_LEFT);
        $digit_list = array(
            '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
            'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J',
            'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
            'U', 'V', 'W', 'X', 'Y', 'Z'
        );

        $first_digit = $digit_input[3];
        $second_digit = $digit_input[2];
        $third_digit = $digit_input[1];
        $fourth_digit = $digit_input[0];

        function findDigit($find)
        {
            global $digit_list;
            for ($i = 0; $i < sizeof($digit_list); $i++) {
                if ($digit_list[$i] == $find) {
                    return $i;
                }
            }
            return 0;
        }

        $first_digit_index = findDigit($first_digit);
        $second_digit_index = findDigit($second_digit);
        $third_digit_index = findDigit($third_digit);
        $fourth_digit_index = findDigit($fourth_digit);

        // echo $fourth_digit_index . $third_digit_index . $second_digit_index . $first_digit_index;

        function isLimit($digit)
        {
            if ($digit == 'Z') {
                return true;
            } else {
                return false;
            }
        }

        function addDigit($digit_index)
        {
            return ($digit_index % 35) + 1;
        }

        function isNumber($digit)
        {
            global $digit_list;
            return $digit_list[$digit];
        }

        // Lakukan iterasi untuk penambahan index
        for ($i = 0; $i < $iterasi; $i++) {
            echo isNumber($fourth_digit_index);
            echo isNumber($third_digit_index);
            echo isNumber($second_digit_index);
            echo isNumber($first_digit_index);

            $first_digit = $digit_list[$first_digit_index];
            $second_digit = $digit_list[$second_digit_index];
            $third_digit = $digit_list[$third_digit_index];
            $fourth_digit = $digit_list[$fourth_digit_index];
            echo "<br>";

            if (isLimit($first_digit) == true) {
                $second_digit_index = addDigit($second_digit_index);
                if (isLimit($second_digit) == true) {
                    $third_digit_index = addDigit($third_digit_index);
                    if (isLimit($third_digit) == true) {
                        $fourth_digit_index = addDigit($fourth_digit_index);
                        if (isLimit($fourth_digit) == true) {
                            $first_digit_index = 0;
                            $second_digit_index = 0;
                            $third_digit_index = 0;
                            $fourth_digit_index = 0;
                            continue;
                        }
                    }
                }
            }
            $first_digit_index = addDigit($first_digit_index);
        }
    }
    ?>
</body>

</html>