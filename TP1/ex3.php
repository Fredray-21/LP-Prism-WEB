<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex3</title>
</head>

<body>
    <?php
    $date = getdate();
    $string_date = "{$date['weekday']} {$date['mday']} {$date['month']} à {$date['hours']}h {$date['minutes']}min {$date['seconds']}s" ;

    $current_user = get_current_user();
    var_dump($date);

    echo "L'utilisateur $current_user a demandé cette page le $string_date ";
    ?>
</body>

</html>