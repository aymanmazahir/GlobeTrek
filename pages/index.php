<?php
$_title = 'Home - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
?>

<style>
  /* Premium Home Page Stylings */
  .home-section {
    padding: 6rem 0;
    position: relative;
  }
  .section-subtitle {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.85rem;
    font-weight: 700;
    color: var(--accent);
    text-transform: uppercase;
    letter-spacing: 0.15em;
    margin-bottom: 0.75rem;
  }
  .section-subtitle::before {
    content: '';
    width: 25px;
    height: 3px;
    background: var(--warning);
    border-radius: 999px;
  }
  
  /* Section 2: News Feed Cards */
  .news-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    margin-top: 2.5rem;
  }
  @media(min-width: 768px) {
    .news-grid {
      grid-template-columns: repeat(3, 1fr);
    }
  }
  .news-card {
    background: #fff;
    border: 1px solid rgba(16, 34, 55, 0.08);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(16, 34, 55, 0.03);
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
  }
  .news-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 45px rgba(0, 167, 255, 0.08);
    border-color: rgba(0, 167, 255, 0.15);
  }
  .news-image {
    height: 180px;
    background-size: cover;
    background-position: center;
    position: relative;
  }
  .news-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: var(--warning);
    color: #10243a;
    font-weight: 700;
    font-size: 0.75rem;
    padding: 0.35rem 0.75rem;
    border-radius: 999px;
    text-transform: uppercase;
  }
  .news-content {
    padding: 1.5rem;
  }
  .news-date {
    font-size: 0.82rem;
    color: var(--muted);
    font-weight: 600;
    margin-bottom: 0.5rem;
  }
  .news-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: var(--text);
    margin: 0 0 0.75rem 0;
    line-height: 1.4;
  }
  .news-desc {
    font-size: 0.92rem;
    color: var(--muted);
    line-height: 1.6;
    margin: 0;
  }

  /* Section 5: Gallery Cards */
  .gallery-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    margin-top: 3rem;
  }
  @media(min-width: 768px) {
    .gallery-grid {
      grid-template-columns: repeat(2, 1fr);
    }
  }
  @media(min-width: 1100px) {
    .gallery-grid {
      grid-template-columns: repeat(4, 1fr);
    }
  }
  .gallery-card {
    background: #fff;
    border: 1px solid rgba(16, 34, 55, 0.06);
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(16,34,55,0.04);
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
  }
  .gallery-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 30px 60px rgba(16,34,55,0.12);
  }
  .gallery-img-box {
    height: 220px;
    background-size: cover;
    background-position: center;
  }
  .gallery-desc-box {
    padding: 1.5rem;
  }
  .gallery-desc-box h4 {
    font-size: 1.2rem;
    color: var(--text);
    margin: 0 0 0.5rem 0;
  }
  .gallery-desc-box p {
    color: var(--muted);
    font-size: 0.88rem;
    line-height: 1.6;
    margin: 0;
  }

  /* Section 8: Interactive Matcher */
  .matcher-box {
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.5);
    border-radius: 32px;
    padding: 3rem;
    box-shadow: 0 30px 70px rgba(16, 34, 55, 0.06);
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
  }
  .matcher-options {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
    margin-top: 2rem;
  }
  .matcher-btn {
    background: #fff;
    border: 1px solid rgba(16, 34, 55, 0.1);
    color: var(--text);
    padding: 1rem 2rem;
    border-radius: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    box-shadow: 0 4px 15px rgba(0,0,0,0.02);
  }
  .matcher-btn:hover {
    background: var(--accent);
    color: #fff;
    border-color: var(--accent);
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0, 167, 255, 0.2);
  }
  .matcher-result {
    margin-top: 2.5rem;
    padding-top: 2.5rem;
    border-top: 1px dashed rgba(16, 34, 55, 0.15);
    display: none;
    animation: fadeIn 0.5s ease both;
  }
  
  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
  }

  /* Section 9: Impact Stats */
  .impact-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem;
    margin-top: 3rem;
  }
  @media(min-width: 768px) {
    .impact-row {
      grid-template-columns: repeat(4, 1fr);
    }
  }
  .impact-card {
    text-align: center;
    background: rgba(33, 141, 83, 0.03);
    border: 1px solid rgba(33, 141, 83, 0.1);
    border-radius: 20px;
    padding: 2.5rem 1.5rem;
    transition: transform 0.3s ease;
  }
  .impact-card:hover {
    transform: translateY(-5px);
  }
  .impact-card h4 {
    font-size: 2.8rem;
    color: #218d53;
    font-weight: 800;
    margin: 0 0 0.5rem 0;
  }
  .impact-card p {
    color: var(--text);
    font-weight: 700;
    font-size: 0.9rem;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    margin: 0;
  }
