const menuTriggers = document.querySelectorAll(".menu-trigger");
const className = "-menu";
const menu = document.querySelector("#menu");

menu.addEventListener("wheel", e => {
  e.stopPropagation();
}, {passive: false});

menu.addEventListener("touchmove", e => {
  e.stopPropagation();
}, {passive: false});

function close() {
  console.log("close");
  document.body.classList.remove(className);
  window.removeEventListener("click", close);
}

function open() {
  document.body.classList.add(className);
  setTimeout(() => {
    window.addEventListener("click", close);
  }, 20);
}

function swtch() {
  if (document.body.classList.contains(className)) close();
  else open();
}

menuTriggers.forEach(trigger => {
  trigger.addEventListener("click", (e) => {
    e.preventDefault();
    swtch();
  });
});

document.querySelector("#menu").addEventListener("click", e => {
  e.stopPropagation();
});
document.querySelectorAll("#menu a").forEach(e => {
  e.addEventListener("click", close);
});
