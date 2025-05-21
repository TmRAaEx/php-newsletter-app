<?php $this->extend('layouts/main'); ?>

<?php $this->section('title') ?>Nyhetsbrev<?php $this->endSection() ?>
<?php $this->section('content') ?>



<h1 class="title">Nyhetsbrev</h1>
<?php if (!empty($newsletters)): ?>
    <div class="newsletters">
        <ul class="newsletter-grid">
            <?php foreach ($newsletters as $field => $newsletter): ?>
                <li class="newletter-item">
                    <a href="<?= base_url('newsletters/' . $newsletter['id']) ?>" style="text-decoration: none; color: unset;">
                        <?= view('components/newsletter_card', ['name' => $newsletter['name'], 'date' => $newsletter['updated_at']]) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php $this->endSection() ?>