</style>

<!-- SECTION 1: HERO SECTION -->
<section class="page-hero" style="background:linear-gradient(135deg, var(--accent-dark) 0%, var(--accent) 100%); position:relative; overflow:hidden; padding: 7rem 0 5rem;">
  <div style="position:absolute; inset:0; background:radial-gradient(circle at right top, rgba(255,255,255,0.18) 0%, transparent 60%); pointer-events:none;"></div>
  <div style="position:absolute; bottom:-60px; left:-60px; width:350px; height:350px; background:radial-gradient(circle, rgba(255,138,43,0.3) 0%, transparent 70%); filter:blur(50px); pointer-events:none;"></div>

  <div class="container" style="position:relative; z-index:2;">
    <div class="hero-grid">
      <div style="animation: fadeInUp 0.8s cubic-bezier(0.165, 0.84, 0.44, 1) both;">
        <span class="section-label" style="color:var(--surface); background:rgba(255,255,255,0.15); padding:0.45rem 1.1rem; border-radius:999px; margin-bottom:1.5rem; display:inline-block; border:1px solid rgba(255,255,255,0.35); font-weight:700; font-size:0.88rem;">
          ✨ EXPLORE SRI LANKA TODAY
        </span>
        <h1 style="font-size:clamp(3rem, 5vw, 4.6rem); line-height:1.08; margin-bottom:1.5rem; font-weight:800; text-shadow:0 12px 35px rgba(16,34,55,0.22);">
          Unforgettable Journeys Await You
        </h1>
        <p style="font-size:1.18rem; opacity:0.92; max-width:620px; margin-bottom:2.5rem; line-height:1.7;">
          Discover handpicked premium travel packages across Sri Lanka. From high-altitude hiking along the Pekoe Trail to surfing world-class breaks, we provide fully secure bookings and transparent, stress-free travel.
        </p>
        
        <div class="hero-search" style="background:#fff; padding:0.55rem; border-radius:999px; display:flex; align-items:center; max-width:520px; box-shadow:0 22px 60px rgba(16,34,55,0.25);">
          <div style="padding:0 1rem; color:var(--accent);">
             <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          </div>
          <input id="package-search" placeholder="Where do you want to go?" style="border:none; box-shadow:none; padding:0.85rem; background:transparent; font-size:1.05rem;">
          <button id="package-search-button" type="button" style="background:var(--warning); margin:0; padding:0.95rem 1.8rem; font-weight:700;">Explore</button>
        </div>
      </div>
      
      <div class="hero-card" style="animation: floatIn 1.1s cubic-bezier(0.165, 0.84, 0.44, 1) 0.15s both; background:rgba(255,255,255,0.96); border:none; box-shadow:0 35px 80px rgba(16,34,55,0.32); border-radius:32px; padding:2.2rem;">
        <h3 style="color:var(--text); margin-bottom:1.5rem; font-size:1.5rem; font-weight:800;">Why GlobeTrek?</h3>
        
        <div class="feature-list" style="display:flex; flex-direction:column; gap:1.6rem; margin:0;">
          <div style="display:flex; gap:1rem; align-items:flex-start;">
            <div style="background:var(--accent-soft); width:48px; height:48px; border-radius:16px; display:flex; align-items:center; justify-content:center; font-size:1.5rem; flex-shrink:0; border:1px solid rgba(0,167,255,0.1);">🌴</div>
            <div>
              <h4 style="margin:0 0 0.25rem; color:var(--text); font-size:1.1rem; font-weight:700;">Premium Destinations</h4>
              <p style="margin:0; color:var(--muted); font-size:0.95rem; line-height:1.5;">Handpicked hotels and private tour routes for premium travel.</p>
            </div>
          </div>
          
          <div style="display:flex; gap:1rem; align-items:flex-start;">
            <div style="background:rgba(33,141,83,0.12); width:48px; height:48px; border-radius:16px; display:flex; align-items:center; justify-content:center; font-size:1.5rem; flex-shrink:0; border:1px solid rgba(33,141,83,0.15);">🛡️</div>
            <div>
              <h4 style="margin:0 0 0.25rem; color:var(--text); font-size:1.1rem; font-weight:700;">Secure Transactions</h4>
              <p style="margin:0; color:var(--muted); font-size:0.95rem; line-height:1.5;">End-to-end encrypted booking tracking with no extra fees.</p>
            </div>
          </div>
          
          <div style="display:flex; gap:1rem; align-items:flex-start;">
            <div style="background:rgba(255,138,43,0.12); width:48px; height:48px; border-radius:16px; display:flex; align-items:center; justify-content:center; font-size:1.5rem; flex-shrink:0; border:1px solid rgba(255,138,43,0.15);">⭐</div>
            <div>
              <h4 style="margin:0 0 0.25rem; color:var(--text); font-size:1.1rem; font-weight:700;">24/7 Expert Staff</h4>
              <p style="margin:0; color:var(--muted); font-size:0.95rem; line-height:1.5;">Highly certified Sri Lankan guides and emergency support desks.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 2: LIVE SRI LANKAN TOURISM NEWS FEED -->
