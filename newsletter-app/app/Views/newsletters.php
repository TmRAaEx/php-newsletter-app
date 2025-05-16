<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<style>
    .newsletters ul {
        display: grid;
        padding: 0;
        list-style: none;
        grid-template-columns: repeat(2, 1fr);
        gap: clamp(1rem, 5vw, 2rem);
    }

    @media screen and (min-width: 768px) {
        .newsletters ul {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media screen and (min-width: 1024px) {
        .newsletters ul {
            grid-template-columns: repeat(4, 1fr);
        }
    }
</style>


<body>


    <h1>Nyhetsbrev</h1>
    <?php if (!empty($newsletters)): ?>
        <div class="newsletters">
            <ul>
                <?php foreach ($newsletters as $field => $newsletter): ?>
                    <li class="newletter-item">
                        <a href="<?= base_url('newsletters/' . $newsletter['id']) ?>" style="text-decoration: none; color: unset;">
                            <?= view('components/newsletter_card', ['name' => $newsletter['name'], 'date' => $newsletter['updated_at']]) ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</body>

</html>