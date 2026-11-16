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
    <meta name="viewport" content="width=device-width,initial-scale=1"><link rel="icon" type="image/svg+xml" href="assets/images/favicon.svg">
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
    <div class="header-contact-bar"><div class="container header-contact-inner"><span class="header-contact-location"><svg viewBox="0 0 20 20" aria-hidden="true"><path d="M10 18s6-5.1 6-10a6 6 0 1 0-12 0c0 4.9 6 10 6 10Z"/><circle cx="10" cy="8" r="2"/></svg><span>Shipping and logistics support <b>·</b> Bhopal, India</span></span><div class="header-contact-links"><a href="mailto:info@seaasiashipping.com" aria-label="Email Sea Asia at info@seaasiashipping.com"><svg viewBox="0 0 20 20" aria-hidden="true"><rect x="2.5" y="4" width="15" height="12" rx="1.5"/><path d="m3.5 5 6.5 5 6.5-5"/></svg><span>info@seaasiashipping.com</span></a><a href="tel:+918319852739" aria-label="Call Sea Asia at plus 91 83198 52739"><svg viewBox="0 0 20 20" aria-hidden="true"><path d="M5.2 2.8h2.4l1.2 3.5-1.7 1.4a12.2 12.2 0 0 0 5.2 5.2l1.4-1.7 3.5 1.2v2.4a1.7 1.7 0 0 1-1.8 1.7A13.7 13.7 0 0 1 3.5 4.6a1.7 1.7 0 0 1 1.7-1.8Z"/></svg><span>+91 83198 52739</span></a></div></div></div>
      <div class="container header-inner">
        <a class="brand" href="index.html">
          <img class="brand-mark" src="assets/images/logo.png" alt="Sea Asia Shipping Services LLP">
          
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
          <div class="nav-dropdown">
  <a class="nav-dropdown-link" href="pages/solutions.html">Solutions</a>
  <button type="button" class="nav-dropdown-toggle" aria-expanded="false" aria-haspopup="true" aria-label="Open Solutions menu"><span class="nav-dropdown-chevron" aria-hidden="true"></span></button>
  <div class="nav-dropdown-menu" aria-label="Solutions">
    <a href="pages/service-customs.html">Customs House Agency (CHA)</a>
    <a href="pages/service-export.html">Export Clearance &amp; Documentation</a>
    <a href="pages/service-import.html">Import Clearance &amp; Documentation</a>
    <a href="pages/service-carrier-coordination.html">Shipping Line &amp; Carrier Coordination</a>
    <a href="pages/service-exim-compliance.html">EXIM Documentation &amp; Compliance</a>
    <a href="pages/service-freight.html">Freight &amp; Logistics Coordination</a>
    <a href="pages/service-port-operations.html">Port &amp; Cargo Handling</a><a href="pages/service-bonded-warehousing.html">Bonded Warehousing</a>
  </div>
</div>
          <a href="pages/gallery.html">
            Gallery
          </a>
          <a class="active" href="contact.html">
            Contact
          </a>
        </nav>
        <a class="button button-small header-cta" href="contact.html">
          Request a Quote
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
            Let&rsquo;s talk about<br><em>your shipment.</em>
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
              Tell us what you&rsquo;re moving.
            </h2>
            <p>
              SEA ASIA SHIPPING SERVICES LLP began in Madhya Pradesh and supports customs clearance, freight forwarding and supply chain operations across India and worldwide.
            </p>
            <p class="detail-label">
              Head Office
            </p>
            <p>
              Paras Business Park, Plot number 14, Narmadapuram Rd, near Ashima Mall, opposite to Maple High Street, Chinar Fortune City, Bhopal, Madhya Pradesh PIN &ndash; 462047
            </p>
            <p class="detail-label">
              Email Us
            </p>
            <p>
              <a href="mailto:info@seaasiashipping.com">info@seaasiashipping.com</a><br>
              <a href="mailto:shikhardhangar0118@gmail.com">shikhardhangar0118@gmail.com</a>
            </p>
            <p class="detail-label">
              WhatsApp Us
            </p>
            <p>
              <a href="https://wa.me/918319852739" target="_blank" rel="noopener noreferrer" aria-label="Chat on WhatsApp at 8319852739">8319852739</a>
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
                  Solution you&rsquo;re interested in
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
    <a class="brand brand-footer" href="index.html" aria-label="Sea Asia Shipping Services LLP home"><img class="brand-mark" src="assets/images/logo.png" alt="Sea Asia Shipping Services LLP"></a>
    <p>Shipping and logistics support<br>from Bhopal, Madhya Pradesh.</p>
    <div class="footer-links"><span>Explore</span><a href="pages/Explore%20Sea%20Asia.html">Explore Sea Asia</a><a href="pages/solutions.html">Solutions</a><a href="pages/gallery.html">Gallery</a><a href="contact.html">Contact</a></div>
    <div class="footer-contact"><span class="footer-heading">Get in touch</span><a class="footer-detail-link" href="mailto:info@seaasiashipping.com"><span class="footer-detail-label">Email</span>info@seaasiashipping.com</a><a class="footer-detail-link" href="tel:+918319852739"><span class="footer-detail-label">Phone</span>+91 83198 52739</a></div>
  </div>
  <div class="container footer-bottom"><span>&#169; <span data-year>2026</span> Sea Asia Shipping Services LLP</span><span>Bhopal, Madhya Pradesh, India</span></div>
</footer>
  </body>
</html>