<section class="home-section" style="background:#fff;">
  <div class="container">
    <div class="section-header" style="max-width:700px; margin-bottom:3.5rem;">
      <span class="section-subtitle">Real-Time Updates</span>
      <h2 style="font-size:2.4rem; font-weight:800; color:var(--text); margin-bottom:0.75rem;">Sri Lanka Live Travel News Feed</h2>
      <p style="color:var(--muted); font-size:1.05rem; line-height:1.7;">Get the latest updates on immigration rules, newly opened trail stages, wildlife sightings, and eco-initiatives directly from local conservation boards.</p>
    </div>
    
    <div class="news-grid">
      <article class="news-card">
        <div class="news-image" style="background-image:url('https://images.unsplash.com/photo-1568430462989-4b13f87a02b5?auto=format&fit=crop&w=800&q=80');">
          <span class="news-badge">Migration</span>
        </div>
        <div class="news-content">
          <div class="news-date">MAY 19, 2026 • 2 MIN READ</div>
          <h3 class="news-title">Blue Whale Sightings Peak in Mirissa</h3>
          <p class="news-desc">Marine biologists report record sightings of Blue Whales off the coast of Mirissa. Strict eco-safari guidelines have successfully minimised vessel disturbances.</p>
        </div>
      </article>

      <article class="news-card">
        <div class="news-image" style="background-image:url('https://images.unsplash.com/photo-1563189331-40992709484b?auto=format&fit=crop&w=800&q=80');">
          <span class="news-badge">Ecotourism</span>
        </div>
        <div class="news-content">
          <div class="news-date">MAY 17, 2026 • 3 MIN READ</div>
          <h3 class="news-title">Pekoe Trail Stage 6 Formally Opened</h3>
          <p class="news-desc">Hiking enthusiasts can now access Stage 6 of the Pekoe Trail connecting Ella to local historic tea estates, featuring gorgeous vistas and solar lodges.</p>
        </div>
      </article>

      <article class="news-card">
        <div class="news-image" style="background-image:url('https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=800&q=80');">
          <span class="news-badge">Policy</span>
        </div>
        <div class="news-content">
          <div class="news-date">MAY 14, 2026 • 1 MIN READ</div>
          <h3 class="news-title">Visa-Free Digital Fast-Track Approved</h3>
          <p class="news-desc">Sri Lanka has expanded visa-free entry digital approvals for 45 countries, allowing faster processing times and smoother arrivals at BIA Airport.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- SECTION 3: FEATURED TRAVEL PACKAGES -->
<section class="home-section" style="background:var(--surface-soft);">
  <div class="container">
    <div class="section-header" style="text-align:center; max-width:650px; margin:0 auto 3.5rem;">
      <span class="section-subtitle" style="justify-content:center;">Exclusive Tours</span>
      <h2 style="font-size:2.4rem; font-weight:800; color:var(--text); margin-bottom:0.75rem;">Most Popular Experiences</h2>
      <p style="color:var(--muted); font-size:1.05rem; line-height:1.7;">Secure your place on our top-rated journeys, complete with dedicated transport and verified hotels.</p>
    </div>
    
    <div class="packages-grid card-grid grid-3" id="packages">
      <!-- Dynamically Injected from DB -->
    </div>
    
    <div style="text-align:center; margin-top:3.5rem;">
        <a href="/globetrek/pages/packages.php" class="button ghost" style="padding:1.1rem 2.2rem; font-size:1.05rem; font-weight:700; border-radius:999px;">View All Packages</a>
    </div>
  </div>
