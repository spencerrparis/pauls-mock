<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $res_date = $_POST['res_date'];
    $guests = (int)$_POST['guests'];

    $table_id = 1; 

    $sql = "INSERT INTO Reservations (reservation_date, guest_count, table_id, status) 
            VALUES ('$res_date', '$guests', '$table_id', 'Pending')";

    if (mysqli_query($conn, $sql)) 
    {
        echo "<script>alert('RESERVATION LOGGED IN SYSTEM'); window.location.href='index.php';</script>";
    } 
    else 
    {
        echo "DATABASE ERROR: " . mysqli_error($conn);
    }
}
?>