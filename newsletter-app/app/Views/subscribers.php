<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prenumeranter</title>
</head>

<body>
    <h1>Nyhetsbrev och prenumeranter</h1>

    <?php if (empty($newsletters)): ?>
        <p>Du har inga nyhetsbrev.</p>
    <?php else: ?>
        <?php foreach ($newsletters as $newsletter): ?>
            <h2><?= esc($newsletter['name']) ?></h2>
            <p><?= esc($newsletter['description'] ?? 'Ingen beskrivning tillgänglig.') ?></p>

            <?php
            // Filtrera prenumerationer för detta nyhetsbrev
            $newsletterSubscriptions = array_filter($subscriptions, function ($subscription) use ($newsletter) {
                return $subscription['newsletter_id'] === $newsletter['id'];
            });

            // Hämta användare för dessa prenumerationer
            $newsletterSubscribers = array_filter($subscribers, function ($subscriber) use ($newsletterSubscriptions) {
                $subscriberIds = array_column($newsletterSubscriptions, 'user_id');
                return in_array($subscriber['id'], $subscriberIds);
            });
            ?>

            <?php if (empty($newsletterSubscribers)): ?>
                <p>Inga prenumeranter för detta nyhetsbrev.</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($newsletterSubscribers as $subscriber): ?>
                        <li><?= esc($subscriber['first_name'] . ' ' . $subscriber['last_name']) ?> (<?= esc($subscriber['email']) ?>)
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
</body>

</html>