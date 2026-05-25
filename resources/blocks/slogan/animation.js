import gsap from "gsap";
import {isBig, setup} from "../../enter/animation.js";
import ScrollTrigger from "gsap/ScrollTrigger";
// import {isBig} from "../../enter/animation.js";

const el = document.querySelector("#slogan");

// gsap.to("#slogan", {
//   scrollTrigger: {
//     trigger: "#slogan",
//     start: "top 80%",
//     end: "bottom 95%",
//     scrub: true,
//   },
//   "--scroll": "0",
//   ease: "none",
// });

function setupS(){
  if(isBig(true)){
    ScrollTrigger.create({
      trigger: el,
      start: "top 80%",
      end: "bottom 125%",
      scrub: true,
      animation: gsap.to(el, {
        "--scroll": "0",
        ease: "none",
        duration: 1 // обязательно!
      })
    });
  }else{
    ScrollTrigger.create({
      trigger: el,
      start: "top 100%",
      end: "bottom 100%",
      scrub: true,
      animation: gsap.to(el, {
        "--scroll": "0",
        ease: "none",
        duration: 1 // обязательно!
      })
    });
  }
}


//
// let triggers = [], trigger;
//
// function setup() {
//   triggers.forEach(trigger => trigger.kill());
//   triggers = [];
//
//   if (isBig(true)) {
//     console.log("big");
//     ScrollTrigger.create({
//       trigger: '#philosophy',
//       start: 'top 25%',
//       end: 'bottom 75%',
//       scrub: true,
//       onUpdate: self => {
//         console.log(self.progress);
//         const val = 1 - self.progress
//         document.querySelector('#philosophy').style.setProperty('--scroll', `${val.toFixed(4)}`)
//       }
//     })
//   }
//   if (trigger ?? false) triggers.push(trigger);
// }
//
// window.addEventListener("resize", () => {
//   ScrollTrigger.refresh();
//   setup();
// });
//
// setup()

setup(()=>{
  el.removeAttribute("style");
}, setupS);
