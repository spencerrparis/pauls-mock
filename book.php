<main class="container">
    <h2>Table Reservation</h2>
    <form action="process_booking.php" method="POST" class="booking-form">
        <label>Full Name:</label>
        <input type="text" name="full_name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Date:</label>
        <input type="date" name="res_date" min="<?php echo date('Y-m-d'); ?>" required>

        <label>Time:</label>
        <input type="time" name="res_time" required>

        <label>Guests:</label>
        <input type="number" name="guests" min="1" max="10" required>

        <button type="submit" name="submit_booking">Confirm Reservation</button>
    </form>
</main>