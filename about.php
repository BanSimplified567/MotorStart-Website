<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  <title>About MotorStart</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
    integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
    integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ"
    crossorigin="anonymous"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD2Hhh_14Uam62GXGaTMcXWhhVkYg0EbDY&callback=initMap"
    async defer></script>

  <!-- Custom CSS File Link -->
  <link rel="stylesheet" href="./assets/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- font awesome cdn link -->
  <link rel="icon" type="image/x-icon" href="./assets/image/favicon.ico"><!-- Favicon / Icon -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"><!-- Google font cdn link -->
</head>

<body>

  <header class="header">
    <a href="#" class="logo">
      <i class="fa-solid fa-bicycle"></i>
      <h3>MotorStart</h3>
    </a>

    <!-- MAIN MENU FOR SMALLER DEVICES -->
    <nav class="navbar navbar-expand-lg">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a href="index.php" class="text-decoration-none">Home</a>
        </li>
        <li class="nav-item">
          <a href="about.php" class="text-decoration-none">About</a>
        </li>
        <li class="nav-item">
          <a href="#contact" class="text-decoration-none">Contact</a>
        </li>
        <li class="nav-item">
          <a href="login.php" class="text-decoration-none">Logout</a>
        </li>
      </ul>
      </div>
    </nav>
    <div class="icons">

      <a href="index.php" class="text-decoration-none">
        <div class="fas fa-user"></div>
      </a>
    </div>

    <!-- SEARCH TEXT BOX -->
    <div class="search-form">
      <input type="search" id="search-box" class="form-control" placeholder="search here...">
      <label for="search-box" class="fas fa-search"></label>
    </div>

    <!-- CART SECTION -->
    <div class="cart">
      <h2 class="cart-title">Your Cart:</h2>
      <div class="cart-content">

      </div>
      <div class="total">
        <div class="total-title">Total: </div>
        <div class="total-price">₱0</div>
      </div>
      <!-- BUY BUTTON -->
      <button type="button" class="btn-buy">Checkout Now</button>
    </div>
  </header>
  <div class="main-about">
    <!-- Mission Section -->
    <section class="section2-container">
      <div class="section2">
        <span>
          <h1>OUR MISSION</h1>
          <p>
            Our mission is to revolutionize the motorcycle industry by creating machines that blend performance,
            innovation, and style. We aim to deliver motorcycles that offer the perfect ride for enthusiasts, from
            beginners to seasoned riders.
          </p>
        </span>
        <img src="./assets/image/bmw-1.jpg" alt="Motorcycle Model">
      </div>
    </section>

    <!-- Vision Section -->
    <section class="section2-container">
      <div class="section2">
        <img src="./assets/image/bmw-2.jpg" alt="Motorcycle Model">
        <span>
          <h1>OUR VISION</h1>
          <p>
            Our vision is to push the boundaries of motorcycle engineering and design, creating bikes that offer
            unmatched power, precision, and riding experience. We aim to be the leaders in the industry, inspiring
            riders across the globe.
          </p>
        </span>
      </div>
    </section>

    <!-- Team Section -->
    <section>
      <div class="section3-container">
        <div class="section3">
          <span class="section3-text">
            <h1>OUR TEAM</h1>
            <p>
              Our team is composed of passionate motorcycle enthusiasts, engineers, and designers who share a
              commitment to building the ultimate riding experience. We are dedicated to crafting bikes that
              embody performance, design, and adventure.
            </p>
          </span>
          <span class="section3-images">
            <img src="./assets/image/Model1.jpg" alt="Team Member 1">
            <img src="./assets/image/Model2.jpg" alt="Team Member 2">
            <img src="./assets/image/Model3.jpg" alt="Team Member 3">
          </span>
        </div>
      </div>
    </section>

    <!-- Brand Section -->
    <section class="section4-container">
      <div class="section4">
        <span>
          <h1>OUR BRAND</h1>
          <p>
            Our brand represents the spirit of freedom, adventure, and high performance. We create motorcycles
            that combine cutting-edge technology, superior craftsmanship, and timeless design, embodying the
            true essence of the riding experience.
          </p>
        </span>
      </div>
    </section>

    <!-- CEO Section -->
    <section class="section2-container">
      <div class="section-ceo">
        <span>
          <h1>THE CEO OF MOTORCYCLE INNOVATORS</h1>
          <p>
            Our CEO is a passionate motorcycle enthusiast and visionary, leading the company with a commitment to
            creating high-performance motorcycles that push the boundaries of design and technology. Under their
            leadership, we strive to be the forefront of innovation in the motorcycle industry.
          </p>
        </span>
        <img src="./assets/image/Ceo.webp" alt="CEO Image">
      </div>
    </section>
  </div>
  <!-- GALLERY SECTION -->
  <section class="gallery" id="gallery">
    <h1 class="heading">The <span>Gallery</span></h1>
    <div class="box-container">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="box">
              <div class="image">
                <img src="./assets/image/model1.jpg" alt="">
              </div>
              <div class="content">
                <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
                </div>
                <h3 class="gallery-title">Model 1</h3>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="box">
              <div class="image">
                <img src="./assets/image/model5.jpg" alt="">
              </div>
              <div class="content">
                <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
                </div>
                <h3 class="gallery-title">Model 2</h3>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="box">
              <div class="image">
                <img src="./assets/image/model6.jpg" alt="">
              </div>
              <div class="content">
                <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
                </div>
                <h3 class="gallery-title">Model 3</h3>
              </div>
            </div>
          </div>
        </div><br />
        <div class="row pic-to-hide">
          <div class="col-md-4">
            <div class="box">
              <div class="image">
                <img src="./assets/image/model4.jpg" alt="">
              </div>
              <div class="content">
                <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
                </div>
                <h3 class="gallery-title">Model 4</h3>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="box">
              <div class="image">
                <img src="./assets/image/Model2.jpg" alt="">
              </div>
              <div class="content">
                <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
                </div>
                <h3 class="gallery-title">Model 4</h3>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="box">
              <div class="image">
                <img src="./assets/image/Model3.jpg" alt="">
              </div>
              <div class="content">
                <div class="stars">
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
                </div>
                <h3 class="gallery-title">Model 5</h3>
              </div>
            </div>
          </div>
        </div><br />
        <center>
          <button id="showBtn" class="btn btn-dark">SHOW MORE</button>
        </center>
      </div>
    </div>
  </section>

  <!-- BLOGS SECTION -->
  <section class="blogs" id="blogs">
    <h1 class="heading">Our <span>Motorbike Blogs</span></h1>
    <div class="box-container">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="box">
              <div class="image">
                <img src="./assets/image/bmw-2.jpg" alt="">
              </div>
              <div class="content">
                <a href="https://www.motorcycle.com/2020/11/11/top-10-fastest-motorcycles/" target="_blank"
                  class="title text-decoration-none">Top 10 Fastest Motorcycles of 2020</a>
                <span>by Motorcycle.com</span>
                <p>We’ve seen some truly fast motorcycles in 2020. Here are the top 10, including bikes from Ducati,
                  Kawasaki, and more...</p>
                <center>
                  <a href="https://www.motorcycle.com/2020/11/11/top-10-fastest-motorcycles/" target="_blank"
                    class="btn">Read More</a>
                </center>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="box">
              <div class="image">
                <img src="./assets/image/bmw-3.png" alt="">
              </div>
              <div class="content">
                <a href="https://www.cycleworld.com/2023-best-motorcycles/" target="_blank"
                  class="title text-decoration-none">Best Motorcycles to Buy in 2023</a>
                <span>by CycleWorld</span>
                <p>Looking for a new bike? Here are the best motorcycles to buy in 2023, from cruisers to
                  sportbikes...</p>
                <center>
                  <a href="https://www.cycleworld.com/2023-best-motorcycles/" target="_blank" class="btn">Read
                    More</a>
                </center>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="box">
              <div class="image">
                <img src="./assets/image/bmw-4.jpg" alt="">
              </div>
              <div class="content">
                <a href="https://www.rideapart.com/learn-to-ride-motorcycle-guide/" target="_blank"
                  class="title text-decoration-none">Learn to Ride: A Beginner’s Guide</a>
                <span>by RideApart</span>
                <p>Starting your motorcycle journey? Here’s a guide for beginners that covers everything from safety
                  gear to the basics of riding...</p>
                <center>
                  <a href="https://www.rideapart.com/learn-to-ride-motorcycle-guide/" target="_blank" class="btn">Read
                    More</a>
                </center>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- TESTIMONIALS SECTION -->
  <section class="review" id="review">
    <h1 class="heading"><span>Motorbike</span> Testimonials</h1>
    <div class="box-container">
      <div class="container">
        <div class="row">
          <div class="col-md-4">
            <div class="box">
              <img src="./assets/image/quote-img.png" alt="" class="quote">
              <p>
                "Riding my new Ducati has been a dream come true. The handling is exceptional, and the speed is
                thrilling. I feel like I'm part of the road."
              </p>
              <img src="./assets/image/Testimony.jpg" alt="" class="user">
              <h3>Emma Stone</h3>
              <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="box">
              <img src="./assets/image/quote-img.png" alt="" class="quote">
              <p>
                "The Kawasaki Ninja ZX-6R has completely changed the way I view sportbikes. It's fast, sleek, and an
                absolute blast to ride on any terrain."
              </p>
              <img src="./assets/image/Testimony1.jpg" alt="" class="user">
              <h3>David Johnson</h3>
              <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="box">
              <img src="./assets/image/quote-img.png" alt="" class="quote">
              <p>
                "The Honda CRF450R has been my go-to for off-roading. It’s durable, powerful, and ready for any
                adventure. I can’t imagine riding anything else."
              </p>
              <img src="./assets/image/Testimony2.jpg" alt="" class="user">
              <h3>Michael Lee</h3>
              <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- CONTACT US SECTION -->
  <section class="contact" id="contact">
    <h1 class="heading"><span>Contact</span> Us</h1>
    <div class="row">
      <div id="map" class="map pull-left">
        <iframe class="map"
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31685.2855924705!2d123.59879!3d10.01897!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33ab90e2b2994dbd%3A0xabababab!2sSibonga%20Community%20College%2C%20Cebu!5e0!3m2!1sen!2sph!4v1234567890123!5m2!1sen!2sph"
          width="400" height="200" style="border: 0" allowfullscreen="" loading="lazy"></iframe>

      </div>
      <form name="contact" method="POST" action="https://formspree.io/f/xayzavgb">
        <h3> Get in touch with us!</h3>
        <div class="inputBox">
          <span class="fas fa-envelope"></span>
          <input type="email" name="email" placeholder="Email Address">
        </div>
        <div class="inputBox">
          <textarea name="message" placeholder="Enter your message..."></textarea>
        </div>
        <button type="submit" class="btn">Contact Now</button>
      </form>
    </div>
  </section>


  <!-- FOOTER SECTION -->
  <section class="footer">
    <div class="footer-container">
      <div class="logo">
        <img src="./assets/image/MotorLogo.jpg" class="img"><br />
        <i class="fas fa-envelope"></i>
        <p>SibongaSCC@gmail.com</p><br />
        <i class="fas fa-phone"></i>
        <p>+63 912-456-789</p><br />
        <i class="fab fa-facebook-messenger"></i>
        <p>@MotorStart</p><br />
      </div>
      <div class="support">
        <h2>Support</h2>
        <br />
        <a href="#">Contact Us</a>
        <a href="#">Customer Service</a>
        <a href="#">Chatbot Inquiry</a>
        <a href="#">Submit a Ticket</a>
      </div>
      <div class="company">
        <h2>Company</h2>
        <br />
        <a href="#">About Us</a>
        <a href="#">Affiliates</a>
        <a href="#">Resources</a>
        <a href="#">Partnership</a>
        <a href="#">Suppliers</a>
      </div>
      <div class="newsletters">
        <h2>Newsletters</h2>
        <br />
        <p>Subscribe to our newsletter for news and updates!</p>
        <div class="input-wrapper">
          <input type="email" class="newsletter" placeholder="Your email address">
          <i id="paper-plane-icon" class="fas fa-paper-plane"></i>
        </div>
      </div>
    </div>
  </section>


  <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
  <script src="./assets/js/script.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</body>

</html>
