<?php
session_start();
require_once "config.php";

// Check if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.html");
    exit;
}

// Fetch user data
$user_id = $_SESSION["id"];
$sql = "SELECT full_name, email FROM users WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(":id", $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Handle full name update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $new_full_name = trim($_POST["full_name"]);
    if (!empty($new_full_name)) {
        $sql = "UPDATE users SET full_name = :full_name WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":full_name", $new_full_name);
        $stmt->bindParam(":id", $user_id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            $_SESSION["full_name"] = $new_full_name; // Update session
        } else {
            $error = "Failed to update name.";
        }
    } else {
        $error = "Name cannot be empty.";
    }
}

$full_name = $_SESSION["full_name"] ?? $user["full_name"];
$email = $user["email"];
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
        /* General Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        /* Profile Page Layout */
        .profile-page {
            width: 100%;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 20px;
        }

        .profile-main {
            width: 80%;
            max-width: 500px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .profile-main:hover {
            transform: translateY(-5px);
        }

        /* Profile Image */
        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 20px;
            object-fit: cover;
            border: 3px solid #007bff;
        }

        /* Profile Info */
        .profile-info {
            margin-bottom: 20px;
        }

        .profile-info h2 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .profile-info p {
            font-size: 16px;
            color: #666;
            margin: 5px 0;
        }

        .profile-info p strong {
            color: #333;
        }

        /* Edit Form */
        .edit-form {
            display: none;
            margin-top: 20px;
        }

        .edit-form.active {
            display: block;
        }

        .edit-form input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .edit-form input[type="submit"] {
            background: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .edit-form input[type="submit"]:hover {
            background: #0056b3;
        }

        /* Buttons */
        .edit-btn, .logout-btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 5px;
            text-decoration: none;
            color: #fff;
            background: #007bff;
            border-radius: 5px;
            transition: background 0.3s ease;
        }

        .edit-btn:hover, .logout-btn:hover {
            background: #0056b3;
        }

        .logout-btn {
            background: #dc3545;
        }

        .logout-btn:hover {
            background: #b02a37;
        }

        /* Error Message */
        .error {
            color: #dc3545;
            font-size: 14px;
            margin-top: 10px;
        }
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
                    <a href="products.php">Products</a
                    <a href="compare.php">Compare</a>
                    <a href="contact.php">Contact</a>
                    <a href="profile.php" class="active">Profile</a>
                    <a href="logout.php">Logout</a>
                </div>
            </div>
            <div class="profile-page col-100">
        <div class="profile-main col-80">
            <img src="assets/images/products/user.jpg" alt="Profile Picture" class="profile-img">
            <div class="profile-info">
                <h2><?php echo htmlspecialchars($full_name); ?></h2>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
            </div>
            <form action="profile.php" method="POST" class="edit-form" id="editForm">
                <input type="text" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" required>
                <input type="submit" name="update" value="Save Changes">
            </form>
            <?php if (isset($error)): ?>
                <p class="error"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <a href="#" class="edit-btn" onclick="toggleEdit()">Edit Name</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
            
        </div>
    </div>

<script>
        function toggleEdit() {
            const form = document.getElementById("editForm");
            form.classList.toggle("active");
        }
    </script>
    <script src="assets/js/script.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>