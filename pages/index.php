<?php
$_title = 'Home - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
?>

<!-- Hero Section -->
<section class="page-hero" style="background:linear-gradient(135deg, var(--accent-dark) 0%, var(--accent) 100%); position:relative; overflow:hidden; padding: 6rem 0 4rem;">
  <!-- Background Pattern -->
  <div style="position:absolute; inset:0; background:radial-gradient(circle at right top, rgba(255,255,255,0.15) 0%, transparent 50%); pointer-events:none;"></div>
  <div style="position:absolute; bottom:-50px; left:-50px; width:300px; height:300px; background:radial-gradient(circle, rgba(255,138,43,0.3) 0%, transparent 70%); filter:blur(40px); pointer-events:none;"></div>

  <div class="container" style="position:relative; z-index:2;">
    <div class="hero-grid">
      <div style="animation: fadeInUp 0.8s ease both;">
        <span class="section-label" style="color:var(--surface); background:rgba(255,255,255,0.15); padding:0.4rem 1rem; border-radius:999px; margin-bottom:1.5rem; display:inline-block; border:1px solid rgba(255,255,255,0.3);">
          ✨ Discover The World
        </span>
        <h1 style="font-size:clamp(3rem, 5vw, 4.5rem); line-height:1.1; margin-bottom:1.5rem; text-shadow:0 10px 30px rgba(16,34,55,0.2);">
          Unforgettable Journeys Await You
        </h1>
        <p style="font-size:1.15rem; opacity:0.9; max-width:600px; margin-bottom:2.5rem; line-height:1.6;">
          Explore our carefully curated premium travel packages. From relaxing beach escapes to thrilling mountain adventures, we make booking simple, secure, and stress-free.
        </p>
        
        <div class="hero-search" style="background:#fff; padding:0.5rem; border-radius:999px; display:flex; align-items:center; max-width:500px; box-shadow:0 20px 50px rgba(16,34,55,0.2);">
          <div style="padding:0 1rem; color:var(--accent);">
             <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          </div>
          <input id="package-search" placeholder="Where do you want to go?" style="border:none; box-shadow:none; padding:0.8rem; background:transparent; font-size:1.05rem;">
          <button id="package-search-button" type="button" style="background:var(--warning); margin:0;">Explore</button>
        </div>
      </div>
      
      <div class="hero-card" style="animation: floatIn 1s ease 0.2s both; background:rgba(255,255,255,0.95); border:none; box-shadow:0 30px 60px rgba(16,34,55,0.3); border-radius:32px;">
        <h3 style="color:var(--text); margin-bottom:1.5rem; font-size:1.5rem;">Why GlobeTrek?</h3>
        
        <div class="feature-list" style="display:flex; flex-direction:column; gap:1.5rem;">
          <div style="display:flex; gap:1rem; align-items:flex-start;">
            <div style="background:var(--accent-soft); width:48px; height:48px; border-radius:16px; display:flex; align-items:center; justify-content:center; font-size:1.5rem; flex-shrink:0;">🌴</div>
            <div>
              <h4 style="margin:0 0 0.25rem; color:var(--text); font-size:1.1rem;">Premium Destinations</h4>
              <p style="margin:0; color:var(--muted); font-size:0.95rem; line-height:1.5;">Handpicked locations that guarantee the best experiences.</p>
            </div>
          </div>
          
          <div style="display:flex; gap:1rem; align-items:flex-start;">
            <div style="background:rgba(33,141,83,0.15); width:48px; height:48px; border-radius:16px; display:flex; align-items:center; justify-content:center; font-size:1.5rem; flex-shrink:0;">🛡️</div>
            <div>
              <h4 style="margin:0 0 0.25rem; color:var(--text); font-size:1.1rem;">Secure Booking System</h4>
              <p style="margin:0; color:var(--muted); font-size:0.95rem; line-height:1.5;">Your payments and personal data are fully protected.</p>
            </div>
          </div>
          
          <div style="display:flex; gap:1rem; align-items:flex-start;">
            <div style="background:rgba(255,138,43,0.15); width:48px; height:48px; border-radius:16px; display:flex; align-items:center; justify-content:center; font-size:1.5rem; flex-shrink:0;">⭐</div>
            <div>
              <h4 style="margin:0 0 0.25rem; color:var(--text); font-size:1.1rem;">24/7 Staff Support</h4>
              <p style="margin:0; color:var(--muted); font-size:0.95rem; line-height:1.5;">Our dedicated staff team is always ready to assist you.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Featured Packages -->
