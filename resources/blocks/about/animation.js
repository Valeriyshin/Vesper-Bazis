import ScrollTrigger from "gsap/ScrollTrigger";
import {isBig, setup} from "../../enter/animation.js";

const el = document.querySelector("#about");
const block = el.querySelector(".num-block");
const texture = el.querySelector("._texture");
let y1, y2;

function setupA() {
  let triggers=[];
  if (isBig(true)) {
    triggers.push(ScrollTrigger.create({
      trigger: el,
      start: `top 80%`,
      end: `bottom 30%`,
      scrub: true,
      onUpdate: self => {
        y1 = self.progress * -120;
        y2 = self.progress * 120;
        block.style.transform = `translateY(${y1}px)`;
        texture.style.transform = `translateY(${y2}px)`;
      },
    }));
  } else {
    triggers.push(ScrollTrigger.create({
      trigger: el,
      start: `top 90%`,
      end: `bottom 50%`,
      scrub: true,
      onUpdate: self => {
        y1 = self.progress * -20 + 10;
        y2 = self.progress * 60;
        block.style.transform = `translateY(${y1}px)`;
        texture.style.transform = `translateY(${y2}px)`;
      },
    }));
  }
  return triggers;
}

setup(() => {
  el.removeAttribute("style");
}, setupA);
