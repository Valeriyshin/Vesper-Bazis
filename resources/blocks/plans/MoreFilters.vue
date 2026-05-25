<script>
import Spinner from "./Spinner.vue";

export default {
  name: "MoreFilters",
  components: {Spinner},
  props: {
    options: {
      type: Object,
      required: true,
    },
    active: {
      type: Object,
      required: true
    },
    sort_by: {
      type: String,
      required: true
    },
    sort_asc: Boolean,
    lang: {
      type: Object,
      required: true
    },
  },
  emits: ["update:active", "update:sort_by", "update:sort_asc", "close"],
  data() {
    return {
      openStages: ["-opening", "-open"],
      sorts: [
        {caption: "Сначала меньше м²", sort: "s", asc: true},
        {caption: "Сначала больше м²", sort: "s", asc: false},
        {caption: "Сначала меньше цена", sort: "tp", asc: true},
        {caption: "Сначала больше цена", sort: "tp", asc: false},
        {caption: "Сначала меньше комнат", sort: "r", asc: true},
        {caption: "Сначала больше комнат", sort: "r", asc: false},
        {caption: "Сначала меньше цена (м²)", sort: "mp", asc: true},
        {caption: "Сначала больше цена (м²)", sort: "mp", asc: false},
        {caption: "Сначала нижние этажи", sort: "f", asc: true},
        {caption: "Сначала верхние этажи", sort: "f", asc: false},
      ]
    };
  },
  computed: {
    sortByProxy: {
      get() {
        return this.sort_by;
      },
      set(val) {
        this.$emit("update:sort_by", val);
      }
    },
    sortAscProxy: {
      get() {
        return this.sort_asc;
      },
      set(val) {
        this.$emit("update:sort_asc", val);
      }
    },
    activeProxy: {
      get() {
        return this.active;
      },
      set(newVal) {
        console.log("set");
        this.$emit("update:active", newVal);
      }
    },
    sortCaption() {
      return this.sorts
        .find(variant => (variant.sort === this.sortByProxy && variant.asc === this.sortAscProxy))
        ?.caption;
    }
  },
  methods: {
    ddOpen() {
      this.opened = true;
      clearTimeout(this.to);
      this.$refs.dd?.classList.add(this.openStages[0]);
      this.to = setTimeout(() => {
        this.$refs.dd?.classList.add(this.openStages[1]);
        this.$refs.dd?.classList.remove(this.openStages[0]);
      }, 5);
      window.addEventListener("click", this.ddClose);
      // this.parent.addEventListener("click", this.ddClose);
    },
    ddClose() {
      this.opened = false;
      clearTimeout(this.to);
      this.$refs.dd?.classList.add(this.openStages[0]);
      this.$refs.dd?.classList.remove(this.openStages[1]);
      this.to = setTimeout(() => {
        this.$refs.dd?.classList.remove(this.openStages[1]);
        this.$refs.dd?.classList.remove(this.openStages[0]);
      }, 100);
      window.removeEventListener("click", close);
      // this.parent.removeEventListener("click", close);
    },
    ddToggle() {
      if (this.opened) this.ddClose();
      else this.ddOpen();
    },
    sort(variant) {
      this.sortByProxy = variant.sort;
      this.sortAscProxy = variant.asc;
    }
  }
};
</script>

<template>
  <div class="_filters-plus">
    <strong>{{  lang['filters.floor'] }}</strong>
    <div class="_field">
      <span><label for="floor_from">{{ lang['filters.from'] }}</label>
        <spinner
          id="floor_from"
          :min="options.floors[0]"
          :max="options.floors[1]"
          v-model="activeProxy.floors[0]"
        />
      </span>
      <span><label for="floor_to">{{ lang['filters.to'] }}</label>
        <spinner
          id="floor_from"
          :min="options.floors[0]"
          :max="options.floors[1]"
          v-model="activeProxy.floors[1]"
        />
      </span>
    </div>
    <strong>{{ lang.filters.square}}</strong>
    <div class="_field">
      <span><label for="floor_from">{{ lang['filters.from'] }}</label>
        <spinner
          id="floor_from"
          :min="options.s[0]"
          :max="options.s[1]"
          v-model="activeProxy.s[0]"
        />
      </span>
      <span><label for="floor_to">{{ lang['filters.to'] }}</label>
        <spinner
          id="floor_from"
          :min="options.s[0]"
          :max="options.s[1]"
          v-model="activeProxy.s[1]"
        />
      </span>
    </div>
    <strong>{{ lang['filters.price.m'] }}</strong>
    <div class="_field">
      <span><label for="floor_from">{{ lang['filters.from'] }}</label>
        <spinner
          id="floor_from"
          :min="options.prices[0]"
          :max="options.prices[1]"
          v-model="activeProxy.prices[0]"
        />
      </span>
      <span><label for="floor_to">{{ lang['filters.to'] }}</label>
      <spinner
        id="floor_from"
        :min="options.prices[0]"
        :max="options.prices[1]"
        v-model="activeProxy.prices[1]"
      /></span>
    </div>
    <button class="apply" @click="$emit('close')">{{ lang['filters.apply'] }}</button>
  </div>
</template>

