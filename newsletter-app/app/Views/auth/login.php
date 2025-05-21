<?= $this->extend('layouts/main'); ?>
<?= $this->section('title'); ?> Logga in <?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<style> 
    .error {
        color: red;
    }

    label {
        display: block;
        margin-top: 1em;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        width: 100%;
        padding: 0.5em;
        margin-top: 0.3em;
    }

    button {
        margin-top: 1.5em;
        padding: 0.5em 1em;
    }
</style>

<h2>Logga in</h2>

<?php if (!empty($error)): ?>
    <div class="error">
        <p><?= esc($error) ?></p>
    </div>
<?php endif; ?>

<?php if (!empty($message)): ?>
    <div class="message">
        <p><?= esc($message) ?></p>
    </div>
<?php endif; ?>

<form method="post" action="<?= site_url('login') ?>">
    <label for="email">Email</label>
    <input type="text" name="email" id="email" value="<?= old('email') ?>">
    <label for="password">Lösenord</label>
    <input type="password" name="password" id="password">
    <button type="submit">Logga in</button>
    <p>Glömt lösenord? <a href="<?= site_url('forgot-password') ?>">Återställ lösenord</a></p>
    <p>Har du inget konto? <a href="<?= site_url('register') ?>">Registrera dig här</a></p>
</form>
<?= $this->endSection(); ?>