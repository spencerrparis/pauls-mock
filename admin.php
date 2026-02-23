<?php
session_start();
include 'db_connect.php';

// Access control: Ensure only logged-in staff can see this
if (!isset($_SESSION['user_id'])) 
{
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
<body class="main-body-container" style="margin-left: 50px;"> <header style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 40px;">
        <div>
            <h1 class="neon-title" style="font-size: 40px;">ADMIN DASHBOARD</h1>
            <p style="color: var(--neon-cyan);">LOGGED IN AS: <?php echo strtoupper($_SESSION['full_name']); ?></p>
        </div>
        <a href="logout.php" class="confirm-btn" style="text-decoration:none; font-size: 12px;">TERMINATE SESSION [LOGOUT]</a>
    </header>

    <div class="flicker-strip"></div>

    <div class="admin-grid">
        
        <div class="admin-card">
            <h3 style="color:var(--neon-pink); margin-bottom:20px;">ACTIVE RESERVATIONS</h3>
            <table width="100%" style="border-collapse: collapse; text-align: left;">
                <tr style="border-bottom: 1px solid #333; color: var(--neon-cyan);">
                    <th style="padding:10px;">Customer ID</th>
                    <th>Guests</th>
                    <th>Time</th>
                    <th>Status</th>
                </tr>
                <?php
                $query = "SELECT * FROM Reservations ORDER BY reservation_date DESC LIMIT 10";
                $result = mysqli_query($conn, $query);
                
                if(mysqli_num_rows($result) > 0) 
                {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr style='border-bottom: 1px solid #111;'>
                                <td style='padding:10px;'>USER_{$row['user_id']}</td>
                                <td>{$row['guest_count']}</td>
                                <td>" . ($row['start_time'] ?? 'N/A') . "</td>
                                <td style='font-weight:bold; color:var(--neon-cyan);'>{$row['status']}</td>
                              </tr>";
                    }
                } 
                else 
                {
                    echo "<tr><td colspan='4' style='padding:20px; color:#444;'>No active bookings found.</td></tr>";
                }
                ?>
            </table>
        </div>

        <div class="admin-sidebar-data">
            
            <div class="admin-card" style="margin-bottom: 20px;">
                <h3 style="color:var(--neon-pink); margin-bottom:20px;">FLOOR MAP</h3>
                <div class="table-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                    <?php
                    $tables_res = mysqli_query($conn, "SELECT * FROM DiningTables");
                    while($table = mysqli_fetch_assoc($tables_res)) 
                    {
                        $tid = $table['table_id'];
                        // Check occupancy for "today"
                        $check_sql = "SELECT * FROM Reservations WHERE table_id = $tid AND reservation_date = CURDATE() AND status = 'Confirmed'";
                        $check_res = mysqli_query($conn, $check_sql);
                        $status_class = (mysqli_num_rows($check_res) > 0) ? "occupied" : "vacant";
                        
                        echo "<div class='table-box $status_class' style='padding:10px; border:2px solid; text-align:center;'>
                                <span style='font-size:12px;'>TABLE {$table['table_number']}</span><br>
                                <small style='font-size:10px;'>CAP: {$table['capacity']}</small>
                              </div>";
                    }
                    ?>
                </div>
            </div>

            <div class="admin-card" style="margin-bottom: 20px;">
                <h3>STAFF STATUS</h3>
                <p><span class="flicker-box"></span> Manager: <span style="color: #00ff00;">ONLINE</span></p>
            </div>

            <div class="admin-card">
                <h3>TOTAL REVENUE</h3>
                <?php
                $sales = mysqli_query($conn, "SELECT SUM(price) AS total FROM MenuItems");
                $data = mysqli_fetch_assoc($sales);
                echo "<p style='font-size: 30px; color:var(--neon-cyan); text-shadow: 0 0 10px var(--neon-cyan);'>£" . number_format($data['total'], 2) . "</p>";
                ?>
            </div>
        </div>
    </div>

</body>
</html>