<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <style>
        body {
            font-family: sans-serif;
            max-width: 500px;
            margin: auto;
            padding: 1em;
        }

        .error {
            color: red;
        }

        label {
            display: block;
            margin-top: 1em;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 0.5em;
            margin-top: 0.3em;
        }

        button {
            margin-top: 1.5em;
            padding: 0.5em 1em;
        }
    </style>

    <h2>Logga in</h2>
    <?php
    if (!empty($errors)): ?>
        <div class="error">
            <h1>Errors</h1>
            <ul>
                <?php foreach ($errors as $field => $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="post" action="<?= site_url('login') ?>">
        <label for="email">Email</label>
        <input type="text" name="email" id="email" value="<?= old('email') ?>">
        <label for="password">Lösenord</label>
        <input type="password" name="password" id="password">
        <button type="submit">Logga in</button>
    </form>
</body>

</html>