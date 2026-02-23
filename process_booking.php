<?php
    session_start();
    include 'db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) 
    {
        $user_id = $_SESSION['user_id'];
        $date    = mysqli_real_escape_string($conn, $_POST['date']);
        $time    = mysqli_real_escape_string($conn, $_POST['time']);
        $guests  = mysqli_real_escape_string($conn, $_POST['guests']);

        $sql = "INSERT INTO bookings (user_id, booking_date, booking_time, guests) 
                VALUES ('$user_id', '$date', '$time', '$guests')";

        if (mysqli_query($conn, $sql)) 
        {
            echo "SUCCESS";
        } 
        else 
        {
            echo "DB_ERROR";
        }
    } 
    else 
    {
        echo "AUTH_REQUIRED";
    }
?>