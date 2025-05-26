<?= $this->extend('layouts/main'); ?>
<?= $this->section('title'); ?> Skapa konto <?= $this->endSection(); ?>

<?= $this->section('content'); ?>

<h2>Skapa konto</h2>

<?php if (!empty($errors)): ?>
    <div class="error" style=" color: #721c24; padding: 1rem; border-radius: 0.5rem;">
        <ul>
            <?php foreach ($errors as $field => $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="<?= site_url('register') ?>" style="display: flex; flex-direction: column; gap: 1rem;">
    <?= csrf_field() ?>

    <label for="first_name">Förnamn</label>
    <input type="text" name="first_name" id="first_name" value="<?= old('first_name') ?>">

    <label for="last_name">Efternamn</label>
    <input type="text" name="last_name" id="last_name" value="<?= old('last_name') ?>">

    <label for="email">E-postadress</label>
    <input type="email" name="email" id="email" value="<?= old('email') ?>">

    <label for="password">Lösenord</label>
    <input type="password" name="password" id="password">
    <label for="password">Bekräfta Lösenord</label>
    <input type="password" name="password_confirm" id="password_confirm">

    <div>
        <p>Välj roll(er):</p>
        <?php foreach ($roles as $role): ?>
            <label style="display: flex; align-items: center; gap: 0.5rem;">
                <input type="checkbox" name="roles[]" value="<?= esc($role['id']) ?>" <?= (is_array(old('roles')) && in_array($role['id'], old('roles'))) ? 'checked' : '' ?>>
                <?= esc($role['name']) ?>
            </label>
        <?php endforeach; ?>
    </div>

    <button type="submit">Registrera</button>
    <p>Har du redan ett konto? <a href="<?= site_url('login') ?>" style="color: blue; text-decoration: underline;">Logga
            in här</a></p>
</form>

<?= $this->endSection(); ?>