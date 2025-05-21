<?php $this->extend('layouts/main') ?>
<?php $this->section('title') ?>Profil<?php $this->endSection() ?>

<?php $this->section('content') ?>

<?php
if (!empty($user)): ?>
    <h1>Profil</h1>
    <p>Förnamn: <?= esc($user['first_name']) ?></p>
    <p>Efternamn: <?= esc($user['last_name']) ?></p>
    <p>Email: <?= esc($user['email']) ?></p>
    <p>Registrerad: <?= esc($user['created_at']) ?></p>
<?php endif ?>

<form action="/logout" method="post">
    <button type="submit">Logga ut</button>
</form>

<h2>Inloggade enheter</h2>
<?php if (!empty($sessions)): ?>
    <ul>
        <?php foreach ($sessions as $session): ?>
            <li>
                <p>IP: <?= esc($session['ip_address']) ?></p>
                <p>Enhet: <?= esc($session['user_agent']) ?></p>
                <p>Senast Aktivitet: <?= esc($session['created_at']) ?></p>
            </li>
        <?php endforeach; ?>

    </ul>
    <form action="/logout-all" method="post">
        <button type="submit">Logga ut från alla enheter</button>
    </form>
<?php endif; ?>
<?php $this->endSection() ?>