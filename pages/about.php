<?php
$_title = 'About Us - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
?>

<style>
  .about-hero {
    background: linear-gradient(135deg, rgba(16, 36, 58, 0.95) 0%, rgba(0, 110, 177, 0.95) 100%), 
                url('/globetrek/assets/images/packages/default_package.jpg') no-repeat center center/cover;
    padding: 6rem 1rem;
    text-align: center;
    color: #fff;
    border-radius: 0 0 40px 40px;
    margin-bottom: 4rem;
    box-shadow: 0 20px 40px rgba(16, 34, 55, 0.15);
    position: relative;
    overflow: hidden;
  }
  .about-hero::before {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(circle at top right, rgba(255,139,43,0.2) 0%, transparent 60%);
    pointer-events: none;
  }
  .about-hero h1 {
    font-size: clamp(2.5rem, 5vw, 4rem);
    font-weight: 800;
    margin-bottom: 1rem;
    line-height: 1.1;
  }
  .about-hero p {
    font-size: 1.2rem;
    max-width: 800px;
    margin: 0 auto;
    opacity: 0.9;
    line-height: 1.6;
  }
  .about-section {
    padding: 2rem 0;
    margin-bottom: 4rem;
  }
  .trending-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 2rem;
    margin-top: 2rem;
  }
  @media(min-width: 768px) {
    .trending-grid {
      grid-template-columns: 1fr 1fr;
    }
  }
  .trending-card {
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    border: 1px solid rgba(16, 34, 55, 0.08);
    border-radius: 24px;
    padding: 2.2rem;
    box-shadow: 0 15px 40px rgba(16, 34, 55, 0.05);
    transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
  }
  .trending-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 60px rgba(0, 167, 255, 0.12);
    border-color: rgba(0, 167, 255, 0.2);
  }
  .trending-card-icon {
    font-size: 2.5rem;
    margin-bottom: 1.25rem;
    display: inline-block;
  }
  .trending-card h3 {
    font-size: 1.35rem;
    color: var(--text);
    margin-bottom: 0.75rem;
  }
  .trending-card p {
    color: var(--muted);
    font-size: 0.98rem;
    line-height: 1.7;
    margin: 0;
  }
  .stats-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 1.5rem;
    margin-top: 3rem;
  }
  @media(min-width: 900px) {
    .stats-row {
      grid-template-columns: repeat(4, 1fr);
    }
  }
  .stat-card {
    text-align: center;
    background: linear-gradient(135deg, rgba(0, 167, 255, 0.03) 0%, rgba(0, 110, 177, 0.03) 100%);
    border: 1px solid rgba(0, 167, 255, 0.1);
    border-radius: 20px;
    padding: 2rem 1.5rem;
    box-shadow: 0 10px 30px rgba(16, 34, 55, 0.02);
  }
  .stat-card h4 {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--accent-dark);
    margin: 0 0 0.5rem 0;
  }
  .stat-card p {
    color: var(--text);
    font-weight: 600;
    font-size: 0.95rem;
    margin: 0;
    text-transform: uppercase;
    letter-spacing: 0.05em;
  }
</style>

<div class="about-hero fade-up">
  <div class="container">
    <span class="section-label" style="color:var(--warning); margin-bottom:1rem; display:inline-block;">Pearl of the Indian Ocean</span>
    <h1>Sri Lanka Tourism Today</h1>
    <p>Discover a land where ancient history meets pristine coastlines, and thriving ecosystems welcome travelers from around the globe. Sri Lanka has surged back to the top of the global travel charts as the ultimate 2026 destination.</p>
  </div>
</div>

