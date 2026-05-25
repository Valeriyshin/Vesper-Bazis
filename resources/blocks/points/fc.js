import 'swiper/css';
import 'swiper/css/navigation';
import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';

const el = document.querySelector("#fc");
const line = el.querySelector(".line");

// noinspection JSUnusedLocalSymbols
const swiper = new Swiper('#fc .swiper', {

  modules: [ Navigation ],

  // Navigation arrows
  navigation: {
    nextEl: '#fc .swiper-button-next',
    prevEl: '#fc .swiper-button-prev',
  },

  on: {
    activeIndexChange: function (s) {
      let curP = s.activeIndex * -282;
      line.style.top= curP+'px';
      // console.log('swiper s');
      // console.log(s);
    },
  },
});
