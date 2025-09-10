<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2nd Floor Booking</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="images/logo.png" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    
</head>
<body>

    <nav class="navbar  navbar-expand-lg bg-body-tertiary">
        <div class="navbarcolor container-fluid">
          <a class="navbar-brand" href="#">
            <img src="images/logo.png" class="logo" alt="Bootstrap" >
            Sports Booking
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class=" navbar-nav me-auto mb-2 mb-lg-0 " >
                <li class="nav-item">
                    <a class="nav-link"  aria-current="page" href="#book-your-ground">Book</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link"  href="#rulesAndRegulations">Rules And Regulations</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link"  href="#owners">Owner</a>
                  </li>
                  <!-- Reservations Page Link in the Navbar -->
                    <li class="nav-item">
                    <a class="nav-link" href="reservation.php">Reservations</a>
                    </li><li class="nav-item">
                    <a class="nav-link" href="wow.php">Chat Services</a>
                    </li>

            </ul>
            
          </div>
        </div>
      </nav>
    <div class=" booking-open">
        Booking is open both (Online And Offline)
    </div>
    <div class="our-ground">
        <h1>Play And Enjoy in Our <a href="place.html">Place</a></h1>
        <h2><a href="#book-your-ground">Book Here</a></h2>
    </div>
    <div id="book-your-ground">
      <div class="container">
          <div class="row">
              <div class="col-lg-12 text-center">
                  <h1>Plan Your Next Victory Here</h1>
              </div>
          </div>
          <form action="" method="post">
              <div class="row main-book">
                  <div class="col-md-6">
                      <input class="boook" type="text" name="name" placeholder="Your Good Name" required>
                  </div>
                  <div class="col-md-6">
                      <input class="boook" type="email" name="email" placeholder="Email Address Please" required>
                  </div>
              </div>
              <div class="row main-book">
                  <div class="col-md-6">
                      <input class="boook" type="date" name="booking_date" placeholder="Select Date" required>
                  </div>
                  <div class="col-md-6">
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
                  </div>
              </div>
              <div class="row main-book">
                  <div class="col-md-12 text-center">
                      <button type="submit" class="boook" name="book-btn">Book Now</button>
                  </div>
              </div>
          </form>
      </div>
  </div>
  <?php
