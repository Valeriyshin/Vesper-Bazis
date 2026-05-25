import ScrollTrigger from "gsap/ScrollTrigger";
import {setup} from "../../enter/animation.js";

const elems = document.querySelectorAll(".-float");

function getRange(el) {
  let range;
  if (window.innerWidth > 1050) {
    range = el.dataset.ranged;
  }
  if (!range) range = el.dataset.range;
  if (!range) range = 50;
  return range;
}

function setupF() {
  let triggers = [];
  elems.forEach(el => {
    triggers.push(ScrollTrigger.create({
      trigger: el,
      start: "top bottom",
      end: "bottom top",
      scrub: true,
      onUpdate: self => {
        const range = getRange(el);
        let pos = self.progress * -range + range / 2;
        el.style.transform = `translateY(${pos}px)`;
      }
    }));
  });
  return triggers;
}

setup(null, setupF);
