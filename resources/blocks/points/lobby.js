import 'swiper/css';
import 'swiper/css/navigation';
import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';

// noinspection JSUnusedLocalSymbols
const swiper = new Swiper('#lobby .swiper', {

  modules: [ Navigation ],

  // Navigation arrows
  navigation: {
    nextEl: '#lobby .swiper-button-next',
    prevEl: '#lobby .swiper-button-prev',
  },
});
