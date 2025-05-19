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
    <h2>Inloggade enheter</h2>
    <?php if (!empty($sessions)): ?>
        <ul>
            <?php foreach ($sessions as $session): ?>
                <li>
                    <p>IP: <?= esc($session['ip_address']) ?></p>
                    <p>Enhet: <?= esc($session['user_agent']) ?></p>
                    <p>Senast Aktivitet: <?= esc($session['created_at']) ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>

</html>