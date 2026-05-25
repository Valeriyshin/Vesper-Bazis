import ScrollTrigger from "gsap/ScrollTrigger";
import {setup} from "../../enter/animation.js";

const el = document.querySelector("#address");
const inner = el.querySelector("._inner");

let pos;

function setupA() {
  // if (isBig(true)) {
    return ScrollTrigger.create({
      trigger: el,
      start: `top 100%`,
      end: `bottom 10%`,
      scrub: true,
      onUpdate: self => {
        pos = (self.progress -0.5)*30;
        inner.style.transform = `translateY(${pos}vh)`;
      }
    });
  // } else {
  //   return ScrollTrigger.create({
  //     trigger: el,
  //     start: `top 100%`,
  //     end: `bottom 10%`,
  //     scrub: true,
  //     onUpdate: self => {
  //       console.log(self.progress);
  //       pos = (self.progress -0.5)*30;
  //       console.log(pos);
  //       inner.style.transform = `translateY(${pos}vh)`;
  //     }
  //   });
  // }
}

setup(()=>{
  el.removeAttribute("style");
}, setupA);
