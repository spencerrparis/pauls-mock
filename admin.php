<?php
session_start();
include 'db_connect.php';

// SECURITY CHECK: Kick out anyone not logged in OR anyone who isn't a Manager (Role 1)
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>STAFF PORTAL | APEX NEON</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="main-body-container" style="margin-left: 50px;">
    
    <header style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 40px;">
        <div>
            <h1 class="neon-title" style="font-size: 40px;">ADMIN DASHBOARD</h1>
            <p style="color: var(--neon-cyan);">OPERATOR: <?php echo strtoupper($_SESSION['full_name']); ?></p>
        </div>
        <a href="logout.php" class="confirm-btn" style="text-decoration:none; font-size: 12px;">LOGOUT</a>
    </header>

    <div class="flicker-strip"></div>

    <div class="admin-grid">
        <div class="admin-card">
            <h3 style="color:var(--neon-pink); margin-bottom:20px;">ACTIVE RESERVATIONS</h3>
            <table>
                <tr>
                    <th>User ID</th>
                    <th>Guests</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
                <?php
                $res = mysqli_query($conn, "SELECT * FROM Reservations ORDER BY reservation_date DESC");
                while($row = mysqli_fetch_assoc($res)) {
                    echo "<tr>
                            <td>USER_{$row['user_id']}</td>
                            <td>{$row['guest_count']}</td>
                            <td>{$row['reservation_date']}</td>
                            <td style='color:var(--neon-cyan)'>{$row['status']}</td>
                          </tr>";
                }
                ?>
            </table>
        </div>

        <div class="admin-sidebar-data">
            <div class="admin-card" style="margin-bottom: 20px;">
                <h3>TABLE MAP</h3>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <?php
                    $tables = mysqli_query($conn, "SELECT * FROM DiningTables");
                    while($t = mysqli_fetch_assoc($tables)) {
                        $class = ($t['is_active']) ? 'vacant' : 'occupied';
                        echo "<div class='table-box $class'>T-{$t['table_number']}</div>";
                    }
                    ?>
                </div>
            </div>
            
            <div class="admin-card">
                <h3>REVENUE PROJECTION</h3>
                <p style="font-size: 24px; color: var(--neon-cyan);">£1,240.00</p>
            </div>
        </div>
    </div>
</body>
</html>