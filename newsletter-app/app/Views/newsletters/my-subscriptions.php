<?php $this->extend('layouts/main') ?>
<?php $this->section('title') ?>Mina prenumerationer<?php $this->endSection() ?>
<?php $this->section('content') ?>

<h1 class="title">Mina prenumerationer</h1>

<?php if (empty($newsletters)): ?>
    <p>Du prenumererar inte på några nyhetsbrev.</p>
<?php else: ?>
    <ul class="newsletter-grid">
        <?php foreach ($newsletters as $newsletter): ?>
            <li><a href="<?= base_url('newsletters/' . $newsletter['id']) ?>" style="text-decoration: none; color: unset;">
                    <?= view('components/newsletter_card', ['name' => $newsletter['name'], 'date' => $newsletter['updated_at']]) ?>
                </a> </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php $this->endSection() ?>