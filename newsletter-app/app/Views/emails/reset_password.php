<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Återställ lösenord</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Återställ ditt lösenord</h2>
    <p>Hej, <?php echo $name?></p>
    <p>Du har begärt att återställa ditt lösenord för konto: <?php echo $email ?>. Klicka på länken nedan för att
        återställa det:</p>
    <p>
        <a href="<?= esc($link) ?>"
            style="background-color: #007bff; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;">
            Återställ lösenord
        </a>
    </p>
    <p>Om du inte begärde detta kan du ignorera detta meddelande.</p>
    <p>Vänliga hälsningar,<br>Teamet</p>
</body>

</html>