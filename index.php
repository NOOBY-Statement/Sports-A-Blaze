<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset = "UTF-8">
        <meta name = "viewport" content="width=device-width, initial-scale=1.0">
        <title>Sports A-Blaze</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

        <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
            <div class="container-fluid">
              <a class="navbar-brand" href="#" style="font-weight:bold; font-size:18px; padding-left: 70px;">
                <img src="logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-top">
                Sports A-Blaze
              </a>
              
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
              
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                  <li class="nav-item">
                    <a class="nav-link" href="#home">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#services">Services</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                  </li>
                  <br>
                  <form class="d-flex" action="login.php" method="POST"> <!--login button-->
                    <button class="btn btn-outline-success" type="submit">LOGIN</button>
                  </form>
              </div>
            </div>
          </nav>
<br>
<br>
        
    <!-- Hero Section -->
    <div class="hero-header" id="home">
        <div class="container hero-content">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-5" style="font-weight:bold;">STREAMLINING <span style="color:red; font-weight:bold;">SPORTS</span> EQUIPMENT AND COURT MANAGEMENT</h1>
                    <form action="signup.php" method="POST">
                    <button type="submit" class="btn btn-custom mt-4">Get Started</button>
                    </form>
                </div>
               
            </div>
        </div>
    </div>


<!-- Services Section -->
<section id="services" class="py-5">
    <div class="container1">
        <br>
        <br>
        <br>
      <!-- Carousel -->
      <div class="carousel-container mb-4 position-relative">
        <div id="services-carousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000"> <!-- Interval in milliseconds (5000 = 5 seconds) -->
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="bball_court.jpg" class="d-block w-100 service-img" alt="Service 1">
            </div>
            <div class="carousel-item">
              <img src="vball_court.jpg" class="d-block w-100 service-img" alt="Service 2">
            </div>
            <div class="carousel-item">
              <img src="badmin_court.jpg" class="d-block w-100 service-img" alt="Service 3">
            </div>
            <div class="carousel-caption text-start">
                <div class="carousel-description">
                  <h3>Court</h3>
                  <p>Our state-of-the-art sports complex features premium courts for basketball, volleyball, and badminton. 
                    Equipped with high-quality hardwood flooring, a smooth surface with adjustable nets, and a meticulously designed anti-slip surface, 
                    ensuring a top-tier experience for players of all skill levels. 
                    Whether you're here for a game, a practice, or a tournament, our facility promises a dynamic and engaging environment for all athletes.</p>
                    <form action="login.php" method="POST">
                    <button type="submit" class="btn btn-primary">Reserve Now</button>
                    </form>
                </div>
              </div>
          </div>
        </div>
      </div>
      <!-- End Carousel -->
  
      <br>
      <br>
      <br>
  
      <!-- Equipment Carousel -->
      <div class="carousel-container position-relative">
        <div id="equipment-carousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="2000"> <!-- Interval in milliseconds (5000 = 5 seconds) -->
          <div class="carousel-inner">
            <div class="carousel-item active">
              <img src="e1.jpeg" class="d-block w-100 service-img" alt="Equipment 1">
            </div>
            <div class="carousel-item">
              <img src="equip2.jpg" class="d-block w-100 service-img" alt="Equipment 2">
            </div>
            <div class="carousel-item">
              <img src="e3.jpg" class="d-block w-100 service-img" alt="Equipment 3">
            </div>
            <div class="carousel-caption text-start">
                <div class="carousel-description">
                  <h3>Equipment</h3>
                  <p>Experience the ultimate range of sports equipment for basketball, volleyball, and badminton all in one place. 
                    Whether you're hitting the court with a premium basketball, spiking a high-quality volleyball, or smashing a durable badminton shuttlecock, 
                    we've got you covered. Our collection includes top-of-the-line balls, nets, rackets, and accessories to elevate your game. 
                    Click here to elevate your performance today!</p>
                    <form action="login.php" method="POST">
                    <button type="submit" class="btn btn-primary">Reserve Now</button>
                    </form>
                </div>
              </div>
          </div>
        </div>
      </div>
      <!-- End Equipment Carousel -->
    </div>
  </section>
  
  <br>
  <br>

<!-- Footer -->
<footer id="about" class="bg-dark text-white py-4">
    <div class="container mt-2">
        <div class="row justify-content-between">
            <div class="col-md-4 mb-3 text-start">
                <h5>Contact Us</h5>
                <p>
                    <ion-icon name="location"></ion-icon> 143 Revolution St. Paris, France <br>
                    <ion-icon name="call"></ion-icon> (123) 456-7890<br>
                    <a href="mailto:sportsblaze.tester@gmail.com">
                      <ion-icon name="mail"></ion-icon> sportsblaze.tester@gmail.com
                    </a>
                </p>
            </div>
            <div class="col-md-8 mb-3">
                <h5>About the Company</h5>
                <p>Sports A-Blaze is your one-stop shop for all your sports equipment needs.</p>
                <p>At Sports A-Blaze, we simplify your game. Hitting the court for a basketball match, 
                  spiking it in a volleyball game, or smashing it in a badminton rally? We've got you covered! 
                  Our easy-to-use platform allows you to browse and reserve high-quality sports equipment with just a few clicks. 
                  Perfect for players of all levels, our extensive inventory ensures that you always have access to the best gear when you need it.
                  Play more, stress less - reserve your equipment today with Sports A-Blaze.</p>
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
            <a href="https://www.facebook.com/YourFacebookPage" class="text-white me-3">
                    <ion-icon name="logo-facebook"></ion-icon>
                </a>
                <a href="https://twitter.com/YourTwitterHandle" class="text-white me-3">
                    <ion-icon name="logo-twitter"></ion-icon>
                </a>
                <a href="https://www.instagram.com/YourInstagramHandle" class="text-white">
                    <ion-icon name="logo-instagram"></ion-icon>
                </a>
            </div>
        </div>
        <div class="text-center mt-3">
            <p>&copy; 2024 Sports A-Blaze. All rights reserved.</p>
        </div>
    </div>
</footer>






    <!-- Scripts -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
</html>
