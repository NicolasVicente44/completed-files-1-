<?php
    if (session_status() === PHP_SESSION_NONE) session_start();

    $notifications = [];

    if (isset($_SESSION["notifications"])) $notifications = $_SESSION["notifications"];
    unset($_SESSION["notifications"]);
?>

<?php foreach ($notifications as $type => $messages): ?>
    <div class="notification <?= $type ?>">
        <?php foreach ($messages as $message): ?>
            <p><?= $message ?></p>
        <?php endforeach ?>
    </div>
<?php endforeach ?>