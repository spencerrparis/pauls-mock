<?php
session_start();
include 'db_connect.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM Users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        if (password_verify($password, $user['password_hash'])) {
            // Set Session Variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role_id'] = $user['role_id'];

            // Redirect based on role (1 = Manager/Staff, 3 = Customer)
            if ($_SESSION['role_id'] == 1)
            {
                header("Location: admin.php");
            } 
            else 
            {
                header("Location: index.php");
            }
            exit();
        } 
        else 
        {
            $error = "ACCESS DENIED: INVALID CREDENTIALS";
        }
    } 
    else 
    {
        $error = "ACCESS DENIED: INVALID CREDENTIALS";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>System Login | Apex Neon</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="display:flex; justify-content:center; align-items:center; height:100vh; margin:0;">
    <div style="width: 100%; max-width: 400px; padding: 20px;">
        <form method="POST" class="neon-form">
            <h2 style="color:var(--neon-pink); text-align:center; margin-bottom:20px;">APEX SYSTEM LOGIN</h2>
            <div class="flicker-strip"></div>
            <?php if($error) echo "<p style='color:#ff4444; text-align:center; border:1px solid #ff4444; padding:10px;'>$error</p>"; ?>
            <div class="form-group">
                <input type="email" name="email" placeholder="EMAIL ADDRESS" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="SECURITY KEY" required>
            </div>
            <button type="submit" class="confirm-btn">AUTHORIZE</button>
            <p style="text-align: center; margin-top: 20px; font-size: 12px;">
            NEW OPERATOR? <a href="register.php" style="color: var(--neon-cyan); text-decoration: none;">CREATE ACCOUNT</a>
            </p>
        </form>
    </div>
</body>
</html>