<?php
session_start();
require_once "config.php"; // Reuse your SIPLookUP config.php

// Default query to fetch all products
$sql = "SELECT id, name, category, motor, range_val, features, connectivity FROM products";
$conditions = [];
$params = [];

// Search functionality
if (!empty($_GET["search"])) {
    $search = trim($_GET["search"]);
    $conditions[] = "(name LIKE :search OR category LIKE :search OR features LIKE :search OR connectivity LIKE :search)";
    $params[":search"] = "%$search%";
}

// Filter by category
if (!empty($_GET["category"])) {
    $category = $_GET["category"];
    $conditions[] = "category = :category";
    $params[":category"] = $category;
}

// Build query with conditions
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}
$sql .= " ORDER BY id DESC";

$stmt = $conn->prepare($sql);
foreach ($params as $key => $value) {
    $stmt->bindValue($key, $value);
}
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/e3831a00ca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="assets/css/style.css">
    <title>SIPLookUp</title>
</head>
<style>
    .filter-bar a.active { font-weight: bold; color: #007bff; } /* Highlight active filter */
</style>
<body>
    <div class="sl-container col-100 common">
        <div class="sl-main col-100 common align flex-col">
            <div class="navigation col-100 common-bet">
                <div class="nav-logo col-20 common align">
                    <a href="home.php">SIPLookUp</a>
                </div>
                <div class="nav-links col-50 common-even align">
                    <a href="home.php">Home</a>
                    <a href="products.php" class="active">Products</a>
                    <a href="compare.php">Compare</a>
                    <a href="contact.php">Contact</a>
                    <a href="profile.php">Profile</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
            <div class="products-main col-100 common" style="padding-top:35pc;">
                <div class="products col-100 common flex-col align">
                    <h2>Products</h2>
                    <form action="products.php" method="GET">
                        <input type="search" name="search" placeholder="Enter Product name here" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                        <input type="submit" value="Search">
                    </form>
                    <div class="filter-bar col-100 common align">
                        <p><a href="products.php?filter=All Products" <?php echo $filter === "All Products" ? 'class="active"' : ''; ?>>All Products</a></p>
                        <p><a href="products.php?category=Appliances">Appliances</a></p>
                        <p><a href="products.php?category=Cars">Cars</a></p>
                        <p><a href="products.php?category=Office">Office</a></p>
            </div>
            <div class="products-page col-100 common-even">
                <?php foreach ($products as $product): ?>
                    <div class="product-box common flex-col">
                            <img src="assets/images/products/noimage.png" alt="<?php echo htmlspecialchars($product['name']); ?>">                        
                            <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <span class="common-bet">
                            <h4>Category:</h4><p><?php echo htmlspecialchars($product['category']); ?></p>
                        </span>
                        <span class="common-bet">
                            <h4>Features:</h4><p><?php echo htmlspecialchars($product['features'] ?? 'N/A'); ?></p>
                        </span>
                        <span class="common-bet">
                            <h4>Connectivity:</h4><p><?php echo htmlspecialchars($product['connectivity'] ?? 'N/A'); ?></p>
                        </span>
                        <span class="common-bet">
                            <h4>Price:</h4><p>$<?php echo number_format($product['price'], 2); ?></p>
                        </span>
                        <a href="details.php?id=<?php echo $product['id']; ?>">Summarize</a>
                    </div>
                <?php endforeach; ?>
            </div>
                </div>
            </div>
            
        </div>
    </div>


    <script src="assets/js/script.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>