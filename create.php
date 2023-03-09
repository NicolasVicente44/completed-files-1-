<?php

    session_start();

    $date = strtotime("gofuckyourself");

    require_once("./helper_functions.php");
    require_once("./_connect.php");

    // Sanitize the values
    // Cast to secure string
    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlspecialchars($_POST[$key]);
    }

    // Cast to email
    $_POST["email"] = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);

    // Cast to date
    foreach (["date_of_birth", "booking_date"] as $field) {
        $_POST[$field] = sanitize_date($_POST[$field]);
    }

    // Cast to time
    $_POST["booking_time"] = sanitize_time($_POST["booking_time"]);

    // Validate the values
    $errors = [];

    // Required
    $fields = ["first_name", "last_name", "date_of_birth", "email", "booking_date", "booking_time", "message"];

    foreach ($fields as $field) {
        // skip non required fields
        if ($field === "message") continue;

        // humanize the field name
        $humanize = str_replace("_", " ", $field);
        $humanize = ucfirst($humanize);

        // add an error if the field is empty
        if (empty($_POST[$field])) $errors[]= "{$humanize} is required.";
    }

    // Format
    if (!validate_date($_POST["date_of_birth"])) {
        $errors[]= "Your date of birth must be in a YYYY-MM-DD format";
    }

    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $errors[]= "Your provided email as in an invalid format";
    }

    if (!validate_date($_POST["booking_date"])) {
        $errors[]= "Your booking date must be in a YYYY-MM-DD format";
    }

    if (!validate_time($_POST["booking_time"])) {
        $errors[]= "Your booking time must be in a HH:MM format";
    }

    // Return error if there's a problem with the values
    if (count($errors) > 0) {
        $_SESSION["notifications"]["errors"] = $errors;
        $_SESSION["form_fields"] = $_POST;

        header("Location: ./index.php");
        exit();
    }

    // Business criteria
    // User is at least 19 years of age
    if (!(strtotime($_POST["date_of_birth"]) < strtotime("-19 years"))) {
        $errors[] = "You must be at least 19 years of age to book";
    }

    // Can't book into the past
    if (strtotime("{$_POST['booking_date']} {$_POST['booking_time']}") < strtotime("now")) {
        $errors[] = "You can't book into the past";
    }

    // Can't book before 9pm at night
    if (strtotime($_POST["booking_time"]) < strtotime("21:00")) {
        $errors[] = "You can not book a time before 9pm";
    }

    // Return error if there's a problem with the business requirements
    if (count($errors) > 0) {
        $_SESSION["notifications"]["warnings"] = $errors;
        $_SESSION["form_fields"] = $_POST;

        header("Location: ./index.php");
        exit();
    }

    // Normalize the values
    // Normalize names
    foreach(["first_name", "last_name"] as $field) {
        $_POST[$field] = ucwords(strtolower($_POST[$field]));
    }

    // Normalize the booking time
    $_POST["requested_date_and_time"] = "{$_POST['booking_date']} {$_POST['booking_time']}:00";

    // Now you write the new booking to the database
    $sql = "INSERT INTO bookings (
        first_name,
        last_name,
        date_of_birth,
        email,
        requested_date_and_time,
        message
    ) VALUES (
        :first_name,
        :last_name,
        :date_of_birth,
        :email,
        :requested_date_and_time,
        :message
    )";

    try {
        $conn = connect("localhost", "comp_1006", "root", "", 3308);

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":first_name", $_POST["first_name"], PDO::PARAM_STR);
        $stmt->bindParam(":last_name", $_POST["last_name"], PDO::PARAM_STR);
        $stmt->bindParam(":date_of_birth", $_POST["date_of_birth"], PDO::PARAM_STR);
        $stmt->bindParam(":email", $_POST["email"], PDO::PARAM_STR);
        $stmt->bindParam(":requested_date_and_time", $_POST["requested_date_and_time"], PDO::PARAM_STR);
        $stmt->bindParam(":message", $_POST["message"], PDO::PARAM_STR);

        $stmt->execute();
    } catch (PDOException $error) {
        $_SESSION["notifications"]["errors"][]= "There was an issue with attempting to book your event";
        $_SESSION["notifications"]["errors"][]= $error->getMessage();
        $_SESSION["form_fields"] = $_POST;

        header("Location: ./index.php");
        exit();
    }

    $_SESSION["notifications"]["success"][] = "Congratulations you're booking has been accepted";
    header("Location: ./index.php");

?>