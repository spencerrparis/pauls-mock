<?php 
session_start();
include 'db_connect.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>APEX NEON | Immersive Dining</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<aside class="sidebar">
    <nav>
        <div style="color:var(--neon-pink); font-size: 24px; margin-bottom: 30px; font-weight: bold;">APEX</div>
        <ul>
            <li><a href="#home">HOME</a></li>
            <li><a href="#menu">MENU</a></li>
            <li><a href="#order">RESERVATIONS</a></li>
            <li><a href="#about">ABOUT</a></li>
        </ul>
    </nav>
</aside>

<div class="main-body-container">
    <header id="home">
        <h1 class="neon-title">APEX NEON</h1>
        <div class="intro-box">
            <div class="flicker-strip"></div>
            
            <div style="margin-bottom: 20px;">
                <?php if(isset($_SESSION['full_name'])): ?>
                    <span style="color: var(--neon-cyan); letter-spacing: 2px;">
                        WELCOME BACK, <?php echo strtoupper($_SESSION['full_name']); ?>
                    </span>
                    <?php if($_SESSION['role_id'] == 1): ?>
                         | <a href="admin.php" style="color:white; text-decoration:none;">[DASHBOARD]</a>
                    <?php endif; ?>
                    | <a href="logout.php" style="color:var(--neon-pink); text-decoration:none;">[LOGOUT]</a>
                <?php else: ?>
                    <a href="login.php" class="confirm-btn" style="text-decoration:none; font-size: 12px;">MEMBER LOGIN</a>
                <?php endif; ?>
            </div>

            <p>Experience the fusion of flavor and light in our high-tech bistro.</p>
        </div>
    </header>

    </div>

<script>
    window.onscroll = function() {
        var aboutSection = document.getElementById("about");
        var sidebar = document.querySelector(".sidebar");
        if (aboutSection.getBoundingClientRect().top <= window.innerHeight) {
            sidebar.style.opacity = "1";
        } else {
            sidebar.style.opacity = "0";
        }
    };
</script>
</body>
</html>