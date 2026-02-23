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
        <div style="margin-top: 50px; font-size: 10px; color: var(--neon-cyan);">LOYALTY SCHEME v1.0</div>
    </nav>
</aside>

<div class="main-body-container">
    
    <header id="home">
        <h1 class="neon-title">APEX NEON</h1>
        <div class="intro-box">
            <div class="flicker-strip"></div>
            <p>Introductory text: Experience the fusion of flavor and light in our high-tech bistro.</p>
            <div style="margin-top: 20px;">
                <?php if(isset($_SESSION['full_name'])): ?>
                    <span style="color: var(--neon-cyan)">LOGGED IN AS: <?php echo strtoupper($_SESSION['full_name']); ?></span>
                <?php else: ?>
                    <a href="login.php" style="color: var(--neon-pink); text-decoration: none;">STAFF LOGIN / SIGN UP</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <section id="menu" style="margin-top: 100px;">
        <div style="display:flex; align-items:center; gap:20px; margin-bottom: 40px;">
            <div class="flicker-box"></div>
            <h2 style="font-size: 32px; letter-spacing: 5px;">MENU</h2>
            <div class="flicker-box"></div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 40px;">
            <?php
            $categories = ['Small Dishes', 'Main Dishes', 'Drinks'];
            foreach($categories as $cat) {
                echo "<div>";
                echo "<h3 style='color: var(--neon-cyan); border-bottom: 1px solid #333; padding-bottom: 10px;'>" . strtoupper($cat) . "</h3>";
                
                $sql = "SELECT m.* FROM MenuItems m 
                        JOIN Categories c ON m.category_id = c.category_id 
                        WHERE c.category_name = '$cat' AND m.is_available = 1";
                $result = mysqli_query($conn, $sql);
                
                if(mysqli_num_rows($result) > 0) {
                    while($item = mysqli_fetch_assoc($result)) {
                        echo "<div style='margin: 15px 0;'>
                                <strong>{$item['name']}</strong><br>
                                <small style='color:#888'>{$item['description']}</small><br>
                                <span style='color: var(--neon-pink)'>£" . number_format($item['price'], 2) . "</span>
                              </div>";
                    }
                } else {
                    echo "<p style='color:#444'>Data pending...</p>";
                }
                echo "</div>";
            }
            ?>
        </div>
    </section>

    <section id="order" style="margin-top: 100px;">
        <div class="flicker-strip"></div>
        <h2 style="margin-bottom: 30px;">SECURE A TABLE</h2>
        <form action="process_booking.php" method="POST" class="neon-form">
            <div class="form-group">
                <input type="text" name="full_name" placeholder="FULL NAME" required>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="EMAIL ADDRESS" required>
            </div>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <input type="date" name="res_date" required>
                <input type="number" name="guests" placeholder="NUMBER OF GUESTS" min="1" required>
            </div>
            <button type="submit" class="confirm-btn" style="margin-top: 20px;">CONFIRM RESERVATION</button>
        </form>
    </section>

    <section id="about" style="margin-top: 150px; padding-bottom: 100px;">
        <div class="flicker-strip"></div>
        <h2>SYSTEM INFO</h2>
        <p>Apex Neon is a data-driven dining experience. Built for Task 2.</p>
    </section>

</div>

<script>
    // Logic to show sidebar when "About" section is visible
    window.onscroll = function() {
        var aboutSection = document.getElementById("about");
        var sidebar = document.querySelector(".sidebar");
        var position = aboutSection.getBoundingClientRect();

        // Show sidebar if About section has scrolled into view
        if (position.top <= (window.innerHeight || document.documentElement.clientHeight)) {
            sidebar.style.opacity = "1";
        } else {
            sidebar.style.opacity = "0";
        }
    };
</script>

</body>
</html>