</section>

<!-- SECTION 4: SYSTEM CAPABILITIES & PORTAL HIGHLIGHT -->
<section class="home-section" style="background:#fff;">
  <div class="container">
    <div class="section-header" style="max-width:700px; margin-bottom:3.5rem;">
      <span class="section-subtitle">System Showcase</span>
      <h2 style="font-size:2.4rem; font-weight:800; color:var(--text); margin-bottom:0.75rem;">How GlobeTrek Works For You</h2>
      <p style="color:var(--muted); font-size:1.05rem; line-height:1.7;">GlobeTrek Adventures is designed as an interactive portal linking travelers, operations staff, and security teams in one seamless dashboard.</p>
    </div>

    <div class="card-grid grid-2">
      <div class="feature-item" style="background:var(--surface-soft); border-radius:24px; padding:2rem; border:1px solid rgba(16, 34, 55, 0.04);">
        <div class="feature-item-icon" style="background:var(--accent-soft); color:var(--accent);">📋</div>
        <div class="feature-item-content">
          <h3 style="font-size:1.25rem; font-weight:700; margin-bottom:0.5rem;">Interactive Booking Desk</h3>
          <p style="margin:0; color:var(--muted); font-size:0.95rem; line-height:1.6;">Browse destinations, adjust travel dates, specify traveler headcounts, and watch booking totals calculate instantly. Check out with secure, simulated card payments.</p>
        </div>
      </div>

      <div class="feature-item" style="background:var(--surface-soft); border-radius:24px; padding:2rem; border:1px solid rgba(16, 34, 55, 0.04);">
        <div class="feature-item-icon" style="background:rgba(33,141,83,0.12); color:#218d53;">🧭</div>
        <div class="feature-item-content">
          <h3 style="font-size:1.25rem; font-weight:700; margin-bottom:0.5rem;">Staff & Guide Coordination</h3>
          <p style="margin:0; color:var(--muted); font-size:0.95rem; line-height:1.6;">Our operations staff use their dedicated dashboard to publish custom packages, monitor travel bookings, review inquiries, and ensure seamless local transfers.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 5: ICONIC DESTINATIONS CAROUSEL/GALLERY -->
<section class="home-section" style="background:var(--surface-soft);">
  <div class="container">
    <div class="section-header" style="text-align:center; max-width:700px; margin:0 auto 3.5rem;">
      <span class="section-subtitle" style="justify-content:center;">Breathtaking Sights</span>
      <h2 style="font-size:2.4rem; font-weight:800; color:var(--text); margin-bottom:0.75rem;">Iconic Destinations</h2>
      <p style="color:var(--muted); font-size:1.05rem; line-height:1.7;">Browse these iconic, handpicked Sri Lankan treasures and start visualizing your customized itinerary.</p>
    </div>

    <div class="gallery-grid">
      <article class="gallery-card">
        <div class="gallery-img-box" style="background-image:url('https://images.unsplash.com/photo-1588598126715-d14210d65b11?auto=format&fit=crop&w=800&q=80');"></div>
        <div class="gallery-desc-box">
          <h4>Sigiriya Sky Fortress</h4>
          <p>The timeless Lion Rock fortress rising 200m above the jungle canopy, showcasing ancient water gardens, frescoes, and monumental history.</p>
        </div>
      </article>

      <article class="gallery-card">
        <div class="gallery-img-box" style="background-image:url('https://images.unsplash.com/photo-1545229765-7ff6feee3dbf?auto=format&fit=crop&w=800&q=80');"></div>
        <div class="gallery-desc-box">
          <h4>Nine Arch Bridge, Ella</h4>
          <p>A spectacular colonial-era stone railway bridge nestled amidst misty green tea plantations, serving as Sri Lanka's ultimate photography spot.</p>
        </div>
      </article>

      <article class="gallery-card">
        <div class="gallery-img-box" style="background-image:url('https://images.unsplash.com/photo-1586861635167-e5223aadc9fe?auto=format&fit=crop&w=800&q=80');"></div>
        <div class="gallery-desc-box">
          <h4>Galle Dutch Fort</h4>
          <p>A historic ocean fortress showcasing centuries of colonial Dutch architecture, cobblestone pathways, boutique shops, and a famous lighthouse.</p>
        </div>
      </article>

      <article class="gallery-card">
        <div class="gallery-img-box" style="background-image:url('https://images.unsplash.com/photo-1456926631375-92c8ce872def?auto=format&fit=crop&w=800&q=80');"></div>
        <div class="gallery-desc-box">
          <h4>Yala Leopard Sanctuary</h4>
          <p>A thriving shoreline jungle reserve boasting the highest density of wild leopards in the world, alongside wild elephants and birdlife.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- SECTION 6: ADVENTURE SPORTS SPOTLIGHT -->
