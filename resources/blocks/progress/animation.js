import gsap from 'gsap'

const element=document.querySelector('#progress')
const scroll = element.dataset.max + '%';

gsap.to(element, {
  '--scroll': scroll,
  duration: 1.5,
  ease: 'power2.out',
  scrollTrigger: {
    trigger: element,
    start: 'top 80%',
    toggleActions: 'play none none none' // только один раз, без возврата
  }
})
