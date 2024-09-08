<?php
session_start();
include 'db.php'; // Ensure this file connects to your database

// Fetch categories and cities for the filter options
$categories_result = mysqli_query($conn, "SELECT * FROM categories");
$cities_result = mysqli_query($conn, "SELECT DISTINCT address FROM businesses");

// Initialize the base query to fetch businesses
$search_query = "SELECT * FROM businesses WHERE 1=1";

// Initialize an array for parameters
$params = [];
$types = "";

// Check if the search form is submitted
if (isset($_GET['search'])) {
    // Get the filter inputs
    $search_term = $_GET['search_term'] ?? '';
    $category_id = $_GET['category_id'] ?? '';
    $city = $_GET['city'] ?? '';

    // Filter by business name
    if (!empty($search_term)) {
        $search_query .= " AND name LIKE ?";
        $params[] = "%" . $search_term . "%";
        $types .= "s";
    }

    // Filter by category
    if (!empty($category_id)) {
        $search_query .= " AND category_id = ?";
        $params[] = $category_id;
        $types .= "i";
    }

    // Filter by city
    if (!empty($city)) {
        $search_query .= " AND address LIKE ?";
        $params[] = "%" . $city . "%";
        $types .= "s";
    }
}

// Prepare the SQL statement
$stmt = mysqli_prepare($conn, $search_query);

// Bind parameters if there are any
if (!empty($params)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}

// Execute the query
mysqli_stmt_execute($stmt);

// Fetch the results
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Businesses</title>
</head>
<body>

    <h1>Search Businesses</h1>

    <!-- Search and Filter Form -->
    <form action="search.php" method="GET">
        <input type="text" name="search_term" placeholder="Search by name" value="<?php echo isset($_GET['search_term']) ? htmlspecialchars($_GET['search_term']) : ''; ?>">
        
        <!-- Category Filter -->
        <select name="category_id">
            <option value="">Select Category</option>
            <?php while ($category = mysqli_fetch_assoc($categories_result)): ?>
                <option value="<?php echo htmlspecialchars($category['id']); ?>" <?php if (isset($_GET['category_id']) && $_GET['category_id'] == $category['id']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($category['name']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <!-- City Filter -->
        <select name="city">
            <option value="">Select City</option>
            <?php while ($city = mysqli_fetch_assoc($cities_result)): ?>
                <option value="<?php echo htmlspecialchars($city['address']); ?>" <?php if (isset($_GET['city']) && $_GET['city'] == $city['address']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($city['address']); ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit" name="search">Search</button>
    </form>

    <!-- Display Search Results -->
    <h2>Business Results</h2>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <ul>
            <?php while ($business = mysqli_fetch_assoc($result)): ?>
                <li>
                    <h3><?php echo htmlspecialchars($business['name']); ?></h3>
                    <p><?php echo htmlspecialchars($business['description']); ?></p>
                    <p>Category: 
                        <?php
                        // Get category name based on category_id
                        $category_result = mysqli_query($conn, "SELECT name FROM categories WHERE id = '" . mysqli_real_escape_string($conn, $business['category_id']) . "'");
                        if ($category_result && mysqli_num_rows($category_result) > 0) {
                            $category = mysqli_fetch_assoc($category_result);
                            echo htmlspecialchars($category['name']);
                        } else {
                            echo "No category";
                        }
                        ?>
                    </p>

                    <p>Location: <?php echo htmlspecialchars($business['address']); ?></p>
                    <p>Phone: <?php echo htmlspecialchars($business['phone']); ?></p>
                </li>
            <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No businesses found.</p>
    <?php endif; ?>

</body>
</html>