// Database connection setup
$conn = new mysqli("sql201.infinityfree.com", "if0_37585900", "G0XnHXPcEJLW5Y", "if0_37585900_2ndfloorbooking");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["book-btn"])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $booking_date = $_POST['booking_date'];
    $time_slot = $_POST['time_slot'];

    // Get today's date
    $today = date("Y-m-d");

    // Check if the booking date is in the past
    if ($booking_date < $today) {
        echo "<script>alert('You cannot book a date in the past. Please select a valid date.');</script>";
    } else {
        // Check if the user has booked for the selected day
        $stmt = $conn->prepare("SELECT * FROM bookings WHERE email = ? AND booking_date = ?");
        $stmt->bind_param("ss", $email, $booking_date);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<script>alert('You have already booked a time slot for this day.');</script>";
        } else {
            // Check if the time slot is already booked
            $stmt = $conn->prepare("SELECT * FROM bookings WHERE booking_date = ? AND time_slot = ?");
            $stmt->bind_param("ss", $booking_date, $time_slot);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo "<script>alert('This time slot is already booked by someone else. Please choose a different time slot.');</script>";
            } else {
                // Insert booking
                $stmt = $conn->prepare("INSERT INTO bookings (name, email, booking_date, time_slot) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $name, $email, $booking_date, $time_slot);
                
                if ($stmt->execute()) {
                    $id = $conn->insert_id; 
                    echo "<script>alert('Booking successful! Your booking key is: $id\\n\\nThis key is very important for cancellations and further actions. Please save it safely.');</script>";
                } else {
                    echo "<script>alert('Error in booking.');</script>";
                }
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>


    <div class="rulesAndRegulations" id="rulesAndRegulations">
        <h2>Rules And Regulations</h2>
        <h3>Rules for Playing Football in an Apartment Corridor</h3>
        <p><strong>1. No Kicking or Hard Shots:</strong> To avoid damage to walls and floors, use soft kicks and avoid hard shots.</p>
        <p><strong>2. Use a Soft Ball:</strong> Use a soft, inflatable ball designed for indoor use to minimize damage and noise.</p>
        <p><strong>3. Keep the Volume Down:</strong> Avoid loud shouting or cheering to respect neighbors and maintain a peaceful environment.</p>
        <p><strong>4. Clear the Area:</strong> Ensure the corridor is free of obstacles and that everyone has enough space to play safely.</p>
        <p><strong>5. Respect Other Residents:</strong> Be mindful of other residents' needs and schedules. If someone needs to pass through, stop the game and allow them to go through.</p>
        <p><strong>6. No Sliding or Rough Play:</strong> Sliding or rough play can damage flooring or walls. Keep movements controlled and gentle.</p>
        <p><strong>7. Clean Up After Playing:</strong> After the game, clean up any mess and return the corridor to its original state.</p>
        <p><strong>8. No Food or Drinks:</strong> To prevent spills and messes, no food or drinks should be brought into the playing area.</p>
        <p><strong>9. Supervision for Children:</strong> If children are playing, ensure they are supervised to prevent accidents and ensure safe play.</p>
        <p><strong>10. Adhere to Building Policies:</strong> Follow any specific rules or guidelines set by your building management regarding activities in common areas.</p>
        <p><strong>11. No Damage to Fixtures:</strong> Any damage to lights, doorbells, or other fixtures will be considered a serious offense and may result in fines to cover repair or replacement costs.</p>
  
        <h3>Rules for Playing Cricket in an Apartment Corridor</h3>
        <p><strong>1. No Fast Shots:</strong> To avoid damage to walls and floors, do not play fast or hard shots. Use gentle swings and soft balls.</p>
        <p><strong>2. Stop While Someone is Passing:</strong> If someone needs to pass through the corridor, stop the game and let them through. Resume play once the area is clear.</p>
        <p><strong>3. Use a Soft Ball:</strong> Use a soft, lightweight cricket ball designed for indoor use to reduce noise and prevent damage.</p>
        <p><strong>4. Keep the Volume Down:</strong> Avoid loud shouting or cheering to maintain a peaceful environment for other residents.</p>
        <p><strong>5. Clear the Area:</strong> Ensure the corridor is free of obstacles and that everyone has enough space to play safely.</p>
        <p><strong>6. No Sliding or Rough Play:</strong> Avoid sliding or rough play to prevent damage to flooring or walls.</p>
        <p><strong>7. Clean Up After Playing:</strong> Clean up any mess and restore the corridor to its original state after the game.</p>
        <p><strong>8. No Food or Drinks:</strong> Do not bring food or drinks into the playing area to avoid spills and messes.</p>
        <p><strong>9. Supervision for Children:</strong> Ensure that children are supervised during play to prevent accidents and ensure safe play.</p>
        <p><strong>10. Adhere to Building Policies:</strong> Follow any specific rules or guidelines set by your building management regarding activities in common areas.</p>
        <p><strong>11. No Damage to Fixtures:</strong> Any damage to lights, doorbells, or other fixtures will be considered a serious offense and may result in fines to cover repair or replacement costs.</p>
    
    </div><br><br>
    <div class="owners row" id="owners">
        <div class="col-sm-3">
            
          </div>
          <div class="col-sm-6">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title" style="color:black !important;">Muhammed Mohsin</h5>
                <p class="card-text"  style="color:black !important;">Reach out for further assistance or questions.</p>
                <a class="contact-button whatsapp-button" href="https://wa.me/923152801587" target="_blank">
                   <i class="fa-brands fa-square-whatsapp fa-beat-fade fa-2xl" style="color: #63E6BE;"></i>
                </a>
                <a class="contact-button github-button" href="https://github.com/mking1837" target="_blank">
                   <i class="fa-brands fa-square-github fa-beat-fade fa-2xl" style="color: #000000;"></i>
                </a>
                <a class="contact-button github-button" href="https://mohsinpro123.mystrikingly.com/" target="_blank">
                   <i class="fa-solid fa-globe fa-beat-fade fa-2xl" style="color: #74C0FC;"></i>
                </a>
                
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            
          </div>
    </div><br><br>
    
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
           <a href="https://github.com/mking1837/" target="_blank">
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