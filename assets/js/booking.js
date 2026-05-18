// booking.js - booking page specific logic
import { ajax } from './global.js'
import { isEmail, requireNonEmpty } from './validate.js'

export async function submitBooking(form){
  const data = Object.fromEntries(new FormData(form))
  if(!requireNonEmpty(data.name) || !isEmail(data.email)){
    alert('Please provide a valid name and email')
    return
  }
  const resp = await ajax('/globetrek/api/create_booking.php',{method:'POST',body:new FormData(form)})
  if(resp.success) {
    window.location.href = '/globetrek/pages/payment.php?booking_id=' + resp.booking_id
  } else {
    alert(resp.error || 'Failed to create booking')
  }
}