import gsap from "gsap";

document.querySelectorAll('.op-text').forEach((el) => {
  const end = el.dataset.end ?? '70%';
  gsap.to(el, {
    scrollTrigger: {
      trigger: el,
      start: "top bottom",
      end: `bottom ${end}`,
      scrub: true,
    },
    "opacity": "1",
    ease: "none",
  });
})
