<?php
session_start();
include 'db.php';

// Registration Logic
if(isset($_POST['register'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $city = $_POST['city'];
    $address = $_POST['address'];
    
    // Check if email already exists
    $check_email = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check_email->bind_param('s', $email);
    $check_email->execute();
    $result = $check_email->get_result();
    
    if($result->num_rows == 0){
        $stmt = $conn->prepare("INSERT INTO users (name, email, password, city, address) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param('sssss', $name, $email, $password, $city, $address);
        $stmt->execute();
        header('Location: login.php');
    } else {
        echo "Email already exists.";
    }
}

// Login Logic
if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if(password_verify($password, $user['password'])){
        $_SESSION['user_id'] = $user['id'];
        header('Location:home.php');
    } else {
        echo "Invalid credentials.";
    }
}

// Logout Logic
if(isset($_GET['logout'])){
    session_destroy();
    header('Location: login.php');
}
?>
