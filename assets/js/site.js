import { ajax } from './global.js'

function formatPrice(value){
  return new Intl.NumberFormat('en-US',{style:'currency',currency:'USD'}).format(Number(value)||0)
}

function createPackageCard(pkg){
  const bgImage = pkg.image_url && pkg.image_url !== 'default_package.jpg' 
    ? `/globetrek/assets/images/packages/${pkg.image_url}` 
    : '';
  
  return `<article class="package-card" style="background:var(--surface); border-radius:24px; overflow:hidden; box-shadow:0 12px 30px rgba(16,34,55,0.08); transition:transform 0.3s ease, box-shadow 0.3s ease; display:flex; flex-direction:column; border:1px solid rgba(0,167,255,0.1);">
    <div style="height:200px; background:var(--accent-soft); position:relative; overflow:hidden;">
        ${bgImage ? `<img src="${bgImage}" alt="${pkg.title}" style="width:100%; height:100%; object-fit:cover; position:absolute; inset:0; z-index:0;">` : `<div style="position:absolute; inset:0; background:linear-gradient(135deg, var(--accent) 0%, var(--accent-dark) 100%); opacity:0.1; z-index:0;"></div>`}
        <div style="position:absolute; top:1rem; left:1rem; background:rgba(255,255,255,0.9); backdrop-filter:blur(10px); padding:0.4rem 0.8rem; border-radius:999px; font-size:0.85rem; font-weight:700; color:var(--accent-dark); z-index:1;">
            📍 ${pkg.destination || 'Global'}
        </div>
        <div style="position:absolute; top:1rem; right:1rem; background:var(--success); color:white; padding:0.4rem 0.8rem; border-radius:999px; font-size:0.85rem; font-weight:700; z-index:1;">
            ${pkg.duration_days || 1} Days
        </div>
    </div>
    <div style="padding:1.5rem; flex:1; display:flex; flex-direction:column;">
        <h3 style="margin:0 0 0.5rem; font-size:1.25rem; color:var(--text);">${pkg.title}</h3>
        <p style="margin:0 0 1.5rem; color:var(--muted); font-size:0.95rem; line-height:1.6; flex:1;">${pkg.summary || 'Discover an unforgettable travel itinerary designed just for you.'}</p>
        <div style="display:flex; justify-content:space-between; align-items:center; border-top:1px solid rgba(16,34,55,0.08); padding-top:1rem;">
            <div style="display:flex; flex-direction:column;">
                <span style="font-size:0.8rem; color:var(--muted); font-weight:700; text-transform:uppercase; letter-spacing:0.05em;">From</span>
                <span style="font-size:1.3rem; font-weight:800; color:var(--accent-dark);">${formatPrice(pkg.price)}</span>
            </div>
            <a class="button" style="padding:0.75rem 1.25rem; border-radius:12px; background:var(--warning); box-shadow:0 8px 20px rgba(255,138,43,0.25);" href="/globetrek/pages/booking.php?package_id=${pkg.id}">Book Now</a>
        </div>
    </div>
  </article>`
}

export async function loadPackageCards(selector, query = ''){
  const root = document.querySelector(selector)
  if(!root) return
  root.innerHTML = '<div style="grid-column:1/-1; text-align:center; padding:3rem;"><div class="loader"></div><p style="margin-top:1rem; color:var(--muted);">Loading experiences…</p></div>'
  try{
    const url = '/globetrek/api/get_packages.php' + (query ? '?q=' + encodeURIComponent(query) : '')
    const resp = await ajax(url)
    if(!resp.success){
      root.innerHTML = '<p style="grid-column:1/-1; text-align:center; color:var(--warning);">Unable to load packages.</p>'
      return
    }
    const items = resp.data || []
    if(!items.length){
      root.innerHTML = '<p style="grid-column:1/-1; text-align:center;">No packages match your search. Try another destination!</p>'
      return
    }
    root.innerHTML = items.map(createPackageCard).join('')
  }catch(err){
    root.innerHTML = '<p style="grid-column:1/-1; text-align:center; color:var(--warning);">Unable to load packages.</p>'
  }
}

export async function loadPackageList(selector){
  return loadPackageCards(selector)
}

export async function initializePackageSearch(inputSelector, buttonSelector, outputSelector){
  const input = document.querySelector(inputSelector)
  const button = document.querySelector(buttonSelector)
  if(!input || !button) return
  const load = () => loadPackageCards(outputSelector, input.value.trim())
  button.addEventListener('click', load)
  input.addEventListener('keypress', e => { if(e.key === 'Enter'){ e.preventDefault(); load() }})
}

export async function populatePackageSelect(selectId, selectedId){
  const select = document.getElementById(selectId)
  if(!select) return
  select.innerHTML = '<option>Loading packages…</option>'
  try{
    const resp = await ajax('/globetrek/api/get_packages.php')
    if(!resp.success){
      select.innerHTML = '<option value="">Unable to load packages</option>'
      return
    }
    const packages = resp.data || []
    if(!packages.length){
      select.innerHTML = '<option value="">No packages available</option>'
      return
    }
    select.innerHTML = packages.map(pkg => {
      const selected = pkg.id === Number(selectedId) ? ' selected' : ''
      return `<option value="${pkg.id}"${selected}>${pkg.title} (${formatPrice(pkg.price)})</option>`
    }).join('')
  }catch(err){
    select.innerHTML = '<option value="">Unable to load packages</option>'
  }
}
