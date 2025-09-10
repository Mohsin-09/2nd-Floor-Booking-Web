<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Booking</title>
    <link rel="stylesheet" href="css/cancel-style.css">
    <link rel="icon" href="images/logo.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div id="cancel-booking">
        <h1>Cancel Your Booking</h1>
        <form method="POST" action="">
            <label for="id">Id:</label>
            <input type="text" name="id" id="id" required><br><br>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required><br><br>
            <label for="booking_date">Booking Date:</label>
            <input type="date" name="booking_date" id="booking_date" required><br><br>
            <label for="time_slot">Time Slot:</label>
            <select class="select-book" name="time_slot" required>
                <option value="" disabled selected>Select Time Slot</option>
                <option value="12-1">12 PM - 1 PM</option>
                <option value="1-2">1 PM - 2 PM</option>
                <option value="2-3">2 PM - 3 PM</option>
                <option value="3-4">3 PM - 4 PM</option>
                <option value="4-5">4 PM - 5 PM</option>
                <option value="5-6">5 PM - 6 PM</option>
                <option value="6-7">6 PM - 7 PM</option>
                <option value="7-8">7 PM - 8 PM</option>
                <option value="8-9">8 PM - 9 PM</option>
            </select>
            <input type="submit" name="cancel-btn" value="Cancel Booking">
        </form>
    </div>

       <?php
        // Database connection
        $conn = mysqli_connect("sql201.infinityfree.com", "if0_37585900", "G0XnHXPcEJLW5Y", "if0_37585900_2ndfloorbooking");

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        if (isset($_POST["cancel-btn"])) {
            $id = mysqli_real_escape_string($conn, $_POST['id']);
            $name = mysqli_real_escape_string($conn, $_POST['name']);      
            $booking_date = mysqli_real_escape_string($conn, $_POST['booking_date']);
            $time_slot = mysqli_real_escape_string($conn, $_POST['time_slot']);

            // Verify booking
            $query = "SELECT * FROM bookings WHERE id = '$id' AND name = '$name'AND booking_date = '$booking_date' AND time_slot = '$time_slot'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                $delete_query = "DELETE FROM bookings WHERE id = '$id' AND name = '$name'  AND  booking_date = '$booking_date' AND time_slot = '$time_slot'";
                if (mysqli_query($conn, $delete_query)) {
                    echo "<script>alert('Booking canceled successfully.');</script>";
                } else {
                    echo "<script>alert('Error canceling booking.');</script>";
                }
            } else {
                echo "<script>alert('No booking found with the provided details.');</script>";
            }
        }
        
        mysqli_close($conn);
    ?>

    <footer>
        <h3 class="head-footer">Sports Booking</h3>
        <h5>For 2nd Floor</h5>
        <div class="footer-links">
            <a href="index.php#rulesAndRegulations">Rules and Regulations</a> |
            <a href="index.php#owners">Owners</a> |
            <a href="index.php#book-your-ground">Booking</a> 
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
    <script src="https://kit.fontawesome.com/429ae836d4.js" crossorigin="anonymous"></script>
</body>
</html>