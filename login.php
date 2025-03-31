<?php
session_start();
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["mailid"]);
    $password = trim($_POST["password"]);

    // Check if user exists
    $sql = "SELECT id, full_name, email, password FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $user["password"])) {
            // Password is correct, start session
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $user["id"];
            $_SESSION["full_name"] = $user["full_name"];
            $_SESSION["email"] = $user["email"];
            header("Location: home.php"); // Redirect to profile page (create later)
            exit;
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No account found with that email.";
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
                <form action="login.php" method="POST" class="common flex-col">
                    <h3>Login</h3>
                    <label for="mailid">Email</label>
                    <input type="email" id="mailid" name="mailid" placeholder="Your Email here" required>
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Your Password here" required>
                    <input type="submit" name="signin" id="signin" value="Login"><br>
                    <span>No account? <a href="register.php">Register</a></span>
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