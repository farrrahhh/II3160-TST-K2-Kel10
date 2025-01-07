<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to Medshot</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            margin: 0;
            height: 100vh;
        }
        .image-container {
            flex: 1;
            background-image: url('<?= base_url('assets/images/medical-background.jpg') ?>');
            background-size: cover;
            background-position: center;
        }
        .login-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2rem;
        }
        h1 {
            color: #336699;
            margin-bottom: 0.5rem;
        }
        p {
            color: #666;
            margin-bottom: 2rem;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #336699;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .forgot-password {
            text-align: right;
            margin-bottom: 1rem;
        }
        .forgot-password a {
            color: #336699;
            text-decoration: none;
        }
        .login-button {
            width: 100%;
            padding: 0.75rem;
            background-color: #336699;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .or-divider {
            text-align: center;
            margin: 1rem 0;
            color: #666;
        }
        .social-login {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .social-login button {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .social-login img {
            width: 20px;
            height: 20px;
            margin-right: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="image-container"></div>
    <div class="login-container">
        <h1>Login to Medshot</h1>
        <p>Enter your credentials to access your account</p>
        
        <?= form_open('auth/login') ?>
            <div>
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required placeholder="Enter your email">
            </div>
            <div>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter your password">
            </div>
            <div class="forgot-password">
                <a href="<?= site_url('auth/forgot_password') ?>">Forget Password?</a>
            </div>
            <button type="submit" class="login-button">Login</button>
        <?= form_close() ?>

        <div class="or-divider">OR</div>

        <div class="social-login">
            <button>
                <img src="<?= base_url('assets/images/google-icon.png') ?>" alt="Google">
                Login with Google
            </button>
            <button>
                <img src="<?= base_url('assets/images/apple-icon.png') ?>" alt="Apple">
                Login with Apple
            </button>
            <button>
                <img src="<?= base_url('assets/images/facebook-icon.png') ?>" alt="Facebook">
                Login with Facebook
            </button>
        </div>
    </div>
</body>
</html>