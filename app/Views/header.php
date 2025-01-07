<!-- <HTML>
    <body>
    <?php if (session()->get('isLoggedIn')): ?>
        <h1>Welcome, <?= esc(session()->get('username')) ?></h1>
        <p>Password: <?= esc(session()->get('password')) ?></p>
        <p>Name: <?= esc(session()->get('name')) ?></p>
        <p>Data Users:</p>
    <?php else: ?>
        <p>YOU ARE NOT LOGGED IN</p>
        <a href="/login">Login</a>
    <?php endif; ?> -->