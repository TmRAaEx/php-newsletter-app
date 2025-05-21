<?php $this->extend('layouts/main') ?>
<?php $this->section('title');
echo $message ?? "Meddelanden"; ?><?php $this->endSection() ?>
<?php $this->section('content') ?>

<?php if (!empty($message)): ?>
    <p><?= esc($message) ?></p>
<?php endif; ?>
<?php $this->endSection(); ?>

<!-- TODO: Refactor into a toaster notification -->