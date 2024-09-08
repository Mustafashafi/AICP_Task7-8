<?php
session_start();
include 'db.php';

// Add Category Logic
if (isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];

    // Add category to database
    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->bind_param('s', $category_name);
    $stmt->execute();

    // Redirect to categories list or home page
    header('Location: categories.php');
    exit();
}

// Update Category Logic
if (isset($_POST['update_category'])) {
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];

    // Update category in the database
    $stmt = $conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
    $stmt->bind_param('si', $category_name, $category_id);
    $stmt->execute();

    // Redirect to categories list or home page
    header('Location: categories.php');
    exit();
}

// Delete Category Logic
if (isset($_GET['delete_category'])) {
    $category_id = $_GET['delete_category'];

    // Delete category from database
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param('i', $category_id);
    $stmt->execute();

    // Redirect to categories list or home page
    header('Location: categories.php');
    exit();
}
?>
