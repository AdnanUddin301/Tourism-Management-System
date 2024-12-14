<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Tourism Management System</title>
    <style>
        /* Styles for carousel and other elements */
        /* Ensure the parent container has enough height to vertically center the carousel */
        body {
            display: flex;
            justify-content: center; /* Horizontally center the carousel */
            align-items: center; /* Vertically center the carousel */
            height: 100vh; /* Make sure the body takes up the full viewport height */
            margin: 0; /* Remove default margin */
        }

        /* Carousel container */
        .carousel {
            display: flex;
            overflow: hidden;
            position: relative;
            width: 80%; /* Control the width of the carousel */
            margin: 20px; /* Add some margin for spacing */
            justify-content: center; /* Horizontally center the items within the carousel */
        }

        /* Carousel item */
        .carousel-item {
            min-width: 80%; /* Ensure each item takes 80% of the carousel width */
            transition: transform 0.5s ease;
        }

        /* Image inside the carousel item */
        .carousel-item img {
            width: 100%; /* Set image width to 100% of the container */
            height: 400px; /* Fixed height for the images */
            object-fit: cover; /* Ensure image covers the container */
            border-radius: 10px; /* Rounded corners for images */
        }

        .welcome-section {
            text-align: center;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
        }

        .btn {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #34a832;
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        /* Button container */
        .btn-container {
            display: inline-block;
        }

        .btn-container a {
            display: inline-block;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<div class="welcome-section">
    <h2 style="font-family: 'Poppins', Arial, sans-serif; font-size: 2.5em; font-weight: bold; color:#34a832; background: linear-gradient(to right,#34a832, #3498db); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin: 20px 0; padding: 10px; text-transform: uppercase; letter-spacing: 2px;">
        Welcome to the Tourism Management System
    </h2>

    <?php if (isset($_SESSION['user_id'])): ?>
        <p style="font-size: 1.2em; color: #2c3e50; font-weight: bold; text-align: center; padding: 10px; background-color: #eaf2f8; border-radius: 5px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
            Welcome, <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Guest'; ?>!
        </p>

        <div class="btn-container">
            <a href="tourist_spots.php" class="btn">Tourist Spots</a>
            <a href="logout.php" class="btn" style="background-color: #e74c3c;">Log Out</a>
        </div>
    <?php else: ?>
        <p style="font-size: 1.1em; color: #2c3e50; margin: 20px 0;">
            Please sign in or sign up to start exploring our services.
        </p>
        
        <div class="btn-container">
            <a href="signin.php" class="btn">Sign In</a>
            <a href="signup.php" class="btn" style="background-color: #3498db;">Sign Up</a>
            <a href="signin.php" class="btn">Explore Tourist Spots</a>
            
        </div>
    <?php endif; ?>
</div>


<!-- Carousel Section -->
<div class="carousel rounded-box">
  <div class="carousel-item">
    <img src="assets/images/front1.jpg" alt="Image 1" />
  </div>
  <div class="carousel-item">
    <img src="assets/images/front2.jpg" alt="Image 2" />
  </div>
  <div class="carousel-item">
    <img src="assets/images/front3.jpg" alt="Image 3" />
  </div>
  <div class="carousel-item">
    <img src="assets/images/goa1.jpg" alt="Image 4" />
  </div>
  <div class="carousel-item">
    <img src="assets/images/emran.jpeg" alt="Image 5" />
  </div>
  <div class="carousel-item">
    <img src="assets/images/goa2.jpg" alt="Image 6" />
  </div>
  <div class="carousel-item">
    <img src="assets/images/mahdi.jpeg" alt="Image 7" />
  </div>
</div>

</body>
</html>