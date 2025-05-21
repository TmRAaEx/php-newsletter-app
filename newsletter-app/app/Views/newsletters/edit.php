<?php
$this->extend('layouts/main'); ?>


<?php $this->section('title') ?>Redigera nyhetsbrev<?php $this->endSection() ?>
<?php $this->section('content') ?>
<?php if (!empty($error)): ?>
    <h1>
        <?= $error ?>
    </h1>
<?php endif; ?>

<?php if (!empty($newsletter)): ?>
    <h1>Redigera nyhetsbrev: <?= esc($newsletter['name']) ?></h1>
    <form  class="edit-form" action="<?= base_url('newsletters/edit/' . $newsletter['id']) ?>" method="post">
        <label for="name">Namn:</label>
        <input type="text" name="name" value="<?= $newsletter['name'] ?>">
        <label for="description">Beskrivning:</label>
        <input type="text" name="description" value="<?= $newsletter['description'] ?>">

        <button class="button-link" type="submit">Redigera</button>
    </form>
<?php endif; ?>
<?php $this->endSection() ?>