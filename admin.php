<?php

    $user = "user";
    $password = "password";

    if (
        !isset($_SERVER["PHP_AUTH_USER"]) ||
        $_SERVER["PHP_AUTH_USER"] !== $user ||
        $_SERVER["PHP_AUTH_PW"] !== $password
    ) {
        header('WWW-Authenticate: Basic realm="Jan\'s New Backpack"');
        header('HTTP/1.0 401 Unauthorized');
        echo "You are not authorized!";
        exit;
    }

    require_once("./_connect.php");
    $conn = connect("localhost", "comp_1006", "root", "", 3308);

    $sql = "SELECT * FROM bookings ORDER BY requested_date_and_time DESC";
    $bookings = $conn->query($sql)->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <title>Admin</title>
    </head>

    <body class="container">
        <header>
            <h1>Admin</h1>
        </header>

        <a href="./index.php">Return to home...</a>

        <h2>Bookings</h2>

        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Created On</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Date of Birth</th>
                    <th>Booking Date & Time</th>
                    <th>Message</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?= $booking->created_at ?></td>
                        <td><?= $booking->first_name ?> <?= $booking->last_name ?></td>
                        <td><?= $booking->email ?></td>
                        <td><?= $booking->date_of_birth ?></td>
                        <td><?= $booking->requested_date_and_time ?></td>
                        <td><?= $booking->message ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </body>
</html>