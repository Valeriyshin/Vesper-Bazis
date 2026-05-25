<script>
import Plan from "./Plan.vue";
import MoreFilters from "./MoreFilters.vue";
import Modal from "./Modal.vue";
import {bodyAClass} from "../modals/index.js";
import {lenis} from "../../enter/animation.js";

export default {
  name: "App",
  components: {Modal, MoreFilters, Plan},
  props: {
    plans: {
      type: Array,
      default() {
        return [];
      }
    },
    lang: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      apts: [],
      filters: {
        rooms: [],
        floors: [0, 0],
        s: [0, 0],
        prices: [0, 0],
        active: {
          rooms: [],
          floors: [0, 0],
          s: [0, 0],
          prices: [0, 0],
          sort: ["s", true]
        }
      },
      openFilters: false,
      show: 3,
      line: 3,
      result: [],
      active: null
    };
  },
  computed: {
    filteredApts() {
      return this.plans.filter(apt => {
        if (this.filters.active.rooms.length && (!this.filters.active.rooms.includes(apt.rooms))) {
          return false;
        }
        if (!this.filterRange(apt, "floor", this.filters.active.floors)) return false;
        if (!this.filterRange(apt, "area", this.filters.active.s)) return false;
        return this.filterRange(apt, "totalPrice", this.filters.active.prices);
      });
    },
    sliced() {
      if (this.show >= this.filteredApts.length) return this.filteredApts;
      return this.filteredApts.slice(0, this.show);
    },
    showMore() {
      // return this.show < this.result.length;
      return this.show < this.filteredApts.length;
    }
  },
  mounted() {
    this.setLine();
    window.removeEventListener('resize', this.setLine);
    window.addEventListener('resize', this.setLine);
    this.initFilters();
    this.updateResult();
  },
  watch: {
    "filters.active": {
      deep: true,
      handler() {
        this.updateResult();
        this.resetMore();
      }
    },
    line(newVal) {
      this.show = newVal;
    },
  },
  methods: {
    setLine() {
      if (window.innerWidth >= 1636) this.line = 3;
      else if (window.innerWidth >= 1260) this.line = 4;
      else if (window.innerWidth >= 960) this.line = 3;
      else if (window.innerWidth <= 767) this.line = 4;
      else this.line = 2;
    },
    activate(plan) {
      this.active = plan;
    },
    deactivate() {
      this.active = null;
    },
    updateResult() {
      const res = this.plans.filter(apt => {
        if (!this.filters.active.rooms.includes(apt.rooms)) return false;
        if (!this.filterRange(apt, "floor", this.filters.active.floors)) return false;
        if (!this.filterRange(apt, "area", this.filters.active.s)) return false;
        return this.filterRange(apt, "totalPrice", this.filters.active.prices);
      });
      //   .sort((a, b) => {
      //   switch (this.filters.active.sort[0]) {
      //     case "s":
      //       return this.filters.active.sort[1]
      //         ? (a.area < b.area ? -1 : 1)
      //         : (a.area > b.area ? -1 : 1);
      //     case "tp":
      //       return this.filters.active.sort[1]
      //         ? (a.totalPrice < b.totalPrice ? -1 : 1)
      //         : (a.totalPrice > b.totalPrice ? -1 : 1);
      //     case "r":
      //       return this.filters.active.sort[1]
      //         ? (a.rooms < b.rooms ? -1 : 1)
      //         : (a.rooms > b.rooms ? -1 : 1);
      //     case "mp":
      //       return this.filters.active.sort[1]
      //         ? (a.meterPrice < b.meterPrice ? -1 : 1)
      //         : (a.meterPrice > b.meterPrice ? -1 : 1);
      //     case "f":
      //       return this.filters.active.sort[1]
      //         ? (a.floor < b.floor ? -1 : 1)
      //         : (a.floor > b.floor ? -1 : 1);
      //   }
      // });
      this.result = (this.show >= res.length)
        ? res
        : res.slice(0, this.show);
    },
    filterRange(apt, aptParam, filter) {
      return ((apt[aptParam] >= filter[0]) && (apt[aptParam] <= filter[1]));

    },
    initFilters() {
      this.filters.rooms = [];
      this.plans.forEach(apt => {
        if (!this.filters.rooms.includes(apt.rooms)) {
          this.filters.rooms.push(apt.rooms);
        }
        this.checkRange("floors", apt, "floor");
        this.checkRange("s", apt, "area");
        this.checkRange("prices", apt, "totalPrice");
      });
      this.filters.rooms.sort();
      this.resetFilters();
    },
    resetFilters() {
      // this.filters.active.rooms = [...this.filters.rooms];
      this.filters.active.s = [...this.filters.s];
      this.filters.active.prices = [...this.filters.prices];
      this.filters.active.floors = [...this.filters.floors];
    },
    checkRange(filterName, apt, aptParam) {
      if ((!this.filters[filterName][0]) || (this.filters[filterName][0] > apt[aptParam])) {
        this.filters[filterName][0] = apt[aptParam];
      }
      if ((!this.filters[filterName][1]) || (this.filters[filterName][1] < apt[aptParam])) {
        this.filters[filterName][1] = apt[aptParam];
      }
    },
    toggleFilters() {
      this.openFilters = !this.openFilters;
    },
    closeFilters() {
      this.openFilters = false;
    },
    more() {
      this.show += this.line;
    },
    resetMore() {
      this.show = this.line;
    },
    openPlan(plan) {
      this.active = plan;
      document.body.classList.add(bodyAClass);
      lenis?.stop();
    },
    closePlan() {
      this.active = null;
      document.body.classList.remove(bodyAClass);
      lenis?.start();
    }
  },
};
</script>

<template>
  <h1>{{ lang.h1 }}</h1>
  <div class="_filters">
    <div class="_rooms">
      <p>{{ lang['filters.rooms'] }}</p>
      <div class="_list">
        <label v-for="room in filters.rooms">
          <input type="checkbox"
                 name="rooms"
                 :value="room"
                 v-model="filters.active.rooms"
                 @change="resetMore"
          />
          <span>{{ room }}</span>
        </label>
      </div>
    </div>
    <div :class="{'_more':true,'-active':openFilters}" @click="toggleFilters">Фильтры</div>
  </div>
  <transition name="fade">
    <more-filters
      v-if="openFilters"
      v-model:active="filters.active"
      :options="filters"
      :lang="lang"
      v-model:sort_by="filters.active.sort[0]"
      v-model:sort_asc="filters.active.sort[1]"
      @close="closeFilters"
    />
  </transition>
  <ul class="_results">
    <plan
      v-for="apt in sliced"
      :apartment="apt"
      @click="openPlan(apt)"
    />
  </ul>
  <button class="_moreP" v-if="showMore" @click="more">
    {{ lang.more }} ({{ filteredApts.length - show }})
  </button>
  <modal v-if="active" :plan="active" @close="closePlan" />
</template>
