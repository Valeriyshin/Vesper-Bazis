import gsap from "gsap";
import ScrollTrigger from "gsap/ScrollTrigger";
import {isBig, isTab, setup} from "../../enter/animation.js";

function shuffleArr(array) {
  let currentIndex = array.length;
  while (currentIndex !== 0) {
    let randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex--;
    [array[currentIndex], array[randomIndex]] = [
      array[randomIndex], array[currentIndex]];
  }
}

const set = [2, 3, 4, 5, 6];
const setMini = [2, 4, 5];

shuffleArr(set);
shuffleArr(setMini);

function clearH() {
  for (let i = 2; i <= 6; i++) {
    document.querySelectorAll(`header .sticky div:nth-child(${i})`).forEach((el) => {
      el.removeAttribute("style");
    });
  }
}

function setupH() {

  if (isBig(true)) {
    let i, j, trigger, triggers = [], start, end;
    const step = 100 / set.length;
    for (i = 0; i < set.length; i++) {
      j = set[i];
      // j=i+2
      start = (-i * step).toFixed(0);
      // end = ((i+1)*step).toFixed(0);
      end = (100 + (set.length - 1) * step - i * step).toFixed(0);
      // end = (133 + (50 - (j * step))).toFixed(2);
      // start = 0;
      // end=100;
      // console.log(start, end, i, j);
      // console.log(`top ${start}%`);
      // console.log(`bottom ${end}%`);
      trigger = ScrollTrigger.create({
        trigger: "header",
        // start: `top+=${j * 100}vh top`,
        // end: `bottom+= ${j * 100 + 300}vh bottom`,
        // start: `top 10% + ${size}%`,
        start: `top ${start}%`,
        end: `bottom ${end}%`,
        // start: `top -40%`,
        // end: `bottom 145%`,
        scrub: true,
        animation: gsap.to(`header .sticky div:nth-child(${j})`, {
          "--scroll": "0%",
          ease: "none",
          paused: true,
        }),
        // onEnter: () => {
        //   top.classList.remove("-show");
        // },
        // onEnterBack: () => {
        //   top.classList.remove("-show");
        // },
        // onLeave: () => {
        //   top.classList.add("-show");
        // },
      });
      triggers.push(trigger);
    }
    return triggers;
  } else if (isTab()) {
    let i, piece, el, k, val;
    piece = 1 / (setMini.length + 1);
    k = 1 / (piece * 2);

    return ScrollTrigger.create({
      trigger: "body",
      start: `top 0%`,
      end: `top -100%`,
      scrub: true,
      onUpdate: self => {
        // console.log(self.progress);
        for (i = 0; i < setMini.length; i++) {
          el = document.querySelector(`header .sticky div:nth-child(${setMini[i]})`);
          // console.log(el);
          val = self.progress * k - 0.5 * i;
          if (val < 0) val = 0;
          if (val > 1) val = 1;
          val = ((1-val) * 100).toFixed(2)+'%';
          el.style.setProperty('--scroll', val);
        }
      },
    });
  }
}

setup(clearH, setupH);




