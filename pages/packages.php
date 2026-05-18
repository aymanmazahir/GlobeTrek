<?php
$_title = 'Packages - GlobeTrek Adventures';
include __DIR__ . '/../includes/header.php';
?>
<section class="page-panel fade-up">
  <div class="section-header">
    <span class="section-label">Explore tours</span>
    <h2>All travel packages</h2>
    <p>Use the search tool to filter tours by destination, experience type, or price range.</p>
  </div>
  <div class="hero-search" style="margin-bottom:1.5rem;">
    <input id="package-search" placeholder="Search packages or keywords">
    <button id="package-search-button" type="button">Search</button>
  </div>
  <div id="packages-list" class="packages-grid"></div>
</section>
<script type="module">
import { loadPackageList, initializePackageSearch } from '/globetrek/assets/js/site.js'
loadPackageList('#packages-list')
initializePackageSearch('#package-search', '#package-search-button', '#packages-list')
</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>