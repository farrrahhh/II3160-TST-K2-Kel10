<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediMart - Your Online Pharmacy</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        :root {
            --primary: #4066E0;
            --primary-dark: #333;
            --secondary: #E8EAF6;
            --text: #2C3E50;
            --text-light: #6B7C93;
            --background: #F8FAFC;
        }

        body {
            background-color: var(--background);
        }

        /* Navbar Styles */
        .navbar {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: var(--text);
            font-size: 1.5rem;
            font-weight: 600;
        }

        .logo-icon {
            color: var(--primary);
            font-size: 1.8rem;
        }

        .nav-middle {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
            justify-content: flex-start;
            text-align: left; 
            
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text);
            font-weight: 500;
            transition: color 0.3s;
            
        }

        .nav-links a:hover {
            color: var(--primary);
        }


        .nav-icons {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .nav-icon {
            color: var(--text);
            text-decoration: none;
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .nav-icon span {
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Hero Section */
        .hero {
            margin-top: 80px;
            padding: 4rem 2rem;
            position: relative; /* Agar pseudo-elemen ::after bekerja */
            background: url('<?= base_url("images/pict1.png") ?>') center/cover no-repeat;
            min-height: 500px;
            display: flex;
            align-items: center;
            justify-content: flex-start; /* Menjaga konten ke kiri */
            overflow: hidden;
        }

        /* Blur efek pada gambar latar */
        .hero::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%; /* Pastikan blur menutupi seluruh area */
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Warna overlay semi-transparan */
            z-index: 1; /* Letakkan di bawah teks */
        }

        /* Hero container untuk menampung konten */
        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative; /* Agar berada di atas blur */
            z-index: 2; /* Konten di atas pseudo-elemen */
            display: flex;
            flex-direction: column; /* Susunan konten secara vertikal */
            align-items: flex-start; /* Teks ke kiri */
        }

        /* Hero content */
        .hero-content {
            max-width: 500px;
        }

        /* Judul utama */
        .hero-title {
            font-size: 3.5rem;
            color: white;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        /* Subjudul */
        .hero-subtitle {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
        }

        .hero-button {
            display: inline-block;
            padding: 1rem 2rem;
            background: white;
            color: var(--primary);
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: transform 0.3s;
        }

        .hero-button:hover {
            transform: translateY(-2px);
        }

        /* Categories Section */
        .categories {
            padding: 4rem 2rem;
        }

        .categories-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 2rem;
            color: var(--text);
            margin-bottom: 2rem;
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .category-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }

        .category-card:hover {
            transform: translateY(-5px);
        }

        .category-image {
            width: 100%;
            height: 200px;
            background-size: cover;
            background-position: center;
        }

        .category-content {
            padding: 1.5rem;
        }

        .category-title {
            font-size: 1.2rem;
            color: var(--text);
            margin-bottom: 0.5rem;
        }

        .category-description {
            color: var(--text-light);
            font-size: 0.9rem;
        }
        .logo-icon{
            width: 50px;
            height: 50px;
        }
        .user-icon{
            width: 30px;
            height: 30px;
        }

        @media (max-width: 768px) {
            .nav-middle {
                display: none;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .categories-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="/" class="logo">
                <span class="logo-icon">
                    <!-- image -->
                    <img class="logo-icon" src="<?= base_url('images/icon.png') ?>" alt="My Icon">
                </span>
                MediMart
            </a>
            
            

            <div class="nav-icons">
            <a href="/transactions" class="nav-icon">
                     <span>Easy Diagnose</span>
                </a>
                <a href="/transactions" class="nav-icon">
                     <span>Your Transactions</span>
                </a>
                <a href="/profile" class="nav-icon">
                    <img class="user-icon" src="<?= base_url('images/User.png') ?>" alt="My Profile">
                
                </a>
            </div>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <h1 class="hero-title">Your Health, Our Priority</h1>
                <p class="hero-subtitle">Get your medicines and health supplies delivered right to your doorstep.</p>
                <a href="#" class="hero-button">Shop Now</a>
            </div>
        </div>
    </section>

    <section class="categories">
        <div class="categories-container">
            <h2 class="section-title">Shop By Category</h2>
            <div class="categories-grid">
                <div class="category-card">
                    <div class="category-image" style="background-image: url('<?php echo base_url('/images/medicine.png'); ?>')"></div>

                    <div class="category-content">
                        <h3 class="category-title">Medicines</h3>
                        <p class="category-description">Prescription and over-the-counter medicines</p>
                    </div>
                </div>
                
                <div class="category-card">
                <div class="category-image" style="background-image: url('<?php echo base_url('/images/vitamin.png'); ?>')"></div>
                    <div class="category-content">
                        <h3 class="category-title">Vitamins</h3>
                        <p class="category-description">Stay healthy with our range of vitamins</p>
                    </div>
                </div>
                
                <div class="category-card">
                <div class="category-image" style="background-image: url('<?php echo base_url('/images/supplement.png'); ?>')"></div>
                    <div class="category-content">
                        <h3 class="category-title">Supplements</h3>
                        <p class="category-description">Supplements boost health by providing essential nutrients your body needs.</p>
                    </div>
                </div>
                
                <div class="category-card">
                <div class="category-image" style="background-image: url('<?php echo base_url('/images/ointment.png'); ?>')"></div>
                    <div class="category-content">
                        <h3 class="category-title">Ointments</h3>
                        <p class="category-description">Ointments provide targeted relief and protection for the skin.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>