
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediMart - Your Online Pharmacy</title>
    <link rel="stylesheet" href="<?= base_url('css/style2.css') ?>">
   
    
</head>

<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="#" class="logo">
                <span class="logo-icon">
                    <img class="logo-icon" src="<?= base_url('images/icon.png') ?>" alt="My Icon">
                </span>
                MediMart
            </a>
            <div class="nav-icons">
                <a href="/transactions" class="nav-icon">Easy Diagnose</a>
                <a href="/transactions" class="nav-icon">Your Transactions</a>
                <div class="profile-container" onclick="toggleDropdown()">
                    <img class="user-icon" src="<?= base_url('images/User.png') ?>" alt="Profile">
                    <div id="dropdown-menu" class="dropdown-menu hidden">
                        <a href="/MediMart/logout">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

      



</body>
</html>