<section class="page-panel fade-up" style="background:var(--surface-soft); padding:5rem 0;">
  <div class="container">
    <div class="section-header" style="text-align:center; max-width:600px; margin:0 auto 3rem;">
      <span class="section-label" style="color:var(--accent-dark); margin-bottom:1rem; display:inline-block;">Featured Tours</span>
      <h2 style="font-size:2.5rem; margin-bottom:1rem; color:var(--text);">Most Popular Experiences</h2>
      <p style="color:var(--muted); font-size:1.1rem;">Browse our top-rated travel packages and find your next grand adventure.</p>
    </div>
    
    <div class="packages-grid card-grid grid-3" id="packages">
      <!-- Injected via site.js -->
    </div>
    
    <div style="text-align:center; margin-top:3rem;">
        <a href="/globetrek/pages/packages.php" class="button ghost" style="padding:1rem 2rem; font-size:1.1rem; border-radius:999px;">View All Packages</a>
    </div>
  </div>
</section>

<!-- Testimonials -->
<section class="page-panel fade-up" style="padding:5rem 0; background:var(--surface);">
  <div class="container">
      <div class="section-header" style="margin-bottom:3rem;">
        <span class="section-label" style="color:var(--warning);">Testimonials</span>
        <h2 style="font-size:2.5rem;">What Our Travelers Say</h2>
      </div>
      
      <div class="card-grid grid-3">
        <article class="hero-card" style="background:rgba(0,167,255,0.03); border:1px solid rgba(0,167,255,0.1); border-radius:24px;">
          <div style="color:var(--warning); font-size:1.2rem; margin-bottom:1rem;">★★★★★</div>
          <p style="color:var(--text); font-size:1.1rem; line-height:1.6; margin-bottom:1.5rem;">"GlobeTrek made booking my family holiday effortless. The package and support were excellent from start to finish. Highly recommend!"</p>
          <div style="display:flex; align-items:center; gap:1rem;">
              <div style="width:48px; height:48px; border-radius:50%; background:var(--accent-soft); display:flex; align-items:center; justify-content:center; font-weight:bold; color:var(--accent-dark);">PK</div>
              <div>
                  <strong style="display:block; color:var(--text);">Priya K.</strong>
                  <span class="text-muted" style="font-size:0.9rem;">Family Traveler</span>
              </div>
          </div>
        </article>
        
        <article class="hero-card" style="background:rgba(33,141,83,0.03); border:1px solid rgba(33,141,83,0.1); border-radius:24px;">
          <div style="color:var(--warning); font-size:1.2rem; margin-bottom:1rem;">★★★★★</div>
          <p style="color:var(--text); font-size:1.1rem; line-height:1.6; margin-bottom:1.5rem;">"The staff support is incredible. They helped customize my itinerary perfectly. The whole booking process is extremely secure and easy."</p>
          <div style="display:flex; align-items:center; gap:1rem;">
              <div style="width:48px; height:48px; border-radius:50%; background:rgba(33,141,83,0.1); display:flex; align-items:center; justify-content:center; font-weight:bold; color:var(--success);">SM</div>
              <div>
                  <strong style="display:block; color:var(--text);">Sohan M.</strong>
                  <span class="text-muted" style="font-size:0.9rem;">Solo Backpacker</span>
              </div>
          </div>
        </article>
        
        <article class="hero-card" style="background:rgba(255,138,43,0.03); border:1px solid rgba(255,138,43,0.1); border-radius:24px;">
          <div style="color:var(--warning); font-size:1.2rem; margin-bottom:1rem;">★★★★★</div>
          <p style="color:var(--text); font-size:1.1rem; line-height:1.6; margin-bottom:1.5rem;">"As a corporate client, the customer dashboard is fantastic. I can manage all my bookings and payments effortlessly."</p>
          <div style="display:flex; align-items:center; gap:1rem;">
              <div style="width:48px; height:48px; border-radius:50%; background:rgba(255,138,43,0.1); display:flex; align-items:center; justify-content:center; font-weight:bold; color:var(--warning);">MR</div>
              <div>
                  <strong style="display:block; color:var(--text);">Mala R.</strong>
                  <span class="text-muted" style="font-size:0.9rem;">Business Manager</span>
              </div>
          </div>
        </article>
      </div>
  </div>
</section>

<script type="module">
import { loadPackageCards, initializePackageSearch } from '/globetrek/assets/js/site.js'
loadPackageCards('#packages')
initializePackageSearch('#package-search', '#package-search-button', '#packages')
</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>