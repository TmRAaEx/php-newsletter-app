<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Återställ lösenord</title>
</head>

<body>
    <h2>Återställ ditt lösenord</h2>
    <p>Fyll i ditt nya lösenord nedan.</p>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>

    <form action="/reset-password?token=<?= esc($token) ?>" method="POST">
        <label for="password">Nytt lösenord:</label><br>
        <input type="password" id="password" name="password" required><br><br>

        <label for="password_confirm">Bekräfta lösenord:</label><br>
        <input type="password" id="password_confirm" name="password_confirm" required><br><br>

        <button type="submit">Återställ lösenord</button>
    </form>
</body>

</html>