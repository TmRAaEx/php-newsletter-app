<?php $this->extend('layouts/main'); ?>

<?php $this->section('title') ?>Nyhetsbrev<?php $this->endSection() ?>
<?php $this->section('content') ?>

<?php if (isset($newsletter)): ?>
    <h1 class="title"><?= esc($newsletter['name']) ?></h1>
    <p class="newsletter-description"><?= esc($newsletter['description']) ?></p>

    <?php if (!$isSubscribed): ?>
        <form action="<?= base_url('newsletters/subscribe') ?>" method="post">
            <input type="hidden" name="newsletter_id" value="<?= esc($newsletter['id']) ?>">
            <input type="hidden" name="user_id" value="<?= esc(session('user_id')) ?>">
            <button class="subscribe-button" type="submit">Prenumerera</button>
        </form>
    <?php else: ?>

        <form action="<?= base_url('newsletters/unsubscribe') ?>" method="post">
            <input type="hidden" name="newsletter_id" value="<?= esc($newsletter['id']) ?>">
            <input type="hidden" name="user_id" value="<?= esc(session('user_id')) ?>">
            <button class="unsubscribe-button" type="submit">Avsluta prenumeration</button>
        </form>
    <?php endif; ?>
<?php endif; ?>
<?php $this->endSection(); ?>