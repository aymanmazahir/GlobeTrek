// global.js - shared utilities
function qs(sel, root=document){return root.querySelector(sel)}
function qsa(sel, root=document){return Array.from(root.querySelectorAll(sel))}
function ajax(url, opts={}){return fetch(url, opts).then(r=>r.json())}

const header = qs('header');
if(header){
  const handleHeaderScroll = () => {
    const isScrolled = window.scrollY > 20;
    header.classList.toggle('scrolled', isScrolled);
  };
  handleHeaderScroll();
  window.addEventListener('scroll', () => requestAnimationFrame(handleHeaderScroll));
}

const closeAdminModal = () => {
  const adminModalBackdrop = qs('#adminModalBackdrop');
  const adminModalTitle = qs('#adminModalTitle');
  const adminModalBody = qs('#adminModalBody');
  if(!adminModalBackdrop) return;
  adminModalBackdrop.classList.add('hidden');
  adminModalBody.innerHTML = '';
  adminModalTitle.textContent = '';
};

// Listen globally for modal toggles so it works regardless of when script is parsed
document.addEventListener('click', event => {
  const openButton = event.target.closest('[data-modal-open]');
  const adminModalBackdrop = qs('#adminModalBackdrop');
  const adminModalTitle = qs('#adminModalTitle');
  const adminModalBody = qs('#adminModalBody');

  if(openButton){
    event.preventDefault();
    const template = qs(openButton.dataset.modalOpen);
    const title = openButton.dataset.modalTitle || '';
    if(template && adminModalBody && adminModalBackdrop){
      adminModalTitle.textContent = title;
      adminModalBody.innerHTML = template.innerHTML;
      adminModalBackdrop.classList.remove('hidden');
    }
    return;
  }

  if(event.target.closest('[data-modal-close]') || event.target === adminModalBackdrop){
    closeAdminModal();
  }
});

// Toast Notification Logic
function showToast(message, type = 'info') {
  let container = qs('#toast-container');
  if (!container) {
    container = document.createElement('div');
    container.id = 'toast-container';
    document.body.appendChild(container);
  }

  const toast = document.createElement('div');
  toast.className = `toast ${type}`;
  toast.textContent = message;

  container.appendChild(toast);

  // Trigger animation after append
  requestAnimationFrame(() => {
    toast.classList.add('show');
  });

  // Auto-remove after 4 seconds
  setTimeout(() => {
    toast.classList.remove('show');
    toast.addEventListener('transitionend', () => toast.remove());
  }, 4000);
}

// Bind to window for non-module global usage
window.showToast = showToast;

export {qs, qsa, ajax, showToast}