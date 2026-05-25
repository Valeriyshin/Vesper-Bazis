import gsap from "gsap";

document.querySelectorAll('.text-right').forEach((el) => {
  const end = el.dataset.end ?? '80%';
  gsap.to(el, {
    scrollTrigger: {
      trigger: el,
      start: "top bottom",
      end: `bottom ${end}`,
      scrub: true,
    },
    "transform": "translateX(0%)",
    ease: "none",
  });
})

