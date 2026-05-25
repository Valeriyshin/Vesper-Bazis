import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";
import {isBigger, setup} from "../../enter/animation.js";

let registry = [];

function setupVF() {
  let triggers = [];
  registry.length = 0;
  if(isBigger(1050)) {
    document
      .querySelectorAll(".vertical-flow")
      .forEach(el => {
        const parent = el.parentElement;
        const dy = parent.offsetHeight - el.offsetHeight;

        gsap.set(el, {y: dy});

        triggers.push(ScrollTrigger.create({
          trigger: parent,
          start: "top bottom",
          end: "bottom 40%",
          scrub: true,
          onUpdate: self => {
            const progress = self.progress;
            // Смещение от начального dy к 0
            const y = dy * (1 - progress) * -1;
            gsap.set(el, {y});
          }
        }));
        registry.push(el);
      });
    return triggers;
  }
  return null;
}

function clear() {
  registry.forEach(el => {
    el.removeAttribute("style");
  });
}

setup(clear, setupVF);
