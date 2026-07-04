<?php
require_once 'config/database.php';
require_once 'config/auth.php';

if (isLoggedIn()) {
    header('Location: index.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = sanitize($_POST['username'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    if (empty($username) || empty($email) || empty($password)) {
        $error = 'All fields are required';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters';
    } else {
        try {
            if ($db->registerUser($username, $email, $password)) {
                $success = 'Account created successfully! <a href="login.php">Login here</a>';
            } else {
                $error = 'Username or email already exists';
            }
        } catch (Exception $e) {
            $error = 'Error registering account';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Beauty Haven</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .auth-container {
            max-width: 500px;
            margin: 3rem auto;
            padding: 2rem;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .auth-form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .auth-form input {
            padding: 0.8rem;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
            transition: 0.3s;
        }

        .auth-form input:focus {
            outline: none;
            border-color: #667eea;
        }

        .auth-links {
            text-align: center;
            margin-top: 1rem;
        }

        .auth-links a {
            color: #667eea;
            text-decoration: none;
        }

        .auth-links a:hover {
            text-decoration: underline;
        }

        .message {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="logo">💄 Beauty Haven</div>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </div>
    </nav>

    <div class="auth-container">
        <h2>Create Account</h2>
        
        <?php if ($error): ?>
            <div class="message error"><?= $error ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="message success"><?= $success ?></div>
        <?php else: ?>
            <form method="POST" class="auth-form">
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <button type="submit" class="btn-primary">Sign Up</button>
            </form>
        <?php endif; ?>
        
        <div class="auth-links">
            Already have an account? <a href="login.php">Login here</a>
        </div>
    </div>
</body>
</html>
