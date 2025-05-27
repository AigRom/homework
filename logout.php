<?php
//setcookie("admin_auth", "", time() - 3600, "/"); // kustutab küpsise

session_start();         // Alustame sessiooni
session_unset();         // Kustutame kõik sessiooni muutujad
session_destroy();       // Hävitame sessiooni täielikult
header("Location: index.php");
exit;
