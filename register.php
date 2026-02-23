<?php
session_start();
include 'db_connect.php';

$message = "";
$status_color = "var(--neon-cyan)";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name  = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass  = $_POST['password'];
    $phone = mysqli_real_escape_string($conn, $_POST['phone_number']);

    // Check if email already exists
    $check_email = mysqli_query($conn, "SELECT email FROM Users WHERE email = '$email'");
    
    if (mysqli_num_rows($check_email) > 0) 
    {
        $message = "ERROR: EMAIL ALREADY REGISTERED";
        $status_color = "#ff4444";
    } 
    else 
    {
        // Hash password
        $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
        
        $role_id = 2; 

        $sql = "INSERT INTO Users (role_id, full_name, email, password_hash, phone_number) 
                VALUES ('$role_id', '$name', '$email', '$hashed_pass', '$phone')";

        if (mysqli_query($conn, $sql)) 
        {
            $message = "REGISTRATION SUCCESSFUL. PROCEED TO LOGIN.";
            $status_color = "#00ff00";
        } 
        else 
        {
            $message = "SYSTEM ERROR: UNABLE TO REGISTER";
            $status_color = "#ff4444";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Join Apex | Registration</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="display:flex; justify-content:center; align-items:center; min-height:100vh; margin:0; padding: 20px 0;">

    <div style="width: 100%; max-width: 500px; padding: 20px;">
        <form method="POST" class="neon-form">
            <h2 style="color:var(--neon-pink); text-align:center; margin-bottom:10px;">NEON MEMBERSHIP</h2>
            <p style="text-align:center; font-size: 12px; margin-bottom: 20px; letter-spacing: 1px;">INITIALIZE NEW USER PROFILE</p>
            
            <div class="flicker-strip"></div>

            <?php if($message): ?>
                <p style="color: <?php echo $status_color; ?>; text-align: center; font-size: 14px; border: 1px solid <?php echo $status_color; ?>; padding: 10px; margin-bottom: 20px;">
                    <?php echo $message; ?>
                </p>
            <?php endif; ?>
            
            <div class="form-group">
                <input type="text" name="full_name" placeholder="FULL NAME" required>
            </div>

            <div class="form-group">
                <input type="email" name="email" placeholder="EMAIL ADDRESS" required>
            </div>

            <div class="form-group">
                <input type="text" name="phone_number" placeholder="PHONE (OPTIONAL)">
            </div>
            
            <div class="form-group">
                <input type="password" name="password" placeholder="CREATE SECURITY KEY" required>
            </div>
            
            <button type="submit" class="confirm-btn" style="width: 100%;">CREATE PROFILE</button>
            
            <p style="text-align: center; margin-top: 20px; font-size: 12px;">
                ALREADY A MEMBER? <a href="login.php" style="color: var(--neon-cyan); text-decoration: none;">LOGIN HERE</a>
            </p>
        </form>
    </div>

</body>
</html>