import ScrollTrigger from "gsap/ScrollTrigger";
import {isBigger, setup} from "../../enter/animation.js";

const options = [
  "-at",
  "-mu",
  "-gc",
  "-fc",
  "-em",
];
const div = 1 / (options.length - 1);
const el = document.querySelector("#location");

function setupL() {
  let i;

  if (isBigger(1050)) {
    return ScrollTrigger.create({
      trigger: el,
      start: "top 100px",
      end: "bottom bottom",
      scrub: true,
      onUpdate: self => {
        i = Math.floor(self.progress / div);
        el.setAttribute("class", options[i]);
      }
    });
  } else {
    return ScrollTrigger.create({
      trigger: el,
      start: "top 100px",
      end: "bottom bottom",
      scrub: true,
      onUpdate: self => {
        i = Math.floor(self.progress / div);
        el.setAttribute("class", options[i]);
      }
    });
  }
}

document.querySelectorAll("#location li").forEach(li => {
  li.addEventListener("mouseover", () => {
    el.setAttribute("class", li.getAttribute("class"));
  });
});

setup(null, setupL);