<section class="home-section" style="background:#fff;">
  <div class="container">
    <div class="section-header" style="max-width:700px; margin-bottom:3.5rem;">
      <span class="section-subtitle">Thrills & Adventure</span>
      <h2 style="font-size:2.4rem; font-weight:800; color:var(--text); margin-bottom:0.75rem;">Active Adventure Sports</h2>
      <p style="color:var(--muted); font-size:1.05rem; line-height:1.7;">Satisfy your adrenaline cravings with world-class beach activities, hiking trails, and lagoon sports.</p>
    </div>

    <div class="card-grid grid-3">
      <div class="testimonial-card" style="padding:2.2rem; background:rgba(255, 139, 43, 0.02); border:1px solid rgba(255, 139, 43, 0.1);">
        <div style="font-size:2.2rem; margin-bottom:1rem;">🏄</div>
        <h4 style="margin:0 0 0.5rem 0; font-size:1.25rem; font-weight:700; color:var(--text);">Eco-Surfing at Weligama</h4>
        <p style="margin:0; color:var(--muted); font-size:0.95rem; line-height:1.65;">From beginners finding their footing to experts tackling Hiriketiya breakers, Sri Lanka offers consistent ocean swells, surf camps, and sustainable gear rentals.</p>
      </div>

      <div class="testimonial-card" style="padding:2.2rem; background:rgba(0, 167, 255, 0.02); border:1px solid rgba(0, 167, 255, 0.1);">
        <div style="font-size:2.2rem; margin-bottom:1rem;">🪂</div>
        <h4 style="margin:0 0 0.5rem 0; font-size:1.25rem; font-weight:700; color:var(--text);">Ella Paragliding & Hiking</h4>
        <p style="margin:0; color:var(--muted); font-size:0.95rem; line-height:1.65;">Soar high above green mountain gaps, or complete premium guided hikes along Ella Rock and the Pekoe Trail to capture unparalleled panoramic tea trail photos.</p>
      </div>

      <div class="testimonial-card" style="padding:2.2rem; background:rgba(33, 141, 83, 0.02); border:1px solid rgba(33, 141, 83, 0.1);">
        <div style="font-size:2.2rem; margin-bottom:1rem;">🤿</div>
        <h4 style="margin:0 0 0.5rem 0; font-size:1.25rem; font-weight:700; color:var(--text);">Diving Shipwrecks in Trinco</h4>
        <p style="margin:0; color:var(--muted); font-size:0.95rem; line-height:1.65;">Dive historic naval shipwrecks and vibrant coral gardens, or explore Pigeon Island national park accompanied by PADI-certified marine guides.</p>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 7: SRI LANKAN CULINARY JOURNEYS -->
