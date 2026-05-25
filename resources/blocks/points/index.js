const classToggle='-open'

document.querySelectorAll('._cut').forEach((el) => {
  el.addEventListener('click', (e) => {
    e.preventDefault();
    if(el.classList.contains('-disabled'))return;
    el.classList.toggle(classToggle);
  })
})
