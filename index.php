<?php
// Start session and include necessary files
session_start();
include 'db.php';
include 'header.php';

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    header('Location:home.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Information App</title>
    <link rel="stylesheet" href="assets/css/style.css"> <!-- Add custom styles here -->
</head>
<body>
    <!-- Splash Screen -->
    <section class="splash-screen">
        <div class="container1">
            <h1>Welcome to the Business Directory</h1>
            <p>Find the best businesses in your area with ease.</p>
            <a href="login.php" class="btn">Login</a>
            <a href="signup.php" class="btn">Sign Up</a>
        </div>
    </section>

    <style>
        /* Example inline CSS for simplicity */
        .splash-screen {
            height: 70vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f4f4f4;
            text-align: center;
        }

        .container1 {
            background-color: #fff;
            padding: 50px;
            box-shadow: 0px 5px 15px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            margin: 10px;
            padding: 15px 25px;
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        p {
            font-size: 1.2rem;
            color: #555;
        }
    </style>

    <?php include 'footer.php'; ?>
</body>
</html>
