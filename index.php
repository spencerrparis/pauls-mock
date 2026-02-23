<?php 
// Connection to your MySQL database
include 'db_connect.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apex Neon | Epicurean Themes</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Roboto+Mono&display=swap" rel="stylesheet">
</head>
<body>

<div class="main-wrapper">
    <aside class="sidebar">
        <nav>
            <div class="sidebar-logo">APEX</div>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#menu">Menu</a></li>
                <li><a href="#order">Order</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact Us</a></li>
            </ul>
            <div class="loyalty-tag">Loyalty Scheme</div>
        </nav>
    </aside>

    <main class="main-body-container">
        <section id="home" class="header-section">
            <h1 class="neon-title">APEX NEON</h1>
            <div class="intro-box">
                <p class="intro-text">Introductory text: Experience the fusion of flavor and light.</p>
                <div class="login-welcome">
                    <?php 
                    session_start();
                    if(isset($_SESSION['full_name'])) {
                        echo "WELCOME, " . strtoupper($_SESSION['full_name']);
                    } else {
                        echo '<a href="login.php" class="flicker-text">LOGIN / SIGN UP</a>';
                    }
                    ?>
                </div>
            </div>
            <div class="neon-strip"></div> </section>

        <section id="menu">
            <div class="menu-header">
                <div class="flicker-box small"></div>
                <h2>MENU</h2>
                <div class="flicker-box small"></div>
            </div>
            
            <div class="menu-grid">
                <?php
                // Fetching categories from your MySQL table
                $categories = ['Small Dishes', 'Main Dishes', 'Drinks'];
                foreach($categories as $cat): 
                ?>
                <div class="menu-column">
                    <h3><?php echo strtoupper($cat); ?></h3>
                    <div class="neon-strip-thin"></div>
                    <?php
                    // Fetch items matching the category from your MenuItems table
                    $query = "SELECT m.* FROM MenuItems m 
                              JOIN Categories c ON m.category_id = c.category_id 
                              WHERE c.category_name = '$cat' AND m.is_available = 1";
                    $result = mysqli_query($conn, $query);
                    while($item = mysqli_fetch_assoc($result)):
                    ?>
                        <div class="item">
                            <span class="item-name"><?php echo $item['name']; ?></span>
                            <span class="item-price">£<?php echo $item['price']; ?></span>
                        </div>
                    <?php endwhile; ?>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="order">
            <div class="neon-strip"></div>
            <h2>ORDER FORM</h2>
            <form action="process_booking.php" method="POST" class="order-form">
                <div class="form-group">
                    <input type="text" name="full_name" placeholder="FULL NAME" required>
                    <input type="email" name="email" placeholder="EMAIL" required>
                </div>
                <div class="form-group">
                    <input type="date" name="res_date" required>
                    <input type="time" name="res_time" required>
                </div>
                <div class="form-group">
                    <input type="number" name="guests" placeholder="GUESTS" min="1" required>
                    <button type="submit" class="confirm-btn">CONFIRM</button>
                </div>
            </form>
        </section>

        <section id="about">
            <div class="info-block">
                <div class="flicker-bar">ABOUT US</div>
                <div class="content-box">
                    <p>Immersive dining inspired by high-tech aesthetics.</p>
                </div>
            </div>
            <div class="info-block">
                <div class="flicker-bar">CONTACT</div>
                <div class="content-box">
                    <p>Location: Sector 7, Neon District</p>
                </div>
            </div>
        </section>
    </main>
</div>
<script>
window.onscroll = function() {
    var aboutSection = document.getElementById("about");
    var sidebar = document.querySelector(".sidebar");
    
    // Get the position of the About section relative to the top of the viewport
    var position = aboutSection.getBoundingClientRect();

    // If the top of 'About' is at or above the top of the screen (0)
    if (position.top <= 100) {
        sidebar.style.opacity = "1";
        sidebar.style.pointerEvents = "auto"; // Makes links clickable
    } else {
        sidebar.style.opacity = "0";
        sidebar.style.pointerEvents = "none"; // Prevents clicking while hidden
    }
};
</script>
</body>
</html>