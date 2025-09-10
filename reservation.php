<?php
// Database connection
$conn = new mysqli("sql201.infinityfree.com", "if0_37585900", "G0XnHXPcEJLW5Y", "if0_37585900_2ndfloorbooking");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize the SQL query
$sql = "SELECT name, email, booking_date, time_slot FROM bookings";

// Check if the 'days' parameter is set in the URL
if (isset($_GET['days'])) {
    $days = intval($_GET['days']);
    
    // Calculate the end date based on the number of days
    $dateRange = date('Y-m-d', strtotime("+$days days"));
    $sql .= " WHERE booking_date <= '$dateRange'";
}

// Add ordering to the query
$sql .= " ORDER BY booking_date, time_slot";

// Execute the query
$result = $conn->query($sql);

// Delete past reservations
$currentDate = date('Y-m-d');
$deletePastReservations = "DELETE FROM bookings WHERE booking_date < '$currentDate'";
$conn->query($deletePastReservations);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Current Reservations</title>
    <link rel="stylesheet" href="css/style.css"> <!-- Link to your existing styles -->
    <link rel="icon" href="images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="images/logo.png" class="logo" alt="Logo">
            Sports Booking
        </a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin-left: 630px;">
                <li class="nav-item"><a class="nav-link" href="index.php#book-your-ground">Book</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#rulesAndRegulations">Rules And Regulations</a></li>
                <li class="nav-item"><a class="nav-link" href="index.php#owners">Owners</a></li>
                <li class="nav-item"><a class="nav-link" href="reservation.php">Reservations</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <h1 class="text-center">Current Reservations</h1>
    
    <!-- Filter Section -->
    <div class="mb-3">
        <label for="dateFilter" class="form-label">Filter Reservations:</label>
        <select id="dateFilter" class="form-select" onchange="window.location.href=this.value;">
            <option value="reservation.php?days=1" <?= isset($_GET['days']) && $_GET['days'] == 1 ? 'selected' : ''; ?>>Next 1 Day</option>
            <option value="reservation.php?days=7" <?= isset($_GET['days']) && $_GET['days'] == 7 ? 'selected' : ''; ?>>Next 7 Days</option>
            <option value="reservation.php?days=30" <?= isset($_GET['days']) && $_GET['days'] == 30 ? 'selected' : ''; ?>>Next 30 Days</option>
            <option value="reservation.php" <?= !isset($_GET['days']) ? 'selected' : ''; ?>>All Reservations</option>
        </select>
    </div>
    
    <?php if ($result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Time Slot</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                            <td><?php echo htmlspecialchars($row['time_slot']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="no-reservations-message text-center">No reservations have been made yet.</p>
    <?php endif; ?>
</div>

<footer>
    <h3 class="head-footer">Sports Booking</h3>
    <h5>For 2nd Floor</h5>
    <div class="footer-links">
        <a href="#rulesAndRegulations">Rules and Regulations</a> |
        <a href="#owners">Owners</a> |
        <a href="#book-your-ground">Booking</a> |
        <a href="cancel-booking.php">Cancel Booking</a> 
    </div>
    <div class="social-links">
        <a href="https://github.com/mking1837/2ndFloorBookingWeb" target="_blank">
            <i class="fab fa-github"></i>
        </a>
        <a href="https://www.linkedin.com/in/mking1538/" target="_blank">
            <i class="fab fa-linkedin"></i>
        </a>
    </div>
    <p>&copy; 2024 Sports Booking. All rights reserved.</p>
    <p><a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="js/script.js"></script>
<script src="https://kit.fontawesome.com/429ae836d4.js" crossorigin="anonymous"></script>
</body>
</html>

<?php $conn->close(); ?>
