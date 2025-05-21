    <h2 class="newsletter-name"><?= esc($newsletter['name']) ?></h2>

    <a class="button-link" href="<?= base_url('newsletters/edit/' . $newsletter['id']) ?>">Redigera nyhetsbrev</a>
    <?php
    // Filter subscriptions for the current newsletter
    $newsletterSubscriptions = array_filter($subscriptions, function ($subscription) use ($newsletter) {
        return $subscription['newsletter_id'] === $newsletter['id'];
    });

    // get all subscribers for the current newsletter
    $newsletterSubscribers = array_filter($subscribers, function ($subscriber) use ($newsletterSubscriptions) {
        $subscriberIds = array_column($newsletterSubscriptions, 'user_id');
        return in_array($subscriber['id'], $subscriberIds);
    });
    ?>

    <?php if (empty($newsletterSubscribers)): ?>
        <p>Inga prenumeranter för detta nyhetsbrev.</p>
    <?php else: ?>
        <p style="font-size: var(--font-small);"> prenumeranter:</p>
        <ul class="newsletter-subscribers">
            <?php foreach ($newsletterSubscribers as $subscriber): ?>
                <li><?= esc($subscriber['first_name'] . ' ' . $subscriber['last_name']) ?> (<?= esc($subscriber['email']) ?>)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>