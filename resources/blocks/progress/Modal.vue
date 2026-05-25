<script>
import {Navigation} from "swiper/modules";
import {Swiper, SwiperSlide} from "swiper/vue";

export default {
  name: "Modal",
  components: {
    Swiper,
    SwiperSlide,
  },
  props: {
    lang: {
      type: Object,
      required: true
    },
    milestones:{
      type: Array,
      required: true
    }
  },
  data() {
    console.log(this.milestones);
    return {
      milestonesOld: [
        {
          title: "ОКТЯБРЬ 2025",
          details: [
            "Ведется монтаж монолитных железобетонных каркасов домов.",
            "Ведется каменная кладка стен.",
            "Ведутся работы по устройству кровли.",
          ],
          imgs: [
            "/stages/10.25/1.jpg",
            "/stages/10.25/2.jpg",
            "/stages/10.25/3.jpg",
          ]
        },
        {
          title: "СЕНТЯБРЬ 2025",
          details: [
            "Ведется каменная кладка стен.",
            "Ведутся внутренние строительно-монтажные работы.",
          ],
          imgs: [
            "/stages/09.25/1.jpg",
            "/stages/09.25/2.jpg",
            "/stages/09.25/3.jpg",
          ]
        },
        {
          title: "АВГУСТ 2025",
          details: [
            "Ведется каменная кладка стен.",
            "Ведутся внутренние строительно-монтажные работы.",
          ],
          imgs: [
            "/stages/08.25/1.jpg",
            "/stages/08.25/2.jpg",
            "/stages/08.25/3.jpg",
            "/stages/08.25/4.jpg",
          ]
        },
      ],
      activeIndex: 0,
      openStages: ["-opening", "-open"],
      to: null,
      opened: false,
      parent: document.querySelector("#progress-modal ._body"),
      modules: [Navigation]
    };
  },
  computed: {
    activeEl() {
      return this.milestones[this.activeIndex];
    },
    activeTitle() {
      return this.activeEl.title;
    }
  },
  methods: {
    activate(i) {
      this.activeIndex = i;
    },
    ddOpen() {
      this.opened = true;
      clearTimeout(this.to);
      this.$refs.dd.classList.add(this.openStages[0]);
      this.to = setTimeout(() => {
        this.$refs.dd.classList.add(this.openStages[1]);
        this.$refs.dd.classList.remove(this.openStages[0]);
      }, 5);
      window.addEventListener("click", this.ddClose);
      this.parent.addEventListener("click", this.ddClose);
    },
    ddClose() {
      this.opened = false;
      clearTimeout(this.to);
      this.$refs.dd.classList.add(this.openStages[0]);
      this.$refs.dd.classList.remove(this.openStages[1]);
      this.to = setTimeout(() => {
        this.$refs.dd.classList.remove(this.openStages[1]);
        this.$refs.dd.classList.remove(this.openStages[0]);
      }, 100);
      window.removeEventListener("click", close);
      this.parent.removeEventListener("click", close);
    },
    ddToggle() {
      if (this.opened) this.ddClose();
      else this.ddOpen();
    }

  },
};
</script>

<template>
  <div class="_text">
    <h1>{{ lang.h1 }}</h1>
    <div class="dropdown" ref="dd" @click.prevent.stop="ddToggle">
      <div class="_value">{{ activeTitle }}</div>
      <ul>
        <li
          v-for="(milestone, i) in milestones"
          :key="i"
          @click="activate(i)"
        >
          {{ milestone.title }}
        </li>
      </ul>
    </div>
    <ul v-if="activeEl?.details?.length">
      <li v-for="li in activeEl.details">{{ li }}</li>
    </ul>
    <strong>
      {{ lang.finish }}
    </strong>
  </div>
  <swiper slides-per-view="1" :modules="modules" navigation>
    <swiper-slide v-for="(item, i) in activeEl.images" :key="i">
      <img :src="`/storage/${item}`" alt="Стадия строительства">
    </swiper-slide>
  </swiper>
</template>
