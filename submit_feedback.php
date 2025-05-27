<?php
require_once("settings.php"); // DB konstandid
require_once("mysqli.php"); // DB klass
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $message = trim($_POST["message"] ?? '');

    if ($name && $email && $message) {
        $timestamp = date("Y-m-d H:i:s");
        $name = htmlspecialchars($name);
        $email = htmlspecialchars($email);
        $message = str_replace(["\r", "\n", ";"], " ", htmlspecialchars($message));

        $line = "$timestamp;$name;$email;$message\n";  // CSV faili kirjutamise osa

        file_put_contents("feedback.csv", $line, FILE_APPEND | LOCK_EX); // CSV faili kirjutamise osa

        // Kirjuta andmebaasi
        $db = new Db();
        $db->addFeedback($timestamp, $name, $email, $message); //kasutab DB klassi LisaTagasiside funktsiooni andmete lisamiseks

        echo "<h3>Aitäh! Teie sõnum on salvestatud.</h3>";
        echo "<a href='index.php'>Avalehele</a>";
    } else {
        echo "<h3>Palun täida kõik väljad.</h3>";
		echo "<a href='javascript:history.back()'>Tagasi</a>";
    }
} else {
    header("Location: contact.html");
    exit;
}
