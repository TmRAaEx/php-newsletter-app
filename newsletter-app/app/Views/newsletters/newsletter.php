<?php $this->extend('layouts/main'); ?>

<?php $this->section('title') ?>Nyhetsbrev<?php $this->endSection() ?>
<?php $this->section('content') ?>

<?php if (isset($newsletter)): ?>
    <h1><?= esc($newsletter['name']) ?></h1>
    <p><?= esc($newsletter['description']) ?></p>


    <form action="<?= base_url('newsletters/subscribe') ?>" method="post">
        <input type="hidden" name="newsletter_id" value="<?= esc($newsletter['id']) ?>">
        <input type="hidden" name="user_id" value="<?= esc(session('user_id')) ?>">
        <button type="submit">Subscribe</button>
    <?php endif; ?>

    <?php $this->endSection() ?>