<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediMart - Your Online Pharmacy</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        /* Navbar styles */
        .navbar {
            padding: 1.5rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-icon {
            color: #4066E0;
            font-size: 24px;
            font-weight: bold;
        }

        .logo-text {
            color: #333;
            font-size: 24px;
            font-weight: bold;
        }
        .signup-btn {
            background: #4066E0;
            color: white;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            
            font-weight: 500;
        }

        .login-btn, .signup-btn {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            border: 2px solid #4066E0;
            border-radius: 5px;
            font-weight: bold;
            text-decoration: none;
            text-align: center;
            cursor: pointer;
            transition: background 0.3s;
        }
        .signup-btn {
            background-color: #4066E0;
            color: white;
        }

        .login-btn {
            background: transparent;
            color: #4066E0;
        }

        

        .signup-btn:hover {
            background: #335cbf;
        }

        

        .signup-btn:hover {
            background-color: #335cbf;
        }

        /* Hero section styles */
        .hero {
            padding: 8rem 5% 4rem;
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero-content {
            width: 50%;
            position: relative;
            z-index: 2;
        }

        .hero-tag {
            color: #4066E0;
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .hero-tag::before,
        .hero-tag::after {
            content: "";
            height: 1px;
            width: 30px;
            background: #4066E0;
        }

        .hero h1 {
            font-size: 3.5rem;
            color: #1a1a1a;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero h1 span {
            color: #4066E0;
        }

        .hero p {
            color: #666;
            font-size: 1.2rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
        }

        .cta-primary {
            background: #4066E0;
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s;
        }

        .cta-secondary {
            background: white;
            color: #4066E0;
            padding: 1rem 2rem;
            border: 1px solid #4066E0;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s;
        }

        /* Features section styles */
        .features {
            padding: 6rem 5%;
            text-align: center;
            background: white;
            
        }

        .features-title {
            color: #4066E0;
            font-size: 1rem;
            font-weight: bold;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .features-title::before,
        .features-title::after {
            content: "";
            height: 1px;
            width: 30px;
            background: #4066E0;
        }

        .features h2 {
            font-size: 2.5rem;
            color: #1a1a1a;
            margin-bottom: 4rem;
        }

        .features-grid {
            display: flex;
            justify-content: space-between;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .feature-card {
            flex: 1;
            min-width: 250px;
            text-align: center;
            position: relative;
        }

        .feature-icon {
            width: 120px;
            height: 120px;
            background: #f0f4ff;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #4066E0;
            position: relative;
        }

        .feature-number {
            position: absolute;
            top: 0;
            right: 0;
            background: #4066E0;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .feature-card h3 {
            color: #1a1a1a;
            margin-bottom: 1rem;
            font-size: 1.2rem;
        }

        .feature-card p {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .logo-icon {
            width: 45px;  
            height: 45px; 
        }

        /* About Us Section */
        .about-us {
            padding: 6rem 5%;
            text-align: center;
            background: #f8f9ff;
        }
        .about-us h2 {
            font-size: 2.5rem;
            color: #1a1a1a;
            margin-bottom: 1rem;
        }

        /* Footer styles */
        footer {
            padding: 2rem 5%;
            background: #4066E0;
            color: white;
            text-align: center;

        }

        footer a {
            color: white;
            text-decoration: none;
            margin: 0 1rem;
        }

        footer a:hover {
            text-decoration: underline;
        }
        

        /* Responsive styles */
        @media (max-width: 768px) {
            .navbar {
                padding: 1rem;
            }

            .nav-links {
                display: none;
            }

            .hero {
                padding: 6rem 1rem 2rem;
            }

            .hero-content {
                width: 100%;
                text-align: center;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .cta-buttons {
                justify-content: center;
            }

            .features-grid {
                flex-direction: column;
                align-items: center;
            }

            .feature-card {
                max-width: 300px;
            }
            .hero-image{
                display: none;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="#" class="logo">
            <span class="logo-icon">
                <img class="logo-icon" src="<?= base_url('images/icon.png') ?>" alt="My Icon">
            </span>
            <span class="logo-text">MediMart</span>
        </a>
        <div class="nav-links">
            <a href="#features">Features</a>
            <a href="#about-us">About Us</a>
            <a href="/MediMart/login" class="login-btn">Login</a>
            <a href="/MediMart/register" class="signup-btn">Sign-Up</a>
        </div>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <div class="hero-tag">JOIN THE REVOLUTION</div>
            <h1>The #1 Online <span>Medicine</span> Platform for Your Health</h1>
            <p>Your trusted partner in healthcare, delivering medicines and wellness products right to your doorstep.</p>
            <div class="cta-buttons">
                <button class="cta-primary">Get Started Now →</button>
                <button class="cta-secondary">Explore Products</button>
            </div>
        </div>
        <div class="hero-image">
        <img src="<?= base_url('images/hero-image.png') ?>" alt="Hero Image" style="width: 80%; position: absolute; right: -200px; bottom: 0;">
        </div>
        

    </section>

    <section class="features">
        <div class="features-title">FEATURES</div>
        <h2>MediMart: Your Health, Our Priority</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">💊
                    <div class="feature-number">01</div>
                </div>
                <h3>Product Management</h3>
                <p>Pharmacies can manage their product catalog, including adding new medicines, updating stock, and editing product details like price and description.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🚚
                    <div class="feature-number">02</div>
                </div>
                <h3>Seamless Ordering</h3>
                <p>Customers can add medicines to their cart, check real-time stock availability, and complete orders with ease.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">👨‍⚕️
                    <div class="feature-number">03</div>
                </div>
                <h3>Secure Payment</h3>
                <p>Payments are processed through QRIS, allowing customers to pay using any e-wallet or bank. Customers can track their payment status and view transaction history.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📱
                    <div class="feature-number">04</div>
                </div>
                <h3>User Authentication</h3>
                <p>Ensures data security by requiring users to log in before accessing services like order history, keeping user data private and safe.</p>
            </div>
        </div>
    </section>

    <section class="about-us">
        <div class="features-title">ABOUT US</div>
        <h2>Welcome to MediMart</h2>
        
        <p style="margin: 2rem 0; color: #666; font-size: 1rem; line-height: 1.8;">
            At MediMart, we believe that everyone deserves easy access to quality healthcare. 
            Our mission is to deliver top-quality medicines and wellness products with convenience and reliability.
            With our expert pharmacists, fast delivery services, and a user-friendly platform, 
            we are committed to being your trusted partner in health.
        </p>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 MediMart | Farah Aulia </p>
    </footer>
</body>
</html>
