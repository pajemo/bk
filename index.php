<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pajemo Bank - Home</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">

        <div class="carousel-item active" style="background-image: url('images/slide1.png');">
          <div class="carousel-caption">
            <h1>Welcome to Pajemo Bank</h1> <br>
            <p class="pp">Your trusted partner in financial growth.</p>
          </div>
        </div>

        <div class="carousel-item" style="background-image: url('images/slide2.png');">
          <div class="carousel-caption">
            <h1>Secure Online Banking</h1> <br>
            <p class="pp">Manage your accounts anytime, anywhere.</p>
          </div>
        </div>

        <div class="carousel-item" style="background-image: url('images/slide3.png');">
          <div class="carousel-caption">
            <h1>Personalized Financial Solutions</h1> <br>
            <p class="pp">Tailored services to meet your needs.</p>
          </div>
        </div>

      </div>

      <!-- Carousel Controls -->
      <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    var heroCarousel = document.querySelector('#heroCarousel');
    var carousel = new bootstrap.Carousel(heroCarousel, {
        interval: 4000, // 2 seconds between slides
        pause: 'hover', // pause when you hover
        ride: 'carousel'
    });
});
</script>

<section class="banners">
    <div class="banner-item">
        <h3>Low Interest Rates</h3>
        <p>Enjoy competitive rates on all our loan products.</p>
    </div>
    <div class="banner-item">
        <h3>24/7 Customer Support</h3>
        <p>Our team is here to help you anytime, anywhere.</p>
    </div>
    <div class="banner-item">
        <h3>Secure Transactions</h3>
        <p>Bank with confidence using our advanced security measures.</p>
    </div>
</section>

<section class="features">
    <h2>Our Services</h2>
    <div class="feature-list">
        <div class="feature-item">
            <img src="images/service1.png" alt="Online Banking">
            <h3>Online Banking</h3>
            <p>Access your accounts and manage your finances online securely and conveniently.</p>
        </div>
        <div class="feature-item">
            <img src="images/service2.png" alt="Loans">
            <h3>Loans</h3>
            <p>Flexible loan options to help you achieve your personal and business goals.</p>
        </div>
        <div class="feature-item">
            <img src="images/service3.png" alt="Investment">
            <h3>Investment</h3>
            <p>Grow your wealth with our expert investment services and advice.</p>
        </div>
    </div>
</section>

<section class="promotions">
    <h2>Current Promotions</h2>
    <div class="promotion-item">
        <h4>Summer Savings Account</h4>
        <p>Open a savings account this summer and earn a bonus interest rate.</p>
    </div>
    <div class="promotion-item">
        <h4>Home Loan Special</h4>
        <p>Get reduced rates on home loans for a limited time.</p>
    </div>
</section>

<section class="testimonials">
    <h2>What Our Customers Say</h2>
    <div class="testimonial-list">
        <div class="testimonial-item">
            <p>"Pajmeo Bank has transformed the way I manage my finances. Their online banking platform is intuitive and reliable."</p>
            <div class="author">- Sarah K.</div>
        </div>
        <div class="testimonial-item">
            <p>"The loan process was smooth and transparent. I highly recommend Pajmeo Bank for their excellent customer service."</p>
            <div class="author">- Michael B.</div>
        </div>
    </div>
</section>

<section class="cta">
    <h2>Ready to take control of your finances?</h2>
    <a href="register.php">Open an Account Today</a>
</section>

<section class="credit-card-explore" style="text-align: center; margin: 3rem 0;">
    <h2>Explore PajemoBank® / AAdvantage® Credit Cards</h2>
    <img src="images/credit-card-large.png" alt="PajemoBank Credit Cards" style="max-width: 100%; height: auto; margin: 1rem 0;">
    <br>
    <a href="credit-cards.php" class="btn btn-primary btn-lg">Learn More</a>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const carouselSlide = document.getElementById('carousel-slide');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    let counter = 0;
    const totalSlides = carouselSlide.children.length;

    function showSlide(index) {
        if (index < 0) {
            counter = totalSlides - 1;
        } else if (index >= totalSlides) {
            counter = 0;
        } else {
            counter = index;
        }
        carouselSlide.style.transform = 'translateX(' + (-counter * 100) + '%)';
    }

    // Show initial slide
    showSlide(counter);

    prevBtn.addEventListener('click', () => {
        showSlide(counter - 1);
    });

    nextBtn.addEventListener('click', () => {
        showSlide(counter + 1);
    });

    // Auto slide every 5 seconds
    setInterval(() => {
        showSlide(counter + 1);
    }, 5000);
});

document.addEventListener('DOMContentLoaded', function() {
  const section = document.querySelector('.credit-card-explore');

  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        section.classList.add('show');
        observer.unobserve(section); // Only animate once
      }
    });
  }, { threshold: 0.2 }); // Trigger when 20% is visible

  observer.observe(section);
});
</script>

<?php include 'footer.php'; ?>
</body>
</html>
