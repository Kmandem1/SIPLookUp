<?php
session_start();
require_once "config.php";

// Fetch all products for selection
$sql = "SELECT id, name, category FROM products";
$stmt = $conn->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle comparison
$comparison = [];
$selected_products = isset($_POST["compare"]) && isset($_POST["product_ids"]) ? $_POST["product_ids"] : [];
if (count($selected_products) == 2) {
    $sql = "SELECT * FROM products WHERE id IN (:id1, :id2)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id1", $selected_products[0], PDO::PARAM_INT);
    $stmt->bindParam(":id2", $selected_products[1], PDO::PARAM_INT);
    $stmt->execute();
    $comparison = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Ensure same category
    if (count($comparison) == 2 && $comparison[0]["category"] !== $comparison[1]["category"]) {
        $comparison = [];
        $error = "Please select two products from the same category.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Compare Products - SIPLookUP</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .compare-main { 
            width: 100%; 
            padding: 20px; 
            display: flex; 
            flex-direction: column; 
            align-items: center; 
        }
        .product-list { 
            display: flex; 
            flex-wrap: wrap; 
            justify-content: center; 
            gap: 20px; 
            margin: 20px 0; 
        }
        .product-box { 
            background: #fff; 
            border: 1px solid #ddd; 
            border-radius: 5px; 
            padding: 15px; 
            width: 250px; 
            text-align: center; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
        }
        .product-box img { 
            width: 100%; 
            height: auto; 
        }
        .comparison-table { 
            width: 80%; 
            border-collapse: collapse; 
            margin-top: 20px; 
        }
        .comparison-table th, .comparison-table td { 
            border: 1px solid #ddd; 
            padding: 10px; 
            text-align: left; 
        }
        .comparison-table th { 
            background: #f5f5f5; 
        }
        .difference { 
            background: #ffe6e6; 
        }
        .error { 
            color: #dc3545; 
            margin: 10px 0; 
        }
        .compare-btn { 
            background: #007bff; 
            color: #fff; 
            padding: 10px 20px; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
            margin-top: 20px; 
        }
        .compare-btn:hover { 
            background: #0056b3; 
        }
        .back-btn { 
            display: inline-block; 
            margin-top: 20px; 
            text-decoration: none; 
            color: #007bff; 
        }
    </style>
</head>
<body>
    <div class="compare-main col-100 common align">
        <h2>Compare Products</h2>
        <form action="compare.php" method="POST">
            <div class="product-list">
                <?php foreach ($products as $product): ?>
                    <div class="product-box">
                        <input type="checkbox" name="product_ids[]" value="<?php echo $product['id']; ?>" <?php echo in_array($product['id'], $selected_products) ? 'checked' : ''; ?>>
                        <img src="assets/images/products/noimage.png" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p>Category: <?php echo htmlspecialchars($product['category']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <input type="submit" name="compare" value="Compare Selected Products" class="compare-btn">
        </form>

        <?php if (!empty($comparison)): ?>
            <h3>Comparison</h3>
            <table class="comparison-table">
                <tr>
                    <th>Attribute</th>
                    <th><?php echo htmlspecialchars($comparison[0]['name']); ?></th>
                    <th><?php echo htmlspecialchars($comparison[1]['name']); ?></th>
                </tr>
                <?php 
                $attributes = ['category', 'motor', 'range_val', 'features', 'connectivity', 'price', 'software_hardware_summary'];
                foreach ($attributes as $attr): 
                    $val1 = $comparison[0][$attr] ?? 'N/A';
                    $val2 = $comparison[1][$attr] ?? 'N/A';
                    $diff_class = ($val1 !== $val2) ? 'difference' : '';
                ?>
                    <tr>
                        <td><?php echo ucfirst(str_replace('_', ' ', $attr)); ?></td>
                        <td class="<?php echo $diff_class; ?>"><?php echo htmlspecialchars($val1); ?></td>
                        <td class="<?php echo $diff_class; ?>"><?php echo htmlspecialchars($val2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php elseif (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <a href="products.php" class="back-btn">Back to Products</a>
    </div>
</body>
</html>