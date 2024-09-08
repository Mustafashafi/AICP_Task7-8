<?php
session_start();
include 'db.php';

// Add Business Logic
if(isset($_POST['add_business'])){
    $business_name = $_POST['business_name'];
    $category_id = $_POST['category'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];
    
    // Add business to database
    $stmt = $conn->prepare("INSERT INTO businesses (name, category_id, address, phone, description, user_id) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sssssi', $business_name, $category, $address, $phone, $description, $user_id);
    $stmt->execute();
    
    header('Location: home.php');
}
?>
