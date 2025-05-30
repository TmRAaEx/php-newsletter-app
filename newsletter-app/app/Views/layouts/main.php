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
                <!-- check if user is logged in -->
                <?php if (session('session_token')): ?>

                    <?php if (in_array('customer', session('user_roles'))): ?>
                        <li class="nav-link">
                            <a href=" <?= base_url('/newsletters/my-newsletters') ?>">
                                Mina nyhetsbrev
                            </a>
                        </li>
                    <?php endif;
                    if (in_array('subscriber', session('user_roles'))): ?>

                        <li class="nav-link">
                            <a href=" <?= base_url('/newsletters/my-subscriptions') ?>">
                                Mina prenumerationer
                            </a>
                        </li>
                    <?php endif; ?>
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
        <p id="copyright">&copy; <?= date('Y') ?> My Newsletter App</p>
    </footer>
</body>

</html>