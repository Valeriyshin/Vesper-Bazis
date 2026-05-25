<script>
export default {
  name: "Spinner",
  props: {
    id: String,
    min: Number,
    max: Number,
    modelValue: Number
  },
  emits: ["update:modelValue"],
  computed: {
    modelProxy: {
      get() {
        return this.formatWithDots(this.modelValue);
      },
      set(newVal) {
        this.$emit("update:modelValue", this.toInt(newVal));
      }
    }
  },
  methods: {
    step(val) {
      let nextVal = this.modelValue;
      nextVal += val;
      if (nextVal < this.min) nextVal = this.min;
      if (nextVal > this.max) nextVal = this.max;
      this.modelProxy = nextVal;
    },
    formatWithDots(n) {
      return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
    },
    toInt(x) {
      const s = String(x);
      const neg = s.includes('-');       // есть ли минус где-нибудь
      const digits = s.replace(/\D/g, ''); // оставляем только цифры
      return Number((neg ? '-' : '') + (digits || '0'));
    }
  },
};
</script>

<template>
  <div class="_spinner">
    <button @click="step(-1)">-</button>
    <input type="text" :id="id" :min="min" :max="max" v-model="modelProxy" />
    <button @click="step(1)">+</button>
  </div>
</template>

<style scoped>

</style>
