
<nav class="navbar navbar-expand-lg navbar-light site-navbar">
    <a class="navbar-brand site-brand" href="index.php">MelodyMine</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto align-items-lg-center">
            <?php if (isset($_SESSION['username'])): ?>
            <li class="nav-item">
                <span class="welcome-pill">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
            </li>
            <?php if ($_SESSION['role'] !== 'client'): ?>
            <li class="nav-item">
                <a class="nav-link nav-chip" href="admin_dashboard.php">Admin Dashboard</a>
            </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link nav-chip nav-chip-ghost" href="logout.php">Logout</a>
            </li>
            <?php else: ?>
            <li class="nav-item">
                <a class="nav-link nav-chip" href="login.php">Login</a>
            </li>
            <li class="nav-item">
                <a class="nav-link nav-chip nav-chip-ghost" href="register.php">Register</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>
