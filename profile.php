<?php
session_start();
include 'db.php';  // Database connection file

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Get the logged-in user's data
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

// Fetch the user's businesses if they are a business admin
$businesses_sql = "SELECT * FROM businesses WHERE user_id = ?";
$stmt = $conn->prepare($businesses_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$businesses_result = $stmt->get_result();

// Fetch the user's reviews
$reviews_sql = "SELECT r.*, b.name as business_name FROM reviews r 
                JOIN businesses b ON r.business_id = b.id 
                WHERE r.user_id = ?";
$stmt = $conn->prepare($reviews_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$reviews_result = $stmt->get_result();

// Fetch the user's favorited businesses
$favorites_sql = "SELECT b.* FROM user_favorites uf 
                  JOIN businesses b ON uf.business_id = b.id 
                  WHERE uf.user_id = ?";
$stmt = $conn->prepare($favorites_sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$favorites_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>

    <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
    <p>Email: <?php echo htmlspecialchars($user['email']); ?></p>

    <!-- Edit Profile Form -->
    <h2>Edit Profile</h2>
    <form action="update_profile.php" method="POST">
        <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        <button type="submit">Update Profile</button>
    </form>

    <!-- Display User's Businesses (if any) -->
    <h2>Your Businesses</h2>
    <?php if ($businesses_result->num_rows > 0): ?>
        <ul>
            <?php while ($business = $businesses_result->fetch_assoc()): ?>
                <li>
                    <strong><?php echo htmlspecialchars($business['name']); ?></strong><br>
                    Category: <?php echo htmlspecialchars($business['category_id']); ?><br>
                    Location: <?php echo htmlspecialchars($business['address']); ?><br>
                    Phone: <?php echo htmlspecialchars($business['phone']); ?><br>
                    <a href="edit_business.php?business_id=<?php echo $business['id']; ?>">Edit</a> | 
                    <a href="delete_business.php?business_id=<?php echo $business['id']; ?>">Delete</a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>You have no businesses listed.</p>
    <?php endif; ?>

    <!-- Display User's Reviews -->
    <h2>Your Reviews</h2>
    <?php if ($reviews_result->num_rows > 0): ?>
        <ul>
            <?php while ($review = $reviews_result->fetch_assoc()): ?>
                <li>
                    <strong>Reviewed <?php echo htmlspecialchars($review['business_name']); ?></strong><br>
                    Rating: <?php echo htmlspecialchars($review['rating']); ?>/5<br>
                    Comment: <?php echo htmlspecialchars($review['comment']); ?><br>
                    <a href="edit_review.php?review_id=<?php echo $review['id']; ?>">Edit</a> | 
                    <a href="delete_review.php?review_id=<?php echo $review['id']; ?>">Delete</a>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>You haven't left any reviews yet.</p>
    <?php endif; ?>

    <!-- Display User's Favorited Businesses -->
    <h2>Your Favorite Businesses</h2>
    <?php if ($favorites_result->num_rows > 0): ?>
        <ul>
            <?php while ($favorite = $favorites_result->fetch_assoc()): ?>
                <li>
                    <strong><?php echo htmlspecialchars($favorite['name']); ?></strong><br>
                    Category: <?php echo htmlspecialchars($favorite['category_id']); ?><br>
                    Location: <?php echo htmlspecialchars($favorite['address']); ?><br>
                    Phone: <?php echo htmlspecialchars($favorite['phone']); ?><br>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>You haven't favorited any businesses yet.</p>
    <?php endif; ?>

</body>
</html>
