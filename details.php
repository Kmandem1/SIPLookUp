<?php
session_start();
require_once "config.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    header("Location: products.php");
    exit;
}

$product_id = $_GET["id"];
$sql = "SELECT * FROM products WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":id", $product_id, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: products.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($product['name']); ?> - SIPLookUP</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="details-main col-100 common flex-col align">
        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
        <div class="product-details col-80 common flex-col">
            <img src="assets/images/products/noimage.png" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width:200px;">
            <p><b>Category:</b> <?php echo htmlspecialchars($product['category']); ?></p>
            <?php if ($product['motor']): ?>
                <p><b>Motor:</b> <?php echo htmlspecialchars($product['motor']); ?></p>
            <?php endif; ?>
            <?php if ($product['range_val']): ?>
                <p><b>Range:</b> <?php echo htmlspecialchars($product['range_val']); ?></p>
            <?php endif; ?>
            <p><b>Features:</b> <?php echo htmlspecialchars($product['features']); ?></p>
            <p><b>Connectivity:</b> <?php echo htmlspecialchars($product['connectivity']); ?></p>
            <p><b>Price:</b> $<?php echo number_format($product['price'], 2); ?></p>
            <p><b>Software Config:</b> <?php echo htmlspecialchars($product['software_config']); ?></p>
            <p><b>Hardware Config:</b> <?php echo htmlspecialchars($product['hardware_config']); ?></p>
        </div>
        <div class="summary-box col-80 common flex-col">
            <h3>Summary</h3>
            <p><?php echo htmlspecialchars($product['summary_100_words']); ?></p>
        </div>
        <a href="products.php">Back to Products</a>
    </div>
</body>
</html>