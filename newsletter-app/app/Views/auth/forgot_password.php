<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glömt lösenord</title>
</head>
<body>
    <h2>Glömt lösenord</h2>
    <p>Fyll i din e-postadress för att återställa ditt lösenord.</p>

    <form action="/reset-password-email" method="POST">
        <label for="email">E-postadress:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <button type="submit">Skicka</button>
    </form>
</body>
</html>