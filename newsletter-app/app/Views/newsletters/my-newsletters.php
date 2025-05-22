<?php
$this->extend('layouts/main'); ?>
<?php $this->section('title'); ?>Mina Nyhetsbrev<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
<h1 class="title">Nyhetsbrev och prenumeranter</h1>

<a href="<?= base_url('/newsletters/create') ?>" class="button-link"
    style="background-color: lightgray; margin-bottom: 20px;">
    <p style="font-size: var(--font-medium); color: black;">Skapa nyhetsbrev</p>
</a>

<?php if (empty($newsletters)): ?>
    <p>Du har inga nyhetsbrev.</p>
<?php else: ?>
    <?php foreach ($newsletters as $newsletter): ?>
        <?= view("components/newsletter_item", ['newsletter' => $newsletter]) ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php $this->endSection(); ?>