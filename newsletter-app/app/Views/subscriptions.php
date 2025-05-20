<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mina prenumerationer</title>
</head>

<body>
    <h2>Mina prenumerationer</h2>

    <?php if (empty($newsletters)): ?>
        <p>Du prenumererar inte på några nyhetsbrev.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($newsletters as $newsletter): ?>
                <li><a href="<?= base_url('newsletters/' . $newsletter['id']) ?>" style="text-decoration: none; color: unset;">
                        <?= view('components/newsletter_card', ['name' => $newsletter['name'], 'date' => $newsletter['updated_at']]) ?>
                    </a> </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</body>

</html>