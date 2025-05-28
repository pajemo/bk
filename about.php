<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>About Pajemo Bank</title>
<style>
  body {
    font-family: "Helvetica Neue", sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
    color: #333;
  }.content {
  max-width: 900px;
  margin: 3rem auto;
  padding: 2rem;
  background: #ffffff;
  border-radius: 12px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
  display: flex;
  flex-direction: column;
  align-items: center; /* Center all children including short paragraphs! */
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  opacity: 0;
  transform: translateY(20px);
  animation: fadeInUp 0.8s forwards ease-out;
}

.content p, 
.content li {
  text-align: justify; /* For clean left+right text edges */
  max-width: 700px; /* Prevent stretching full width */
  margin: 0.5rem auto; /* Center horizontally within flex container */
  transition: box-shadow 0.3s ease;
  display: block;
}
  .content:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.12);
  }

  h1 {
    font-size: 2rem;
    color: #222;
    margin-bottom: 1rem;
    font-weight: 700;
    text-align: center;
  }

  h2 {
    font-size: 1.5rem;
    color: #5e2b97;
    margin-bottom: 1rem;
    font-weight: 600;
  }

  p:hover, li:hover {
    box-shadow: 0 4px 16px rgba(93, 12, 208, 0.2);
    border-radius: 4px;
    background: #f3f0fa;
    padding: 0.3rem;
    text-align: center;
  }

  ul {
    list-style-type: disc;
    margin-left: 1.5rem;
    padding-left: 0;
  }

  .statement {
  text-align: center; /* Center headings and images */
}

  .section-image {
    max-width: 150px;
    border-radius: 8px;
    margin: 1rem 0;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  }

  .section-image:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
  }

  @keyframes fadeInUp {
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }
</style>
</head>
<body>

<div class="content">
  <h1>About Pajemo Bank</h1>
  <p>At Pajemo Bank, we are committed to providing exceptional financial services tailored to meet the needs of our customers. Our mission is to empower individuals and businesses to achieve their financial goals through innovative solutions and personalized support.</p>

  <div class="statement">
    <h2>Our Mission</h2>
    <img src="https://via.placeholder.com/150" alt="Our Mission Image" class="section-image" />
    <p>To deliver secure, accessible, and customer-centric banking services that foster financial growth and stability for our community.</p>
  </div>

  <div class="statement">
    <h2>Our Vision</h2>
    <img src="https://via.placeholder.com/150" alt="Our Vision Image" class="section-image" />
    <p>To be the leading bank recognized for innovation, integrity, and excellence in customer service.</p>
  </div>
</div>

<div class="content">
  <div class="statement">
    <h2>Our History</h2>
    <p>Founded in 1990, Pajemo Bank has grown from a small local bank to a trusted financial institution serving thousands of customers nationwide.</p>
  </div>

  <div class="statement">
    <h2>Our Values</h2>
    <ul>
      <li>Integrity: We uphold the highest standards of honesty and ethics.</li>
      <li>Customer Focus: Our customers are at the heart of everything we do.</li>
      <li>Innovation: We embrace new technologies to improve banking experiences.</li>
      <li>Community: We are committed to supporting and giving back to our communities.</li>
    </ul>
  </div>

  <div class="statement">
    <h2>Leadership Team</h2>
    <p>Our leadership team consists of experienced professionals dedicated to driving the bank's success and ensuring excellent customer service.</p>
  </div>

  <div class="statement">
    <h2>Corporate Social Responsibility</h2>
    <p>Pajemo Bank actively participates in community development programs and promotes sustainable banking practices.</p>
  </div>

  <div class="statement">
    <h2>Awards and Recognition</h2>
    <p>We have been recognized for excellence in banking services and innovation by various industry organizations.</p>
  </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
