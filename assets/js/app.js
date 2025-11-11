// Minimal client-side validation helpers
document.addEventListener('submit', function(e){
  const f = e.target;
  if(f.id === 'signup'){
    const p = f.querySelector('input[name=password]').value;
    if(p.length < 6){ alert('Password must be 6+ chars'); e.preventDefault(); }
  }
  if(f.id === 'regForm'){
    const email = f.querySelector('input[name=email]').value;
    if(!/^[^@]+@[^@]+\.[^@]+$/.test(email)){ alert('Enter a valid email'); e.preventDefault(); }
  }
});
