import {toggleTheme} from "../dark-theme.js";

const switcher = document.querySelector('#menu ._switch');

switcher.addEventListener('click', (e) => {
  e.preventDefault();
  toggleTheme();
})
