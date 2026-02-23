<?php 
session_start();
include 'db_connect.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>APEX NEON | Immersive Dining</title>
    <link rel="stylesheet" href="style.css">
    <style>
        @keyframes neon-hum 
        {
            0%, 100% { box-shadow: 0 0 10px rgba(0, 255, 255, 0.1); }
            50% { box-shadow: 0 0 20px rgba(0, 255, 255, 0.3); }
        }
        @keyframes text-flicker 
        {
            0%, 19%, 21%, 23%, 25%, 54%, 56%, 100% { opacity: 1; }
            20%, 22%, 24%, 55% { opacity: 0.5; }
        }
        .scanline 
        {
            width: 100%; height: 20px; z-index: 10;
            background: rgba(0, 255, 255, 0.05);
            position: absolute; left: 0;
            animation: scanline-move 10s linear infinite;
            pointer-events: none;
        }
        @keyframes scanline-move 
        {
            0% { top: 0%; } 100% { top: 100%; }
        }
        .intro-box { animation: neon-hum 5s ease-in-out infinite; }
        .neon-title { animation: text-flicker 6s infinite; }
    </style>
</head>
<body>

<aside class="sidebar">
    <nav>
        <div style="color:var(--neon-pink); font-size: 24px; margin-bottom: 30px; font-weight: bold; letter-spacing: 3px;">APEX</div>
        <ul>
            <li><a href="#home">HOME</a></li>
            <li><a href="#menu">MENU</a></li>
            <li><a href="#order">RESERVATIONS</a></li>
            <li><a href="#about">ABOUT</a></li>
        </ul>
    </nav>
</aside>

<div class="main-body-container">
    <header id="home" style="position: relative; overflow: hidden;">
        <div class="scanline"></div>
        <h1 class="neon-title">APEX NEON</h1>
        
        <div class="intro-box">
            <div class="flicker-strip"></div>
            <div style="margin-bottom: 20px;">
                <?php if(isset($_SESSION['full_name'])): ?>
                    <span style="color: var(--neon-cyan); letter-spacing: 2px; font-weight: bold;">
                        WELCOME BACK, <?php echo strtoupper(htmlspecialchars($_SESSION['full_name'])); ?>
                    </span>
                    <?php if(isset($_SESSION['role_id']) && $_SESSION['role_id'] == 1): ?>
                         | <a href="admin.php" style="color:white; text-decoration:none;">[DASHBOARD]</a>
                    <?php endif; ?>
                    | <a href="logout.php" style="color:var(--neon-pink); text-decoration:none;">[LOGOUT]</a>
                <?php else: ?>
                    <a href="login.php" class="confirm-btn" style="text-decoration:none; font-size: 12px;">MEMBER LOGIN</a>
                    <a href="register.php" style="color:var(--neon-cyan); text-decoration:none; font-size: 11px; margin-left: 15px;">CREATE ACCOUNT</a>
                <?php endif; ?>
            </div>
            <p>Experience the fusion of flavor and light in our high-tech bistro.</p>
        </div>
    </header>

    <section id="menu" style="padding: 100px 0;">
        <h2 class="neon-title" style="font-size: 40px;">THE NEON MENU</h2>
        <div class="menu-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; margin-top: 50px;">
            <div class="intro-box" style="border-color: var(--neon-cyan);">
                <h3 style="color: var(--neon-cyan);">CYBER-RAMEN</h3>
                <p>Bioluminescent noodles in a miso-chrome broth. <span style="color:var(--neon-pink);">£18</span></p>
            </div>
            <div class="intro-box" style="border-color: var(--neon-pink);">
                <h3 style="color: var(--neon-pink);">GLITCH FRIES</h3>
                <p>Triple-cooked with electric truffle salt. <span style="color:var(--neon-cyan);">£9</span></p>
            </div>
        </div>
    </section>

    <section id="order" style="padding: 100px 0;">
        <h2 class="neon-title" style="font-size: 40px;">SECURE A TABLE</h2>
        <div class="intro-box" style="max-width: 650px; margin: 0 auto;">
            <p id="booking-status" style="font-family: monospace; color: #888;">> PROTOCOL STANDBY...</p>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <form id="reservationForm" style="margin-top: 25px; display: flex; gap: 15px; flex-wrap: wrap; justify-content: center;">
                    <input type="date" name="date" required style="background:#000; color:#fff; border:1px solid var(--neon-cyan); padding:12px;">
                    <input type="time" name="time" required style="background:#000; color:#fff; border:1px solid var(--neon-cyan); padding:12px;">
                    <input type="number" name="guests" placeholder="GUESTS" min="1" max="10" required style="background:#000; color:#fff; border:1px solid var(--neon-cyan); padding:12px; width: 100px;">
                    <button type="submit" class="confirm-btn" style="padding: 12px 30px;">CONFIRM</button>
                </form>
            <?php else: ?>
                <div style="padding: 20px; border: 1px dashed var(--neon-pink); text-align: center; margin-top: 20px;">
                    <p style="color: var(--neon-pink); font-size: 14px; margin: 0;">[ACCESS DENIED: PLEASE LOGIN TO BOOK]</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <section id="about" style="padding: 100px 0; margin-bottom: 100px;">
        <h2 class="neon-title" style="font-size: 40px;">OUR STORY</h2>
        <p style="line-height: 1.8; letter-spacing: 1px; max-width: 800px;">
            Established in 2077, APEX NEON is a sensory-overload bistro. We blend high-definition flavor with immersive lighting to create an atmosphere that exists at the edge of tomorrow.
        </p>
    </section>
</div>

<script>
    // 1. AJAX BOOKING LOGIC (STOPS REDIRECT)
    document.addEventListener('DOMContentLoaded', function() 
    {
        const resForm = document.getElementById('reservationForm');
        if (resForm) 
        {
            resForm.addEventListener('submit', function(e) 
            {
                e.preventDefault(); // CRITICAL: This stops the page from changing/redirecting
                
                const statusBox = document.getElementById('booking-status');
                const formData = new FormData(this);
                statusBox.innerText = "> UPLOADING TO MAINframe...";

                fetch('process_booking.php', 
                {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => 
                {
                    if (data.trim() === "SUCCESS") 
                    {
                        statusBox.innerHTML = "<span style='color:var(--neon-cyan)'>[BOOKING SECURED]</span>";
                        resForm.reset(); 
                    } 
                    else 
                    {
                        statusBox.innerHTML = "<span style='color:var(--neon-pink)'>ERROR: " + data + "</span>";
                    }
                })
                .catch(err => 
                {
                    statusBox.innerHTML = "<span style='color:var(--neon-pink)'>SYSTEM OFFLINE</span>";
                });
            });
        }
    });

    // 2. SIDEBAR VISIBILITY SCRIPT
    window.onscroll = function() 
    {
        var about = document.getElementById("about");
        var sidebar = document.querySelector(".sidebar");
        if (about && sidebar) 
        {
            if (about.getBoundingClientRect().top <= window.innerHeight) {
                sidebar.style.opacity = "1";
            } else {
                sidebar.style.opacity = "0";
            }
        }
    };
</script>
</body>
</html>