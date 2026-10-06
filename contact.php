<?php
declare(strict_types=1);

session_start();

// Start a form session and create a token to protect submissions.
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$status = $_SESSION['contact_status'] ?? null;
unset($_SESSION['contact_status']);

// Escape visitor-facing text before placing it in the page.
function h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?><!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="Contact Sea Asia Shipping Services LLP in Bhopal, Madhya Pradesh, for logistics and shipping enquiries.">
    <title>Contact | Sea Asia Shipping Services LLP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <script defer src="https://cdn.jsdelivr.net/npm/gsap@3.15.0/dist/gsap.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/gsap@3.15.0/dist/ScrollTrigger.min.js"></script>
    <script src="assets/js/main.js" defer></script>
  </head>
  <body>
    <a class="skip-link" href="#main">
      Skip to content
    </a>
    <header class="site-header">
      <div class="container header-inner">
        <a class="brand" href="index.html">
          <img class="brand-mark" src="assets/images/sea-asia-emblem.png" alt="">
          <span class="brand-name">SEA ASIA<span>SHIPPING SERVICES LLP</span></span>
        </a>
        <button class="nav-toggle" aria-expanded="false" aria-controls="primary-nav" aria-label="Open menu">
          <span></span><span></span><span></span>
        </button>
        <nav class="primary-nav" id="primary-nav" aria-label="Main navigation">
          <a href="index.html">
            Home
          </a>
          <a href="pages/Explore%20Sea%20Asia.html">
            Explore Sea Asia
          </a>
          <a href="pages/solutions.html">
            Solutions
          </a>
          <a href="pages/why-us.html">
            Why Us
          </a>
          <a href="pages/process.html">
            Our Processes
          </a>
          <a href="pages/gallery.html">
            Gallery
          </a>
        </nav>
        <a class="button button-small header-cta" href="contact.php">
          Request a Quote <span>&#8599;</span>
        </a>
      </div>
    </header>
    <main id="main">
      <section class="page-hero">
        <div class="container">
          <p class="breadcrumb">
            <a href="index.html">
              Home
            </a>
            / Contact
          </p>
          <p class="eyebrow eyebrow-light">
            <span></span> CONTACT SEA ASIA
          </p>
          <h1>
            Letâ€™s talk about<br><em>your shipment.</em>
          </h1>
          <p>
            Send us a few details and our team can follow up about your logistics requirements.
          </p>
        </div>
      </section>
      <section class="content-section">
        <div class="container contact-layout">
          <!-- Business location and service information -->
          <aside class="contact-details">
            <p class="eyebrow eyebrow-light">
              <span></span> START A CONVERSATION
            </p>
            <h2>
              Tell us what youâ€™re moving.
            </h2>
            <p>
              Sea Asia Shipping Services LLP is based in Bhopal, Madhya Pradesh. Use the form to tell us what solution you need and how we can reach you.
            </p>
            <p class="detail-label">
              Location
            </p>
            <p>
              Bhopal, Madhya Pradesh, India
            </p>
            <p class="detail-label">
              Solutions
            </p>
            <p>
              Customs Â· Freight Â· Transportation Â· Warehousing Â· Project Logistics
            </p>
            <p class="detail-label">
              Prefer a direct contact?
            </p>
            <p>
              Add the companyâ€™s verified phone number and business email here before publishing.
            </p>
          </aside>
          <div>
            <!-- Enquiry form and its submission status -->
            <?php if ($status): ?>
            <div class="form-status <?= ($status['type'] ?? '') === 'error' ? 'error' : '' ?>" role="status">
              <?= h((string)$status['message']) ?>
            </div>
            <?php endif; ?>
            <form class="contact-form" action="php/contact-submit.php" method="post">
              <input type="hidden" name="csrf_token" value="<?= h($_SESSION['csrf_token']) ?>">
              <div class="hp-field" aria-hidden="true">
                <label for="website">
                  Leave this field empty
                </label>
                <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
              </div>
              <div class="form-field">
                <label for="name">
                  Your name *
                </label>
                <input id="name" name="name" required maxlength="100" autocomplete="name">
              </div>
              <div class="form-field">
                <label for="company">
                  Company
                </label>
                <input id="company" name="company" maxlength="150" autocomplete="organization">
              </div>
              <div class="form-field">
                <label for="email">
                  Work email *
                </label>
                <input id="email" name="email" type="email" required maxlength="190" autocomplete="email">
              </div>
              <div class="form-field">
                <label for="phone">
                  Phone
                </label>
                <input id="phone" name="phone" type="tel" maxlength="30" autocomplete="tel">
              </div>
              <div class="form-field full">
                <label for="service">
                  Solution youâ€™re interested in
                </label>
                <select id="service" name="service">
                  <option value="">Choose a solution</option><option>Customs clearance</option><option>Import / Export</option><option>Air freight</option><option>Ocean freight</option><option>Road transportation</option><option>Warehousing</option><option>Project logistics</option><option>Shipment documentation</option><option>Other / not sure</option>
                </select>
              </div>
              <div class="form-field full">
                <label for="message">
                  Shipment details *
                </label>
                <textarea id="message" name="message" required maxlength="5000" placeholder="Tell us about the cargo, origin, destination, timing or support you need.">
                </textarea>
              </div>
              <div class="form-field full">
                <p class="form-note">
                  Please avoid sending confidential or sensitive personal information in this form.
                </p>
                <button class="button" type="submit">
                  Send enquiry <span aria-hidden="true">&#8599;</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </section>
    </main>
    <footer class="site-footer">
      <div class="container footer-main">
        <a class="brand brand-footer" href="index.html">
          <img class="brand-mark" src="assets/images/sea-asia-emblem.png" alt="">
          <span class="brand-name">SEA ASIA<span>SHIPPING SERVICES LLP</span></span>
        </a>
        <p>
          Shipping and logistics support<br>from Bhopal, Madhya Pradesh.
        </p>
        <div class="footer-links">
          <span>Explore</span>
          <a href="pages/Explore%20Sea%20Asia.html">
            Explore Sea Asia
          </a>
          <a href="pages/solutions.html">
            Solutions
          </a>
          <a href="pages/process.html">
            Our Processes
          </a>
          <a href="contact.php">
            Contact
          </a>
        </div>
        <div class="footer-contact">
          <span>Get in touch</span>
          <a href="contact.php">
            Send an enquiry &#8599;
          </a>
        </div>
      </div>
      <div class="container footer-bottom">
        <span>Â© <span data-year>2026</span> Sea Asia Shipping Services LLP</span><span>Bhopal, Madhya Pradesh, India</span>
      </div>
    </footer>
  </body>
</html>
