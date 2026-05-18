</main>
<?php if(empty($isAdminPage)): ?>
<footer>
  <div class="container footer-grid">
    <div>
      <h3 style="color:#fff;margin-top:0">GlobeTrek Adventures</h3>
      <p class="footer-note">Modern travel booking for customers, staff, and administrators. Built for tourism and hospitality management.</p>
    </div>
    <div>
      <h4 style="color:#fff;margin-bottom:.9rem">Quick links</h4>
      <div class="footer-links">
        <a href="/globetrek/pages/index.php">Home</a>
        <a href="/globetrek/pages/about.php">About</a>
        <a href="/globetrek/pages/packages.php">Packages</a>
        <a href="/globetrek/pages/contact.php">Contact</a>
      </div>
    </div>
    <div>
      <h4 style="color:#fff;margin-bottom:.9rem">Contact</h4>
      <p class="footer-note">Negombo, Sri Lanka<br>support@globetrek.com<br>+94 77 123 4567</p>
    </div>
  </div>
  <div class="container" style="border-top:1px solid rgba(255,255,255,.15);padding-top:1rem;margin-top:1rem;">
    <p class="footer-note">© <?= date('Y') ?> GlobeTrek Adventures. All rights reserved.</p>
  </div>
</footer>
<?php endif ?>
<div id="toast-container"></div>
<script type="module" src="/globetrek/assets/js/global.js"></script>
<script>
    // Global Toast Handler
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

        // Custom messages if set via session could go here, 
        // but since the system primarily uses GET params, this catches them.
        if (message && window.showToast) {
            window.showToast(message, type);
            // Clean URL so it doesn't fire again on refresh
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });
</script>
</body>
</html>