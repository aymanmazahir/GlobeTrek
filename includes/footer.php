</main>

<style>
  /* Premium Animated Footer */
  footer {
    background: linear-gradient(135deg, #10243a 0%, #081422 100%);
    color: #e2f1ff;
    padding: 6rem 0 3rem;
    position: relative;
    overflow: hidden;
    border-top: 1px solid rgba(255, 255, 255, 0.05);
  }
  
  /* Wave SVG Styling */
  .footer-wave {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    overflow: hidden;
    line-height: 0;
    transform: rotate(180deg);
  }
  .footer-wave svg {
    position: relative;
    display: block;
    width: calc(130% + 1.3px);
    height: 48px;
    transform: rotateY(180deg);
  }
  .footer-wave .shape-fill {
    fill: rgba(255, 255, 255, 0.98);
  }
  
  .footer-grid-modern {
    display: grid;
    grid-template-columns: 1fr;
    gap: 3rem;
    margin-bottom: 4rem;
  }
  
  @media(min-width: 600px) {
    .footer-grid-modern {
      grid-template-columns: repeat(2, 1fr);
    }
  }
  
  @media(min-width: 1000px) {
    .footer-grid-modern {
      grid-template-columns: 2fr 1fr 1fr 1.5fr;
    }
  }
  
  .footer-col {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
    position: relative;
    z-index: 2;
  }
  
  .footer-col h4 {
    font-size: 1.2rem;
    font-weight: 800;
    color: #fff;
    margin: 0;
    padding-bottom: 0.6rem;
    position: relative;
    text-transform: uppercase;
    letter-spacing: 0.08em;
  }
  
  .footer-col h4::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 3px;
    background: #ff8b2b;
    border-radius: 999px;
  }
  
  .footer-about-text {
    font-size: 0.96rem;
    line-height: 1.7;
    color: #a8c5e6;
    margin: 0;
  }
  
  .footer-links-list {
    display: flex;
    flex-direction: column;
    gap: 0.85rem;
  }
  
  .footer-link-item {
    color: #d0e7ff;
    text-decoration: none;
    font-size: 0.96rem;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
  }
  
  .footer-link-item:hover {
    color: #ff8b2b;
    transform: translateX(6px);
  }
  
  .footer-link-item::before {
    content: '→';
    font-size: 0.85rem;
    opacity: 0;
    transform: translateX(-5px);
    transition: all 0.25s ease;
  }
  
  .footer-link-item:hover::before {
    opacity: 1;
    transform: translateX(0);
  }
  
  .footer-social-wrapper {
    display: flex;
    gap: 0.75rem;
    margin-top: 0.5rem;
  }
  
  .footer-social-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.06);
    border: 1px solid rgba(255, 255, 255, 0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    text-decoration: none;
    font-size: 1.1rem;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  }
  
  .footer-social-btn:hover {
    background: #ff8b2b;
    color: #10243a;
    transform: translateY(-5px) scale(1.1);
    box-shadow: 0 10px 25px rgba(255, 139, 43, 0.3);
  }
  
  .footer-contact-info {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 0.9rem;
    font-size: 0.96rem;
    color: #a8c5e6;
  }
  
  .footer-contact-info li {
    display: flex;
    gap: 0.75rem;
    align-items: flex-start;
  }
  
  .footer-contact-icon {
    font-size: 1.2rem;
    flex-shrink: 0;
  }
  
  .footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    padding-top: 2rem;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    align-items: center;
    justify-content: space-between;
  }
  
  @media(min-width: 768px) {
    .footer-bottom {
      flex-direction: row;
    }
  }
  
  .footer-bottom-text {
    font-size: 0.92rem;
    color: #7b9ebd;
    margin: 0;
  }
  
  .footer-live-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(33, 141, 83, 0.12);
    border: 1px solid rgba(33, 141, 83, 0.25);
    padding: 0.4rem 0.85rem;
    border-radius: 999px;
    font-size: 0.82rem;
    color: #218d53;
    font-weight: 700;
  }
  
  .footer-live-dot {
    width: 8px;
    height: 8px;
    background: #218d53;
    border-radius: 50%;
    animation: livePulse 1.5s infinite;
  }
  
  @keyframes livePulse {
    0% { transform: scale(0.9); opacity: 0.6; }
    50% { transform: scale(1.2); opacity: 1; box-shadow: 0 0 8px #218d53; }
    100% { transform: scale(0.9); opacity: 0.6; }
  }
</style>

<?php if(empty($isAdminPage)): ?>
<footer>
  <!-- Wave Divider Animation -->
  <div class="footer-wave">
    <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
      <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z" class="shape-fill"></path>
    </svg>
  </div>

  <div class="container">
    <div class="footer-grid-modern">
      <!-- About Segment -->
      <div class="footer-col">
        <h3 style="color:#fff; margin:0 0 0.5rem 0; font-size:1.6rem; font-weight:800; letter-spacing:-0.02em;">GlobeTrek</h3>
        <p class="footer-about-text">
          GlobeTrek Adventures is a premier travel portal dedicated to crafting eco-friendly, highly authentic journeys across the stunning landscapes of Sri Lanka. We connect global travelers with community initiatives, wellness escapes, and local heritage.
        </p>
        <div class="footer-social-wrapper">
          <a href="#" class="footer-social-btn" aria-label="Facebook">📘</a>
          <a href="#" class="footer-social-btn" aria-label="Instagram">📸</a>
          <a href="#" class="footer-social-btn" aria-label="YouTube">🎥</a>
          <a href="#" class="footer-social-btn" aria-label="Twitter">🐦</a>
        </div>
      </div>
      
      <!-- Top Experiences -->
      <div class="footer-col">
        <h4>Experiences</h4>
        <div class="footer-links-list">
          <a href="/globetrek/pages/packages.php" class="footer-link-item">The Pekoe Trail</a>
          <a href="/globetrek/pages/packages.php" class="footer-link-item">Yala Wildlife Safari</a>
          <a href="/globetrek/pages/packages.php" class="footer-link-item">Weligama Surf Breaks</a>
          <a href="/globetrek/pages/packages.php" class="footer-link-item">Ayurvedic Wellness</a>
        </div>
      </div>
      
      <!-- Portals -->
      <div class="footer-col">
        <h4>Navigation</h4>
        <div class="footer-links-list">
          <a href="/globetrek/pages/index.php" class="footer-link-item">Home Page</a>
          <a href="/globetrek/pages/about.php" class="footer-link-item">About Us</a>
          <a href="/globetrek/pages/packages.php" class="footer-link-item">Tours Hub</a>
          <a href="/globetrek/pages/contact.php" class="footer-link-item">Contact Desk</a>
        </div>
      </div>
      
      <!-- Support info -->
      <div class="footer-col">
        <h4>Sri Lanka Office</h4>
        <ul class="footer-contact-info">
          <li>
            <span class="footer-contact-icon">📍</span>
            <span>72 Beach Road, Negombo,<br>Western Province, Sri Lanka</span>
          </li>
          <li>
            <span class="footer-contact-icon">✉️</span>
            <span>explore@globetrek.com</span>
          </li>
          <li>
            <span class="footer-contact-icon">📞</span>
            <span>+94 31 223 8989</span>
          </li>
        </ul>
      </div>
    </div>
    
    <div class="footer-bottom">
      <p class="footer-bottom-text">
        © <?= date('Y') ?> GlobeTrek Adventures Ltd. Handcrafted for Sri Lanka Tourism.
      </p>
      
      <div class="footer-live-badge">
        <div class="footer-live-dot"></div>
        <span>LIVE SYSTEM OPERATIONAL</span>
      </div>
    </div>
  </div>
</footer>
<?php endif ?>

<div id="toast-container"></div>
<script type="module" src="/globetrek/assets/js/global.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const urlParams = new URLSearchParams(window.location.search);
        let message = null;
        let type = 'info';

        if (urlParams.has('added') || urlParams.has('registered') || urlParams.has('updated') || urlParams.has('success') || urlParams.has('sent')) {
            message = 'Action completed successfully.';
            type = 'success';
        } else if (urlParams.has('error')) {
            message = 'An error occurred. Please try again.';
            type = 'error';
        } else if (urlParams.has('expired') || urlParams.has('cancelled')) {
            message = 'Item has been cancelled or expired.';
            type = 'error';
        }

        if (message && window.showToast) {
            window.showToast(message, type);
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });
</script>
</body>
</html>