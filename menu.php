<?php 
include 'db_connect.php'; 
include 'header.php'; 

$query = "SELECT m.*, c.category_name FROM MenuItems m 
          JOIN Categories c ON m.category_id = c.category_id 
          WHERE m.is_available = 1 ORDER BY c.category_name";
$result = mysqli_query($conn, $query);
?>

<main class="container">
    <h1>Our Seasonal Menu</h1>
    <div class="menu-grid">
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <div class="menu-item">
                <img src="assets/<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>">
                <h3><?php echo $row['name']; ?></h3>
                <p><?php echo $row['description']; ?></p>
                <span class="price">£<?php echo number_format($row['price'], 2); ?></span>
            </div>
        <?php endwhile; ?>
    </div>
</main>