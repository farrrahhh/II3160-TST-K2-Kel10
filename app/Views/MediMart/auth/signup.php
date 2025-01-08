<!-- Login Page - app/Views/auth/login.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MediMart</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
        }

        .left-section {
            flex: 1;
            position: relative;
            overflow: hidden;
        }

        .left-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('<?= base_url("images/pict.png") ?>') center/cover no-repeat;
            z-index: 1;
        }

        /* make the picture is covered a grey blur */
        .left-section::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 2;
        }

        

        .left-content {
            position: relative;
            z-index: 3; /* Di atas overlay hitam */
            color: white;
            text-align: center;
            padding: 2rem;
        }

        .right-section {
            flex: 1;
            padding: 2rem 4rem;
            display: flex;
            flex-direction: column;
        }

        .logo {
            position: absolute;
            top: 2rem;
            right: 2rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            color: #333;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .logo-icon {
            color: #4066E0;
            font-size: 2rem;
        }

        h1 {
            font-size: 3.5rem;
            color: #4066E0;
            margin-bottom: 1rem;
        }

        .subtitle {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 2rem;
        }

        .illustration {
            min-width: 80%;
            margin: 2rem auto;
        }

        .form-container {
            max-width: 400px;
            width: 100%;
            margin: auto;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            font-size: 1rem;
        }

        input:focus {
            outline: none;
            border-color: #4066E0;
        }

        .password-input {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #666;
            cursor: pointer;
        }

        .signup-button {
            width: 100%;
            padding: 0.75rem;
            background-color: #4066E0;
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            margin-top: 1rem;
        }

        .signup-button:hover {
            background-color: #9fa8da;
        }

        .links {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
        }

        .links a {
            color: #4066E0;
            text-decoration: none;
        }

        .links a:hover {
            text-decoration: underline;
        }
        .logo-icon {
            width: 45px;  
            height: 45px; 
        }


        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .left-section {
                display: none;
            }

            .right-section {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <section class="left-section">
        
    </section>

    <section class="right-section">
        <a href="/MediMart" class="logo">
            <span class="logo-icon">
                <img class="logo-icon" src="<?= base_url('images/icon.png') ?>" alt="My Icon">
            </span>
            MediMart
        </a>

        <div class="form-container">
           
            <h1>Join Us!</h1>
            <p class="subtitle">Create an account to start shopping</p>
            
            <form action="/MediMart/register" method="POST">
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" placeholder="Enter your full name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Create a password" required>
                </div>

                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm_password" placeholder="Re-enter your password" required>
                </div>

                <button type="submit" class="signup-button">Sign Up</button>

                <div class="links">
                    <a href="/MediMart/login">Already have an account? Log in</a>
                </div>
            </form>
        </div>
    </section>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
    </script>
</body>
</html>

