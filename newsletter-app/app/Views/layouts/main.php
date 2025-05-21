<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?></title>
    <link rel="stylesheet" href="<?= base_url('/css/styles.css') ?>">
</head>

<body>
    <aside id="sidebar">
        <nav>
            <ul class="nav-list">
                <li class="nav-link">
                    <a href=" <?= base_url('/') ?>">
                        Hem
                    </a>
                </li>
                <li class="nav-link">
                    <a href=" <?= base_url('/newsletters') ?>">
                        Nyhetsbrev
                    </a>
                </li>
                <?php if (session('session_token')): ?>
                    <li class="nav-link">
                        <a href=" <?= base_url('/profile') ?>">
                            Profil
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-link">
                        <a href=" <?= base_url('/login') ?>">
                            Logga in
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href=" <?= base_url('/register') ?>">
                            Registrera
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </aside>

    <main id="content">
        <?= $this->renderSection('content') ?>
    </main>

    <footer>
        <p>&copy; <?= date('Y') ?> My Newsletter App</p>
    </footer>
</body>

</html>