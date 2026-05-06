
<nav class="navbar navbar-expand-lg navbar-dark bg-seafoamgreen">
    <a class="navbar-brand nav-txt-color " href="#"><b style="margin-left:18px;font-size:22px">MelodyMine</b></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION['username'])): ?>
                 
                <li class="nav-item">
                    <a class="nav-link " style="margin-right:8px;font-size:20px" href="#">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</a>
                </li>
                <?php if ($_SESSION['role']!='client'): ?>
                <li class="nav-item">
                    <a class="nav-link " style="font-size:20px" href="admin_dashboard.php">Admin dashboard</a>
                </li>  
                <?php endif; ?> 
                <li class="nav-item">
                    <a class="nav-link " style="margin-left:8px;font-size:20px"href="logout.php">Logout</a>
                </li>
            <?php else: ?>
                <!-- <li class="nav-item">
                    <a class="nav-link nav-txt-color" href="login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-txt-color nav-link " href="register.php">Register</a>
                </li> -->
            <?php endif; ?>
        </ul>
    </div>
</nav>
