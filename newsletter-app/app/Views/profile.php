<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    if (!empty($user)): ?>
        <h1>Profil</h1>
        <p>Förnamn: <?= esc($user['first_name']) ?></p>
        <p>Efternamn: <?= esc($user['last_name']) ?></p>
        <p>Email: <?= esc($user['email']) ?></p>
        <p>Registrerad: <?= esc($user['created_at']) ?></p>

    <?php endif ?>
</body>

</html>