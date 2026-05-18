import { ajax } from './global.js'

function formatPrice(value){
  return new Intl.NumberFormat('en-US',{style:'currency',currency:'USD'}).format(Number(value)||0)
}

function createPackageCard(pkg){
  return `<article class="package-card">
    <div class="package-pill">${pkg.title}</div>
    <h3>${pkg.title}</h3>
    <p>${pkg.summary || 'Discover an unforgettable travel itinerary designed just for you.'}</p>
    <div class="package-meta">
      <span class="package-price">${formatPrice(pkg.price)}</span>
      <a class="button" href="/globetrek/pages/booking.php?package_id=${pkg.id}">Book now</a>
    </div>
  </article>`
}

export async function loadPackageCards(selector, query = ''){
  const root = document.querySelector(selector)
  if(!root) return
  root.innerHTML = '<p>Loading packages…</p>'
  try{
    const url = '/globetrek/api/get_packages.php' + (query ? '?q=' + encodeURIComponent(query) : '')
    const resp = await ajax(url)
    if(!resp.success){
      root.innerHTML = '<p>Unable to load packages.</p>'
      return
    }
    const items = resp.data || []
    if(!items.length){
      root.innerHTML = '<p>No packages match your search.</p>'
      return
    }
    root.innerHTML = items.map(createPackageCard).join('')
  }catch(err){
    root.innerHTML = '<p>Unable to load packages.</p>'
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
