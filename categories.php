<?php
session_start();
include 'db.php';  // Ensure the database connection is included correctly

// Add Category Logic
if (isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
    $stmt->bind_param('s', $category_name);
    $stmt->execute();

    // Redirect back to category page after insertion
    header('Location: category.php');
    exit();
}

// Update Category Logic
if (isset($_POST['update_category'])) {
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];

    // Prepared statement for update
    $stmt = $conn->prepare("UPDATE categories SET name = ? WHERE id = ?");
    $stmt->bind_param('si', $category_name, $category_id);
    $stmt->execute();

    // Redirect after updating
    header('Location: category.php');
    exit();
}

// Delete Category Logic
if (isset($_GET['delete_category'])) {
    $category_id = $_GET['delete_category'];

    // Prepared statement for delete
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param('i', $category_id);
    $stmt->execute();

    // Redirect after deletion
    header('Location: category.php');
    exit();
}

// Fetch categories from database for listing
$result = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
</head>
<body>
    <h1>Manage Categories</h1>

    <!-- Add Category Form -->
    <form action="category.php" method="POST">
        <input type="text" name="category_name" placeholder="Category Name" required>
        <button type="submit" name="add_category">Add Category</button>
    </form>

    <!-- Update Category Form -->
    <?php if (isset($_GET['edit_category'])): ?>
        <?php
        // Fetch the category data to be updated
        $category_id = $_GET['edit_category'];
        $stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->bind_param('i', $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $category = $result->fetch_assoc();
        ?>
        <form action="category.php" method="POST">
            <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
            <input type="text" name="category_name" placeholder="Category Name" value="<?php echo $category['name']; ?>" required>
            <button type="submit" name="update_category">Update Category</button>
        </form>
    <?php endif; ?>

    <!-- List of Categories -->
    <h2>Existing Categories</h2>
    <ul>
        <?php while ($category = $result->fetch_assoc()): ?>
            <li>
                <?php echo $category['name']; ?>
                <a href="category.php?delete_category=<?php echo $category['id']; ?>">Delete</a>
                
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
