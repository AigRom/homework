<?php
session_start();
$correct_password = "admin123";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    if ($password === $correct_password) {
        //setcookie("admin_auth", "true", time() + 600, "/"); // kehtib 5 minutit
        $_SESSION['admin_auth'] = true; // kasutaja on sisse loginud
        header("Location: admin.php");
        exit;
    } else {
        $error = "Vale parool.";
    }
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Admin sisselogimine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h2>Administraatori sisselogimine</h2>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form method="POST" class="mt-3" style="max-width: 400px;">
            <div class="mb-3">
                <label for="password" class="form-label">Parool</label>
                <input type="password" name="password" id="password" class="form-control" required autofocus>
            </div>
            <button type="submit" class="btn btn-primary">Logi sisse</button>
        </form>
    </div>
</body>
</html>
