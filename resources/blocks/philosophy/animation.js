import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";
import {isBig, setup} from "../../enter/animation.js";

const el = document.querySelector("#philosophy");

function setupPh() {
  if (isBig(true)) {
    return ScrollTrigger.create({
      trigger: el,
      start: `top 25%`,
      end: `bottom 75%`,
      scrub: true,
      animation: gsap.to(el, {
        "--scroll": "0",
        ease: "none",
        duration: 1
      })
    });
  } else {
    const offset = window.innerHeight * -2 + 200 ;
    console.log(offset);
    const offset2 = offset - window.innerHeight * 0.8;

    return ScrollTrigger.create({
      trigger: "body",
      start: `top ${offset}px`,
      end: `top ${offset2}px`,
      scrub: true,
      animation: gsap.to(el, {
        "--scroll": "0",
        ease: "none",
        duration: 1
      })
    });
  }
}

setup(()=>{
  el.removeAttribute("style");
}, setupPh);