<section class="home-section" style="background:var(--surface-soft); position:relative; overflow:hidden;">
  <div style="position:absolute; inset:0; background:radial-gradient(circle at left bottom, rgba(255,139,43,0.06) 0%, transparent 60%); pointer-events:none;"></div>
  
  <div class="container" style="position:relative; z-index:2;">
    <div class="hero-grid">
      <div style="align-self:center;">
        <span class="section-subtitle">Local Gastronomy</span>
        <h2 style="font-size:2.4rem; font-weight:800; color:var(--text); margin-bottom:1.25rem;">Immersive Culinary Journeys</h2>
        <p style="color:var(--muted); font-size:1.05rem; line-height:1.7; margin-bottom:2rem;">
          Sri Lankan food is an incredible journey of aromas, exotic spices, and culinary heritage. Our packages offer unique culinary classes where you harvest organic farm ingredients and cook alongside village experts:
        </p>
        
        <ul style="list-style:none; padding:0; margin:0; display:flex; flex-direction:column; gap:1.2rem;">
          <li style="display:flex; gap:1rem; align-items:flex-start;">
            <span style="background:rgba(255,138,43,0.15); width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">🍛</span>
            <div>
              <strong style="display:block; color:var(--text); font-size:1.05rem;">Organic Spice Farm Tours</strong>
              <span style="color:var(--muted); font-size:0.92rem; line-height:1.5; display:block;">Discover how wild cinnamon, cardamom, and black pepper are harvested sustainably in Matale.</span>
            </div>
          </li>
          <li style="display:flex; gap:1rem; align-items:flex-start;">
            <span style="background:rgba(255,138,43,0.15); width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; flex-shrink:0;">🍳</span>
            <div>
              <strong style="display:block; color:var(--text); font-size:1.05rem;">Village Hearth Culinary Classes</strong>
              <span style="color:var(--muted); font-size:0.92rem; line-height:1.5; display:block;">Learn the secrets to crafting perfect crispy hoppers and traditional spicy coconut sambol.</span>
            </div>
          </li>
        </ul>
      </div>

      <div class="hero-card" style="background-image:url('https://images.unsplash.com/photo-1596797038530-2c107229654b?auto=format&fit=crop&w=800&q=80'); background-size:cover; background-position:center; min-height:360px; border-radius:32px; box-shadow:0 30px 70px rgba(16, 34, 55, 0.12); border:none;"></div>
    </div>
  </div>
</section>

<!-- SECTION 8: INTERACTIVE SRI LANKAN TOUR MATCHER -->
<section class="home-section" style="background:#fff;">
  <div class="container">
    <div class="matcher-box fade-up">
      <span class="section-subtitle" style="justify-content:center;">Find Your Dream Trip</span>
      <h2 style="font-size:2.2rem; font-weight:800; color:var(--text); margin-bottom:0.75rem;">Sri Lankan Experience Finder</h2>
      <p style="color:var(--muted); font-size:1.02rem; line-height:1.6;">Click your preferred travel theme below to instantly match with our recommended itinerary.</p>
      
      <div class="matcher-options">
        <button type="button" class="matcher-btn" onclick="matchTour('eco')">🌿 Eco & Wellness</button>
        <button type="button" class="matcher-btn" onclick="matchTour('coast')">🏄 Coastal Break</button>
        <button type="button" class="matcher-btn" onclick="matchTour('history')">🛕 Cultural Journey</button>
      </div>

      <div id="matcherResult" class="matcher-result">
        <div style="font-size:3.5rem; margin-bottom:1rem;" id="matcherEmoji">🌿</div>
        <h4 style="font-size:1.4rem; font-weight:800; color:var(--text); margin-bottom:0.5rem;" id="matcherTitle">Highland Tea Trail & Yoga</h4>
        <p style="color:var(--muted); font-size:0.98rem; line-height:1.6; max-width:600px; margin:0 auto 1.5rem;" id="matcherDesc">
          A gorgeous eco-trip through the misty valleys of Ella, complete with custom yoga sessions, Pekoe Trail hiking stages, and organic farm-to-table dining.
        </p>
        <a href="/globetrek/pages/packages.php" class="button" style="padding:0.9rem 2rem; font-weight:700;">Explore Packages</a>
      </div>
    </div>
  </div>
</section>

<script>
  function matchTour(theme) {
    const resultBox = document.getElementById('matcherResult');
    const emojiEl = document.getElementById('matcherEmoji');
    const titleEl = document.getElementById('matcherTitle');
    const descEl = document.getElementById('matcherDesc');

    resultBox.style.display = 'block';

    if (theme === 'eco') {
      emojiEl.textContent = '🌿';
      titleEl.textContent = 'Highland Tea Trail & Yoga Retreat';
      descEl.textContent = 'Explore the misty tea estates of Ella and Nuwara Eliya. Take part in guided Pekoe Trail hiking excursions, private organic garden tours, and restorative Ayurvedic spa treatments.';
    } else if (theme === 'coast') {
      emojiEl.textContent = '🏄';
      titleEl.textContent = 'Southern Shoreline Surf & Whale Safari';
      descEl.textContent = 'Hit the beach breaks of Weligama and Hiriketiya, complete with surf training desks, and board eco-certified vessels to witness majestic Blue Whales off Mirissa.';
    } else if (theme === 'history') {
      emojiEl.textContent = '🛕';
      titleEl.textContent = 'Grand Golden Triangle Cultural Tour';
      descEl.textContent = 'Explore iconic ancient wonders like the Sigiriya Lion Rock Sky Fortress, bicycling pathways of Polonnaruwa ruins, and the timeless coastal cobblestones of Galle Dutch Fort.';
    }
    
    // Smooth scroll to results
    resultBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }
