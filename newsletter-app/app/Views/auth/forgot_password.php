<?= $this->extend('layouts/main'); ?>
<?= $this->section('title'); ?> Glömt lösenord? <?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<h2>Glömt lösenord</h2>
<p>Fyll i din e-postadress för att återställa ditt lösenord.</p>

<form action="/reset-password-email" method="POST">
    <label for="email">E-postadress:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <button type="submit">Skicka</button>
</form>

<?= $this->endSection(); ?>