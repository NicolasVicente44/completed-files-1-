<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" href="./assets/styles/style.css">
        <link rel="stylesheet" href="./assets/styles/modal.css">
        <script src="./assets/js/main.js" defer></script>

        <title>Jan's New Back Pack</title>
    </head>

    <body>
        <header>
            <?php require_once("./notification.php") ?>

            <nav>
                <ul>
                    <li><a href="https://youtu.be/otT53ANCfR4?t=138" target="_blank">Watch Stefon's Review!</a></li>
                </ul>
            </nav>

            <div id="title-block">
                <h1 class="">Jan's New Backpack</h1>
                <h2 class="blue-glow">...a Stefon recommended club...</h2>
            </div>
        </header>

        <hr>

        <main>
            <div id="main-content">
                <h2>This Club has <span class="emphasis pink-glow">Everything</span></h2>

                <a href="#" id="modal-opener" class="blue-glow">Book Your Event Today!</a>
            </div>
        </main>

        <footer>
            <p><a href="./admin.php">&copy;2023 Shaun McKinnon</a></p>
        </footer>

        <div id="modal" class="modal-container">
            <?php
                if (session_status() === PHP_SESSION_NONE) session_start();

                $form_fields = $_SESSION["form_fields"] ?? [];
                
                unset($_SESSION["form_fields"]);
            ?>

            <form class="form-container" action="./create.php" method="post" novalidate>
                <a id="modal-closer" href="#">X</a>
                <h2 class="pink-glow">Book Today!</h2>

                <div class="form-group">
                    <label class="blue-glow" for="first_name">First Name</label>
                    <input type="text" name="first_name" id="first_name" placeholder="Stefan" required value="<?= $form_fields["first_name"] ?? "" ?>">
                </div>

                <div class="form-group">
                    <label class="blue-glow" for="last_name">Last Name</label>
                    <input type="text" name="last_name" id="last_name" placeholder="Meyers" required value="<?= $form_fields["last_name"] ?? "" ?>">
                </div>

                <div class="form-group">
                    <label class="blue-glow" for="date_of_birth">Date of Birth</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" required value="<?= $form_fields["date_of_birth"] ?? "" ?>">
                </div>

                <div class="form-group">
                    <label class="blue-glow" for="email">Email</label>
                    <input type="email" name="email" id="email" placeholder="stefanheartsseth@huumba.com" required value="<?= $form_fields["email"] ?? "" ?>">
                </div>

                <div class="form-group">
                    <label class="blue-glow" for="booking_date">Booking Date and Time</label>
                    <input type="date" name="booking_date" id="booking_date" required value="<?= $form_fields["booking_date"] ?? "" ?>">
                    <input type="time" name="booking_time" id="booking_time" required value="<?= $form_fields["booking_time"] ?? "" ?>">
                </div>

                <div class="form-group">
                    <label class="blue-glow" for="booking_date">Booking Details</label>
                    <textarea name="message" id="message" placeholder="Please enter any details you think we should know here..."><?= $form_fields["message"] ?? "" ?></textarea>
                </div>

                <div class="button-container">
                    <button type="submit">Book Now</button>
                </div>
            </form>
        </div>
    </body>
</html>