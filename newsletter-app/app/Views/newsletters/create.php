<?php $this->extend('layouts/main'); ?>

<?php $this->section('title'); ?>Skapa nyhetsbrev<?php $this->endSection(); ?>
<?php $this->section('content'); ?>

<h1 class="title">Skapa nyhetsbrev</h1>

<form action="<?= base_url('/newsletters/create') ?>" method="post">
    <input type="text" name="name" placeholder="Nyhetsbrevets namn" required>
    <input type="text" name="description" placeholder="Nyhetsbrevets beskrivning" required>
    <button type="submit" class="submit-button">Skapa</button>
</form>



<?php $this->endSection(); ?>   