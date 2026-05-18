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

const adminModalBackdrop = qs('#adminModalBackdrop');
const adminModalTitle = qs('#adminModalTitle');
const adminModalBody = qs('#adminModalBody');

const closeAdminModal = () => {
  if(!adminModalBackdrop) return;
  adminModalBackdrop.classList.add('hidden');
  adminModalBody.innerHTML = '';
  adminModalTitle.textContent = '';
};

if(adminModalBackdrop){
  document.addEventListener('click', event => {
    const openButton = event.target.closest('[data-modal-open]');
    if(openButton){
      event.preventDefault();
      const template = qs(openButton.dataset.modalOpen);
      const title = openButton.dataset.modalTitle || '';
      if(template && adminModalBody){
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
}

export {qs,qsa,ajax}