<div class="container">
  <!-- Section 1: The Modern Renaissance -->
  <section class="about-section fade-up" style="animation-delay: 0.1s;">
    <div class="section-header" style="max-width:800px; margin-bottom:3rem;">
      <span class="section-label" style="color:var(--accent-dark);">Travel Renaissance</span>
      <h2 style="font-size:2.3rem;">Current Sri Lankan Tourism Trends</h2>
      <p style="font-size:1.1rem; line-height:1.7;">
        Tourism in Sri Lanka is undergoing a phenomenal evolution, moving far beyond typical sightseeing. Today's travelers seek deep, meaningful connections with nature, local heritage, and community-driven initiatives that help preserve this ecological paradise.
      </p>
    </div>
    
    <div class="trending-grid">
      <div class="trending-card">
        <span class="trending-card-icon">🌿</span>
        <h3>Eco-Tourism & Conscious Travel</h3>
        <p>Sustainable travel is leading the charge in Sri Lanka. Visitors are exploring off-the-beaten-path hiking routes like the newly popular <strong>Pekoe Trail</strong> in the central highlands, staying in solar-powered eco-lodges, and participating in forest restoration and coral replanting programs along the southern coast.</p>
      </div>

      <div class="trending-card">
        <span class="trending-card-icon">🧘</span>
        <h3>Wellness, Yoga & Ayurvedic Healing</h3>
        <p>Sri Lanka has evolved into a global wellness sanctuary. Retreat centers in Ella, Weligama, and Hiriketiya attract travelers seeking mental rejuvenation, holistic yoga journeys, and centuries-old Ayurvedic therapies that restore balance using local, natural herbs and traditional practices.</p>
      </div>

      <div class="trending-card">
        <span class="trending-card-icon">🏄</span>
        <h3>Adventure Sports & Coastal Exploration</h3>
        <p>From the world-class surf breaks of <strong>Arugam Bay</strong> and Hiriketiya to kite-surfing in the pristine lagoon of Kalpitiya, adventure travel has seen a massive surge. Snorkeling with blacktip reef sharks in Trincomalee and diving historic shipwrecks are now highlight activities for coastal explorers.</p>
      </div>

      <div class="trending-card">
        <span class="trending-card-icon">🐘</span>
        <h3>Responsible Wildlife Safaris</h3>
        <p>National Parks like Yala, Wilpattu, and Minneriya are implementing stricter eco-guidelines to protect the majestic Sri Lankan elephants, leopards, and birdlife. Eco-tours now emphasize slow safaris, wildlife photography code-of-conducts, and conservation education.</p>
      </div>
    </div>
    
    <div class="stats-row">
      <div class="stat-card">
        <h4>2.5M+</h4>
        <p>Annual Visitors Expected</p>
      </div>
      <div class="stat-card">
        <h4>8</h4>
        <p>UNESCO World Heritage Sites</p>
      </div>
      <div class="stat-card">
        <h4>22+</h4>
        <p>Thriving National Parks</p>
      </div>
      <div class="stat-card">
        <h4>1,340km</h4>
        <p>Pristine Coastline</p>
      </div>
    </div>
  </section>

  <!-- Section 2: System Showcase -->
  <section class="about-section page-panel fade-up" style="animation-delay: 0.2s; background: rgba(0, 167, 255, 0.02); border: 1px solid rgba(0, 167, 255, 0.15);">
    <div class="section-header" style="margin-bottom:2.5rem;">
      <span class="section-label" style="color:var(--accent-dark);">Platform Overview</span>
      <h2 style="font-size:2rem; margin-bottom:0.75rem;">GlobeTrek Adventures Management System</h2>
      <p style="font-size:1.05rem;">We bridge the gap between global travelers and authentic Sri Lankan adventures. Our system provides a unified, secure platform supporting various user tiers:</p>
    </div>
    
    <div class="card-grid grid-2">
      <div class="feature-item" style="background:#fff; border-radius:18px; padding:1.5rem; box-shadow:0 8px 25px rgba(0,0,0,0.02);">
        <div class="feature-item-icon">🌍</div>
        <div class="feature-item-content">
          <h3 style="font-size:1.15rem; color:var(--text); margin-bottom:0.5rem;">For Customers</h3>
          <p style="margin:0; font-size:0.95rem; line-height:1.6; color:var(--muted);">Easily browse curated travel packages, customize your tour dates, specify guest counts, book securely, make payments, and coordinate with staff directly from your dedicated dashboard.</p>
        </div>
      </div>
      
      <div class="feature-item" style="background:#fff; border-radius:18px; padding:1.5rem; box-shadow:0 8px 25px rgba(0,0,0,0.02);">
        <div class="feature-item-icon">🧭</div>
        <div class="feature-item-content">
          <h3 style="font-size:1.15rem; color:var(--text); margin-bottom:0.5rem;">For Travel Staff</h3>
          <p style="margin:0; font-size:0.95rem; line-height:1.6; color:var(--muted);">Coordinate itinerary updates, monitor upcoming customer bookings, publish new travel routes, manage package descriptions, and provide high-fidelity traveler assistance.</p>
        </div>
      </div>
      
      <div class="feature-item" style="background:#fff; border-radius:18px; padding:1.5rem; box-shadow:0 8px 25px rgba(0,0,0,0.02);">
        <div class="feature-item-icon">📊</div>
        <div class="feature-item-content">
          <h3 style="font-size:1.15rem; color:var(--text); margin-bottom:0.5rem;">For Administrators</h3>
          <p style="margin:0; font-size:0.95rem; line-height:1.6; color:var(--muted);">Maintain bulletproof control over user roles, securely oversee staff lists, generate financial reporting, adjust catalog settings, and approve system-wide bookings.</p>
        </div>
      </div>
      
      <div class="feature-item" style="background:#fff; border-radius:18px; padding:1.5rem; box-shadow:0 8px 25px rgba(0,0,0,0.02);">
        <div class="feature-item-icon">🔒</div>
        <div class="feature-item-content">
          <h3 style="font-size:1.15rem; color:var(--text); margin-bottom:0.5rem;">Enterprise Security</h3>
          <p style="margin:0; font-size:0.95rem; line-height:1.6; color:var(--muted);">Engineered using strict separation constraints (Users, Staff, Customers), BCrypt hash protections, secure transaction managers, and responsive CSS UI transitions.</p>
        </div>
      </div>
    </div>
  </section>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>