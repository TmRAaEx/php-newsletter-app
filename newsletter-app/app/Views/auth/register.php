<!DOCTYPE html>
<html>

<head>
    <title>Registrera konto</title>
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
</head>

<body>

    <h2>Skapa konto</h2>

    <?php if (!empty($errors)): 
        ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $field => $error):?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('register') ?>">
        <?= csrf_field() ?>

        <label for="first_name">Förnamn</label>
        <input type="text" name="first_name" id="first_name" value="<?= old('first_name') ?>">

        <label for="last_name">Efternamn</label>
        <input type="text" name="last_name" id="last_name" value="<?= old('last_name') ?>">

        <label for="email">E-postadress</label>
        <input type="email" name="email" id="email" value="<?= old('email') ?>">

        <label for="password">Lösenord</label>
        <input type="password" name="password" id="password">

        <button type="submit">Registrera</button>
    </form>

</body>

</html>