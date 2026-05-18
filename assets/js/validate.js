// validate.js - simple form helpers
export function isEmail(v){return /^[^@\s]+@[^@\s]+\.[^@\s]+$/.test(v)}
export function requireNonEmpty(v){return String(v||"").trim().length>0}