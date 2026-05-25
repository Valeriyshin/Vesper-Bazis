function setTheme(theme) {
  if (theme === 'dark') {
    document.body.classList.add('dark')
    localStorage.setItem('theme', 'dark')
  } else {
    document.body.classList.remove('dark')
    localStorage.setItem('theme', 'light')
  }
}

function initTheme() {
  console.log("initTheme");
  const saved = localStorage.getItem('theme')
  if (saved === 'dark' || saved === 'light') {
    setTheme(saved)
  } else {
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches
    setTheme(prefersDark ? 'dark' : 'light')
  }
}

function toggleTheme() {
  const saved = localStorage.getItem('theme')
  const to = saved === 'dark' ? 'light' : 'dark';
  setTheme(to)
}

initTheme()

export { setTheme, toggleTheme }
