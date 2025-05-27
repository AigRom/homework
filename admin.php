<?php
require_once("settings.php"); // DB konstandid
require_once("mysqli.php");   // DB klass

//if ($_COOKIE["admin_auth"] !== "true") {
session_start();
if (empty($_SESSION['admin_auth']) || $_SESSION['admin_auth'] !== true) {
    header("Location: login.php");
    exit;
}

// andmebaasi sisu lugemine
$db = new Db();

// kustutamine
if (isset($_GET['sid']) && is_numeric($_GET['sid']) && isset($_GET['delete'])) {
    $id = (int)$_GET['sid'];
    if ($db->deleteFeedback($id)) {
        echo "<div class='alert alert-success text-center'>Tagasiside edukalt kustutatud.</div>";

        // Kirjuta feedback.csv fail uuesti kogu andmebaasi sisu põhjal
        $all = $db->getFeedback(); // võtab tagasiside kirjed andmebaasist
        $csv_rows = []; // loob tühja massiivi

        if ($all) { // kui kirjed on olemas
            foreach ($all as $row) { // käib iga andmebaasi rea läbi
                $timestamp = $row['added'];
                $name = str_replace(";", " ", $row['name']);
                $email = str_replace(";", " ", $row['email']);
                $message = str_replace(["\r", "\n", ";"], " ", $row['message']);
                $csv_rows[] = "$timestamp;$name;$email;$message";
            }

            file_put_contents("feedback.csv", implode("\n", $csv_rows) . "\n"); // kirjutab CSV faili
        }

    } else {
        echo "<div class='alert alert-danger text-center'>Kustutamisel tekkis tõrge.</div>";
    }
}

$rows = $db->getFeedback(); // Laeme kõik tagasisidekirjed andmebaasist


/*
// CSV lugemine
$rows = [];
if (file_exists("feedback.csv")) {
    $lines = file("feedback.csv", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $fields = explode(";", $line);
        if (count($fields) >= 4) {
            $rows[] = $fields;
        }
    }
}
*/
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Tagasiside haldus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2>Laekunud tagasiside</h2>
        <div class="d-flex justify-content-end align-items-center mb-3">
            <a href="index.php" class="btn btn-outline-success me-1">Avaleht</a>
            <a href="logout.php" class="btn btn-outline-danger">Logi välja</a>
        </div>

        <?php if (!empty($rows)): ?> 
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Aeg</th>
                        <th>Nimi</th>
                        <th>E-post</th>
                        <th>Sõnum</th>
                        <th>Kustuta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r): ?>
                        <tr>
                            <td><?= date("d.m.Y H:i", strtotime($r['added'])) ?></td>
                            <td><?= htmlspecialchars($r['name']) ?></td>
                            <td><?= htmlspecialchars($r['email']) ?></td>
                            <td><?= nl2br(htmlspecialchars($r['message'])) ?></td>
                            <td class="text-center">
                                <?php $id = htmlspecialchars($r['id']); ?>
                                <a href="admin.php?sid=<?= $id ?>&delete=true"
                                   onclick="return confirm('Kas oled kindel, et soovid selle kirje kustutada?')"
                                   title="Kustuta">
                                    <i class="fa-regular fa-trash-can text-danger"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-muted">Tagasisidet ei ole veel saabunud.</p>
        <?php endif; ?>
    </div>
</body>
</html>
