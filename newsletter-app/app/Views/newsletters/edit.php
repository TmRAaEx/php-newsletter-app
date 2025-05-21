<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Document</title>
</head>

<body>


    <?php if (!empty($error)): ?>
        <h1>
            <?= $error ?>
        </h1>
    <?php endif; ?>

    <?php if (!empty($newsletter)): ?>
        <h1>Redigera nyhetsbrev: <?= esc($newsletter['name']) ?></h1>
        <form action="<?= base_url('newsletters/edit/' . $newsletter['id']) ?>" method="post">
            <label for="name">Namn:</label>
            <input type="text" name="name" value="<?= $newsletter['name'] ?>">
            <label for="description">Beskrivning:</label>
            <input type="textarea" name="description" value="<?= $newsletter['description'] ?>">

            <button role="submit">Redigera</button>
        </form>
    <?php endif; ?>
</body>

</html>