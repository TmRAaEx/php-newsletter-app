<?php $this->extend('layouts/main') ?>
<?php $this->section('title') ?>Profil<?php $this->endSection() ?>

<?php $this->section('content') ?>

<?php
if (!empty($user)): ?>
    <h1 class="title">Välkommen <?= esc($user['first_name']) ?></h1>
    <h2>Uppgifter</h2>
    <div class="user-info">
        <p>Förnamn: <span><?= esc($user['first_name']) ?></span></p>
        <p>Efternamn: <span><?= esc($user['last_name']) ?></span></p>
        <p>Mejl address: <span><?= esc($user['email']) ?></span></p>
        <p>Registrerad: <span><?= esc($user['created_at']) ?></span></p>
    </div>
<?php endif ?>

<form action="/logout" method="post">
    <button class="logout" type="submit">Logga ut</button>
</form>

<h2>Inloggade enheter</h2>
<?php if (!empty($sessions)): ?>
    <ul class="session-list">
        <?php foreach ($sessions as $session): ?>
            <li class="session-card">
                <p>IP: <?= esc($session['ip_address']) ?></p>
                <p>Enhet: <?= esc($session['user_agent']) ?></p>
                <p>Senast Aktivitet: <?= esc($session['created_at']) ?></p>
            </li>
        <?php endforeach; ?>

    </ul>
    <form action="/logout-all" method="post">
        <button class="logout" type="submit">Logga ut från alla enheter</button>
    </form>
<?php endif; ?>
<?php $this->endSection() ?>