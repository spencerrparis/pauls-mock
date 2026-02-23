<?php
session_start();
include 'db_connect.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM Users WHERE email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) 
    {
        $user = mysqli_fetch_assoc($result);
        
        // This checks the hashed password in the DB against what the user typed
        if (password_verify($password, $user['password_hash'])) 
        {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            
            header("Location: admin.php");
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
    <title>Staff Login | Apex Neon</title>
    <link rel="stylesheet" href="style.css">
</head>
<body style="display:flex; justify-content:center; align-items:center; height:100vh; margin:0;">

    <div style="width: 100%; max-width: 400px; padding: 20px;">
        <form method="POST" class="neon-form">
            <h2 style="color:var(--neon-pink); text-align:center; margin-bottom:20px;">STAFF AUTHORIZATION</h2>
            
            <div class="flicker-strip"></div>

            <?php if($error): ?>
                <p style="color: #ff4444; text-align: center; font-size: 14px; border: 1px solid #ff4444; padding: 10px;">
                    <?php echo $error; ?>
                </p>
            <?php endif; ?>
            
            <div class="form-group">
                <input type="email" name="email" placeholder="STAFF EMAIL" required>
            </div>
            
            <div class="form-group">
                <input type="password" name="password" placeholder="SECURITY KEY" required>
            </div>
            
            <button type="submit" class="confirm-btn">ENTER SYSTEM</button>
        </form>
    </div>

</body>
</html>