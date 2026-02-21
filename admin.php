<?php
session_start();
include 'db_connect.php';

// Security check: Redirect if not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard | Apex Neon</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="admin-body">
    <header class="admin-header">
        <h1>ADMIN DASHBOARD</h1>
        <a href="logout.php">LOGOUT</a>
    </header>

    <div class="admin-grid">
        <div class="admin-card current-orders">
            <h3>CURRENT ORDERS</h3>
            <table>
                <tr><th>Guest</th><th>Table</th><th>Time</th><th>Status</th></tr>
                <?php
                $res_query = "SELECT r.*, u.full_name, t.table_number 
                              FROM Reservations r 
                              JOIN Users u ON r.user_id = u.user_id 
                              JOIN DiningTables t ON r.table_id = t.table_id
                              WHERE status = 'Pending'";
                $results = mysqli_query($conn, $res_query);
                while($row = mysqli_fetch_assoc($results)) {
                    echo "<tr>
                            <td>{$row['full_name']}</td>
                            <td>{$row['table_number']}</td>
                            <td>{$row['start_time']}</td>
                            <td>{$row['status']}</td>
                          </tr>";
                }
                ?>
            </table>
        </div>

        <div class="admin-card table-map">
            <h3>MAP OF TABLES</h3>
            <div class="table-container">
                <div class="table-status occupied">T1</div>
                <div class="table-status vacant">T2</div>
                <div class="table-status reserved">T3</div>
            </div>
        </div>

        <div class="admin-card staff-status">
            <h3>STAFF CLOCKED IN</h3>
            <p>Manager: Active</p>
        </div>

        <div class="admin-card sales-figures">
            <h3>SALES FIGURES</h3>
            <p>Total Revenue: £1,240.00</p>
        </div>
    </div>
</body>
</html>