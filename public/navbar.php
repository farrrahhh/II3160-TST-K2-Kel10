<nav class="navbar">
    <div class="nav-container">
        <a href="/MediMart/user/dashboard" class="logo">
            <span class="logo-icon">
                <img class="logo-icon" src="<?= base_url('images/icon.png') ?>" alt="My Icon">
            </span>
            MediMart
        </a>
        <div class="nav-icons">
            <a href="/MediMart/user/dashboard" class="nav-icon">Easy Diagnose</a>
            <a href="/MediMart/user/transactions" class="nav-icon">Your Transactions</a>
            <!-- Profil dengan Dropdown -->
            <div class="profile-container" onclick="toggleDropdown()">
                <img class="user-icon" src="<?= base_url('images/User.png') ?>" alt="Profile">
                <div id="dropdown-menu" class="dropdown-menu hidden">
                    <a href="/MediMart/logout">Logout</a>
                </div>
            </div>
        </div>
    </div>
</nav>