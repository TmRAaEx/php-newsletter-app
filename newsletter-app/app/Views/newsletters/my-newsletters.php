<?php
$this->extend('layouts/main'); ?>
<?php $this->section('title'); ?>Mina Nyhetsbrev<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
<h1>Nyhetsbrev och prenumeranter</h1>

<?php if (empty($newsletters)): ?>
    <p>Du har inga nyhetsbrev.</p>
<?php else: ?>
    <?php foreach ($newsletters as $newsletter): ?>
        <h2 style="text-decoration: underline;"><?= esc($newsletter['name']) ?></h2>
        <a href="<?= base_url('newsletters/edit/' . $newsletter['id']) ?>">Redigera nyhetsbrev</a>
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
            <ul>
                <?php foreach ($newsletterSubscribers as $subscriber): ?>
                    <li><?= esc($subscriber['first_name'] . ' ' . $subscriber['last_name']) ?> (<?= esc($subscriber['email']) ?>)
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php $this->endSection(); ?>