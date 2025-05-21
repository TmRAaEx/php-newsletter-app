<?= $this->extend('layouts/main'); ?>
<?= $this->section('title'); ?> Skapa konto <?= $this->endSection(); ?>

<?= $this->section('content'); ?>




    <h2>Skapa konto</h2>

    <?php if (!empty($errors)):
        ?>
        <div class="error">
            <ul>
                <?php foreach ($errors as $field => $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= site_url('register') ?>">
        <?= csrf_field() ?>

        <label for="first_name">Förnamn</label>
        <input type="text" name="first_name" id="first_name" value="<?= old('first_name') ?>">

        <label for="last_name">Efternamn</label>
        <input type="text" name="last_name" id="last_name" value="<?= old('last_name') ?>">

        <label for="email">E-postadress</label>
        <input type="email" name="email" id="email" value="<?= old('email') ?>">

        <label for="password">Lösenord</label>
        <input type="password" name="password" id="password">

        <label for="role_id">Välj roll</label>
        <select name="role_id" id="role_id">
            <?php foreach ($roles as $role): ?>
                <option value="<?= esc($role['id']) ?>" <?= old('role_id') == $role['id'] ? 'selected' : '' ?>>
                    <?= esc($role['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>


        <button type="submit">Registrera</button>
        <p>Har du redan ett konto? <a href="<?= site_url('login') ?>">Logga in här</a></p>
    </form>

    <?= $this->endSection(); ?>