import ScrollTrigger from "gsap/ScrollTrigger";

const el = document.querySelector("#courtyard ._yard strong");
let p;

ScrollTrigger.create({
  trigger: el,
  start: "top bottom",
  end: `bottom 80%`,
  scrub: true,
  onUpdate: self => {
    // console.log(self.progress);
    p = -100 + 100 * self.progress;
    el.style.transform = `translateX(${p}%)`;
  }
});

// gsap.to(el, {
//   scrollTrigger: {
//     trigger: el,
//     start: "top bottom",
//     end: `bottom 80%`,
//     scrub: true,
//   },
//   "transform": "translate(0%, 0%)",
//   ease: "none",
//   onUpdate: self => {
//     console.log(self);
//   }
// });
// console.log(el);
