<?php
// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Business Information App</title>
    <link rel="stylesheet" href="/assets/css/style.css"> <!-- Link to your CSS file -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Navigation Bar -->
    <header>
        <nav class="navbar">
            <div class="container">
                <a href="index.php" class="logo">Business Info</a>
                <ul class="nav-menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="categories.php">Categories</a></li>
                    <li><a href="search.php">Search</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li><a href="profile.php">My Profile</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="signup.php">Sign Up</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>

    <style>
    /* Reset body margin and padding */
    body, html {
        margin: 0;
        padding: 0;
    }

    /* Navigation bar styling */
    .navbar {
        background-color: #007BFF;
        padding: 15px;
        margin: 0; /* Ensure no margin around the header */
    }

    .navbar .logo {
        color: white;
        font-size: 1.5rem;
        text-decoration: none;
    }

    .nav-menu {
        list-style: none;
        float: right;
    }

    .nav-menu li {
        display: inline-block;
        margin-left: 20px;
    }

    .nav-menu li a {
        color: white;
        text-decoration: none;
        font-size: 1rem;
    }

    .nav-menu li a:hover {
        color: #ffcc00;
    }
</style>

