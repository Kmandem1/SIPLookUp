<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST["fname"]);
    $email = trim($_POST["mailid"]);
    $password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT); // Hash the password

    // Check if email already exists
    $sql = "SELECT id FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Email already exists. Please use a different email.";
    } else {
        // Insert new user
        $sql = "INSERT INTO users (full_name, email, password) VALUES (:full_name, :email, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":full_name", $full_name);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);

        if ($stmt->execute()) {
            header("Location: login.php"); // Redirect to login page
            exit;
        } else {
            echo "Something went wrong. Please try again.";
        }
    }
}
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
<body>
    <div class="sl-container col-100 common" style="background-image: url(assets/images/banner-1.jpg);background-position: center;background-size: cover;background-repeat: no-repeat;">
        <span id="siplookup"><a href="index.html">SIPLookUp</a></span>
        <div class="login col-100 common align">
            <div class="login-main col-100 common align">
                <form action="register.php" method="POST" class="common flex-col">
                    <h3>Register</h3>
                    <label for="fname">Full Name</label>
                    <input type="text" name="fname" id="fname" placeholder="Enter here" required>
                    <label for="mailid">Email</label>
                    <input type="email" id="mailid" name="mailid" placeholder="Enter here" required>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter here" required>
                    <input type="submit" name="signin" id="signin" value="Register"><br>
                    <span>Already have an account? <a href="login.php">Login</a></span>
                </form>
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