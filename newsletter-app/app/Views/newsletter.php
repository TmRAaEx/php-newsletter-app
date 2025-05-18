<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php if (isset($newsletter)): ?>
        <h1><?= esc($newsletter['name']) ?></h1>
        <p><?= esc($newsletter['description']) ?></p>
    <?php endif; ?>

    
</body>
</html>