</script>

<!-- SECTION 9: SUSTAINABILITY & IMPACT PILLARS -->
<section class="home-section" style="background:var(--surface-soft);">
  <div class="container">
    <div class="section-header" style="text-align:center; max-width:700px; margin:0 auto 3.5rem;">
      <span class="section-subtitle" style="justify-content:center;">Conscious Operations</span>
      <h2 style="font-size:2.4rem; font-weight:800; color:var(--text); margin-bottom:0.75rem;">Our Sustainable Travel Pillars</h2>
      <p style="color:var(--muted); font-size:1.05rem; line-height:1.7;">We are dedicated to safeguarding Sri Lanka’s ecosystems, supporting local heritage, and ensuring fair local revenue distribution.</p>
    </div>

    <div class="impact-row">
      <div class="impact-card">
        <h4>100%</h4>
        <p>Carbon Neutral Safaris</p>
      </div>
      <div class="impact-card">
        <h4>35%</h4>
        <p>Revenue to Village Guides</p>
      </div>
      <div class="impact-card">
        <h4>0%</h4>
        <p>Single-Use Plastics</p>
      </div>
      <div class="impact-card">
        <h4>12K+</h4>
        <p>Coral Reefs Replanted</p>
      </div>
    </div>
  </div>
</section>

<!-- SECTION 10: DYNAMIC CTA & NEWSLETTER SIGNUP -->
<section class="home-section" style="background:#fff;">
  <div class="container">
    <div class="hero-card" style="background:linear-gradient(135deg, rgba(16,36,58,0.96) 0%, rgba(0,110,177,0.96) 100%); border:none; box-shadow:0 35px 80px rgba(16,34,55,0.18); border-radius:32px; padding:4.5rem 3rem; text-align:center; position:relative; overflow:hidden;">
      <div style="position:absolute; inset:0; background:radial-gradient(circle at top right, rgba(255,139,43,0.18) 0%, transparent 60%); pointer-events:none;"></div>
      
      <div style="position:relative; z-index:2; max-width:700px; margin:0 auto;">
        <span class="section-label" style="color:var(--warning); background:rgba(255,255,255,0.1); padding:0.4rem 1.1rem; border-radius:999px; display:inline-block; border:1px solid rgba(255,255,255,0.15); margin-bottom:1.5rem; font-weight:700;">
          📢 EXCLUSIVE INSIDER CLUB
        </span>
        <h2 style="font-size:2.6rem; font-weight:800; color:#fff; margin-bottom:1rem; line-height:1.15;">Get Sri Lankan Travel Deals First</h2>
        <p style="color:#d0e7ff; font-size:1.1rem; line-height:1.7; margin-bottom:2.5rem;">
          Subscribe to our premium explorer list to receive seasonal hotel discounts, itinerary guides, and live festival updates directly to your inbox.
        </p>
        
        <form style="display:flex; gap:0.8rem; flex-wrap:wrap; max-width:560px; margin:0 auto;" onsubmit="event.preventDefault(); if(window.showToast) window.showToast('Subscribed successfully! Welcome to the GlobeTrek Explorer list.', 'success'); this.reset();">
          <input type="email" placeholder="Enter your email address" required style="flex:1; background:#fff; border:none; border-radius:999px; padding:1.1rem 1.5rem; font-size:1.02rem; color:var(--text); box-shadow:0 10px 30px rgba(0,0,0,0.06);">
          <button type="submit" style="background:var(--warning); color:#10243a; font-weight:700; border-radius:999px; padding:1.1rem 2.2rem; margin:0;">Subscribe</button>
        </form>
      </div>
    </div>
  </div>
</section>

<script type="module">
import { loadPackageCards, initializePackageSearch } from '/globetrek/assets/js/site.js'
loadPackageCards('#packages')
initializePackageSearch('#package-search', '#package-search-button', '#packages')
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>