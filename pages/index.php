<?php
$_title = 'Home - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
?>
<section class="page-hero" style="background:linear-gradient(135deg, rgba(0,150,255,.95) 0%, rgba(9,133,208,.95) 100%);border-bottom:1px solid rgba(255,255,255,.15);">
  <div class="container">
    <div class="hero-grid">
      <div>
        <span class="section-label">Travel made simple</span>
        <h1>Book unforgettable tours with GlobeTrek Adventures</h1>
        <p>Discover carefully curated travel packages, secure payments, and live support for every journey.</p>
        <div class="hero-actions">
          <a class="button" href="/globetrek/pages/packages.php">View packages</a>
          <a class="button" href="/globetrek/pages/contact.php">Contact us</a>
        </div>
        <div class="hero-search" style="margin-top:2rem;">
          <input id="package-search" placeholder="Search destinations, packages or activities">
          <button id="package-search-button" type="button">Search</button>
        </div>
      </div>
      <div class="hero-card">
        <h3>Why choose GlobeTrek?</h3>
        <p>We offer a fully managed booking system with custom itineraries, safe payments, staff coordination, and admin reporting.</p>
        <div class="feature-list">
          <div class="feature-item">
            <div class="feature-item-icon">✈️</div>
            <div class="feature-item-content"><h3>Travel packages</h3><p>Browse tours from relaxing beach escapes to cultural experiences.</p></div>
          </div>
          <div class="feature-item">
            <div class="feature-item-icon">💼</div>
            <div class="feature-item-content"><h3>Secure bookings</h3><p>Fast, easy booking experience for customers and staff.</p></div>
          </div>
          <div class="feature-item">
            <div class="feature-item-icon">📊</div>
            <div class="feature-item-content"><h3>Admin reports</h3><p>Powerful dashboards for managers and administrators.</p></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="page-panel fade-up">
  <div class="section-header">
    <span class="section-label">Featured packages</span>
    <h2>Popular travel experiences</h2>
    <p>Explore the latest tour packages, tailored for adventure, relaxation and unforgettable moments.</p>
  </div>
  <div class="packages-grid" id="packages"></div>
</section>
<section class="page-panel fade-up">
  <div class="section-header">
    <span class="section-label">Customer stories</span>
    <h2>What travelers are saying</h2>
  </div>
  <div class="card-grid grid-3">
    <article class="testimonial-card">
      <p>GlobeTrek made booking my family holiday effortless. The package and support were excellent from start to finish.</p>
      <strong>Priya K.</strong>
      <span class="text-muted">Family traveler</span>
    </article>
    <article class="testimonial-card">
      <p>The staff dashboard is great for our tour operators. We can confirm bookings and manage packages quickly.</p>
      <strong>Sohan M.</strong>
      <span class="text-muted">Travel agent</span>
    </article>
    <article class="testimonial-card">
      <p>An amazing admin panel experience — I can monitor bookings, payments, and reports without any hassle.</p>
      <strong>Mala R.</strong>
      <span class="text-muted">Business manager</span>
    </article>
  </div>
</section>
<script type="module">
import { loadPackageCards, initializePackageSearch } from '/globetrek/assets/js/site.js'
loadPackageCards('#packages')
initializePackageSearch('#package-search', '#package-search-button', '#packages')
</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>